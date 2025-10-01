<x-app-layout>
    <x-slot name="header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h2 style="font-size: 1.875rem; font-weight: 600; color: #1f2937; margin: 0;">
                {{ __('SmartSpend Dashboard') }}
            </h2>
            <p style="color: #6b7280; margin: 0; font-size: 0.875rem;">
                {{ $currentMonth->format('F Y') }} Overview
            </p>
        </div>
    </x-slot>

    <div style="padding: 2rem 0;">
        <div style="max-width: 90rem; margin: 0 auto; padding: 0 1.5rem;">
            
            <!-- Key Metrics Cards -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
                
                <!-- Total Balance Card -->
                <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 1.5rem; border-radius: 1rem; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem;">
                        <div>
                            <p style="font-size: 0.875rem; opacity: 0.9; margin: 0;">Net Balance</p>
                            <p style="font-size: 2rem; font-weight: 700; margin: 0.5rem 0 0 0;">
                                ${{ number_format($netBalance, 2) }}
                            </p>
                        </div>
                        <div style="background: rgba(255,255,255,0.2); padding: 0.75rem; border-radius: 50%;">
                            <span style="font-size: 1.5rem;">💰</span>
                        </div>
                    </div>
                    <p style="font-size: 0.75rem; opacity: 0.8; margin: 0;">
                        All-time income minus expenses
                    </p>
                </div>

                <!-- Monthly Income -->
                <div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; padding: 1.5rem; border-radius: 1rem; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem;">
                        <div>
                            <p style="font-size: 0.875rem; opacity: 0.9; margin: 0;">This Month Income</p>
                            <p style="font-size: 2rem; font-weight: 700; margin: 0.5rem 0 0 0; color: #dcfce7;">
                                +${{ number_format($monthlyIncome, 2) }}
                            </p>
                        </div>
                        <div style="background: rgba(255,255,255,0.2); padding: 0.75rem; border-radius: 50%;">
                            <span style="font-size: 1.5rem;">📈</span>
                        </div>
                    </div>
                    <p style="font-size: 0.75rem; opacity: 0.8; margin: 0;">
                        {{ $currentMonth->format('F Y') }} earnings
                    </p>
                </div>

                <!-- Monthly Expenses -->
                <div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; padding: 1.5rem; border-radius: 1rem; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem;">
                        <div>
                            <p style="font-size: 0.875rem; opacity: 0.9; margin: 0;">This Month Expenses</p>
                            <p style="font-size: 2rem; font-weight: 700; margin: 0.5rem 0 0 0; color: #fecaca;">
                                -${{ number_format($monthlyExpenses, 2) }}
                            </p>
                        </div>
                        <div style="background: rgba(255,255,255,0.2); padding: 0.75rem; border-radius: 50%;">
                            <span style="font-size: 1.5rem;">📊</span>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <span style="font-size: 0.75rem; opacity: 0.8;">
                            {{ $expenseChange >= 0 ? '↗️' : '↘️' }} 
                            {{ abs(round($expenseChange, 1)) }}% vs last month
                        </span>
                    </div>
                </div>

                <!-- Savings Rate -->
                <div style="background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%); color: #1f2937; padding: 1.5rem; border-radius: 1rem; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem;">
                        <div>
                            <p style="font-size: 0.875rem; color: #6b7280; margin: 0;">Savings Rate</p>
                            <p style="font-size: 2rem; font-weight: 700; margin: 0.5rem 0 0 0; color: {{ $savingsRate >= 20 ? '#10b981' : ($savingsRate >= 10 ? '#f59e0b' : '#dc2626') }};">
                                {{ round($savingsRate, 1) }}%
                            </p>
                        </div>
                        <div style="background: rgba(255,255,255,0.3); padding: 0.75rem; border-radius: 50%;">
                            <span style="font-size: 1.5rem;">🎯</span>
                        </div>
                    </div>
                    <p style="font-size: 0.75rem; color: #6b7280; margin: 0;">
                        {{ $savingsRate >= 20 ? 'Excellent!' : ($savingsRate >= 10 ? 'Good progress' : 'Needs improvement') }}
                    </p>
                </div>
            </div>

            <!-- Charts and Analysis Row -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
                
                <!-- Monthly Spending Trend Chart -->
                <div style="background-color: white; border-radius: 1rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); padding: 1.5rem;">
                    <h3 style="font-size: 1.25rem; font-weight: 600; color: #1f2937; margin: 0 0 1.5rem 0;">Spending Trend</h3>
                    <div style="position: relative; height: 250px;">
                        <canvas id="spendingTrendChart"></canvas>
                    </div>
                </div>

                <!-- Expenses by Category Pie Chart -->
                <div style="background-color: white; border-radius: 1rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); padding: 1.5rem;">
                    <h3 style="font-size: 1.25rem; font-weight: 600; color: #1f2937; margin: 0 0 1.5rem 0;">This Month by Category</h3>
                    @if($expensesByCategory->count() > 0)
                        <div style="position: relative; height: 250px;">
                            <canvas id="categoryPieChart"></canvas>
                        </div>
                    @else
                        <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 250px; color: #9ca3af;">
                            <span style="font-size: 3rem; margin-bottom: 1rem;">📊</span>
                            <p style="margin: 0; text-align: center;">No expenses this month yet</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recent Transactions and Top Categories -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
                
                <!-- Recent Transactions -->
                <div style="background-color: white; border-radius: 1rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); padding: 1.5rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                        <h3 style="font-size: 1.25rem; font-weight: 600; color: #1f2937; margin: 0;">Recent Activity</h3>
                        <div style="display: flex; gap: 0.5rem;">
                            <a href="{{ route('incomes.index') }}" style="color: #10b981; font-size: 0.875rem; text-decoration: none;">All Income</a>
                            <span style="color: #d1d5db;">|</span>
                            <a href="{{ route('expenses.index') }}" style="color: #dc2626; font-size: 0.875rem; text-decoration: none;">All Expenses</a>
                        </div>
                    </div>
                    
                    <div style="max-height: 300px; overflow-y: auto;">
                        @foreach($recentIncomes->take(3) as $income)
                            <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid #f3f4f6;">
                                <div style="display: flex; align-items: center; gap: 0.75rem;">
                                    <div style="width: 2rem; height: 2rem; background-color: #dcfce7; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                        <span style="color: #16a34a; font-size: 0.875rem;">💰</span>
                                    </div>
                                    <div>
                                        <p style="font-weight: 500; color: #1f2937; margin: 0; font-size: 0.875rem;">{{ $income->title }}</p>
                                        <p style="color: #9ca3af; font-size: 0.75rem; margin: 0;">{{ $income->date->format('M d') }}</p>
                                    </div>
                                </div>
                                <p style="color: #10b981; font-weight: 600; margin: 0; font-size: 0.875rem;">+${{ number_format($income->amount, 2) }}</p>
                            </div>
                        @endforeach
                        
                        @foreach($recentExpenses->take(3) as $expense)
                            <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid #f3f4f6;">
                                <div style="display: flex; align-items: center; gap: 0.75rem;">
                                    <div style="width: 2rem; height: 2rem; background-color: {{ $expense->category ? $expense->category->color : '#f3f4f6' }}; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                        <span style="color: white; font-size: 0.75rem; font-weight: 600;">
                                            {{ $expense->category ? strtoupper(substr($expense->category->name, 0, 1)) : 'E' }}
                                        </span>
                                    </div>
                                    <div>
                                        <p style="font-weight: 500; color: #1f2937; margin: 0; font-size: 0.875rem;">{{ $expense->title }}</p>
                                        <p style="color: #9ca3af; font-size: 0.75rem; margin: 0;">
                                            {{ $expense->date->format('M d') }} • {{ $expense->category ? $expense->category->name : 'Uncategorized' }}
                                        </p>
                                    </div>
                                </div>
                                <p style="color: #dc2626; font-weight: 600; margin: 0; font-size: 0.875rem;">-${{ number_format($expense->amount, 2) }}</p>
                            </div>
                        @endforeach
                        
                        @if($recentIncomes->isEmpty() && $recentExpenses->isEmpty())
                            <div style="text-align: center; padding: 2rem; color: #9ca3af;">
                                <p style="margin: 0;">No recent transactions</p>
                                <div style="margin-top: 1rem; display: flex; gap: 0.5rem; justify-content: center;">
                                    <a href="{{ route('incomes.create') }}" style="background-color: #10b981; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; font-size: 0.875rem;">Add Income</a>
                                    <a href="{{ route('expenses.create') }}" style="background-color: #dc2626; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none; font-size: 0.875rem;">Add Expense</a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Top Categories -->
                <div style="background-color: white; border-radius: 1rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); padding: 1.5rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                        <h3 style="font-size: 1.25rem; font-weight: 600; color: #1f2937; margin: 0;">Top Spending Categories</h3>
                        <a href="{{ route('categories.index') }}" style="color: #6366f1; font-size: 0.875rem; text-decoration: none;">Manage</a>
                    </div>
                    
                    @if($topCategories->count() > 0)
                        @foreach($topCategories as $categoryData)
                            @if($categoryData->category)
                                <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid #f3f4f6;">
                                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                                        <div style="width: 2.5rem; height: 2.5rem; background-color: {{ $categoryData->category->color }}; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                            <span style="color: white; font-size: 0.875rem; font-weight: 600;">
                                                {{ strtoupper(substr($categoryData->category->name, 0, 1)) }}
                                            </span>
                                        </div>
                                        <div>
                                            <p style="font-weight: 500; color: #1f2937; margin: 0; font-size: 0.875rem;">{{ $categoryData->category->name }}</p>
                                            <p style="color: #9ca3af; font-size: 0.75rem; margin: 0;">{{ $categoryData->count }} transaction{{ $categoryData->count === 1 ? '' : 's' }}</p>
                                        </div>
                                    </div>
                                    <div style="text-align: right;">
                                        <p style="color: #dc2626; font-weight: 600; margin: 0; font-size: 0.875rem;">-${{ number_format($categoryData->total, 2) }}</p>
                                        <div style="width: 80px; height: 4px; background-color: #f3f4f6; border-radius: 2px; margin-top: 0.25rem;">
                                            <div style="width: {{ min(100, ($categoryData->total / $topCategories->first()->total) * 100) }}%; height: 100%; background-color: {{ $categoryData->category->color }}; border-radius: 2px;"></div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @else
                        <div style="text-align: center; padding: 2rem; color: #9ca3af;">
                            <span style="font-size: 3rem; margin-bottom: 1rem; display: block;">🏷️</span>
                            <p style="margin: 0;">No spending categories yet</p>
                            <a href="{{ route('categories.create') }}" style="color: #6366f1; text-decoration: none; font-size: 0.875rem; margin-top: 0.5rem; display: inline-block;">Create your first category</a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 1rem; padding: 2rem; text-align: center;">
                <h3 style="color: white; font-size: 1.5rem; font-weight: 600; margin: 0 0 1rem 0;">Quick Actions</h3>
                <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                    <a href="{{ route('incomes.create') }}" style="background: rgba(255,255,255,0.2); color: white; padding: 0.75rem 1.5rem; border-radius: 0.5rem; text-decoration: none; font-weight: 500; backdrop-filter: blur(10px);">
                        💰 Add Income
                    </a>
                    <a href="{{ route('expenses.create') }}" style="background: rgba(255,255,255,0.2); color: white; padding: 0.75rem 1.5rem; border-radius: 0.5rem; text-decoration: none; font-weight: 500; backdrop-filter: blur(10px);">
                        💳 Add Expense
                    </a>
                    <a href="{{ route('categories.create') }}" style="background: rgba(255,255,255,0.2); color: white; padding: 0.75rem 1.5rem; border-radius: 0.5rem; text-decoration: none; font-weight: 500; backdrop-filter: blur(10px);">
                        🏷️ New Category
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script>
        // Monthly Spending Trend Chart with proper scaling
        const spendingCtx = document.getElementById('spendingTrendChart');
        
        if (spendingCtx) {
            const expenseData = {!! json_encode(array_column($monthlyTrend, 'amount')) !!};
            const maxExpense = Math.max(...expenseData, 0);
            const yAxisMax = maxExpense > 0 ? Math.ceil(maxExpense * 1.2) : 100;
            
            new Chart(spendingCtx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode(array_column($monthlyTrend, 'month')) !!},
                    datasets: [{
                        label: 'Monthly Expenses',
                        data: expenseData,
                        backgroundColor: 'rgba(220, 38, 38, 0.8)',
                        borderColor: '#dc2626',
                        borderWidth: 2,
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { 
                            display: false 
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return '$' + context.parsed.y.toFixed(2);
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            min: 0,
                            max: yAxisMax,
                            ticks: {
                                callback: function(value) {
                                    return '$' + value;
                                }
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        }

        // Category Pie Chart
        @if($expensesByCategory->count() > 0)
            const categoryCtx = document.getElementById('categoryPieChart');
            
            if (categoryCtx) {
                new Chart(categoryCtx, {
                    type: 'doughnut',
                    data: {
                        labels: {!! json_encode($expensesByCategory->pluck('category.name')) !!},
                        datasets: [{
                            data: {!! json_encode($expensesByCategory->pluck('total')) !!},
                            backgroundColor: {!! json_encode($expensesByCategory->pluck('category.color')) !!},
                            borderWidth: 3,
                            borderColor: '#ffffff'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 15,
                                    usePointStyle: true,
                                    font: {
                                        size: 12
                                    }
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const label = context.label || '';
                                        const value = context.parsed || 0;
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = ((value / total) * 100).toFixed(1);
                                        return label + ': $' + value.toFixed(2) + ' (' + percentage + '%)';
                                    }
                                }
                            }
                        }
                    }
                });
            }
        @endif
    </script>
</x-app-layout>