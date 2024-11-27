<!DOCTYPE html>
<html dir="rtl" lang="ar" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="horizontal">

<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Favicon icon-->
    <link rel="shortcut icon" type="image/png" href="{{assert('assets/images/logos/logo.jpg')}}" />

    <!-- Core Css -->
    <link rel="stylesheet" href="{{asset('assets/css/styles.css')}}" />

    <title>Electron</title>
    <link rel="stylesheet" href="{{asset('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}">
</head>

<body>
<div class="container my-5">
    <div class="row  ">

        <div class="text-center border-bottom py-3">
            <h5 >نموذج الورقي </h5>
        </div>

        <div class="mx-5 py-4 d-block">

            <h5>الإسم :<span>{{$client->name_ar}}</span></h5>
            <h5>الرقم المدني : <span>{{$client->civil_number}}</span></h5>
            <h5>الهاتف :<span>   {{$client->client_phone->last()->phone}} </span></h5>
            <h5>العنوان :<span> قطعة : {{$client->client_address->last()->block}}- شارع :  قطعة : {{$client->client_address->last()->street}}- مبني : {{$client->client_address->last()->building}}-  </span></h5>
            <h5>المديونية :<span>   {{$item->amount}}   د.ك </span></h5>
            <h5>رقم الملف :<span> {{$item->id}}  </span></h5>
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
<script src="{{asset('assets/libs/simplebar/dist/simplebar.min.js')}}"></script>
<script src="{{asset('assets/js/theme/app.horizontal.init.js')}}"></script>
<script src="{{asset('assets/js/theme/theme.js')}}"></script>
<script src="{{asset('assets/js/theme/app.min.js')}}"></script>
<script src="{{asset('assets/js/theme/sidebarmenu.js')}}"></script>
<script src="{{asset('assets/js/theme/feather.min.js')}}}"></script>

<!-- solar icons -->
<script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
<script src="{{asset('assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/js/datatable/datatable.init.js')}}"></script>
</body>

</html>
