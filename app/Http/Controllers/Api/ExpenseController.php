<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the user's expenses.
     */
    public function index(Request $request)
    {
        $expenses = Expense::with('category')
            ->where('user_id', $request->user()->id)
            ->orderBy('date', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $expenses
        ], 200);
    }

    /**
     * Store a newly created expense.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'description' => 'nullable|string|max:500'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $expense = Expense::create([
            'user_id' => $request->user()->id,
            'category_id' => $request->category_id,
            'amount' => $request->amount,
            'date' => $request->date,
            'description' => $request->description
        ]);

        $expense->load('category');

        return response()->json([
            'success' => true,
            'message' => 'Expense created successfully',
            'data' => $expense
        ], 201);
    }

    /**
     * Display the specified expense.
     */
    public function show(Request $request, $id)
    {
        $expense = Expense::with('category')
            ->where('user_id', $request->user()->id)
            ->where('id', $id)
            ->first();

        if (!$expense) {
            return response()->json([
                'success' => false,
                'message' => 'Expense not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $expense
        ], 200);
    }

    /**
     * Update the specified expense.
     */
    public function update(Request $request, $id)
    {
        $expense = Expense::where('user_id', $request->user()->id)
            ->where('id', $id)
            ->first();

        if (!$expense) {
            return response()->json([
                'success' => false,
                'message' => 'Expense not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'category_id' => 'sometimes|required|exists:categories,id',
            'amount' => 'sometimes|required|numeric|min:0',
            'date' => 'sometimes|required|date',
            'description' => 'nullable|string|max:500'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $expense->update($request->all());
        $expense->load('category');

        return response()->json([
            'success' => true,
            'message' => 'Expense updated successfully',
            'data' => $expense
        ], 200);
    }

    /**
     * Remove the specified expense.
     */
    public function destroy(Request $request, $id)
    {
        $expense = Expense::where('user_id', $request->user()->id)
            ->where('id', $id)
            ->first();

        if (!$expense) {
            return response()->json([
                'success' => false,
                'message' => 'Expense not found'
            ], 404);
        }

        $expense->delete();

        return response()->json([
            'success' => true,
            'message' => 'Expense deleted successfully'
        ], 200);
    }
}