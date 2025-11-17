<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Lumospace - Modern Furniture & Lighting')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container px-4">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">
                Lumospace
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('products') }}">Shop</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('service') }}">Contact</a></li>
                </ul>

                <div class="d-flex align-items-center gap-3">
                    <!-- Cart Icon (Authenticated users only) -->
                    @auth
                        @if(Auth::user()->role !== 'admin')
                            <a href="{{ route('cart.index') }}" class="position-relative text-white" title="My Cart">
                                <i class="bi bi-cart3" style="font-size: 1.3rem;"></i>
                                @if(Auth::user()->cart && Auth::user()->cart->items->count() > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning text-dark" style="font-size: 0.7rem;">
                                        {{ Auth::user()->cart->items->count() }}
                                    </span>
                                @endif
                            </a>
                        @endif
                    @endauth

                    <!-- Search Icon & Bar (Toggle + Direct to Products) -->
                    <div class="search-toggle-container">
                        <!-- Search Icon -->
                        <a href="{{ route('products') }}" class="search-icon-link" id="searchIconBtn" onclick="toggleSearchInput(event)" title="Search Products">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="color: white;">
                                <circle cx="8" cy="8" r="6" stroke="currentColor" stroke-width="1.5" fill="none"/>
                                <path d="M12 12L18 18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            </svg>
                        </a>

                        <!-- Search Input (Hidden by default) -->
                        <form action="{{ route('products') }}" method="GET" class="search-input-form" id="searchInputForm" style="display: none;">
                            <div class="input-group input-group-sm">
                                <input type="text" 
                                       class="form-control" 
                                       name="search" 
                                       placeholder="Cari..." 
                                       id="headerSearchInput"
                                       style="height: 32px; width: 200px;">
                                <button class="btn btn-warning" type="submit" style="height: 32px; padding: 0 10px;">
                                    <i class="bi bi-search"></i>
                                </button>
                                <button class="btn btn-secondary" type="button" id="closeSearchBtn" style="height: 32px; padding: 0 8px;">
                                    <i class="bi bi-x"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                    
                    <!-- User Menu Dropdown -->
                    @auth
                        <div class="dropdown">
                            <a href="#" class="text-white me-3 dropdown-toggle" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li>
                                    <h6 class="dropdown-header">{{ Auth::user()->name }}</h6>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                @if(Auth::user()->role === 'admin')
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        <i class="bi bi-speedometer2"></i> Admin Dashboard
                                    </a></li>
                                @else
                                    <li><a class="dropdown-item" href="{{ route('cart.index') }}">
                                        <i class="bi bi-cart"></i> My Cart
                                    </a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('auth.logout') }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="bi bi-box-arrow-right"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <!-- Not Authenticated - Show Login/Register -->
                        <div class="dropdown">
                            <a href="#" class="text-white me-3 dropdown-toggle" id="guestDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="guestDropdown">
                                <li><a class="dropdown-item" href="{{ route('auth.login') }}">
                                    <i class="bi bi-box-arrow-in-right"></i> Login
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('auth.register') }}">
                                    <i class="bi bi-person-plus"></i> Register
                                </a></li>
                            </ul>
                        </div>
                    @endauth

                    @if(!Auth::check() || Auth::user()->role !== 'admin')
                        <a href="{{ route('service') }}" class="btn btn-warning fw-bold">Buy Now</a>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Content -->
    @yield('content')

    <!-- Footer -->
    <footer class="footer bg-dark text-white mt-5 py-4">
        <div class="container text-center">
            <h5 class="fw-bold mb-2">Lumospace</h5>
            <p class="mb-1">Modern furniture & lighting crafted for your lifestyle.</p>
            <div class="mb-3">
                <a href="#" class="text-white me-3"><i class="bi bi-instagram"></i></a>
                <a href="#" class="text-white me-3"><i class="bi bi-facebook"></i></a>
                <a href="#" class="text-white"><i class="bi bi-envelope"></i></a>
            </div>
            <p class="small mb-0">&copy; {{ date('Y') }} Lumospace. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        .search-toggle-container {
            position: relative;
            display: flex;
            align-items: center;
            min-width: 24px;
            min-height: 24px;
        }

        .search-icon-link {
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 24px;
            height: 24px;
            text-decoration: none;
            opacity: 1;
            visibility: visible;
        }

        .search-icon-link:hover {
            opacity: 0.8;
            transform: scale(1.1);
        }

        .search-icon-link.hidden {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            position: absolute;
        }

        .search-input-form {
            display: flex;
            align-items: center;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        .search-input-form.show {
            opacity: 1;
            visibility: visible;
        }

        .search-input-form .form-control {
            border-radius: 4px 0 0 4px;
            font-size: 0.85rem;
        }

        .search-input-form .btn {
            border-radius: 0;
            font-size: 0.85rem;
        }

        .search-input-form .btn:last-child {
            border-radius: 0 4px 4px 0;
        }
    </style>

    <script>
        function expandSearchBar(e) {
            e.preventDefault();
            const form = document.getElementById('expandedSearchForm');
            const input = document.getElementById('expandedSearchInput');
            
            // Toggle show state
            if (form.classList.contains('show')) {
                form.classList.remove('show');
                form.style.display = 'none';
            } else {
                form.classList.add('show');
                form.style.display = 'block';
                input.focus();
            }
        }

        function toggleSearchInput(e) {
            const currentPath = window.location.pathname;
            const isProductsPage = currentPath === '/products';
            
            // Jika sudah di halaman products, toggle search bar
            if (isProductsPage) {
                e.preventDefault();
                const icon = document.getElementById('searchIconBtn');
                const form = document.getElementById('searchInputForm');
                const input = document.getElementById('headerSearchInput');
                
                if (form.style.display === 'none' || !form.style.display) {
                    // Show form
                    form.style.display = 'block';
                    icon.classList.add('hidden');
                    form.classList.add('show');
                    input.focus();
                } else {
                    // Hide form
                    form.style.display = 'none';
                    icon.classList.remove('hidden');
                    form.classList.remove('show');
                }
            }
            // Jika tidak di halaman products, biarkan link navigasi (tidak preventDefault)
        }

        // Close search when ESC pressed
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const form = document.getElementById('searchInputForm');
                const icon = document.getElementById('searchIconBtn');
                if (form && form.style.display !== 'none') {
                    form.style.display = 'none';
                    icon.classList.remove('hidden');
                    form.classList.remove('show');
                }
            }
        });

        // Close search when clicking outside
        document.addEventListener('click', function(e) {
            const container = document.querySelector('.search-toggle-container');
            const form = document.getElementById('searchInputForm');
            const icon = document.getElementById('searchIconBtn');
            if (container && !container.contains(e.target) && form && form.style.display !== 'none') {
                form.style.display = 'none';
                icon.classList.remove('hidden');
                form.classList.remove('show');
            }
        });

        // Close button
        const closeBtn = document.getElementById('closeSearchBtn');
        if (closeBtn) {
            closeBtn.addEventListener('click', function() {
                const form = document.getElementById('searchInputForm');
                const icon = document.getElementById('searchIconBtn');
                form.style.display = 'none';
                icon.classList.remove('hidden');
                form.classList.remove('show');
            });
        }

        // Auto-toggle search bar saat navigasi ke halaman products selesai
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            if (currentPath === '/products') {
                const form = document.getElementById('searchInputForm');
                const icon = document.getElementById('searchIconBtn');
                if (form && icon) {
                    form.style.display = 'block';
                    icon.classList.add('hidden');
                    form.classList.add('show');
                    const input = document.getElementById('headerSearchInput');
                    if (input) input.focus();
                }
            }
        });
    </script>
</body>

</html>
