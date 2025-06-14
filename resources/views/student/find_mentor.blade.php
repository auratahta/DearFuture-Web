<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DearFuture - Find {{ $subject->name }} Mentors</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Krona+One&family=Rubik:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Styles -->
    <style>
        :root {
            --bg: #131b31;
            --primary: #e4e4e4;
            --text: #70798b;
            --judul: #5af7ff;
            --accent: #ff6b6b;
            --highlight: #ffce54;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            outline: none;
            border: none;
            text-decoration: none;
        }

        body {
            font-family: "Rubik", sans-serif;
            background-color: var(--bg);
            color: var(--primary);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Navbar */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            padding: 1.4rem 7%;
            top: 0;
            left: 0;
            right: 0;
            z-index: 9999;
            border-bottom: 1px solid #a39b9b;
            background-color: var(--bg);
            width: 100%;
        }

        .navbar .navbar-logo {
            font-size: 30px;
            font-family: "Krona One";
            font-weight: 400;
            color: var(--judul);
            text-decoration: none;
            text-shadow: 0px 4px 7px rgba(90, 247, 255, 0.25);
        }

        .navbar .navbar-nav a {
            color: #fff;
            font-family: Rubik;
            font-size: 17px;
            font-weight: 400;
            margin: 0 1.5rem;
            text-decoration: none;
        }

        .navbar .navbar-nav a:hover {
            color: var(--judul);
            transition: 0.1s;
        }

        .navbar .navbar-extra {
            display: flex;
            align-items: center;
        }

        .navbar .navbar-extra .user-name {
            color: #fff;
            margin-right: 10px;
            font-family: "Krona One", "Rubik";
        }

        .navbar .navbar-extra .user-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            object-fit: cover;
        }

        /* Main Container */
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding-top: 100px;
            padding-bottom: 50px;
        }

        /* Page Header */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            background: linear-gradient(90deg, #1d293d 0%, #262f4b 100%);
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .header-content h1 {
            font-size: 32px;
            margin-bottom: 10px;
            color: white;
        }

        .header-content p {
            color: var(--text);
            font-size: 16px;
        }

        .header-image img {
            width: 80px;
            height: 80px;
            object-fit: contain;
        }

        /* Mentor Cards */
        .mentor-list {
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        .mentor-card {
            background-color: white;
            border-radius: 12px;
            padding: 25px;
            color: #333;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            display: flex;
            gap: 20px;
        }

        .mentor-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .mentor-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--judul);
            flex-shrink: 0;
        }

        .mentor-info {
            flex: 1;
        }

        .mentor-name {
            font-size: 24px;
            font-weight: bold;
            color: #1a1a1a;
            margin-bottom: 8px;
        }

        .mentor-rating {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
        }

        .stars {
            color: #ffc107;
            font-size: 16px;
        }

        .rating-text {
            color: #666;
            font-size: 14px;
        }

        .mentor-description {
            color: #555;
            line-height: 1.5;
            margin-bottom: 15px;
        }

        .mentor-subjects {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 15px;
        }

        .subject-tag {
            background-color: #f0f0f0;
            color: #555;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
        }

        .mentor-price {
            color: var(--judul);
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .mentor-actions {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn-primary {
            background-color: var(--judul);
            color: var(--bg);
        }

        .btn-primary:hover {
            background-color: #4ddee6;
            transform: translateY(-2px);
        }

        .btn-outline {
            background-color: transparent;
            color: var(--judul);
            border: 2px solid var(--judul);
        }

        .btn-outline:hover {
            background-color: var(--judul);
            color: var(--bg);
        }

        /* No mentors message */
        .no-mentors {
            text-align: center;
            padding: 50px;
            background-color: #1d293d;
            border-radius: 12px;
            margin-top: 30px;
        }

        .no-mentors h3 {
            color: white;
            margin-bottom: 10px;
        }

        .no-mentors p {
            color: var(--text);
        }

        /* Back button */
        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background-color: #2a324d;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }

        .back-button:hover {
            background-color: #3a4267;
            transform: translateY(-2px);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                width: 95%;
                padding-top: 90px;
            }

            .page-header {
                flex-direction: column;
                text-align: center;
                gap: 20px;
            }

            .mentor-card {
                flex-direction: column;
                text-align: center;
            }

            .mentor-avatar {
                align-self: center;
            }

            .mentor-actions {
                justify-content: center;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar">
        <a href="{{ url('/student/menu') }}" class="navbar-logo">DearFuture</a>
        
        <div class="navbar-nav">
            <a href="{{ url('/student/menu') }}">Home</a>
            <a href="{{ url('/student/history') }}">History</a>
        </div>
        
        <div class="navbar-extra">
            <span class="user-name">{{ Auth::user()->name }}</span>
            <img src="{{ Auth::user()->photo ? asset('storage/'.Auth::user()->photo) : asset('image/profile.png') }}" alt="User Profile" class="user-avatar">
        </div>
    </nav>

    <div class="container">
        <!-- Back Button -->
        <a href="{{ url('/student/subjects') }}" class="back-button">
            <i class="fas fa-arrow-left"></i>
            Back to Subjects
        </a>

        <!-- Page Header -->
        <div class="page-header">
            <div class="header-content">
                <h1>{{ $subject->name }} Mentors</h1>
                <p>Choose from our qualified {{ $subject->name }} tutors</p>
            </div>
            <div class="header-image">
                <img src="{{ $subject->icon ? asset('storage/subjects/' . $subject->icon) : asset('image/subjects/' . Str::slug($subject->name, '-') . '.png') }}" alt="{{ $subject->name }}">
            </div>
        </div>

        <!-- Mentor List -->
        @if($mentors->count() > 0)
            <div class="mentor-list">
                @foreach($mentors as $mentor)
                    <div class="mentor-card">
                        <img src="{{ $mentor->photo ? asset('storage/'.$mentor->photo) : asset('image/profile.png') }}" alt="{{ $mentor->name }}" class="mentor-avatar">
                        
                        <div class="mentor-info">
                            <h3 class="mentor-name">{{ $mentor->name }}</h3>
                            
                            <div class="mentor-rating">
                                <div class="stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= floor($mentor->average_rating))
                                            <i class="fas fa-star"></i>
                                        @elseif($i <= ceil($mentor->average_rating))
                                            <i class="fas fa-star-half-alt"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                </div>
                                <span class="rating-text">{{ $mentor->average_rating }}/5.0 ({{ $mentor->total_reviews }} reviews)</span>
                            </div>

                            @if($mentor->mentorProfile && $mentor->mentorProfile->bio)
                                <p class="mentor-description">{{ Str::limit($mentor->mentorProfile->bio, 120) }}</p>
                            @endif

                            <div class="mentor-subjects">
                                @foreach($mentor->mentorSubjects as $mentorSubject)
                                    <span class="subject-tag">{{ $mentorSubject->name }}</span>
                                @endforeach
                            </div>

                            <div class="mentor-price">
                                Starting from Rp 30,000/session
                            </div>

                            <div class="mentor-actions">
                                <a href="{{ route('student.mentor.profile', ['mentor' => $mentor->id, 'subject' => $subject->id]) }}" class="btn btn-primary">
                                    <i class="fas fa-calendar-plus"></i> Book Session
                                </a>
                                <a href="{{ route('student.mentor.profile', ['mentor' => $mentor->id, 'subject' => $subject->id]) }}" class="btn btn-outline">
                                    <i class="fas fa-user"></i> View Profile
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="no-mentors">
                <h3>No Mentors Available</h3>
                <p>We're sorry, but there are currently no mentors available for {{ $subject->name }}. Please check back later or contact our support team.</p>
            </div>
        @endif
    </div>

    <script>
        // Add some interactive effects
        document.addEventListener('DOMContentLoaded', function() {
            const mentorCards = document.querySelectorAll('.mentor-card');
            
            mentorCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-5px)';
                    this.style.boxShadow = '0 8px 25px rgba(0, 0, 0, 0.15)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                    this.style.boxShadow = '0 5px 15px rgba(0, 0, 0, 0.1)';
                });
            });
        });
    </script>
</body>
</html>