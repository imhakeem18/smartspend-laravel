<x-app-layout>
    <x-slot name="header">
        <h2 style="font-size: 1.875rem; font-weight: 600; color: #1f2937;">
            {{ __('Expense Details') }}
        </h2>
    </x-slot>

    <div style="padding: 3rem 0;">
        <div style="max-width: 42rem; margin: 0 auto; padding: 0 1.5rem;">
            <div style="background-color: white; overflow: hidden; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); border-radius: 0.5rem;">
                
                <!-- Header -->
                <div style="padding: 1.5rem; border-bottom: 1px solid #e5e7eb;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h3 style="font-size: 1.25rem; font-weight: 600; color: #1f2937; margin: 0;">{{ $expense->title }}</h3>
                        <div style="display: flex; gap: 0.5rem;">
                            <a href="{{ route('expenses.edit', $expense) }}" 
                               style="background-color: #f59e0b; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; font-weight: 500; font-size: 0.875rem;">
                                Edit
                            </a>
                            <a href="{{ route('expenses.index') }}" 
                               style="background-color: #6b7280; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; font-weight: 500; font-size: 0.875rem;">
                                Back to List
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Expense Details -->
                <div style="padding: 1.5rem;">
                    
                    <!-- Amount - Main highlight -->
                    <div style="text-align: center; margin-bottom: 2rem; padding: 1.5rem; background-color: #fee2e2; border-radius: 0.5rem;">
                        <p style="color: #6b7280; font-size: 0.875rem; margin: 0 0 0.5rem 0; text-transform: uppercase; letter-spacing: 0.05em;">Expense Amount</p>
                        <p style="color: #dc2626; font-size: 3rem; font-weight: 700; margin: 0;">-${{ number_format($expense->amount, 2) }}</p>
                    </div>

                    <!-- Details Grid -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                        
                        <!-- Date -->
                        <div>
                            <p style="color: #6b7280; font-size: 0.875rem; margin: 0 0 0.5rem 0; font-weight: 500;">Date</p>
                            <p style="color: #1f2937; font-size: 1.125rem; font-weight: 600; margin: 0;">
                                {{ $expense->date->format('M d, Y') }}
                            </p>
                            <p style="color: #9ca3af; font-size: 0.75rem; margin: 0.25rem 0 0 0;">
                                {{ $expense->date->format('l') }} <!-- Day of week -->
                            </p>
                        </div>

                        <!-- Category -->
                        <div>
                            <p style="color: #6b7280; font-size: 0.875rem; margin: 0 0 0.5rem 0; font-weight: 500;">Category</p>
                            @if($expense->category)
                                <div style="display: flex; align-items: center; gap: 0.5rem;">
                                    <span style="background-color: {{ $expense->category->color }}; color: white; padding: 0.5rem 1rem; border-radius: 9999px; font-size: 0.875rem; font-weight: 600;">
                                        {{ $expense->category->name }}
                                    </span>
                                </div>
                                @if($expense->category->description)
                                    <p style="color: #9ca3af; font-size: 0.75rem; margin: 0.5rem 0 0 0;">
                                        {{ $expense->category->description }}
                                    </p>
                                @endif
                            @else
                                <p style="color: #9ca3af; font-style: italic; margin: 0;">No category assigned</p>
                            @endif
                        </div>
                    </div>

                    <!-- Description -->
                    @if($expense->description)
                        <div style="margin-bottom: 1.5rem;">
                            <p style="color: #6b7280; font-size: 0.875rem; margin: 0 0 0.5rem 0; font-weight: 500;">Description</p>
                            <div style="background-color: #f9fafb; padding: 1rem; border-radius: 0.375rem; border-left: 4px solid #3b82f6;">
                                <p style="color: #1f2937; margin: 0; line-height: 1.6;">{{ $expense->description }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Metadata -->
                    <div style="border-top: 1px solid #f3f4f6; padding-top: 1.5rem; margin-top: 2rem;">
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; color: #9ca3af; font-size: 0.75rem;">
                            <div>
                                <strong>Created:</strong> {{ $expense->created_at->format('M d, Y \a\t g:i A') }}
                            </div>
                            @if($expense->updated_at != $expense->created_at)
                                <div>
                                    <strong>Last Updated:</strong> {{ $expense->updated_at->format('M d, Y \a\t g:i A') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div style="padding: 1.5rem; border-top: 1px solid #e5e7eb; background-color: #f9fafb;">
                    <div style="display: flex; gap: 1rem; justify-content: center;">
                        <a href="{{ route('expenses.edit', $expense) }}" 
                           style="background-color: #f59e0b; color: white; padding: 0.75rem 1.5rem; border-radius: 0.375rem; text-decoration: none; font-weight: 500;">
                            Edit Expense
                        </a>
                        
                        <form action="{{ route('expenses.destroy', $expense) }}" method="POST" style="display: inline;" 
                              onsubmit="return confirm('Are you sure you want to delete this expense? This action cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    style="background-color: #dc2626; color: white; padding: 0.75rem 1.5rem; border-radius: 0.375rem; border: none; cursor: pointer; font-weight: 500; font-size: 1rem;">
                                Delete Expense
                            </button>
                        </form>
                        
                        <a href="{{ route('expenses.index') }}" 
                           style="background-color: #6b7280; color: white; padding: 0.75rem 1.5rem; border-radius: 0.375rem; text-decoration: none; font-weight: 500;">
                            Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>