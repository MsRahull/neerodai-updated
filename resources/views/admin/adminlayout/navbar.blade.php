<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark custom-header">
    <a class="navbar-brand ps-3" href="{{ url('admin/dashboard') }}">Neerodai Admin</a>
    
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" 
            id="sidebarToggle" href="#!">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Spacer pushes content to right -->
    <div class="ms-auto me-3 d-flex align-items-center">
        <form method="POST" action="{{ url('admin/logout') }}">
            @csrf
            <button type="submit" class="btn btn-danger btn-sm">Logout</button>
        </form>
    </div>
</nav>
<style>
    .custom-header {
    background-color: #002244 !important;
}
.sb-sidenav-dark{
    background-color: #163656 !important;
}
.sb-sidenav-dark .sb-sidenav-menu .nav-link{
    color: #ffffffff !important;
}
.sb-sidenav-dark .sb-sidenav-menu .sb-sidenav-menu-heading{
        color: #ffffffff !important;

}
.sb-sidenav-dark .sb-sidenav-menu .nav-link .sb-nav-link-icon{
            color: #ffffffff !important;

}
.sb-sidenav-dark .sb-sidenav-menu .nav-link .sb-sidenav-collapse-arrow{
                color: #ffffffff !important;

}
.sb-sidenav-dark .sb-sidenav-footer{
                    background-color: #002244 !important;
                    

}
.btn-danger{
    color: #163656 !important;
    border: 1px solid #163656 !important;
    background-color: white !important;
}
.sb-topnav.navbar-dark #sidebarToggle{
    color: white !important;
}
</style>