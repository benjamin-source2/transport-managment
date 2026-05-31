<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - TranspoGo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --glass-bg: rgba(255, 255, 255, 0.08);
            --glass-border: rgba(255, 255, 255, 0.15);
            --glass-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
            --primary: #667eea;
            --secondary: #764ba2;
            --accent: #f093fb;
        }
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #0f0c29 0%, #302b63 50%, #24243e 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        body::before {
            content: '';
            position: fixed;
            top: -50%; left: -50%;
            width: 200%; height: 200%;
            background:
                radial-gradient(ellipse at 20% 50%, rgba(102, 126, 234, 0.12) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 20%, rgba(118, 75, 162, 0.12) 0%, transparent 50%),
                radial-gradient(ellipse at 50% 80%, rgba(240, 147, 251, 0.08) 0%, transparent 50%);
            z-index: -1;
            animation: ambientShift 20s ease-in-out infinite alternate;
        }
        @keyframes ambientShift {
            0% { transform: translate(0, 0) rotate(0deg); }
            100% { transform: translate(-2%, -2%) rotate(3deg); }
        }
        .floating-icons { position: fixed; inset: 0; pointer-events: none; z-index: 0; overflow: hidden; }
        .floating-icons i {
            position: absolute; color: rgba(255, 255, 255, 0.03);
            font-size: var(--size);
            animation: floatIcon var(--duration) ease-in-out infinite alternate;
            animation-delay: var(--delay);
        }
        @keyframes floatIcon {
            0% { transform: translateY(0) scale(1); opacity: 1; }
            100% { transform: translateY(-80px) scale(1.1); opacity: 0.5; }
        }
        .login-card {
            background: rgba(255, 255, 255, 0.06);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 24px;
            padding: 2.5rem;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            position: relative;
            z-index: 1;
        }
        .login-card .logo {
            text-align: center;
            margin-bottom: 2rem;
        }
        .login-card .logo i {
            font-size: 3rem;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .login-card .logo h1 {
            font-size: 1.8rem;
            font-weight: 800;
            background: linear-gradient(135deg, #fff 0%, #a8b5ff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-top: 0.5rem;
        }
        .login-card .logo p {
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.9rem;
            margin-top: 0.3rem;
        }
        .login-card .form-label {
            color: rgba(255, 255, 255, 0.7);
            font-weight: 500;
            font-size: 0.85rem;
        }
        .login-card .form-control {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 12px;
            padding: 0.8rem 1rem;
            color: #fff;
            transition: all 0.3s ease;
        }
        .login-card .form-control:focus {
            background: rgba(255, 255, 255, 0.10);
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.15);
            color: #fff;
        }
        .login-card .form-control::placeholder { color: rgba(255, 255, 255, 0.3); }
        .login-card .form-control.is-invalid {
            border-color: #ef476f;
            box-shadow: 0 0 0 3px rgba(239, 71, 111, 0.15);
        }
        .login-card .invalid-feedback { color: #ff7a9a; }
        .login-btn {
            width: 100%;
            padding: 0.8rem;
            border: none;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1rem;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: #fff;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }
        .login-btn:active { transform: translateY(0); }
        .login-card .footer-text {
            text-align: center;
            margin-top: 1.5rem;
            color: rgba(255, 255, 255, 0.4);
            font-size: 0.8rem;
        }
        .error-message {
            background: rgba(239, 71, 111, 0.12);
            border: 1px solid rgba(239, 71, 111, 0.2);
            border-radius: 12px;
            padding: 0.8rem 1rem;
            color: #ff7a9a;
            font-size: 0.85rem;
            margin-bottom: 1rem;
        }
        .input-icon-wrapper { position: relative; }
        .input-icon-wrapper .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.3);
        }
        .input-icon-wrapper .form-control { padding-left: 2.8rem; }
    </style>
</head>
<body>
    <div class="floating-icons">
        <i class="bi bi-bus-front" style="--size: 5rem; top: 10%; left: 5%; --duration: 25s; --delay: 0s;"></i>
        <i class="bi bi-truck" style="--size: 3.5rem; bottom: 15%; right: 8%; --duration: 30s; --delay: 2s;"></i>
        <i class="bi bi-geo-alt" style="--size: 3rem; top: 30%; right: 15%; --duration: 20s; --delay: 4s;"></i>
        <i class="bi bi-signpost-2" style="--size: 4rem; bottom: 25%; left: 8%; --duration: 28s; --delay: 1s;"></i>
        <i class="bi bi-ticket-perforated" style="--size: 2.5rem; top: 60%; left: 15%; --duration: 22s; --delay: 3s;"></i>
        <i class="bi bi-compass" style="--size: 3.5rem; top: 15%; left: 40%; --duration: 26s; --delay: 5s;"></i>
    </div>

    <div class="login-card">
        <div class="logo">
            <i class="bi bi-bus-front"></i>
            <h1>TranspoGo</h1>
            <p>Transport Ticket Booking System</p>
        </div>

        @if($errors->any())
            <div class="error-message">
                <i class="bi bi-exclamation-circle me-2"></i>
                {{ $errors->first('email') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label"><i class="bi bi-envelope me-1"></i>Email Address</label>
                <div class="input-icon-wrapper">
                    <i class="bi bi-envelope-fill input-icon"></i>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}" placeholder="Enter your email" required autofocus>
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label"><i class="bi bi-lock me-1"></i>Password</label>
                <div class="input-icon-wrapper">
                    <i class="bi bi-lock-fill input-icon"></i>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                           placeholder="Enter your password" required>
                </div>
            </div>
            <button type="submit" class="login-btn">
                <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
            </button>
        </form>

        <div class="footer-text" style="margin-top: 1.2rem;">
            Don't have an account?
            <a href="{{ route('register') }}" style="color: var(--primary); text-decoration: none; font-weight: 600;">Register Here</a>
        </div>

        <div class="footer-text">
            <i class="bi bi-shield-check me-1"></i>
            Demo: admin@transport.com / admin123
        </div>
    </div>
</body>
</html>
