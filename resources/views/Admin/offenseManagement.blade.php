@extends('layouts2.app')

@section('content')
<style>
  .offense-wrap { padding: 1.5rem 0; }
  .filter-btn { display: inline-flex; align-items: center; gap: 6px; }
  .section-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; overflow: hidden; }
  .section-header { display: flex; align-items: center; gap: 10px; padding: 1rem 1.25rem; border-bottom: 1px solid #e5e7eb; background: #f9fafb; }
  .section-title { font-size: 15px; font-weight: 500; color: #111827; margin: 0; }
  .count-pill { font-size: 12px; font-weight: 600; padding: 3px 10px; border-radius: 999px; }
  .pill-all   { background: #e5e7eb; color: #374151; }
  .pill-paid  { background: #d1fae5; color: #065f46; }
  .pill-unpaid{ background: #fee2e2; color: #991b1b; }

  .table-wrapper { overflow-x: auto; }
  .offense-table { width: 100%; min-width: 780px; }

  .offense-table thead th {
    background: #f3f4f6;
    font-size: 12px;
    font-weight: 600;
    color: #6b7280;
    padding: 10px 12px;
    white-space: nowrap;
    text-transform: uppercase;
    letter-spacing: 0.03em;
  }

  .offense-table tbody td {
    padding: 10px 12px;
    font-size: 13px;
    color: #1f2937;
    vertical-align: middle;
  }

  .offense-table tbody tr:hover {
    background: #f9fafb;
  }

  .id-cell {
    font-family: monospace;
    font-size: 12px;
    color: #9ca3af;
  }

  .txn-cell {
    font-family: monospace;
    font-size: 12px;
    color: #6b7280;
  }

  .fine-cell {
    font-weight: 600;
  }

  .table-section { display: none; }
  .table-section.active { display: block; }

  .btn-filter-all {
    background: #1f372b !important;
    color: #fff !important;
    border-color: #1f2937 !important;
  }

  .btn-filter-paid {
    background: #065f46 !important;
    color: #fff !important;
    border-color: #065f46 !important;
  }

  .btn-filter-unpaid {
    background: #991b1b !important;
    color: #fff !important;
    border-color: #991b1b !important;
  }

  .date-filter-box {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 15px;
    margin-bottom: 20px;
  }
</style>

<div class="container-fluid px-4 py-4 offense-wrap">

  <h2 class="fw-medium fs-4 mb-4 text-dark">
    <i class="bi bi-shield-exclamation me-2"></i>Offense Management
  </h2>

  <!-- Date Filter -->
  <div class="date-filter-box">
    <div class="row g-3 align-items-end">

      <div class="col-md-4">
        <label class="form-label fw-medium">From Date</label>
        <input type="date" id="fromDate" class="form-control border-success-subtle border-2 bg-success-subtle">
      </div>

      <div class="col-md-4">
        <label class="form-label fw-medium">To Date</label>
        <input type="date" id="toDate" class="form-control border-success-subtle border-2 bg-success-subtle">
      </div>

      <div class="col-md-4 d-flex gap-2">
        <button class="btn btn-success w-100" onclick="filterByDate()">
          <i class="bi bi-funnel"></i> Filter
        </button>

        <button class="btn btn-outline-secondary w-100" onclick="resetFilter()">
          <i class="bi bi-arrow-clockwise"></i> Reset
        </button>
      </div>

    </div>
  </div>


  <!-- Search + Total Fine -->
<div class="row g-3 mb-4">

  <div class="col-md-8">
    <div class="position-relative">
      <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>

      <input
        type="text"
        id="searchInput"
        class="form-control ps-5 border-success-subtle border-2 bg-success-subtle"
        placeholder="Search by driver, officer, thana, offense type, transaction id..."
        onkeyup="searchTable()"
      >
    </div>
  </div>

  <div class="col-md-4">
    <div class="card border-success-subtle shadow-sm h-100">
      <div class="card-body d-flex align-items-center justify-content-between">

        <div>
          <small class="text-muted d-block">Total Fine Amount</small>
          <h4 class="mb-0 fw-bold text-success">
            ৳ <span id="totalFine">
              {{ number_format($allOffenses->sum('fine')) }}
            </span>
          </h4>
        </div>

        <div class="fs-2 text-success">
          <i class="bi bi-cash-stack"></i>
        </div>

      </div>
    </div>
  </div>

</div>



  <!-- Filter Buttons -->
  <div class="d-flex flex-wrap gap-2 mb-4">
    <button class="btn btn-sm filter-btn btn-filter-all" onclick="switchTab('all', this)">
      <i class="bi bi-list-ul"></i> All Offenses
      <span class="count-pill pill-all ms-1">{{ count($allOffenses) }}</span>
    </button>

    <button class="btn btn-sm btn-outline-secondary filter-btn" onclick="switchTab('paid', this)">
      <i class="bi bi-check-circle"></i> Paid
      <span class="count-pill pill-paid ms-1">{{ count($paidOffenses) }}</span>
    </button>

    <button class="btn btn-sm btn-outline-secondary filter-btn" onclick="switchTab('unpaid', this)">
      <i class="bi bi-exclamation-circle"></i> Unpaid
      <span class="count-pill pill-unpaid ms-1">{{ count($unpaidOffenses) }}</span>
    </button>
  </div>

  @php
    $tables = [
      ['id' => 'all',    'label' => 'All Offenses List',    'data' => $allOffenses,    'pillClass' => 'pill-all'],
      ['id' => 'paid',   'label' => 'Paid Offenses List',   'data' => $paidOffenses,   'pillClass' => 'pill-paid'],
      ['id' => 'unpaid', 'label' => 'Unpaid Offenses List', 'data' => $unpaidOffenses, 'pillClass' => 'pill-unpaid'],
    ];
  @endphp

  @foreach($tables as $t)
  <div id="{{ $t['id'] }}Table" class="section-card table-section {{ $loop->first ? 'active' : '' }} mb-4">

    <div class="section-header bg-success">
      <p class="section-title text-white">{{ $t['label'] }}</p>
      <span class="count-pill {{ $t['pillClass'] }}">{{ count($t['data']) }}</span>
    </div>

    <div class="table-wrapper">
      <table class="table offense-table mb-0">

        <thead>
          <tr>
            <th>ID</th>
            <th>Driver</th>
            <th>Officer</th>
            <th>Thana</th>
            <th>Offense Type</th>
            <th>Details</th>
            <th>Fine (৳)</th>
            <th>Points</th>
            <th>Transaction ID</th>
            <th>Status</th>
            <th>Date</th>
          </tr>
        </thead>

        <tbody>
          @forelse($t['data'] as $offense)
          <tr class="offense-row"
              data-date="{{ date('Y-m-d', strtotime($offense->created_at)) }}">

            <td class="id-cell">#{{ $offense->id }}</td>
            <td>{{ $offense->driver_name }}</td>
            <td>{{ $offense->officer_name }}</td>
            <td>{{ $offense->thana_name }}</td>
            <td>{{ $offense->offense_type }}</td>

            <td class="text-muted"
                style="max-width:180px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
              {{ $offense->details_offense }}
            </td>

            <td class="fine-cell">{{ number_format($offense->fine) }}</td>

            <td>{{ $offense->point }}</td>

            <td class="txn-cell">{{ $offense->transaction_id ?? 'N/A' }}</td>

            <td>
              @if($offense->status == 'paid')
                <span class="badge rounded-pill bg-success-subtle text-success fw-medium">
                  <i class="bi bi-check-circle-fill me-1"></i>Paid
                </span>
              @else
                <span class="badge rounded-pill bg-danger-subtle text-danger fw-medium">
                  <i class="bi bi-x-circle-fill me-1"></i>Unpaid
                </span>
              @endif
            </td>

            <td class="text-muted" style="white-space:nowrap;">
              {{ date('d M Y', strtotime($offense->created_at)) }}
            </td>

          </tr>
          @empty
          <tr>
            <td colspan="11" class="text-center text-muted py-4">
              No records found.
            </td>
          </tr>
          @endforelse
        </tbody>

      </table>
    </div>
  </div>
  @endforeach

</div>

<script>

  function switchTab(type, clickedBtn) {

    document.querySelectorAll('.table-section').forEach(el => {
      el.classList.remove('active');
    });

    document.querySelectorAll('.filter-btn').forEach(btn => {

      btn.classList.remove(
        'btn-filter-all',
        'btn-filter-paid',
        'btn-filter-unpaid'
      );

      btn.classList.add('btn-outline-secondary');
    });

    document.getElementById(type + 'Table').classList.add('active');

    clickedBtn.classList.remove('btn-outline-secondary');
    clickedBtn.classList.add('btn-filter-' + type);

    applyFilters();
  }


  function applyFilters() {

    let fromDate = document.getElementById('fromDate').value;
    let toDate   = document.getElementById('toDate').value;
    let search   = document.getElementById('searchInput').value.toLowerCase();

    let activeTable = document.querySelector('.table-section.active');

    let total = 0;

    activeTable.querySelectorAll('.offense-row').forEach(row => {

      let rowDate = row.getAttribute('data-date');
      let text    = row.innerText.toLowerCase();

      let show = true;

      // Date Filter
      if (fromDate && rowDate < fromDate) {
        show = false;
      }

      if (toDate && rowDate > toDate) {
        show = false;
      }

      // Search Filter
      if (search && !text.includes(search)) {
        show = false;
      }

      row.style.display = show ? '' : 'none';

      // Total Fine
      if (show) {

        let fineText = row.querySelector('.fine-cell')
                          .innerText
                          .replace(/,/g, '');

        total += parseFloat(fineText) || 0;
      }

    });

    document.getElementById('totalFine').innerText =
      total.toLocaleString();
  }


  function filterByDate() {
    applyFilters();
  }


  function searchTable() {
    applyFilters();
  }


  function resetFilter() {

    document.getElementById('fromDate').value = '';
    document.getElementById('toDate').value = '';
    document.getElementById('searchInput').value = '';

    applyFilters();
  }


  // Initial Total Load
  window.onload = function () {
    applyFilters();
  }

</script>
@endsection