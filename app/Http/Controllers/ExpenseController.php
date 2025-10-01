<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all expenses for the authenticated user, ordered by date (newest first)
        $expenses = Expense::with('category')
            ->where('user_id', Auth::id())
            ->orderBy('date', 'desc')
            ->paginate(10);

        return view('expenses.index', compact('expenses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get all categories for the dropdown
        $categories = Category::where('user_id', Auth::id())->get();
        
        return view('expenses.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string|max:1000',
            'date' => 'required|date',
        ]);

        Expense::create([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'title' => $request->title,
            'amount' => $request->amount,
            'description' => $request->description,
            'date' => $request->date,
        ]);

        return redirect()->route('expenses.index')->with('success', 'Expense added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense)
    {
        // Make sure the expense belongs to the authenticated user
        if ($expense->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Load the category relationship
        $expense->load('category');

        return view('expenses.show', compact('expense'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expense $expense)
    {
        // Make sure the expense belongs to the authenticated user
        if ($expense->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Get all categories for the dropdown
        $categories = Category::where('user_id', Auth::id())->get();

        return view('expenses.edit', compact('expense', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Expense $expense)
    {
        // Make sure the expense belongs to the authenticated user
        if ($expense->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string|max:1000',
            'date' => 'required|date',
        ]);

        $expense->update([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'amount' => $request->amount,
            'description' => $request->description,
            'date' => $request->date,
        ]);

        return redirect()->route('expenses.index')->with('success', 'Expense updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        // Make sure the expense belongs to the authenticated user
        if ($expense->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $expense->delete();

        return redirect()->route('expenses.index')->with('success', 'Expense deleted successfully!');
    }
}