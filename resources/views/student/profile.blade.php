<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DearFuture - Profile</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Krona+One&family=Rubik:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
        
</head>

<body>
    <!-- Navbar Start -->
    <nav class="navbar">
        <a href="#" class="navbar-logo">DearFuture</a>
        <div class="navbar-nav">
            <a href="{{url('/student/menu')}}">Home</a>
            <a href="{{ route('student.history') }}">History</a>
            <a href="{{ route('student.profile') }}" class="active">Profile</a>
        </div>
        
        <div class="navbar-extra">
            <span class="user-name">{{ $user->name }}</span>
            <img src="{{ $user->photo ? asset('storage/'.$user->photo) : asset('image/profile.png') }}" alt="User Profile" class="user-avatar">
        </div>
    </nav>
    <!-- Navbar End -->
    
    <div class="container">
        <div class="profile-header">
            <div class="profile-avatar">
                <img src="{{ $user->photo ? asset('storage/'.$user->photo) : asset('image/profile.png') }}" alt="{{ $user->name }}">
            </div>
            <div class="profile-info">
                <h2 class="profile-name">{{ $user->name }}</h2>
                <p class="profile-phone">{{ $user->phone ?: 'No phone number' }}</p>
                <a href="mailto:{{ $user->email }}" class="profile-email">{{ $user->email }}</a>
            </div>
            <button class="edit-button" id="editProfileBtn">
                EDIT <i class="fas fa-pencil-alt"></i>
            </button>
        </div>

        <!-- View Profile Section -->
        <div class="profile-form" id="viewProfileSection">
            <div class="form-field">
                <span class="form-field-label">Birth Date</span>
                {{ $user->birthdate ? date('d/m/Y', strtotime($user->birthdate)) : 'DD/MM/YYYY' }}
            </div>
            <div class="form-field">
                <span class="form-field-label">School</span>
                {{ $user->school ?: 'Not specified' }}
            </div>
            <div class="form-field">
                <span class="form-field-label">Gender</span>
                {{ $user->gender ?: 'Not specified' }}
            </div>
            <div class="form-field">
                <span class="form-field-label">Address</span>
                {{ $user->address ?: 'Not specified' }}
            </div>
            <div class="form-field">
                <span class="form-field-label">Parent's Name</span>
                {{ $user->parent_name ?: 'Not specified' }}
            </div>
            <div class="form-field">
                <span class="form-field-label">Parent's Phone Number</span>
                {{ $user->parent_phone ?: 'Not specified' }}
            </div>
        </div>

        <!-- Edit Profile Form -->
        <div class="edit-profile-form" id="editProfileSection">
            <form action="{{ route('student.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" value="{{ $user->name }}" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ $user->email }}" required>
                </div>
                
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="text" id="phone" name="phone" value="{{ $user->phone }}">
                </div>
                
                <div class="form-group">
                    <label for="birthdate">Birth Date</label>
                    <input type="date" id="birthdate" name="birthdate" value="{{ $user->birthdate }}">
                </div>
                
                <div class="form-group">
                    <label for="school">School</label>
                    <input type="text" id="school" name="school" value="{{ $user->school }}">
                </div>
                
                <div class="form-group">
                    <label for="gender">Gender</label>
                    <select id="gender" name="gender">
                        <option value="">Select Gender</option>
                        <option value="Male" {{ $user->gender == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ $user->gender == 'Female' ? 'selected' : '' }}>Female</option>
                        <option value="Other" {{ $user->gender == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea id="address" name="address" rows="3">{{ $user->address }}</textarea>
                </div>
                
                <div class="form-group">
                    <label for="parent_name">Parent's Name</label>
                    <input type="text" id="parent_name" name="parent_name" value="{{ $user->parent_name }}">
                </div>
                
                <div class="form-group">
                    <label for="parent_phone">Parent's Phone Number</label>
                    <input type="text" id="parent_phone" name="parent_phone" value="{{ $user->parent_phone }}">
                </div>
                
                <div class="form-group">
                    <label for="photo">Profile Photo</label>
                    <input type="file" id="photo" name="photo">
                </div>
                
                <div class="form-buttons">
                    <button type="button" class="btn btn-secondary" id="cancelEditBtn">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editProfileBtn = document.getElementById('editProfileBtn');
            const cancelEditBtn = document.getElementById('cancelEditBtn');
            const viewProfileSection = document.getElementById('viewProfileSection');
            const editProfileSection = document.getElementById('editProfileSection');
            
            editProfileBtn.addEventListener('click', function() {
                viewProfileSection.style.display = 'none';
                editProfileSection.style.display = 'block';
            });
            
            cancelEditBtn.addEventListener('click', function() {
                editProfileSection.style.display = 'none';
                viewProfileSection.style.display = 'block';
            });
        });
    </script>
</body>
</html>