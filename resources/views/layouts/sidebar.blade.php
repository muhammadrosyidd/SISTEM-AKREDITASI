<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
    /* Menggunakan font Poppins untuk seluruh sidebar */
    .sidenav,
    .sidenav * {
        font-family: 'Poppins', sans-serif;
        box-sizing: border-box;
    }

    /* Latar belakang gelap yang solid */
    .sidenav {
        background-color: #0f172a;
    }

    /* Memberi jarak antar setiap item menu utama */
    .nav-item {
        margin-bottom: 18px;
    }

    /* Penyesuaian Nav Link */
    .nav-link {
        color: #cbd5e1;
        padding: 0.8rem 1.5rem;
        display: flex;
        align-items: center;
        border-radius: 6px;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    /* Gaya saat kursor diarahkan ke link */
    .nav-link:hover {
        background-color: #1e293b;
        color: #ffffff;
    }

    /* Gaya untuk link yang sedang aktif/terpilih */
    .nav-link.active {
        background-color: #4f46e5;
        color: #ffffff;
        font-weight: 500;
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
    }

    /* Gaya untuk menonaktifkan interaksi pada heading menu */
    .nav-link.non-interactive {
        cursor: default;
    }

    .nav-link.non-interactive:hover {
        background-color: transparent;
        color: #cbd5e1;
    }

    /* Menata ikon agar sejajar */
    .nav-icon {
        width: 24px;
        margin-right: 1rem;
        text-align: center;
        font-size: 1.1rem;
    }

    /* Wrapper untuk sub-menu kriteria dengan garis vertikal */
    .submenu-wrapper {
        position: relative;
        padding-left: 1.25rem;
        margin-left: 27px;
        border-left: 2px solid #334155;
    }

    /* Gaya untuk setiap link di dalam sub-menu */
    .submenu-wrapper .nav-link {
        padding: 0.6rem 1rem;
        font-size: 0.9rem;
        font-weight: 400;
    }

    /* Mengatur jarak yang lebih rapat untuk item di dalam submenu */
    .submenu-wrapper .nav-item {
        margin-bottom: 4px;
    }

    /* Hover di submenu tidak perlu shadow atau warna se-kontras menu utama */
    .submenu-wrapper .nav-link.active,
    .submenu-wrapper .nav-link:hover {
        background-color: #334155;
        box-shadow: none;
    }
</style>

<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 fixed-start" id="sidenav-main">
    <div class="sidenav-header" style="height: 70px;">
        <a class="navbar-brand d-flex align-items-center m-0 px-4" href="#">
            <span class="font-weight-bold text-lg text-white">Sistem Akreditasi</span>
        </a>
    </div>

    {{-- Wrapper utama menu --}}
    <div class="collapse navbar-collapse px-3 w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                    href="{{ route('dashboard') }}">
                    <div class="nav-icon"><i class="bi bi-grid-1x2"></i></div>
                    <span class="nav-link-text">Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link non-interactive">
                    <div class="nav-icon"><i class="bi bi-stack"></i></div>
                    <span class="nav-link-text">Kriteria</span>
                </a>

                <div>
                    <div class="submenu-wrapper mt-2">
                        <ul class="navbar-nav">
                            <li class="nav-item"><a
                                    class="nav-link {{ request()->routeIs('kriteria.index') ? 'active' : '' }}"
                                    href="{{ route('kriteria.index') }}">Kriteria 1</a></li>
                            <li class="nav-item"><a
                                    class="nav-link {{ request()->routeIs('kriteria2.index') ? 'active' : '' }}"
                                    href="{{ route('kriteria2.index') }}">Kriteria 2</a></li>
                            <li class="nav-item"><a
                                    class="nav-link {{ request()->routeIs('kriteria3.index') ? 'active' : '' }}"
                                    href="{{ route('kriteria3.index') }}">Kriteria 3</a></li>
                            <li class="nav-item"><a
                                    class="nav-link {{ request()->routeIs('kriteria4.index') ? 'active' : '' }}"
                                    href="{{ route('kriteria4.index') }}">Kriteria 4</a></li>
                            <li class="nav-item"><a
                                    class="nav-link {{ request()->routeIs('kriteria5.index') ? 'active' : '' }}"
                                    href="{{ route('kriteria5.index') }}">Kriteria 5</a></li>
                            <li class="nav-item"><a
                                    class="nav-link {{ request()->routeIs('kriteria6.index') ? 'active' : '' }}"
                                    href="{{ route('kriteria6.index') }}">Kriteria 6</a></li>
                            <li class="nav-item"><a
                                    class="nav-link {{ request()->routeIs('kriteria7.index') ? 'active' : '' }}"
                                    href="{{ route('kriteria7.index') }}">Kriteria 7</a></li>
                            <li class="nav-item"><a
                                    class="nav-link {{ request()->routeIs('kriteria8.index') ? 'active' : '' }}"
                                    href="{{ route('kriteria8.index') }}">Kriteria 8</a></li>
                            <li class="nav-item"><a
                                    class="nav-link {{ request()->routeIs('kriteria9.index') ? 'active' : '' }}"
                                    href="{{ route('kriteria9.index') }}">Kriteria 9</a></li>
                        </ul>
                    </div>
                </div>
            </li>

            {{-- ====================================================== --}}
            {{-- [MODIFIKASI] BLOK VALIDASI DENGAN IKON SEMULA --}}
            {{-- ====================================================== --}}
            <li class="nav-item">
                {{-- Ikon dikembalikan menjadi 'bi-person-check' --}}
                <a class="nav-link {{ request()->routeIs('validasikjr.index') ? 'active' : '' }}"
                    href="{{ route('validasikjr.index') }}">
                    <div class="nav-icon"><i class="bi bi-person-check"></i></div>
                    <span class="nav-link-text">Validasi Kajur</span>
                </a>
            </li>
            <li class="nav-item">
                {{-- Ikon dikembalikan menjadi 'bi-patch-check' --}}
                <a class="nav-link {{ request()->routeIs('validasi.index') ? 'active' : '' }}"
                    href="{{ route('validasi.index') }}">
                    <div class="nav-icon"><i class="bi bi-patch-check"></i></div>
                    <span class="nav-link-text">Validasi Direktur</span>
                </a>
            </li>
            {{-- ====================================================== --}}
            {{-- AKHIR BLOK MODIFIKASI --}}
            {{-- ====================================================== --}}

            <li class="nav-item">
                <a class="nav-link" href="#"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <div class="nav-icon"><i class="bi bi-box-arrow-left"></i></div>
                    <span class="nav-link-text">Logout</span>
                </a>
            </li>
        </ul>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</aside>
