<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Furni. Admin & Petugas — {{ $page_title ?? 'Dashboard' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f2f1;
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        /* ── SIDEBAR ─────────────────────────────────── */
        .sidebar {
            width: 84px;
            background: #ffffff;
            height: 100vh;
            border-right: 1px solid #e5e7eb;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 0 0 24px;
            flex-shrink: 0;
            z-index: 50;
            transition: width 0.25s ease;
            overflow: hidden;
        }

        .sidebar-logo {
            height: 72px;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            border-bottom: 1px solid #f1f5f9;
            flex-shrink: 0;
        }
        .sidebar-logo span {
            font-size: 16px;
            font-weight: 900;
            color: #3b5d50;
            letter-spacing: -1px;
            text-transform: uppercase;
        }

        .sidebar-nav {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            width: 100%;
            padding-top: 12px;
            gap: 8px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            border-radius: 10px;
            color: #94a3b8;
            text-decoration: none;
            transition: all 0.2s;
            position: relative;
        }
        .nav-item:hover {
            background-color: #f0f7f4;
            color: #3b5d50;
        }
        .nav-item.active {
            background-color: #3b5d50;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(59, 93, 80, 0.35);
        }
        .nav-item svg { width: 20px; height: 20px; }

        /* Tooltip */
        .nav-item::after {
            content: attr(data-tooltip);
            position: absolute;
            left: 56px;
            background: #1e293b;
            color: #fff;
            font-size: 12px;
            font-weight: 600;
            padding: 5px 10px;
            border-radius: 6px;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.15s;
            z-index: 100;
        }
        .nav-item:hover::after { opacity: 1; }

        .nav-divider {
            width: 32px;
            height: 1px;
            background: #f1f5f9;
            margin: 8px auto;
        }

        .sidebar-bottom {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            width: 100%;
            padding: 0 14px;
        }

        .btn-logout {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            border-radius: 10px;
            color: #94a3b8;
            background: none;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
        }
        .btn-logout:hover { background: #fef2f2; color: #ef4444; }
        .btn-logout svg { width: 20px; height: 20px; }
        .btn-logout::after {
            content: 'Logout';
            position: absolute;
            left: 52px;
            background: #1e293b;
            color: #fff;
            font-size: 12px;
            font-weight: 600;
            padding: 5px 10px;
            border-radius: 6px;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.15s;
        }
        .btn-logout:hover::after { opacity: 1; }

        /* ── MAIN AREA ────────────────────────────────── */
        .admin-main {
            flex: 1;
            display: flex;
            flex-direction: column;
            height: 100vh;
            overflow: hidden;
        }

        .admin-header {
            background: linear-gradient(135deg, #3b5d50 0%, #2d4a3e 100%);
            height: 72px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 36px;
            color: white;
            flex-shrink: 0;
            box-shadow: 0 2px 8px rgba(59, 93, 80, 0.25);
        }
        .header-left { display: flex; align-items: center; gap: 16px; }
        .header-title {
            font-size: 1.25rem;
            font-weight: 700;
            letter-spacing: -0.01em;
        }
        .header-breadcrumb {
            font-size: 0.8rem;
            color: rgba(255,255,255,0.6);
            font-weight: 500;
        }
        .header-right { display: flex; align-items: center; gap: 16px; }
        .header-user {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .header-avatar {
            width: 36px;
            height: 36px;
            background: rgba(255,255,255,0.2);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 14px;
            border: 2px solid rgba(255,255,255,0.3);
        }
        .header-user-info { text-align: right; }
        .header-user-name { font-weight: 600; font-size: 0.875rem; }
        .header-user-role {
            font-size: 0.7rem;
            color: rgba(255,255,255,0.65);
            background: rgba(255,255,255,0.15);
            padding: 2px 8px;
            border-radius: 20px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        /* ── SCROLL CONTENT ───────────────────────────── */
        .admin-content {
            flex: 1;
            overflow-y: auto;
            padding: 32px 36px;
        }

        /* ── SUCCESS / ERROR ALERTS ───────────────────── */
        .alert-success {
            background: linear-gradient(135deg, #d1fae5, #ecfdf5);
            border: 1px solid #6ee7b7;
            color: #065f46;
            padding: 14px 20px;
            border-radius: 12px;
            margin-bottom: 24px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.9rem;
        }
        .alert-error {
            background: #fef2f2;
            border: 1px solid #fca5a5;
            color: #991b1b;
            padding: 14px 20px;
            border-radius: 12px;
            margin-bottom: 24px;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-logo">
            <span>Furni.</span>
        </div>

        <nav class="sidebar-nav">
            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}"
               class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
               data-tooltip="Dashboard">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
            </a>

            <!-- Kelola Produk -->
            <a href="{{ route('admin.products.index') }}"
               class="nav-item {{ request()->routeIs('admin.products.*') ? 'active' : '' }}"
               data-tooltip="Kelola Produk">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </a>

            <!-- Kelola Pesanan -->
            <a href="{{ route('admin.orders.index') }}"
               class="nav-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}"
               data-tooltip="Kelola Pesanan">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </a>

            <!-- Petugas (Admin Only) -->
            @if(auth('admin')->user()->role === 'admin')
                <a href="{{ route('admin.staff.index') }}"
                   class="nav-item {{ request()->routeIs('admin.staff.*') ? 'active' : '' }}"
                   data-tooltip="Petugas">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </a>
            @endif

            <!-- Customer (Admin Only) -->
            @if(auth('admin')->user()->role === 'admin')
                <a href="{{ route('admin.customers.index') }}"
                   class="nav-item {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}"
                   data-tooltip="Customer">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </a>
            @endif

            <!-- Laporan Penjualan (Admin Only) -->
            @if(auth('admin')->user()->role === 'admin')
                <a href="{{ route('admin.reports.sales') }}"
                   class="nav-item {{ request()->routeIs('admin.reports.sales') ? 'active' : '' }}"
                   data-tooltip="Laporan Penjualan">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </a>
            @endif

            <!-- Laporan Customer / Inbox (Shared with role-based tooltips) -->
            <a href="{{ route('admin.reports.customer') }}"
               class="nav-item {{ request()->routeIs('admin.reports.customer.*') ? 'active' : '' }}"
               data-tooltip="{{ auth('admin')->user()->role === 'admin' ? 'Laporan Customer' : 'Laporan' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                </svg>
            </a>
        </nav>

        <div class="sidebar-bottom">
            <form method="POST" action="{{ route('admin.logout') }}" style="margin:0;">
                @csrf
                <button type="submit" class="btn-logout">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main -->
    <main class="admin-main">
        <header class="admin-header">
            <div class="header-left">
                <div>
                    <h1 class="header-title">{{ $page_title ?? 'Dashboard' }}</h1>
                </div>
            </div>
            <div class="header-right">
                <div class="header-user">
                    <div class="header-user-info">
                        <p class="header-user-name">{{ auth('admin')->user()->name }}</p>
                    </div>
                    <div class="header-avatar">
                        {{ strtoupper(substr(auth('admin')->user()->name, 0, 1)) }}
                    </div>
                </div>
            </div>
        </header>

        <div class="admin-content">
            @if(session('success'))
                <div class="alert-success">
                    <svg style="width:18px;height:18px;flex-shrink:0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert-error">{{ session('error') }}</div>
            @endif

            @yield('content')
        </div>
    </main>

</body>
</html>
