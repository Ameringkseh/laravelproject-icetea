<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Indo Ice Tea')</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="{{ asset('image.png') }}">
    <style>
        :root {
            --primary: #ff7e5f;
            --primary-dark: #e66e52;
            --secondary: #feb47b;
            --dark: #2d3436;
            --gray: #636e72;
            --navbar-orange: #ff9933;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--dark);
        }

        header {
            background: linear-gradient(135deg, var(--navbar-orange), #ff7e5f);
            color: white;
            padding: 15px 8%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .logo {
            font-size: 1.6rem;
            font-weight: 700;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: transform 0.3s ease;
        }

        .logo:hover {
            transform: scale(1.05);
        }

        .nav-links {
            list-style: none;
            display: flex;
            gap: 10px;
        }

        .nav-links li {
            position: relative;
        }

        .nav-links a {
            text-decoration: none;
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
            padding: 12px 22px;
            border-radius: 50px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            display: inline-block;
            background: transparent;
            overflow: hidden;
            letter-spacing: 0.5px;
        }

        .nav-links a::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255,255,255,0.2);
            border-radius: 50px;
            transform: scaleX(0);
            transform-origin: right;
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: -1;
        }

        .nav-links a:hover::before {
            transform: scaleX(1);
            transform-origin: left;
        }

        .nav-links a:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        }

        .nav-links a.active {
            background: rgba(255,255,255,0.25);
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        }

        .nav-links a .nav-icon {
            margin-right: 6px;
            font-size: 1rem;
        }

        /* Burger Menu */
        .burger-menu {
            display: none;
            flex-direction: column;
            justify-content: space-between;
            width: 28px;
            height: 20px;
            cursor: pointer;
            z-index: 1002;
            padding: 5px;
        }

        .burger-menu span {
            display: block;
            height: 3px;
            width: 100%;
            background: white;
            border-radius: 3px;
            transition: all 0.3s ease;
            transform-origin: left;
        }

        .burger-menu.active span:nth-child(1) {
            transform: rotate(45deg);
        }

        .burger-menu.active span:nth-child(2) {
            opacity: 0;
            transform: translateX(10px);
        }

        .burger-menu.active span:nth-child(3) {
            transform: rotate(-45deg);
        }

        /* Mobile Navigation Overlay */
        .mobile-nav-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            backdrop-filter: blur(5px);
            z-index: 999;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .mobile-nav-overlay.active {
            opacity: 1;
        }

        /* Mobile Navigation */
        .mobile-nav {
            display: none;
            position: fixed;
            top: 0;
            right: -300px;
            width: 280px;
            height: 100vh;
            background: linear-gradient(180deg, var(--navbar-orange), #ff6b45);
            z-index: 1001;
            padding: 80px 30px 30px;
            transition: right 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: -10px 0 40px rgba(0,0,0,0.3);
        }

        .mobile-nav.active {
            right: 0;
        }

        .mobile-nav ul {
            list-style: none;
        }

        .mobile-nav li {
            margin-bottom: 15px;
            transform: translateX(50px);
            opacity: 0;
            transition: all 0.3s ease;
        }

        .mobile-nav.active li {
            transform: translateX(0);
            opacity: 1;
        }

        .mobile-nav.active li:nth-child(1) { transition-delay: 0.1s; }
        .mobile-nav.active li:nth-child(2) { transition-delay: 0.2s; }
        .mobile-nav.active li:nth-child(3) { transition-delay: 0.3s; }

        .mobile-nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            color: white;
            text-decoration: none;
            font-size: 1.2rem;
            font-weight: 600;
            padding: 15px 20px;
            border-radius: 15px;
            transition: all 0.3s ease;
            background: rgba(255,255,255,0.1);
        }

        .mobile-nav a:hover,
        .mobile-nav a.active {
            background: rgba(255,255,255,0.25);
            transform: translateX(10px);
        }

        .mobile-nav a .nav-icon {
            font-size: 1.3rem;
        }

        .mobile-nav-close {
            position: absolute;
            top: 25px;
            right: 25px;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .mobile-nav-close:hover {
            background: rgba(255,255,255,0.2);
            transform: rotate(90deg);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }

            .burger-menu {
                display: flex;
            }

            .mobile-nav,
            .mobile-nav-overlay {
                display: block;
            }
        }

        footer {
            background: var(--dark);
            color: #ddd;
            text-align: center;
            padding: 20px;
            margin-top: 40px;
        }

        footer a {
            color: inherit;
            text-decoration: none;
        }
    </style>
    @stack('styles')
