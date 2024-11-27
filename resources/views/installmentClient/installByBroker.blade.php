<!DOCTYPE html>
<html dir="rtl" lang="ar" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="horizontal">

<head>
  <!-- Required meta tags -->
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Favicon icon-->
  <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/logo.jpg')}}" />

  <!-- Core Css -->
  <link rel="stylesheet" href="{{ asset('assets/css/styles.css')}}" />

  <title>Electron</title>
  <link rel="stylesheet" href="{{ asset('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}">
</head>

<body>
  <main class="container pb-5">
    <div class="text-center mb-5 bg-info ">
      <h2 class="mt-5 font-weight-medium text-white py-2">البيانات المطلوبة</h2>
    </div>
 

    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
              <img class="logo-data" src="{{ asset('assets/images/logos/logo.jpg')}}" height="120"  alt="Logo">
              <div class="d-flex">
                <button class="btn btn-primary text-white mx-1">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="height:15px;" class="mx-1">
                    <path fill="white" d="M164.9 24.6c-7.7-18.6-28-28.5-47.4-23.2l-88 24C12.1 30.2 0 46 0 64C0 311.4 200.6 512 448 512c18 0 33.8-12.1 38.6-29.5l24-88c5.3-19.4-4.6-39.7-23.2-47.4l-96-40c-16.3-6.8-35.2-2.1-46.3 11.6L304.7 368C234.3 334.7 177.3 277.7 144 207.3L193.3 167c13.7-11.2 18.4-30 11.6-46.3l-40-96z"/></svg>
                    اتصل بنا 
                </button>
                <button class="btn btn-success text-white mx-1">
                  <i class="ti ti-message-2 fs-5"></i>    المراسلة بالواتس اب    
                </button>
              </div>
            </div>
            @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif
            <form action="{{ route('installmentClient.store') }}" method="POST"
            enctype="multipart/form-data">
            @csrf

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="name" class="form-label">الاسم</label>
                  <input type="text" class="form-control"  id="name_ar" name="name_ar"  placeholder="ادخل الاسم">
                  @error('name_ar')
                  <div class="alert alert-danger">{{ $message }}</div>
              @enderror
                  <input type="text" class="form-control" id="broker_id" name="boker_id" value="{{$data->id}}" style="display:none;">
                
                </div>
                <div class="col-md-6 mb-3">
                  <label for="idNumber" class="form-label">الرقم المدني (ارقام انجليزية)</label>
                  <input type="text" class="form-control" id="civil_number" name="civil_number"  placeholder="ادخل الرقم المدني">
                  @error('civil_number')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                </div>
                <div class="col-md-6 mb-3">
                  <label for="phone" class="form-label">الهاتف (ارقام انجليزية)</label>
                  <input type="text" class="form-control"  name="phone"  id="phone" placeholder="الهاتف">
                  @error('phone')
                  <div class="alert alert-danger">{{ $message }}</div>
              @enderror
                </div>
                <div class="col-md-6 mb-3">
                  <label for="salary" class="form-label">الراتب</label>
                  <input type="text" class="form-control" id="salary"  name="salary"   placeholder="ادخل الراتب">
                  @error('salary')
                  <div class="alert alert-danger">{{ $message }}</div>
              @enderror
                </div>
                <div class="col-md-6 mb-3">
                  <label for="job" class="form-label">الوظيفة - جهه الدخل</label>
                  <select class="form-select" id="work" name="ministry_id">
                    @foreach ($ministry as $item)
                                                        <option value="{{ $item->id }}">{{ $item->name_ar }}</option>
                                                    @endforeach
                </select>
                @error('ministry_id')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
                </div>
               
                <div class="col-md-6 mb-3">
                  <label for="bank" class="form-label">اختار البنك</label>
                  <select class="form-select" id="bank" name="bank_id">
                    @foreach ($bank as $item)
                                                          <option value="{{ $item->id }}">{{ $item->name_ar }}</option>
                                                      @endforeach
                  </select>
                  @error('bank_id')
                  <div class="alert alert-danger">{{ $message }}</div>
              @enderror
                </div>
                <div class="col-md-6 mb-3">
                  <label for="province" class="form-label">اختار المحافظة</label>
                  <select class="form-select" name="governorate_id">
                    @foreach ($government as $item)
                                                         <option value="{{ $item->id }}">{{ $item->name_ar }}</option>
                                                     @endforeach
                 </select>
                 @error('governorate_id')
                 <div class="alert alert-danger">{{ $message }}</div>
             @enderror
                </div>
                <div class="col-6 mb-3">
                  <label for="area" class="form-label">اختار المنطقة</label>
                  <select class="form-select"  name="area_id">
                    @foreach ($region as $item)
                                                         <option value="{{ $item->id }}">{{ $item->name_ar }}</option>
                                                     @endforeach
                 </select>
                 @error('area_id')
                 <div class="alert alert-danger">{{ $message }}</div>
             @enderror
                </div>
                <div class="col-6 mb-3">

                      <label class="form-label"> مجموع الاقساط </label>
                      <input type="text" name="installment_total"  class="form-control" />
                   
                  </div>
              </div>
              <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">تقديم</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </main>
  
  <script src="{{ asset('assets/js/vendor.min.js')}}"></script>
  <!-- Import Js Files -->
  <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{ asset('assets/libs/simplebar/dist/simplebar.min.js')}}"></script>
  <script src="{{ asset('assets/js/theme/app.horizontal.init.js')}}"></script>
  <script src="{{ asset('assets/js/theme/theme.js')}}"></script>
  <script src="{{ asset('assets/js/theme/app.min.js')}}"></script>
  <script src="{{ asset('assets/js/theme/sidebarmenu.js')}}"></script>
  <script src="{{ asset('assets/js/theme/feather.min.js')}}"></script>

  <!-- solar icons -->
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js')}}"></script>
  <script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
  <script src="{{ asset('assets/js/datatable/datatable.init.js')}}"></script>
</body>

</html>