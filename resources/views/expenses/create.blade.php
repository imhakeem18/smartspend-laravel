<x-app-layout>
    <x-slot name="header">
        <h2 style="font-size: 1.875rem; font-weight: 600; color: #1f2937;">
            {{ __('Add New Expense') }}
        </h2>
    </x-slot>

    <div style="padding: 3rem 0;">
        <div style="max-width: 42rem; margin: 0 auto; padding: 0 1.5rem;">
            <div style="background-color: white; overflow: hidden; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); border-radius: 0.5rem;">
                
                <!-- Header -->
                <div style="padding: 1.5rem; border-bottom: 1px solid #e5e7eb;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h3 style="font-size: 1.25rem; font-weight: 600; color: #1f2937; margin: 0;">New Expense Details</h3>
                        <a href="{{ route('expenses.index') }}" 
                           style="background-color: #6b7280; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; font-weight: 500;">
                            Back to List
                        </a>
                    </div>
                </div>

                <!-- Form -->
                <div style="padding: 1.5rem;">
                    <form action="{{ route('expenses.store') }}" method="POST">
                        @csrf
                        <div style="margin-bottom: 1.5rem;">
                            <label for="title" style="display: block; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">
                                Expense Title *
                            </label>
                            <input type="text" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title') }}"
                                   placeholder="e.g., Lunch at restaurant, Gas for car..."
                                   style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 1rem; color: #1f2937;"
                                   required>
                            @error('title')
                                <p style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Amount Field -->
                        <div style="margin-bottom: 1.5rem;">
                            <label for="amount" style="display: block; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">
                                Amount ($) *
                            </label>
                            <input type="number" 
                                   id="amount" 
                                   name="amount" 
                                   value="{{ old('amount') }}"
                                   placeholder="0.00"
                                   step="0.01"
                                   min="0.01"
                                   style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 1rem; color: #1f2937;"
                                   required>
                            @error('amount')
                                <p style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Category Field -->
                        <div style="margin-bottom: 1.5rem;">
                            <label for="category_id" style="display: block; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">
                                Category *
                            </label>
                            <select id="category_id" 
                                    name="category_id" 
                                    style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 1rem; color: #1f2937; background-color: white;"
                                    required>
                                <option value="">Select a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
                            @enderror
                            
                            @if($categories->count() == 0)
                                <p style="color: #f59e0b; font-size: 0.875rem; margin-top: 0.25rem;">
                                    No categories found. <a href="{{ route('categories.create') }}" style="color: #3b82f6; text-decoration: underline;">Create a category first</a>
                                </p>
                            @endif
                        </div>

                        <!-- Date Field -->
                        <div style="margin-bottom: 1.5rem;">
                            <label for="date" style="display: block; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">
                                Date *
                            </label>
                            <input type="date" 
                                   id="date" 
                                   name="date" 
                                   value="{{ old('date', date('Y-m-d')) }}"
                                   style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 1rem; color: #1f2937;"
                                   required>
                            @error('date')
                                <p style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description Field -->
                        <div style="margin-bottom: 1.5rem;">
                            <label for="description" style="display: block; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">
                                Description (Optional)
                            </label>
                            <textarea id="description" 
                                      name="description" 
                                      rows="3"
                                      placeholder="Add any additional notes about this expense..."
                                      style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 1rem; color: #1f2937; resize: vertical;">{{ old('description') }}</textarea>
                            @error('description')
                                <p style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                            <a href="{{ route('expenses.index') }}" 
                               style="background-color: #f3f4f6; color: #374151; padding: 0.75rem 1.5rem; border-radius: 0.375rem; text-decoration: none; font-weight: 500; border: 1px solid #d1d5db;">
                                Cancel
                            </a>
                            <button type="submit" 
                                    style="background-color: #dc2626; color: white; padding: 0.75rem 1.5rem; border-radius: 0.375rem; border: none; cursor: pointer; font-weight: 500; font-size: 1rem;">
                                Add Expense
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Quick Categories Info -->
            @if($categories->count() > 0)
                <div style="margin-top: 1.5rem; background-color: #f0f9ff; border: 1px solid #bae6fd; border-radius: 0.5rem; padding: 1rem;">
                    <h4 style="color: #0369a1; font-weight: 600; margin: 0 0 0.5rem 0;">Available Categories:</h4>
                    <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                        @foreach($categories as $category)
                            <span style="background-color: {{ $category->color }}; color: white; padding: 0.25rem 0.5rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 500;">
                                {{ $category->name }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>