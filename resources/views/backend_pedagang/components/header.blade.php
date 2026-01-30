<header>
    <div class="topbar d-flex align-items-center px-3 py-2 bg-white shadow-sm">
        <nav class="navbar navbar-expand w-100 d-flex align-items-center justify-content-between">

            <!-- 🔹 Kiri: burger + logo + teks -->
            <div class="d-flex align-items-center gap-2">
                <div class="mobile-toggle-menu">
                    <i class="bx bx-menu fs-4"></i>
                </div>

                <!-- logo + teks disembunyikan di layar kecil -->
                <div class="d-none d-lg-flex align-items-center gap-2">
                    <img src="{{ asset('backend/assets/images/logo_kota_dumai.png') }}" 
                         class="logo-icon" alt="logo icon" width="35">
                    <h5 class="logo-text mb-0 fw-bold text-primary">PORTAL PEDAGANG</h5>
                </div>
            </div>

            <!-- 🔹 Kanan: user -->
            <div class="user-box dropdown d-flex align-items-center">
                <!-- GANTI DARI <a> JADI <button> -->
                <button class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret p-0 border-0 bg-transparent" 
                    type="button" 
                    data-bs-toggle="dropdown" 
                    aria-expanded="false">
                    <img src="{{ asset('backend/assets/images/user.jpg') }}" 
                         class="user-img rounded-circle" 
                         alt="user avatar" width="35" height="35" />
                    <div class="user-info ps-2 d-none d-sm-block">
                        <p class="user-name mb-0 fw-semibold text-dark">
                            {{ $displayName ?? Auth::user()->nik }}
                        </p>
                    </div>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow">
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item border-0 bg-transparent w-100 text-start">
                                <i class="bx bx-log-out-circle"></i><span>Logout</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </div>

        </nav>
    </div>
    <style>
    @media (max-width: 1199.98px) {
        .topbar .logo-icon,
        .topbar .logo-text {
            display: none !important;
        }
    }
    
    /* Optional: styling untuk button biar mirip link */
    .user-box .nav-link.dropdown-toggle {
        cursor: pointer;
    }
    .user-box .nav-link.dropdown-toggle:focus {
        box-shadow: none;
        outline: none;
    }
    </style>
</header>