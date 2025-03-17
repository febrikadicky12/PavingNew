<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">
  
      <div class="d-flex align-items-center justify-content-between">
        <a href="index.html" class="logo d-flex align-items-center">
          <img src="\NiceAdmin\assets\img\logo.png" alt="">
          <span class="d-none d-lg-block">Paping Nusantara</span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
      </div><!-- End Logo -->
  
    <!-- End Search Bar -->
  
      <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">
            <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
              <img src="/NiceAdmin/assets/img/wong.jpg" alt="Profile" class="rounded-circle">
              <span class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::user()->name }}</span>
            </a><!-- End Profile Iamge Icon -->
  
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
              <li class="dropdown-header">
              <h6>{{ Auth::user()->name }}</h6>
              <span>{{ Auth::user()->role }}</span>
              
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
            
  
            </ul><!-- End Profile Dropdown Items -->
          </li><!-- End Profile Nav -->
  
        </ul>
      </nav><!-- End Icons Navigation -->
  
    </header><!-- End Header -->
  
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
  <a class="nav-link" href="{{ route('admin.users.index') }}">
    <i class="bi bi-people"></i><span>Akun Karyawan</span>
  </a>
</li><!-- End Akun Karyawan Nav -->

<li class="nav-item">
  <a class="nav-link" href="{{ route('admin.karyawan.index') }}">
    <i class="bi bi-people"></i><span>Karyawan</span>
  </a>
</li><!-- End Akun Karyawan Nav -->


<li class="nav-item">
          <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-box2-fill"></i><span>Pengelolaan</span><i class="bi bi-chevron-down ms-auto"></i>
          </a>
          <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
            <li>
              <a href="{{ route('admin.produk.index') }}">
                <i class="bi bi-circle"></i><span>Produk</span>
              </a>
            </li>
            <li>
              <a href="{{ route('admin.produksi.create') }}">
                <i class="bi bi-circle"></i><span>Produksi</span>
              </a>
            </li>
            <li>
              <a href="{{ route('admin.bahan.index') }}">
                <i class="bi bi-circle"></i><span>Bahan</span>
              </a>
            </li>
          </ul>
        </li><!-- End Tables Nav -->

        {{-- <li class="nav-item">
  <a class="nav-link" href="{{ route('admin.bahan.index') }}">
    <i class="bi bi-cart4"></i><span>Bahan</span>
  </a>
</li><!-- End Akun Karyawan Nav --> --}}

          <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
            <li>
              <a href="components-alerts.html">
                <i class="bi bi-circle"></i><span>Alerts</span>
              </a>
            </li>
            <li>
              <a href="components-accordion.html">
                <i class="bi bi-circle"></i><span>Accordion</span>
              </a>
            </li>
            <li>
              <a href="components-badges.html">
                <i class="bi bi-circle"></i><span>Badges</span>
              </a>
            </li>
            <li>
              <a href="components-breadcrumbs.html">
                <i class="bi bi-circle"></i><span>Breadcrumbs</span>
              </a>
            </li>
            <li>
              <a href="components-buttons.html">
                <i class="bi bi-circle"></i><span>Buttons</span>
              </a>
            </li>
            <li>
              <a href="components-cards.html">
                <i class="bi bi-circle"></i><span>Cards</span>
              </a>
            </li>
            <li>
              <a href="components-carousel.html">
                <i class="bi bi-circle"></i><span>Carousel</span>
              </a>
            </li>
            <li>
              <a href="components-list-group.html">
                <i class="bi bi-circle"></i><span>List group</span>
              </a>
            </li>
            <li>
              <a href="components-modal.html">
                <i class="bi bi-circle"></i><span>Modal</span>
              </a>
            </li>
            <li>
              <a href="components-tabs.html">
                <i class="bi bi-circle"></i><span>Tabs</span>
              </a>
            </li>
            <li>
              <a href="components-pagination.html">
                <i class="bi bi-circle"></i><span>Pagination</span>
              </a>
            </li>
            <li>
              <a href="components-progress.html">
                <i class="bi bi-circle"></i><span>Progress</span>
              </a>
            </li>
            <li>
              <a href="components-spinners.html">
                <i class="bi bi-circle"></i><span>Spinners</span>
              </a>
            </li>
            <li>
              <a href="components-tooltips.html">
                <i class="bi bi-circle"></i><span>Tooltips</span>
              </a>
            </li>
          </ul>
        </li><!-- End Components Nav -->

        </li><!-- End Produk -->

        <li class="nav-item">
  <a class="nav-link" href="{{ route('admin.suplier.index') }}">
    <i class="bi bi-box2-fill"></i><span>Suplier</span>
  </a>
</li>
        
        <li class="nav-item">
          <a class="nav-link" href="{{ route('admin.mitra.index') }}">
            <i class="bi bi-person-workspace"></i><span>Mitra</span></i>
          </a>
        </li><!-- End Forms Nav -->
  
        <li class="nav-item">
  <a class="nav-link" href="{{ route('admin.datamesin.index') }}">
    <i class="bi bi-gear-fill"></i><span>Mesin</span>
  </a>
</li><!-- End Akun Karyawan Nav -->
  
          </ul>
        </li><!-- End Icons Nav -->

      </ul>
  
    </aside><!-- End Sidebar-->
  