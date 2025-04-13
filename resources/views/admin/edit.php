@extends('layouts.admin')

@section('content')
<div class="main-content">
    <div class="content-header d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-light">Edit User: {{ $user->name }}</h1>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-light">
            <i class="fas fa-arrow-left"></i> Back to Users
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#basic-info" type="button">
                            Basic Info
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-details" type="button">
                            Profile Details
                        </button>
                    </li>
                    @if($user->role === 'mentor')
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#mentor-info" type="button">
                            Mentor Info
                        </button>
                    </li>
                    @endif
                </ul>
            </div>

            <div class="card-body">
                <div class="tab-content">
                    <!-- Basic Info Tab -->
                    <div class="tab-pane fade show active" id="basic-info">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $user->name) }}" 
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', $user->email) }}" 
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="role" class="form-label">User Role</label>
                                <select class="form-select @error('role') is-invalid @enderror" 
                                        id="role" 
                                        name="role" 
                                        required>
                                    <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>
                                        Admin
                                    </option>
                                    <option value="mentor" {{ old('role', $user->role) === 'mentor' ? 'selected' : '' }}>
                                        Mentor
                                    </option>
                                    <option value="pelajar" {{ old('role', $user->role) === 'pelajar' ? 'selected' : '' }}>
                                        Student
                                    </option>
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">
                                    Password 
                                    <small class="text-muted">(leave blank to keep current)</small>
                                </label>
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password" 
                                       autocomplete="new-password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Profile Details Tab -->
                    <div class="tab-pane fade" id="profile-details">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" 
                                       class="form-control" 
                                       id="phone" 
                                       name="phone" 
                                       value="{{ old('phone', $user->profile->phone ?? '') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="photo" class="form-label">Profile Photo</label>
                                <input type="file" 
                                       class="form-control" 
                                       id="photo" 
                                       name="photo" 
                                       accept="image/*">
                                @if($user->profile && $user->profile->photo)
                                    <div class="mt-2">
                                        <small class="text-muted">Current Photo:</small>
                                        <img src="{{ asset('storage/' . $user->profile->photo) }}" 
                                             alt="Current Photo" 
                                             class="img-thumbnail" 
                                             style="max-height: 100px;">
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" 
                                      id="address" 
                                      name="address" 
                                      rows="3">{{ old('address', $user->profile->address ?? '') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="bio" class="form-label">Bio</label>
                            <textarea class="form-control" 
                                      id="bio" 
                                      name="bio" 
                                      rows="4">{{ old('bio', $user->profile->bio ?? '') }}</textarea>
                        </div>
                    </div>

                    <!-- Mentor Info Tab (if applicable) -->
                    @if($user->role === 'mentor')
                    <div class="tab-pane fade" id="mentor-info">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="hourly_rate" class="form-label">Hourly Rate (Rp)</label>
                                <input type="number" 
                                       class="form-control" 
                                       id="hourly_rate" 
                                       name="hourly_rate" 
                                       value="{{ old('hourly_rate', $user->mentorProfile->hourly_rate ?? 0) }}"
                                       min="0" 
                                       step="1000">
                            </div>

                            <div class="col-md-6 mb-3 d-flex align-items-end">
                                <div class="form-check">
                                    <input type="checkbox" 
                                           class="form-check-input" 
                                           id="is_active" 
                                           name="is_active" 
                                           {{ old('is_active', $user->mentorProfile->is_active ?? false) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        Available for Mentoring
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="experience" class="form-label">Professional Experience</label>
                                <textarea class="form-control" 
                                          id="experience" 
                                          name="experience" 
                                          rows="3">{{ old('experience', $user->mentorProfile->experience ?? '') }}</textarea>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="education" class="form-label">Educational Background</label>
                                <textarea class="form-control" 
                                          id="education" 
                                          name="education" 
                                          rows="3">{{ old('education', $user->mentorProfile->education ?? '') }}</textarea>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update User
                </button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary ms-2">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const roleSelect = document.getElementById('role');
    const mentorTab = document.querySelector('button[data-bs-target="#mentor-info"]');
    const mentorPane = document.getElementById('mentor-info');

    function toggleMentorTab() {
        const isMentor = roleSelect.value === 'mentor';
        
        if (mentorTab) {
            mentorTab.style.display = isMentor ? 'block' : 'none';
        }
        
        if (mentorPane) {
            mentorPane.classList.toggle('show', isMentor);
            mentorPane.classList.toggle('active', isMentor);
        }
    }

    roleSelect.addEventListener('change', toggleMentorTab);
    
    // Initial check on page load
    toggleMentorTab();

    // Photo preview
    const photoInput = document.getElementById('photo');
    photoInput.addEventListener('change', function(event) {
        const file = event.target.files[0];
        const reader = new FileReader();
        
        reader.onload = function(e) {
            // Check if preview already exists
            let preview = document.querySelector('.photo-preview');
            if (!preview) {
                preview = document.createElement('img');
                preview.classList.add('photo-preview', 'img-thumbnail', 'mt-2');
                preview.style.maxHeight = '100px';
                event.target.closest('.mb-3').appendChild(preview);
            }
            preview.src = e.target.result;
        };
        
        if (file) {
            reader.readAsDataURL(file);
        }
    });
});
</script>
@endpush