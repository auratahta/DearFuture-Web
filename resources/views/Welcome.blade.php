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

    <!-- Style -->
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
</head>

<body>
    <!-- Navbar Start -->
    <nav class= "navbar">
        <a href = "#" class="navbar-logo">DearFuture</a>

        <div class="navbar-nav">
            <a href="#Home"> Home</a>
            <a href="#About"> About Us</a>
        </div>

        <div class="navbar-extra">
            <a href="#" id="navLoginBtn">LogIn</a>
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
            <div class="feature-card">
                <div class="feature-icon">
                    <img src="{{ asset('image/Mentor.png') }}" alt="DearFuture Mentor">
                </div>
                <h2>Find your Mentor</h2>
                <p>Connect with expert mentors based on their specialization, availability, and preferred schedule</p>
                </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <img src="{{ asset('image/news.png') }}" alt="DearFuture news">
                </div>
                <h2>News</h2>
                <p>Access valuable resources, including scholarship opportunities, exam schedules, and inspiring articles</p>
            </div>

            <div class="feature-card">
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

    <!-- Review Section Start -->
    <div class="review-container">
        <div class="review-header">
            <h1>Review</h1>
            <h2>Cerita & Pengalaman Seru Mereka Tentang Aplikasi Dear Future</h2>
        </div>
        
        <div class="testimonials">
            <div class="testimonial-card">
                <div class="testimonial-content">
                    <p>Sebelum Pakai Dear Future saya kurang sekali dalam pelajaran. Tetapi setelah mendapat mentor dari Dear Future alhamdulillah jadi lebih bisa paham sama materi yang diajarkan.</p>
                    <div class="testimonial-author">
                        <div class="author-info">
                            <h3>Nauly Manalu</h3>
                            <p>Pelajar</p>
                        </div>
                        <div class="author-image">
                            <img src="{{ asset('images/testimonials/nauly.jpg') }}" alt="Nauly Manalu">
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="testimonial-card active">
                <div class="testimonial-content">
                    <p>Mentornya ramah banget! Sangat membantu jelaskan soal yang gak aku ngerti secara detail. The best banget Dear Future!!</p>
                    <div class="testimonial-author">
                        <div class="author-info">
                            <h3>Mark Keifer</h3>
                            <p>Pelajar</p>
                        </div>
                        <div class="author-image">
                            <img src="{{ asset('images/testimonials/mark.jpg') }}" alt="Mark Keifer">
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="testimonial-card">
                <div class="testimonial-content">
                    <p>Nilai matematika saya meningkat. Saya senang belajar secara private dengan Kak Dea di Dear Future. Saya jadi lebih fokus, juga membantu saya lebih paham pelajaran matematika</p>
                    <div class="testimonial-author">
                        <div class="author-info">
                            <h3>Haechan Lee</h3>
                            <p>Pelajar</p>
                        </div>
                        <div class="author-image">
                            <img src="{{ asset('images/testimonials/haechan.jpg') }}" alt="Haechan Lee">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="footer-tagline">
            <p>At DearFuture, we believe that your future starts with the right guidance. Let's build your success together!</p>
        </div>
    </div>
    <!-- Review Section End -->

    <!-- Login Modal -->
<div class="login-modal" id="loginModal">
        <div class="login-modal-content">
            <div class="login-modal-header">
                <h2>LOGIN</h2>
                <span class="close-modal">&times;</span>
            </div>
            <div class="login-modal-body">
                    <div class="form-group">
                        <input type="email" name="email" id="email" placeholder="Email" required>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" id="password" placeholder="Password" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="login-btn"><a href="{{ url('/subjects') }}">LOG IN</a></button>
                    </div>
                
                <div class="signup-link">
                    <p>Don't have an account?</p>
                    <a href="#" id="openSignupModal">SIGN UP</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Signup Modal -->
    <div class="signup-modal" id="signupModal">
        <div class="signup-modal-content">
            <div class="signup-modal-header">
                <h2>SIGN UP</h2>
                <span class="close-signup-modal">&times;</span>
            </div>
            <div class="signup-modal-body">
                <form action="#" method="POST" class="signup-form" onsubmit="event.preventDefault();">
                    <div class="form-group">
                        <input type="text" name="name" id="signup-name" placeholder="Name" required>
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" id="signup-email" placeholder="Email" required>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" id="signup-password" placeholder="Password" required>
                    </div>
                    <div class="form-group">
                        <input type="tel" name="number" id="signup-number" placeholder="Phone Number" required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="school" id="signup-school" placeholder="School" required>
                    </div>
                    <div class="form-group">
                        <input type="date" name="birthdate" id="signup-birthdate" placeholder="Birth Date" required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="parent-name" id="signup-parent-name" placeholder="Parent's Name" required>
                    </div>
                    <div class="form-group">
                        <input type="tel" name="parent-phone" id="signup-parent-phone" placeholder="Parent's Phone Number" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="signup-btn">SIGN UP</button>
                    </div>
                </form>
                <div class="login-link">
                    <p>Already have an account?</p>
                    <a href="#" id="switchToLogin">LOG IN</a>
                </div>
            </div>
        </div>
    </div>

    <!-- My JavaScript -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>