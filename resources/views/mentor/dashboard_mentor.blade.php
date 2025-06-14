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
    <link rel="stylesheet" href="{{ asset('css/menu.css') }}">
</head>

<body>
    <!-- Navbar Start -->
    <nav class="navbar">
        <a href="#" class="navbar-logo">DearFuture</a>
        
        <div class="navbar-nav">
            <a href="{{ route('mentor.dashboard_mentor') }}">Home</a>
        </div>
        
        <div class="navbar-extra" onclick="window.location.href='{{ route('mentor.profile') }}';" style="cursor: pointer;">
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
            <div class="feature-card" onclick="window.location.href='{{ url('/mentor/history') }}';" style="cursor: pointer;">
                <div class="feature-icon">
                    <img src="{{ asset('image/Mentor.png') }}" alt="DearFuture Mentor">
                </div>
                <h2>Schedule</h2>
                <p>Connect with expert mentors based on their specialization, availability, and preferred schedule</p>
            </div>
        </div>
    </section>
    <!-- Features Section End -->


    <!-- My JavaScript -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/review.js') }}"></script>
</body>

</html>