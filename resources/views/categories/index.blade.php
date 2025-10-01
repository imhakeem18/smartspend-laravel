<x-app-layout>
    <x-slot name="header">
        <h2 style="font-size: 1.875rem; font-weight: 600; color: #1f2937;">
            {{ __('Expense Categories') }}
        </h2>
    </x-slot>

    <div style="padding: 3rem 0;">
        <div style="max-width: 80rem; margin: 0 auto; padding: 0 1.5rem;">
            <div style="background-color: white; overflow: hidden; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); border-radius: 0.5rem;">
                
                <!-- Header with Add Button -->
                <div style="padding: 1.5rem; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center;">
                    <h3 style="font-size: 1.25rem; font-weight: 600; color: #1f2937;">Manage Categories</h3>
                    <a href="{{ route('categories.create') }}" 
                       style="background-color: #10b981; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; font-weight: 500; display: inline-block;">
                        Add New Category
                    </a>
                </div>

                <!-- Success/Error Messages -->
                @if (session('success'))
                    <div style="background-color: #dcfce7; border: 1px solid #bbf7d0; color: #166534; padding: 1rem; margin: 1rem;">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div style="background-color: #fef2f2; border: 1px solid #fecaca; color: #dc2626; padding: 1rem; margin: 1rem;">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Categories Grid/List -->
                <div style="padding: 1.5rem;">
                    @if($categories->count() > 0)
                        
                        <!-- Categories Grid -->
                        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
                            @foreach($categories as $category)
                                <div style="border: 1px solid #e5e7eb; border-radius: 0.5rem; padding: 1.5rem; position: relative; background-color: #fafafa;">
                                    
                                    <!-- Category Color & Name -->
                                    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                                        <div style="width: 3rem; height: 3rem; background-color: {{ $category->color }}; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                            <span style="color: white; font-weight: bold; font-size: 1.25rem;">
                                                {{ strtoupper(substr($category->name, 0, 1)) }}
                                            </span>
                                        </div>
                                        <div>
                                            <h4 style="font-size: 1.125rem; font-weight: 600; color: #1f2937; margin: 0;">
                                                {{ $category->name }}
                                            </h4>
                                            <p style="color: #6b7280; font-size: 0.875rem; margin: 0.25rem 0 0 0;">
                                                {{ $category->expenses_count }} expense{{ $category->expenses_count === 1 ? '' : 's' }}
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Description -->
                                    @if($category->description)
                                        <p style="color: #6b7280; font-size: 0.875rem; margin-bottom: 1rem; line-height: 1.5;">
                                            {{ $category->description }}
                                        </p>
                                    @endif

                                    <!-- Total Expenses for this Category -->
                                    @php
                                        $totalAmount = $category->expenses->sum('amount');
                                    @endphp
                                    
                                    @if($totalAmount > 0)
                                        <div style="background-color: #fee2e2; padding: 0.75rem; border-radius: 0.375rem; margin-bottom: 1rem;">
                                            <p style="color: #dc2626; font-weight: 600; margin: 0; font-size: 0.875rem;">
                                                Total Spent: -${{ number_format($totalAmount, 2) }}
                                            </p>
                                        </div>
                                    @endif

                                    <!-- Action Buttons -->
                                    <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                                        <a href="{{ route('categories.show', $category) }}" 
                                           style="background-color: #3b82f6; color: white; padding: 0.375rem 0.75rem; border-radius: 0.25rem; text-decoration: none; font-size: 0.75rem; font-weight: 500;">
                                            View
                                        </a>
                                        <a href="{{ route('categories.edit', $category) }}" 
                                           style="background-color: #f59e0b; color: white; padding: 0.375rem 0.75rem; border-radius: 0.25rem; text-decoration: none; font-size: 0.75rem; font-weight: 500;">
                                            Edit
                                        </a>
                                        @if($category->expenses_count === 0)
                                            <form action="{{ route('categories.destroy', $category) }}" method="POST" style="display: inline;" 
                                                  onsubmit="return confirm('Are you sure you want to delete this category?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        style="background-color: #dc2626; color: white; padding: 0.375rem 0.75rem; border-radius: 0.25rem; border: none; cursor: pointer; font-size: 0.75rem; font-weight: 500;">
                                                    Delete
                                                </button>
                                            </form>
                                        @else
                                            <span style="background-color: #e5e7eb; color: #6b7280; padding: 0.375rem 0.75rem; border-radius: 0.25rem; font-size: 0.75rem;">
                                                Can't Delete
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div style="margin-top: 1.5rem;">
                            {{ $categories->links() }}
                        </div>

                        <!-- Summary -->
                        <div style="margin-top: 2rem; padding: 1.5rem; background-color: #f0f9ff; border-radius: 0.5rem; border: 1px solid #bae6fd;">
                            <h4 style="color: #0369a1; font-weight: 600; margin: 0 0 1rem 0;">Categories Summary</h4>
                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                                <div>
                                    <p style="color: #0369a1; font-size: 0.875rem; margin: 0;">Total Categories</p>
                                    <p style="color: #0c4a6e; font-size: 1.5rem; font-weight: 600; margin: 0;">{{ $categories->total() }}</p>
                                </div>
                                <div>
                                    <p style="color: #0369a1; font-size: 0.875rem; margin: 0;">Categories with Expenses</p>
                                    <p style="color: #0c4a6e; font-size: 1.5rem; font-weight: 600; margin: 0;">{{ $categories->where('expenses_count', '>', 0)->count() }}</p>
                                </div>
                                <div>
                                    <p style="color: #0369a1; font-size: 0.875rem; margin: 0;">Empty Categories</p>
                                    <p style="color: #0c4a6e; font-size: 1.5rem; font-weight: 600; margin: 0;">{{ $categories->where('expenses_count', 0)->count() }}</p>
                                </div>
                            </div>
                        </div>

                    @else
                        <!-- Empty State -->
                        <div style="text-align: center; padding: 3rem; color: #6b7280;">
                            <div style="width: 4rem; height: 4rem; background-color: #f3f4f6; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem auto;">
                                <span style="font-size: 1.5rem;">🏷️</span>
                            </div>
                            <h3 style="font-size: 1.25rem; font-weight: 500; margin-bottom: 0.5rem;">No categories created yet</h3>
                            <p style="margin-bottom: 1.5rem;">Create your first category to organize your expenses better.</p>
                            <a href="{{ route('categories.create') }}" 
                               style="background-color: #10b981; color: white; padding: 0.75rem 1.5rem; border-radius: 0.375rem; text-decoration: none; font-weight: 500;">
                                Create Your First Category
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>