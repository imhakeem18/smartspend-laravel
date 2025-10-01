<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Income') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    
                    <!-- Back to List Button -->
                    <div style="margin-bottom: 20px;">
                        <a href="{{ route('incomes.index') }}" 
                           style="color: #3B82F6; text-decoration: none;">
                            ← Back to Incomes List
                        </a>
                    </div>

                    <!-- Form -->
                    <form action="{{ route('incomes.update', $income) }}" method="POST" style="display: flex; flex-direction: column; gap: 24px;">
                        @csrf
                        @method('PUT')

                        <!-- Title Field -->
                        <div>
                            <label for="title" style="display: block; font-size: 14px; font-weight: 600; color: #374151; margin-bottom: 8px;">
                                Income Title *
                            </label>
                            <input type="text" 
                                   name="title" 
                                   id="title"
                                   value="{{ old('title', $income->title) }}"
                                   placeholder="e.g., Salary, Freelance, Business Income"
                                   style="width: 100%; padding: 8px 12px; border: 1px solid #D1D5DB; border-radius: 6px; font-size: 16px;">
                            @error('title')
                                <p style="margin-top: 4px; font-size: 14px; color: #DC2626;">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Amount Field -->
                        <div>
                            <label for="amount" style="display: block; font-size: 14px; font-weight: 600; color: #374151; margin-bottom: 8px;">
                                Amount ($) *
                            </label>
                            <input type="number" 
                                   name="amount" 
                                   id="amount"
                                   value="{{ old('amount', $income->amount) }}"
                                   step="0.01"
                                   min="0.01"
                                   placeholder="0.00"
                                   style="width: 100%; padding: 8px 12px; border: 1px solid #D1D5DB; border-radius: 6px; font-size: 16px;">
                            @error('amount')
                                <p style="margin-top: 4px; font-size: 14px; color: #DC2626;">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Date Field -->
                        <div>
                            <label for="date" style="display: block; font-size: 14px; font-weight: 600; color: #374151; margin-bottom: 8px;">
                                Date Received *
                            </label>
                            <input type="date" 
                                   name="date" 
                                   id="date"
                                   value="{{ old('date', $income->date->format('Y-m-d')) }}"
                                   style="width: 100%; padding: 8px 12px; border: 1px solid #D1D5DB; border-radius: 6px; font-size: 16px;">
                            @error('date')
                                <p style="margin-top: 4px; font-size: 14px; color: #DC2626;">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description Field -->
                        <div>
                            <label for="description" style="display: block; font-size: 14px; font-weight: 600; color: #374151; margin-bottom: 8px;">
                                Description (Optional)
                            </label>
                            <textarea name="description" 
                                      id="description"
                                      rows="3"
                                      placeholder="Additional details about this income..."
                                      style="width: 100%; padding: 8px 12px; border: 1px solid #D1D5DB; border-radius: 6px; font-size: 16px; resize: vertical;">{{ old('description', $income->description) }}</textarea>
                            @error('description')
                                <p style="margin-top: 4px; font-size: 14px; color: #DC2626;">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Form Buttons -->
                        <div style="display: flex; gap: 15px; margin-top: 20px;">
                            <button type="submit" 
                                    style="background-color: #10B981; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">
                                Update Income
                            </button>
                            <a href="{{ route('incomes.index') }}" 
                               style="background-color: #6B7280; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block;">
                                Cancel
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>