{{-- resources/views/admin/sessions/edit.blade.php --}}
@extends('layouts.admin')

@section('title', 'Edit Session')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-white">Edit Session #{{ $session->id }}</h1>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.sessions.show', $session) }}" class="btn btn-outline-light">
            <i class="fas fa-eye me-2"></i> View Session
        </a>
        <a href="{{ route('admin.sessions.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i> Back to List
        </a>
    </div>
</div>

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <h6><i class="fas fa-exclamation-triangle me-2"></i>Please fix the following errors:</h6>
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row">
    <div class="col-lg-8">
        <div class="card session-card">
            <div class="card-header">
                <h5 class="mb-0 text-white">Edit Session Details</h5>
                <small class="text-muted">
                    @if($session->student)
                        Editing booked session details
                    @else
                        Editing availability slot for students to book
                    @endif
                </small>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.sessions.update', $session) }}" method="POST" id="sessionForm">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="mentor_id" class="form-label text-info fw-bold">Mentor <span class="text-danger">*</span></label>
                                <select name="mentor_id" id="mentor_id" class="form-select @error('mentor_id') is-invalid @enderror" required>
                                    <option value="">Select Mentor</option>
                                    @foreach($mentors as $mentor)
                                    <option value="{{ $mentor->id }}" {{ (old('mentor_id', $session->mentor_id) == $mentor->id) ? 'selected' : '' }}>
                                        {{ $mentor->name }} ({{ $mentor->email }})
                                    </option>
                                    @endforeach
                                </select>
                                @error('mentor_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="subject_id" class="form-label text-info fw-bold">Subject <span class="text-danger">*</span></label>
                                <select name="subject_id" id="subject_id" class="form-select @error('subject_id') is-invalid @enderror" required>
                                    <option value="">Select Subject</option>
                                    @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}" {{ (old('subject_id', $session->subject_id) == $subject->id) ? 'selected' : '' }}>
                                        {{ $subject->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('subject_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status" class="form-label text-info fw-bold">Status <span class="text-danger">*</span></label>
                                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                    <option value="available" {{ old('status', $session->status) === 'available' ? 'selected' : '' }}>Available for Booking</option>
                                    <option value="booked" {{ old('status', $session->status) === 'booked' ? 'selected' : '' }}>Booked (Pending Payment)</option>
                                    <option value="pending" {{ old('status', $session->status) === 'pending' ? 'selected' : '' }}>Pending Payment</option>
                                    <option value="confirmed" {{ old('status', $session->status) === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                    <option value="ongoing" {{ old('status', $session->status) === 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                                    <option value="completed" {{ old('status', $session->status) === 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ old('status', $session->status) === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                                @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6" id="student-field">
                            <div class="mb-3">
                                <label for="student_id" class="form-label text-info fw-bold">Student</label>
                                <select name="student_id" id="student_id" class="form-select @error('student_id') is-invalid @enderror">
                                    <option value="">No student (Available slot)</option>
                                    @foreach($students as $student)
                                    <option value="{{ $student->id }}" {{ (old('student_id', $session->student_id) == $student->id) ? 'selected' : '' }}>
                                        {{ $student->name }} ({{ $student->email }})
                                    </option>
                                    @endforeach
                                </select>
                                @error('student_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Leave empty for availability slots</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="date" class="form-label text-info fw-bold">Date <span class="text-danger">*</span></label>
                                <input type="date" name="date" id="date" class="form-control @error('date') is-invalid @enderror" 
                                       value="{{ old('date', $session->date ? $session->date->format('Y-m-d') : '') }}" required>
                                @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="price" class="form-label text-info fw-bold">Price (Rp) <span class="text-danger">*</span></label>
                                <input type="number" name="price" id="price" class="form-control @error('price') is-invalid @enderror" 
                                       value="{{ old('price', $session->price) }}" min="0" step="1000" required>
                                @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="start_time" class="form-label text-info fw-bold">Start Time <span class="text-danger">*</span></label>
                                <input type="time" name="start_time" id="start_time" class="form-control @error('start_time') is-invalid @enderror" 
                                       value="{{ old('start_time', $session->start_time ? \Carbon\Carbon::parse($session->start_time)->format('H:i') : '') }}" required>
                                @error('start_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="end_time" class="form-label text-info fw-bold">End Time <span class="text-danger">*</span></label>
                                <input type="time" name="end_time" id="end_time" class="form-control @error('end_time') is-invalid @enderror" 
                                       value="{{ old('end_time', $session->end_time ? \Carbon\Carbon::parse($session->end_time)->format('H:i') : '') }}" required>
                                @error('end_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- NEW: Meeting Link Field -->
                    <div class="mb-3">
                        <label for="meeting_link" class="form-label text-info fw-bold">Meeting Link</label>
                        <input type="url" name="meeting_link" id="meeting_link" class="form-control @error('meeting_link') is-invalid @enderror" 
                               value="{{ old('meeting_link', $session->meeting_link) }}" placeholder="https://zoom.us/j/123456789 atau link meeting lainnya">
                        @error('meeting_link')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            Link meeting untuk session ini. Akan dikirim ke student ketika session dikonfirmasi.
                        </small>
                    </div>

                    <div class="mb-4">
                        <label for="notes" class="form-label text-info fw-bold">Notes</label>
                        <textarea name="notes" id="notes" rows="3" class="form-control @error('notes') is-invalid @enderror" 
                                  placeholder="Additional notes about this session...">{{ old('notes', $session->notes) }}</textarea>
                        @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    @if($errors->has('conflict'))
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        {{ $errors->first('conflict') }}
                    </div>
                    @endif

                    <div class="d-flex justify-content-between">
                        <div>
                            @if(in_array($session->status, ['pending', 'cancelled']))
                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteSessionModal">
                                <i class="fas fa-trash me-2"></i>Delete Session
                            </button>
                            @endif
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.sessions.show', $session) }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Session
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Current Session Info -->
        <div class="card mb-4 session-card">
            <div class="card-header">
                <h5 class="mb-0 text-white">
                    <i class="fas fa-info-circle me-2"></i> Current Session Info
                </h5>
            </div>
            <div class="card-body">
                <div class="info-item d-flex justify-content-between mb-2">
                    <span class="text-info fw-bold">Current Status:</span>
                    <span class="badge badge-{{ strtolower($session->status) }}">{{ ucfirst($session->status) }}</span>
                </div>

                <div class="info-item d-flex justify-content-between mb-2">
                    <span class="text-info fw-bold">Session Type:</span>
                    @if($session->student)
                        <span class="badge bg-info">Booked Session</span>
                    @else
                        <span class="badge bg-success">Availability Slot</span>
                    @endif
                </div>

                <div class="info-item d-flex justify-content-between mb-2">
                    <span class="text-info fw-bold">Current Date:</span>
                    <span class="text-white">{{ $session->date ? $session->date->format('d M Y') : 'No date' }}</span>
                </div>

                <div class="info-item d-flex justify-content-between mb-2">
                    <span class="text-info fw-bold">Current Time:</span>
                    <span class="text-white">{{ $session->start_time ? \Carbon\Carbon::parse($session->start_time)->format('H:i') : '--:--' }} - 
                           {{ $session->end_time ? \Carbon\Carbon::parse($session->end_time)->format('H:i') : '--:--' }} WIB</span>
                </div>

                <div class="info-item d-flex justify-content-between mb-2">
                    <span class="text-info fw-bold">Mentor:</span>
                    <span class="text-white">{{ $session->mentor->name ?? 'Not assigned' }}</span>
                </div>

                <div class="info-item d-flex justify-content-between mb-2">
                    <span class="text-info fw-bold">Student:</span>
                    <span class="text-white">{{ $session->student->name ?? 'Available for booking' }}</span>
                </div>

                <div class="info-item d-flex justify-content-between">
                    <span class="text-info fw-bold">Meeting Link:</span>
                    <span class="text-white">
                        @if($session->meeting_link)
                            <i class="fas fa-check text-success"></i> Set
                        @else
                            <i class="fas fa-times text-warning"></i> Not set
                        @endif
                    </span>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card mb-4 session-card">
            <div class="card-header">
                <h5 class="mb-0 text-white">
                    <i class="fas fa-bolt me-2"></i> Quick Status Updates
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    @if($session->status == 'pending')
                    <form action="{{ route('admin.sessions.update-status', $session) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="confirmed">
                        <button type="submit" class="btn btn-success btn-sm">
                            <i class="fas fa-check me-2"></i>Quick Confirm
                        </button>
                    </form>
                    @endif
                    
                    @if($session->status == 'confirmed')
                    <form action="{{ route('admin.sessions.update-status', $session) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="completed">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-star me-2"></i>Quick Complete
                        </button>
                    </form>
                    @endif
                    
                    @if($session->status != 'cancelled' && $session->status != 'completed')
                    <form action="{{ route('admin.sessions.update-status', $session) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="cancelled">
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to cancel this session?')">
                            <i class="fas fa-times me-2"></i>Quick Cancel
                        </button>
                    </form>
                    @endif
                </div>
                <div class="form-text mt-2 text-muted">
                    <i class="fas fa-info-circle me-1"></i>
                    These quick actions will update the status immediately. Use the form above for detailed changes.
                </div>
            </div>
        </div>
        
        <!-- Editing Guidelines -->
        <div class="card session-card">
            <div class="card-header">
                <h5 class="mb-0 text-white">
                    <i class="fas fa-lightbulb text-warning me-2"></i> Editing Guidelines
                </h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <h6 class="text-info"><i class="fas fa-info-circle me-2"></i>Status Guidelines:</h6>
                    <ul class="mb-0 small text-white">
                        <li><strong>Available:</strong> Slot open for booking (no student assigned)</li>
                        <li><strong>Booked:</strong> Student booked but hasn't paid</li>
                        <li><strong>Pending:</strong> Waiting for payment confirmation</li>
                        <li><strong>Confirmed:</strong> Payment confirmed, session ready</li>
                        <li><strong>Ongoing:</strong> Session is currently happening</li>
                        <li><strong>Completed:</strong> Session finished successfully</li>
                        <li><strong>Cancelled:</strong> Session was cancelled</li>
                    </ul>
                </div>

                <div class="alert alert-warning">
                    <h6 class="text-warning"><i class="fas fa-exclamation-triangle me-2"></i>Important Notes:</h6>
                    <ul class="mb-0 small text-white">
                        <li>Changing status to "Available" will remove student assignment</li>
                        <li>Meeting link helps students join the session</li>
                        <li>Check for scheduling conflicts before saving</li>
                        <li>End time must be after start time</li>
                        <li>Past dates may cause validation errors</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
@if(in_array($session->status, ['pending', 'cancelled']))
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
                <p class="text-center">Are you sure you want to delete session <strong>#{{ $session->id }}</strong>?</p>
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
@endif
@endsection

@push('styles')
<style>
/* Simple Session Card Styling */
.session-card {
    background-color: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.session-card .card-header {
    background-color: rgba(255, 255, 255, 0.05);
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
}

/* Form Controls */
.form-control, .form-select {
    background-color: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: #ffffff;
}

.form-control:focus, .form-select:focus {
    background-color: rgba(255, 255, 255, 0.15);
    border-color: #5af7ff;
    color: #ffffff;
    box-shadow: 0 0 0 0.25rem rgba(90, 247, 255, 0.25);
}

.form-control.is-invalid, .form-select.is-invalid {
    border-color: #dc3545;
}

.invalid-feedback {
    color: #dc3545;
}

/* Status Badges */
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

.badge-ongoing {
    background-color: #17a2b8;
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

/* Alert Styles */
.alert-info {
    background-color: rgba(23, 162, 184, 0.1);
    border-color: rgba(23, 162, 184, 0.3);
    color: #17a2b8;
}

.alert-warning {
    background-color: rgba(255, 193, 7, 0.1);
    border-color: rgba(255, 193, 7, 0.3);
    color: #ffc107;
}

.alert-danger {
    background-color: rgba(220, 53, 69, 0.1);
    border-color: rgba(220, 53, 69, 0.3);
    color: #dc3545;
}

/* Info Items */
.info-item {
    padding: 8px 0;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.info-item:last-child {
    border-bottom: none;
}

/* Responsive */
@media (max-width: 768px) {
    .info-item {
        flex-direction: column !important;
        align-items: flex-start !important;
        gap: 5px;
    }
    
    .d-flex.gap-2 {
        flex-direction: column;
        gap: 10px !important;
    }
    
    .btn {
        width: 100%;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusSelect = document.getElementById('status');
    const studentField = document.getElementById('student-field');
    const studentSelect = document.getElementById('student_id');
    
    // Handle status change
    function handleStatusChange() {
        const status = statusSelect.value;
        
        if (status === 'available') {
            studentSelect.value = '';
            studentSelect.disabled = true;
            studentField.querySelector('label').innerHTML = 'Student <small class="text-muted">(Not required for available slots)</small>';
            studentSelect.required = false;
        } else {
            studentSelect.disabled = false;
            studentField.querySelector('label').innerHTML = 'Student';
        }
    }
    
    statusSelect.addEventListener('change', handleStatusChange);
    handleStatusChange();

    // Auto-update end time when start time changes (1.5 hours later)
    const startTimeInput = document.getElementById('start_time');
    const endTimeInput = document.getElementById('end_time');
    
    startTimeInput.addEventListener('change', function() {
        if (this.value && !endTimeInput.value) {
            const startTime = new Date('2000-01-01 ' + this.value);
            startTime.setHours(startTime.getHours() + 1);
            startTime.setMinutes(startTime.getMinutes() + 30);
            
            const hours = startTime.getHours().toString().padStart(2, '0');
            const minutes = startTime.getMinutes().toString().padStart(2, '0');
            endTimeInput.value = hours + ':' + minutes;
        }
    });

    // Validate time inputs
    endTimeInput.addEventListener('change', function() {
        const startTime = startTimeInput.value;
        const endTime = this.value;
        
        if (startTime && endTime && startTime >= endTime) {
            this.setCustomValidity('End time must be after start time');
            this.classList.add('is-invalid');
        } else {
            this.setCustomValidity('');
            this.classList.remove('is-invalid');
        }
    });
    
    // Form validation before submit
    document.getElementById('sessionForm').addEventListener('submit', function(e) {
        const startTime = startTimeInput.value;
        const endTime = endTimeInput.value;
        
        if (startTime && endTime && startTime >= endTime) {
            e.preventDefault();
            alert('End time must be after start time');
            return false;
        }
    });

    // Add confirmation for quick status changes
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
</script>
@endpush