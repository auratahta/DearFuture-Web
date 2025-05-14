<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DearFuture - Mentor Profile</title>
    
    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Krona+One&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Style -->
    <link rel="stylesheet" href="{{ asset('css/menu.css') }}">
    
    <style>
        /* Additional Profile Styles */
        .content-container {
            max-width: 1000px;
            margin: 30px auto;
            padding: 30px;
            background-color: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        
        .profile-section {
            margin-bottom: 30px;
        }
        
        .profile-header {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
            position: relative;
        }
        
        .profile-avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background-color: #8e9097;
            margin-right: 30px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 4px solid #5af7ff;
        }
        
        .profile-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .profile-info {
            flex: 1;
        }
        
        .profile-name {
            font-size: 28px;
            font-weight: 600;
            color: #e4e4e4;
            margin-bottom: 8px;
        }
        
        .profile-role {
            background-color: rgba(90, 247, 255, 0.2);
            color: #5af7ff;
            padding: 5px 15px;
            border-radius: 20px;
            display: inline-block;
            font-size: 14px;
            margin-bottom: 15px;
        }
        
        .edit-button {
            position: absolute;
            right: 0;
            top: 0;
            background-color: #6c757d;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            display: flex;
            align-items: center;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .edit-button:hover {
            background-color: #5a6268;
        }
        
        .edit-button i {
            margin-left: 8px;
        }
        
        .profile-content {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
        }
        
        .profile-details {
            flex: 2;
            min-width: 300px;
        }
        
        .profile-stats {
            flex: 1;
            min-width: 200px;
        }
        
        .info-card {
            background-color: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }
        
        .info-card-title {
            color: #5af7ff;
            font-size: 18px;
            font-weight: 500;
            margin-bottom: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding-bottom: 10px;
        }
        
        .info-item {
            margin-bottom: 15px;
        }
        
        .info-label {
            color: #5af7ff;
            font-size: 14px;
            margin-bottom: 5px;
        }
        
        .info-value {
            color: #e4e4e4;
            font-size: 16px;
        }
        
        .stats-card {
            background-color: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
            text-align: center;
        }
        
        .stats-value {
            font-size: 28px;
            font-weight: 600;
            color: #5af7ff;
            margin-bottom: 5px;
        }
        
        .stats-label {
            color: #e4e4e4;
            font-size: 14px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            color: #5af7ff;
            font-size: 14px;
            margin-bottom: 8px;
            display: block;
        }
        
        .form-control {
            width: 100%;
            padding: 12px 15px;
            background-color: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 5px;
            color: #e4e4e4;
            font-family: 'Rubik', sans-serif;
            font-size: 16px;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #5af7ff;
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        .form-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 30px;
        }
        
        .btn {
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            border: none;
            font-family: 'Rubik', sans-serif;
        }
        
        .btn-primary {
            background-color: #5af7ff;
            color: #131b31;
        }
        
        .btn-primary:hover {
            background-color: #45d6e0;
            transform: translateY(-2px);
        }
        
        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }
        
        .btn-secondary:hover {
            background-color: #5a6268;
            transform: translateY(-2px);
        }
        
        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            transition: opacity 0.5s;
        }
        
        .alert-success {
            background-color: rgba(40, 167, 69, 0.2);
            border: 1px solid #28a745;
            color: #28a745;
        }
        
        .alert-danger {
            background-color: rgba(220, 53, 69, 0.2);
            border: 1px solid #dc3545;
            color: #dc3545;
        }
        
        .photo-preview {
            margin-top: 15px;
        }
        
        .photo-preview img {
            max-width: 100px;
            border-radius: 5px;
        }
        
        /* Edit form initially hidden */
        .edit-form-container {
            display: none;
            margin-top: 30px;
            background-color: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            padding: 20px;
        }
        
        .edit-form-title {
            color: #5af7ff;
            font-size: 20px;
            margin-bottom: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding-bottom: 10px;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .profile-header {
                flex-direction: column;
                text-align: center;
            }
            
            .profile-avatar {
                margin-right: 0;
                margin-bottom: 20px;
            }
            
            .edit-button {
                position: relative;
                margin-top: 20px;
                justify-content: center;
                width: 100%;
            }
            
            .profile-content {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar Start -->
    <nav class="navbar">
        <a href="#" class="navbar-logo">DearFuture</a>
        
        <div class="navbar-nav">
            <a href="{{ route('mentor.dashboard_mentor')}}">Home</a>
        </div>
        
        <div class="navbar-extra" style="cursor: pointer;">
            <span class="user-name">{{ $user->name }}</span>
            <img src="{{ $user->photo ? asset('storage/'.$user->photo) : asset('image/profile.png') }}" alt="User Profile" class="user-avatar">
        </div>
    </nav>
    <!-- Navbar End -->
    
    <div class="content-container">
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        
        @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        
        <div class="profile-section">
            <div class="profile-header">
                <div class="profile-avatar">
                    <img src="{{ $user->photo ? asset('storage/'.$user->photo) : asset('image/profile.png') }}" alt="{{ $user->name }}">
                </div>
                <div class="profile-info">
                    <h2 class="profile-name">{{ $user->name }}</h2>
                    <div class="profile-role">Mentor</div>
                    <p class="profile-email">{{ $user->email }}</p>
                    <p class="profile-phone">{{ $user->phone ?: 'Phone not provided' }}</p>
                </div>
                <button class="edit-button" id="editProfileBtn">
                    EDIT <i class="fas fa-pencil-alt"></i>
                </button>
            </div>
            
            <div class="profile-content">
                <div class="profile-details">
                    <div class="info-card">
                        <h3 class="info-card-title">Personal Information</h3>
                        <div class="info-item">
                            <div class="info-label">Bio</div>
                            <div class="info-value">{{ $user->bio ?: 'No bio available' }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Address</div>
                            <div class="info-value">{{ $user->address ?: 'No address provided' }}</div>
                        </div>
                    </div>
                    
                    <div class="info-card">
                        <h3 class="info-card-title">Professional Information</h3>
                        <div class="info-item">
                            <div class="info-label">Education</div>
                            <div class="info-value">{{ $user->mentorProfile?->education ?: 'No education details provided' }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Experience</div>
                            <div class="info-value">{{ $user->mentorProfile?->experience ?: 'No experience details provided' }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Hourly Rate</div>
                            <div class="info-value">{{ $user->mentorProfile?->hourly_rate ? 'Rp ' . number_format($user->mentorProfile->hourly_rate, 0, ',', '.') . '/hour' : 'Not specified' }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Status</div>
                            <div class="info-value">
                                <span style="padding: 5px 10px; border-radius: 15px; font-size: 14px; background-color: {{ $user->mentorProfile?->is_active ? 'rgba(40, 167, 69, 0.2)' : 'rgba(220, 53, 69, 0.2)' }}; color: {{ $user->mentorProfile?->is_active ? '#28a745' : '#dc3545' }};">
                                    {{ $user->mentorProfile?->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="profile-stats">
                    <div class="info-card">
                        <h3 class="info-card-title">Statistics</h3>
                        <div class="stats-card">
                            <div class="stats-value">{{ $totalSessions ?? 0 }}</div>
                            <div class="stats-label">Total Sessions</div>
                        </div>
                        <div class="stats-card">
                            <div class="stats-value">{{ $averageRating ?? '0.0' }}</div>
                            <div class="stats-label">Average Rating</div>
                        </div>
                        <div class="stats-card">
                            <div class="stats-value">{{ $totalStudents ?? 0 }}</div>
                            <div class="stats-label">Total Students</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Edit form - initially hidden -->
            <div class="edit-form-container" id="editProfileForm">
                <h3 class="edit-form-title">Edit Profile</h3>
                <form action="{{ route('mentor.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                    </div>
                    
                    <div class="form-group">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control" id="address" name="address" rows="3">{{ old('address', $user->address) }}</textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="bio" class="form-label">Bio</label>
                        <textarea class="form-control" id="bio" name="bio" rows="4">{{ old('bio', $user->bio) }}</textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="education" class="form-label">Education</label>
                        <textarea class="form-control" id="education" name="education" rows="3">{{ old('education', $user->mentorProfile?->education) }}</textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="experience" class="form-label">Experience</label>
                        <textarea class="form-control" id="experience" name="experience" rows="3">{{ old('experience', $user->mentorProfile?->experience) }}</textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="hourly_rate" class="form-label">Hourly Rate (Rp)</label>
                        <input type="number" class="form-control" id="hourly_rate" name="hourly_rate" value="{{ old('hourly_rate', $user->mentorProfile?->hourly_rate) }}" min="0">
                    </div>
                    
                    <div class="form-group">
                        <label for="is_active" class="form-label">Availability Status</label>
                        <div style="margin-top: 10px;">
                            <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $user->mentorProfile?->is_active) ? 'checked' : '' }}>
                            <label for="is_active" style="color: #e4e4e4; margin-left: 5px;">Available for Mentoring</label>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="photo" class="form-label">Profile Photo</label>
                        <input type="file" class="form-control" id="photo" name="photo">
                        @if($user->photo)
                        <div class="photo-preview" style="margin-top: 10px;">
                            <p style="font-size: 14px; color: #5af7ff;">Current Photo:</p>
                            <img src="{{ asset('storage/'.$user->photo) }}" alt="Current Photo">
                        </div>
                        @endif
                        <div class="photo-preview"></div>
                    </div>
                    
                    <div class="form-buttons">
                        <button type="button" class="btn btn-secondary" id="cancelEditBtn">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle edit form visibility
            const editProfileBtn = document.getElementById('editProfileBtn');
            const editProfileForm = document.getElementById('editProfileForm');
            const cancelEditBtn = document.getElementById('cancelEditBtn');
            
            editProfileBtn.addEventListener('click', function() {
                editProfileForm.style.display = 'block';
                // Scroll to the form
                editProfileForm.scrollIntoView({ behavior: 'smooth' });
            });
            
            cancelEditBtn.addEventListener('click', function() {
                editProfileForm.style.display = 'none';
                // Scroll back to the top of the profile
                document.querySelector('.profile-header').scrollIntoView({ behavior: 'smooth' });
            });
            
            // Photo preview functionality
            const photoInput = document.getElementById('photo');
            const photoPreview = document.querySelector('.photo-preview');
            
            if (photoInput && photoPreview) {
                photoInput.addEventListener('change', function() {
                    // Clear existing preview (except for "Current Photo" if present)
                    const newPreviewDiv = document.createElement('div');
                    newPreviewDiv.className = 'new-preview';
                    
                    // Remove old "new preview" if exists
                    const oldNewPreview = photoPreview.querySelector('.new-preview');
                    if (oldNewPreview) {
                        photoPreview.removeChild(oldNewPreview);
                    }
                    
                    if (this.files && this.files[0]) {
                        const reader = new FileReader();
                        
                        reader.onload = function(e) {
                            const previewLabel = document.createElement('p');
                            previewLabel.textContent = 'Preview:';
                            previewLabel.style.fontSize = '14px';
                            previewLabel.style.color = '#5af7ff';
                            previewLabel.style.marginTop = '10px';
                            
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.alt = 'Photo Preview';
                            img.style.maxWidth = '100px';
                            img.style.borderRadius = '5px';
                            
                            newPreviewDiv.appendChild(previewLabel);
                            newPreviewDiv.appendChild(img);
                            photoPreview.appendChild(newPreviewDiv);
                        }
                        
                        reader.readAsDataURL(this.files[0]);
                    }
                });
            }
            
            // Auto-hide alerts after 5 seconds
            const alerts = document.querySelectorAll('.alert');
            if (alerts.length > 0) {
                setTimeout(function() {
                    alerts.forEach(function(alert) {
                        alert.style.opacity = '0';
                        setTimeout(function() {
                            alert.style.display = 'none';
                        }, 500);
                    });
                }, 5000);
            }
        });
    </script>
    
    <!-- My JavaScript -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/review.js') }}"></script>
</body>
</html>