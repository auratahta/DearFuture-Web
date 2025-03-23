<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dear Future - Subjects</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Krona+One&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/subject.css') }}">
</head>

<body>
    <div class="container">
        <!-- Header -->
        <header>
            <a href="#" class="logo">Dear Future</a>
            
            <div class="nav-menu">
                <a href="#">Home</a>
                <a href="#">History</a>
            </div>
            
            <div class="user-profile">
                <span class="user-name">Aura Tahta</span>
                <img src="{{ asset('images/avatar.jpg') }}" alt="User Profile" class="user-avatar">
            </div>
        </header>
        
        <!-- Main Content -->
        <main class="content-container">
            <!-- Subject Grid -->
            <div class="subject-grid">
                <!-- Row 1 -->
                <div class="subject-card">
                    <img src="{{ asset('images/subjects/Big Sale.png') }}" alt="Big Deals" class="subject-icon">
                    <p class="subject-name">BIG DEALS</p>
                </div>
                
                <div class="subject-card">
                    <img src="{{ asset('images/subjects/Snbt.png') }}" alt="SNBT" class="subject-icon">
                    <p class="subject-name">SNBT</p>
                </div>
                
                <div class="subject-card">
                    <img src="{{ asset('images/subjects/math.png') }}" alt="Math" class="subject-icon">
                    <p class="subject-name">Math</p>
                </div>
                
                <div class="subject-card">
                    <img src="{{ asset('images/subjects/physics.png') }}" alt="Physics" class="subject-icon">
                    <p class="subject-name">Physics</p>
                </div>
                
                <!-- Row 2 -->
                <div class="subject-card">
                    <img src="{{ asset('images/subjects/biology.png') }}" alt="Biology" class="subject-icon">
                    <p class="subject-name">Biology</p>
                </div>
                
                <div class="subject-card">
                    <img src="{{ asset('images/subjects/chemistry.png') }}" alt="Chemistry" class="subject-icon">
                    <p class="subject-name">Chemistry</p>
                </div>
                
                <div class="subject-card">
                    <img src="{{ asset('images/subjects/indonesia.png') }}" alt="Bahasa Indonesia" class="subject-icon">
                    <p class="subject-name">Bahasa Indonesia</p>
                </div>
                
                <div class="subject-card">
                    <img src="{{ asset('images/subjects/english.png') }}" alt="English" class="subject-icon">
                    <p class="subject-name">English</p>
                </div>
                
                <!-- Row 3 -->
                <div class="subject-card">
                    <img src="{{ asset('images/subjects/economics.png') }}" alt="Economics" class="subject-icon">
                    <p class="subject-name">Economics</p>
                </div>
                
                <div class="subject-card">
                    <img src="{{ asset('images/subjects/geography.png') }}" alt="Geography" class="subject-icon">
                    <p class="subject-name">Geography</p>
                </div>
                
                <div class="subject-card">
                    <img src="{{ asset('images/subjects/history.png') }}" alt="History" class="subject-icon">
                    <p class="subject-name">History</p>
                </div>
                
                <div class="subject-card">
                    <img src="{{ asset('images/subjects/sociology.png') }}" alt="Sociology" class="subject-icon">
                    <p class="subject-name">Sociology</p>
                </div>
            </div>
            
            <!-- Promotions Area -->
            <div class="promotions">
                <!-- Promo 1 -->
                <div class="promo-card">
                    <img src="{{ asset('images/promos/promo-58.jpg') }}" alt="Promotion: Tidak ada kata terlambat untuk hemat">
                </div>
                
                <!-- Promo 2 -->
                <div class="promo-card">
                    <img src="{{ asset('images/promos/promo-50.jpg') }}" alt="Promotion: Diskon 50%">
                </div>
                
                <!-- Promo 3 -->
                <div class="promo-card">
                    <img src="{{ asset('images/promos/promo-32.jpg') }}" alt="Promotion: Diskon Super Irit">
                </div>
            </div>
        </main>
    </div>
</body>
</html>