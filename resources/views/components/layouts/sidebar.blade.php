<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}" href="{{ url('/dashboard') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-heading">Pages</li>

        <li class="nav-item">
            <a class="nav-link  {{ Request::is(['petugas', 'siswa*', 'kelas']) ? 'active' : 'collapsed' }}"
                data-bs-target="#master-data" data-bs-toggle="collapse" href="#">
                <i class="bi bi-menu-button-wide"></i><span>Master Data</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="master-data" class="nav-content collapse {{ Request::is(['jabatan*', 'karyawan*']) ? 'show' : '' }}"
                data-bs-parent="#sidebar-nav">

                <li>
                    <a href="{{ url('jabatan') }}" class="{{ Request::is('jabatan') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Data Jabatan</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('karyawan') }}" class="{{ Request::is('karyawan*') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Data Karyawan</span>
                    </a>
                </li>
            </ul>

        </li><!-- End Master Data -->

        <li class="nav-item">
            <a class="nav-link collapsed {{ Request::is('absensi*') ? 'active' : '' }}" href="{{ url('absensi') }}">
                <i class="bi bi-book"></i>
                <span>Absensi</span>
            </a>
        </li>

        <li class="nav-heading">Setting</li>

        <li class="nav-item">
            <a class="nav-link collapsed {{ Request::is('profile') ? 'active' : '' }}" href="{{ url('profile') }}">
                <i class="bi bi-person"></i>
                <span>Profile</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ url('/logout') }}" onclick="confirmLogout(event)">
                <i class="bi bi-box-arrow-in-right"></i>
                <span>Sign Out</span>
            </a>
        </li>

    </ul>

</aside><!-- End Sidebar-->