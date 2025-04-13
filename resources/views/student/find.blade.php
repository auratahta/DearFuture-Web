<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DearFuture - Find Courses</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Krona+One&family=Rubik:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/find.css') }}">
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
        <!-- Header with decorative elements -->
        <div class="page-header">
            <div class="header-content">
                <h1>Find Your Perfect Mentor</h1>
                <p>Choose from our selected physics tutors to help you succeed</p>
            </div>
            <div class="header-image">
                <img src="{{ asset('image/subjects/physics.png') }}" alt="Physics">
            </div>
        </div>
        
        <!-- Search Bar with filters -->
        <div class="search-section">
            <div class="search-container">
                <input type="text" id="searchInput" placeholder="Search by subject or tutor name" class="search-input">
                <button onclick="searchCourses()" class="search-button">SEARCH</button>
            </div>
            <div class="filter-tags">
                <span class="filter-tag active">All</span>
                <span class="filter-tag">Morning</span>
                <span class="filter-tag">Afternoon</span>
                <span class="filter-tag">Evening</span>
                <span class="filter-tag">Weekend</span>
            </div>
        </div>
        
        <!-- Featured Tutors Section -->
        <div class="featured-section">
            <h2 class="section-title">Featured Physics Tutors</h2>
            <div class="tutors-grid">
                <div class="tutor-card">
                    <img src="{{ asset('image/mentor1.png') }}" alt="Tutor" class="tutor-img">
                    <div class="tutor-info">
                        <h3>Nauly Manalu</h3>
                        <p>Physics Expert • 4.9 ⭐</p>
                    </div>
                </div>
                <div class="tutor-card">
                    <img src="{{ asset('image/mentor2.png') }}" alt="Tutor" class="tutor-img">
                    <div class="tutor-info">
                        <h3>Deananda Vivi</h3>
                        <p>Physics Teacher • 4.8 ⭐</p>
                    </div>
                </div>
                <div class="tutor-card">
                    <img src="{{ asset('image/mentor3.png') }}" alt="Tutor" class="tutor-img">
                    <div class="tutor-info">
                        <h3>Bang Bona</h3>
                        <p>SNBT Specialist • 5.0 ⭐</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Available Sessions Section -->
        <div class="sessions-section">
            <div class="section-header">
                <h2 class="section-title">Available Sessions</h2>
                <div class="sort-by">
                    <span>Sort by:</span>
                    <select class="sort-select">
                        <option>Newest</option>
                        <option>Price: Low to High</option>
                        <option>Price: High to Low</option>
                        <option>Rating</option>
                    </select>
                </div>
            </div>
            
            <!-- Course Cards Container -->
            <div class="course-list">
                <!-- Course Card 1 -->
                <div class="course-card">
                    <div class="card-badge">Limited Seats</div>
                    <h2 class="course-title">10 SMA FISIKA</h2>
                    <div class="course-details">
                        <div class="tutor-name">Nauly Manalu</div>
                        <div class="rating">
                            <span class="stars">★★★★★</span>
                            <span class="rating-count">(42 reviews)</span>
                        </div>
                        <div class="price-info">
                            <img src="{{ asset('image/money.png') }}" alt="Price" class="price-icon"> Rp30.000
                        </div>
                        <div class="schedule-info">
                            <img src="{{ asset('image/calendar.png') }}" alt="Calendar" class="calendar-icon"> Sunday, 12 June 
                            <img src="{{ asset('image/time.png') }}" alt="Time" class="time-icon"> 11:00 - 12:00 AM
                        </div>
                        <div class="topics-tags">
                            <span class="topic-tag">Mechanics</span>
                            <span class="topic-tag">Kinematics</span>
                            <span class="topic-tag">Energy</span>
                        </div>
                        <button class="book-button">BOOK NOW</button>
                    </div>
                </div>
                
                <!-- Course Card 2 -->
                <div class="course-card popular">
                    <div class="card-badge popular-badge">Popular</div>
                    <h2 class="course-title">11 SMA FISIKA</h2>
                    <div class="course-details">
                        <div class="tutor-name">Bunga Calista</div>
                        <div class="rating">
                            <span class="stars">★★★★☆</span>
                            <span class="rating-count">(38 reviews)</span>
                        </div>
                        <div class="price-info">
                            <img src="{{ asset('image/money.png') }}" alt="Price" class="price-icon"> Rp28.000
                            <span class="discount">Rp35.000</span>
                        </div>
                        <div class="schedule-info">
                            <img src="{{ asset('image/calendar.png') }}" alt="Calendar" class="calendar-icon"> Monday, 13 June 
                            <img src="{{ asset('imaget/time.png') }}" alt="Time" class="time-icon"> 15:00 - 16:00 PM
                        </div>
                        <div class="topics-tags">
                            <span class="topic-tag">Electromagnetism</span>
                            <span class="topic-tag">Circuits</span>
                        </div>
                        <button class="book-button">BOOK NOW</button>
                    </div>
                </div>
                
                <!-- Course Card 3 -->
                <div class="course-card">
                    <h2 class="course-title">10 SMA FISIKA</h2>
                    <div class="course-details">
                        <div class="tutor-name">Agatha Valensia</div>
                        <div class="rating">
                            <span class="stars">★★★★★</span>
                            <span class="rating-count">(51 reviews)</span>
                        </div>
                        <div class="price-info">
                            <img src="{{ asset('image/money.png') }}" alt="Price" class="price-icon"> Rp32.000
                        </div>
                        <div class="schedule-info">
                            <img src="{{ asset('image/calendar.png') }}" alt="Calendar" class="calendar-icon"> Tuesday, 14 June 
                            <img src="{{ asset('image/time.png') }}" alt="Time" class="time-icon"> 09:00 - 10:00 AM
                        </div>
                        <div class="topics-tags">
                            <span class="topic-tag">Thermodynamics</span>
                            <span class="topic-tag">Waves</span>
                            <span class="topic-tag">Optics</span>
                        </div>
                        <button class="book-button">BOOK NOW</button>
                    </div>
                </div>
            </div>
            
            <!-- Pagination -->
            <div class="pagination">
                <a href="#" class="page-link active">1</a>
                <a href="#" class="page-link">2</a>
                <a href="#" class="page-link">3</a>
                <a href="#" class="page-link next">Next →</a>
            </div>
        </div>
    </div>
    
    <!-- Need Help Section -->
    <div class="help-section">
        <div class="help-content">
            <h2>Need Help Finding the Right Class?</h2>
            <p>Our education advisors can help you find the perfect tutor for your needs</p>
            <button class="contact-button">Contact Us</button>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <p>© 2023 DearFuture Education. All rights reserved.</p>
            <div class="footer-links">
                <a href="#">Terms</a>
                <a href="#">Privacy</a>
                <a href="#">Help</a>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script src="{{ asset('js/search.js') }}"></script>
</body>
</html>