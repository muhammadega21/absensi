<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link collapsed{{ Request::is('dashboard') ? 'active' : '' }}" href="{{ url('/dashboard') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="nav-heading">Pages</li>

        <li class="nav-item">
            <a class="nav-link  {{ Request::is(['unit_kerja', 'karyawan']) ? 'active' : 'collapsed' }}"
                data-bs-target="#master-data" data-bs-toggle="collapse" href="#">
                <i class="bi bi-menu-button-wide"></i><span>Master Data</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="master-data"
                class="nav-content collapse {{ Request::is(['unit_kerja*', 'karyawan*']) ? 'show' : '' }}"
                data-bs-parent="#sidebar-nav">

                <li>
                    <a href="{{ url('unit_kerja') }}" class="{{ Request::is('unit_kerja') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Data Unit Kerja</span>
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
            <a class="nav-link collapsed{{ Request::is('absen') ? 'active' : '' }}" href="{{ url('/absen') }}">
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
