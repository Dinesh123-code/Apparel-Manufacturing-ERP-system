<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ERP Management') — Manufacturing Suite</title>

    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts: Inter & JetBrains Mono -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-canvas: #f4f6f8;
            --sidebar-bg: #ffffff;
            --sidebar-border: #e5e7eb;
            --topbar-bg: #ffffff;
            --topbar-border: #e5e7eb;
            --accent-blue: #2563eb;
            --accent-blue-hover: #1d4ed8;
            --text-dark: #111827;
            --text-muted: #6b7280;
            --card-border: #e5e7eb;
            --card-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.03);
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--bg-canvas);
            color: var(--text-dark);
            margin: 0;
            font-size: 13.5px;
            -webkit-font-smoothing: antialiased;
        }

        /* ---- Sidebar ---- */
        #sidebar {
            position: fixed;
            top: 0; left: 0;
            width: 230px; height: 100vh;
            background: var(--sidebar-bg);
            border-right: 1px solid var(--sidebar-border);
            display: flex; flex-direction: column;
            z-index: 1000;
        }

        .sidebar-header {
            padding: 20px 20px 14px;
        }
        .brand-title {
            font-weight: 800;
            font-size: 16px;
            color: var(--text-dark);
            letter-spacing: -0.3px;
            line-height: 1.2;
        }
        .brand-sub {
            font-size: 10px;
            font-weight: 700;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        .btn-new-order {
            background: #000000;
            color: #ffffff;
            font-weight: 600;
            font-size: 13px;
            border-radius: 8px;
            padding: 10px 16px;
            border: none;
            display: flex; align-items: center; justify-content: center; gap: 8px;
            margin: 0 16px 20px;
            transition: background 0.15s;
            text-decoration: none;
        }
        .btn-new-order:hover {
            background: #1f2937;
            color: #ffffff;
        }

        .sidebar-menu {
            padding: 0 12px;
            list-style: none;
            margin: 0;
        }
        .sidebar-menu .nav-item {
            margin-bottom: 4px;
        }
        .sidebar-menu .nav-link-custom {
            display: flex; align-items: center; gap: 12px;
            padding: 10px 14px;
            color: #4b5563;
            font-weight: 500;
            font-size: 13.5px;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.15s;
        }
        .sidebar-menu .nav-link-custom:hover {
            background: #f3f4f6;
            color: #111827;
        }
        .sidebar-menu .nav-link-custom.active {
            background: var(--accent-blue);
            color: #ffffff;
            font-weight: 600;
        }
        .sidebar-menu .nav-link-custom.active i {
            color: #ffffff;
        }
        .sidebar-menu .nav-link-custom i {
            font-size: 16px;
            color: #6b7280;
        }

        .sidebar-footer {
            margin-top: auto;
            border-top: 1px solid var(--sidebar-border);
            padding: 12px;
        }

        /* ---- Main Wrapper ---- */
        #main-wrapper {
            margin-left: 230px;
            min-height: 100vh;
            display: flex; flex-direction: column;
        }

        /* ---- Top Navigation Bar ---- */
        .topbar {
            height: 64px;
            background: var(--topbar-bg);
            border-bottom: 1px solid var(--topbar-border);
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 28px;
            position: sticky; top: 0; z-index: 100;
        }

        .topbar-left {
            display: flex; align-items: center; gap: 36px;
        }
        .page-title {
            font-size: 19px;
            font-weight: 800;
            color: var(--text-dark);
            margin: 0;
            letter-spacing: -0.4px;
        }

        .topbar-tabs {
            display: flex; gap: 24px;
            margin: 0; padding: 0; list-style: none;
            height: 64px; align-items: center;
        }
        .topbar-tabs .tab-link {
            text-decoration: none;
            color: #4b5563;
            font-weight: 500;
            font-size: 13.5px;
            height: 64px;
            display: flex; align-items: center;
            border-bottom: 3px solid transparent;
            transition: all 0.15s;
        }
        .topbar-tabs .tab-link:hover {
            color: var(--text-dark);
        }
        .topbar-tabs .tab-link.active {
            color: var(--accent-blue);
            font-weight: 700;
            border-bottom-color: var(--accent-blue);
        }

        .topbar-right {
            display: flex; align-items: center; gap: 16px;
        }
        .search-box {
            position: relative;
            width: 240px;
        }
        .search-box input {
            width: 100%;
            padding: 7px 12px 7px 34px;
            font-size: 13px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            outline: none;
            background: #ffffff;
        }
        .search-box input:focus {
            border-color: var(--accent-blue);
            box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
        }
        .search-box i {
            position: absolute; left: 11px; top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 14px;
        }

        .icon-btn {
            background: none; border: none;
            color: #4b5563; font-size: 17px;
            cursor: pointer; padding: 6px;
            border-radius: 6px;
            display: flex; align-items: center; justify-content: center;
            transition: background 0.15s;
        }
        .icon-btn:hover { background: #f3f4f6; color: #111827; }

        .user-avatar-btn {
            width: 34px; height: 34px;
            border-radius: 50%;
            background: #2563eb;
            color: #ffffff;
            font-weight: 700;
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; border: none; cursor: pointer;
        }

        /* ---- Content Area ---- */
        .page-body {
            padding: 24px 28px;
            flex: 1;
        }

        /* ---- UI Cards ---- */
        .card-custom {
            background: #ffffff;
            border: 1px solid var(--card-border);
            border-radius: 12px;
            box-shadow: var(--card-shadow);
        }

        /* Monospace for codes */
        .font-mono {
            font-family: 'JetBrains Mono', monospace;
            font-weight: 600;
        }

        /* Badges */
        .badge-eff-high {
            background-color: #dcfce7;
            color: #15803d;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 6px;
            font-size: 12px;
        }
        .badge-eff-mid {
            background-color: #ffedd5;
            color: #c2410c;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 6px;
            font-size: 12px;
        }
        .badge-eff-low {
            background-color: #fee2e2;
            color: #b91c1c;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 6px;
            font-size: 12px;
        }

        .badge-status-active {
            background-color: #dcfce7;
            color: #15803d;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 11.5px;
        }
        .badge-status-inactive {
            background-color: #f3f4f6;
            color: #6b7280;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 11.5px;
        }

        /* Form Inputs */
        .form-control-custom, .form-select-custom {
            font-size: 13px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 7px 12px;
        }
        .form-control-custom:focus, .form-select-custom:focus {
            border-color: var(--accent-blue);
            box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
        }

        /* Buttons */
        .btn-black {
            background: #000000;
            color: #ffffff;
            font-weight: 600;
            font-size: 13px;
            border-radius: 8px;
            padding: 7px 16px;
            border: none;
        }
        .btn-black:hover {
            background: #1f2937;
            color: #ffffff;
        }

        .btn-outline-custom {
            border: 1px solid #d1d5db;
            background: #ffffff;
            color: #374151;
            font-size: 13px;
            font-weight: 600;
            border-radius: 8px;
            padding: 6px 14px;
        }
        .btn-outline-custom:hover {
            background: #f9fafb;
            color: #111827;
        }
    </style>
    @stack('styles')
</head>
<body>

<!-- Sidebar -->
<aside id="sidebar">
    <div class="sidebar-header">
        <div class="brand-title">ERP Management</div>
        <div class="brand-sub">MANUFACTURING</div>
    </div>

    <a href="{{ route('bundles.create') }}" class="btn-new-order">
        <i class="bi bi-plus-lg"></i> New Production Order
    </a>

    <ul class="sidebar-menu">
        <li class="nav-item">
            <a href="{{ route('sourcing') }}" class="nav-link-custom {{ request()->routeIs('sourcing*') ? 'active' : '' }}">
                <i class="bi bi-folder2-open"></i> Sourcing
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('cutting') }}" class="nav-link-custom {{ request()->routeIs('cutting*') ? 'active' : '' }}">
                <i class="bi bi-scissors"></i> Cutting
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('bundles.index') }}" class="nav-link-custom {{ request()->routeIs('bundles*') || request()->routeIs('dashboard*') || request()->routeIs('sewing*') ? 'active' : '' }}">
                <i class="bi bi-tsunami"></i> Sewing
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('qc') }}" class="nav-link-custom {{ request()->routeIs('qc*') ? 'active' : '' }}">
                <i class="bi bi-clipboard-check"></i> Master Data / QC
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('shipping') }}" class="nav-link-custom {{ request()->routeIs('shipping*') ? 'active' : '' }}">
                <i class="bi bi-truck"></i> Shipping
            </a>
        </li>
    </ul>

    <div class="sidebar-footer">
        <ul class="sidebar-menu">
            <li class="nav-item">
                <a href="{{ route('settings') }}" class="nav-link-custom {{ request()->routeIs('settings*') ? 'active' : '' }}">
                    <i class="bi bi-gear"></i> Settings
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('support') }}" class="nav-link-custom {{ request()->routeIs('support*') ? 'active' : '' }}">
                    <i class="bi bi-question-circle"></i> Support
                </a>
            </li>
        </ul>
    </div>
