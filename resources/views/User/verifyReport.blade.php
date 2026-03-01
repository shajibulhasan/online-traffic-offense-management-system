<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Verified Report · Driver details</title>
  <!-- Bootstrap 5 CSS (light version) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome 6 (free) for verified seal & icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    /* soft custom polish for verified feel */
    .verified-badge {
      color: #0d6efd;
      background: #e7f1ff;
      border-radius: 50rem;
      padding: 0.35rem 1rem;
      font-weight: 500;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      border: 1px solid #b6d4fe;
    }
    .report-card {
      border: none;
      border-radius: 1.2rem;
      box-shadow: 0 0.5rem 1.2rem rgba(0,0,0,0.05), 0 0 0 1px rgba(0,0,0,0.02);
      transition: 0.2s;
      background-color: #ffffff;
    }
    .detail-label {
      font-size: 0.8rem;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.03em;
      color: #5b6878;
      margin-bottom: 0.2rem;
    }
    .detail-value {
      font-size: 1.25rem;
      font-weight: 500;
      color: #1a2634;
      background: #f8fafd;
      padding: 0.6rem 1rem;
      border-radius: 0.85rem;
      border: 1px solid #e9edf2;
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .detail-value i {
      color: #2c3e50;
      opacity: 0.7;
      width: 1.6rem;
      text-align: center;
    }
    .status-active {
      background-color: #d1e7dd;
      color: #0a582c;
      font-weight: 600;
      padding: 0.35rem 1.2rem;
      border-radius: 50rem;
      border: 1px solid #a3cfbb;
    }
    .driver-photo-placeholder {
      width: 80px;
      height: 80px;
      background: linear-gradient(145deg, #e9ecef, #dee2e6);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 2.5rem;
      color: #495057;
      border: 3px solid white;
      box-shadow: 0 4px 8px rgba(0,0,0,0.04);
    }
    .footer-note {
      background: #f1f4f9;
      border-radius: 1rem;
      padding: 0.75rem 1.5rem;
      font-size: 0.9rem;
    }
    .error-fallback {
      color: #dc3545;
      font-size: 0.85rem;
      font-style: italic;
    }
  </style>
</head>
<body class="bg-light d-flex align-items-center min-vh-100">

<div class="container py-4">
  <!-- top simulated identity: driver name & license input (given) -->
  <div class="row justify-content-center mb-4">
    <div class="col-lg-7 col-md-9">
      <div class="bg-white p-3 rounded-4 shadow-sm d-flex align-items-center gap-3 flex-wrap">
        <div class="d-flex align-items-center gap-3 flex-grow-1">
          <i class="fas fa-id-card fa-2x text-primary opacity-75"></i>
          <div>
            <span class="text-secondary-emphasis fw-semibold">Given information</span>
            <h4 class="mb-0 fw-semibold">
              <span id="displayDriverName">{{ $driver->name ?? 'N/A' }}</span> 
              <span class="text-muted fw-light mx-1">•</span> 
              <span id="displayLicenseNumber">{{ $driver->license ?? 'N/A' }}</span>
            </h4>
          </div>
        </div>
        <span class="verified-badge ms-auto">
          <i class="fas fa-check-circle"></i> verified record
        </span>
      </div>
    </div>
  </div>

  <!-- MAIN VERIFIED REPORT CARD -->
  <div class="row justify-content-center">
    <div class="col-lg-7 col-md-9">
      <div class="card report-card p-4 p-xl-5">
        
        <!-- header: report title & badge -->
        <div class="d-flex justify-content-between align-items-start mb-4">
          <div>
            <h2 class="fw-bold mb-1"><i class="fas fa-file-lines me-2 text-primary"></i>Verified driver report</h2>
            <p class="text-secondary-emphasis">Official record · issued <span id="currentDate"></span></p>
          </div>
          <div class="driver-photo-placeholder">
            <i class="fas fa-user-circle"></i>
          </div>
        </div>

        <div class="row g-4">
          <!-- left column -->
          <div class="col-md-6">
            <div class="mb-4">
              <div class="detail-label"><i class="far fa-user me-1"></i>Full name (legal)</div>
              <div class="detail-value" id="detailFullName">
                <i class="fas fa-user-check"></i> {{ $driver->name ?? 'N/A' }}
              </div>
            </div>
            <div class="mb-4">
              <div class="detail-label"><i class="fas fa-id-card"></i> Driver license number</div>
              <div class="detail-value" id="detailLicense">
                <i class="fas fa-qrcode"></i> {{ $driver->license ?? 'N/A' }}
              </div>
            </div>
            <div class="mb-4">
              <div class="detail-label"><i class="fas fa-id-card"></i> NID </div>
              <div class="detail-value">
                <i class="fas fa-calendar-check"></i> {{ $driver->nid ?? 'N/A' }}
              </div>
            </div>
          </div>
          <!-- right column -->
          <div class="col-md-6">
            <div class="mb-4">
              <div class="detail-label"><i class="fas fa-phone"></i> Phone</div>
              <div class="detail-value">
                <i class="fas fa-motorcycle"></i> {{ $driver->phone ?? 'N/A' }}
              </div>
            </div>
             <div class="mb-4">
              <div class="detail-label"><i class="fas fa-envelope"></i> Email</div>
              <div class="detail-value">
                <i class="fas fa-envelope-open-text"></i> {{ $driver->email ?? 'N/A' }}
              </div>
            </div>
            <div class="mb-4">
              <div class="detail-label"><i class="fas fa-shield-alt"></i> Status</div>
              <div class="detail-value d-flex align-items-center">
                @if($driver == null)
                  <span class="error-fallback">Driver data not found</span>
                @else
                  <i class="fas fa-check-circle text-success"></i> 
                  <span class="status-active ms-2"> Verified</span>
                  <span class="ms-auto"><i class="fas fa-certificate text-primary"></i></span>
                @endif
              </div>
            </div>
           
          </div>
        </div>

        <hr class="my-4 opacity-25">
        <div class="row g-3">
          <div class="col-sm-6">
            <div class="d-flex align-items-center gap-2 p-2 rounded-3 bg-light">
              <i class="fas fa-fingerprint fs-5 text-secondary"></i>
              <span class="small">
                @if($lastOffense)
                  <span class="fw-semibold">Last Offense:</span> 
                  {{ \Carbon\Carbon::parse($lastOffense->created_at)->format('d M Y') }} - {{ $lastOffense->details_offense ?? 'N/A' }} 
                @else
                  <span class="fw-semibold">Last Offense:</span> No offenses found
                @endif
              </span>
              </span>
            </div>
          </div>
        </div>
      </div>


      <p class="text-center text-muted mt-3 small">
        <i class="fas fa-sync-alt me-1"></i> report generated from driver name & license shown above — data matches
      </p>
    </div>
  </div>
</div>

<script>
  try {
    const today = new Date();
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    const formattedDate = today.toLocaleDateString('en-US', options);
    document.getElementById('currentDate').textContent = formattedDate;
  } catch (e) {
    console.error('Error setting date:', e);
    document.getElementById('currentDate').textContent = 'Current date';
  }
</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>