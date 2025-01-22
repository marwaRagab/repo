<header class="topbar sticky-top px-3">
    <div class="with-vertical"><!-- ---------------------------------- -->
        <!-- Start Vertical Layout Header -->
        <!-- ---------------------------------- -->
        <nav class="navbar navbar-expand-lg p-0 justify-content-between">
            <ul class="navbar-nav">
                <li class="nav-item nav-icon-hover-bg rounded-circle">
                    <button class="border-0 bg-transparent d-flex align-items-center justify-content-center "
                        type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample"
                        aria-controls="offcanvasExample">
                        <iconify-icon icon="solar:list-bold-duotone" class="fs-7"></iconify-icon>
                    </button>
                </li>
            </ul>

            <div class="d-block d-xl-none">
                <img src="{{ asset('assets/images/logos/logo.jpg') }}" class="logo" alt="Logo-Dark" />
            </div>

    </div>
    <div class="app-header with-horizontal">
        <nav class="navbar navbar-expand-xl px-5">
            <ul class="navbar-nav">
                <li class="nav-item d-none d-xl-block">
                    <a href="#" class="text-nowrap logo-img">
                        <img src="{{ asset('assets/images/logos/logo.jpg') }}" class="logo" alt="Logo" />
                    </a>
                </li>
            </ul>
            <a class="navbar-toggler p-0 border-0" href="javascript:void(0)" data-bs-toggle="collapse"
                data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="p-2">
                    <i class="ti ti-dots fs-7"></i>
                </span>
            </a>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <div class="d-flex align-items-center justify-content-between">
                    <a href="javascript:void(0)"
                        class="nav-link d-flex d-lg-none align-items-center justify-content-center" type="button"
                        data-bs-toggle="offcanvas" data-bs-target="#mobilenavbar"
                        aria-controls="offcanvasWithBothOptions">
                        <div class="nav-icon-hover-bg rounded-circle ">
                            <i class="ti ti-align-justified fs-7"></i>
                        </div>
                    </a>
                    <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-center">

                        <!-- ------------------------------- -->
                        <!-- search-->
                        <!-- ------------------------------- -->
                        <li class="nav-item dropdown d-none d-lg-block">
                            <a class="nav-link position-relative shadow-none" href="javascript:void(0)" id="drop3"
                                aria-expanded="false">
                                <form class="nav-link position-relative shadow-none">
                                    <input type="text" class="form-control rounded-3 py-2 ps-5 text-dark"
                                        placeholder="ابحث هنا ...">
                                    <iconify-icon icon="solar:magnifer-linear"
                                        class="text-dark position-absolute top-50 start-0 translate-middle-y text-dark ms-3"></iconify-icon>
                                </form>
                            </a>
                        </li>
                        @php
                        $count = App\Models\Notification::where('user_id', Auth::id())
                        ->where('show', 0)
                        ->whereDate('created_at', today())
                        ->count();

                        @endphp
                        <li class="nav-item dropdown">
                            <a class="nav-link position-relative" href="javascript:void(0)" id="drop2"
                                aria-expanded="false">
                                <i class="ti ti-bell fs-7"></i>
                                <span
                                    class="position-absolute top-25 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ $count }}
                                    <span class="visually-hidden">un read</span>
                                </span>
                            </a>
                            <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up"
                                aria-labelledby="drop2">
                                <!--  Search Bar -->

                                <div class="modal-header border-bottom p-3">
                                    <h5 class="mb-0 fs-5 p-1">الإشعارات</h5>

                                </div>
                                @php

                                $lastThreeRows = App\Models\Notification::orderBy('created_at', 'desc')
                                ->where('user_id', Auth::id())
                                ->where('show', 0)
                               
                                ->get();

                                @endphp
                                <div class="message-body p-3" data-simplebar="">
                                    <ul class="list text-end mb-0 py-2">

                                        @foreach ($lastThreeRows as $one_br)
                                            <li class="p-1 mb-1 bg-hover-light-black rounded border-bottom p-3">
                                                <a href="{{ route('supportProblem.show', $one_br->problem_id) }}">
                                                <span class="fs-3 text-dark d-block ">{{ $one_br->title }}</span>
                                                <span class=" text-muted d-block border-bottom p-3">
                                                    {{ \Carbon\Carbon::parse($one_br->created_at)->locale('ar')->translatedFormat('l j F Y h:i A') }}

                                                </span>
                                                </a>

                                            </li>
                                        @endforeach

                                        <li class="p-1 mb-1 bg-hover-light-black rounded">

                                            <a href="{{ route('notificatoin.index') }}">
                                                عرض الكل
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>

                        <!-- ------------------------------- -->
                        <!-- start profile Dropdown -->
                        <!-- ------------------------------- -->
                        <li class="nav-item dropdown">
                            <a class="nav-link position-relative ms-6" href="javascript:void(0)" id="drop1"
                                aria-expanded="false">
                                <div class="d-flex align-items-center flex-shrink-0">
                                    <div class="user-profile me-sm-3 me-2">
                                        <img src="{{ asset('user_profile/' . (Auth::user()->img ?? 'default.jpg')) }}" width="40"
                                            class="rounded-circle" alt="spike-img">



                                    </div>
                                    <span class="d-sm-none d-block"><iconify-icon
                                            icon="solar:alt-arrow-down-line-duotone"></iconify-icon></span>

                                    <div class="d-none d-sm-block">
                                        <h6 class=" mb-1 profile-name">
                                            {{ Auth::user()->name_ar ?? 'Default Name' }}
                                        </h6>
                                        <p class=" lh-base mb-0 profile-subtext">
                                            {{ Auth::user()?->roles?->name_ar ?? '' }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up"
                                aria-labelledby="drop1">
                                <div class="profile-dropdown position-relative" data-simplebar>

                                    <div class="py-6 px-7 mb-1">
                                        <!-- <a href="../horizontal/authentication-login.html" class="btn btn-primary w-100">Log
                      Out</a> -->
                                        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-primary w-100">تسجيل الخروج</button>
                                        </form>
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