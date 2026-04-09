@extends('layouts2.app')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4 text-black">Offense Management</h2>
        
        <!-- 3 Buttons -->
        <div class="mb-3">
            <button class="btn btn-secondary me-2" onclick="showTable('all')">All Offenses</button>
            <button class="btn btn-success me-2" onclick="showTable('paid')">Paid Offenses</button>
            <button class="btn btn-danger" onclick="showTable('unpaid')">Unpaid Offenses</button>
        </div>
        <!-- All Offenses Table -->
        <div id="allTable" class="table-section">
            <h4 class='text-black'>All Offenses List</h4>
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Driver Name</th>
                        <th>Officer Name</th>
                        <th>Thana</th>
                        <th>Offense Type</th>
                        <th>Details</th>
                        <th>Fine</th>
                        <th>Point</th>
                        <th>Transaction ID</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($allOffenses as $offense)
                    <tr>
                        <td>{{ $offense->id }}</td>
                        <td>{{ $offense->driver_name }}</td>
                        <td>{{ $offense->officer_name }}</td>
                        <td>{{ $offense->thana_name }}</td>
                        <td>{{ $offense->offense_type }}</td>
                        <td>{{ $offense->details_offense }}</td>
                        <td>{{ $offense->fine }}</td>
                        <td>{{ $offense->point }}</td>
                        <td>{{ $offense->transaction_id ?? 'N/A' }}</td>
                        <td>
                            <span class="badge {{ $offense->status == 'paid' ? 'bg-success' : 'bg-danger' }}">
                                {{ $offense->status }}
                            </span>
                        </td>
                        <td>{{ date('d-m-Y', strtotime($offense->created_at)) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Paid Offenses Table -->
        <div id="paidTable" class="table-section" style="display: none;">
            <h4 class='text-black'>Paid Offenses List</h4>
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Driver Name</th>
                        <th>Officer Name</th>
                        <th>Thana</th>
                        <th>Offense Type</th>
                        <th>Details</th>
                        <th>Fine</th>
                        <th>Point</th>
                        <th>Transaction ID</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($paidOffenses as $offense)
                    <tr>
                        <td>{{ $offense->id }}</td>
                        <td>{{ $offense->driver_name }}</td>
                        <td>{{ $offense->officer_name }}</td>
                        <td>{{ $offense->thana_name }}</td>
                        <td>{{ $offense->offense_type }}</td>
                        <td>{{ $offense->details_offense }}</td>
                        <td>{{ $offense->fine }}</td>
                        <td>{{ $offense->point }}</td>
                        <td>{{ $offense->transaction_id ?? 'N/A' }}</td>
                        <td>
                            <span class="badge bg-success">{{ $offense->status }}</span>
                        </td>
                        <td>{{ date('d-m-Y', strtotime($offense->created_at)) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Unpaid Offenses Table -->
        <div id="unpaidTable" class="table-section" style="display: none;">
            <h4 class='text-black'>Unpaid Offenses List</h4>
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Driver Name</th>
                        <th>Officer Name</th>
                        <th>Thana</th>
                        <th>Offense Type</th>
                        <th>Details</th>
                        <th>Fine</th>
                        <th>Point</th>
                        <th>Transaction ID</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($unpaidOffenses as $offense)
                    <tr>
                        <td>{{ $offense->id }}</td>
                        <td>{{ $offense->driver_name }}</td>
                        <td>{{ $offense->officer_name }}</td>
                        <td>{{ $offense->thana_name }}</td>
                        <td>{{ $offense->offense_type }}</td>
                        <td>{{ $offense->details_offense }}</td>
                        <td>{{ $offense->fine }}</td>
                        <td>{{ $offense->point }}</td>
                        <td>{{ $offense->transaction_id ?? 'N/A' }}</td>
                        <td>
                            <span class="badge bg-danger">{{ $offense->status }}</span>
                        </td>
                        <td>{{ date('d-m-Y', strtotime($offense->created_at)) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function showTable(type) {
            document.getElementById('allTable').style.display = 'none';
            document.getElementById('paidTable').style.display = 'none';
            document.getElementById('unpaidTable').style.display = 'none';
            
            if(type === 'all') {
                document.getElementById('allTable').style.display = 'block';
            } else if(type === 'paid') {
                document.getElementById('paidTable').style.display = 'block';
            } else if(type === 'unpaid') {
                document.getElementById('unpaidTable').style.display = 'block';
            }
        }
    </script>
@endsection