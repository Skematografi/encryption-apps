<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar" style="font-size:15px;">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/dashboard">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-key"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Encrypt Decrypt</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <li class="nav-item {{ Request::segment(1) === 'dashboard' ? 'active' : null }}">
        <a class="nav-link" href="/dashboard">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        Menu
    </div>

    <!-- Nav Item - Tables -->
    @php
        $storages = isset($access_controls['Storages']) ? ($access_controls['Storages']['is_view'] ? true : false) : false;
        $users = isset($access_controls['User']) ? ($access_controls['User']['is_view'] ? true : false) : false;
        $roles = isset($access_controls['Roles']) ? ($access_controls['Roles']['is_view'] ? true : false) : false;
    @endphp

    @if ($storages)
        <li class="nav-item {{ Request::segment(1) === 'storages' ? 'active' : null }}">
            <a class="nav-link" href="/storages">
                <i class="fas fa-fw fa-cloud"></i>
                <span>Storage</span></a>
        </li>
    @endif
    @if ($users || $roles)
        <li class="nav-item {{ in_array(Request::segment(1), ['users', 'roles']) ? 'active' : null }}">
            <a class="nav-link {{ in_array(Request::segment(1), ['users', 'roles']) ? null : 'collapsed' }}" href="#"
                data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-wrench"></i>
                <span>Settings</span>
            </a>
            <div id="collapseTwo" class="collapse {{ in_array(Request::segment(1), ['users', 'roles']) ? 'show' : null }}"
                aria-labelledby="headingTwo" data-parent="#accordionSidebar" style="">
                <div class="bg-white py-2 collapse-inner rounded">
                    @if ($users)
                        <a class="collapse-item {{ Request::segment(1) === 'users' ? 'active' : null }}" href="/users"><i
                                class="fas fa-fw fa-users"></i> Users</a>
                    @endif
                    @if ($roles)
                        <a class="collapse-item {{ Request::segment(1) === 'roles' ? 'active' : null }}" href="/roles"><i
                                class="fas fa-fw fa-tag"></i> Roles</a>
                    @endif
                </div>
            </div>
        </li>
    @endif

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
