<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">
  
      <div class="d-flex align-items-center justify-content-between">
        <a href="index.html" class="logo d-flex align-items-center">
          <img src="/NiceAdmin/assets/img/logo.png" alt="">
          <span class="d-none d-lg-block">Paping Nusantara</span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i> <!-- Tombol Sidebar -->
      </div>
  
      <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">
          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="/NiceAdmin/assets/img/wong.jpg" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::user()->name }}</span>
          </a>
  
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>{{ Auth::user()->name }}</h6>
              <span>{{ Auth::user()->role }}</span>
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                  @csrf
              </form>
              <a class="dropdown-item d-flex align-items-center" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                  <i class="bi bi-box-arrow-right"></i>
                  <span>Sign Out</span>
              </a>
            </li>
          </ul>
        </ul>
      </nav>
    </header>

    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar collapsed"> <!-- Sidebar dalam keadaan tertutup -->
      <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
          <a class="nav-link" href="index.html">
            <i class="bi bi-grid"></i>
            <span>Dashboard</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="{{ route('admin.users.index') }}">
            <i class="bi bi-people"></i><span>Akun Karyawan</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="{{ route('admin.karyawan.index') }}">
            <i class="bi bi-people"></i><span>Karyawan</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link collapsed" data-bs-toggle="collapse" href="#pengelolaan-nav">
            <i class="bi bi-box2-fill"></i><span>Pengelolaan</span><i class="bi bi-chevron-down ms-auto"></i>
          </a>
          <ul id="pengelolaan-nav" class="nav-content collapse">
            <li><a href="{{ route('admin.produk.index') }}"><i class="bi bi-circle"></i> Produk</a></li>
            <li><a href="{{ route('admin.produksi.create') }}"><i class="bi bi-circle"></i> Produksi</a></li>
            <li><a href="{{ route('admin.bahan.index') }}"><i class="bi bi-circle"></i> Bahan</a></li>
          </ul>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="{{ route('admin.suplier.index') }}">
            <i class="bi bi-box2-fill"></i><span>Suplier</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="{{ route('admin.mitra.index') }}">
            <i class="bi bi-person-workspace"></i><span>Mitra</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="{{ route('admin.datamesin.index') }}">
            <i class="bi bi-gear-fill"></i><span>Mesin</span>
          </a>
        </li>

      </ul>
    </aside>

    <!-- ======= Main Content ======= -->
    <main id="main" class="main">
        <div class="container">
        </div>
    </main>

    <!-- ======= JavaScript untuk Sidebar ======= -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
    const toggleBtn = document.querySelector(".toggle-sidebar-btn");
    const sidebar = document.querySelector("#sidebar");

    function closeSidebar() {
        sidebar.classList.add("collapsed");
    }

    toggleBtn.addEventListener("click", function () {
        sidebar.classList.toggle("collapsed");
    });

    document.addEventListener("click", function (event) {
        const isClickInsideSidebar = sidebar.contains(event.target);
        const isClickOnToggleBtn = toggleBtn.contains(event.target);

        // Jangan tutup sidebar jika klik terjadi pada submenu
        const isSubmenuLink = event.target.closest("#pengelolaan-nav");
        
        if (!isClickInsideSidebar && !isClickOnToggleBtn && !isSubmenuLink) {
            closeSidebar();
        }
    });
});

    </script>

</body>