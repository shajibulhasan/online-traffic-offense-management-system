@extends('layouts2.app')

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
        <div class="d-flex align-items-center">
            <i class="fas fa-check-circle fa-lg me-3 text-success"></i>
            <span>{{ session('success') }}</span>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@elseif(session('error'))
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
        <div class="d-flex align-items-center">
            <i class="fas fa-exclamation-circle fa-lg me-3 text-danger"></i>
            <span>{{ session('error') }}</span>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-xl-11">
            <!-- Header Section -->
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold text-dark mb-1">
                        <i class="fas fa-user-shield text-success me-2"></i>Officer Management
                    </h2>
                    <p class="text-muted">Manage and verify officer registrations</p>
                </div>
                <div class="mt-2 mt-sm-0">
                    <div class="stats-badge">
                        <span class="bg-light px-3 py-2 rounded-pill shadow-sm">
                            <i class="fas fa-users text-success me-1"></i>
                            Total: <strong>{{ $pendingOfficers->count() + $approvedOfficers->count() }}</strong>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Main Card -->
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <!-- Modern Tab Navigation -->
                <div class="card-header bg-white p-0 border-0">
                    <div class="nav-tabs-wrapper">
                        <ul class="nav nav-tabs border-0 px-4 pt-4" id="officerTab" role="tablist">
                            <li class="nav-item me-3" role="presentation">
                                <button class="nav-link active fw-semibold py-3 px-4" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending" type="button" role="tab" aria-controls="pending" aria-selected="true">
                                    <i class="fas fa-hourglass-half me-2 text-warning"></i>
                                    Pending Approval
                                    <span class="badge bg-warning bg-opacity-25 text-dark ms-2 rounded-pill">{{ $pendingOfficers->count() }}</span>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fw-semibold py-3 px-4" id="approved-tab" data-bs-toggle="tab" data-bs-target="#approved" type="button" role="tab" aria-controls="approved" aria-selected="false">
                                    <i class="fas fa-check-circle me-2 text-success"></i>
                                    Approved Officers
                                    <span class="badge bg-success bg-opacity-25 text-success ms-2 rounded-pill">{{ $approvedOfficers->count() }}</span>
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="tab-content" id="officerTabContent">
                        <!-- Pending Officers Tab -->
                        <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                            <div class="table-responsive">
                                <table class="table align-middle mb-0">
                                    <thead class="bg-light">
                                        <tr class="text-secondary">
                                            <th class="ps-4" style="width: 80px">#</th>
                                            <th>Officer Details</th>
                                            <th>Contact Info</th>
                                            <th>NID</th>
                                            <th>Applied Date</th>
                                            <th class="pe-4 text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $pendingId = 1; @endphp
                                        @forelse($pendingOfficers as $officer)
                                        <tr>
                                            <td class="ps-4 fw-bold text-muted">{{ $pendingId++ }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-circle bg-warning bg-opacity-10 text-warning me-3">
                                                        <i class="fas fa-user"></i>
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold text-dark">{{ $officer->name }}</div>
                                                        <small class="text-muted">ID: {{ $officer->id }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div><i class="fas fa-phone-alt text-muted me-2 small"></i>{{ $officer->phone }}</div>
                                                <div><i class="fas fa-envelope text-muted me-2 small"></i>{{ $officer->email }}</div>
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark px-3 py-2">{{ $officer->nid }}</span>
                                            </td>
                                            <td>
                                                @if($officer->created_at)
                                                    <div class="small">{{ \Carbon\Carbon::parse($officer->created_at)->format('d M, Y') }}</div>
                                                    <div class="small text-muted">{{ \Carbon\Carbon::parse($officer->created_at)->format('h:i A') }}</div>
                                                @else
                                                    <div class="small text-muted">—</div>
                                                @endif
                                            </td>
                                            <td class="pe-4 text-end">
                                                <button type="button" class="btn btn-sm btn-success rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#approveModal" data-officer-id="{{ $officer->id }}" data-officer-name="{{ $officer->name }}" data-officer-email="{{ $officer->email }}" data-officer-phone="{{ $officer->phone }}">
                                                    <i class="fas fa-check-circle me-1"></i> Approve
                                                </button>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-5">
                                                <div class="empty-state">
                                                    <i class="fas fa-inbox fa-4x text-muted mb-3 opacity-50"></i>
                                                    <h5 class="text-muted">No Pending Requests</h5>
                                                    <p class="text-muted small mb-0">All officer registrations have been processed.</p>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Approved Officers Tab -->
                        <div class="tab-pane fade" id="approved" role="tabpanel" aria-labelledby="approved-tab">
                            <div class="table-responsive">
                                <table class="table align-middle mb-0">
                                    <thead class="bg-light">
                                        <tr class="text-secondary">
                                            <th class="ps-4" style="width: 80px">#</th>
                                            <th>Officer Details</th>
                                            <th>Contact Info</th>
                                            <th>NID</th>
                                            <th>Approved Date</th>
                                            <th class="pe-4">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $approvedId = 1; @endphp
                                        @forelse($approvedOfficers as $officer)
                                        <tr>
                                            <td class="ps-4 fw-bold text-muted">{{ $approvedId++ }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-circle bg-success bg-opacity-10 text-success me-3">
                                                        <i class="fas fa-user-check"></i>
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold text-dark">{{ $officer->name }}</div>
                                                        <small class="text-muted">ID: {{ $officer->id }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div><i class="fas fa-phone-alt text-muted me-2 small"></i>{{ $officer->phone }}</div>
                                                <div><i class="fas fa-envelope text-muted me-2 small"></i>{{ $officer->email }}</div>
                                            </td>
                                            <td>
                                                <span class="badge bg-success text-dark px-3 py-2">{{ $officer->nid }}</span>
                                            </td>
                                            <td>
                                                @if($officer->updated_at)
                                                    <div class="small">{{ \Carbon\Carbon::parse($officer->updated_at)->format('d M, Y') }}</div>
                                                    <div class="small text-success">{{ \Carbon\Carbon::parse($officer->updated_at)->format('h:i A') }}</div>
                                                @else
                                                    <div class="small text-muted">—</div>
                                                @endif
                                            </td>
                                            <td class="pe-4">
                                                <span class="badge bg-success bg-opacity-15 text-success rounded-pill px-3 py-2">
                                                    <i class="fas fa-check-circle me-1"></i> Approved
                                                </span>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-5">
                                                <div class="empty-state">
                                                    <i class="fas fa-user-check fa-4x text-muted mb-3 opacity-50"></i>
                                                    <h5 class="text-muted">No Approved Officers</h5>
                                                    <p class="text-muted small mb-0">Approved officers will appear here.</p>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Approve Modal -->
<div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-gradient-success text-white border-0 rounded-top-4 py-3">
                <h5 class="modal-title fw-bold" id="approveModalLabel">
                    <i class="fas fa-user-check me-2"></i>Confirm Approval
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="text-center mb-4">
                    <div class="avatar-circle-modal bg-warning bg-opacity-10 mx-auto mb-3">
                        <i class="fas fa-user-shield fa-2x text-warning"></i>
                    </div>
                    <h5 class="fw-bold text-dark">Pending Approvals</h5>
                    <p class="text-muted mb-0">You are about to approve this officer registration.</p>
                </div>
                
                <div class="officer-details-card bg-light rounded-4 p-4 mb-4">
                    <h6 class="fw-bold text-dark mb-3">
                        <i class="fas fa-id-card text-success me-2"></i>OFFICER DETAILS
                    </h6>
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="d-flex align-items-center p-2 rounded-3 bg-white">
                                <div class="icon-wrapper bg-success bg-opacity-10 rounded-circle p-2 me-3">
                                    <i class="fas fa-user text-success"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Full Name</small>
                                    <strong id="modalOfficerName" class="text-dark">—</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex align-items-center p-2 rounded-3 bg-white">
                                <div class="icon-wrapper bg-success bg-opacity-10 rounded-circle p-2 me-3">
                                    <i class="fas fa-envelope text-success"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Email Address</small>
                                    <strong id="modalOfficerEmail" class="text-dark">—</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex align-items-center p-2 rounded-3 bg-white">
                                <div class="icon-wrapper bg-success bg-opacity-10 rounded-circle p-2 me-3">
                                    <i class="fas fa-phone text-success"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Phone Number</small>
                                    <strong id="modalOfficerPhone" class="text-dark">—</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="alert alert-info border-0 bg-info bg-opacity-10 rounded-4">
                    <div class="d-flex">
                        <i class="fas fa-shield-alt text-info me-3 fs-5 mt-1"></i>
                        <div>
                            <strong class="text-dark d-block mb-1">Important Notice</strong>
                            <small class="text-secondary">This action will grant officer privileges to this user. They will be able to access officer-only features and manage traffic offense records.</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 justify-content-center gap-3 pb-4">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4 py-2" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Cancel
                </button>
                <form id="approveForm" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-success rounded-pill px-4 py-2 shadow-sm">
                        <i class="fas fa-check-circle me-1"></i> Yes, Approve Officer
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    /* Modern Design System */
    :root {
        --success: #198754;
        --success-dark: #0f6b3a;
        --success-light: #e6f4ea;
        --warning-light: #fff4e5;
        --gray-bg: #f8f9fa;
        --border-radius: 1rem;
    }

    .card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    /* Avatar Style */
    .avatar-circle {
        width: 44px;
        height: 44px;
        background: var(--gray-bg);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        transition: all 0.2s ease;
    }
    
    .avatar-circle-modal {
        width: 70px;
        height: 70px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: all 0.2s ease;
    }
    
    /* Gradient Background */
    .bg-gradient-success {
        background: linear-gradient(135deg, var(--success) 0%, var(--success-dark) 100%);
    }
    
    /* Tab Styling */
    .nav-tabs {
        border-bottom: 2px solid #e9ecef;
        gap: 0.5rem;
    }
    
    .nav-tabs .nav-link {
        border: none;
        background: transparent;
        color: #6c757d;
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        margin-bottom: -2px;
        transition: all 0.2s ease;
        border-radius: 0;
        position: relative;
    }
    
    .nav-tabs .nav-link:hover:not(.active) {
        color: #00ac72;
        background: transparent;
        border-color: transparent;
    }
    
    .nav-tabs .nav-link.active {
        color: var(--success);
        background: transparent;
        border-bottom: 3px solid var(--success);
    }
    
    .nav-tabs .nav-link i {
        font-size: 0.9rem;
    }
    
    /* Badge Styling */
    .badge.bg-warning {
        background-color: #ffe8cc !important;
        color: #cc7b00 !important;
        font-weight: 500;
        padding: 0.35rem 0.65rem;
    }
    
    .badge.bg-success {
        background-color: #e0f5e9 !important;
        color: #005f29 !important;
    }
    
    /* Table Styling - NO HOVER EFFECT */
    .table {
        font-size: 0.9rem;
    }
    
    .table thead th {
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 1rem 0.75rem;
        border-bottom: 2px solid #e9ecef;
    }
    
    /* Pending table header color */
    #pending thead th {
        background: linear-gradient(135deg, #fff9e6 0%, #ffffff 100%);
        color: #856404;
    }
    
    /* Approved table header color */
    #approved thead th {
        background: linear-gradient(135deg, #e8f5e9 0%, #ffffff 100%);
        color: #198d1f;
    }
    
    .table tbody tr {
        border-bottom: 1px solid #f0f2f5;
        background-color: transparent;
    }
    
    /* NO HOVER EFFECT - Explicitly removed */
    .table tbody tr:hover {
        background-color: transparent !important;
    }
    
    .table tbody td {
        padding: 1rem 0.75rem;
        vertical-align: middle;
    }
    
    /* Alternating row colors for pending table */
    #pending tbody tr:nth-child(even) {
        background-color: #fefef8;
    }
    
    #pending tbody tr:nth-child(odd) {
        background-color: #ffffff;
    }
    
    /* Alternating row colors for approved table */
    #approved tbody tr:nth-child(even) {
        background-color: #f8fff8;
    }
    
    #approved tbody tr:nth-child(odd) {
        background-color: #ffffff;
    }
    
    /* Button Styling */
    .btn-success {
        background: linear-gradient(135deg, var(--success) 0%, var(--success-dark) 100%);
        border: none;
        font-weight: 500;
        transition: transform 0.1s ease, box-shadow 0.2s ease;
    }
    
    .btn-success:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(25, 135, 84, 0.32);
    }
    
    .btn-success:active {
        transform: translateY(1px);
    }
    
    .btn-outline-secondary {
        border: 1px solid #dee2e6;
        transition: all 0.2s ease;
    }
    
    .btn-outline-secondary:hover {
        background: #f8f9fa;
        border-color: #cbd5e0;
    }
    
    /* Modal Styling */
    .modal-content {
        overflow: hidden;
    }
    
    .officer-details-card {
        border-left: 4px solid var(--success);
        background: #ffffff !important;
        box-shadow: 0 2px 8px rgba(0,0,0,0.03);
    }
    
    .icon-wrapper {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    /* Alert Styling */
    .alert-info {
        background: #e7f3ff !important;
        border: none;
    }
    
    /* Stats Badge */
    .stats-badge span {
        font-size: 0.9rem;
        background: white !important;
        border: 1px solid #e9ecef;
    }
    
    /* Empty State */
    .empty-state {
        padding: 3rem 1rem;
    }
    
    /* Scrollbar */
    .table-responsive::-webkit-scrollbar {
        height: 6px;
    }
    
    .table-responsive::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    .table-responsive::-webkit-scrollbar-thumb {
        background: #cbd5e0;
        border-radius: 10px;
    }
    
    /* Animation for modal */
    .modal.fade .modal-dialog {
        transform: scale(0.95);
        transition: transform 0.2s ease-out;
    }
    
    .modal.show .modal-dialog {
        transform: scale(1);
    }
    
    /* Alert animation */
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .alert {
        animation: slideDown 0.3s ease-out;
    }
    
    /* Tab content animation */
    .tab-pane {
        animation: fadeIn 0.25s ease-out;
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .nav-tabs .nav-link {
            padding: 0.5rem 1rem;
            font-size: 0.85rem;
        }
        
        .table tbody td, 
        .table thead th {
            padding: 0.75rem 0.5rem;
        }
        
        .avatar-circle {
            width: 36px;
            height: 36px;
            font-size: 0.9rem;
        }
        
        .avatar-circle-modal {
            width: 55px;
            height: 55px;
        }
        
        .avatar-circle-modal i {
            font-size: 1.5rem;
        }
        
        .btn-success, .btn-outline-secondary {
            padding: 0.3rem 0.8rem;
            font-size: 0.85rem;
        }
        
        .officer-details-card {
            padding: 1rem !important;
        }
    }
</style>

<script>
    // Handle modal data population
    const approveModal = document.getElementById('approveModal');
    if (approveModal) {
        approveModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const officerId = button.getAttribute('data-officer-id');
            const officerName = button.getAttribute('data-officer-name');
            const officerEmail = button.getAttribute('data-officer-email');
            const officerPhone = button.getAttribute('data-officer-phone');
            
            // Update modal content
            document.getElementById('modalOfficerName').textContent = officerName;
            document.getElementById('modalOfficerEmail').textContent = officerEmail;
            document.getElementById('modalOfficerPhone').textContent = officerPhone;
            
            // Update form action with correct route
            const approveForm = document.getElementById('approveForm');
            approveForm.action = "{{ url('/officers') }}/" + officerId + "/approve";
        });
    }
    
    // Bootstrap 5 Tab initialization
    document.addEventListener('DOMContentLoaded', function() {
        // Restore last active tab using localStorage
        const activeTab = localStorage.getItem('activeOfficerTab');
        if (activeTab === 'approved') {
            const approvedTabBtn = document.querySelector('#approved-tab');
            if (approvedTabBtn) {
                const bsTab = new bootstrap.Tab(approvedTabBtn);
                bsTab.show();
            }
        }
        
        // Save active tab when switching
        const tabElements = document.querySelectorAll('#officerTab button');
        tabElements.forEach(tab => {
            tab.addEventListener('shown.bs.tab', function(event) {
                const targetId = event.target.getAttribute('data-bs-target');
                if (targetId === '#approved') {
                    localStorage.setItem('activeOfficerTab', 'approved');
                } else {
                    localStorage.setItem('activeOfficerTab', 'pending');
                }
            });
        });
    });
</script>
@endsection