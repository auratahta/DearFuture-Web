<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DearFuture - History</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Krona+One&family=Rubik:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/history.css') }}">
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
            <!-- Page Header -->
            <div class="page-header">
                <h1>Your Learning History</h1>
                <p>Track your progress and revisit past sessions</p>
            </div>
            
            <!-- Search Bar -->
            <div class="search-container">
                <input type="text" placeholder="Search by subject or mentor..." class="search-input">
                <button class="search-button">Search</button>
            </div>
            
            <!-- Filter Options -->
            <div class="filter-container">
                <div class="filter-options">
                    <button class="filter-btn active">All</button>
                    <button class="filter-btn">Active</button>
                    <button class="filter-btn">Completed</button>
                </div>
                <div class="sort-options">
                    <label for="sort-select">Sort by:</label>
                    <select id="sort-select" class="sort-select">
                        <option value="recent">Most Recent</option>
                        <option value="oldest">Oldest</option>
                    </select>
                </div>
            </div>
            
            <!-- History Cards -->
            <div class="history-cards">
                <!-- Card 1 - Active -->
                <div class="history-card">
                    <div class="class-header">
                        <h2 class="class-title">10 SMA FISIKA</h2>
                        <div class="mentor-name">Nauly Manalu</div>
                    </div>
                    
                    <div class="class-details">
                        <div class="detail-row">
                            <div class="detail-item">
                                <img src="{{ asset('image/money.png') }}" alt="Price" class="detail-icon">
                                <span class="detail-text">Rp30.000</span>
                            </div>
                            <div class="detail-item">
                                <img src="{{ asset('image/calendar.png') }}" alt="Calendar" class="detail-icon">
                                <span class="detail-text">Sunday, 12 June</span>
                            </div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-item">
                                <img src="{{ asset('image/time.png') }}" alt="Time" class="detail-icon">
                                <span class="detail-text">11:00 - 12:00 AM</span>
                            </div>
                            <div class="detail-item link-item">
                                <img src="{{ asset('image/link.png') }}" alt="Link" class="detail-icon">
                                <a href="https://us07web.zoom.us/" class="meeting-link">https://us07web.zoom.us/</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-footer">
                        <span class="status-badge active">ACTIVE</span>
                        <button class="action-btn">Join Now</button>
                    </div>
                </div>
                
                <!-- Card 2 - Done -->
                <div class="history-card">
                    <div class="class-header">
                        <h2 class="class-title">10 SMA FISIKA</h2>
                        <div class="mentor-name">Nauly Manalu</div>
                    </div>
                    
                    <div class="class-details">
                        <div class="detail-row">
                            <div class="detail-item">
                                <img src="{{ asset('image/money.png') }}" alt="Price" class="detail-icon">
                                <span class="detail-text">Rp30.000</span>
                            </div>
                            <div class="detail-item">
                                <img src="{{ asset('image/calendar.png') }}" alt="Calendar" class="detail-icon">
                                <span class="detail-text">Sunday, 12 June</span>
                            </div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-item">
                                <img src="{{ asset('image/time.png') }}" alt="Time" class="detail-icon">
                                <span class="detail-text">11:00 - 12:00 AM</span>
                            </div>
                            <div class="detail-item link-item">
                                <img src="{{ asset('image/link.png') }}" alt="Link" class="detail-icon">
                                <a href="https://us07web.zoom.us/" class="meeting-link">https://us07web.zoom.us/</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-footer">
                        <span class="status-badge done">DONE</span>
                    </div>
                </div>
                
                <!-- Card 3 - Active -->
                <div class="history-card">
                    <div class="class-header">
                        <h2 class="class-title">11 SMA MATEMATIKA</h2>
                        <div class="mentor-name">Bunga Calista</div>
                    </div>
                    
                    <div class="class-details">
                        <div class="detail-row">
                            <div class="detail-item">
                                <img src="{{ asset('image/money.png') }}" alt="Price" class="detail-icon">
                                <span class="detail-text">Rp28.000</span>
                            </div>
                            <div class="detail-item">
                                <img src="{{ asset('image/calendar.png') }}" alt="Calendar" class="detail-icon">
                                <span class="detail-text">Monday, 13 June</span>
                            </div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-item">
                                <img src="{{ asset('image/time.png') }}" alt="Time" class="detail-icon">
                                <span class="detail-text">15:00 - 16:00 PM</span>
                            </div>
                            <div class="detail-item link-item">
                                <img src="{{ asset('image/link.png') }}" alt="Link" class="detail-icon">
                                <a href="https://us07web.zoom.us/" class="meeting-link">https://us07web.zoom.us/</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-footer">
                        <span class="status-badge active">ACTIVE</span>
                        <button class="action-btn">Join Now</button>
                    </div>
                </div>
                
                <!-- Card 4 - Done -->
                <div class="history-card">
                    <div class="class-header">
                        <h2 class="class-title">10 SMA BIOLOGI</h2>
                        <div class="mentor-name">Agatha Valensia</div>
                    </div>
                    
                    <div class="class-details">
                        <div class="detail-row">
                            <div class="detail-item">
                                <img src="{{ asset('image/money.png') }}" alt="Price" class="detail-icon">
                                <span class="detail-text">Rp32.000</span>
                            </div>
                            <div class="detail-item">
                                <img src="{{ asset('image/calendar.png') }}" alt="Calendar" class="detail-icon">
                                <span class="detail-text">Tuesday, 14 June</span>
                            </div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-item">
                                <img src="{{ asset('image/time.png') }}" alt="Time" class="detail-icon">
                                <span class="detail-text">09:00 - 10:00 AM</span>
                            </div>
                            <div class="detail-item link-item">
                                <img src="{{ asset('image/link.png') }}" alt="Link" class="detail-icon">
                                <a href="https://us07web.zoom.us/" class="meeting-link">https://us07web.zoom.us/</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-footer">
                        <span class="status-badge done">DONE</span>
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

    <!-- JavaScript -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>