</head>
<body>
    <header>
        <a href="{{ route('home') }}" class="logo">🍹 Indo Ice Tea</a>
        
        <!-- Desktop Navigation -->
        <nav>
            <ul class="nav-links">
                <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}"><span class="nav-icon">🏠</span>Beranda</a></li>
                <li><a href="{{ route('menu.index') }}" class="{{ request()->routeIs('menu.index') ? 'active' : '' }}"><span class="nav-icon">🍵</span>Menu</a></li>
                <li><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}"><span class="nav-icon">📞</span>Kontak</a></li>
            </ul>
        </nav>

        <!-- Burger Menu Button -->
        <div class="burger-menu" onclick="toggleMobileNav()">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </header>

    <!-- Mobile Navigation Overlay -->
    <div class="mobile-nav-overlay" onclick="closeMobileNav()"></div>

    <!-- Mobile Navigation -->
    <nav class="mobile-nav">
        <div class="mobile-nav-close" onclick="closeMobileNav()">✕</div>
        <ul>
            <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}"><span class="nav-icon">🏠</span>Beranda</a></li>
            <li><a href="{{ route('menu.index') }}" class="{{ request()->routeIs('menu.index') ? 'active' : '' }}"><span class="nav-icon">🍵</span>Menu</a></li>
            <li><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}"><span class="nav-icon">📞</span>Kontak</a></li>
        </ul>
    </nav>

    <main>
        @yield('content')
    </main>

    <!-- Professional Footer -->
    <footer class="site-footer">
        <div class="footer-wave">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 120" preserveAspectRatio="none">
                <path fill="#2d3436" d="M0,64L48,69.3C96,75,192,85,288,80C384,75,480,53,576,48C672,43,768,53,864,64C960,75,1056,85,1152,80C1248,75,1344,53,1392,42.7L1440,32L1440,120L1392,120C1344,120,1248,120,1152,120C1056,120,960,120,864,120C768,120,672,120,576,120C480,120,384,120,288,120C192,120,96,120,48,120L0,120Z"></path>
            </svg>
        </div>
        
        <div class="footer-main">
            <div class="footer-container">
                <!-- Brand Column -->
                <div class="footer-col footer-brand">
                    <div class="footer-logo">🍹 Indo Ice Tea</div>
                    <p class="footer-tagline">Kesegaran teh asli Indonesia dengan sentuhan modern untuk menemani setiap momenmu.</p>
                    <div class="footer-social">
                        <a href="#" class="social-link" aria-label="Instagram"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg></a>
                        <a href="#" class="social-link" aria-label="Facebook"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg></a>
                        <a href="#" class="social-link" aria-label="Twitter"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path></svg></a>
                        <a href="https://wa.me/6282122339125" class="social-link" aria-label="WhatsApp"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg></a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="footer-col">
                    <h4 class="footer-title">Menu Cepat</h4>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}">Beranda</a></li>
                        <li><a href="{{ route('menu.index') }}">Menu Minuman</a></li>
                        <li><a href="{{ route('contact') }}">Hubungi Kami</a></li>
                        <li><a href="{{ route('login') }}">Admin Panel</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div class="footer-col">
                    <h4 class="footer-title">Kontak Kami</h4>
                    <ul class="footer-contact">
                        <li>
                            <span class="contact-icon">📍</span>
                            <span>Jl. Sariasih No.22, Sarijadi<br>Kota Bandung, Indonesia</span>
                        </li>
                        <li>
                            <span class="contact-icon">📞</span>
                            <span>+62 821-2233-9125</span>
                        </li>
                        <li>
                            <span class="contact-icon">⏰</span>
                            <span>Senin - Jumat<br>09:00 - 18:00 WIB</span>
                        </li>
                    </ul>
                </div>

                <!-- Newsletter -->
                <div class="footer-col">
                    <h4 class="footer-title">Dapatkan Promo</h4>
                    <p class="newsletter-text">Subscribe untuk info promo menarik & menu terbaru!</p>
                    <form class="newsletter-form" onsubmit="event.preventDefault(); alert('Terima kasih telah subscribe!');">
                        <input type="email" placeholder="Email kamu..." required>
                        <button type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <div class="footer-container">
                <p>&copy; 2026 Indo Ice Tea. All rights reserved.</p>
                <div class="footer-bottom-links">
                    <a href="#">Privacy Policy</a>
                    <a href="#">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <style>
        /* Professional Footer Styles */
        .site-footer {
            background: var(--dark);
            color: #b2bec3;
            margin-top: 0;
            position: relative;
        }

        .footer-wave {
            position: absolute;
            top: -60px;
            left: 0;
            right: 0;
            height: 60px;
            overflow: hidden;
        }

        .footer-wave svg {
            display: block;
            width: 100%;
            height: 100%;
        }

        .footer-main {
            padding: 80px 0 40px;
        }

        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: grid;
            grid-template-columns: 1.5fr 1fr 1fr 1.2fr;
            gap: 40px;
        }

        .footer-brand .footer-logo {
            font-size: 1.8rem;
            font-weight: 700;
            color: white;
            margin-bottom: 15px;
        }

        .footer-tagline {
            font-size: 0.95rem;
            line-height: 1.7;
            margin-bottom: 25px;
            color: #9ca3a8;
        }

        .footer-social {
            display: flex;
            gap: 12px;
        }

        .social-link {
            width: 42px;
            height: 42px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #ddd;
            transition: all 0.3s ease;
        }

        .social-link:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(255, 126, 95, 0.4);
        }

        .footer-title {
            color: white;
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 25px;
            position: relative;
            padding-bottom: 12px;
        }

        .footer-title::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 40px;
            height: 3px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            border-radius: 2px;
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 12px;
        }

        .footer-links a {
            color: #9ca3a8;
            text-decoration: none;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
        }

        .footer-links a::before {
            content: '→';
            margin-right: 8px;
            opacity: 0;
            transform: translateX(-10px);
            transition: all 0.3s ease;
        }

        .footer-links a:hover {
            color: var(--primary);
            padding-left: 5px;
        }

        .footer-links a:hover::before {
            opacity: 1;
            transform: translateX(0);
        }

        .footer-contact {
            list-style: none;
        }

        .footer-contact li {
            display: flex;
            gap: 12px;
            margin-bottom: 18px;
            font-size: 0.9rem;
            line-height: 1.6;
        }

        .contact-icon {
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .newsletter-text {
            font-size: 0.9rem;
            margin-bottom: 20px;
            color: #9ca3a8;
        }

        .newsletter-form {
            display: flex;
            gap: 8px;
        }

        .newsletter-form input {
            flex: 1;
            padding: 14px 18px;
            border: none;
            border-radius: 12px;
            background: rgba(255,255,255,0.1);
            color: white;
            font-family: inherit;
            font-size: 0.9rem;
            outline: none;
            transition: all 0.3s ease;
        }

        .newsletter-form input::placeholder {
            color: #888;
        }

        .newsletter-form input:focus {
            background: rgba(255,255,255,0.15);
            box-shadow: 0 0 0 2px var(--primary);
        }

        .newsletter-form button {
            padding: 14px 18px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border: none;
            border-radius: 12px;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .newsletter-form button:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(255, 126, 95, 0.5);
        }

        .footer-bottom {
            background: rgba(0,0,0,0.2);
            padding: 20px 0;
            border-top: 1px solid rgba(255,255,255,0.05);
        }

        .footer-bottom .footer-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .footer-bottom p {
            font-size: 0.85rem;
            color: #777;
        }

        .footer-bottom-links {
            display: flex;
            gap: 25px;
        }

        .footer-bottom-links a {
            color: #777;
            text-decoration: none;
            font-size: 0.85rem;
            transition: color 0.3s ease;
        }

        .footer-bottom-links a:hover {
            color: var(--primary);
        }

        /* Responsive Footer */
        @media (max-width: 992px) {
            .footer-container {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 600px) {
            .footer-container {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .footer-title::after {
                left: 50%;
                transform: translateX(-50%);
            }

            .footer-social {
                justify-content: center;
            }

            .footer-contact li {
                justify-content: center;
            }

            .footer-links a::before {
                display: none;
            }

            .footer-bottom .footer-container {
                flex-direction: column;
                gap: 15px;
            }

            .newsletter-form {
                flex-direction: column;
            }

            .newsletter-form button {
                width: 100%;
            }
        }
    </style>

    <!-- Mobile Navigation JavaScript -->
    <script>
        function toggleMobileNav() {
            const burger = document.querySelector('.burger-menu');
            const mobileNav = document.querySelector('.mobile-nav');
            const overlay = document.querySelector('.mobile-nav-overlay');
            
            burger.classList.toggle('active');
            mobileNav.classList.toggle('active');
            overlay.classList.toggle('active');
            
            // Prevent body scroll when menu is open
            document.body.style.overflow = mobileNav.classList.contains('active') ? 'hidden' : '';
        }

        function closeMobileNav() {
            const burger = document.querySelector('.burger-menu');
            const mobileNav = document.querySelector('.mobile-nav');
            const overlay = document.querySelector('.mobile-nav-overlay');
            
            burger.classList.remove('active');
            mobileNav.classList.remove('active');
            overlay.classList.remove('active');
            document.body.style.overflow = '';
        }

        // Close menu on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeMobileNav();
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
