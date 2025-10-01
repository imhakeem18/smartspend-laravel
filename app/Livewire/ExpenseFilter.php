<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Expense;
use App\Models\Category;

class ExpenseFilter extends Component
{
    public $selectedCategory = '';
    public $startDate = '';
    public $endDate = '';
    public $searchTerm = '';

    public function render()
    {
        $query = Expense::with('category')
            ->where('user_id', auth()->id());

        // Filter by category
        if ($this->selectedCategory) {
            $query->where('category_id', $this->selectedCategory);
        }

        // Filter by date range
        if ($this->startDate) {
            $query->whereDate('date', '>=', $this->startDate);
        }
        if ($this->endDate) {
            $query->whereDate('date', '<=', $this->endDate);
        }

        // Search in description
        if ($this->searchTerm) {
            $query->where('description', 'like', '%' . $this->searchTerm . '%');
        }

        $expenses = $query->orderBy('date', 'desc')->get();
        $categories = Category::where('user_id', auth()->id())->get();

        return view('livewire.expense-filter', [
            'expenses' => $expenses,
            'categories' => $categories
        ]);
    }

    public function clearFilters()
    {
        $this->selectedCategory = '';
        $this->startDate = '';
        $this->endDate = '';
        $this->searchTerm = '';
    }
}