<?php

namespace App\Services\Reports;

use App\Models\Transxn;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class NwcReportService
{
    /**
     * Resolve a start and end date for the report, defaulting to the current day.
     */
    public function resolveDateRange(?string $startDate, ?string $endDate): array
    {
        $start = $startDate ? Carbon::parse($startDate)->startOfDay() : now()->startOfDay();
        $end = $endDate ? Carbon::parse($endDate)->endOfDay() : ($startDate ? Carbon::parse($startDate)->endOfDay() : now()->endOfDay());

        if ($start->greaterThan($end)) {
            [$start, $end] = [$end->copy()->startOfDay(), $start->copy()->endOfDay()];
        }

        return [$start, $end];
    }

    /**
     * Fetch report rows for the given filters.
     */
    public function getReportData(array $filters = []): Collection
    {
        [$start, $end] = $this->resolveDateRange($filters['start_date'] ?? null, $filters['end_date'] ?? null);

        $transactions = Transxn::query()
            ->with([
                'shipment.client',
                'shipment.consignment',
                'shipment.nwcReceipt',
                'nwcReceipt',
            ])
            ->whereBetween('created_at', [$start, $end])
            ->orderByDesc('created_at')
            ->get();

        return $transactions->map(function (Transxn $transaction) {
            $shipment = $transaction->shipment;
            $receipt = $transaction->nwcReceipt ?: optional($shipment)->nwcReceipt;

            $consignment = optional($shipment)->consignment;
            $client = optional($shipment)->client;

            $billUsd = $receipt?->bill_usd;
            $billKwacha = $receipt?->bill_kwacha;

            if ($billUsd === null && $shipment) {
                $billUsd = (float) $shipment->amount_to_be_collected;
            }

            if ($billKwacha === null && $billUsd !== null && function_exists('convert_currency')) {
                try {
                    $billKwacha = convert_currency($billUsd, 'usd', 'zmw');
                } catch (\Throwable $th) {
                    $billKwacha = null;
                }
            }

            $rate = $receipt?->rate;
            if (($rate === null || $rate == 0.0) && $billUsd && $billUsd != 0 && $billKwacha) {
                $rate = round($billKwacha / $billUsd, 6);
            }

            $method = $this->normalizeMethod($receipt?->method_of_payment);
            $methodLabel = $this->formatMethodLabel($receipt?->method_of_payment);

            $airtel = $method === 'airtel' ? (float) ($billKwacha ?? 0) : 0.0;
            $mtn = $method === 'mtn' ? (float) ($billKwacha ?? 0) : 0.0;
            $cashPayments = $method === 'cash' ? (float) ($billKwacha ?? 0) : 0.0;

            return [
                'date' => $transaction->created_at ?? now(),
                'receipt_number' => $transaction->receipt_number,
                'hawb_number' => optional($shipment)->code,
                'consignee_name' => $consignment?->consignee ?? $consignment?->name,
                'client_name' => $client?->name,
                'rate' => $rate !== null ? (float) $rate : null,
                'bill_usd' => $billUsd !== null ? (float) $billUsd : null,
                'bill_kwacha' => $billKwacha !== null ? (float) $billKwacha : null,
                'method_of_payment' => $methodLabel,
                'airtel' => $airtel,
                'mtn' => $mtn,
                'cash_payments' => $cashPayments,
                'shipment' => $shipment,
                'consignment' => $consignment,
                'client' => $client,
                'receipt' => $receipt,
            ];
        });
    }

    /**
     * Summarise the report rows.
     */
    public function summarize(Collection $rows, Carbon $start, Carbon $end): array
    {
        $totals = [
            'total_rows' => $rows->count(),
            'total_rate' => $rows->filter(fn ($row) => $row['rate'] !== null)->sum('rate'),
            'total_bill_usd' => $rows->filter(fn ($row) => $row['bill_usd'] !== null)->sum('bill_usd'),
            'total_bill_kwacha' => $rows->filter(fn ($row) => $row['bill_kwacha'] !== null)->sum('bill_kwacha'),
            'total_airtel' => $rows->sum('airtel'),
            'total_mtn' => $rows->sum('mtn'),
            'total_cash_payments' => $rows->sum('cash_payments'),
        ];

        $totals['average_rate'] = $totals['total_rows'] > 0
            ? round($rows->filter(fn ($row) => $row['rate'] !== null)->avg('rate'), 4)
            : 0;

        return array_merge($totals, [
            'period_start' => $start,
            'period_end' => $end,
        ]);
    }

    /**
     * Generate an Excel file for the supplied rows and return storage details.
     */
    public function generateExcel(Collection $rows, array $summary, string $disk = 'local', ?string $filename = null): array
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headers = [
            'A1' => 'Date',
            'B1' => 'HAWB No',
            'C1' => 'Receipt #',
            'D1' => 'Consignee Name',
            'E1' => 'Client Name',
            'F1' => 'Rate',
            'G1' => 'Bill (USD)',
            'H1' => 'Bill (ZMW)',
            'I1' => 'Method of Payment',
            'J1' => 'Airtel',
            'K1' => 'MTN',
            'L1' => 'Cash Payments',
        ];

        foreach ($headers as $cell => $value) {
            $sheet->setCellValue($cell, $value);
        }

        $rowPointer = 2;
        foreach ($rows as $row) {
            $sheet->setCellValue("A{$rowPointer}", optional($row['date'])->format('Y-m-d'));
            $sheet->setCellValue("B{$rowPointer}", $row['hawb_number']);
            $sheet->setCellValue("C{$rowPointer}", $row['receipt_number']);
            $sheet->setCellValue("D{$rowPointer}", $row['consignee_name']);
            $sheet->setCellValue("E{$rowPointer}", $row['client_name']);
            $sheet->setCellValue("F{$rowPointer}", $row['rate']);
            $sheet->setCellValue("G{$rowPointer}", $row['bill_usd']);
            $sheet->setCellValue("H{$rowPointer}", $row['bill_kwacha']);
            $sheet->setCellValue("I{$rowPointer}", $row['method_of_payment']);
            $sheet->setCellValue("J{$rowPointer}", $row['airtel']);
            $sheet->setCellValue("K{$rowPointer}", $row['mtn']);
            $sheet->setCellValue("L{$rowPointer}", $row['cash_payments']);
            $rowPointer++;
        }

        $summaryStartRow = $rowPointer + 1;
        $sheet->setCellValue("E{$summaryStartRow}", 'Totals');
        $sheet->setCellValue("F{$summaryStartRow}", $summary['total_rate']);
        $sheet->setCellValue("G{$summaryStartRow}", $summary['total_bill_usd']);
        $sheet->setCellValue("H{$summaryStartRow}", $summary['total_bill_kwacha']);
        $sheet->setCellValue("J{$summaryStartRow}", $summary['total_airtel']);
        $sheet->setCellValue("K{$summaryStartRow}", $summary['total_mtn']);
        $sheet->setCellValue("L{$summaryStartRow}", $summary['total_cash_payments']);

        $sheet->setCellValue("E" . ($summaryStartRow + 1), 'Average Rate');
        $sheet->setCellValue("F" . ($summaryStartRow + 1), $summary['average_rate']);

        $sheet->setAutoFilter($sheet->calculateWorksheetDimension());
        foreach (range('A', 'L') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $filename = $filename ?: 'nwc-report-' . now()->format('Ymd_His') . '-' . Str::random(4) . '.xlsx';
        $relativePath = 'reports/' . $filename;

        Storage::disk($disk)->makeDirectory('reports');
        $writer = new Xlsx($spreadsheet);
        $writer->save(Storage::disk($disk)->path($relativePath));

        return [
            'disk' => $disk,
            'path' => $relativePath,
            'filename' => $filename,
        ];
    }

    protected function normalizeMethod(?string $method): ?string
    {
        if (!$method) {
            return null;
        }

        $slug = Str::of($method)->lower()->snake();

        if ($slug->contains('airtel')) {
            return 'airtel';
        }
        if ($slug->contains('mtn')) {
            return 'mtn';
        }
        if ($slug->contains('cash')) {
            return 'cash';
        }

        return (string) $slug;
    }

    protected function formatMethodLabel(?string $method): string
    {
        if (!$method) {
            return 'N/A';
        }

        return Str::of($method)
            ->replace('_', ' ')
            ->replace('-', ' ')
            ->title();
    }
}
