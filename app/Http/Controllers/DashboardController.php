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
        
        
        $currentMonth = now();
        $currentYear = $currentMonth->year;
        $currentMonthNumber = $currentMonth->month;
        
    
        $totalIncome = Income::where('user_id', $user->id)->sum('amount');
        $totalExpenses = Expense::where('user_id', $user->id)->sum('amount');
        $netBalance = $totalIncome - $totalExpenses;
        

        $monthlyIncome = Income::where('user_id', $user->id)
            ->whereYear('date', $currentYear)
            ->whereMonth('date', $currentMonthNumber)
            ->sum('amount');
            
        $monthlyExpenses = Expense::where('user_id', $user->id)
            ->whereYear('date', $currentYear)
            ->whereMonth('date', $currentMonthNumber)
            ->sum('amount');
            
        $monthlyBalance = $monthlyIncome - $monthlyExpenses;
        
    
        $recentIncomes = Income::where('user_id', $user->id)
            ->orderBy('date', 'desc')
            ->limit(5)
            ->get();
            
        $recentExpenses = Expense::with('category')
            ->where('user_id', $user->id)
            ->orderBy('date', 'desc')
            ->limit(5)
            ->get();
        
        
        $expensesByCategory = Expense::select('category_id', DB::raw('SUM(amount) as total'))
            ->with('category')
            ->where('user_id', $user->id)
            ->whereYear('date', $currentYear)
            ->whereMonth('date', $currentMonthNumber)
            ->groupBy('category_id')
            ->orderBy('total', 'desc')
            ->get();
        
    
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
        

        $topCategories = Expense::select('category_id', DB::raw('SUM(amount) as total'), DB::raw('COUNT(*) as count'))
            ->with('category')
            ->where('user_id', $user->id)
            ->groupBy('category_id')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();
        
        $lastMonth = now()->subMonth();
        $lastMonthExpenses = Expense::where('user_id', $user->id)
            ->whereYear('date', $lastMonth->year)
            ->whereMonth('date', $lastMonth->month)
            ->sum('amount');
            
        $expenseChange = $lastMonthExpenses > 0 
            ? (($monthlyExpenses - $lastMonthExpenses) / $lastMonthExpenses) * 100 
            : 0;
        

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