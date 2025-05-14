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
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/subject.css') }}">
</head>

<body>
    <!-- Header/Navbar -->
    <header class="header">
        <a href="{{ url('/student/menu') }}" class="logo">DearFuture</a>
        
        <nav class="nav-links">
            <a href="{{ url('/student/menu') }}">Home</a>
            <a href="{{ url('/student/history') }}">History</a>
        </nav>
        
        <div class="user-profile">
            <span class="username">{{ Auth::user()->name }}</span>
            <img src="{{ Auth::user()->photo ? asset('storage/'.Auth::user()->photo) : asset('image/profile.png') }}" alt="User Profile" class="avatar">
        </div>
    </header>
    
    <!-- Main Container -->
    <div class="container">
        @if(session('error'))
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <div>{{ session('error') }}</div>
            </div>
        @endif
        
        @php
            // Ambil subjects special
            $specialSubjects = $subjects->where('category', 'Special');
            
            // Ambil subjects akademik
            $academicSubjects = $subjects->whereNotIn('category', ['Special'])->sortBy('display_order');
        @endphp
        
        <!-- Special Subjects -->
        @if($specialSubjects->count() > 0)
            <section class="subject-section special-subjects fade-in">
                <h2 class="section-title">Special Offers</h2>
                
                <div class="subject-grid">
                    @foreach($specialSubjects as $index => $subject)
                        <a href="{{ url('/student/find') }}?subject={{ $subject->id }}" class="subject-card fade-in delay-{{ $index + 1 }}">
                            <img src="{{ $subject->icon ? asset('storage/subjects/' . $subject->icon) : asset('image/subjects/' . Str::slug($subject->name, '-') . '.png') }}" alt="{{ $subject->name }}" class="subject-icon">
                            <h3 class="subject-name">{{ $subject->name }}</h3>
                            @if($subject->description)
                                <p class="subject-description">{{ $subject->description }}</p>
                            @endif
                        </a>
                    @endforeach
                </div>
            </section>
        @endif
        
        <!-- Academic Subjects -->
        @if($academicSubjects->count() > 0)
            <section class="subject-section academic-subjects fade-in delay-2">
                <h2 class="section-title">Academic Subjects</h2>
                
                <div class="subject-grid">
                    @foreach($academicSubjects as $index => $subject)
                        <a href="{{ url('/student/find') }}?subject={{ $subject->id }}" class="subject-card fade-in delay-{{ $index % 4 + 1 }}">
                            <img src="{{ $subject->icon ? asset('storage/subjects/' . $subject->icon) : asset('image/subjects/' . Str::slug($subject->name, '-') . '.png') }}" alt="{{ $subject->name }}" class="subject-icon">
                            <h3 class="subject-name">{{ $subject->name }}</h3>
                            @if($subject->description)
                                <p class="subject-description">{{ $subject->description }}</p>
                            @endif
                        </a>
                    @endforeach
                </div>
            </section>
        @endif
    
    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2025 DearFuture. All rights reserved.</p>
    </footer>
    
    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animasi ketika halaman dimuat
            const elements = document.querySelectorAll('.fade-in');
            
            // Observer untuk animasi scroll
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = 1;
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, { threshold: 0.1 });
            
            // Observasi elemen dengan kelas fade-in
            elements.forEach(element => {
                element.style.opacity = 0;
                element.style.transform = 'translateY(20px)';
                element.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
                observer.observe(element);
            });
            
            // Hover efek untuk card
            const cards = document.querySelectorAll('.subject-card');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.querySelector('.subject-icon').style.transform = 'scale(1.2) rotate(5deg)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.querySelector('.subject-icon').style.transform = 'scale(1)';
                });
            });
        });
    </script>
</body>
</html>