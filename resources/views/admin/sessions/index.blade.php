{{-- resources/views/admin/sessions/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Session Management')

@section('styles')
<style>
    /* Additional styles specific to sessions page */
    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 20px;
        margin-bottom: 25px;
    }
    
    .stat-card {
        background-color: rgba(255, 255, 255, 0.05);
        border-radius: 10px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
    }
    
    .stat-icon {
        font-size: 28px;
        margin-bottom: 10px;
    }
    
    .stat-value {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 5px;
        color: white;
    }
    
    .stat-label {
        font-size: 12px;
        color: rgba(255, 255, 255, 0.7);
        margin: 0;
    }
    
    .filters-card {
        background-color: rgba(255, 255, 255, 0.05);
        border-radius: 10px;
        margin-bottom: 25px;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .filters-header {
        background-color: rgba(255, 255, 255, 0.05);
        color: var(--primary-color);
        font-weight: 600;
        padding: 15px 20px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 10px 10px 0 0;
    }
    
    .sessions-table-card {
        background-color: rgba(255, 255, 255, 0.05);
        border-radius: 10px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        overflow: hidden;
    }
    
    .table-header {
        background-color: rgba(255, 255, 255, 0.05);
        color: var(--primary-color);
        font-weight: 600;
        padding: 15px 20px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .table-dark {
        background-color: transparent;
        color: var(--text-color);
    }
    
    .table-dark th {
        background-color: transparent;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        color: var(--primary-color);
        font-weight: 600;
    }
    
    .table-dark td {
        background-color: transparent;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(255, 255, 255, 0.05) !important;
    }
    
    .user-info {
        display: flex;
        flex-direction: column;
    }
    
    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .status-available { 
        background-color: rgba(28, 200, 138, 0.2); 
        color: #1cc88a; 
    }
    
    .status-booked { 
        background-color: rgba(58, 191, 186, 0.2); 
        color: #3abfba; 
    }
    
    .status-pending { 
        background-color: rgba(247, 194, 68, 0.2); 
        color: #f7c244; 
    }
    
    .status-confirmed { 
        background-color: rgba(28, 200, 138, 0.2); 
        color: #1cc88a; 
    }
    
    .status-completed { 
        background-color: rgba(90, 247, 255, 0.2); 
        color: var(--primary-color); 
    }
    
    .status-cancelled { 
        background-color: rgba(231, 74, 59, 0.2); 
        color: #e74a3b; 
    }
    
    .action-buttons {
        display: flex;
        gap: 5px;
        align-items: center;
    }
    
    .btn-action {
        padding: 6px 10px;
        border-radius: 6px;
        border: none;
        color: white;
        font-size: 12px;
        transition: all 0.3s;
    }
    
    .btn-action:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    }
    
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: rgba(255, 255, 255, 0.5);
    }
    
    .empty-state i {
        font-size: 4rem;
        margin-bottom: 20px;
        opacity: 0.3;
    }
    
    .modal-content {
        background-color: rgba(19, 27, 49, 0.95);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: var(--text-color);
    }
    
    .modal-header {
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .modal-footer {
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .price-text {
        font-size: 16px;
        font-weight: 600;
        color: #1cc88a;
    }
    
    .subject-badge {
        background-color: rgba(90, 247, 255, 0.2);
        color: var(--primary-color);
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }
    
    @media (max-width: 768px) {
        .stats-container {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .table-responsive {
            font-size: 14px;
        }
        
        .user-info {
            width: 30px;
            height: 30px;
            font-size: 14px;
        }
    }
    
    @media (max-width: 576px) {
        .stats-container {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<!-- Header -->
<div class="header-container">
    <h1>Session Management</h1>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.sessions.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-2"></i> Create Session
        </a>
        <a href="{{ route('admin.sessions.export', request()->query()) }}" class="btn btn-outline-primary">
            <i class="fas fa-download me-2"></i> Export CSV
        </a>
    </div>
</div>

<!-- Success/Error Messages -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Statistics Cards -->
<div class="stats-container">
    <div class="stat-card">
        <div class="stat-icon text-info">
            <i class="fas fa-calendar-alt"></i>
        </div>
        <div class="stat-value">{{ $stats['total_sessions'] ?? 0 }}</div>
        <p class="stat-label">Total Sessions</p>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon text-success">
            <i class="fas fa-calendar-plus"></i>
        </div>
        <div class="stat-value">{{ $stats['available_slots'] ?? 0 }}</div>
        <p class="stat-label">Available Slots</p>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon text-warning">
            <i class="fas fa-clock"></i>
        </div>
        <div class="stat-value">{{ $stats['booked_sessions'] ?? 0 }}</div>
        <p class="stat-label">Booked Sessions</p>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon" style="color: var(--primary-color);">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="stat-value">{{ $stats['confirmed_sessions'] ?? 0 }}</div>
        <p class="stat-label">Confirmed</p>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon" style="color: var(--primary-color);">
            <i class="fas fa-star"></i>
        </div>
        <div class="stat-value">{{ $stats['completed_sessions'] ?? 0 }}</div>
        <p class="stat-label">Completed</p>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon text-info">
            <i class="fas fa-calendar-day"></i>
        </div>
        <div class="stat-value">{{ $stats['today_sessions'] ?? 0 }}</div>
        <p class="stat-label">Today's Sessions</p>
    </div>
</div>

<!-- Filters -->
<div class="filters-card">
    <div class="filters-header">
        <i class="fas fa-filter me-2"></i> <strong>Filters & Search</strong>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.sessions.index') }}">
            <div class="row g-3">
                <div class="col-md-2">
                    <label class="form-label">Type</label>
                    <select name="type" class="form-select">
                        <option value="">All Types</option>
                        <option value="available" {{ request('type') == 'available' ? 'selected' : '' }}>Available Slots</option>
                        <option value="booked" {{ request('type') == 'booked' ? 'selected' : '' }}>Booked Sessions</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Available</option>
                        <option value="booked" {{ request('status') == 'booked' ? 'selected' : '' }}>Booked</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">From Date</label>
                    <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">To Date</label>
                    <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Search</label>
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search mentor, student or subject..." value="{{ request('search') }}">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                        @if(request()->hasAny(['status', 'type', 'date_from', 'date_to', 'search']))
                        <a href="{{ route('admin.sessions.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Sessions Table -->
<div class="sessions-table-card">
    <div class="table-header">
        <strong>All Sessions ({{ isset($sessions) ? $sessions->total() : 0 }})</strong>
    </div>
    <div class="p-0">
        <div class="table-responsive">
            <table class="table table-dark table-hover mb-0">
                <thead>
                    <tr>
                        <th width="60">ID</th>
                        <th>Student</th>
                        <th>Mentor</th>
                        <th>Subject</th>
                        <th>Date & Time</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th width="120">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sessions ?? [] as $session)
                    <tr>
                        <td>
                            <span class="fw-bold" style="color: var(--primary-color);">#{{ $session->id }}</span>
                        </td>
                        <td>
                            @if($session->student)
                            <div class="user-info">
                                <div class="text-white fw-bold">{{ $session->student->name }}</div>
                                <div class="text-muted small">{{ $session->student->email }}</div>
                            </div>
                            @else
                            <div class="d-flex align-items-center">
                                <i class="fas fa-calendar-plus me-2 text-success"></i>
                                <span class="text-success fw-bold">Available for booking</span>
                            </div>
                            @endif
                        </td>
                        <td>
                            <div class="user-info">
                                <div class="text-white fw-bold">{{ $session->mentor->name ?? 'N/A' }}</div>
                                <div class="text-muted small">{{ $session->mentor->email ?? 'N/A' }}</div>
                            </div>
                        </td>
                        <td>
                            <span class="subject-badge">
                                <i class="fas fa-book me-1"></i>
                                {{ $session->subject->name ?? 'N/A' }}
                            </span>
                        </td>
                        <td>
                            <div>
                                <div class="text-white">
                                    <i class="fas fa-calendar me-1"></i>
                                    {{ $session->date ? $session->date->format('d M Y') : 'N/A' }}
                                </div>
                                <div class="text-muted small">
                                    <i class="fas fa-clock me-1"></i>
                                    {{ $session->start_time ? \Carbon\Carbon::parse($session->start_time)->format('H:i') : 'N/A' }} - 
                                    {{ $session->end_time ? \Carbon\Carbon::parse($session->end_time)->format('H:i') : 'N/A' }}
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="price-text">Rp {{ number_format($session->price ?? 0, 0, ',', '.') }}</div>
                        </td>
                        <td>
                            @php
                                $status = strtolower($session->status ?? 'available');
                                $statusClass = 'status-' . $status;
                            @endphp
                            <span class="status-badge {{ $statusClass }}">
                                {{ ucfirst($session->status ?? 'Available') }}
                            </span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.sessions.show', $session) }}" class="btn btn-info btn-action" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.sessions.edit', $session) }}" class="btn btn-warning btn-action" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                @if($session->status != 'completed')
                                <div class="dropdown">
                                    <button class="btn btn-secondary btn-action dropdown-toggle" type="button" data-bs-toggle="dropdown" title="More Actions">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-dark">
                                        @if($session->status == 'pending')
                                        <li>
                                            <form action="{{ route('admin.sessions.update-status', $session) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="confirmed">
                                                <button type="submit" class="dropdown-item text-success">
                                                    <i class="fas fa-check me-2"></i> Confirm
                                                </button>
                                            </form>
                                        </li>
                                        @endif
                                        
                                        @if($session->status == 'confirmed')
                                        <li>
                                            <form action="{{ route('admin.sessions.update-status', $session) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="completed">
                                                <button type="submit" class="dropdown-item text-info">
                                                    <i class="fas fa-star me-2"></i> Complete
                                                </button>
                                            </form>
                                        </li>
                                        @endif
                                        
                                        @if($session->status != 'cancelled')
                                        <li>
                                            <form action="{{ route('admin.sessions.update-status', $session) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="cancelled">
                                                <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to cancel this session?')">
                                                    <i class="fas fa-times me-2"></i> Cancel
                                                </button>
                                            </form>
                                        </li>
                                        @endif
                                        
                                        @if(in_array($session->status, ['pending', 'cancelled']))
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <button type="button" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#deleteSessionModal{{ $session->id }}">
                                                <i class="fas fa-trash me-2"></i> Delete
                                            </button>
                                        </li>
                                        @endif
                                    </ul>
                                </div>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <i class="fas fa-calendar-times"></i>
                                <h5>No sessions found</h5>
                                <p>Try adjusting your filters or create a new session</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if(isset($sessions) && method_exists($sessions, 'links'))
        <div class="card-footer" style="background-color: rgba(255, 255, 255, 0.05); border-top: 1px solid rgba(255, 255, 255, 0.1); padding: 15px;">
            <div class="d-flex justify-content-center">
                {{ $sessions->withQueryString()->links() }}
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Delete Session Modals -->
@isset($sessions)
@foreach($sessions as $session)
@if(in_array($session->status, ['pending', 'cancelled']))
<div class="modal fade" id="deleteSessionModal{{ $session->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="color: var(--primary-color);">Delete Session</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <i class="fas fa-exclamation-triangle fa-3x text-warning"></i>
                </div>
                <p class="text-center">Are you sure you want to delete session <strong style="color: var(--primary-color);">#{{ $session->id }}</strong>?</p>
                <div class="alert alert-warning" style="background-color: rgba(247, 194, 68, 0.2); border: 1px solid rgba(247, 194, 68, 0.3); color: #f7c244;">
                    <i class="fas fa-info-circle me-2"></i>
                    This action cannot be undone. All related data will be permanently deleted.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('admin.sessions.destroy', $session) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-2"></i>Delete Session
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif
@endforeach
@endisset
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search enhancement
    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput) {
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                this.closest('form').submit();
            }
        });
    }
    
    // Tooltip initialization for action buttons
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Confirmation for status changes
    const statusForms = document.querySelectorAll('form[action*="update-status"]');
    statusForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const status = this.querySelector('input[name="status"]').value;
            if (status === 'cancelled') {
                if (!confirm('Are you sure you want to cancel this session?')) {
                    e.preventDefault();
                }
            }
        });
    });
});
</script>
@endsection