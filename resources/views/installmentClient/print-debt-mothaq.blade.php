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
    .print {
        justify-content: center;
        display: flex;
        flex-direction: column;
        width: 100%;
    }

    .print .print-text {
        margin-block: 1.5rem;
    }
</style>

<body>
<div class="container-fluid print py-5">
    <div class="d-flex justify-content-around align-items-center">
        <h5 class="print-text">السيد / الموثق </h5>
        <h5 class="print-text">المحترم</h5>
    </div>
    <div class="text-center py-5">
        <h3>تحية طيبة وبعد
        </h3>
    </div>
    <div class="content">
        <h5 class="print-text">الرجاء التأكد من اسم الشركة لوجود أخطاء كثيرة في عدد من الاقرارات السابقة وكتابة الاسم كامل بنفس الصيغة
            المكتوبة بين قوسين.</h5>
        <h5 class="print-text"> لسيادتكم جزيل الشكر ،،،،،،،، </h5>
        <h5 class="print-text"> وأقر بموجب هذا بأنه مدين الى/ </h5>
        <h2>( شركة الكترون للاجهزة الالكترونية)</h2>
        <h5 class="print-text">بمبلغ وقدره (   {{$data["amount"]}} د.ك ) فقط لا غير - قرضا حسنا - وتعهد بسداد كامل المبلغ دفعة واحدة عند الطلب وذلك
            بدون مماطلة أو تاخير ، وطلب الحاضر تذييل هذا الإقرار بالصيغة التنفيذية.</h5>
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
<script src="{{asset('assets/js/theme/sidebarmenu.js')}}"></script>
<script src="{{asset('assets/js/theme/feather.min.js')}}"></script>

<!-- solar icons -->
<script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
<script src="{{asset('assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/js/datatable/datatable.init.js')}}"></script>
</body>

</html>
