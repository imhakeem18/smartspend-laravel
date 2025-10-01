<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Income Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    
                    <!-- Back to List Button -->
                    <div style="margin-bottom: 30px;">
                        <a href="{{ route('incomes.index') }}" 
                           style="color: #3B82F6; text-decoration: none; font-size: 16px;">
                            ← Back to Incomes List
                        </a>
                    </div>

                    <!-- Income Details Card -->
                    <div style="border: 1px solid #E5E7EB; border-radius: 8px; padding: 30px; background-color: #F9FAFB;">
                        
                        <!-- Title -->
                        <div style="margin-bottom: 25px;">
                            <h3 style="font-size: 24px; font-weight: bold; color: #1F2937; margin: 0;">
                                {{ $income->title }}
                            </h3>
                        </div>

                        <!-- Details Grid -->
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 25px;">
                            
                            <!-- Amount -->
                            <div>
                                <label style="display: block; font-size: 14px; font-weight: 600; color: #6B7280; margin-bottom: 8px;">
                                    Amount
                                </label>
                                <div style="font-size: 28px; font-weight: bold; color: #10B981;">
                                    ${{ number_format($income->amount, 2) }}
                                </div>
                            </div>

                            <!-- Date -->
                            <div>
                                <label style="display: block; font-size: 14px; font-weight: 600; color: #6B7280; margin-bottom: 8px;">
                                    Date Received
                                </label>
                                <div style="font-size: 18px; color: #1F2937;">
                                    {{ $income->date->format('F j, Y') }}
                                    <span style="font-size: 14px; color: #6B7280;">
                                        ({{ $income->date->diffForHumans() }})
                                    </span>
                                </div>
                            </div>

                        </div>

                        <!-- Description -->
                        @if($income->description)
                            <div style="margin-bottom: 25px;">
                                <label style="display: block; font-size: 14px; font-weight: 600; color: #6B7280; margin-bottom: 8px;">
                                    Description
                                </label>
                                <div style="font-size: 16px; color: #4B5563; line-height: 1.6; background-color: white; padding: 15px; border-radius: 6px; border: 1px solid #E5E7EB;">
                                    {{ $income->description }}
                                </div>
                            </div>
                        @endif

                        <!-- Meta Information -->
                        <div style="border-top: 1px solid #E5E7EB; padding-top: 20px; margin-top: 30px;">
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; font-size: 14px; color: #6B7280;">
                                <div>
                                    <strong>Created:</strong> {{ $income->created_at->format('M j, Y \a\t g:i A') }}
                                </div>
                                <div>
                                    <strong>Last Updated:</strong> {{ $income->updated_at->format('M j, Y \a\t g:i A') }}
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Action Buttons -->
                    <div style="display: flex; gap: 15px; margin-top: 30px; justify-content: center;">
                        <a href="{{ route('incomes.edit', $income) }}" 
                           style="background-color: #F59E0B; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; font-weight: bold; display: inline-block;">
                            Edit Income
                        </a>
                        
                        <form action="{{ route('incomes.destroy', $income) }}" 
                              method="POST" 
                              style="display: inline-block;"
                              onsubmit="return confirm('Are you sure you want to delete this income? This action cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    style="background-color: #EF4444; color: white; padding: 12px 24px; border: none; border-radius: 6px; cursor: pointer; font-weight: bold;">
                                Delete Income
                            </button>
                        </form>
                        
                        <a href="{{ route('incomes.index') }}" 
                           style="background-color: #6B7280; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; font-weight: bold; display: inline-block;">
                            Back to List
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>