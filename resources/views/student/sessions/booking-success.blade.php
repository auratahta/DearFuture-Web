<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DearFuture - Booking Berhasil</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Krona+One:wght@400;700&family=Rubik:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        /* Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Rubik', sans-serif;
            background-color: #131b31;
            min-height: 100vh;
            color: #ffffff;
        }
        
        /* Navbar - Exact match dari DearFuture CSS */
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
            background-color: #131b31;
            width: 100%;
        }

        .navbar .navbar-logo {
            font-size: 30px;
            font-family: "Krona One";
            font-weight: 400;
            color: #5af7ff;
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
            color: #5af7ff;
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
        
        /* Container */
        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 120px 2rem 3rem 2rem;
        }
        
        /* Success Container */
        .success-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.4);
            text-align: center;
            position: relative;
            color: #1a1f2e;
            margin: 2rem 0;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        /* Success Icon */
        .success-icon {
            width: 100px;
            height: 100px;
            background: #22c55e;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            animation: bounce 0.6s ease-out;
        }
        
        .success-icon i {
            font-size: 3rem;
            color: #ffffff;
        }
        
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-20px);
            }
            60% {
                transform: translateY(-10px);
            }
        }
        
        /* Success Text */
        .success-title {
            font-size: 2rem;
            font-weight: 700;
            color: #1a1f2e;
            margin-bottom: 1rem;
        }
        
        .success-message {
            color: #6b7280;
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 2.5rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        
        /* Session Summary */
        .session-summary {
            background: rgba(248, 250, 252, 0.7);
            border-radius: 16px;
            padding: 1.8rem;
            margin: 2rem 0;
            text-align: left;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(229, 231, 235, 0.5);
        }
        
        .summary-header {
            text-align: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(229, 231, 235, 0.6);
        }
        
        .summary-header h3 {
            color: #1a1f2e;
            font-size: 1.2rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1rem;
        }
        
        .summary-item {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            padding: 1rem;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 12px;
            border: 1px solid rgba(229, 231, 235, 0.4);
            transition: all 0.3s ease;
        }
        
        .summary-item:hover {
            background: rgba(255, 255, 255, 0.95);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .summary-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            color: #ffffff;
            flex-shrink: 0;
        }
        
        .summary-icon.subject { background: #8b5cf6; }
        .summary-icon.mentor { background: #6366f1; }
        .summary-icon.date { background: #06b6d4; }
        .summary-icon.time { background: #8b5cf6; }
        .summary-icon.price { background: #f59e0b; }
        .summary-icon.status { background: #22c55e; }
        
        .summary-content {
            flex: 1;
        }
        
        .summary-label {
            font-weight: 500;
            color: #6b7280;
            font-size: 0.875rem;
            margin-bottom: 0.25rem;
        }
        
        .summary-value {
            color: #1a1f2e;
            font-size: 0.95rem;
            font-weight: 600;
        }
        
        .status-confirmed {
            color: #22c55e;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        /* Countdown Container */
        .countdown-container {
            background: rgba(254, 243, 199, 0.8);
            border: 1px solid rgba(245, 158, 11, 0.5);
            border-radius: 12px;
            padding: 1rem;
            margin: 1.5rem 0;
            text-align: center;
            backdrop-filter: blur(5px);
        }
        
        .countdown-text {
            color: #92400e;
            font-weight: 600;
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
        }
        
        .countdown-timer {
            color: #b45309;
            font-size: 1.25rem;
            font-weight: 700;
            font-family: 'Rubik', sans-serif;
        }
        
        /* Next Steps */
        .next-steps {
            background: rgba(219, 234, 254, 0.8);
            border: 1px solid rgba(59, 130, 246, 0.5);
            border-radius: 12px;
            padding: 1.5rem;
            margin: 1.5rem 0;
            text-align: left;
            backdrop-filter: blur(5px);
        }
        
        .next-steps h4 {
            color: #1e40af;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1rem;
            font-weight: 700;
        }
        
        .next-steps ul {
            color: #1e3a8a;
            margin: 0;
            padding-left: 1.25rem;
        }
        
        .next-steps li {
            margin-bottom: 0.5rem;
            line-height: 1.5;
            font-size: 0.875rem;
        }
        
        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 2rem;
        }
        
        .btn {
            padding: 0.8rem 1.8rem;
            border-radius: 10px;
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            font-size: 0.9rem;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #2563eb, #1e40af);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(59, 130, 246, 0.4);
            color: #ffffff;
            text-decoration: none;
        }
        
        .btn-outline {
            background: rgba(255, 255, 255, 0.8);
            color: #6b7280;
            border: 1.5px solid rgba(209, 213, 219, 0.6);
            backdrop-filter: blur(5px);
        }
        
        .btn-outline:hover {
            background: rgba(255, 255, 255, 0.95);
            border-color: #9ca3af;
            color: #374151;
            text-decoration: none;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        /* Confetti Animation */
        .confetti {
            position: fixed;
            width: 8px;
            height: 8px;
            background: #22c55e;
            animation: confetti 2s ease-in-out infinite;
            z-index: 1000;
            border-radius: 2px;
        }
        
        .confetti:nth-child(1) { left: 10%; animation-delay: 0s; background: #ef4444; }
        .confetti:nth-child(2) { left: 20%; animation-delay: 0.2s; background: #3b82f6; }
        .confetti:nth-child(3) { left: 30%; animation-delay: 0.4s; background: #22c55e; }
        .confetti:nth-child(4) { left: 40%; animation-delay: 0.6s; background: #f59e0b; }
        .confetti:nth-child(5) { left: 50%; animation-delay: 0.8s; background: #8b5cf6; }
        .confetti:nth-child(6) { left: 60%; animation-delay: 1s; background: #06b6d4; }
        .confetti:nth-child(7) { left: 70%; animation-delay: 1.2s; background: #84cc16; }
        .confetti:nth-child(8) { left: 80%; animation-delay: 1.4s; background: #f97316; }
        .confetti:nth-child(9) { left: 90%; animation-delay: 1.6s; background: #ec4899; }
        
        @keyframes confetti {
            0% {
                transform: translateY(-100vh) rotate(0deg);
                opacity: 1;
            }
            100% {
                transform: translateY(100vh) rotate(720deg);
                opacity: 0;
            }
        }
        
        /* Fade in animation */
        .fade-in {
            opacity: 0;
            animation: fadeIn 0.8s ease-out forwards;
        }
        
        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .navbar {
                padding: 1rem 4%;
            }
            
            .container {
                margin: 0 auto;
                padding: 100px 1rem 2rem 1rem;
            }
            
            .success-container {
                padding: 2rem;
                margin: 1rem 0;
                border-radius: 16px;
            }
            
            .success-title {
                font-size: 1.5rem;
            }
            
            .summary-grid {
                grid-template-columns: 1fr;
            }
            
            .action-buttons {
                flex-direction: column;
                align-items: center;
            }
            
            .btn {
                width: 100%;
                max-width: 300px;
                justify-content: center;
            }
        }

        @media (max-width: 576px) {
            .navbar {
                flex-direction: column;
                padding: 0.8rem 4%;
                gap: 10px;
            }
            
            .container {
                padding: 130px 0.5rem 2rem 0.5rem;
            }
            
            .success-container {
                margin: 0.5rem 0;
                padding: 1.5rem;
                border-radius: 12px;
            }
            
            .success-icon {
                width: 80px;
                height: 80px;
            }
            
            .success-icon i {
                font-size: 2rem;
            }
            
            .success-title {
                font-size: 1.3rem;
            }
            
            .session-summary {
                padding: 1.5rem;
            }
            
            .summary-item {
                padding: 1rem;
            }
        }
    </style>
</head>

<body>
    <!-- Confetti Animation -->
    <div class="confetti"></div>
    <div class="confetti"></div>
    <div class="confetti"></div>
    <div class="confetti"></div>
    <div class="confetti"></div>
    <div class="confetti"></div>
    <div class="confetti"></div>
    <div class="confetti"></div>
    <div class="confetti"></div>

    <!-- Navbar Start -->
    <nav class="navbar">
        <a href="#" class="navbar-logo">DearFuture</a>
        
        <div class="navbar-nav">
            <a href="{{ route('student.menu') }}">Home</a>
            <a href="{{ route('student.history.index') }}">History</a>
            <a href="{{ route('student.sessions.index') }}">Sessions</a>
        </div>
        
        <div class="navbar-extra">
            <span class="user-name">{{ Auth::user()->name }}</span>
            <img src="{{ Auth::user()->avatar ?? asset('image/profile.png') }}" alt="User Profile" class="user-avatar">
        </div>
    </nav>
    <!-- Navbar End -->
    
    <div class="container">
        <div class="success-container fade-in">
            <div class="success-icon">
                <i class="fas fa-check"></i>
            </div>
            
            <h1 class="success-title">🎉 Booking Berhasil!</h1>
            <p class="success-message">
                Selamat! Sesi mentoring Anda telah berhasil dipesan dan dikonfirmasi. 
                Anda akan menerima notifikasi lebih lanjut tentang detail sesi.
            </p>
            
            <!-- Session Summary -->
            <div class="session-summary">
                <div class="summary-header">
                    <h3>
                        📚 Detail Sesi Anda
                    </h3>
                </div>
                
                <div class="summary-grid">
                    <div class="summary-item">
                        <div class="summary-icon subject">
                            <i class="fas fa-book"></i>
                        </div>
                        <div class="summary-content">
                            <div class="summary-label">Subject</div>
                            <div class="summary-value">{{ $session->subject->name }}</div>
                        </div>
                    </div>
                    
                    <div class="summary-item">
                        <div class="summary-icon mentor">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div class="summary-content">
                            <div class="summary-label">Mentor</div>
                            <div class="summary-value">{{ $session->mentor->name }}</div>
                        </div>
                    </div>
                    
                    <div class="summary-item">
                        <div class="summary-icon date">
                            <i class="fas fa-calendar"></i>
                        </div>
                        <div class="summary-content">
                            <div class="summary-label">Tanggal</div>
                            <div class="summary-value">{{ $session->date->format('l, d F Y') }}</div>
                        </div>
                    </div>
                    
                    <div class="summary-item">
                        <div class="summary-icon time">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="summary-content">
                            <div class="summary-label">Waktu</div>
                            <div class="summary-value">{{ $session->start_time->format('H:i') }} - {{ $session->end_time->format('H:i') }}</div>
                        </div>
                    </div>
                    
                    <div class="summary-item">
                        <div class="summary-icon price">
                            <i class="fas fa-coins"></i>
                        </div>
                        <div class="summary-content">
                            <div class="summary-label">Harga</div>
                            <div class="summary-value">
                                @if($session->price)
                                    Rp{{ number_format($session->price, 0, ',', '.') }}
                                @else
                                    Gratis
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="summary-item">
                        <div class="summary-icon status">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="summary-content">
                            <div class="summary-label">Status</div>
                            <div class="summary-value status-confirmed">
                                <i class="fas fa-check-circle"></i>
                                Dikonfirmasi
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Auto-redirect countdown -->
            <div class="countdown-container">
                <div class="countdown-text">
                    <i class="fas fa-clock me-1"></i>
                    Otomatis mengarahkan ke History dalam:
                </div>
                <div class="countdown-timer" id="countdown">10 detik</div>
            </div>
            
            <!-- Next Steps -->
            <div class="next-steps">
                <h4>
                    <i class="fas fa-lightbulb"></i>
                    Langkah Selanjutnya:
                </h4>
                <ul>
                    <li>🔗 Link meeting akan tersedia 15 menit sebelum sesi dimulai</li>
                    <li>🌐 Pastikan koneksi internet Anda stabil</li>
                    <li>📝 Siapkan materi yang ingin Anda diskusikan</li>
                    <li>⚙️ Anda dapat membatalkan atau reschedule sesi di halaman history</li>
                    <li>📧 Cek email untuk notifikasi lebih lanjut</li>
                </ul>
            </div>
            
            <!-- Action Buttons -->
            <div class="action-buttons">
                <a href="{{ route('student.history.show', $session->id) }}" class="btn btn-primary">
                    <i class="fas fa-eye"></i>
                    Lihat Detail Sesi
                </a>
                
                <a href="{{ route('student.history.index') }}" class="btn btn-outline">
                    <i class="fas fa-history"></i>
                    Lihat Semua Sesi
                </a>
                
                <a href="{{ route('student.sessions.index') }}" class="btn btn-outline">
                    <i class="fas fa-search"></i>
                    Cari Sesi Lain
                </a>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        // Auto redirect countdown
        let countdown = 10;
        const countdownElement = document.getElementById('countdown');
        let redirectTimer;
        
        function updateCountdown() {
            countdownElement.textContent = countdown + ' detik';
            countdown--;
            
            if (countdown < 0) {
                clearInterval(redirectTimer);
                countdownElement.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Mengarahkan...';
                window.location.href = "{{ route('student.history.index') }}";
            }
        }
        
        // Start countdown
        redirectTimer = setInterval(updateCountdown, 1000);
        updateCountdown(); // Initial call
        
        // Stop auto redirect if user interacts with page
        function stopRedirect() {
            clearInterval(redirectTimer);
            countdownElement.innerHTML = '<i class="fas fa-hand-paper me-1"></i>Redirect dibatalkan';
            document.querySelector('.countdown-container').style.opacity = '0.7';
        }
        
        document.addEventListener('click', stopRedirect);
        document.addEventListener('keydown', stopRedirect);
        document.addEventListener('scroll', stopRedirect);
        
        // Enhanced interactive effects
        document.addEventListener('DOMContentLoaded', function() {
            // Animate summary items with stagger
            const summaryItems = document.querySelectorAll('.summary-item');
            summaryItems.forEach((item, index) => {
                item.style.opacity = '0';
                item.style.transform = 'translateY(10px)';
                setTimeout(() => {
                    item.style.transition = 'all 0.4s ease';
                    item.style.opacity = '1';
                    item.style.transform = 'translateY(0)';
                }, 500 + (index * 100));
            });
            
            // Enhanced button interactions
            const buttons = document.querySelectorAll('.btn');
            buttons.forEach(button => {
                button.addEventListener('click', function() {
                    this.style.transform = 'translateY(0) scale(0.98)';
                    setTimeout(() => {
                        this.style.transform = '';
                    }, 150);
                });
            });
        });
        
        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            switch(e.key) {
                case '1':
                    window.location.href = "{{ route('student.history.show', $session->id) }}";
                    break;
                case '2':
                    window.location.href = "{{ route('student.history.index') }}";
                    break;
                case '3':
                    window.location.href = "{{ route('student.sessions.index') }}";
                    break;
                case 'Escape':
                    stopRedirect();
                    break;
            }
        });
        
        console.log('🎉 Booking success page loaded!');
        console.log('Session ID: {{ $session->id }}');
        console.log('Subject: {{ $session->subject->name }}');
        console.log('Mentor: {{ $session->mentor->name }}');
    </script>
</body>
</html>