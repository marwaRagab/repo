<!DOCTYPE html>
<html dir="rtl" lang="ar" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="horizontal">

@include('ClientDashboard.partials.head')
<body>

    <div id="main-wrapper">
        <div class="page-wrapper">
         @include('ClientDashboard.partials.hori_sidebar')
            <!-- mobile sidebar -->
           @include('ClientDashboard.partials.mobile_sidebar')
            <div class="body-wrapper">
                <div class="container-fluid">
                    <!--  Header Start -->
                  @include('ClientDashboard.partials.header')
                  @include('ClientDashboard.partials.crumb')
                    <!--  Header End -->
                    <main>
                        @yield('content')
                    </main>

                </div>
            </div>
        </div>

    </div>

@include('ClientDashboard.partials.footer')
</body>

</html>
