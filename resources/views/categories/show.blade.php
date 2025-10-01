<x-app-layout>
    <x-slot name="header">
        <h2 style="font-size: 1.875rem; font-weight: 600; color: #1f2937;">
            {{ __('Category Details') }}
        </h2>
    </x-slot>

    <div style="padding: 3rem 0;">
        <div style="max-width: 80rem; margin: 0 auto; padding: 0 1.5rem;">
            
            <!-- Category Header Card -->
            <div style="background-color: white; overflow: hidden; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); border-radius: 0.5rem; margin-bottom: 2rem;">
                
                <!-- Header -->
                <div style="padding: 1.5rem; border-bottom: 1px solid #e5e7eb;">
                    <div style="display: flex; justify-content: between; align-items: center; gap: 2rem;">
                        <!-- Category Info -->
                        <div style="display: flex; align-items: center; gap: 1.5rem; flex: 1;">
                            <div style="width: 4rem; height: 4rem; background-color: {{ $category->color }}; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <span style="color: white; font-weight: bold; font-size: 1.5rem;">
                                    {{ strtoupper(substr($category->name, 0, 1)) }}
                                </span>
                            </div>
                            <div>
                                <h3 style="font-size: 1.5rem; font-weight: 600; color: #1f2937; margin: 0;">{{ $category->name }}</h3>
                                @if($category->description)
                                    <p style="color: #6b7280; margin: 0.5rem 0 0 0; font-size: 1rem;">{{ $category->description }}</p>
                                @endif
                                <p style="color: #9ca3af; font-size: 0.875rem; margin: 0.5rem 0 0 0;">
                                    Created {{ $category->created_at->format('M d, Y') }}
                                </p>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div style="display: flex; gap: 0.5rem;">
                            <a href="{{ route('categories.edit', $category) }}" 
                               style="background-color: #f59e0b; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; font-weight: 500; font-size: 0.875rem;">
                                Edit Category
                            </a>
                            <a href="{{ route('categories.index') }}" 
                               style="background-color: #6b7280; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; font-weight: 500; font-size: 0.875rem;">
                                Back to List
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Stats -->
                <div style="padding: 1.5rem;">
                    @php
                        $totalExpenses = $expenses->total();
                        $totalAmount = $category->expenses()->sum('amount');
                        $avgAmount = $totalExpenses > 0 ? $totalAmount / $totalExpenses : 0;
                        $thisMonthAmount = $category->expenses()->whereYear('date', now()->year)->whereMonth('date', now()->month)->sum('amount');
                    @endphp

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
                        <!-- Total Expenses -->
                        <div style="text-align: center; padding: 1rem; background-color: #fee2e2; border-radius: 0.5rem;">
                            <p style="color: #6b7280; font-size: 0.875rem; margin: 0; text-transform: uppercase; letter-spacing: 0.05em;">Total Expenses</p>
                            <p style="color: #dc2626; font-size: 2rem; font-weight: 700; margin: 0.25rem 0 0 0;">{{ $totalExpenses }}</p>
                        </div>

                        <!-- Total Amount -->
                        <div style="text-align: center; padding: 1rem; background-color: #fee2e2; border-radius: 0.5rem;">
                            <p style="color: #6b7280; font-size: 0.875rem; margin: 0; text-transform: uppercase; letter-spacing: 0.05em;">Total Spent</p>
                            <p style="color: #dc2626; font-size: 2rem; font-weight: 700; margin: 0.25rem 0 0 0;">-${{ number_format($totalAmount, 2) }}</p>
                        </div>

                        <!-- Average Expense -->
                        <div style="text-align: center; padding: 1rem; background-color: #f0f9ff; border-radius: 0.5rem;">
                            <p style="color: #6b7280; font-size: 0.875rem; margin: 0; text-transform: uppercase; letter-spacing: 0.05em;">Average Expense</p>
                            <p style="color: #3b82f6; font-size: 2rem; font-weight: 700; margin: 0.25rem 0 0 0;">${{ number_format($avgAmount, 2) }}</p>
                        </div>

                        <!-- This Month -->
                        <div style="text-align: center; padding: 1rem; background-color: #f0fdf4; border-radius: 0.5rem;">
                            <p style="color: #6b7280; font-size: 0.875rem; margin: 0; text-transform: uppercase; letter-spacing: 0.05em;">This Month</p>
                            <p style="color: #10b981; font-size: 2rem; font-weight: 700; margin: 0.25rem 0 0 0;">${{ number_format($thisMonthAmount, 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Expenses List -->
            <div style="background-color: white; overflow: hidden; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); border-radius: 0.5rem;">
                
                <div style="padding: 1.5rem; border-bottom: 1px solid #e5e7eb;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h4 style="font-size: 1.25rem; font-weight: 600; color: #1f2937; margin: 0;">
                            Expenses in {{ $category->name }}
                        </h4>
                        <a href="{{ route('expenses.create') }}" 
                           style="background-color: #dc2626; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; font-weight: 500; font-size: 0.875rem;">
                            Add New Expense
                        </a>
                    </div>
                </div>

                <div style="padding: 1.5rem;">
                    @if($expenses->count() > 0)
                        <!-- Expenses Table -->
                        <div style="overflow-x: auto;">
                            <table style="width: 100%; border-collapse: collapse;">
                                <thead>
                                    <tr style="background-color: #f9fafb;">
                                        <th style="padding: 0.75rem; text-align: left; font-weight: 600; color: #374151; border-bottom: 1px solid #e5e7eb;">Date</th>
                                        <th style="padding: 0.75rem; text-align: left; font-weight: 600; color: #374151; border-bottom: 1px solid #e5e7eb;">Title</th>
                                        <th style="padding: 0.75rem; text-align: right; font-weight: 600; color: #374151; border-bottom: 1px solid #e5e7eb;">Amount</th>
                                        <th style="padding: 0.75rem; text-align: center; font-weight: 600; color: #374151; border-bottom: 1px solid #e5e7eb;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($expenses as $expense)
                                        <tr style="border-bottom: 1px solid #f3f4f6;">
                                            <td style="padding: 0.75rem; color: #6b7280;">
                                                {{ $expense->date->format('M d, Y') }}
                                            </td>
                                            <td style="padding: 0.75rem;">
                                                <div>
                                                    <p style="color: #1f2937; font-weight: 500; margin: 0;">{{ $expense->title }}</p>
                                                    @if($expense->description)
                                                        <p style="color: #9ca3af; font-size: 0.875rem; margin: 0.25rem 0 0 0;">{{ Str::limit($expense->description, 50) }}</p>
                                                    @endif
                                                </div>
                                            </td>
                                            <td style="padding: 0.75rem; text-align: right; color: #dc2626; font-weight: 600;">
                                                -${{ number_format($expense->amount, 2) }}
                                            </td>
                                            <td style="padding: 0.75rem; text-align: center;">
                                                <div style="display: flex; gap: 0.5rem; justify-content: center;">
                                                    <a href="{{ route('expenses.show', $expense) }}" 
                                                       style="background-color: #3b82f6; color: white; padding: 0.25rem 0.5rem; border-radius: 0.25rem; text-decoration: none; font-size: 0.75rem;">
                                                        View
                                                    </a>
                                                    <a href="{{ route('expenses.edit', $expense) }}" 
                                                       style="background-color: #f59e0b; color: white; padding: 0.25rem 0.5rem; border-radius: 0.25rem; text-decoration: none; font-size: 0.75rem;">
                                                        Edit
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div style="margin-top: 1.5rem;">
                            {{ $expenses->links() }}
                        </div>

                    @else
                        <!-- Empty State -->
                        <div style="text-align: center; padding: 3rem; color: #6b7280;">
                            <div style="width: 4rem; height: 4rem; background-color: {{ $category->color }}; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem auto; opacity: 0.3;">
                                <span style="color: white; font-weight: bold; font-size: 1.5rem;">
                                    {{ strtoupper(substr($category->name, 0, 1)) }}
                                </span>
                            </div>
                            <h3 style="font-size: 1.25rem; font-weight: 500; margin-bottom: 0.5rem;">No expenses in this category yet</h3>
                            <p style="margin-bottom: 1.5rem;">Start tracking expenses for {{ $category->name }} by adding your first expense.</p>
                            <a href="{{ route('expenses.create') }}" 
                               style="background-color: #dc2626; color: white; padding: 0.75rem 1.5rem; border-radius: 0.375rem; text-decoration: none; font-weight: 500;">
                                Add Expense
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Delete Category Option -->
                @if($totalExpenses === 0)
                    <div style="padding: 1.5rem; border-top: 1px solid #e5e7eb; background-color: #fef2f2;">
                        <div style="display: flex; justify-content: between; align-items: center;">
                            <div>
                                <h4 style="color: #dc2626; font-weight: 600; margin: 0 0 0.5rem 0;">Delete Category</h4>
                                <p style="color: #dc2626; font-size: 0.875rem; margin: 0;">
                                    Since this category has no expenses, you can safely delete it if no longer needed.
                                </p>
                            </div>
                            <form action="{{ route('categories.destroy', $category) }}" method="POST" style="margin-left: 1rem;" 
                                  onsubmit="return confirm('Are you sure you want to delete this category? This action cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        style="background-color: #dc2626; color: white; padding: 0.75rem 1.5rem; border-radius: 0.375rem; border: none; cursor: pointer; font-weight: 500; font-size: 1rem;">
                                    Delete Category
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>