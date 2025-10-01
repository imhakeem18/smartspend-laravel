<x-app-layout>
    <x-slot name="header">
        <h2 style="font-size: 1.875rem; font-weight: 600; color: #1f2937;">
            {{ __('My Expenses') }}
        </h2>
    </x-slot>

    <div style="padding: 3rem 0;">
        <div style="max-width: 80rem; margin: 0 auto; padding: 0 1.5rem;">
            
            <!-- Success Message -->
            @if (session('success'))
                <div style="background-color: #dcfce7; border: 1px solid #bbf7d0; color: #166534; padding: 1rem; margin-bottom: 1.5rem; border-radius: 0.5rem;">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Header with Add Button -->
            <div style="background-color: white; padding: 1.5rem; border-radius: 0.5rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); margin-bottom: 1.5rem;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <h3 style="font-size: 1.25rem; font-weight: 600; color: #1f2937;">Expense List</h3>
                    <a href="{{ route('expenses.create') }}" 
                       style="background-color: #dc2626; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; font-weight: 500; display: inline-block;">
                        Add New Expense
                    </a>
                </div>
            </div>

            <!-- Livewire Component -->
            @livewire('expense-filter')

        </div>
    </div>
</x-app-layout>