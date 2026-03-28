@guest
    @include('auth.login')
@else
    @extends('layouts2.app')

    @section('content')
     <!-- Display Success or Error Messages -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @elseif(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

    <!-- Dashboard Container -->

    <div class="dashboard-container">
        <!-- Header Section -->
        <div class="dashboard-header">
            <div class="header-title">
                <i class="fas fa-chart-pie"></i>
                <h1>Offenses Analytics</h1>
            </div>
            <div class="header-date">
                <i class="fas fa-calendar-alt"></i>
                <span>{{ date('F j, Y') }}</span>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="stats-grid">
            @if(Auth::check() && Auth::user()->role != 'user')
                <div class="stat-card stat-card-primary">
                    <div class="stat-icon">
                        <i class="fas fa-gavel"></i>
                    </div>
                    <div class="stat-content">
                        <h3>Total Offenses</h3>
                        <p class="stat-number">{{ number_format($totalOffenseCount) }}</p>
                        <span class="stat-trend">All time records</span>
                    </div>
                </div>
                
                <div class="stat-card stat-card-danger">
                    <div class="stat-icon">
                        <i class="fas fa-calendar-day"></i>
                    </div>
                    <div class="stat-content">
                        <h3>Today's Offenses</h3>
                        <p class="stat-number">{{ number_format($todayOffenseCount) }}</p>
                        <span class="stat-trend">Updated daily</span>
                    </div>
                </div>
            @else
                <div class="stat-card stat-card-info">
                    <div class="stat-icon">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <div class="stat-content">
                        <h3>My Offenses</h3>
                        <p class="stat-number">{{ number_format($userOffenseCount) }}</p>
                        <span class="stat-trend">Total records</span>
                    </div>
                </div>
                
                <div class="stat-card stat-card-warning">
                    <div class="stat-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-content">
                        <h3>Unpaid Offenses</h3>
                        <p class="stat-number">{{ number_format($unpaidOffenseCount) }}</p>
                        <span class="stat-trend">Pending payment</span>
                    </div>
                </div>
            @endif
        </div>

        <!-- Chart Section -->
        <div class="chart-section">
            <div class="chart-header">
                <div class="chart-title">
                    <i class="fas fa-chart-bar"></i>
                    <h3>Offense Distribution</h3>
                </div>
                <div class="chart-legend">
                    @if(Auth::check() && Auth::user()->role != 'user')
                        <span class="legend-item">
                            <span class="legend-color total-color"></span>
                            Total Offenses
                        </span>
                        <span class="legend-item">
                            <span class="legend-color today-color"></span>
                            Today's Offenses
                        </span>
                    @else
                        <span class="legend-item">
                            <span class="legend-color total-color"></span>
                            My Offenses
                        </span>
                        <span class="legend-item">
                            <span class="legend-color today-color"></span>
                            Unpaid Offenses
                        </span>
                    @endif
                </div>
            </div>
            
            <div class="chart-container">
                <canvas id="offensesChart"></canvas>
            </div>
            
            <!-- Stats Insights -->
            @php
                if(Auth::check() && Auth::user()->role != 'user') {
                    $percentage = $totalOffenseCount > 0 ? round(($todayOffenseCount / $totalOffenseCount) * 100, 1) : 0;
                    $comparison = $todayOffenseCount > ($totalOffenseCount / 30) ? 'above' : 'below';
                    $message = $comparison == 'above' ? 'Above daily average' : 'Below daily average';
                    $icon = $comparison == 'above' ? 'exclamation-triangle' : 'check-circle';
                    $color = $comparison == 'above' ? '#e53e3e' : '#38a169';
                } else {
                    $percentage = $userOffenseCount > 0 ? round(($unpaidOffenseCount / $userOffenseCount) * 100, 1) : 0;
                    $comparison = $unpaidOffenseCount > ($userOffenseCount / 30) ? 'above' : 'below';
                    $message = $comparison == 'above' ? 'Above daily average' : 'Below daily average';
                    $icon = $comparison == 'above' ? 'exclamation-triangle' : 'check-circle';
                    $color = $comparison == 'above' ? '#e53e3e' : '#38a169';
                }
            @endphp
            
            <div class="chart-footer">
                <div class="insight-card">
                    <i class="fas fa-percent"></i>
                    <div class="insight-content">
                        <span class="insight-label">Today's Share</span>
                        <strong class="insight-value">{{ $percentage }}%</strong>
                    </div>
                </div>
                
                <div class="insight-card" style="border-left-color: {{ $color }}">
                    <i class="fas fa-{{ $icon }}" style="color: {{ $color }}"></i>
                    <div class="insight-content">
                        <span class="insight-label">Trend Analysis</span>
                        <strong class="insight-value" style="color: {{ $color }}">{{ $message }}</strong>
                    </div>
                </div>
                
                <button onclick="refreshChart()" class="refresh-btn">
                    <i class="fas fa-sync-alt"></i>
                    Refresh Data
                </button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('offensesChart').getContext('2d');
            
            @if(Auth::check() && Auth::user()->role != 'user')
                const chartData = {
                    labels: ['Total Offenses', 'Today\'s Offenses'],
                    values: [{{ $totalOffenseCount }}, {{ $todayOffenseCount }}],
                    colors: ['#3b82f6', '#ef4444']
                };
            @else
                const chartData = {
                    labels: ['My Offenses', 'Unpaid Offenses'],
                    values: [{{ $userOffenseCount }}, {{ $unpaidOffenseCount }}],
                    colors: ['#10b981', '#f59e0b']
                };
            @endif
            
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: chartData.labels,
                    datasets: [{
                        label: 'Number of Offenses',
                        data: chartData.values,
                        backgroundColor: chartData.colors,
                        borderRadius: 8,
                        barPercentage: 0.5,
                        categoryPercentage: 0.7,
                        borderWidth: 0,
                        hoverOffset: 4
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
                            backgroundColor: '#1f2937',
                            titleColor: '#f3f4f6',
                            bodyColor: '#d1d5db',
                            borderColor: '#374151',
                            borderWidth: 1,
                            padding: 12,
                            cornerRadius: 8,
                            callbacks: {
                                label: function(context) {
                                    const value = context.parsed.y;
                                    return `Offenses: ${value.toLocaleString()}`;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#e5e7eb',
                                drawBorder: false,
                                lineWidth: 1
                            },
                            ticks: {
                                stepSize: Math.ceil(Math.max(...chartData.values) / 5),
                                callback: function(value) {
                                    return value.toLocaleString();
                                },
                                color: '#6b7280'
                            },
                            title: {
                                display: true,
                                text: 'Number of Offenses',
                                color: '#6b7280',
                                font: {
                                    size: 12,
                                    weight: '500'
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#374151',
                                font: {
                                    size: 13,
                                    weight: '600'
                                }
                            }
                        }
                    },
                    layout: {
                        padding: {
                            top: 20,
                            bottom: 10
                        }
                    },
                    onClick: function(e, item) {
                        if(item.length > 0) {
                            const index = item[0].dataIndex;
                            const label = this.data.labels[index];
                            const value = this.data.datasets[0].data[index];
                            
                            // You can replace this with a modal for better UX
                            alert(`${label}\nTotal: ${value.toLocaleString()} offenses`);
                        }
                    }
                }
            });
        });
        
        function refreshChart() {
            const btn = document.querySelector('.refresh-btn');
            btn.style.opacity = '0.7';
            btn.disabled = true;
            
            setTimeout(() => {
                location.reload();
            }, 300);
        }
    </script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        .dashboard-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 30px 20px;
        }
        
        /* Header Styles */
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
            flex-wrap: wrap;
            gap: 20px;
        }
        
        .header-title {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .header-title i {
            font-size: 32px;
            color: #3b82f6;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .header-title h1 {
            font-size: 28px;
            font-weight: 700;
            color: #111827;
            margin: 0;
        }
        
        .header-date {
            background: #f3f4f6;
            padding: 10px 20px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: #4b5563;
            font-weight: 500;
        }
        
        .header-date i {
            font-size: 18px;
            color: #3b82f6;
        }
        
        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }
        
        .stat-card {
            background: white;
            border-radius: 20px;
            padding: 25px;
            display: flex;
            align-items: center;
            gap: 20px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
            border: 1px solid #e5e7eb;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
        }
        
        .stat-card-primary .stat-icon {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
        }
        
        .stat-card-danger .stat-icon {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
        }
        
        .stat-card-info .stat-icon {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
        }
        
        .stat-card-warning .stat-icon {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
        }
        
        .stat-content {
            flex: 1;
        }
        
        .stat-content h3 {
            font-size: 14px;
            font-weight: 600;
            color: #6b7280;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .stat-number {
            font-size: 32px;
            font-weight: 800;
            color: #111827;
            margin-bottom: 5px;
            line-height: 1;
        }
        
        .stat-trend {
            font-size: 12px;
            color: #9ca3af;
        }
        
        /* Chart Section */
        .chart-section {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            border: 1px solid #e5e7eb;
        }
        
        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 20px;
            padding-bottom: 20px;
            border-bottom: 2px solid #f3f4f6;
        }
        
        .chart-title {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .chart-title i {
            font-size: 24px;
            color: #3b82f6;
        }
        
        .chart-title h3 {
            font-size: 20px;
            font-weight: 700;
            color: #111827;
            margin: 0;
        }
        
        .chart-legend {
            display: flex;
            gap: 20px;
        }
        
        .legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            color: #6b7280;
            font-weight: 500;
        }
        
        .legend-color {
            width: 12px;
            height: 12px;
            border-radius: 3px;
        }
        
        .total-color {
            background: #3b82f6;
        }
        
        .today-color {
            background: #ef4444;
        }
        
        .chart-container {
            position: relative;
            height: 400px;
            margin-bottom: 30px;
        }
        
        .chart-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
            padding-top: 20px;
            border-top: 2px solid #f3f4f6;
        }
        
        .insight-card {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px 20px;
            background: #f9fafb;
            border-radius: 12px;
            border-left: 4px solid #3b82f6;
        }
        
        .insight-card i {
            font-size: 28px;
            color: #3b82f6;
        }
        
        .insight-content {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        
        .insight-label {
            font-size: 12px;
            color: #6b7280;
            font-weight: 500;
        }
        
        .insight-value {
            font-size: 20px;
            font-weight: 700;
            color: #111827;
        }
        
        .refresh-btn {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
        }
        
        .refresh-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3);
        }
        
        .refresh-btn:active {
            transform: translateY(0);
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .dashboard-container {
                padding: 20px 15px;
            }
            
            .header-title h1 {
                font-size: 24px;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }
            
            .stat-card {
                padding: 20px;
            }
            
            .chart-section {
                padding: 20px;
            }
            
            .chart-container {
                height: 300px;
            }
            
            .chart-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .chart-footer {
                flex-direction: column;
                align-items: stretch;
            }
            
            .insight-card {
                justify-content: center;
            }
            
            .refresh-btn {
                justify-content: center;
            }
        }
        
        /* Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .stat-card, .chart-section {
            animation: fadeInUp 0.5s ease-out;
        }
        
        .stat-card:nth-child(2) {
            animation-delay: 0.1s;
        }
    </style>
    @endsection
@endguest