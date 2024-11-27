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
<div class="container my-5">
    <div class="row">

        <div class="col-12  text-center py-3">

            <h5 > تصدير الاقساط فرع الرئيسي</h5>
            @php
             $branch_id= \Illuminate\Support\Facades\Auth::user()->branch_id;
             $branch_name=\App\Models\Branch::findorfail($branch_id)->name_ar;
             \Carbon\Carbon::setlocale("ar");
             $day_name= \Carbon\Carbon::today()->translatedFormat('l');
           @endphp
            {{Carbon::createFromFormat('Y-m-d', $date)->locale('fr_FR')->dayName
}}

             {{$branch_name}}

        </div>

        <div class="col-12 py-2 mx-5 ">
            <table class="table table-bordered">

                <tbody>
                <tr>
                    <th>التاريخ</th>
                    <td>{{date('Y-m-d')}}
                        <p>{{$day_name}}</p>
                    </td>
                    <th>   مجموع الايرادات  </th>
                    <td>{{number_format($amount_knet+$amount_cash+$amount_bank, 3, '.', ',')}} </td>
                    <th>تصدير الكاش  </th>
                    <td>{{number_format($amount_cash, 3, '.', ',') }} </td>
                </tr>

                <tr>
                    <th>تصدير الروابط</th>
                    <td>{{ number_format($amount_bank, 3, '.', ',') }} </td>
                    <th>تصدير الكي نت</th>
                    <td>{{number_format($amount_knet, 3, '.', ',')}}</td>
                    <th>مجموع التصدير</th>
                    <td>{{ number_format($amount_knet+$amount_cash+$amount_bank, 3, '.', ',')}} </td>
                </tr>

                </tbody>
            </table>
        </div>
        <div class="col-12 mx-5 py-1 d-flex justify-content-between">
            <h6> توقيع الكاشير </h6>
            <h6> توقيع المدير المالي</h6>

        </div>

        <div class="col-12 mx-5 py-5 mt-5 d-flex justify-content-between">

            <h6> توقيع المستلم</h6>

        </div>




    </div>

</div>


<script src="{{ asset('assets/js/vendor.min.js')}}"></script>

<!-- Import Js Files -->
<script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{ asset('assets/libs/simplebar/dist/simplebar.min.js')}}"></script>
<script src="{{ asset('assets/js/theme/app.horizontal.init.js')}}"></script>
<script src="{{ asset('assets/js/theme/theme.js')}}"></script>
<script src="{{ asset('assets/js/theme/app.min.js')}}"></script>
<script src="{{ asset('assets/js/theme/sidebarmenu.js')}}"></script>
<script src="{{ asset('assets/js/theme/feather.min.js')}}"></script>

<script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>

<script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('assets/js/datatable/datatable.init.js')}}"></script>



<!-- solar icons -->

</body>

</html>
