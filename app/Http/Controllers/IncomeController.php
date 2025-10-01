<?php

namespace App\Http\Controllers;

use App\Models\Income;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $incomes = Income::where('user_id', Auth::id())
            ->orderBy('date', 'desc')
            ->paginate(10);
            
        return view('incomes.index', compact('incomes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('incomes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'date' => 'required|date',
            'description' => 'nullable|string|max:500',
        ]);

        Income::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'amount' => $request->amount,
            'date' => $request->date,
            'description' => $request->description,
        ]);

        return redirect()->route('incomes.index')
            ->with('success', 'Income added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Income $income)
    {
        // Check if income belongs to current user
        if ($income->user_id !== Auth::id()) {
            abort(403);
        }
        
        return view('incomes.show', compact('income'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Income $income)
    {
        // Check if income belongs to current user
        if ($income->user_id !== Auth::id()) {
            abort(403);
        }
        
        return view('incomes.edit', compact('income'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Income $income)
    {
        // Check if income belongs to current user
        if ($income->user_id !== Auth::id()) {
            abort(403);
        }
        
        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'date' => 'required|date',
            'description' => 'nullable|string|max:500',
        ]);

        $income->update([
            'title' => $request->title,
            'amount' => $request->amount,
            'date' => $request->date,
            'description' => $request->description,
        ]);

        return redirect()->route('incomes.index')
            ->with('success', 'Income updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Income $income)
    {
        // Check if income belongs to current user
        if ($income->user_id !== Auth::id()) {
            abort(403);
        }
        
        $income->delete();
        
        return redirect()->route('incomes.index')
            ->with('success', 'Income deleted successfully!');
    }
}