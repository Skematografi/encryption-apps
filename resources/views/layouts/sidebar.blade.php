
<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-hourglass"></i>
        </div>
        <div class="sidebar-brand-text mx-3">R.R.S</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ Request::segment(1) === 'home' ? 'active' : null }}">
        <a class="nav-link" href="/home">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Menu
    </div>

    <!-- Nav Item - Tables -->
    @hasanyrole('leader|ppic')
    <li class="nav-item {{ Request::segment(1) === 'supplier' ? 'active' : null }}">
        <a class="nav-link" href="/supplier">
            <i class="fas fa-fw fa-users"></i>
            <span>Supplier</span></a>
    </li>
    <li class="nav-item {{ Request::segment(1) === 'product' ? 'active' : null }}">
        <a class="nav-link" href="/product">
            <i class="fas fa-fw fa-table"></i>
            <span>Produk</span></a>
    </li>
    <li class="nav-item {{ Request::segment(1) === 'out_standing_po' ? 'active' : null }}">
        <a class="nav-link" href="/out_standing_po">
            <i class="fas fa-fw fa-folder"></i>
            <span>Out Standing PO</span></a>
    </li>
    @endhasanyrole

    @hasanyrole('leader|admin_qc')
        <li class="nav-item {{ Request::segment(1) === 'return_pmr' ? 'active' : null }}">
            <a class="nav-link" href="/return_pmr">
                <i class="fas fa-fw fa-edit"></i>
                <span>Return PM R1</span></a>
        </li>
        <li class="nav-item {{ Request::segment(1) === 'report' ? 'active' : null }}">
            <a class="nav-link" href="/report">
                <i class="fas fa-fw fa-file"></i>
                <span>Laporan</span></a>
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
