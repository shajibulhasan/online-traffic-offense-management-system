@guest
    @include('auth.login')
@else
    @extends('layouts2.app')

    @section('content')

    <style>
          /* dashboard content */
        .dashboard-container {
            padding: 32px 36px;
            max-width: 1200px;
        }

        .offense-card {
            max-width: 550px;
            background: white;
            border-radius: 28px;
            box-shadow: 0 20px 30px -10px rgba(2, 48, 93, 0.2);
            overflow: hidden;
            border: 1px solid rgba(0,70,120,0.08);
            margin-bottom: 40px;
        }

        .card-header-custom {
            background: #0b7c36;
            padding: 22px 28px;
            border-bottom: 1px solid rgba(0,70,120,0.1);
            
        }

        .card-header-custom h3 {
            color: white;
            font-weight: 600;
            font-size: 1.5rem;
            margin: 0;
            letter-spacing: -0.3px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-header-custom h3 i {
            color: #fcd34d;
        }

        .card-body-custom {
            padding: 32px 24px;
            background: white;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .big-number {
            font-size: 7rem;
            font-weight: 800;
            line-height: 1;
            color: #b91c1c;
            text-shadow: 0 4px 12px rgba(185,28,28,0.15);
        }

        .label-total {
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #4b6f8e;
            font-weight: 600;
            margin-top: 4px;
        }

        /* extra stats row (optional, but matches admin theme) */
        .stats-row {
            display: flex;
            flex-wrap: wrap;
            gap: 24px;
            margin-top: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 24px;
            padding: 24px 28px;
            box-shadow: 0 8px 24px rgba(0, 40, 70, 0.06);
            flex: 1 1 180px;
            border: 1px solid #dfeaf3;
        }

        .stat-card i {
            font-size: 2rem;
            color: #1f5f99;
            background: #e3f0fd;
            padding: 12px;
            border-radius: 18px;
        }

        .stat-card .stat-value {
            font-size: 2rem;
            font-weight: 700;
            margin-top: 12px;
            color: #0b2b4a;
        }

        .stat-card .stat-label {
            color: #597a9d;
            font-weight: 500;
        }

        /* dummy table / list hint */
        .recent-box {
            background: white;
            border-radius: 24px;
            padding: 22px 28px;
            margin-top: 30px;
            border: 1px solid #dee9f2;
        }

        .recent-title {
            font-weight: 600;
            font-size: 1.2rem;
            margin-bottom: 18px;
            color: #163a5c;
        }

        .thana-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #ecf3fa;
            padding: 14px 0;
        }

        .thana-row:last-child {
            border-bottom: none;
        }

        .badge-offense {
            background: #dc2626;
            color: white;
            font-weight: 600;
            padding: 6px 14px;
            border-radius: 40px;
            font-size: 0.9rem;
        }

    </style>

       <div class="dashboard-container">
            <!-- row col-md-6 offset-md-3 style card (exactly as snippet) -->
            <div class="row">
                <div class="offense-card col-md-6 mx-auto">
                    <div class="card-header-custom">
                        <h3>
                            <i class="fas fa-exclamation-triangle"></i> 
                            Total Offenses Recorded
                        </h3>
                    </div>
                    <div class="card-body-custom">
                        <!-- number "1" as shown in image, but we can also mimic dynamic 1 -->
                        <div class="big-number">120</div>
                        <div class="label-total">offense in system</div>
                    </div>
                </div>
                <div class="offense-card col-md-6">
                    <div class="card-header-custom">
                        <h3>
                            <i class="fas fa-exclamation-triangle"></i> 
                            Today's Offenses Recorded
                        </h3>
                    </div>
                    <div class="card-body-custom">
                        <!-- number "1" as shown in image, but we can also mimic dynamic 1 -->
                        <div class="big-number">5</div>
                        <div class="label-total">offenses recorded today</div>
                    </div>
                </div>                         
            </div>
            <!-- Additional admin stats (harmonizes with dashboard) -->
            <div class="stats-row">
                <div class="stat-card">
                    <i class="fas fa-user-police"></i>
                    <div class="stat-value">8</div>
                    <div class="stat-label">Verified officers</div>
                </div>
                <div class="stat-card">
                    <i class="fas fa-building"></i>
                    <div class="stat-value">457</div>
                    <div class="stat-label">Thanas</div>
                </div>
                <div class="stat-card">
                    <i class="fas fa-pen-fancy"></i>
                    <div class="stat-value">12</div>
                    <div class="stat-label">Offense types</div>
                </div>
            </div>

            <!-- Recent thana / area summary (simulates Thana list & area list) -->
            <div class="recent-box">
                <div class="recent-title"><i class="fas fa-clock" style="margin-right: 10px; color: #256eb0;"></i> Recent thana activity</div>
                <div class="thana-row">
                    <span><i class="fas fa-map-marker-alt" style="color:#1f6390;"></i> <strong>Motijheel Thana</strong> (Area: 5)</span>
                    <span class="badge-offense">2 offenses</span>
                </div>
                <div class="thana-row">
                    <span><i class="fas fa-map-marker-alt" style="color:#1f6390;"></i> <strong>Uttara Thana</strong> (Area: 3)</span>
                    <span class="badge-offense">0 offenses</span>
                </div>
                <div class="thana-row">
                    <span><i class="fas fa-map-marker-alt" style="color:#1f6390;"></i> <strong>Ramna Thana</strong> (Area: 4)</span>
                    <span class="badge-offense">1 offense</span>
                </div>
                <hr>
                <!-- subtle hint of "Total Offenses Recorded 1" and area list -->
                <div style="display: flex; justify-content: space-between; color: #2f577d;">
                    <span><i class="far fa-file-alt"></i> Area list: Gulshan, Banani, Motijheel...</span>
                    <span><i class="fas fa-check-circle" style="color:#2e7d32;"></i> Assign officer: 3 pending</span>
                </div>
            </div>
    @endsection
@endguest
