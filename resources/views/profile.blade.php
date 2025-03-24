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
    
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
</head>

<body>
    <!-- Navbar Start -->
    <nav class="navbar">
        <a href="{{ url('/menu') }}" class="navbar-logo">DearFuture</a>
        
        <div class="navbar-nav">
            <a href="{{ url('/menu') }}">Home</a>
            <a href="{{ url('/history') }}">History</a>
        </div>
        
        <div class="navbar-extra">
            <span class="user-name">Aura Tahta</span>
            <img src="{{ asset('image/profile.png') }}" alt="User Profile" class="user-avatar">
        </div>
    </nav>
    <!-- Navbar End -->
    
    <div class="container">
        <div class="profile-header">
            <div class="profile-avatar"></div>
            <div class="profile-info">
                <h2 class="profile-name">Aura Tahta</h2>
                <p class="profile-phone">0812 3456 7890</p>
                <a href="mailto:auratht@gmail.com" class="profile-email">auratht@gmail.com</a>
            </div>
            <button class="edit-button">
                EDIT <i class="fas fa-pencil-alt"></i>
            </button>
        </div>

        <div class="profile-form">
            <div class="form-field">DD/MM/YYYY</div>
            <div class="form-field">School</div>
            <div class="form-field">Gender</div>
            <div class="form-field">Address</div>
            <div class="form-field">Parent's Name</div>
            <div class="form-field">Parent's Phone Number</div>
        </div>
    </div>
</body>
</html>