<?php

namespace App\Http\Controllers;

use App\Mail\NwcReportMail;
use App\Services\Reports\NwcReportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Twilio\Rest\Client as TwilioClient;

class NwcReportController extends Controller
{
    public function __construct(private readonly NwcReportService $reportService)
    {
    }

    public function index(Request $request)
    {
        [$start, $end] = $this->reportService->resolveDateRange(
            $request->input('start_date'),
            $request->input('end_date')
        );

        $filters = [
            'start_date' => $start->toDateString(),
            'end_date' => $end->toDateString(),
        ];

        $rows = $this->reportService->getReportData($filters);
        $summary = $this->reportService->summarize($rows, $start, $end);

        return view('adminLte.pages.reports.nwc.index', [
            'reportRows' => $rows,
            'summary' => $summary,
            'filters' => $filters,
        ]);
    }

    public function export(Request $request)
    {
        [$start, $end] = $this->reportService->resolveDateRange(
            $request->input('start_date'),
            $request->input('end_date')
        );

        $filters = [
            'start_date' => $start->toDateString(),
            'end_date' => $end->toDateString(),
        ];

        $rows = $this->reportService->getReportData($filters);

        if ($rows->isEmpty()) {
            return redirect()
                ->back()
                ->with('error', 'No transactions found for the selected period.');
        }

        $summary = $this->reportService->summarize($rows, $start, $end);
        $file = $this->reportService->generateExcel($rows, $summary);
        $downloadPath = Storage::disk($file['disk'])->path($file['path']);

        return response()->download($downloadPath, $file['filename'])->deleteFileAfterSend(true);
    }

    public function shareEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);

        [$start, $end] = $this->reportService->resolveDateRange(
            $request->input('start_date'),
            $request->input('end_date')
        );

        $filters = [
            'start_date' => $start->toDateString(),
            'end_date' => $end->toDateString(),
        ];

        $rows = $this->reportService->getReportData($filters);

        if ($rows->isEmpty()) {
            return redirect()
                ->back()
                ->with('error', 'No transactions found for the selected period. Nothing to share.');
        }

        $summary = $this->reportService->summarize($rows, $start, $end);
        $file = $this->reportService->generateExcel($rows, $summary);

        try {
            Mail::to($request->input('email'))
                ->send(new NwcReportMail($summary, $file));
        } catch (\Throwable $th) {
            Log::error('Failed to email NWC report', ['exception' => $th]);
            return redirect()
                ->back()
                ->with('error', 'Failed to send report via email: ' . $th->getMessage());
        } finally {
            Storage::disk($file['disk'])->delete($file['path']);
        }

        return redirect()
            ->back()
            ->with('status', 'Report emailed successfully.');
    }

    public function shareWhatsapp(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);

        [$start, $end] = $this->reportService->resolveDateRange(
            $request->input('start_date'),
            $request->input('end_date')
        );

        $filters = [
            'start_date' => $start->toDateString(),
            'end_date' => $end->toDateString(),
        ];

        $rows = $this->reportService->getReportData($filters);

        if ($rows->isEmpty()) {
            return redirect()
                ->back()
                ->with('error', 'No transactions found for the selected period. Nothing to share.');
        }

        $summary = $this->reportService->summarize($rows, $start, $end);

        $sid = config('services.twilio.sid', env('TWILIO_SID'));
        $token = config('services.twilio.token', env('TWILIO_AUTH_TOKEN'));
        $from = config('services.twilio.whatsapp_from', env('TWILIO_WHATSAPP_FROM'));

        if (!$sid || !$token || !$from) {
            return redirect()
                ->back()
                ->with('error', 'Twilio credentials are not configured. Unable to share via WhatsApp.');
        }

        $phoneString = Str::of($request->input('phone'))
            ->replace(' ', '')
            ->replace('-', '')
            ->replace('(', '')
            ->replace(')', '');

        if ($phoneString->startsWith('00')) {
            $phoneString = Str::of('+' . $phoneString->substr(2));
        }

        $normalizedPhone = $phoneString->value();

        if (!Str::startsWith($normalizedPhone, '+')) {
            $normalizedPhone = '+' . ltrim($normalizedPhone, '+');
        }

        $file = $this->reportService->generateExcel($rows, $summary, 'public');
        $publicUrl = Storage::disk('public')->url($file['path']);

        try {
            $client = new TwilioClient($sid, $token);
            $fromAddress = Str::of($from)->startsWith('whatsapp:')
                ? $from
                : 'whatsapp:' . ltrim($from, '+');

            $client->messages->create('whatsapp:' . $normalizedPhone, [
                'from' => $fromAddress,
                'body' => sprintf(
                    'NWC Report for %s to %s',
                    $start->toDateString(),
                    $end->toDateString()
                ),
                'mediaUrl' => [$publicUrl],
            ]);
            register_shutdown_function(static function () use ($file) {
                Storage::disk('public')->delete($file['path']);
            });
        } catch (\Throwable $th) {
            Log::error('Failed to share NWC report via WhatsApp', ['exception' => $th]);
            Storage::disk('public')->delete($file['path']);

            return redirect()
                ->back()
                ->with('error', 'Failed to send report via WhatsApp: ' . $th->getMessage());
        }

        return redirect()
            ->back()
            ->with('status', 'Report shared via WhatsApp successfully.');
    }
}
