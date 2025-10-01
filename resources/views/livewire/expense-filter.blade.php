<div style="width: 100%; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
    
    <!-- Filter Section -->
    <div style="margin-bottom: 30px; padding: 20px; background: #f8f9fa; border-radius: 6px;">
        <h3 style="margin: 0 0 20px 0; color: #333; font-size: 18px;">Filter Expenses</h3>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 15px;">
            
            <!-- Category Filter -->
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #555;">Category</label>
                <select wire:model.live="selectedCategory" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Start Date -->
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #555;">Start Date</label>
                <input type="date" wire:model.live="startDate" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
            </div>

            <!-- End Date -->
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #555;">End Date</label>
                <input type="date" wire:model.live="endDate" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
            </div>

            <!-- Search -->
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 600; color: #555;">Search Description</label>
                <input type="text" wire:model.live.debounce.300ms="searchTerm" placeholder="Search..." style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
            </div>

        </div>

        <!-- Clear Filters Button -->
        <button wire:click="clearFilters" style="padding: 10px 20px; background: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: 600;">
            Clear Filters
        </button>
    </div>

    <!-- Results Count -->
    <p style="margin-bottom: 20px; color: #666; font-weight: 600;">
        Showing {{ count($expenses) }} expense(s)
    </p>

    <!-- Expenses Table -->
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8f9fa; border-bottom: 2px solid #dee2e6;">
                    <th style="padding: 12px; text-align: left; font-weight: 600; color: #333;">Date</th>
                    <th style="padding: 12px; text-align: left; font-weight: 600; color: #333;">Category</th>
                    <th style="padding: 12px; text-align: left; font-weight: 600; color: #333;">Amount</th>
                    <th style="padding: 12px; text-align: left; font-weight: 600; color: #333;">Description</th>
                    <th style="padding: 12px; text-align: left; font-weight: 600; color: #333;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($expenses as $expense)
                    <tr style="border-bottom: 1px solid #dee2e6;">
                        <td style="padding: 12px;">{{ \Carbon\Carbon::parse($expense->date)->format('M d, Y') }}</td>
                        <td style="padding: 12px;">
                            <span style="display: inline-block; padding: 4px 12px; background: {{ $expense->category->color }}20; color: {{ $expense->category->color }}; border-radius: 12px; font-size: 14px; font-weight: 600;">
                                {{ $expense->category->name }}
                            </span>
                        </td>
                        <td style="padding: 12px; font-weight: 600; color: #dc3545;">Rs. {{ number_format($expense->amount, 2) }}</td>
                        <td style="padding: 12px; color: #666;">{{ $expense->description ?? 'No description' }}</td>
                        <td style="padding: 12px;">
                            <a href="{{ route('expenses.edit', $expense->id) }}" style="padding: 6px 12px; background: #007bff; color: white; text-decoration: none; border-radius: 4px; font-size: 14px; margin-right: 5px;">Edit</a>
                            <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Delete this expense?')" style="padding: 6px 12px; background: #dc3545; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 14px;">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="padding: 40px; text-align: center; color: #999; font-size: 16px;">
                            No expenses found matching your filters.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>