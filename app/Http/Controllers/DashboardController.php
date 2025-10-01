<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Models\Expense;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the dashboard with financial overview
     */
    public function index()
    {
        $user = Auth::user();
        
        // Current month data
        $currentMonth = now();
        $currentYear = $currentMonth->year;
        $currentMonthNumber = $currentMonth->month;
        
        // Total Income and Expenses (All Time)
        $totalIncome = Income::where('user_id', $user->id)->sum('amount');
        $totalExpenses = Expense::where('user_id', $user->id)->sum('amount');
        $netBalance = $totalIncome - $totalExpenses;
        
        // Current Month Data
        $monthlyIncome = Income::where('user_id', $user->id)
            ->whereYear('date', $currentYear)
            ->whereMonth('date', $currentMonthNumber)
            ->sum('amount');
            
        $monthlyExpenses = Expense::where('user_id', $user->id)
            ->whereYear('date', $currentYear)
            ->whereMonth('date', $currentMonthNumber)
            ->sum('amount');
            
        $monthlyBalance = $monthlyIncome - $monthlyExpenses;
        
        // Recent Transactions (Latest 5 of each)
        $recentIncomes = Income::where('user_id', $user->id)
            ->orderBy('date', 'desc')
            ->limit(5)
            ->get();
            
        $recentExpenses = Expense::with('category')
            ->where('user_id', $user->id)
            ->orderBy('date', 'desc')
            ->limit(5)
            ->get();
        
        // Expenses by Category (Current Month)
        $expensesByCategory = Expense::select('category_id', DB::raw('SUM(amount) as total'))
            ->with('category')
            ->where('user_id', $user->id)
            ->whereYear('date', $currentYear)
            ->whereMonth('date', $currentMonthNumber)
            ->groupBy('category_id')
            ->orderBy('total', 'desc')
            ->get();
        
        // Monthly Spending Trend (Last 6 months)
        $monthlyTrend = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthExpenses = Expense::where('user_id', $user->id)
                ->whereYear('date', $date->year)
                ->whereMonth('date', $date->month)
                ->sum('amount');
            
            $monthlyTrend[] = [
                'month' => $date->format('M Y'),
                'amount' => $monthExpenses
            ];
        }
        
        // Top Categories (All Time)
        $topCategories = Expense::select('category_id', DB::raw('SUM(amount) as total'), DB::raw('COUNT(*) as count'))
            ->with('category')
            ->where('user_id', $user->id)
            ->groupBy('category_id')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();
        
        // Budget Analysis (Simple comparison with last month)
        $lastMonth = now()->subMonth();
        $lastMonthExpenses = Expense::where('user_id', $user->id)
            ->whereYear('date', $lastMonth->year)
            ->whereMonth('date', $lastMonth->month)
            ->sum('amount');
            
        $expenseChange = $lastMonthExpenses > 0 
            ? (($monthlyExpenses - $lastMonthExpenses) / $lastMonthExpenses) * 100 
            : 0;
        
        // Savings Rate
        $savingsRate = $monthlyIncome > 0 
            ? (($monthlyIncome - $monthlyExpenses) / $monthlyIncome) * 100 
            : 0;
        
        return view('dashboard', compact(
            'totalIncome',
            'totalExpenses', 
            'netBalance',
            'monthlyIncome',
            'monthlyExpenses',
            'monthlyBalance',
            'recentIncomes',
            'recentExpenses',
            'expensesByCategory',
            'monthlyTrend',
            'topCategories',
            'expenseChange',
            'savingsRate',
            'currentMonth'
        ));
    }
}