</aside>

<!-- Main Content Wrapper -->
<div id="main-wrapper">
    <!-- Topbar Header -->
    <header class="topbar">
        <div class="topbar-left">
            <h1 class="page-title">
                @yield('header-title', 'Bundle Management')
            </h1>
            <ul class="topbar-tabs">
                @if(request()->routeIs('master*'))
                    <li><a href="{{ route('master.buyers') }}" class="tab-link {{ request()->routeIs('master.buyers*') ? 'active' : '' }}">Buyers</a></li>
                    <li><a href="{{ route('master.styles') }}" class="tab-link {{ request()->routeIs('master.styles*') ? 'active' : '' }}">Styles</a></li>
                    <li><a href="{{ route('master.lines') }}" class="tab-link {{ request()->routeIs('master.lines*') ? 'active' : '' }}">Sewing Lines</a></li>
                @else
                    <li><a href="{{ route('dashboard') }}" class="tab-link {{ request()->routeIs('dashboard*') ? 'active' : '' }}">Dashboard</a></li>
                    <li><a href="{{ route('bundles.create') }}" class="tab-link {{ request()->routeIs('bundles.create*') ? 'active' : '' }}">Entry Form</a></li>
                    <li><a href="{{ route('bundles.index') }}" class="tab-link {{ request()->routeIs('bundles.index*') ? 'active' : '' }}">Listing</a></li>
                    <li><a href="{{ route('master.buyers') }}" class="tab-link">Master Data</a></li>
                @endif
            </ul>
        </div>

        <div class="topbar-right">
            <form method="GET" action="{{ route('bundles.index') }}" class="search-box">
                <i class="bi bi-search"></i>
                <input type="text" name="search" placeholder="Search Bundles..." value="{{ request('search') }}">
            </form>
            <button class="icon-btn" title="Notifications" onclick="showToast('You have 3 new quality audit notifications.', 'info')"><i class="bi bi-bell"></i></button>
            <button class="icon-btn" title="History" onclick="openHistoryModal()"><i class="bi bi-clock-history"></i></button>
            
            <div class="dropdown">
                <button class="user-avatar-btn" data-bs-toggle="dropdown">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><span class="dropdown-item-text fw-bold">{{ auth()->user()->name ?? 'User' }}</span></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-1"></i> Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <!-- Page Body -->
    <main class="page-body">
        @yield('content')
        {{ $slot ?? '' }}
    </main>
