<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Incomes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    
                    <!-- Success Message -->
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif
                       
                        <!-- Add New Income Button -->
        <div style="margin-bottom: 20px;">
        <a href="{{ route('incomes.create') }}" 
         style="background-color: #3B82F6; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block;">
        Add New Income
    </a>
</div>

                    <!-- Incomes Table -->
                    @if($incomes->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full table-auto">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="px-4 py-2 text-left">Title</th>
                                        <th class="px-4 py-2 text-left">Amount</th>
                                        <th class="px-4 py-2 text-left">Date</th>
                                        <th class="px-4 py-2 text-left">Description</th>
                                        <th class="px-4 py-2 text-left">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($incomes as $income)
                                        <tr class="border-b">
                                            <td class="px-4 py-2">{{ $income->title }}</td>
                                            <td class="px-4 py-2">${{ number_format($income->amount, 2) }}</td>
                                            <td class="px-4 py-2">{{ $income->date->format('M d, Y') }}</td>
                                            <td class="px-4 py-2">{{ $income->description ?? 'No description' }}</td>
                                            <td class="px-4 py-2">
                                                <a href="{{ route('incomes.show', $income) }}" 
                                                   class="text-blue-600 hover:text-blue-900 mr-2">View</a>
                                                <a href="{{ route('incomes.edit', $income) }}" 
                                                   class="text-green-600 hover:text-green-900 mr-2">Edit</a>
                                                <form action="{{ route('incomes.destroy', $income) }}" 
                                                      method="POST" 
                                                      class="inline-block"
                                                      onsubmit="return confirm('Are you sure you want to delete this income?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="text-red-600 hover:text-red-900">
                                                        Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-4">
                            {{ $incomes->links() }}
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500 text-lg">No incomes found.</p>
                            <p class="text-gray-400">Start by adding your first income!</p>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>