<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all categories for the authenticated user, ordered by name
        $categories = Category::where('user_id', Auth::id())
            ->withCount('expenses') // Count how many expenses each category has
            ->orderBy('name')
            ->paginate(10);

        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Pre-defined color options for easy selection
        $colorOptions = [
            '#FF6B6B' => 'Red',
            '#4ECDC4' => 'Teal',
            '#45B7D1' => 'Blue',
            '#96CEB4' => 'Green',
            '#FECA57' => 'Yellow',
            '#FF9FF3' => 'Pink',
            '#54A0FF' => 'Light Blue',
            '#5F27CD' => 'Purple',
            '#00D2D3' => 'Cyan',
            '#FF9F43' => 'Orange',
            '#1DD1A1' => 'Mint',
            '#FD79A8' => 'Rose',
            '#6C5CE7' => 'Violet',
            '#A29BFE' => 'Lavender',
            '#FF7675' => 'Coral'
        ];

        return view('categories.create', compact('colorOptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,NULL,id,user_id,' . Auth::id(),
            'color' => 'required|string|starts_with:#|size:7',
            'description' => 'nullable|string|max:500',
        ]);

        Category::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'color' => $request->color,
            'description' => $request->description,
        ]);

        return redirect()->route('categories.index')->with('success', 'Category created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        // Make sure the category belongs to the authenticated user
        if ($category->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Get expenses for this category with pagination
        $expenses = $category->expenses()
            ->orderBy('date', 'desc')
            ->paginate(10);

        return view('categories.show', compact('category', 'expenses'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        // Make sure the category belongs to the authenticated user
        if ($category->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Pre-defined color options for easy selection
        $colorOptions = [
            '#FF6B6B' => 'Red',
            '#4ECDC4' => 'Teal',
            '#45B7D1' => 'Blue',
            '#96CEB4' => 'Green',
            '#FECA57' => 'Yellow',
            '#FF9FF3' => 'Pink',
            '#54A0FF' => 'Light Blue',
            '#5F27CD' => 'Purple',
            '#00D2D3' => 'Cyan',
            '#FF9F43' => 'Orange',
            '#1DD1A1' => 'Mint',
            '#FD79A8' => 'Rose',
            '#6C5CE7' => 'Violet',
            '#A29BFE' => 'Lavender',
            '#FF7675' => 'Coral'
        ];

        return view('categories.edit', compact('category', 'colorOptions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        // Make sure the category belongs to the authenticated user
        if ($category->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id . ',id,user_id,' . Auth::id(),
            'color' => 'required|string|starts_with:#|size:7',
            'description' => 'nullable|string|max:500',
        ]);

        $category->update([
            'name' => $request->name,
            'color' => $request->color,
            'description' => $request->description,
        ]);

        return redirect()->route('categories.index')->with('success', 'Category updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // Make sure the category belongs to the authenticated user
        if ($category->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Check if category has expenses
        $expenseCount = $category->expenses()->count();
        
        if ($expenseCount > 0) {
            return redirect()->route('categories.index')
                ->with('error', "Cannot delete category '{$category->name}' because it has {$expenseCount} expense(s). Please reassign or delete those expenses first.");
        }

        $categoryName = $category->name;
        $category->delete();

        return redirect()->route('categories.index')->with('success', "Category '{$categoryName}' deleted successfully!");
    }
}