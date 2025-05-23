<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dear Future</title>

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Krona+One&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Style -->
    <link rel="stylesheet" href="{{ asset('css/menu.css') }}">
</head>

<body>
    <!-- Navbar Start -->
    <nav class="navbar">
        <a href="#" class="navbar-logo">DearFuture</a>
        
        <div class="navbar-nav">
            <a href="{{ url('/student/menu') }}" class="active">Home</a>
            <a href="{{ url('/student/history') }}">History</a>
        </div>
        
        <div class="navbar-extra" onclick="window.location.href='{{ route('student.profile') }}';" style="cursor: pointer;">
            <span class="user-name">{{ Auth::user()->name }}</span>
            <img src="{{ Auth::user()->photo ? asset('storage/'.Auth::user()->photo) : asset('image/profile.png') }}" alt="User Profile" class="user-avatar">
        </div>
    </nav>
    <!-- Navbar End -->

    <!-- LandingPage Section Start -->
    <section class="LandingPage" id="Home">
        <main class="content">
            <h1>Bridging Minds, Building Futures!</h1>
            <p>DearFuture is an educational platform that connects high school students with expert mentors to help them achieve their goals. With mentors specializing in various fields, students can find the perfect guide to match their dreams and interests. Start your journey with the right mentorship and shape a brighter future today!</p>
        </main>
        <div class="logo-container">
            <img src="{{ asset('image/Logo.png') }}" alt="DearFuture Logo">
        </div>
    </section>
    <!-- LandingPage Section End -->

    <!-- Features Section Start -->
    <section class="features">
        <div class="container">
            <div class="feature-card" onclick="window.location.href='{{ url('/student/subjects') }}';" style="cursor: pointer;">
                <div class="feature-icon">
                    <img src="{{ asset('image/Mentor.png') }}" alt="DearFuture Mentor">
                </div>
                <h2>Find your Mentor</h2>
                <p>Connect with expert mentors based on their specialization, availability, and preferred schedule</p>
            </div>


            <div class="feature-card" onclick="window.location.href='{{ url('/student/news') }}';" style="cursor: pointer;">
                <div class="feature-icon">
                    <img src="{{ asset('image/news.png') }}" alt="DearFuture news">
                </div>
                <h2>News</h2>
                <p>Access valuable resources, including scholarship opportunities, exam schedules, and inspiring articles</p>
            </div>

            <div class="feature-card" onclick="window.location.href='{{ url('/student/menu') }}';" style="cursor: pointer;">
                <div class="feature-icon">
                    <img src="{{ asset('image/review.png') }}" alt="DearFuture review">
                </div>
                <h2>Review</h2>
                <p>Gain confidence through authentic reviews, ensuring a high-quality mentoring experience</p>
            </div>
        </div>
    </section>
    <!-- Features Section End -->

    <!-- About Us Start -->
    <section id="about" class="about">
        <div class="container">
            <div class="about-content">
            <h2>About Us</h2>
                <p> At <span>DearFuture</span>, we are passionate about empowering students by bridging the gap between education and mentorship. We understand that every student has unique aspirations and the right guidance can make all the difference in shaping their future. That's why we created <span> DearFuture </span> — a platform dedicated to connecting students with experienced mentors who can provide insights, advice, and support in their academic and career journeys </p>
            </div>
        </div>
    </section>
    <!--About Us End -->

    <!-- Features Visi Misi Start -->
    <section class="vision-mission">
        <div class="container">
            <div class="vision-mission-content">
                <div class="vision-content">
                    <h2>VISION & MISSION</h2>
                </div>
                <div class="mission-text">
                    <p>We aim to make quality mentorship and educational guidance accessible to all students, helping them unlock their full potential. By providing a space where students can seek advice from knowledgeable mentors, we strive to create an environment that fosters learning, growth, and success.</p>
                </div>
            </div>
        </div>
    </section>
    <!-- Features Visi Misi End -->

    <!-- Offering Section Start -->
    <section class="offering">
        <div class="container"> 
            <div class="offering-header">
                <h2>What We Offer ?</h2>
            </div>
            <div class="offering-content">
                <div class="offering-card">
                    <h3>Mentorship Connection</h3>
                    <p>Students can easily find and connect with mentors based on their expertise and specialization. Our mentors come from various fields, offering guidance on university admissions, scholarship opportunities, career planning, and skill development</p>
                </div>

                <div class="offering-card">
                    <h3>A Supportive Community</h3>
                    <p>DearFuture is more than just a platform—it's a growing community of learners and educators working together to inspire, learn, and grow.</p>
                </div>

                <div class="offering-card">
                <h3>Educational Resources</h3>
                <p>We provide a wide range of informative articles covering topics such as scholarships, UTBK exam schedules, study tips, and career insights. These resources are designed to help students stay informed and prepared for the challenges ahead</p>
                </div>
            </div>
        </div>
    </section>
    <!-- Offering Section End -->

    <!-- App Showcase Section Start -->
    <section class="app-showcase">
        <div class="container">
            <div class="showcase-content">
                <div class="showcase-text">
                    <h2>Get the DearFuture App</h2>
                    <p>Find mentors, access educational resources, and connect with our community anytime, anywhere. Download the DearFuture app today and take the first step towards building your brighter future.</p>
                    
                    <div class="app-store-buttons">
                        <a href="#" class="store-button playstore">
                            <i class="fab fa-google-play"></i>
                            <span class="button-text">
                                <span class="small-text">GET IT ON</span>
                                <span class="large-text">Google Play</span>
                            </span>
                        </a>
                        
                        <a href="#" class="store-button appstore">
                            <i class="fab fa-apple"></i>
                            <span class="button-text">
                                <span class="small-text">Download on the</span>
                                <span class="large-text">App Store</span>
                            </span>
                        </a>
                    </div>
                </div>
                
                <div class="showcase-image">
                    <img src="{{ asset('image/hp.png') }}" alt="DearFuture App Screenshot">
                    <div class="image-glow"></div>
                </div>
            </div>
        </div>
    </section>
    <!-- App Showcase Section End -->

    <!-- Review Section Start -->
    <section class="review-section">
        <div class="background-elements">
            <div class="circle circle-1"></div>
            <div class="circle circle-2"></div>
            <div class="circle circle-3"></div>
        </div>
        
        <div class="container">
            <div class="review-header">
                <h2 class="section-title">Review</h2>
                <p class="section-subtitle">Cerita & Pengalaman Seru Mereka Tentang Aplikasi Dear Future</p>
            </div>
            
            <div class="testimonials-container">
                <!-- Testimonial 1 -->
                <div class="testimonial-card">
                    <div class="quote-icon">"</div>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="testimonial-text">Sebelum Pakai Dear Future saya kurang sekali dalam pelajaran. Tetapi setelah mendapat mentor dari Dear Future alhamdulillah jadi lebih bisa paham sama materi yang diajarkan.</p>
                    <div class="user-info">
                        <div class="user-photo">
                            <img src="{{ asset('image/student1.jpg') }}" alt="Nauly Manalu's Photo">
                        </div>
                        <div class="user-details">
                            <h3 class="user-student">Nauly Manalu</h3>
                            <p class="user-role">Pelajar</p>
                        </div>
                    </div>
                </div>
                
                <!-- Testimonial 2 -->
                <div class="testimonial-card">
                    <div class="quote-icon">"</div>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="testimonial-text">Mentornya ramah banget!! Sangat membantu jelaskan soal yang gak aku ngerti secara detail. The best banget Dear Future!!</p>
                    <div class="user-info">
                        <div class="user-photo">
                            <img src="{{ asset('image/student2.jpg') }}" alt="Mark Keifer's Photo">
                        </div>
                        <div class="user-details">
                            <h3 class="user-student">Mark Keifer</h3>
                            <p class="user-role">Pelajar</p>
                        </div>
                    </div>
                </div>
                
                <!-- Testimonial 3 -->
                <div class="testimonial-card">
                    <div class="quote-icon">"</div>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="testimonial-text">Nilai matematika saya meningkat. Saya senang belajar secara private dengan Kak Dea di Dear Future. Saya jadi lebih fokus, juga membantu saya lebih paham pelajaran matematika</p>
                    <div class="user-info">
                        <div class="user-photo">
                            <img src="{{ asset('image/student3.jpg') }}" alt="Haechan Lee's Photo">
                        </div>
                        <div class="user-details">
                            <h3 class="user-student">Haechan Lee</h3>
                            <p class="user-role">Pelajar</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="review-footer">
                <p class="tagline">"At DearFuture, we believe that your future starts with the right guidance."</p>
                <p>Let's build your success together!</p>
            </div>
        </div>
    </section>
    <!-- Review Section End -->

    <!-- My JavaScript -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/review.js') }}"></script>
</body>
</html>