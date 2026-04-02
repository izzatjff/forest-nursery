<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('storage/Tulen.png') }}" type="image/png">
    <title>@yield('title', 'Forest Nursery Management')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full">

<div class="app-layout">

    <!-- Sidebar Overlay (mobile) -->
    <div class="sidebar-overlay" id="sidebar-overlay" onclick="closeSidebar()"></div>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="sidebar-brand-icon">
                <img src="{{ asset('storage/Tulen.png') }}" alt="Deria Alam Logo" class="w-8 h-8 rounded-md">
            </div>
            <div class="sidebar-brand-text">
                <h1>Forest Nursery</h1>
                <span>Management System</span>
            </div>
        </div>

        <div class="sidebar-divider"></div>

        <nav class="sidebar-nav">
            <div class="sidebar-section-label">Overview</div>

            <a class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>
                Dashboard
            </a>

            <div class="sidebar-section-label">Inventory</div>

            <a class="nav-item {{ request()->routeIs('species.*') ? 'active' : '' }}" href="{{ route('species.index') }}">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2L3 7l9 5 9-5-9-5z"/><path d="M3 17l9 5 9-5"/><path d="M3 12l9 5 9-5"/></svg>
                Species Catalog
            </a>

            <a class="nav-item {{ request()->routeIs('seed-batches.*') ? 'active' : '' }}" href="{{ route('seed-batches.index') }}">
                <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-egg" viewBox="0 0 16 16">
                  <path d="M8 15a5 5 0 0 1-5-5c0-1.956.69-4.286 1.742-6.12.524-.913 1.112-1.658 1.704-2.164C7.044 1.206 7.572 1 8 1s.956.206 1.554.716c.592.506 1.18 1.251 1.704 2.164C12.31 5.714 13 8.044 13 10a5 5 0 0 1-5 5m0 1a6 6 0 0 0 6-6c0-4.314-3-10-6-10S2 5.686 2 10a6 6 0 0 0 6 6"/></svg>
                Seed Batches
            </a>

            <a class="nav-item {{ request()->routeIs('plants.*') ? 'active' : '' }}" href="{{ route('plants.index') }}">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M7 20h10"/><path d="M10 20c5.5-2.5.8-6.4 3-10"/><path d="M9.5 9.4c1.1.8 1.8 2.2 2.3 3.7-2 .4-3.5.4-4.8-.3-1.2-.6-2.3-1.9-3-4.2 2.8-.5 4.4 0 5.5.8z"/><path d="M14.1 6a7 7 0 0 0-1.1 4c1.9-.1 3.3-.6 4.3-1.4 1-1 1.6-2.3 1.7-4.6-2.7.1-4 1-4.9 2z"/></svg>
                Plants
            </a>

            <div class="sidebar-section-label">Transactions</div>

            <a class="nav-item {{ request()->routeIs('procurements.*') ? 'active' : '' }}" href="{{ route('procurements.index') }}">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>
                Procurements
            </a>

            <a class="nav-item {{ request()->routeIs('sales.*') ? 'active' : '' }}" href="{{ route('sales.index') }}">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12V7H5a2 2 0 0 1 0-4h14v4"/><path d="M3 5v14a2 2 0 0 0 2 2h16v-5"/><path d="M18 12a2 2 0 0 0 0 4h4v-4Z"/></svg>
                Sales
            </a>

            <div class="sidebar-section-label">Configuration</div>

            <a class="nav-item {{ request()->routeIs('origins.*') ? 'active' : '' }}" href="{{ route('origins.index') }}">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M2 12h20"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                Origins
            </a>
            <a class="nav-item {{ request()->routeIs('pricing.*') ? 'active' : '' }}" href="{{ route('pricing.index') }}">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                Pricing Engine
            </a>
        </nav>

        {{-- <div class="sidebar-footer">
            <div class="sidebar-footer-content">
                <div class="sidebar-footer-dot"></div>
                <span>System Online</span>
            </div>
        </div> --}}
    </aside>

    <!-- Main Content -->
    <div class="main-content">

        <!-- Top Bar -->
        <header class="topbar">
            <div style="display:flex;align-items:center;gap:12px;">
                <button class="mobile-toggle" onclick="toggleSidebar()">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                </button>
                <div class="topbar-title">
                    @yield('page-icon')
                    @yield('page-title', 'Dashboard')
                </div>
            </div>
            <div class="topbar-actions">
                @yield('page-actions')
            </div>
        </header>

        <!-- Content Area -->
        <div class="content-area">
            @if(session('success'))
            <div class="alert-banner alert-banner-success" id="flash-success">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                {{ session('success') }}
                <button onclick="this.parentElement.remove()" style="margin-left:auto;opacity:0.5;cursor:pointer;background:none;border:none;color:inherit;">&times;</button>
            </div>
            @endif

            @if(session('error'))
            <div class="alert-banner alert-banner-error" id="flash-error">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                {{ session('error') }}
                <button onclick="this.parentElement.remove()" style="margin-left:auto;opacity:0.5;cursor:pointer;background:none;border:none;color:inherit;">&times;</button>
            </div>
            @endif

            @if($errors->any())
            <div class="alert-banner alert-banner-error" id="flash-validation">
                <div>
                    <strong>Please fix the following errors:</strong>
                    <ul style="margin-top:4px;padding-left:16px;list-style:disc;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button onclick="this.parentElement.remove()" style="margin-left:auto;opacity:0.5;cursor:pointer;background:none;border:none;color:inherit;align-self:start;">&times;</button>
            </div>
            @endif

            @yield('content')
        </div>
    </div>
</div>

<script>
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('open');
    document.getElementById('sidebar-overlay').classList.toggle('active');
}
function closeSidebar() {
    document.getElementById('sidebar').classList.remove('open');
    document.getElementById('sidebar-overlay').classList.remove('active');
}
function formatCurrency(val) {
    return '$' + Number(val).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

// Auto-dismiss flash messages
setTimeout(() => {
    document.querySelectorAll('.alert-banner').forEach(el => {
        el.style.transition = 'opacity 0.3s, transform 0.3s';
        el.style.opacity = '0';
        el.style.transform = 'translateY(-8px)';
        setTimeout(() => el.remove(), 300);
    });
}, 5000);
</script>

@yield('scripts')

</body>
</html>
