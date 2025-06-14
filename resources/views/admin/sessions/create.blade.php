{{-- resources/views/admin/sessions/create.blade.php --}}
@extends('layouts.admin')

@section('title', 'Create Availability Slot')

@section('content')
<div class="header-container">
    <h1>Create Availability Slot</h1>
    <div>
        <a href="{{ route('admin.sessions.index') }}" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left me-2"></i> Cancel
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
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Create Availability Slot</h5>
                <small class="text-muted">Create time slots that students can book for mentoring sessions</small>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.sessions.store') }}" method="POST" id="sessionForm">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="mentor_id" class="form-label required">Mentor</label>
                                <select name="mentor_id" id="mentor_id" class="form-select @error('mentor_id') is-invalid @enderror" required>
                                    <option value="">Select Mentor</option>
                                    @foreach($mentors as $mentor)
                                    <option value="{{ $mentor->id }}" {{ old('mentor_id') == $mentor->id ? 'selected' : '' }}>
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
                            <div class="form-group mb-3">
                                <label for="subject_id" class="form-label required">Subject</label>
                                <select name="subject_id" id="subject_id" class="form-select @error('subject_id') is-invalid @enderror" required>
                                    <option value="">Select Subject</option>
                                    @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
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
                            <div class="form-group mb-3">
                                <label for="date" class="form-label required">Date</label>
                                <input type="date" name="date" id="date" class="form-control @error('date') is-invalid @enderror" 
                                       value="{{ old('date') }}" min="{{ date('Y-m-d') }}" required>
                                @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="price" class="form-label required">Price (Rp)</label>
                                <input type="number" name="price" id="price" class="form-control @error('price') is-invalid @enderror" 
                                       value="{{ old('price', 30000) }}" min="0" step="1000" required>
                                @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="start_time" class="form-label required">Start Time</label>
                                <input type="time" name="start_time" id="start_time" class="form-control @error('start_time') is-invalid @enderror" 
                                       value="{{ old('start_time') }}" required>
                                @error('start_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="end_time" class="form-label required">End Time</label>
                                <input type="time" name="end_time" id="end_time" class="form-control @error('end_time') is-invalid @enderror" 
                                       value="{{ old('end_time') }}" required>
                                @error('end_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- NEW: Meeting Link Field -->
                    <div class="form-group mb-3">
                        <label for="meeting_link" class="form-label">Meeting Link (Opsional)</label>
                        <input type="url" name="meeting_link" id="meeting_link" class="form-control @error('meeting_link') is-invalid @enderror" 
                               value="{{ old('meeting_link') }}" placeholder="https://zoom.us/j/123456789 atau link meeting lainnya">
                        @error('meeting_link')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            Bisa diisi sekarang atau nanti saat edit session. Link ini akan dikirim ke student ketika session dikonfirmasi.
                        </small>
                    </div>

                    <div class="form-group mb-4">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea name="notes" id="notes" rows="3" class="form-control @error('notes') is-invalid @enderror" 
                                  placeholder="Additional notes about this session...">{{ old('notes') }}</textarea>
                        @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    @if($errors->has('time'))
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        {{ $errors->first('time') }}
                    </div>
                    @endif

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.sessions.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-calendar-plus me-2"></i> Create Availability Slot
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Quick Tips & Preview Sidebar -->
    <div class="col-lg-4">
        <!-- Quick Tips -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-lightbulb text-warning me-2"></i> Quick Tips
                </h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <h6><i class="fas fa-info-circle me-2"></i>Availability Slot Guidelines:</h6>
                    <ul class="mb-0 small">
                        <li>Create time slots for students to book</li>
                        <li>Slots cannot be created in the past</li>
                        <li>End time must be after start time</li>
                        <li>Check for mentor scheduling conflicts</li>
                        <li>Default session duration is 1.5 hours</li>
                        <li>Default price is Rp 30,000</li>
                        <li><strong>Meeting link opsional</strong> - bisa diisi nanti</li>
                    </ul>
                </div>

                <div class="alert alert-success">
                    <h6><i class="fas fa-clock me-2"></i>How it works:</h6>
                    <ul class="mb-0 small">
                        <li><strong>Available:</strong> Students can book this slot</li>
                        <li><strong>Booked:</strong> Student booked but not paid yet</li>
                        <li><strong>Confirmed:</strong> Student paid, session confirmed</li>
                        <li><strong>Completed:</strong> Session finished successfully</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Slot Preview -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-eye me-2"></i> Slot Preview
                </h5>
            </div>
            <div class="card-body">
                <div id="session-preview">
                    <p class="text-muted text-center py-3">
                        <i class="fas fa-info-circle me-2"></i>
                        Fill the form to see availability slot preview
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
/* Form Enhancements */
.form-label.required::after {
    content: " *";
    color: #e74a3b;
    font-weight: bold;
}

.form-control, .form-select {
    background-color: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    color: var(--text-color);
    padding: 12px 15px;
    border-radius: 8px;
    transition: all 0.3s ease;
    font-size: 1rem;
}

.form-control:focus, .form-select:focus {
    background-color: rgba(255, 255, 255, 0.1);
    border-color: var(--primary-color);
    color: white;
    box-shadow: 0 0 0 0.25rem rgba(90, 247, 255, 0.25);
}

.form-control.is-invalid, .form-select.is-invalid {
    border-color: #e74a3b;
}

.invalid-feedback {
    color: #e74a3b;
    font-size: 0.875rem;
    margin-top: 5px;
    font-weight: 500;
}

.form-label {
    color: var(--primary-color);
    font-weight: 600;
    margin-bottom: 8px;
    font-size: 0.95rem;
}

/* Alert Enhancements */
.alert-danger {
    background-color: rgba(231, 74, 59, 0.1);
    border: 1px solid rgba(231, 74, 59, 0.3);
    color: #e74a3b;
}

.alert-danger h6 {
    color: #e74a3b;
    margin-bottom: 10px;
    font-weight: 600;
}

.alert-danger ul {
    padding-left: 20px;
}

.alert-info {
    background-color: rgba(90, 247, 255, 0.1);
    border: 1px solid rgba(90, 247, 255, 0.3);
    color: var(--primary-color);
}

.alert-info h6 {
    color: var(--primary-color);
    margin-bottom: 10px;
    font-weight: 600;
}

.alert-success {
    background-color: rgba(28, 200, 138, 0.1);
    border: 1px solid rgba(28, 200, 138, 0.3);
    color: #1cc88a;
}

.alert-success h6 {
    color: #1cc88a;
    margin-bottom: 10px;
    font-weight: 600;
}

/* Card Enhancements */
.card-title {
    color: var(--primary-color);
    font-weight: 600;
}

.text-muted {
    color: rgba(255, 255, 255, 0.6) !important;
}

/* Button Enhancements */
.btn {
    padding: 12px 24px;
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.3s ease;
    font-size: 0.95rem;
}

.btn-primary {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
    color: #0d1339;
}

.btn-primary:hover {
    background-color: rgba(90, 247, 255, 0.9);
    border-color: rgba(90, 247, 255, 0.9);
    transform: translateY(-1px);
    box-shadow: 0 4px 15px rgba(90, 247, 255, 0.3);
}

.btn-secondary {
    background-color: rgba(255, 255, 255, 0.1);
    border-color: rgba(255, 255, 255, 0.2);
    color: var(--text-color);
}

.btn-secondary:hover {
    background-color: rgba(255, 255, 255, 0.2);
    border-color: rgba(255, 255, 255, 0.3);
    color: white;
}

.btn-outline-primary {
    border-color: var(--primary-color);
    color: var(--primary-color);
}

.btn-outline-primary:hover {
    background-color: var(--primary-color);
    color: #0d1339;
}

/* Preview Styles */
#session-preview .preview-item {
    display: flex;
    flex-direction: column;
    margin-bottom: 15px;
    padding: 10px;
    background: rgba(255, 255, 255, 0.03);
    border-radius: 6px;
    border-left: 3px solid var(--primary-color);
}

#session-preview .preview-label {
    font-size: 0.8rem;
    color: rgba(255, 255, 255, 0.6);
    margin-bottom: 3px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

#session-preview .preview-value {
    font-weight: 600;
    color: var(--text-color);
}

