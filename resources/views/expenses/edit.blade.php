<x-app-layout>
    <x-slot name="header">
        <h2 style="font-size: 1.875rem; font-weight: 600; color: #1f2937;">
            {{ __('Edit Expense') }}
        </h2>
    </x-slot>

    <div style="padding: 3rem 0;">
        <div style="max-width: 42rem; margin: 0 auto; padding: 0 1.5rem;">
            <div style="background-color: white; overflow: hidden; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); border-radius: 0.5rem;">
                
                <!-- Header -->
                <div style="padding: 1.5rem; border-bottom: 1px solid #e5e7eb;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h3 style="font-size: 1.25rem; font-weight: 600; color: #1f2937; margin: 0;">Edit: {{ $expense->title }}</h3>
                        <div style="display: flex; gap: 0.5rem;">
                            <a href="{{ route('expenses.show', $expense) }}" 
                               style="background-color: #3b82f6; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; font-weight: 500; font-size: 0.875rem;">
                                View
                            </a>
                            <a href="{{ route('expenses.index') }}" 
                               style="background-color: #6b7280; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; font-weight: 500; font-size: 0.875rem;">
                                Back to List
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Form -->
                <div style="padding: 1.5rem;">
                    <form action="{{ route('expenses.update', $expense) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Title Field -->
                        <div style="margin-bottom: 1.5rem;">
                            <label for="title" style="display: block; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">
                                Expense Title *
                            </label>
                            <input type="text" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title', $expense->title) }}"
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
                                   value="{{ old('amount', $expense->amount) }}"
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
                                            {{ (old('category_id', $expense->category_id) == $category->id) ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Date Field -->
                        <div style="margin-bottom: 1.5rem;">
                            <label for="date" style="display: block; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">
                                Date *
                            </label>
                            <input type="date" 
                                   id="date" 
                                   name="date" 
                                   value="{{ old('date', $expense->date->format('Y-m-d')) }}"
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
                                      style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 1rem; color: #1f2937; resize: vertical;">{{ old('description', $expense->description) }}</textarea>
                            @error('description')
                                <p style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Buttons -->
                        <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                            <a href="{{ route('expenses.index') }}" 
                               style="background-color: #f3f4f6; color: #374151; padding: 0.75rem 1.5rem; border-radius: 0.375rem; text-decoration: none; font-weight: 500; border: 1px solid #d1d5db;">
                                Cancel
                            </a>
                            <button type="submit" 
                                    style="background-color: #f59e0b; color: white; padding: 0.75rem 1.5rem; border-radius: 0.375rem; border: none; cursor: pointer; font-weight: 500; font-size: 1rem;">
                                Update Expense
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Current Category Info -->
                @if($expense->category)
                    <div style="margin: 0 1.5rem 1.5rem 1.5rem; background-color: #f0f9ff; border: 1px solid #bae6fd; border-radius: 0.5rem; padding: 1rem;">
                        <p style="color: #0369a1; font-weight: 500; margin: 0;">
                            Current Category: 
                            <span style="background-color: {{ $expense->category->color }}; color: white; padding: 0.25rem 0.5rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 500; margin-left: 0.5rem;">
                                {{ $expense->category->name }}
                            </span>
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>