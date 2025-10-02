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
            
            <!-- Quick Actions - Modern & Prominent -->
            <div style="background: linear-gradient(135deg, #059669 0%, #047857 100%); border-radius: 1.5rem; padding: 2.5rem; margin-bottom: 2.5rem; box-shadow: 0 10px 30px rgba(5, 150, 105, 0.25);">
                <h3 style="color: white; font-size: 1.75rem; font-weight: 700; margin: 0 0 1.75rem 0; text-align: center; letter-spacing: -0.025em;">Quick Actions</h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.5rem; max-width: 1000px; margin: 0 auto;">
                    <a href="{{ route('incomes.create') }}" style="background: white; color: #047857; padding: 1.75rem 2rem; border-radius: 1rem; text-decoration: none; font-weight: 600; font-size: 1.125rem; text-align: center; transition: all 0.3s; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08); display: flex; flex-direction: column; align-items: center; gap: 0.875rem; border: 2px solid transparent;">
                        <span style="font-size: 2.75rem;">💰</span>
                        <span>Add Income</span>
                    </a>
                    <a href="{{ route('expenses.create') }}" style="background: white; color: #047857; padding: 1.75rem 2rem; border-radius: 1rem; text-decoration: none; font-weight: 600; font-size: 1.125rem; text-align: center; transition: all 0.3s; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08); display: flex; flex-direction: column; align-items: center; gap: 0.875rem; border: 2px solid transparent;">
                        <span style="font-size: 2.75rem;">💳</span>
                        <span>Add Expense</span>
                    </a>
                    <a href="{{ route('categories.create') }}" style="background: white; color: #047857; padding: 1.75rem 2rem; border-radius: 1rem; text-decoration: none; font-weight: 600; font-size: 1.125rem; text-align: center; transition: all 0.3s; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08); display: flex; flex-direction: column; align-items: center; gap: 0.875rem; border: 2px solid transparent;">
                        <span style="font-size: 2.75rem;">🏷️</span>
                        <span>New Category</span>
                    </a>
                </div>
            </div>

            <!-- Key Metrics Cards - Colorful & Modern -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
                
                <!-- Net Balance - Emerald -->
                <div style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; padding: 1.75rem; border-radius: 1.25rem; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25); position: relative; overflow: hidden;">
                    <div style="position: absolute; top: -20px; right: -20px; width: 100px; height: 100px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem; position: relative;">
                        <div>
                            <p style="font-size: 0.875rem; opacity: 0.95; margin: 0; font-weight: 500;">Net Balance</p>
                            <p style="font-size: 2.25rem; font-weight: 700; margin: 0.5rem 0 0 0; letter-spacing: -0.025em;">
                                ${{ number_format($netBalance, 2) }}
                            </p>
                        </div>
                        <div style="background: rgba(255,255,255,0.25); padding: 0.875rem; border-radius: 1rem;">
                            <span style="font-size: 1.75rem;">💰</span>
                        </div>
                    </div>
                    <p style="font-size: 0.8rem; opacity: 0.85; margin: 0;">
                        All-time income minus expenses
                    </p>
                </div>

                <!-- Monthly Income - Blue -->
                <div style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; padding: 1.75rem; border-radius: 1.25rem; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.25); position: relative; overflow: hidden;">
                    <div style="position: absolute; top: -20px; right: -20px; width: 100px; height: 100px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem; position: relative;">
                        <div>
                            <p style="font-size: 0.875rem; opacity: 0.95; margin: 0; font-weight: 500;">This Month Income</p>
                            <p style="font-size: 2.25rem; font-weight: 700; margin: 0.5rem 0 0 0; letter-spacing: -0.025em;">
                                +${{ number_format($monthlyIncome, 2) }}
                            </p>
                        </div>
                        <div style="background: rgba(255,255,255,0.25); padding: 0.875rem; border-radius: 1rem;">
                            <span style="font-size: 1.75rem;">📈</span>
                        </div>
                    </div>
                    <p style="font-size: 0.8rem; opacity: 0.85; margin: 0;">
                        {{ $currentMonth->format('F Y') }} earnings
                    </p>
                </div>

                <!-- Monthly Expenses - Purple -->
                <div style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); color: white; padding: 1.75rem; border-radius: 1.25rem; box-shadow: 0 4px 12px rgba(139, 92, 246, 0.25); position: relative; overflow: hidden;">
                    <div style="position: absolute; top: -20px; right: -20px; width: 100px; height: 100px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem; position: relative;">
                        <div>
                            <p style="font-size: 0.875rem; opacity: 0.95; margin: 0; font-weight: 500;">This Month Expenses</p>
                            <p style="font-size: 2.25rem; font-weight: 700; margin: 0.5rem 0 0 0; letter-spacing: -0.025em;">
                                -${{ number_format($monthlyExpenses, 2) }}
                            </p>
                        </div>
                        <div style="background: rgba(255,255,255,0.25); padding: 0.875rem; border-radius: 1rem;">
                            <span style="font-size: 1.75rem;">📊</span>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <span style="font-size: 0.8rem; opacity: 0.85;">
                            {{ $expenseChange >= 0 ? '↗️' : '↘️' }} 
                            {{ abs(round($expenseChange, 1)) }}% vs last month
                        </span>
                    </div>
                </div>

                <!-- Savings Rate - Orange/Amber -->
                <div style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; padding: 1.75rem; border-radius: 1.25rem; box-shadow: 0 4px 12px rgba(245, 158, 11, 0.25); position: relative; overflow: hidden;">
                    <div style="position: absolute; top: -20px; right: -20px; width: 100px; height: 100px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem; position: relative;">
                        <div>
                            <p style="font-size: 0.875rem; opacity: 0.95; margin: 0; font-weight: 500;">Savings Rate</p>
                            <p style="font-size: 2.25rem; font-weight: 700; margin: 0.5rem 0 0 0; letter-spacing: -0.025em;">
                                {{ round($savingsRate, 1) }}%
                            </p>
                        </div>
                        <div style="background: rgba(255,255,255,0.25); padding: 0.875rem; border-radius: 1rem;">
                            <span style="font-size: 1.75rem;">🎯</span>
                        </div>
                    </div>
                    <p style="font-size: 0.8rem; opacity: 0.85; margin: 0;">
                        {{ $savingsRate >= 20 ? 'Excellent!' : ($savingsRate >= 10 ? 'Good progress' : 'Keep going!') }}
                    </p>
                </div>
            </div>

            <!-- Charts and Analysis Row -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
                
                <!-- Monthly Spending Trend Chart -->
                <div style="background-color: white; border-radius: 1.25rem; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06); padding: 2rem; border: 1px solid #f3f4f6;">
                    <h3 style="font-size: 1.25rem; font-weight: 600; color: #1f2937; margin: 0 0 1.75rem 0;">Spending Trend</h3>
                    <div style="position: relative; height: 250px;">
                        <canvas id="spendingTrendChart"></canvas>
                    </div>
                </div>

                <!-- Expenses by Category Pie Chart -->
                <div style="background-color: white; border-radius: 1.25rem; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06); padding: 2rem; border: 1px solid #f3f4f6;">
                    <h3 style="font-size: 1.25rem; font-weight: 600; color: #1f2937; margin: 0 0 1.75rem 0;">This Month by Category</h3>
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
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                
                <!-- Recent Transactions -->
                <div style="background-color: white; border-radius: 1.25rem; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06); padding: 2rem; border: 1px solid #f3f4f6;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.75rem;">
                        <h3 style="font-size: 1.25rem; font-weight: 600; color: #1f2937; margin: 0;">Recent Activity</h3>
                        <div style="display: flex; gap: 0.5rem;">
                            <a href="{{ route('incomes.index') }}" style="color: #059669; font-size: 0.875rem; text-decoration: none; font-weight: 500;">All Income</a>
                            <span style="color: #d1d5db;">|</span>
                            <a href="{{ route('expenses.index') }}" style="color: #8b5cf6; font-size: 0.875rem; text-decoration: none; font-weight: 500;">All Expenses</a>
                        </div>
                    </div>
                    
                    <div style="max-height: 300px; overflow-y: auto;">
                        @foreach($recentIncomes->take(3) as $income)
                            <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.875rem 0; border-bottom: 1px solid #f3f4f6;">
                                <div style="display: flex; align-items: center; gap: 0.875rem;">
                                    <div style="width: 2.5rem; height: 2.5rem; background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 0.75rem; display: flex; align-items: center; justify-content: center;">
                                        <span style="font-size: 1rem;">💰</span>
                                    </div>
                                    <div>
                                        <p style="font-weight: 500; color: #1f2937; margin: 0; font-size: 0.9rem;">{{ $income->title }}</p>
                                        <p style="color: #9ca3af; font-size: 0.75rem; margin: 0;">{{ $income->date->format('M d') }}</p>
                                    </div>
                                </div>
                                <p style="color: #10b981; font-weight: 600; margin: 0; font-size: 0.9rem;">+${{ number_format($income->amount, 2) }}</p>
                            </div>
                        @endforeach
                        
                        @foreach($recentExpenses->take(3) as $expense)
                            <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.875rem 0; border-bottom: 1px solid #f3f4f6;">
                                <div style="display: flex; align-items: center; gap: 0.875rem;">
                                    <div style="width: 2.5rem; height: 2.5rem; background-color: {{ $expense->category ? $expense->category->color : '#e5e7eb' }}; border-radius: 0.75rem; display: flex; align-items: center; justify-content: center;">
                                        <span style="color: white; font-size: 0.875rem; font-weight: 600;">
                                            {{ $expense->category ? strtoupper(substr($expense->category->name, 0, 1)) : 'E' }}
                                        </span>
                                    </div>
                                    <div>
                                        <p style="font-weight: 500; color: #1f2937; margin: 0; font-size: 0.9rem;">{{ $expense->title }}</p>
                                        <p style="color: #9ca3af; font-size: 0.75rem; margin: 0;">
                                            {{ $expense->date->format('M d') }} • {{ $expense->category ? $expense->category->name : 'Uncategorized' }}
                                        </p>
                                    </div>
                                </div>
                                <p style="color: #8b5cf6; font-weight: 600; margin: 0; font-size: 0.9rem;">-${{ number_format($expense->amount, 2) }}</p>
                            </div>
                        @endforeach
                        
                        @if($recentIncomes->isEmpty() && $recentExpenses->isEmpty())
                            <div style="text-align: center; padding: 2rem; color: #9ca3af;">
                                <p style="margin: 0;">No recent transactions</p>
                                <div style="margin-top: 1rem; display: flex; gap: 0.75rem; justify-content: center;">
                                    <a href="{{ route('incomes.create') }}" style="background-color: #10b981; color: white; padding: 0.625rem 1.25rem; border-radius: 0.5rem; text-decoration: none; font-size: 0.875rem; font-weight: 500;">Add Income</a>
                                    <a href="{{ route('expenses.create') }}" style="background-color: #8b5cf6; color: white; padding: 0.625rem 1.25rem; border-radius: 0.5rem; text-decoration: none; font-size: 0.875rem; font-weight: 500;">Add Expense</a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Top Categories -->
                <div style="background-color: white; border-radius: 1.25rem; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06); padding: 2rem; border: 1px solid #f3f4f6;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.75rem;">
                        <h3 style="font-size: 1.25rem; font-weight: 600; color: #1f2937; margin: 0;">Top Spending Categories</h3>
                        <a href="{{ route('categories.index') }}" style="color: #059669; font-size: 0.875rem; text-decoration: none; font-weight: 500;">Manage</a>
                    </div>
                    
                    @if($topCategories->count() > 0)
                        @foreach($topCategories as $categoryData)
                            @if($categoryData->category)
                                <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.875rem 0; border-bottom: 1px solid #f3f4f6;">
                                    <div style="display: flex; align-items: center; gap: 0.875rem;">
                                        <div style="width: 2.75rem; height: 2.75rem; background-color: {{ $categoryData->category->color }}; border-radius: 0.75rem; display: flex; align-items: center; justify-content: center;">
                                            <span style="color: white; font-size: 1rem; font-weight: 600;">
                                                {{ strtoupper(substr($categoryData->category->name, 0, 1)) }}
                                            </span>
                                        </div>
                                        <div>
                                            <p style="font-weight: 500; color: #1f2937; margin: 0; font-size: 0.9rem;">{{ $categoryData->category->name }}</p>
                                            <p style="color: #9ca3af; font-size: 0.75rem; margin: 0;">{{ $categoryData->count }} transaction{{ $categoryData->count === 1 ? '' : 's' }}</p>
                                        </div>
                                    </div>
                                    <div style="text-align: right;">
                                        <p style="color: #1f2937; font-weight: 600; margin: 0; font-size: 0.9rem;">${{ number_format($categoryData->total, 2) }}</p>
                                        <div style="width: 80px; height: 5px; background-color: #f3f4f6; border-radius: 3px; margin-top: 0.375rem;">
                                            <div style="width: {{ min(100, ($categoryData->total / $topCategories->first()->total) * 100) }}%; height: 100%; background-color: {{ $categoryData->category->color }}; border-radius: 3px;"></div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @else
                        <div style="text-align: center; padding: 2rem; color: #9ca3af;">
                            <span style="font-size: 3rem; margin-bottom: 1rem; display: block;">🏷️</span>
                            <p style="margin: 0;">No spending categories yet</p>
                            <a href="{{ route('categories.create') }}" style="color: #059669; text-decoration: none; font-size: 0.875rem; margin-top: 0.75rem; display: inline-block; font-weight: 500;">Create your first category</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script>
        // Monthly Spending Trend Chart
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
                        backgroundColor: 'rgba(139, 92, 246, 0.8)',
                        borderColor: '#8b5cf6',
                        borderWidth: 2,
                        borderRadius: 8
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
                            borderWidth: 4,
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