#session-preview .badge {
    align-self: flex-start;
    margin-top: 5px;
}

/* Responsive */
@media (max-width: 768px) {
    .form-group {
        margin-bottom: 20px;
    }
    
    .btn {
        width: 100%;
        margin-bottom: 10px;
    }
    
    .d-flex.gap-2 {
        flex-direction: column;
        gap: 0 !important;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-fill end time when start time is selected (1.5 hours later)
    const startTimeInput = document.getElementById('start_time');
    const endTimeInput = document.getElementById('end_time');
    
    startTimeInput.addEventListener('change', function() {
        if (this.value && !endTimeInput.value) {
            const startTime = new Date('2000-01-01 ' + this.value);
            startTime.setHours(startTime.getHours() + 1);
            startTime.setMinutes(startTime.getMinutes() + 30); // 1.5 hours
            
            const hours = startTime.getHours().toString().padStart(2, '0');
            const minutes = startTime.getMinutes().toString().padStart(2, '0');
            endTimeInput.value = hours + ':' + minutes;
        }
        updatePreview();
    });

    // Update preview when form changes
    const formInputs = document.querySelectorAll('input, select, textarea');
    formInputs.forEach(input => {
        input.addEventListener('change', updatePreview);
        input.addEventListener('input', updatePreview);
    });

    function updatePreview() {
        const mentorSelect = document.getElementById('mentor_id');
        const subjectSelect = document.getElementById('subject_id');
        const dateInput = document.getElementById('date');
        const startTimeInput = document.getElementById('start_time');
        const endTimeInput = document.getElementById('end_time');
        const priceInput = document.getElementById('price');
        const meetingLinkInput = document.getElementById('meeting_link');

        const preview = document.getElementById('session-preview');
        
        if (mentorSelect.value || subjectSelect.value) {
            const mentorText = mentorSelect.options[mentorSelect.selectedIndex]?.text || 'Not selected';
            const subjectText = subjectSelect.options[subjectSelect.selectedIndex]?.text || 'Not selected';
            
            preview.innerHTML = `
                <div class="preview-item">
                    <div class="preview-label">Mentor</div>
                    <div class="preview-value">${mentorText}</div>
                </div>
                <div class="preview-item">
                    <div class="preview-label">Subject</div>
                    <div class="preview-value">
                        <span class="badge bg-primary">${subjectText}</span>
                    </div>
                </div>
                <div class="preview-item">
                    <div class="preview-label">Date</div>
                    <div class="preview-value">${dateInput.value || 'Not set'}</div>
                </div>
                <div class="preview-item">
                    <div class="preview-label">Time</div>
                    <div class="preview-value">${startTimeInput.value || '--:--'} - ${endTimeInput.value || '--:--'} WIB</div>
                </div>
                <div class="preview-item">
                    <div class="preview-label">Price</div>
                    <div class="preview-value">Rp ${priceInput.value ? parseInt(priceInput.value).toLocaleString('id-ID') : '30,000'}</div>
                </div>
                <div class="preview-item">
                    <div class="preview-label">Meeting Link</div>
                    <div class="preview-value">${meetingLinkInput.value || '<span class="text-muted">Will be added later</span>'}</div>
                </div>
                <div class="preview-item">
                    <div class="preview-label">Status</div>
                    <div class="preview-value">
                        <span class="badge bg-success">Available for Booking</span>
                    </div>
                </div>
                <div class="alert alert-success mt-3">
                    <small><i class="fas fa-info-circle me-2"></i>This slot will be available for students to book</small>
                </div>
            `;
        }
    }

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
        
        // Check if date is not in the past
        const selectedDate = new Date(document.getElementById('date').value);
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        
        if (selectedDate < today) {
            e.preventDefault();
            alert('Session date cannot be in the past');
            return false;
        }
    });

    // Initialize preview
    updatePreview();
});
</script>
@endpush