{{-- resources/views/admin/sessions/show.blade.php --}}
@extends('layouts.admin')

@section('title', 'Session Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-white">Session Details #{{ $session->id }}</h1>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.sessions.edit', $session) }}" class="btn btn-warning">
            <i class="fas fa-edit me-2"></i> Edit Session
        </a>
        <a href="{{ route('admin.sessions.index') }}" class="btn btn-outline-light">
            <i class="fas fa-arrow-left me-2"></i> Back to List
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row">
    <!-- Session Information -->
    <div class="col-lg-8">
        <div class="card mb-4 session-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-calendar-alt me-2"></i>
                    <strong>Session Information</strong>
                </div>
                <span class="badge badge-{{ strtolower($session->status) }} px-3 py-2">
                    {{ ucfirst($session->status) }}
                </span>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="info-item mb-3">
                            <label class="form-label text-info fw-bold small">SESSION ID</label>
                            <div class="text-white fs-5 fw-bold">#{{ $session->id }}</div>
                        </div>
                        
                        <div class="info-item mb-3">
                            <label class="form-label text-info fw-bold small">SUBJECT</label>
                            <div class="text-white">
                                <span class="badge bg-info text-dark px-3 py-2">
                                    <i class="fas fa-book me-1"></i>
                                    {{ $session->subject->name ?? 'N/A' }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="info-item mb-3">
                            <label class="form-label text-info fw-bold small">DATE</label>
                            <div class="text-white">
                                <i class="fas fa-calendar me-2"></i>
                                {{ $session->date ? $session->date->format('l, d F Y') : 'N/A' }}
                            </div>
                        </div>
                        
                        <div class="info-item mb-3">
                            <label class="form-label text-info fw-bold small">TIME</label>
                            <div class="text-white">
                                <i class="fas fa-clock me-2"></i>
                                {{ $session->start_time ? \Carbon\Carbon::parse($session->start_time)->format('H:i') : 'N/A' }} - 
                                {{ $session->end_time ? \Carbon\Carbon::parse($session->end_time)->format('H:i') : 'N/A' }}
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="info-item mb-3">
                            <label class="form-label text-info fw-bold small">PRICE</label>
                            <div class="text-success fs-5 fw-bold">Rp {{ number_format($session->price ?? 0, 0, ',', '.') }}</div>
                        </div>
                        
                        <div class="info-item mb-3">
                            <label class="form-label text-info fw-bold small">DURATION</label>
                            <div class="text-white">
                                <i class="fas fa-hourglass-half me-2"></i>
                                {{ $session->duration ?? 90 }} minutes
                            </div>
                        </div>
                        
                        <div class="info-item mb-3">
                            <label class="form-label text-info fw-bold small">CREATED</label>
                            <div class="text-white">{{ $session->created_at->format('d M Y, H:i') }}</div>
                        </div>
                        
                        <div class="info-item mb-3">
                            <label class="form-label text-info fw-bold small">LAST UPDATED</label>
                            <div class="text-white">{{ $session->updated_at->format('d M Y, H:i') }}</div>
                        </div>
                    </div>
                </div>
                
                <!-- Meeting Link Section -->
                @if($session->meeting_link || $session->status !== 'available')
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="info-item">
                            <label class="form-label text-info fw-bold small">MEETING LINK</label>
                            <div class="meeting-link-container">
                                @if($session->meeting_link)
                                    <div class="d-flex align-items-center gap-2">
                                        <a href="{{ $session->meeting_link }}" target="_blank" class="text-primary text-decoration-none">
                                            <i class="fas fa-video me-2"></i>
                                            {{ $session->meeting_link }}
                                        </a>
                                        <button class="btn btn-sm btn-outline-info" onclick="copyToClipboard('{{ $session->meeting_link }}')">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </div>
                                    <small class="text-success">
                                        <i class="fas fa-check-circle me-1"></i>
                                        Meeting link is ready for sharing
                                    </small>
                                @else
                                    <div class="text-warning">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        No meeting link set yet
                                    </div>
                                    <small class="text-muted">
                                        Add meeting link when editing this session
                                    </small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                
                @if($session->notes)
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="info-item">
                            <label class="form-label text-info fw-bold small">NOTES</label>
                            <div class="text-white">{{ $session->notes }}</div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Participants Information -->
        <div class="card mb-4 session-card">
            <div class="card-header">
                <i class="fas fa-users me-2"></i>
                <strong>Participants</strong>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Mentor -->
                    <div class="col-md-6 mb-4">
                        <div class="participant-box p-3 rounded">
                            <h6 class="text-info mb-3">
                                <i class="fas fa-chalkboard-teacher me-2"></i>Mentor
                            </h6>
                            @if($session->mentor)
                            <div class="d-flex align-items-center">
                                <img src="{{ $session->mentor->photo ?? asset('image/profile.png') }}" 
                                     alt="Mentor" class="rounded-circle me-3" width="60" height="60" style="object-fit: cover;">
                                <div>
                                    <div class="text-white fw-bold">{{ $session->mentor->name }}</div>
                                    <div class="text-muted">{{ $session->mentor->email }}</div>
                                    @if($session->mentor->phone)
                                    <div class="text-muted small">
                                        <i class="fas fa-phone me-1"></i>{{ $session->mentor->phone }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @else
                            <div class="text-center py-3">
                                <i class="fas fa-user-times fa-2x mb-2 text-muted"></i>
                                <p class="text-muted mb-0">No mentor assigned</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Student -->
                    <div class="col-md-6 mb-4">
                        <div class="participant-box p-3 rounded">
                            <h6 class="text-info mb-3">
                                <i class="fas fa-user-graduate me-2"></i>Student
                            </h6>
                            @if($session->student)
                            <div class="d-flex align-items-center">
                                <img src="{{ $session->student->photo ?? asset('image/profile.png') }}" 
                                     alt="Student" class="rounded-circle me-3" width="60" height="60" style="object-fit: cover;">
                                <div>
                                    <div class="text-white fw-bold">{{ $session->student->name }}</div>
                                    <div class="text-muted">{{ $session->student->email }}</div>
                                    @if($session->student->phone)
                                    <div class="text-muted small">
                                        <i class="fas fa-phone me-1"></i>{{ $session->student->phone }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @else
                            <div class="text-center py-3">
                                <i class="fas fa-calendar-plus fa-2x mb-2 text-success"></i>
                                <p class="text-success fw-bold mb-0">Available for booking</p>
                                <small class="text-muted">Students can book this slot</small>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Session Feedback -->
        @if($session->feedback)
        <div class="card mb-4 session-card">
            <div class="card-header">
                <i class="fas fa-comment-alt me-2"></i>
                <strong>Session Feedback</strong>
            </div>
            <div class="card-body">
                <div class="feedback-box p-3 rounded text-white">
                    {{ $session->feedback }}
                </div>
            </div>
        </div>
        @endif
    </div>
    
    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Quick Actions -->
        <div class="card mb-4 session-card">
            <div class="card-header">
                <i class="fas fa-bolt me-2"></i>
                <strong>Quick Actions</strong>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    @if($session->status == 'pending')
                    <form action="{{ route('admin.sessions.update-status', $session) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="confirmed">
                        <button type="submit" class="btn btn-success w-100">
                            <i class="fas fa-check me-2"></i>Confirm Session
                        </button>
                    </form>
                    @endif
                    
                    @if($session->status == 'confirmed')
                    <form action="{{ route('admin.sessions.update-status', $session) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="completed">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-star me-2"></i>Mark as Completed
                        </button>
                    </form>
                    @endif
                    
                    @if($session->status != 'cancelled' && $session->status != 'completed')
                    <form action="{{ route('admin.sessions.update-status', $session) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="cancelled">
                        <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Are you sure you want to cancel this session?')">
                            <i class="fas fa-times me-2"></i>Cancel Session
                        </button>
                    </form>
                    @endif
                    
                    <a href="{{ route('admin.sessions.edit', $session) }}" class="btn btn-warning w-100">
                        <i class="fas fa-edit me-2"></i>Edit Session
                    </a>
                    
                    @if(in_array($session->status, ['pending', 'cancelled']))
                    <button type="button" class="btn btn-outline-danger w-100" data-bs-toggle="modal" data-bs-target="#deleteSessionModal">
                        <i class="fas fa-trash me-2"></i>Delete Session
                    </button>
                    @endif
                </div>
            </div>
        </div>

        <!-- Meeting Information -->
        <div class="card mb-4 session-card">
            <div class="card-header">
                <i class="fas fa-video me-2"></i>
                <strong>Meeting Information</strong>
            </div>
            <div class="card-body">
                <div class="meeting-info">
                    @if($session->meeting_link)
                        <div class="alert alert-success">
                            <h6 class="text-success mb-2">
                                <i class="fas fa-check-circle me-2"></i>Meeting Ready
                            </h6>
                            <div class="meeting-link-box p-2 bg-dark rounded">
                                <small class="text-muted d-block mb-1">Meeting Link:</small>
                                <div class="d-flex align-items-center gap-2">
                                    <input type="text" class="form-control form-control-sm" 
                                           id="meetingLinkCopy" value="{{ $session->meeting_link }}" readonly>
                                    <button class="btn btn-sm btn-outline-light" onclick="copyToClipboard('{{ $session->meeting_link }}')">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="mt-2">
                                <a href="{{ $session->meeting_link }}" target="_blank" class="btn btn-sm btn-success w-100">
                                    <i class="fas fa-external-link-alt me-2"></i>Join Meeting
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <h6 class="text-warning mb-2">
                                <i class="fas fa-exclamation-triangle me-2"></i>Meeting Link Missing
                            </h6>
                            <p class="mb-2 small">No meeting link has been set for this session yet.</p>
                            <a href="{{ route('admin.sessions.edit', $session) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-plus me-2"></i>Add Meeting Link
                            </a>
                        </div>
                    @endif
                    
                    <div class="meeting-tips mt-3">
                        <h6 class="text-info small mb-2">
                            <i class="fas fa-lightbulb me-2"></i>Meeting Tips:
                        </h6>
                        <ul class="small text-muted mb-0">
                            <li>Zoom, Google Meet, atau platform lain</li>
                            <li>Pastikan link valid sebelum session dimulai</li>
                            <li>Student akan menerima link saat booking dikonfirmasi</li>
                            <li>Test meeting room sebelum session</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Session Timeline -->
        <div class="card mb-4 session-card">
            <div class="card-header">
                <i class="fas fa-history me-2"></i>
                <strong>Session Timeline</strong>
            </div>
            <div class="card-body">
                <div class="timeline-container">
                    <div class="timeline-item d-flex align-items-center mb-3">
                        <div class="timeline-dot bg-info me-3"></div>
                        <div>
                            <h6 class="text-white mb-1">Session Created</h6>
                            <small class="text-muted">{{ $session->created_at->format('d M Y, H:i') }}</small>
                        </div>
                    </div>
                    
                    @if($session->meeting_link)
                    <div class="timeline-item d-flex align-items-center mb-3">
                        <div class="timeline-dot bg-success me-3"></div>
                        <div>
                            <h6 class="text-white mb-1">Meeting Link Added</h6>
                            <small class="text-muted">Ready for online session</small>
                        </div>
                    </div>
                    @endif
                    
                    @if($session->student)
                    <div class="timeline-item d-flex align-items-center mb-3">
                        <div class="timeline-dot bg-info me-3"></div>
                        <div>
                            <h6 class="text-white mb-1">Student Booked</h6>
                            <small class="text-muted">{{ $session->student->name }} joined</small>
                        </div>
                    </div>
                    @endif
                    
                    @if($session->status == 'confirmed')
                    <div class="timeline-item d-flex align-items-center mb-3">
                        <div class="timeline-dot bg-success me-3"></div>
                        <div>
                            <h6 class="text-white mb-1">Session Confirmed</h6>
                            <small class="text-muted">Ready to proceed</small>
                        </div>
                    </div>
                    @endif
                    
                    @if($session->status == 'completed')
                    <div class="timeline-item d-flex align-items-center mb-3">
                        <div class="timeline-dot bg-info me-3"></div>
                        <div>
                            <h6 class="text-white mb-1">Session Completed</h6>
                            <small class="text-muted">Successfully finished</small>
                        </div>
                    </div>
                    @endif
                    
                    @if($session->status == 'cancelled')
                    <div class="timeline-item d-flex align-items-center mb-3">
                        <div class="timeline-dot bg-danger me-3"></div>
                        <div>
                            <h6 class="text-white mb-1">Session Cancelled</h6>
                            <small class="text-muted">Session was cancelled</small>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Payment Information -->
        @if($session->payment)
        <div class="card mb-4 session-card">
            <div class="card-header">
                <i class="fas fa-credit-card me-2"></i>
                <strong>Payment Information</strong>
            </div>
            <div class="card-body">
                <div class="payment-item d-flex justify-content-between mb-2">
                    <span class="text-info fw-bold">Amount:</span>
                    <span class="text-white">Rp {{ number_format($session->price ?? 0, 0, ',', '.') }}</span>
                </div>
                <div class="payment-item d-flex justify-content-between mb-2">
                    <span class="text-info fw-bold">Status:</span>
                    <span class="badge bg-success">{{ $session->payment->status ?? 'Paid' }}</span>
                </div>
                <div class="payment-item d-flex justify-content-between mb-2">
                    <span class="text-info fw-bold">Method:</span>
                    <span class="text-white">{{ $session->payment->method ?? 'N/A' }}</span>
                </div>
                <div class="payment-item d-flex justify-content-between">
                    <span class="text-info fw-bold">Date:</span>
                    <span class="text-white">{{ $session->payment->created_at->format('d M Y') ?? 'N/A' }}</span>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteSessionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header border-secondary">
                <h5 class="modal-title">Delete Session</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <i class="fas fa-exclamation-triangle fa-3x text-warning"></i>
                </div>
                <p class="text-center">Are you sure you want to delete this session?</p>
                <div class="alert alert-warning">
                    <i class="fas fa-info-circle me-2"></i>
                    This action cannot be undone. All related data will be permanently deleted.
                </div>
            </div>
            <div class="modal-footer border-secondary">
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
@endsection

@push('styles')
<style>
/* Minimal Custom Styles */
.session-card {
    background-color: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.session-card .card-header {
    background-color: rgba(255, 255, 255, 0.05);
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    color: #fff;
}

.participant-box {
    background-color: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.feedback-box {
    background-color: rgba(255, 255, 255, 0.05);
    border-left: 4px solid #5af7ff;
}

.meeting-link-container {
    background-color: rgba(255, 255, 255, 0.05);
    padding: 15px;
    border-radius: 8px;
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.meeting-link-box {
    background-color: rgba(255, 255, 255, 0.1) !important;
}

.timeline-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    flex-shrink: 0;
}

.badge-available {
    background-color: #28a745;
    color: white;
}

.badge-booked {
    background-color: #17a2b8;
    color: white;
}

.badge-pending {
    background-color: #ffc107;
    color: #212529;
}

.badge-confirmed {
    background-color: #28a745;
    color: white;
}

.badge-completed {
    background-color: #17a2b8;
    color: white;
}

.badge-cancelled {
    background-color: #dc3545;
    color: white;
}

.payment-item {
    padding: 8px 0;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.payment-item:last-child {
    border-bottom: none;
}

.alert-success {
    background-color: rgba(28, 200, 138, 0.1);
    border-color: rgba(28, 200, 138, 0.3);
    color: #1cc88a;
}

.alert-warning {
    background-color: rgba(255, 193, 7, 0.1);
    border-color: rgba(255, 193, 7, 0.3);
    color: #ffc107;
}

/* Copy button hover effect */
.btn-outline-info:hover, .btn-outline-light:hover {
    transform: scale(1.05);
}

/* Meeting link input */
#meetingLinkCopy {
    background-color: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: #fff;
    font-size: 12px;
}

#meetingLinkCopy:focus {
    background-color: rgba(255, 255, 255, 0.15);
    border-color: #5af7ff;
    color: #fff;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add confirmation for status changes
    const statusForms = document.querySelectorAll('form[action*="update-status"]');
    statusForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const status = this.querySelector('input[name="status"]').value;
            let message = `Are you sure you want to ${status} this session?`;
            
            if (!confirm(message)) {
                e.preventDefault();
            }
        });
    });
});

// Copy to clipboard function
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Show success feedback
        const button = event.target.closest('button');
        const originalIcon = button.innerHTML;
        button.innerHTML = '<i class="fas fa-check text-success"></i>';
        button.classList.add('btn-success');
        button.classList.remove('btn-outline-info', 'btn-outline-light');
        
        setTimeout(() => {
            button.innerHTML = originalIcon;
            button.classList.remove('btn-success');
            button.classList.add('btn-outline-light');
        }, 2000);
        
        // Show toast notification
        showToast('Meeting link copied to clipboard!', 'success');
    }).catch(function(err) {
        console.error('Failed to copy: ', err);
        showToast('Failed to copy meeting link', 'error');
    });
}

// Simple toast notification
function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `alert alert-${type === 'success' ? 'success' : 'danger'} position-fixed`;
    toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    toast.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
        ${message}
    `;
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.remove();
    }, 3000);
}
</script>
@endpush