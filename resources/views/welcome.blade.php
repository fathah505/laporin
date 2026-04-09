<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lapor.in - Sistem Pengaduan Sarana Sekolah</title>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #2d5a7b;
            --accent: #4fb3bf;
            --light: #f5f7fa;
            --white: #ffffff;
            --text: #333;
            --text-muted: #666;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--text);
            overflow-x: hidden;
        }

        /* ── Navbar ── */
        .navbar {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 1px 20px rgba(0,0,0,0.08);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            padding: 14px 0;
        }
        .nav-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .logo-nav {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }
        .logo-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            overflow: hidden;
            flex-shrink: 0;
        }
        .logo-icon img { width: 100%; height: 100%; object-fit: contain; }
        .logo-nav span {
            font-size: 22px;
            font-weight: 800;
            color: var(--primary);
            letter-spacing: -0.5px;
        }
        .nav-menu {
            display: flex;
            gap: 35px;
            list-style: none;
            align-items: center;
        }
        .nav-menu a {
            text-decoration: none;
            color: #555;
            font-weight: 500;
            font-size: 15px;
            transition: color 0.3s ease;
        }
        .nav-menu a:hover { color: var(--accent); }
        .btn-login {
            background: linear-gradient(135deg, var(--accent) 0%, var(--primary) 100%);
            color: white !important;
            padding: 10px 24px;
            border-radius: 25px;
            font-weight: 600 !important;
            display: flex;
            align-items: center;
            gap: 7px;
            transition: transform 0.2s ease, box-shadow 0.3s ease !important;
        }
        .btn-login i[data-lucide] { width: 15px; height: 15px; }
        .btn-login:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 6px 20px rgba(79,179,191,0.4) !important;
        }

        /* ── Hero ── */
        .hero {
            background: linear-gradient(135deg, var(--accent) 0%, var(--primary) 100%);
            padding: 150px 40px 110px;
            color: white;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .hero::before {
            content: '';
            position: absolute;
            top: -100px; right: -100px;
            width: 500px; height: 500px;
            border-radius: 50%;
            background: rgba(255,255,255,0.05);
            pointer-events: none;
        }
        .hero::after {
            content: '';
            position: absolute;
            bottom: -150px; left: -80px;
            width: 400px; height: 400px;
            border-radius: 50%;
            background: rgba(255,255,255,0.04);
            pointer-events: none;
        }
        .hero-content { max-width: 860px; margin: 0 auto; position: relative; z-index: 1; }
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.25);
            padding: 8px 18px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 28px;
            letter-spacing: 0.3px;
        }
        .hero-badge i[data-lucide] { width: 14px; height: 14px; }
        .hero h1 {
            font-size: 56px;
            margin-bottom: 22px;
            font-weight: 800;
            line-height: 1.15;
            letter-spacing: -1px;
        }
        .hero p {
            font-size: 19px;
            margin-bottom: 44px;
            opacity: 0.92;
            line-height: 1.7;
            max-width: 660px;
            margin-left: auto;
            margin-right: auto;
        }
        .hero-buttons { display: flex; gap: 16px; justify-content: center; flex-wrap: wrap; }
        .btn-hero-primary {
            background: white;
            color: var(--primary);
            padding: 15px 36px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 700;
            font-size: 15px;
            transition: all 0.3s ease;
            box-shadow: 0 6px 20px rgba(0,0,0,0.15);
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-hero-primary i[data-lucide] { width: 17px; height: 17px; }
        .btn-hero-primary:hover { transform: translateY(-3px); box-shadow: 0 10px 28px rgba(0,0,0,0.2); }
        .btn-hero-secondary {
            background: transparent;
            color: white;
            padding: 15px 36px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 600;
            font-size: 15px;
            border: 2px solid rgba(255,255,255,0.7);
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-hero-secondary i[data-lucide] { width: 17px; height: 17px; }
        .btn-hero-secondary:hover { background: white; color: var(--primary); border-color: white; }

        /* ── Section wrapper ── */
        .section-inner {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 40px;
        }

        /* ── Features ── */
        .features { padding: 90px 0; background: var(--light); }
        .section-title { text-align: center; margin-bottom: 60px; }
        .section-title h2 { font-size: 36px; color: var(--primary); margin-bottom: 12px; font-weight: 800; letter-spacing: -0.5px; }
        .section-title p { font-size: 17px; color: var(--text-muted); }
        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 28px;
        }
        .feature-card {
            background: white;
            padding: 36px;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid rgba(0,0,0,0.04);
        }
        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 35px rgba(79,179,191,0.18);
        }
        .feature-icon {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, var(--accent) 0%, var(--primary) 100%);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 24px;
            color: white;
        }
        .feature-icon i[data-lucide] { width: 30px; height: 30px; }
        .feature-card h3 { font-size: 20px; color: var(--primary); margin-bottom: 12px; font-weight: 700; }
        .feature-card p { color: var(--text-muted); line-height: 1.7; font-size: 15px; }

        /* ── How It Works ── */
        .how-it-works { padding: 90px 0; background: white; }
        .steps-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
            margin-top: 55px;
            position: relative;
        }
        .step { text-align: center; padding: 30px 20px; }
        .step-number {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, var(--accent), var(--primary));
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: 800;
            margin: 0 auto 22px;
            box-shadow: 0 6px 20px rgba(79,179,191,0.35);
        }
        .step h3 { font-size: 18px; color: var(--primary); margin-bottom: 10px; font-weight: 700; }
        .step p { color: var(--text-muted); line-height: 1.65; font-size: 14px; }

        /* ── Stats ── */
        .stats {
            background: linear-gradient(135deg, var(--accent) 0%, var(--primary) 100%);
            padding: 70px 0;
            color: white;
        }
        .stats-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 40px;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 40px;
            text-align: center;
        }
        .stat-item { display: flex; flex-direction: column; align-items: center; gap: 10px; }
        .stat-icon-wrap {
            width: 56px;
            height: 56px;
            background: rgba(255,255,255,0.15);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 6px;
        }
        .stat-icon-wrap i[data-lucide] { width: 26px; height: 26px; }
        .stat-item h3 { font-size: 44px; font-weight: 800; letter-spacing: -1px; line-height: 1; }
        .stat-item p { font-size: 16px; opacity: 0.88; font-weight: 500; }

        /* ── CTA ── */
        .cta { padding: 90px 40px; background: var(--light); text-align: center; }
        .cta-content { max-width: 720px; margin: 0 auto; }
        .cta h2 { font-size: 36px; color: var(--primary); margin-bottom: 18px; font-weight: 800; letter-spacing: -0.5px; }
        .cta p { font-size: 17px; color: var(--text-muted); margin-bottom: 40px; line-height: 1.7; }
        .btn-cta {
            background: linear-gradient(135deg, var(--accent), var(--primary));
            color: white;
            padding: 16px 44px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 700;
            font-size: 16px;
            display: inline-flex;
            align-items: center;
            gap: 9px;
            transition: all 0.3s ease;
            box-shadow: 0 6px 24px rgba(79,179,191,0.4);
        }
        .btn-cta i[data-lucide] { width: 18px; height: 18px; }
        .btn-cta:hover { transform: translateY(-3px); box-shadow: 0 10px 30px rgba(79,179,191,0.5); }

        /* ── Footer ── */
        .footer { background: var(--primary); color: white; padding: 60px 0 28px; }
        .footer-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 40px;
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1.5fr;
            gap: 48px;
            margin-bottom: 40px;
        }
        .footer-brand { display: flex; align-items: center; gap: 10px; margin-bottom: 15px; }
        .footer-logo-icon {
            width: 38px; height: 38px;
            border-radius: 9px;
            overflow: hidden;
            flex-shrink: 0;
        }
        .footer-logo-icon img { width: 100%; height: 100%; object-fit: contain; }
        .footer-section h3 { font-size: 17px; font-weight: 700; margin-bottom: 18px; }
        .footer-desc { font-size: 14px; line-height: 1.75; opacity: 0.82; }
        .footer-section ul { list-style: none; }
        .footer-section ul li { margin-bottom: 10px; }
        .footer-section a {
            color: rgba(255,255,255,0.82);
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s ease;
        }
        .footer-section a:hover { color: white; }
        .footer-contact-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            color: rgba(255,255,255,0.82);
            margin-bottom: 10px;
        }
        .footer-contact-item i[data-lucide] { width: 15px; height: 15px; flex-shrink: 0; opacity: 0.7; }
        .footer-bottom {
            max-width: 1400px;
            margin: 0 auto;
            padding: 22px 40px 0;
            text-align: center;
            border-top: 1px solid rgba(255,255,255,0.15);
            font-size: 13px;
            color: rgba(255,255,255,0.6);
        }

        /* ── Mobile Menu ── */
        .menu-toggle { display: none; flex-direction: column; cursor: pointer; gap: 5px; }
        .menu-toggle span { width: 24px; height: 2.5px; background: var(--primary); border-radius: 2px; transition: 0.3s; }

        /* ── Responsive ── */

        @media (max-width: 1200px) {
            .features-grid { grid-template-columns: repeat(3, 1fr); }
            .steps-grid { grid-template-columns: repeat(4, 1fr); }
            .stats-container { grid-template-columns: repeat(4, 1fr); }
            .footer-container { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 992px) {
            .hero h1 { font-size: 44px; }
            .features-grid { grid-template-columns: repeat(2, 1fr); }
            .steps-grid { grid-template-columns: repeat(2, 1fr); }
            .stats-container { grid-template-columns: repeat(2, 1fr); }
            .footer-container { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 768px) {
            .nav-container { padding: 0 20px; }
            .nav-menu {
                display: none;
                position: absolute;
                top: 68px; left: 0; right: 0;
                background: white;
                flex-direction: column;
                padding: 20px 30px;
                box-shadow: 0 10px 20px rgba(0,0,0,0.1);
                gap: 18px;
            }
            .nav-menu.active { display: flex; }
            .menu-toggle { display: flex; }

            .hero { padding: 130px 20px 80px; }
            .hero h1 { font-size: 34px; }
            .hero p { font-size: 16px; }
            .hero-buttons { flex-direction: column; align-items: center; }

            .section-inner { padding: 0 20px; }
            .features { padding: 60px 0; }
            .features-grid { grid-template-columns: 1fr; }

            .how-it-works { padding: 60px 0; }
            .steps-grid { grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 36px; }

            .stats { padding: 50px 0; }
            .stats-container {
                padding: 0 20px;
                grid-template-columns: repeat(2, 1fr);
                gap: 28px;
            }
            .stat-item h3 { font-size: 36px; }

            .cta { padding: 60px 20px; }
            .section-title h2 { font-size: 28px; }

            .footer { padding: 50px 0 24px; }
            .footer-container {
                padding: 0 20px;
                grid-template-columns: 1fr;
                gap: 32px;
                margin-bottom: 28px;
            }
            .footer-bottom { padding: 18px 20px 0; }
        }

        @media (max-width: 480px) {
            .steps-grid { grid-template-columns: 1fr; }
            .stats-container { grid-template-columns: 1fr; }
            .hero h1 { font-size: 28px; }
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="#home" class="logo-nav">
                <div class="logo-icon"><img src="{{ asset('images/logo.png') }}" alt="Logo Lapor.in"></div>
                <span>Lapor.in</span>
            </a>
            <div class="menu-toggle" onclick="toggleMenu()">
                <span></span><span></span><span></span>
            </div>
            <ul class="nav-menu" id="navMenu">
                <li><a href="#home">Beranda</a></li>
                <li><a href="#features">Fitur</a></li>
                <li><a href="#how-it-works">Cara Kerja</a></li>
                <li><a href="#contact">Kontak</a></li>
                <li>
                    <a href="{{ route('login') }}" class="btn-login">
                        <i data-lucide="log-in"></i> Masuk
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Hero -->
    <section class="hero" id="home">
        <div class="hero-content">
            <div class="hero-badge">
                <i data-lucide="shield-check"></i>
                Platform Pengaduan Resmi Sekolah
            </div>
            <h1>Sampaikan Aspirasi Anda dengan Mudah</h1>
            <p>Platform pengaduan sarana dan prasarana sekolah yang efektif dan transparan. Bantu wujudkan lingkungan belajar yang lebih baik untuk semua.</p>
            <div class="hero-buttons">
                <a href="{{ route('login') }}" class="btn-hero-primary">
                    <i data-lucide="send"></i> Mulai Lapor
                </a>
                <a href="#how-it-works" class="btn-hero-secondary">
                    <i data-lucide="info"></i> Pelajari Lebih Lanjut
                </a>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="features" id="features">
        <div class="section-inner">
            <div class="section-title">
                <h2>Fitur Unggulan</h2>
                <p>Kemudahan dalam menyampaikan dan mengelola pengaduan</p>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon"><i data-lucide="file-plus"></i></div>
                    <h3>Mudah Digunakan</h3>
                    <p>Interface yang sederhana dan intuitif memudahkan siswa untuk menyampaikan pengaduan dengan cepat dan tepat.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i data-lucide="camera"></i></div>
                    <h3>Laporan Foto</h3>
                    <p>Sertakan foto bukti kerusakan sarana langsung dari perangkat Anda untuk memperkuat laporan pengaduan.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i data-lucide="activity"></i></div>
                    <h3>Tracking Status</h3>
                    <p>Pantau perkembangan pengaduan Anda dari mulai pengajuan hingga penyelesaian secara real-time.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i data-lucide="message-circle"></i></div>
                    <h3>Umpan Balik</h3>
                    <p>Terima tanggapan dan umpan balik dari petugas untuk setiap pengaduan yang disampaikan.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i data-lucide="monitor-smartphone"></i></div>
                    <h3>Responsive Design</h3>
                    <p>Akses dari berbagai perangkat, kapan saja dan dimana saja dengan tampilan yang optimal dan nyaman.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i data-lucide="lock"></i></div>
                    <h3>Aman & Terpercaya</h3>
                    <p>Data pengaduan Anda terjaga keamanannya dengan sistem autentikasi dan proteksi yang handal.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="how-it-works" id="how-it-works">
        <div class="section-inner">
            <div class="section-title">
                <h2>Cara Kerja</h2>
                <p>Proses pengaduan yang sederhana dan transparan</p>
            </div>
            <div class="steps-grid">
                <div class="step">
                    <div class="step-number">1</div>
                    <h3>Login ke Sistem</h3>
                    <p>Masuk menggunakan NIS untuk siswa atau akun admin/petugas untuk mengakses sistem pengaduan.</p>
                </div>
                <div class="step">
                    <div class="step-number">2</div>
                    <h3>Buat Pengaduan</h3>
                    <p>Isi form pengaduan dengan detail masalah sarana yang ditemukan, lengkap dengan foto bukti bila ada.</p>
                </div>
                <div class="step">
                    <div class="step-number">3</div>
                    <h3>Pantau Status</h3>
                    <p>Lihat status pengaduan Anda secara real-time dan tunggu respons dari petugas sekolah.</p>
                </div>
                <div class="step">
                    <div class="step-number">4</div>
                    <h3>Terima Umpan Balik</h3>
                    <p>Dapatkan informasi tindak lanjut dan konfirmasi penyelesaian langsung dari petugas terkait.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats -->
    <section class="stats">
        <div class="stats-container">
            <div class="stat-item">
                <div class="stat-icon-wrap"><i data-lucide="clipboard-check"></i></div>
                <h3>{{ $totalSelesai ?? '0' }}</h3>
                <p>Pengaduan Terselesaikan</p>
            </div>
            <div class="stat-item">
                <div class="stat-icon-wrap"><i data-lucide="users"></i></div>
                <h3>{{ $totalSiswa ?? '0' }}</h3>
                <p>Siswa Terdaftar</p>
            </div>
            <div class="stat-item">
                <div class="stat-icon-wrap"><i data-lucide="clipboard-list"></i></div>
                <h3>{{ $totalPengaduan ?? '0' }}</h3>
                <p>Total Pengaduan</p>
            </div>
            <div class="stat-item">
                <div class="stat-icon-wrap"><i data-lucide="tag"></i></div>
                <h3>{{ $totalKategori ?? '0' }}</h3>
                <p>Kategori Tersedia</p>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="cta">
        <div class="cta-content">
            <h2>Siap Menyampaikan Aspirasi Anda?</h2>
            <p>Bergabunglah dengan siswa lain yang telah mempercayai Lapor.in untuk mewujudkan lingkungan sekolah yang lebih baik dan nyaman.</p>
            <a href="{{ route('login') }}" class="btn-cta">
                <i data-lucide="arrow-right-circle"></i> Masuk Sekarang
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer" id="contact">
        <div class="footer-container">
            <div class="footer-section">
                <div class="footer-brand">
                    <div class="footer-logo-icon"><img src="{{ asset('images/logo.png') }}" alt="Logo Lapor.in"></div>
                    <span style="font-size: 20px; font-weight: 800;">Lapor.in</span>
                </div>
                <p class="footer-desc">Platform pengaduan sarana dan prasarana sekolah yang efektif, transparan, dan mudah digunakan.</p>
            </div>
            <div class="footer-section">
                <h3>Menu</h3>
                <ul>
                    <li><a href="#home">Beranda</a></li>
                    <li><a href="#features">Fitur</a></li>
                    <li><a href="#how-it-works">Cara Kerja</a></li>
                    <li><a href="#contact">Kontak</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Bantuan</h3>
                <ul>
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Panduan Penggunaan</a></li>
                    <li><a href="#">Kebijakan Privasi</a></li>
                    <li><a href="#">Syarat &amp; Ketentuan</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Kontak</h3>
                <div class="footer-contact-item">
                    <i data-lucide="mail"></i> admin@lapor.in
                </div>
                <div class="footer-contact-item">
                    <i data-lucide="phone"></i> (021) 1234-5678
                </div>
                <div class="footer-contact-item">
                    <i data-lucide="map-pin"></i> Jakarta, Indonesia
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} Lapor.in. All rights reserved.</p>
        </div>
    </footer>

    <script>
        function toggleMenu() {
            document.getElementById('navMenu').classList.toggle('active');
        }
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            });
        });
        document.addEventListener('click', function(event) {
            const navMenu = document.getElementById('navMenu');
            const menuToggle = document.querySelector('.menu-toggle');
            if (!navMenu.contains(event.target) && !menuToggle.contains(event.target)) {
                navMenu.classList.remove('active');
            }
        });
    </script>
    <script>lucide.createIcons();</script>
</body>
</html>