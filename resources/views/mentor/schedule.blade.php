<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DearFuture - Mentor Schedule</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Krona+One&family=Rubik:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/schedule.css') }}">
</head>

<body>
    <!-- Navbar Start -->
    <nav class="navbar">
        <a href="#" class="navbar-logo">DearFuture</a>
        
        <div class="navbar-nav">
            <a href="{{ url('/mentor/dashboard_mentor') }}">Home</a>
        </div>
        
        <div class="navbar-extra">
            <span class="user-name">Deananda Viany</span>
            <img src="{{ asset('image/profile.png') }}" alt="User Profile" class="user-avatar">
        </div>
    </nav>
    <!-- Navbar End -->
    
    <div class="container">
        <!-- Main Content -->
        <div class="content-container">
            <!-- Page Header -->
            <div class="page-header">
                <h1>Your Teaching Schedule</h1>
                <p>Manage your upcoming and past sessions</p>
            </div>
            
            <!-- Search and Filter Bar -->
            <div class="control-panel">
                <div class="search-container">
                    <input type="text" placeholder="Search by subject or student..." class="search-input">
                    <button class="search-button">Search</button>
                </div>
            </div>
            
            <!-- Filter Options -->
            <!-- <div class="filter-container">
                <div class="filter-options">
                    <button class="filter-btn active">All Classes</button>
                    <button class="filter-btn">Upcoming</button>
                    <button class="filter-btn">Ongoing</button>
                    <button class="filter-btn">Completed</button>
                </div>
                <div class="sort-options">
                    <label for="sort-select">Sort by:</label>
                    <select id="sort-select" class="sort-select">
                        <option value="recent">Date (Newest)</option>
                        <option value="oldest">Date (Oldest)</option>
                    </select>
                </div>
            </div> -->
            
            <!-- Schedule Cards -->
            <div class="schedule-cards">
                <!-- Card 1 - Ongoing -->
                <div class="schedule-card">
                    <div class="class-header">
                        <div class="class-badge ongoing">ON GOING</div>
                        <div class="class-actions">
                            <button class="action-btn primary">Start Session</button>
                            <button class="action-btn secondary">Reschedule</button>
                        </div>
                    </div>
                    
                    <div class="class-details">
                        <h2 class="class-title">11 SMA FISIKA</h2>
                        
                        <div class="detail-grid">
                            <div class="detail-item">
                                <div class="detail-label">Date:</div>
                                <div class="detail-value">Monday, 2 March 2025</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Time:</div>
                                <div class="detail-value">19:00 - 20:30 WIB</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Student:</div>
                                <div class="detail-value">Deananda V</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Meeting Link:</div>
                                <div class="detail-value">
                                    <a href="https://us05web.zoom.us/" target="_blank" class="meeting-link">https://us05web.zoom.us/</a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="session-notes">
                            <h3>Session Notes</h3>
                            <p>Review of Newton's Laws of Motion, focusing on problem-solving techniques.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Card 2 - Upcoming -->
                <div class="schedule-card">
                    <div class="class-header">
                        <div class="class-badge upcoming">UPCOMING</div>
                        <div class="class-actions">
                            <button class="action-btn secondary">Reschedule</button>
                            <button class="action-btn danger">Cancel</button>
                        </div>
                    </div>
                    
                    <div class="class-details">
                        <h2 class="class-title">10 SMA FISIKA</h2>
                        
                        <div class="detail-grid">
                            <div class="detail-item">
                                <div class="detail-label">Date:</div>
                                <div class="detail-value">Thursday, 4 March 2025</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Time:</div>
                                <div class="detail-value">15:00 - 16:30 WIB</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Student:</div>
                                <div class="detail-value">Aura Tahta</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Meeting Link:</div>
                                <div class="detail-value">
                                    <a href="https://us07web.zoom.us/" target="_blank" class="meeting-link">https://us07web.zoom.us/</a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="session-notes">
                            <h3>Session Notes</h3>
                            <p>Introduction to basic kinematics and motion equations. Prepare examples of acceleration calculations.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Card 3 - Completed -->
                <div class="schedule-card completed">
                    <div class="class-header">
                        <div class="class-badge completed">COMPLETED</div>
                        <div class="class-actions">
                            <button class="action-btn primary">View Report</button>
                        </div>
                    </div>
                    
                    <div class="class-details">
                        <h2 class="class-title">12 SMA FISIKA</h2>
                        
                        <div class="detail-grid">
                            <div class="detail-item">
                                <div class="detail-label">Date:</div>
                                <div class="detail-value">Wednesday, 26 February 2025</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Time:</div>
                                <div class="detail-value">13:00 - 14:30 WIB</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Student:</div>
                                <div class="detail-value">Bunga Calista</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Meeting Link:</div>
                                <div class="detail-value">
                                    <a href="https://us07web.zoom.us/" target="_blank" class="meeting-link">https://us07web.zoom.us/</a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="session-notes">
                            <h3>Session Notes</h3>
                            <p>Covered electromagnetism and Faraday's Law. Student needs more practice with circuit problems.</p>
                            <div class="feedback-info">
                                <span class="rating">★★★★☆</span>
                                <span class="feedback-text">Student Rating: 4.0/5.0</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Weekly Schedule Overview -->
            <!-- <div class="weekly-overview">
                <h2 class="section-title">Weekly Overview</h2>
                <div class="calendar-container">
                    <div class="calendar-header">
                        <div class="day-header">Monday</div>
                        <div class="day-header">Tuesday</div>
                        <div class="day-header">Wednesday</div>
                        <div class="day-header">Thursday</div>
                        <div class="day-header">Friday</div>
                        <div class="day-header weekend">Saturday</div>
                        <div class="day-header weekend">Sunday</div>
                    </div>
                    <div class="calendar-body">
                        <div class="day-column">
                            <div class="calendar-event">
                                <div class="event-time">19:00 - 20:30</div>
                                <div class="event-title">11 SMA FISIKA</div>
                                <div class="event-student">Deananda V</div>
                            </div>
                        </div>
                        <div class="day-column">
                            No events
                        </div>
                        <div class="day-column">
                            <div class="calendar-event">
                                <div class="event-time">13:00 - 14:30</div>
                                <div class="event-title">12 SMA FISIKA</div>
                                <div class="event-student">Rahman S</div>
                            </div>
                        </div>
                        <div class="day-column">
                            <div class="calendar-event">
                                <div class="event-time">15:00 - 16:30</div>
                                <div class="event-title">10 SMA FISIKA</div>
                                <div class="event-student">Aura Tahta</div>
                            </div>
                        </div>
                        <div class="day-column">
                            No events
                        </div>
                        <div class="day-column weekend">
                            <div class="calendar-event">
                                <div class="event-time">09:00 - 10:30</div>
                                <div class="event-title">11 SMA FISIKA</div>
                                <div class="event-student">Maya Putri</div>
                            </div>
                        </div>
                        <div class="day-column weekend">
                            No events
                        </div>
                    </div>
                </div>
            </div> -->
            
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
    <script src="{{ asset('js/mentor.js') }}"></script>
</body>
</html>