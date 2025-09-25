<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="{{ asset('admin/css/styles.css') }}" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    
    </head>
    <body class="sb-nav-fixed">

        @include('admin.adminlayout.navbar')
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                    @include('admin.adminlayout.sidebar')

            </div>

             <div id="layoutSidenav_content">
                <main class="flex-grow-1 d-flex flex-column admin-background">
                    <div class="container-fluid px-4">
                        @yield('content')
                    </div>
                </main>

                @include('admin.adminlayout.footer')
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="{{ asset('admin/js/scripts.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="{{ asset('admin/js/datatables-simple-demo.js') }}"></script>

    </body>
</html>
<style>
    .admin-background{
        background: #e1e1e1 !important;
    }
     /* Fixed thumbnail size */
    .gallery-thumb {
        width: 120px;
        height: 80px;
        object-fit: cover;
        border: 1px solid #ddd;
        border-radius: 6px;
    }

    /* For preview images */
    .gallery-preview {
        width: 180px;
        height: 120px;
        object-fit: cover;
        border: 1px solid #ccc;
        padding: 3px;
        display: none;
        border-radius: 6px;
    }

/* Pagination container center */
.pagination {
    display: flex;
    justify-content: center;
    gap: 6px;
}

/* Default page link style */
.page-link {
    color: #002244;       /* text color */
    border: 1px solid #002244;
    padding: 6px 12px;
    border-radius: 6px;
    transition: 0.3s;
}

/* Hover effect */
.page-link:hover {
    background-color: #002244;
    color: #fff;
}

/* Active page */
.page-item.active .page-link {
    background-color: rgba(255, 255, 255, 1) !important;
    border-color: #163656 !important;
    color: #163656 !important;
}

/* Disabled (like "Previous" when on page 1) */
.page-item.disabled .page-link {
    color: #aaa;
    background-color: #f8f9fa;
    border-color: #ddd;
}
.page-link, .datatable-pagination a{
    background: #163656 !important;
    color: white !important;
}


    @media(max-width: 576px) {
        .gallery-thumb {
            width: 100px;
            height: 70px;
        }
        .gallery-preview {
            width: 140px;
            height: 100px;
        }
    }


</style>