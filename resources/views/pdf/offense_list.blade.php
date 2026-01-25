<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Offense Report</title>

<style>

body {
    font-family: DejaVu Sans, sans-serif;
    font-size: 11px;
    position: relative;
}

header {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    height: 140px; 
    text-align: center;
    border-bottom: 1px solid #000;
    padding-top: 10px;
}

header img {
    width: 100px;
    margin-bottom: 5px;
}

header h3 {
    margin: 5px 0 2px 0;
}

header p {
    margin: 0;
    font-size: 12px;
}

footer {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    height: 90px;
    text-align: center;
    font-size: 10px;
    border-top: 1px solid #000;
    padding-top: 5px;
}


footer .pagenum:before {
    content: counter(page);
}

.watermark {
    position: fixed;
    top: 50%;
    left: 50%;
    width: 400px;
    transform: translate(-50%, -50%) rotate(-45deg);
    opacity: 0.05;
    font-size: 60px;
    color: #000;
    text-align: center;
    z-index: 0;
}

.main-content {
    margin-top: 150px; 
    margin-bottom: 100px; 
}

h4 {
    margin-bottom: 5px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

th, td {
    border: 1px solid #000;
    padding: 5px;
    font-size: 11px;
}

th {
    background: #f2f2f2;
}

.text-center { text-align: center; }

table tr {
    page-break-inside: avoid;
}

</style>
</head>

<body>

<div class="watermark">Traffic Police</div>

<!-- ===== HEADER ===== -->
<header>
    <img src="{{ public_path('images/logo.png') }}">
    <h3>Bangladesh Traffic Police</h3>
    <p>Official Offense Report</p>
</header>

<!-- ===== FOOTER ===== -->
<footer>
    <p>Page <span class="pagenum"></span></p>
    <p>© {{ date('Y') }} Bangladesh Traffic Police. All rights reserved.</p>
</footer>

<!-- ===== CONTENT ===== -->
<div class="main-content">
    <h4>Driver Information</h4>
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
                <td>{{ $i+1 }}</td>
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

    <br>

    <p>
        <strong>Verify Report:</strong><br>
        <img src="data:image/png;base64,{{ $qrImage }}" width="120">
    </p>

    <br><br>

    <p>
        Authorized Signature <br><br>
        _______________________ <br>
        Officer
    </p>
</div>

</body>
</html>
