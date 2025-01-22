<header class="topbar sticky-top">
    <div class="with-vertical">
        <!-- ---------------------------------- -->
        <!-- Start Vertical Layout Header -->
        <!-- ---------------------------------- -->
        <nav class="navbar navbar-expand-lg p-0 justify-content-between">
            <ul class="navbar-nav">
                <li class="nav-item nav-icon-hover-bg rounded-circle">
                    <button
                        class="border-0 bg-transparent d-flex align-items-center justify-content-center "
                        type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample"
                        aria-controls="offcanvasExample">
                        <iconify-icon icon="solar:list-bold-duotone" class="fs-7"></iconify-icon>
                    </button>
                </li>
            </ul>

            <div class="d-block d-xl-none">
                <img src="{{asset('client_assets')}}/images/logos/logo.jpg" class="logo" alt="Logo-Dark" />
            </div>

    </div>
    <div class="app-header with-horizontal">
        <nav class="navbar navbar-expand-xl container-fluid p-0">
            <ul class="navbar-nav">
                <li class="nav-item d-none d-xl-block">
                    <a href="../index.html" class="text-nowrap logo-img">
                        <img src="{{asset('client_assets')}}/images/logos/logo.jpg" class="logo"
                            alt="Logo" />
                    </a>
                </li>
            </ul>
            <a class="navbar-toggler p-0 border-0" href="javascript:void(0)"
                data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="p-2">
                    <i class="ti ti-dots fs-7"></i>
                </span>
            </a>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <div class="d-flex align-items-center justify-content-between">
                    <a href="javascript:void(0)"
                        class="nav-link d-flex d-lg-none align-items-center justify-content-center"
                        type="button" data-bs-toggle="offcanvas" data-bs-target="#mobilenavbar"
                        aria-controls="offcanvasWithBothOptions">
                        <div class="nav-icon-hover-bg rounded-circle ">
                            <i class="ti ti-align-justified fs-7"></i>
                        </div>
                    </a>
                    <ul
                        class="navbar-nav flex-row ms-auto align-items-center justify-content-center">
                        <li
                            class="nav-item dropdown nav-icon-hover-bg rounded-circle d-flex d-lg-none">
                            <a class="nav-link position-relative" href="javascript:void(0)"
                                id="drop3" aria-expanded="false">
                                <iconify-icon icon="solar:magnifer-linear" class="fs-7 text-dark">
                                </iconify-icon>
                            </a>
                        </li>
                        <!-- ------------------------------- -->
                        <!-- start language Dropdown -->
                        <!-- ------------------------------- -->
                        <li class="nav-item dropdown d-none d-lg-block">
                            <a class="nav-link position-relative shadow-none"
                                href="javascript:void(0)" id="drop3" aria-expanded="false">
                                <form class="nav-link position-relative shadow-none">
                                    <input type="text"
                                        class="form-control rounded-3 py-2 ps-5 text-dark"
                                        placeholder="ابحث هنا ...">
                                    <iconify-icon icon="solar:magnifer-linear"
                                        class="text-dark position-absolute top-50 start-0 translate-middle-y text-dark ms-3">
                                    </iconify-icon>
                                </form>
                            </a>
                        </li>


                        <!-- ------------------------------- -->
                        <!-- start profile Dropdown -->
                        <!-- ------------------------------- -->
                        <li class="nav-item dropdown">
                            <a class="nav-link position-relative ms-6" href="javascript:void(0)"
                                id="drop1" aria-expanded="false">
                                <div class="d-flex align-items-center flex-shrink-0">
                                    <div class="user-profile me-sm-3 me-2">
                                        <img src="{{asset('client_assets')}}/images/profile/user-1.jpg"
                                            width="40" class="rounded-circle" alt="spike-img">
                                    </div>
                                    <span class="d-sm-none d-block">
                                        <iconify-icon icon="solar:alt-arrow-down-line-duotone">
                                        </iconify-icon>
                                    </span>

                                    <div class="d-none d-sm-block">
                                        <h6 class="fs-4 mb-1 profile-name">
                                            Mike Nielsen
                                        </h6>
                                        <p class="fs-3 lh-base mb-0 profile-subtext">
                                            Admin
                                        </p>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up"
                                aria-labelledby="drop1">
                                <div class="profile-dropdown position-relative" data-simplebar>
                                    <div class="py-6 px-7 mb-1">
                                        <a href="../horizontal/authentication-login.html"
                                            class="btn btn-primary w-100">Log
                                            Out</a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <!-- ------------------------------- -->
                        <!-- end profile Dropdown -->
                        <!-- ------------------------------- -->
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</header>
