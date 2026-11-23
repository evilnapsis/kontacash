<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Movement;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $accounts = Account::withBalance()->orderBy('name')->get();
        $totalBalance = $accounts->sum('balance');

        $monthIncome = (float) Movement::where('kind', Movement::KIND_INCOME)
            ->whereYear('movement_date', now()->year)
            ->whereMonth('movement_date', now()->month)
            ->sum('amount');

        $monthExpense = (float) Movement::where('kind', Movement::KIND_EXPENSE)
            ->whereYear('movement_date', now()->year)
            ->whereMonth('movement_date', now()->month)
            ->sum('amount');

        $recentMovements = Movement::with(['category', 'account', 'paymentMethod', 'person'])
            ->latest('movement_date')
            ->latest('id')
            ->take(10)
            ->get();

        return view('dashboard', compact(
            'accounts',
            'totalBalance',
            'monthIncome',
            'monthExpense',
            'recentMovements'
        ));
    }
}
