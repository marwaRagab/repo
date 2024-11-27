<!DOCTYPE html>
<html dir="rtl" lang="ar" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="horizontal">

<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <!-- Favicon icon-->
    <link rel="shortcut icon" type="image/png" href="{{asset('assets/images/logos/logo.jpg')}}"/>

    <!-- Core Css -->
    <link rel="stylesheet" href="{{asset('assets/css/styles.css')}}"/>

    <title>Electron</title>
    <link rel="stylesheet" href="{{asset('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}">
</head>

<body>
<div class="container my-5">
    <div class="border-bottom">
        <div class="text-center py-2">
            <h4 class="text-underline"> إنذار نهائي بالسداد </h4>
        </div>
        @php
            \Carbon\Carbon::setlocale("ar");
            $day_name= \Carbon\Carbon::today()->translatedFormat('l');
        @endphp


        <div class="mx-5 mb-2 d-md-flex d-sm-block justify-content-between">

            <h6>الكويت في : <span>
                        {{$day_name}} {{date('Y-m-d')}}</span></h6>

            <h6>:الرقم المدني <span>{{$client->civil_number}}</span></h6>
        </div>
        <div class="mx-5 mb-2 d-md-flex d-sm-block justify-content-between">

            <h6> الاســـــــــــم : <span>
                    {{$client->name_ar}}</span></h6>

            <h6>الرقم الآلي :<span>{{$client->house_id}}</span></h6>
        </div>
        <div class="mx-5 mb-2 d-md-flex d-sm-block justify-content-between">

            <h6>العنــــــــوان : <span>
                    - قطعة :                     {{\App\Models\Prev_cols_clients::where('client_id','=',$client->id)->first()->block}}   </span></h6>
            - شارع : {{\App\Models\Prev_cols_clients::where('client_id','=',$client->id)->first()->street}} -

            <h6>العمــــــــــل : <span>{{\App\Models\Prev_cols_clients::where('client_id','=',$client->id)->first()->work_place}}</span></h6>
        </div>
        <div class="mx-5 mb-2 d-md-flex d-sm-block justify-content-between">

            <h6> هاتف العميـل : <span>
                    {{\App\Models\Prev_cols_clients::where('client_id','=',$client->id)->first()->phone}}   </span></h6>

            <h6>: رقم المعاملة <span>{{$installment->id}}</span></h6>
        </div>


    </div>
    <div class="row">

        <div class="col-12 mt-4 mx-5 d-block ">
            <p class="text-dark">بالإشارة إلى
                الموضوع أعلاه وإلى عقد / عقود المديونية المبرمة معكم ونظرا لتخلفكم عن إلتزامكم بسداد
                الأقساط الشهرية فى مواعيد إستحقاقها مما أدى إلى أن ترصد فى ذمتكم مبلغ
                ( {{number_format(($not_done_count_lated *  $installment->installment), 3, '.', ',')}} )
                د.ك متأخر لم يتم سداده رغم إستحقاقه للشركة، ونود الإحاطة بأنه فى حال تأخركم
                فى سداد الأقساط تحل جميع الأقساط المتبقية والتي تبلغ
                ( {{number_format(($installment->amount+(($installment->amount*25)/100)), 3, '.', ',')}} د.ك ) وتصبح
                كامل
                المديونية مستحقة السداد فورا ودون تأخير ، وبخلاف ذلك ستضطر الشركة لإتخاذ كافة الإجراءات
                القانونية والتنفيذية التى من شأنها حفظ كافة حقوق الشركة قبلكم ومن هذه الإجراءات ما يلى :

            </p>
            <p class="text-dark"> * إستحقاق كامل المديونية.
            </p>

            <p class="text-dark"> * إستحقاق كامل المديونية.
            </p>
            <p class="text-dark"> * إضافة إسمكم ضمن العملاء المتخذ ضدهم إجراءات قانونية فى الجهات المختصة.
            </p>
            <p class="text-dark"> * إستصدار أمر ضبط وإحضار.
            </p>
            <p class="text-dark"> * إستصدار أمر منع السفر.
            </p>
            <p class="text-dark"> * حجز الأموال لدى البنك.
            </p>
            <p class="text-dark mt-5"> وعليه يرجى التكرم بالعمل على سداد الأقساط المستحقة لتجنب إتخاذ الإجراءات المشار
                ليها أعلاه ، وفى حال رغبتكم بالسداد يرجى مراجعة فرع الشركة بالجهراء. </p>
            <p class="text-dark mb-5"> في حال قيامكم بسداد المبلغ أعلاه قبل إستلامكم لهذا الإنذار يعتبر الكتاب
                لاغيا. </p>


        </div>
        <div class="mx-5 mb-5 d-md-flex d-sm-block justify-content-between">

            <h6>شركة الكترون للأجهزة الالكترونية</h6>

            <h6>الإدارة القانونية</h6>
        </div>
    </div>
    <div class="mx-5 mb-2 d-block">

        <h6>- صورة لمقر العميل. </h6>

        <h6>- صورة لمقر العمل. </h6>
    </div>
</div>

<!-- </div> -->

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
