<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
  <!-- Required meta tags -->
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Favicon icon-->
  <link rel="shortcut icon" type="image/png" href="{{asset('assets/')}}/images/logos/favicon.png" />

  <!-- Core Css -->
  <link rel="stylesheet" href="{{asset('assets/')}}/css/styles.css" />

  <title>الكترون</title>
</head>

<body>

  <div id="main-wrapper" class="p-0 bg-white auth-customizer-none">
    <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
      <div class="auth-login-shape-box position-relative">
        <div class="d-flex align-items-center justify-content-center w-100 z-1 position-relative">
          <div class="card auth-card mb-0 mx-3">
            <div class="card-body">
              <a  class="text-nowrap logo-img text-center d-flex align-items-center justify-content-center mb-1 w-100">
                <img src="{{asset('assets/')}}/images/logos/logo.jpg" class="dark-logo" alt="Logo-light" height="100"/>
              </a>

                                 @if ($errors->has('error'))
                                <div class="alert alert-danger">
                                    {{ $errors->first('error') }}
                                </div>
                                @endif
              <form action="{{ route('client.login') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label">الرقم المدني</label>
                  <input type="text" class="form-control" name='civil_number' id="exampleInputtext" aria-describedby="textHelp">
                </div>
                <div class="mb-4">
                  <label for="exampleInputPassword1" class="form-label">الرقم السري</label>
                  <input  type="password" name="password" class="form-control" id="exampleInputPassword1">
                </div>

                 <button type="submit" class="btn btn-primary w-100 mb-4 rounded-pill"> تسجيل
                                        الدخول</button>
              </form>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
  <!-- Import Js Files -->
  <script src="{{asset('assets/')}}/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{asset('assets/')}}/libs/simplebar/dist/simplebar.min.js"></script>
  <script src="{{asset('assets/')}}/js/theme/app.init.js"></script>
  <script src="{{asset('assets/')}}/js/theme/theme.js"></script>
  <script src="{{asset('assets/')}}/js/theme/app.min.js"></script>
  <script src="{{asset('assets/')}}/js/theme/feather.min.js"></script>

  <!-- solar icons -->
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
</body>

</html>
