<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Transport Booking System')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --glass-bg: rgba(255, 255, 255, 0.12);
            --glass-border: rgba(255, 255, 255, 0.20);
            --glass-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
            --glass-blur: 16px;
            --primary: #667eea;
            --primary-dark: #5a6fd6;
            --secondary: #764ba2;
            --accent: #f093fb;
            --text-primary: #1a1a2e;
            --text-secondary: #4a4a6a;
            --success: #48c774;
            --warning: #ffd166;
            --danger: #ef476f;
            --info: #118ab2;
        }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #0f0c29 0%, #302b63 50%, #24243e 100%);
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background:
                radial-gradient(ellipse at 20% 50%, rgba(102, 126, 234, 0.08) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 20%, rgba(118, 75, 162, 0.08) 0%, transparent 50%),
                radial-gradient(ellipse at 50% 80%, rgba(240, 147, 251, 0.05) 0%, transparent 50%);
            z-index: -1;
            animation: ambientShift 20s ease-in-out infinite alternate;
        }

        @keyframes ambientShift {
            0% { transform: translate(0, 0) rotate(0deg); }
            100% { transform: translate(-2%, -2%) rotate(3deg); }
        }

        /* Floating transport icons background */
        .floating-icons {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            pointer-events: none;
            z-index: 0;
            overflow: hidden;
        }

        .floating-icons i {
            position: absolute;
            color: rgba(255, 255, 255, 0.03);
            font-size: var(--size);
            animation: floatIcon var(--duration) ease-in-out infinite alternate;
            animation-delay: var(--delay);
        }

        @keyframes floatIcon {
            0% { transform: translateY(0) scale(1) rotate(0deg); opacity: 1; }
            100% { transform: translateY(-100px) scale(1.1) rotate(10deg); opacity: 0.6; }
        }

        /* Glass card */
        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(var(--glass-blur));
            -webkit-backdrop-filter: blur(var(--glass-blur));
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            box-shadow: var(--glass-shadow);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .glass-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.2);
            background: rgba(255, 255, 255, 0.15);
        }

        /* Navbar */
        .glass-navbar {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.10);
            padding: 0.75rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .glass-navbar .navbar-brand {
            font-weight: 800;
            font-size: 1.35rem;
            background: linear-gradient(135deg, #fff 0%, #a8b5ff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .glass-navbar .nav-link {
            color: rgba(255, 255, 255, 0.75) !important;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 12px;
            transition: all 0.3s ease;
            margin: 0 2px;
        }

        .glass-navbar .nav-link:hover {
            color: #fff !important;
            background: rgba(255, 255, 255, 0.10);
            transform: translateY(-1px);
        }

        .glass-navbar .nav-link.active {
            color: #fff !important;
            background: rgba(102, 126, 234, 0.25);
        }

        .glass-navbar .nav-link i {
            margin-right: 6px;
        }

        .glass-navbar .dropdown-menu {
            background: rgba(30, 30, 60, 0.9);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.10);
            border-radius: 16px;
            padding: 8px;
            margin-top: 8px;
        }

        .glass-navbar .dropdown-item {
            color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            padding: 8px 16px;
            transition: all 0.2s ease;
        }

        .glass-navbar .dropdown-item:hover {
            background: rgba(102, 126, 234, 0.2);
            color: #fff;
        }

        /* Profile avatar in navbar */
        .nav-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .nav-avatar:hover {
            border-color: rgba(255, 255, 255, 0.5);
            transform: scale(1.05);
        }

        /* Buttons */
        .btn-glass {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            color: #fff;
            border-radius: 12px;
            padding: 0.6rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-glass:hover {
            background: rgba(255, 255, 255, 0.20);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        .btn-primary-glass {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border: none;
            color: #fff;
            border-radius: 12px;
            padding: 0.6rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .btn-primary-glass:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.45);
            color: #fff;
        }

        .btn-outline-glass {
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.25);
            color: rgba(255, 255, 255, 0.85);
            border-radius: 12px;
            padding: 0.6rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-outline-glass:hover {
            background: rgba(255, 255, 255, 0.10);
            color: #fff;
            transform: translateY(-2px);
        }

        .btn-danger-glass {
            background: linear-gradient(135deg, #ef476f, #d63a5e);
            border: none;
            color: #fff;
            border-radius: 12px;
            padding: 0.5rem 1.2rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-danger-glass:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(239, 71, 111, 0.4);
            color: #fff;
        }

        .btn-success-glass {
            background: linear-gradient(135deg, #48c774, #36a85e);
            border: none;
            color: #fff;
            border-radius: 12px;
            padding: 0.5rem 1.2rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-success-glass:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(72, 199, 116, 0.4);
            color: #fff;
        }

        /* Form elements */
        .glass-input {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 12px;
            padding: 0.7rem 1rem;
            color: #fff;
            transition: all 0.3s ease;
        }

        .glass-input:focus {
            background: rgba(255, 255, 255, 0.12);
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.15);
            color: #fff;
            outline: none;
        }

        .glass-input::placeholder {
            color: rgba(255, 255, 255, 0.4);
        }

        .glass-input option {
            background: #1a1a3e;
            color: #fff;
        }

        .glass-select {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 12px;
            padding: 0.7rem 1rem;
            color: #fff;
            transition: all 0.3s ease;
        }

        .glass-select:focus {
            background: rgba(255, 255, 255, 0.12);
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.15);
            color: #fff;
            outline: none;
        }

        .glass-select option {
            background: #1a1a3e;
        }

        .form-label {
            color: rgba(255, 255, 255, 0.75);
            font-weight: 500;
            font-size: 0.9rem;
            margin-bottom: 0.4rem;
        }

        /* Tables */
        .glass-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 4px;
        }

        .glass-table thead th {
            background: rgba(255, 255, 255, 0.06);
            color: rgba(255, 255, 255, 0.7);
            font-weight: 600;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            padding: 0.8rem 1rem;
            border: none;
        }

        .glass-table thead th:first-child {
            border-radius: 12px 0 0 12px;
        }

        .glass-table thead th:last-child {
            border-radius: 0 12px 12px 0;
        }

        .glass-table tbody tr {
            background: rgba(255, 255, 255, 0.04);
            transition: all 0.3s ease;
        }

        .glass-table tbody tr:hover {
            background: rgba(255, 255, 255, 0.08);
        }

        .glass-table tbody td {
            padding: 0.9rem 1rem;
            color: rgba(255, 255, 255, 0.85);
            border: none;
            vertical-align: middle;
        }

        .glass-table tbody tr td:first-child {
            border-radius: 12px 0 0 12px;
        }

        .glass-table tbody tr td:last-child {
            border-radius: 0 12px 12px 0;
        }

        /* Badges */
        .badge-glass {
            padding: 0.3rem 0.8rem;
            border-radius: 50px;
            font-weight: 500;
            font-size: 0.8rem;
        }

        .badge-glass.info {
            background: rgba(17, 138, 178, 0.2);
            color: #6bc8e8;
        }

        .badge-glass.success {
            background: rgba(72, 199, 116, 0.2);
            color: #6cdb8e;
        }

        .badge-glass.warning {
            background: rgba(255, 209, 102, 0.2);
            color: #ffd166;
        }

        .badge-glass.danger {
            background: rgba(239, 71, 111, 0.2);
            color: #ff7a9a;
        }

        .badge-glass.secondary {
            background: rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.6);
        }

        .badge-glass.primary {
            background: rgba(102, 126, 234, 0.2);
            color: #a8b5ff;
        }

        /* Stats cards */
        .stat-card {
            padding: 1.5rem;
            border-radius: 20px;
            background: var(--glass-bg);
            backdrop-filter: blur(var(--glass-blur));
            -webkit-backdrop-filter: blur(var(--glass-blur));
            border: 1px solid var(--glass-border);
            transition: all 0.4s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .stat-icon.primary {
            background: rgba(102, 126, 234, 0.2);
            color: #a8b5ff;
        }

        .stat-icon.success {
            background: rgba(72, 199, 116, 0.2);
            color: #6cdb8e;
        }

        .stat-icon.info {
            background: rgba(17, 138, 178, 0.2);
            color: #6bc8e8;
        }

        .stat-icon.warning {
            background: rgba(255, 209, 102, 0.2);
            color: #ffd166;
        }

        .stat-icon.danger {
            background: rgba(239, 71, 111, 0.2);
            color: #ff7a9a;
        }

        .stat-icon.white {
            background: rgba(255, 255, 255, 0.12);
            color: #fff;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 800;
            color: #fff;
            line-height: 1.2;
        }

        .stat-label {
            color: rgba(255, 255, 255, 0.55);
            font-size: 0.85rem;
            font-weight: 500;
            letter-spacing: 0.3px;
        }

        /* Page header */
        .page-header {
            color: #fff;
            font-weight: 700;
            font-size: 1.75rem;
            position: relative;
            padding-bottom: 0.75rem;
        }

        .page-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 3px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 2px;
        }

        /* Alerts */
        .glass-alert {
            border-radius: 16px;
            padding: 1rem 1.25rem;
            border: none;
            backdrop-filter: blur(10px);
        }

        .glass-alert.success {
            background: rgba(72, 199, 116, 0.15);
            border: 1px solid rgba(72, 199, 116, 0.25);
            color: #6cdb8e;
        }

        .glass-alert.danger {
            background: rgba(239, 71, 111, 0.15);
            border: 1px solid rgba(239, 71, 111, 0.25);
            color: #ff7a9a;
        }

        .glass-alert.info {
            background: rgba(17, 138, 178, 0.15);
            border: 1px solid rgba(17, 138, 178, 0.25);
            color: #6bc8e8;
        }

        /* Pagination */
        .pagination {
            gap: 4px;
        }

        .page-link {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.10);
            color: rgba(255, 255, 255, 0.7);
            border-radius: 10px !important;
            padding: 0.5rem 0.9rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .page-link:hover {
            background: rgba(255, 255, 255, 0.12);
            color: #fff;
        }

        .page-item.active .page-link {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border: none;
            color: #fff;
        }

        .page-item.disabled .page-link {
            background: rgba(255, 255, 255, 0.03);
            color: rgba(255, 255, 255, 0.3);
        }

        /* Trip card */
        .trip-card {
            background: var(--glass-bg);
            backdrop-filter: blur(var(--glass-blur));
            -webkit-backdrop-filter: blur(var(--glass-blur));
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            padding: 1.5rem;
            transition: all 0.4s ease;
            height: 100%;
        }

        .trip-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        }

        .trip-card .route-display {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 1rem;
        }

        .trip-card .route-display .city {
            font-weight: 700;
            font-size: 1.1rem;
            color: #fff;
        }

        .trip-card .route-display .arrow {
            color: var(--primary);
            font-size: 1.2rem;
        }

        .trip-card .trip-detail {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.9rem;
            margin-bottom: 0.3rem;
        }

        .trip-card .trip-detail i {
            margin-right: 6px;
            color: var(--primary);
        }

        .trip-card .price-tag {
            font-size: 1.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Profile upload */
        .profile-photo-wrapper {
            position: relative;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            overflow: hidden;
            border: 3px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .profile-photo-wrapper:hover {
            border-color: var(--primary);
        }

        .profile-photo-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-photo-wrapper .upload-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            cursor: pointer;
        }

        .profile-photo-wrapper:hover .upload-overlay {
            opacity: 1;
        }

        .upload-overlay i {
            color: #fff;
            font-size: 1.5rem;
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.25);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .glass-card { border-radius: 16px; }
            .stat-value { font-size: 1.5rem; }
            .page-header { font-size: 1.4rem; }
            .trip-card .price-tag { font-size: 1.2rem; }
        }

        /* Print */
        @media print {
            body { background: #fff !important; }
            .glass-navbar, .btn, form, .pagination { display: none !important; }
            .glass-card { background: #fff !important; border: 1px solid #ddd !important; }
            .glass-card * { color: #000 !important; }
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Floating background transport icons -->
    <div class="floating-icons">
        <i class="bi bi-bus-front" style="--size: 4rem; top: 10%; left: 5%; --duration: 25s; --delay: 0s;"></i>
        <i class="bi bi-truck" style="--size: 3rem; top: 20%; right: 10%; --duration: 30s; --delay: 2s;"></i>
        <i class="bi bi-geo-alt" style="--size: 2.5rem; top: 50%; left: 8%; --duration: 20s; --delay: 4s;"></i>
        <i class="bi bi-signpost-2" style="--size: 3.5rem; bottom: 20%; right: 5%; --duration: 28s; --delay: 1s;"></i>
        <i class="bi bi-ticket-perforated" style="--size: 2rem; top: 60%; right: 15%; --duration: 22s; --delay: 3s;"></i>
        <i class="bi bi-compass" style="--size: 3rem; bottom: 30%; left: 12%; --duration: 26s; --delay: 5s;"></i>
        <i class="bi bi-map" style="--size: 2.5rem; top: 30%; left: 50%; --duration: 24s; --delay: 2s;"></i>
        <i class="bi bi-arrow-right-circle" style="--size: 2rem; bottom: 10%; left: 40%; --duration: 20s; --delay: 4s;"></i>
    </div>

    <!-- Navbar -->
    <nav class="glass-navbar">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <a class="navbar-brand" href="{{ Auth::user()?->isAdmin() ? route('admin.dashboard') : route('client.dashboard') }}">
                    <i class="bi bi-bus-front me-2"></i>TranspoGo
                </a>
                <div class="d-flex align-items-center gap-2">
                    @auth
                        @if(Auth::user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                            <a href="{{ route('admin.buses.index') }}" class="nav-link {{ request()->routeIs('admin.buses.*') ? 'active' : '' }}">
                                <i class="bi bi-bus-front"></i> Buses
                            </a>
                            <a href="{{ route('admin.routes.index') }}" class="nav-link {{ request()->routeIs('admin.routes.*') ? 'active' : '' }}">
                                <i class="bi bi-signpost-2"></i> Routes
                            </a>
                            <a href="{{ route('admin.trips.index') }}" class="nav-link {{ request()->routeIs('admin.trips.*') ? 'active' : '' }}">
                                <i class="bi bi-calendar-event"></i> Trips
                            </a>
                            <a href="{{ route('admin.bookings.index') }}" class="nav-link {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
                                <i class="bi bi-ticket-perforated"></i> Bookings
                            </a>
                            <div class="dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                    <i class="bi bi-file-earmark-text"></i> Reports
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('admin.reports.trips') }}"><i class="bi bi-calendar-check me-2"></i>Trip Report</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.reports.bookings') }}"><i class="bi bi-journal-text me-2"></i>Booking Report</a></li>
                                </ul>
                            </div>
                        @else
                            <a href="{{ route('client.dashboard') }}" class="nav-link {{ request()->routeIs('client.dashboard') ? 'active' : '' }}">
                                <i class="bi bi-house"></i> Home
                            </a>
                            <a href="{{ route('client.trips') }}" class="nav-link {{ request()->routeIs('client.trips*') ? 'active' : '' }}">
                                <i class="bi bi-search"></i> Browse Trips
                            </a>
                            <a href="{{ route('client.bookings') }}" class="nav-link {{ request()->routeIs('client.bookings*') ? 'active' : '' }}">
                                <i class="bi bi-ticket-perforated"></i> My Tickets
                            </a>
                        @endif
                        <div class="dropdown ms-2">
                            <a href="#" class="d-flex align-items-center text-decoration-none" data-bs-toggle="dropdown">
                                <div class="position-relative">
                                    <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" class="nav-avatar">
                                    <span class="position-absolute bottom-0 end-0 p-1 bg-success rounded-circle" style="width: 10px; height: 10px; border: 2px solid #1a1a3e;"></span>
                                </div>
                                <span class="ms-2 text-white fw-500 d-none d-md-inline" style="font-size: 0.9rem;">{{ Auth::user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-person-circle me-2"></i>Profile</a></li>
                                @if(Auth::user()->isAdmin())
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="bi bi-shield me-2"></i>Admin Panel</a></li>
                                @endif
                                <li><hr class="dropdown-divider" style="border-color: rgba(255,255,255,0.1);"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button class="dropdown-item" type="submit"><i class="bi bi-box-arrow-right me-2"></i>Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div class="container mt-4 mb-5" style="position: relative; z-index: 1;">
        @if(session('success'))
            <div class="glass-alert success alert-dismissible fade show d-flex align-items-center">
                <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                {{ session('success') }}
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" style="filter: invert(1);"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="glass-alert danger alert-dismissible fade show d-flex align-items-center">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                {{ session('error') }}
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" style="filter: invert(1);"></button>
            </div>
        @endif
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
