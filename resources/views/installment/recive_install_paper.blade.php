<!DOCTYPE html>
<html dir="rtl" lang="ar" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="horizontal">

<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Favicon icon-->
    <link rel="shortcut icon" type="image/png" href="{{asset('assets/images/logos/logo.jpg')}}"/>

    <!-- Core Css -->
    <link rel="stylesheet" href="{{asset('assets/css/styles.css')}}"/>

    <title>Electron</title>
    <link rel="stylesheet" href="{{asset('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}">
</head>

<body>
<div class="container my-5">
    <div class="row  border-bottom">
        <div class="text-center py-3">
            <h5> إيصال استلام أوراق عميل
            </h5>
        </div>
        @php
            \Carbon\Carbon::setlocale("ar");
            $day_name= \Carbon\Carbon::today()->translatedFormat('l');
        @endphp


        <div class="mx-5 py-1 ">

            <h6>التاريخ: <span>
                    {{$day_name}} {{date('Y-m-d')}}</span></h6>

            <h6>إستلمت أنا : <span> {{$rec_name}} </span></h6>
        </div>
    </div>
    <div class="row">
        <div class="col-12 py-2 mx-5 ">
            <p class="text-dark"> الأوراق المطلوبة من العميل </p>
        </div>

        <div class="col-12 border mb-1 py-4 mx-5 d-flex justify-content-between">
            <div class="col-md-6 col-sm-12">
                <p class="text-dark">اسم العميل: {{$client->name_ar}}  </p>
                <p class="text-dark"> رقم الهاتف : {{$client->client_phone->last()->phone}}</p>
                <p class="text-dark"> جهة العمل : وزارة الداخلية</p>
                <p class="text-dark">   {{$item->part_paper_number}} رقم إقرار الدين : </p>
            </div>

            <div class="col-md-6 col-sm-12">
                <p class="text-dark">الرقم المدنى : {{$client->civil_number}}</p>
                <p class="text-dark"> البنك : </p>
                <p class="text-dark">جهة الدخل
                 @if($client->client_ministrey)
                    : {{\App\Models\Ministry::find($client->client_ministrey->first()->ministry_id)->name_ar}}
                    @endif
                <p class="text-dark"> رقم المعاملة : {{$item->id}}</p>
            </div>
        </div>
        <div class="col-12 pt-3 mx-5 ">
            <p class="text-dark"> وآنا مسئول عن صحة تطابقها وهي كالآتي : </p>
        </div>
        <div class=" col-12  mb-1 py-4 mx-4 d-flex ">
            <div class="form-check  form-check-inline">
                <input class="form-check-input" type="checkbox" id="option1" value="option1">
                <label class="form-check-label" for="option1">صورة مدنية
                </label>
            </div>
            <div class=" form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="option2" value="option2">
                <label class="form-check-label" for="option2">شهادة الراتب</label>
            </div>
            <div class="  form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="option3" value="option3">
                <label class="form-check-label" for="option3">كشف حساب</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="option1" value="option1">
                <label class="form-check-label" for="option1">ساينت
                </label>
            </div>

        </div>

        <div class=" col-12  mb-1 py-4 mx-4 d-flex ">

            <div class=" form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="option2" value="option2">
                <label class="form-check-label" for="option2">عقد أقساط </label>
            </div>
            <div class="  form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="option3" value="option3">
                <label class="form-check-label" for="option3"> إستقطاع بنكي</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="option1" value="option1">
                <label class="form-check-label" for="option1">رسوم إستقطاع

                </label>
            </div>
            <div class=" form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="option2" value="option2">
                <label class="form-check-label" for="option2">إقرار دين
                </label>
            </div>
        </div>

        <div class=" col-12  mb-1 py-4 mx-4 d-flex ">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="option1" value="option1">
                <label class="form-check-label" for="option1">إستعلام قضائي </label>
            </div>
            <div class=" form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="option2" value="option2">
                <label class="form-check-label" for="option2">استلام اغراض
                </label>
            </div>
            <div class="  form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="option3" value="option3">
                <label class="form-check-label" for="option3"> إقرار دين كفيل
                </label>
            </div>

        </div>

        <div class="col-12  mb-1 py-4 mx-5 d-flex justify-content-between">
            <div class="col-md-6 col-sm-12">
                <p class="text-dark text-underline fw-bolder">مستلم الأوراق </p>
                <p class="text-dark">............... </p>

            </div>

            <div class="col-md-6 col-sm-12">
                <p class="text-dark text-underline fw-bolder">التوقيع </p>
                <p class="text-dark"> ...............</p>
            </div>

        </div>
        <div class="col-12  mb-1 py-4 mx-5 ">
            <p class="text-dark text-underline fw-bolder">ملاحظات الموظف : </p>
            <p class="text-dark"> ......................................................................................
                ........................................................................................</p>
        </div>

        <div class="col-12  mb-1 py-4 mx-5 d-flex justify-content-between">
            <div class="col-md-6 col-sm-12">
                <p class="text-dark text-underline fw-bolder">المدقق </p>
                <p class="text-dark">............... </p>

            </div>

            <div class="col-md-6 col-sm-12">
                <p class="text-dark text-underline fw-bolder">التوقيع </p>
                <p class="text-dark"> ...............</p>
            </div>

        </div>
        <div class="col-12  mb-1 py-4 mx-5 ">
            <p class="text-dark text-underline fw-bolder">ملاحظات المدقق : </p>
            <p class="text-dark"> ......................................................................................
                ........................................................................................</p>
        </div>
        <div class="col-12  mb-1 py-4 mx-5 ">
            <p class="text-dark text-underline fw-bolder">إعتماد المدير العام : </p>
            <p class="text-dark"> ......................................................</p>
        </div>


        <div class="col-12 mx-5 py-1 d-flex justify-content-between">
            <h6> : {{$rec_name}} </h6>
            <h6> {{date('Y-m-d')}}: التاريخ </h6>
        </div>
    </div>

</div>


<script src="{{asset('assets/js/vendor.min.js')}}"></script>
<!-- Import Js Files -->
<script src="{{asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('ssets/libs/simplebar/dist/simplebar.min.js')}}"></script>
<script src="{{asset('assets/js/theme/app.horizontal.init.js')}}"></script>
<script src="{{asset('assets/js/theme/theme.js')}}"></script>
<script src="{{asset('assets/js/theme/app.min.js')}}"></script>
<script src="{{asset('assets/js/theme/sidebarmenu.js')}}"></script>
<script src="{{asset('assets/js/theme/feather.min.js')}}"></script>

<!-- solar icons -->
<script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
<script src="{{asset('assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/js/datatable/datatable.init.js')}}"></script>
</body>

</html>
