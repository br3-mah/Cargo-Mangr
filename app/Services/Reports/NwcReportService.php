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
                'shipment.nwcReceipt.auditLogs.user',
                'shipment.nwcReceipt.user',
                'nwcReceipt.auditLogs.user',
                'nwcReceipt.user',
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

            $cashierName = $this->resolveCashierName($receipt);

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
                'method_slug' => $method,
                'airtel' => $airtel,
                'mtn' => $mtn,
                'cash_payments' => $cashPayments,
                'cashier_name' => $cashierName,
                'shipment' => $shipment,
                'consignment' => $consignment,
                'client' => $client,
                'receipt' => $receipt,
            ];
        });
    }

    /**
     * Apply additional filters to an existing set of report rows.
     */
    public function applyFilters(Collection $rows, array $filters = []): Collection
    {
        $filtered = $rows;

        if (!empty($filters['cashier'])) {
            $cashier = Str::lower($filters['cashier']);
            $filtered = $filtered->filter(function (array $row) use ($cashier) {
                if (empty($row['cashier_name'])) {
                    return false;
                }

                return Str::contains(Str::lower($row['cashier_name']), $cashier);
            });
        }

        if (!empty($filters['method'])) {
            $method = Str::lower($filters['method']);
            $filtered = $filtered->filter(function (array $row) use ($method) {
                if (empty($row['method_slug'])) {
                    return false;
                }

                return Str::lower($row['method_slug']) === $method;
            });
        }

        if (!empty($filters['hawb_number'])) {
            $hawb = Str::lower($filters['hawb_number']);
            $filtered = $filtered->filter(function (array $row) use ($hawb) {
                if (!$row['hawb_number']) {
                    return false;
                }

                return Str::contains(Str::lower($row['hawb_number']), $hawb);
            });
        }

        if (!empty($filters['date'])) {
            try {
                $targetDate = Carbon::parse($filters['date'])->toDateString();
                $filtered = $filtered->filter(function (array $row) use ($targetDate) {
                    if (empty($row['date'])) {
                        return false;
                    }

                    return optional($row['date'])->toDateString() === $targetDate;
                });
            } catch (\Throwable $th) {
                // Ignore invalid dates silently.
            }
        }

        $order = $filters['bill_order'] ?? null;
        if (is_string($order) && Str::contains($order, '_')) {
            [$field, $direction] = array_pad(explode('_', $order, 2), 2, 'asc');
            $direction = Str::lower($direction) === 'desc' ? 'desc' : 'asc';

            if (in_array($field, ['bill_usd', 'bill_kwacha'], true)) {
                $filtered = $filtered->sortBy(function (array $row) use ($field, $direction) {
                    $value = $row[$field];

                    if ($value === null) {
                        return $direction === 'asc' ? INF : -INF;
                    }

                    return (float) $value;
                }, SORT_REGULAR, $direction === 'desc');
            }
        }

        return $filtered->values();
    }

    /**
     * Build filter option lists from the provided rows.
     */
    public function availableFilterOptions(Collection $rows): array
    {
        $methods = $rows
            ->filter(fn (array $row) => !empty($row['method_slug']) && !empty($row['method_of_payment']))
            ->map(fn (array $row) => [
                'value' => Str::lower($row['method_slug']),
                'label' => $row['method_of_payment'],
            ])
            ->unique('value')
            ->sortBy('label')
            ->values();

        $cashiers = $rows
            ->pluck('cashier_name')
            ->filter()
            ->unique()
            ->sort()
            ->values();

        $hawbNumbers = $rows
            ->pluck('hawb_number')
            ->filter()
            ->unique()
            ->sort()
            ->values();

        return [
            'methods' => $methods->all(),
            'cashiers' => $cashiers->all(),
            'hawb_numbers' => $hawbNumbers->all(),
        ];
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
            'J1' => 'Cashier',
            'K1' => 'Airtel',
            'L1' => 'MTN',
            'M1' => 'Cash Payments',
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
            $sheet->setCellValue("J{$rowPointer}", $row['cashier_name'] ?? 'N/A');
            $sheet->setCellValue("K{$rowPointer}", $row['airtel']);
            $sheet->setCellValue("L{$rowPointer}", $row['mtn']);
            $sheet->setCellValue("M{$rowPointer}", $row['cash_payments']);
            $rowPointer++;
        }

        $summaryStartRow = $rowPointer + 1;
        $sheet->setCellValue("E{$summaryStartRow}", 'Totals');
        $sheet->setCellValue("F{$summaryStartRow}", $summary['total_rate']);
        $sheet->setCellValue("G{$summaryStartRow}", $summary['total_bill_usd']);
        $sheet->setCellValue("H{$summaryStartRow}", $summary['total_bill_kwacha']);
        $sheet->setCellValue("K{$summaryStartRow}", $summary['total_airtel']);
        $sheet->setCellValue("L{$summaryStartRow}", $summary['total_mtn']);
        $sheet->setCellValue("M{$summaryStartRow}", $summary['total_cash_payments']);

        $sheet->setCellValue("E" . ($summaryStartRow + 1), 'Average Rate');
        $sheet->setCellValue("F" . ($summaryStartRow + 1), $summary['average_rate']);

        $sheet->setAutoFilter($sheet->calculateWorksheetDimension());
        foreach (range('A', 'M') as $columnID) {
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

    protected function resolveCashierName(?\App\Models\NwcReceipt $receipt): ?string
    {
        if (!$receipt) {
            return null;
        }

        if ($receipt->cashier_name) {
            return $receipt->cashier_name;
        }

        if ($receipt->relationLoaded('user')) {
            $user = $receipt->getRelation('user');
        } else {
            $user = $receipt->user()->first();
        }

        if ($user && $user->name) {
            return $user->name;
        }

        $auditLogs = $receipt->relationLoaded('auditLogs')
            ? $receipt->auditLogs
            : $receipt->auditLogs()->with('user')->get();

        if ($auditLogs->isEmpty()) {
            return null;
        }

        $createdLog = $auditLogs->firstWhere('event', 'created');
        if (!$createdLog) {
            $createdLog = $auditLogs->sortBy('created_at')->first();
        }

        return $createdLog?->user?->name;
    }
}
