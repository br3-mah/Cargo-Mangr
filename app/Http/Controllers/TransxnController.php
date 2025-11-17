<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transxn;
use Carbon\Carbon;

class TransxnController extends Controller
{
    
    public function __construct()
    {
        // check on permissions
        $this->middleware('can:access-finance-transactions')->only('index');
    }

    public function index()
    {
        $transactions = Transxn::with('shipment.client')
            ->orderBy('created_at', 'desc')
            ->get();
            
        $completedTransactions = $transactions->filter(fn($txn) => $txn->isCompleted());

        $sumCompletedBetween = fn (Carbon $start, Carbon $end) =>
            $completedTransactions->whereBetween('created_at', [$start, $end])->sum('total');

        $totals = [
            'todate' => $completedTransactions->sum('total'),
            'today' => $sumCompletedBetween(Carbon::today(), Carbon::now()),
            'yesterday' => $sumCompletedBetween(Carbon::yesterday(), Carbon::today()),
            'this_week' => $sumCompletedBetween(Carbon::now()->startOfWeek(), Carbon::now()),
            'this_month' => $sumCompletedBetween(Carbon::now()->startOfMonth(), Carbon::now()),
        ];
        
        $refundedTransactions = $transactions->filter(function($transaction) {
            return $transaction->isRefunded();
        });
        
        $refundedTotals = [
            'todate' => $refundedTransactions->sum('total'),
            'today' => $refundedTransactions->whereBetween('created_at', [Carbon::today(), Carbon::now()])->sum('total'),
            'yesterday' => $refundedTransactions->whereBetween('created_at', [Carbon::yesterday(), Carbon::today()])->sum('total'),
            'this_week' => $refundedTransactions->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()])->sum('total'),
            'this_month' => $refundedTransactions->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()])->sum('total'),
        ];
        
        $adminTheme = env('ADMIN_THEME', 'adminLte');
        return view('cargo::' . $adminTheme . '.pages.transxns.index', compact('transactions','totals', 'refundedTotals'));
    }

}