</div>

<!-- Activity History Modal -->
<div class="modal fade" id="historyModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" style="font-size: 16px;"><i class="bi bi-clock-history text-primary me-2"></i> System Activity & Audit History</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4" id="historyModalContent">
                <div class="text-center py-4">
                    <span class="spinner-border spinner-border-sm text-primary"></span> Loading Activity Logs...
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Toast Container -->
<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="appToast" class="toast align-items-center border-0 text-white" role="alert">
        <div class="d-flex">
            <div class="toast-body" id="toastBody"></div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>

<script>
function showToast(message, type = 'success') {
    const toast = document.getElementById('appToast');
    const body  = document.getElementById('toastBody');
    toast.className = 'toast align-items-center border-0 text-white bg-' + (type === 'success' ? 'success' : (type === 'info' ? 'primary' : 'danger'));
    body.textContent = message;
    new bootstrap.Toast(toast, { delay: 4000 }).show();
}

function openHistoryModal() {
    const modalEl = document.getElementById('historyModal');
    const modal = new bootstrap.Modal(modalEl);
    modal.show();

    fetch('{{ route("activity-logs") }}')
        .then(r => r.json())
        .then(logs => {
            let html = '<div class="list-group list-group-flush">';
            logs.forEach(log => {
                html += `
                    <div class="list-group-item py-3">
                        <div class="d-flex w-100 justify-content-between align-items-center">
                            <h6 class="mb-1 fw-bold text-dark" style="font-size: 13.5px;"><i class="bi bi-activity text-primary me-2"></i> ${log.description}</h6>
                            <small class="text-muted" style="font-size: 11px;">${new Date(log.created_at).toLocaleString()}</small>
                        </div>
                        <p class="mb-1 text-muted" style="font-size: 12px;">Performed by: <strong>${log.causer_name}</strong> | Action: <span class="badge bg-light text-dark border">${log.event}</span></p>
                    </div>
                `;
            });
            html += '</div>';
            document.getElementById('historyModalContent').innerHTML = html;
        })
        .catch(() => {
            document.getElementById('historyModalContent').innerHTML = '<div class="text-danger p-3">Failed to load history logs.</div>';
        });
}
</script>
@stack('scripts')
</body>
</html>
