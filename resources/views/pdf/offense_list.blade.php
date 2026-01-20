<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Offense List</title>
    <style>
        body { font-family: DejaVu Sans; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; }
        th { background: #f2f2f2; }
        .text-center { text-align: center; }
    </style>
</head>
<body>

<h2 class="text-center">Offense List</h2>

<p>
    <strong>Name:</strong> {{ $driver->name }} <br>
    <strong>Email:</strong> {{ $driver->email ?? 'N/A' }} <br>
    <strong>Generated:</strong> {{ now()->format('d M Y') }}
</p>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Offense Details</th>
            <th>Officer</th>
            <th>Fine</th>
            <th>Point</th>
            <th>Status</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach($offenses as $i => $offense)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $offense->details_offense }}</td>
            <td>{{ $offense->officer_name }}</td>
            <td>{{ $offense->fine }}</td>
            <td>{{ $offense->point }}</td>
            <td>{{ ucfirst($offense->status) }}</td>
            <td>{{ \Carbon\Carbon::parse($offense->created_at)->format('d M Y') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<br>

<p>
    <strong>Total Fine:</strong> {{ $total_fine }} <br>
    <strong>Total Point:</strong> {{ $total_point }}
</p>

</body>
</html>
