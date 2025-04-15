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
            <a class="dropdown-item d-flex align-items-center" href="{{ route('profile.index') }}">
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
    <aside id="sidebar" class="sidebar">
  
      <ul class="sidebar-nav" id="sidebar-nav">
  
        <li class="nav-item">
          <a class="nav-link " href="index.html">
            <i class="bi bi-grid"></i>
            <span>Dashboard</span>
          </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-item">
          <a class="nav-link" href="{{ route('karyawan.bulanan.absen.index') }}">
            <i class="bi bi-person-vcard"></i><span>Absensi</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="{{ route('admin.karyawan.index') }}">
            <i class="bi bi-card-list"></i><span>Slip Gaji</span>
          </a>
        </li>
      </ul>
  
    </aside><!-- End Sidebar-->
  