<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Lapor.in</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #4fb3bf 0%, #2d5a7b 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .login-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
            max-width: 900px;
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        /* ── Kiri ── */
        .login-left {
            background: linear-gradient(135deg, #4fb3bf 0%, #2d5a7b 100%);
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
        }

        .logo-container {
            margin-bottom: 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 14px;
        }

        .logo-container img {
            width: 90px;
            height: 90px;
            object-fit: contain;
            background: rgba(255,255,255,0.15);
            border-radius: 22px;
            padding: 12px;
        }

        .logo-container h1 {
            font-size: 40px;
            font-weight: 700;
            color: white;
            letter-spacing: -1px;
        }

        .welcome-text h2 {
            font-size: 28px;
            margin-bottom: 15px;
            font-weight: 700;
        }

        .welcome-text p {
            font-size: 15px;
            line-height: 1.7;
            opacity: 0.9;
        }

        /* ── Kanan ── */
        .login-right {
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-header { margin-bottom: 35px; }
        .login-header h2 { font-size: 28px; color: #333; margin-bottom: 8px; font-weight: 700; }
        .login-header p { color: #666; font-size: 14px; }

        .form-group { margin-bottom: 22px; }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
            font-size: 14px;
        }
        .form-group input {
            width: 100%;
            padding: 13px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 15px;
            transition: all 0.3s ease;
            background: #f8f9fa;
            font-family: inherit;
        }
        .form-group input:focus {
            outline: none;
            border-color: #4fb3bf;
            background: white;
            box-shadow: 0 0 0 3px rgba(79,179,191,0.1);
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
            font-size: 14px;
        }
        .remember-me { display: flex; align-items: center; gap: 8px; color: #555; }
        .remember-me input[type="checkbox"] { width: 16px; height: 16px; cursor: pointer; accent-color: #4fb3bf; }
        .forgot-password { color: #4fb3bf; text-decoration: none; font-weight: 500; transition: color 0.3s ease; }
        .forgot-password:hover { color: #2d5a7b; }

        .login-button {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #4fb3bf 0%, #2d5a7b 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.3s ease;
            font-family: inherit;
        }
        .login-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(79,179,191,0.4);
        }
        .login-button:active { transform: translateY(0); }

        .error-message {
            background: #fff0f0;
            border: 1px solid #fcc;
            color: #c33;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        @media (max-width: 768px) {
            .login-container { grid-template-columns: 1fr; }
            .login-left { padding: 40px 30px; }
            .login-right { padding: 40px 30px; }
            .welcome-text h2 { font-size: 22px; }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Kiri -->
        <div class="login-left">
            <div class="logo-container">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Lapor.in">
                <h1>Lapor.in</h1>
            </div>
            <div class="welcome-text">
                <h2>Selamat Datang!</h2>
                <p>Sistem Pengaduan Sarana dan Prasarana Sekolah yang efektif dan efisien untuk mendukung lingkungan belajar yang lebih baik.</p>
            </div>
        </div>

        <!-- Kanan -->
        <div class="login-right">
            <div class="login-header">
                <h2>Masuk</h2>
                <p>Silakan login untuk melanjutkan</p>
            </div>

            @if (session('status'))
                <div class="error-message">{{ session('status') }}</div>
            @endif

            @if ($errors->any())
                <div class="error-message">
                    @foreach ($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="login">Username / NIS</label>
                    <input type="text"
                           id="login"
                           name="login"
                           value="{{ old('login') }}"
                           placeholder="Masukkan Username (Admin) atau NIS (Siswa)"
                           required
                           autofocus>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password"
                           id="password"
                           name="password"
                           placeholder="Masukkan password"
                           required>
                </div>

                <div class="form-options">
                    <label class="remember-me">
                        <input type="checkbox" id="remember" name="remember">
                        <span>Ingat Saya</span>
                    {{-- </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-password">Lupa Password?</a>
                    @endif --}}
                </div>

                <button type="submit" class="login-button">Masuk</button>
            </form>
        </div>
    </div>
</body>
</html>