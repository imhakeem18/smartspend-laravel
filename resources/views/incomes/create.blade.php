<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Income') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    
                    <!-- Back to List Button -->
                    <div class="mb-4">
                        <a href="{{ route('incomes.index') }}" 
                           class="text-blue-600 hover:text-blue-900">
                            ← Back to Incomes List
                        </a>
                    </div>

                    <!-- Form -->
                    <form action="{{ route('incomes.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700">
                                Income Title *
                            </label>
                            <input type="text" 
                                   name="title" 
                                   id="title"
                                   value="{{ old('title') }}"
                                   placeholder="e.g., Salary, Freelance, Business Income"
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Amount Field -->
                        <div>
                            <label for="amount" class="block text-sm font-medium text-gray-700">
                                Amount ($) *
                            </label>
                            <input type="number" 
                                   name="amount" 
                                   id="amount"
                                   value="{{ old('amount') }}"
                                   step="0.01"
                                   min="0.01"
                                   placeholder="0.00"
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            @error('amount')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Date Field -->
                        <div>
                            <label for="date" class="block text-sm font-medium text-gray-700">
                                Date Received *
                            </label>
                            <input type="date" 
                                   name="date" 
                                   id="date"
                                   value="{{ old('date', date('Y-m-d')) }}"
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            @error('date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description Field -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">
                                Description (Optional)
                            </label>
                            <textarea name="description" 
                                      id="description"
                                      rows="3"
                                      placeholder="Additional details about this income..."
                                      class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Form Buttons -->
                        <div class="flex items-center space-x-4">
                    <!-- Form Buttons -->
<div style="display: flex; gap: 15px; margin-top: 20px;">
    <button type="submit" 
            style="background-color: #3B82F6; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">
        Add Income
    </button>
    <a href="{{ route('incomes.index') }}" 
       style="background-color: #6B7280; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block;">
        Cancel
    </a>
</div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>