<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Income;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IncomeController extends Controller
{
    /**
     * Display a listing of the user's incomes.
     */
    public function index(Request $request)
    {
        $incomes = Income::where('user_id', $request->user()->id)
            ->orderBy('date', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $incomes
        ], 200);
    }

    /**
     * Store a newly created income.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
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

        $income = Income::create([
            'user_id' => $request->user()->id,
            'title' => $request->title,
            'amount' => $request->amount,
            'date' => $request->date,
            'description' => $request->description
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Income created successfully',
            'data' => $income
        ], 201);
    }

    /**
     * Display the specified income.
     */
    public function show(Request $request, $id)
    {
        $income = Income::where('user_id', $request->user()->id)
            ->where('id', $id)
            ->first();

        if (!$income) {
            return response()->json([
                'success' => false,
                'message' => 'Income not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $income
        ], 200);
    }

    /**
     * Update the specified income.
     */
    public function update(Request $request, $id)
    {
        $income = Income::where('user_id', $request->user()->id)
            ->where('id', $id)
            ->first();

        if (!$income) {
            return response()->json([
                'success' => false,
                'message' => 'Income not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
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

        $income->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Income updated successfully',
            'data' => $income
        ], 200);
    }

    /**
     * Remove the specified income.
     */
    public function destroy(Request $request, $id)
    {
        $income = Income::where('user_id', $request->user()->id)
            ->where('id', $id)
            ->first();

        if (!$income) {
            return response()->json([
                'success' => false,
                'message' => 'Income not found'
            ], 404);
        }

        $income->delete();

        return response()->json([
            'success' => true,
            'message' => 'Income deleted successfully'
        ], 200);
    }
}