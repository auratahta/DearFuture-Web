<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DearFuture - Subjects</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Krona+One&family=Rubik:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/subject.css') }}">
</head>

<body>
    <!-- Navbar Start -->
    <nav class="navbar">
        <a href="#" class="navbar-logo">DearFuture</a>
        
        <div class="navbar-nav">
            <a href="{{ url('/student/menu') }}">Home</a>
            <a href="{{ url('/student/history') }}" class="active">History</a>
        </div>
        
        <div class="navbar-extra">
            <span class="user-name">Aura Tahta</span>
            <img src="{{ asset('image/profile.png') }}" alt="User Profile" class="user-avatar">
        </div>
    </nav>
    <!-- Navbar End -->
    
    <div class="container">
        <!-- Main Content -->
        <div class="content-container">
            <!-- Subject Grid -->
            <div class="subject-grid">
                <!-- Row 1 -->
                <a href="{{ url('/student/find') }}" class="subject-card">
                    <img src="{{ asset('image/subjects/Big Sale.png') }}" alt="Big Deals" class="subject-icon">
                    <p class="subject-name">BIG DEALS</p>
                </a>
                
                <a href="{{ url('/student/find') }}" class="subject-card">
                    <img src="{{ asset('image/subjects/Snbt.png') }}" alt="SNBT" class="subject-icon">
                    <p class="subject-name">SNBT</p>
                </a>
                
                <a href="{{ url('/student/find') }}" class="subject-card">
                    <img src="{{ asset('image/subjects/math.png') }}" alt="Math" class="subject-icon">
                    <p class="subject-name">Math</p>
                </a>
                
                <a href="{{ url('/find') }}" class="subject-card">
                    <img src="{{ asset('image/subjects/physics.png') }}" alt="Physics" class="subject-icon">
                    <p class="subject-name">Physics</p>
                </a>
                
                <!-- Row 2 -->
                <div class="subject-card">
                    <img src="{{ asset('image/subjects/biology.png') }}" alt="Biology" class="subject-icon">
                    <p class="subject-name">Biology</p>
                </div>
                
                <div class="subject-card">
                    <img src="{{ asset('image/subjects/chemistry.png') }}" alt="Chemistry" class="subject-icon">
                    <p class="subject-name">Chemistry</p>
                </div>
                
                <div class="subject-card">
                    <img src="{{ asset('image/subjects/indonesian.png') }}" alt="Bahasa Indonesia" class="subject-icon">
                    <p class="subject-name">Bahasa Indonesia</p>
                </div>
                
                <div class="subject-card">
                    <img src="{{ asset('image/subjects/english.png') }}" alt="English" class="subject-icon">
                    <p class="subject-name">English</p>
                </div>
                
                <!-- Row 3 -->
                <div class="subject-card">
                    <img src="{{ asset('image/subjects/economics.png') }}" alt="Economics" class="subject-icon">
                    <p class="subject-name">Economics</p>
                </div>
                
                <div class="subject-card">
                    <img src="{{ asset('image/subjects/geography.png') }}" alt="Geography" class="subject-icon">
                    <p class="subject-name">Geography</p>
                </div>
                
                <div class="subject-card">
                    <img src="{{ asset('image/subjects/history.png') }}" alt="History" class="subject-icon">
                    <p class="subject-name">History</p>
                </div>
                
                <div class="subject-card">
                    <img src="{{ asset('image/subjects/sosiology.png') }}" alt="Sociology" class="subject-icon">
                    <p class="subject-name">Sociology</p>
                </div>
            </div>
            
            <!-- Promotions Area -->
            <div class="promotions">
                <!-- Promo Article 1 -->
                <a href="#" class="promo-article">
                    <div class="promo-image">
                        <img src="{{ asset('image/promo.png') }}" alt="Promotion: Diskon hingga 58%">
                        <span class="promo-tag">PROMO</span>
                    </div>
                    <div class="promo-content">
                        <div class="promo-text">
                            <h3>Promo Spesial: Diskon hingga 58%</h3>
                            <p>Tidak ada kata terlambat untuk hemat. Manfaatkan promo spesial kami dengan diskon hingga 58% untuk semua pelajaran. Kesempatan terbatas!</p>
                        </div>
                        <div class="promo-footer">
                            <span class="read-more">Baca Selengkapnya <i class="arrow-icon">→</i></span>
                            <span class="promo-date">Berlaku hingga 31 Maret 2025</span>
                        </div>
                    </div>
                </a>
                
                <!-- SNBT News Article -->
                <a href="#" class="promo-article">
                    <div class="promo-image">
                        <img src="{{ asset('image/promo2.jpg') }}" alt="SNPMB 2025 News">
                        <span class="promo-tag snbt">SNBT</span>
                    </div>
                    <div class="promo-content">
                        <div class="promo-text">
                            <h3>Kemendikbud Ristek Luncurkan SNPMB 2025, Berikut Jadwal SNBP dan UTBK-SNBT</h3>
                            <p>Jakarta, Berita UIN Online - Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi resmi meluncurkan sistem Seleksi Nasional Penerimaan Mahasiswa Baru (SNPMB) tahun 2025 dalam Konferensi Pers di Gedung Kemendikbudristek, Jakarta.</p>
                        </div>
                        <div class="promo-footer">
                            <span class="read-more">Baca Selengkapnya <i class="arrow-icon">→</i></span>
                            <span class="promo-date">11 Desember 2024</span>
                        </div>
                    </div>
                </a>
                
                <!-- Scholarship News Article -->
                <a href="#" class="promo-article">
                    <div class="promo-image">
                        <img src="{{ asset('image/promo3.jpg') }}" alt="Australia Scholarship News">
                        <span class="promo-tag beasiswa">BEASISWA</span>
                    </div>
                    <div class="promo-content">
                        <div class="promo-text">
                            <h3>Peluang Emas! 6 Universitas Ternama Australia Tawarkan Beasiswa Fully Funded Tahun 2025</h3>
                            <p>Australia merupakan salah satu negara dengan pendidikan terbaik di dunia, banyak universitas ternama yang menawarkan program beasiswa fully funded bagi mahasiswa Indonesia. Kesempatan ini dibuka untuk program sarjana hingga doktoral.</p>
                        </div>
                        <div class="promo-footer">
                            <span class="read-more">Baca Selengkapnya <i class="arrow-icon">→</i></span>
                            <span class="promo-date">Maret 2025</span>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>