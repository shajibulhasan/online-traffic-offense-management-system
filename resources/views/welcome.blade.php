@guest
    @include('auth.login')
@else
    @extends('layouts2.app')

    @section('content')

    <!-- Total offenses vs Today offenses graph -->
    <div class="recent-box" style="margin-top: 30px; background: linear-gradient(135deg, #667eea 0%, #06c22f 100%); border-radius: 20px; padding: 20px; box-shadow: 0 20px 40px rgba(0,0,0,0.1);">
        <div class="recent-title" style="color: white; font-size: 1.2rem; font-weight: 600; margin-bottom: 20px; display: flex; align-items: center;">
            <i class="fas fa-chart-line" style="margin-right: 12px; color: #ffd700; font-size: 1.5rem;"></i> 
            Offenses Analytics Dashboard
            <span style="margin-left: auto; font-size: 0.9rem; background: rgba(255,255,255,0.2); padding: 5px 15px; border-radius: 20px;">
                <i class="fas fa-calendar-alt" style="margin-right: 5px;"></i> Live Updates
            </span>
        </div>
        
        <!-- Stats Cards -->
        <div style="display: flex; gap: 20px; margin-bottom: 25px;">
            <div style="flex: 1; background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); border-radius: 15px; padding: 20px; border: 1px solid rgba(255,255,255,0.2);">
                @if(Auth::check() && Auth::user()->role != 'user')
                <div style="color: rgba(255,255,255,0.8); font-size: 0.9rem; margin-bottom: 8px;">Total Offenses</div>
                <div style="color: white; font-size: 2.5rem; font-weight: 700; line-height: 1;">{{ $totalOffenseCount }}</div>
                @else
                <div style="color: rgba(255,255,255,0.8); font-size: 0.9rem; margin-bottom: 8px;">My Offenses</div>
                <div style="color: white; font-size: 2.5rem; font-weight: 700; line-height: 1;">{{ $userOffenseCount }}</div>
                @endif
                <div style="color: rgba(255,255,255,0.6); font-size: 0.8rem; margin-top: 8px;">
                    <i class="fas fa-arrow-up" style="color: #4ade80; margin-right: 5px;"></i> All time records
                </div>
            </div>
            <div style="flex: 1; background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); border-radius: 15px; padding: 20px; border: 1px solid rgba(255,255,255,0.2);">
                @if(Auth::check() && Auth::user()->role != 'user')
                <div style="color: rgba(255,255,255,0.8); font-size: 0.9rem; margin-bottom: 8px;">Today's Offenses</div>
                <div style="color: white; font-size: 2.5rem; font-weight: 700; line-height: 1;">{{ $todayOffenseCount }}</div>
                @else
                <div style="color: rgba(255,255,255,0.8); font-size: 0.9rem; margin-bottom: 8px;">My Offenses Unpaid</div>
                <div style="color: white; font-size: 2.5rem; font-weight: 700; line-height: 1;">{{ $unpaidOffenseCount }}</div>
                @endif
                <div style="color: rgba(255,255,255,0.6); font-size: 0.8rem; margin-top: 8px;">
                    <i class="fas fa-arrow-up" style="color: #4ade80; margin-right: 5px;"></i> Updated daily
                </div>
                <div style="color: rgba(255,255,255,0.6); font-size: 0.8rem; margin-top: 8px;">
                    <i class="fas fa-calendar-day" style="color: #ffd700; margin-right: 5px;"></i> {{ date('F j, Y') }}
                </div>
            </div>
        </div>

        <!-- Chart Container -->
        <div style="background: white; border-radius: 15px; padding: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <div style="display: flex; gap: 20px;">
                    <div style="display: flex; align-items: center;">
                        <span style="width: 12px; height: 12px; background: linear-gradient(135deg, #3b82f6, #2563eb); border-radius: 3px; margin-right: 8px;"></span>
                        @if(Auth::check() && Auth::user()->role != 'user')
                        <span style="color: #4a5568; font-size: 0.9rem;">Total Offenses</span>
                        @else
                        <span style="color: #4a5568; font-size: 0.9rem;">My Offenses</span>
                        @endif
                    </div>
                    <div style="display: flex; align-items: center;">
                        <span style="width: 12px; height: 12px; background: linear-gradient(135deg, #ef4444, #dc2626); border-radius: 3px; margin-right: 8px;"></span>
                        @if(Auth::check() && Auth::user()->role != 'user')
                        <span style="color: #4a5568; font-size: 0.9rem;">Today's Offenses</span>
                        @else
                        <span style="color: #4a5568; font-size: 0.9rem;">Unpaid Offenses</span>
                        @endif
                    </div>
                </div>
                <div style="color: #718096; font-size: 0.9rem;">
                    <i class="fas fa-info-circle" style="margin-right: 5px;"></i> Click bars for details
                </div>
            </div>
            
            <canvas id="offensesChart" height="100"></canvas>
            
            <!-- Trend Indicator -->
            @php
                if(Auth::check() && Auth::user()->role != 'user') {
                    $trend = $todayOffenseCount > 0 ? round(($todayOffenseCount / $totalOffenseCount) * 100, 1) : 0;
                } else {
                    $trend = $userOffenseCount > 0 ? round(($unpaidOffenseCount / $userOffenseCount) * 100, 1) : 0;
                }
            @endphp
            
            <div style="margin-top: 20px; padding-top: 20px; border-top: 2px dashed #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
                <div style="display: flex; align-items: center; gap: 15px;">
                    <div style="background: #f7fafc; padding: 8px 15px; border-radius: 25px;">
                        <span style="color: #4a5568; font-size: 0.9rem;">Today's share: <strong style="color: #2d3748; font-size: 1.1rem;">{{ $trend }}%</strong></span>
                    </div>
                    @if(Auth::check() && Auth::user()->role != 'user')
                        @if($todayOffenseCount > ($totalOffenseCount / 30))
                        <span style="color: #e53e3e; font-size: 0.9rem;">
                            <i class="fas fa-exclamation-triangle" style="margin-right: 5px;"></i> Above daily average
                        </span>
                        @else
                        <span style="color: #38a169; font-size: 0.9rem;">
                            <i class="fas fa-check-circle" style="margin-right: 5px;"></i> Below daily average
                        </span>
                        @endif
                    @else
                        @if($unpaidOffenseCount > ($userOffenseCount / 30))
                        <span style="color: #e53e3e; font-size: 0.9rem;">
                            <i class="fas fa-exclamation-triangle" style="margin-right: 5px;"></i> Above daily average
                        </span>
                        @else
                        <span style="color: #38a169; font-size: 0.9rem;">
                            <i class="fas fa-check-circle" style="margin-right: 5px;"></i> Below daily average
                        </span>
                        @endif
                    @endif
                </div>
                <button onclick="refreshChart()" style="background: none; border: none; color: #4299e1; cursor: pointer; font-size: 0.9rem;">
                    <i class="fas fa-sync-alt" style="margin-right: 5px;"></i> Refresh
                </button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('offensesChart').getContext('2d');
        
        // Gradient backgrounds
        const totalGradient = ctx.createLinearGradient(0, 0, 0, 400);
        totalGradient.addColorStop(0, '#3b82f6');
        totalGradient.addColorStop(1, '#2563eb');
        
        const todayGradient = ctx.createLinearGradient(0, 0, 0, 400);
        todayGradient.addColorStop(0, '#ef4444');
        todayGradient.addColorStop(1, '#dc2626');
        
        new Chart(ctx, {
            type: 'bar',
            data: {
                @if(Auth::check() && Auth::user()->role != 'user')
                labels: ['Total Offenses', 'Today Offenses'],
                @else
                labels: ['My Offenses', 'Unpaid Offenses'],
                @endif
                datasets: [{
                    label: 'Number of Offenses',
                    @if(Auth::check() && Auth::user()->role != 'user')
                    data: [{{ $totalOffenseCount }}, {{ $todayOffenseCount }}],
                    @else
                    data: [{{ $userOffenseCount }}, {{ $unpaidOffenseCount }}],
                    @endif
                    backgroundColor: [totalGradient, todayGradient],
                    borderRadius: 10,
                    borderSkipped: false,
                    barPercentage: 0.6,
                    categoryPercentage: 0.8,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { 
                        display: false 
                    },
                    tooltip: {
                        backgroundColor: '#1a202c',
                        titleColor: '#fff',
                        bodyColor: '#e2e8f0',
                        borderColor: '#4a5568',
                        borderWidth: 1,
                        padding: 12,
                        cornerRadius: 8,
                        displayColors: true,
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                let value = context.parsed.y;
                                return label + ': ' + value.toLocaleString() + ' offenses';
                            }
                        }
                    }
                },
                scales: {
                    y: { 
                        beginAtZero: true,
                        grid: {
                            color: '#e2e8f0',
                            drawBorder: false,
                        },
                        ticks: {
                            @if(Auth::check() && Auth::user()->role != 'user')
                            stepSize: Math.ceil({{ $totalOffenseCount }} / 5),
                            @else
                            stepSize: Math.ceil({{ $userOffenseCount }} / 5),
                            @endif
                            callback: function(value) {
                                return value.toLocaleString();
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                },
                onClick: function(e, item) {
                    if(item.length > 0) {
                        const index = item[0].dataIndex;
                        const label = this.data.labels[index];
                        const value = this.data.datasets[0].data[index];
                        alert(`${label}: ${value.toLocaleString()} offenses`);
                    }
                }
            }
        });
        
        function refreshChart() {
            location.reload();
        }
    </script>

    <style>
        .recent-box {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .recent-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 30px 50px rgba(0,0,0,0.15) !important;
        }
        
        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.7; }
            100% { opacity: 1; }
        }
        
        .fa-sync-alt:hover {
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
    </style>

    @endsection
@endguest