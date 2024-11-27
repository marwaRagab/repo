<!DOCTYPE html>
<html dir="rtl" lang="ar" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="horizontal">

<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Favicon icon-->
    <link rel="shortcut icon" type="image/png" href="{{asset('assets/images/logos/logo.jpg')}}" />

    <!-- Core Css -->
    <link rel="stylesheet" href="{{asset('assets/css/styles.css')}}" />

    <title>Electron</title>
    <link rel="stylesheet" href="{{asset('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}">
</head>
<style>
    .print{
        justify-content: center;
        display: flex;
        flex-direction: column;
        width: 100%;
    }
    .print .print-text{
        margin-block: 1.5rem;
    }
</style>
<body>
<div class="container-fluid print py-5">
    <h5 class="print-text">السيد / مدير إدارة التوثيقات</h5>
    <h5 class="print-text">المحترم</h5>
    <div class="text-center py-5">
        <h3>الموضوع : إقرار دين
        </h3>
    </div>
    <div class="content">
        <h5 class="print-text">التاريخ : مقدمة لسيادتكم من / شركه الكترون للاجهزه الالكترونيه بترخيص رقم 2022/187 وسجل تجاري رقم (367154).</h5>
        <h5 class="print-text">التاريخ : أنه لا مانع لدينا من أن يقوم السيد /
        {{ $data["client"]->name_ar}}</h5>
        <h5 class="print-text"> بعمل إقرار دين لصالح الشركة بمبلغ ( {{numberToArabicWords($data["amount"])}} د.ك )</h5>
        <h5 class="print-text">( دينار كويتي فقط لا غير )</h5>

    </div>
    <div class="text-center py-3">
        <h5 class="print-text">
            وتفضلوا بقبول فائق الاحترام ؛؛؛
        </h5>
    </div>
    <div class="d-flex justify-content-end">
        <h5 class="print-text">التوقيع</h5>
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
<script src="{{asset('assets/js/theme/feather.min.js')}}"></script>

<!-- solar icons -->
<script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
<script src="{{asset('assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/js/datatable/datatable.init.js')}}"></script>
</body>

</html>
