<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-key"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Encrypt Decrypt</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Nav Item - Tables -->
    @hasanyrole('leader|superadmin')
        <li class="nav-item {{ Request::segment(1) === 'home' ? 'active' : null }}">
            <a class="nav-link" href="/home">
                <i class="fas fa-fw fa-archive"></i>
                <span>Master</span></a>
        </li>
        <li class="nav-item {{ in_array(Request::segment(1), ['users', 'roles']) ? 'active' : null }}">
            <a class="nav-link {{ in_array(Request::segment(1), ['users', 'roles']) ? null : 'collapsed' }}" href="#"
                data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-cog"></i>
                <span>Pengaturan</span>
            </a>
            <div id="collapseTwo" class="collapse {{ in_array(Request::segment(1), ['users', 'roles']) ? 'show' : null }}"
                aria-labelledby="headingTwo" data-parent="#accordionSidebar" style="">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item {{ Request::segment(1) === 'users' ? 'active' : null }}" href="/users"><i
                            class="fas fa-fw fa-users"></i> Users</a>
                    <a class="collapse-item {{ Request::segment(1) === 'roles' ? 'active' : null }}" href="/roles"><i
                            class="fas fa-fw fa-user-tag"></i> Roles</a>
                </div>
            </div>
        </li>
    @endhasanyrole

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
