@include('includes/head')

<body>
    {{-- <!-- Preloader -->
    <div class="preloader">
        <img src="{{ asset('assets/images/logos/logo.jpg') }}" alt="loader" class="load-img" />
        <img src="{{ asset('assets/images/Spinner@1x-1.4s-200px-200px.svg') }}" alt="loader" class="load-svg" />
    </div> --}}
    <div id="main-wrapper">
        <div class="page-wrapper">
            @include('includes.sidebar_horizontal')
            <div class="body-wrapper mt-3">
                <div class="p-sm-5 p-4 mt-5">
                    <!--  Header Start -->
                    @include('includes/header')
                    <!--  Header End -->
                    @include('includes/crumb')
                    @if (session()->has('message'))
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div>
                    @endif
                    @if (session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session()->get('error') }}
                    </div>
                @endif
                    <!--  Content Start -->
                    @include($view)
                    <!--  Content End -->

                </div>
            </div>
        </div>
    </div>

    @include('includes/footer')
