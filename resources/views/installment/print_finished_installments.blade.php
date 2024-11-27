<!DOCTYPE html>
<html dir="rtl" lang="ar" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="horizontal">

<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Favicon icon-->
    <link rel="shortcut icon" type="image/png" href="../assets/images/logos/logo.jpg" />

    <!-- Core Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css')}}" />
    <title>Electron</title>
    <link rel="stylesheet" href="../assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css">
</head>

<body>
    <div class="container my-5">
        <div class="border-bottom">

            <div class="text-center py-2">
                <h5>براءة ذمة</h5>
            </div>
            <div class="mx-5 d-md-flex d-sm-block justify-content-between">
                @php
                    $now = new DateTime(); // Get the current date and time
                    $dayArabic = $now->format('l'); // Day name in English

                    // Translate day name to Arabic
                    $daysArabic = [
                        'Saturday' => 'السبت',
                        'Sunday' => 'الأحد',
                        'Monday' => 'الإثنين',
                        'Tuesday' => 'الثلاثاء',
                        'Wednesday' => 'الأربعاء',
                        'Thursday' => 'الخميس',
                        'Friday' => 'الجمعة',
                    ];
                    $dayArabic = $daysArabic[$dayArabic];
                @endphp
                <h5>التاريخ:</h5>
                {{ $dayArabic }} الموافق {{ $now->format('Y/m/d') }}
                <h5>:Date</h5>
                
            </div>
            <div class="mx-5  d-md-flex  d-sm-block justify-content-between">

                <h5>رقم الحساب:</h5>
                <span> {{$clients->ipan ?? ' '}} </span>
              
                <h5>:Account Number</h5>
            </div>

        </div>
       
            <div class="row">
                <div class="col-12 mt-3 mx-5 text-center  mb-4">
                    <h6>تشـــهـد شـــركة إلكتـــــرون بصحــة المعلومات أدنــاه</h6>
                    <h6>Electron Company certifies the accuracy of information</h6>
                </div>
                <div class="col-12 mx-5 d-flex justify-content-between">
                    <div class="col-md-6 col-sm-12 me-3">
                        <h6 class="mt-3 "> مقدم الطلب: <span> تست </span></h6>
                        <h6 class="mt-3"> الرقم المدني: <span> 1222122221 </span></h6>
                        <h6 class="mt-3"> الجنسية: <span> تست </span></h6>
                        <h6 class="mt-3"> تاريخ الاتفاقية: <span> 12-12-12 </span></h6>
                        <h6 class="mt-3"> قيمة اقرار الدين: <span> 0.000دينار كويتي </span></h6>
                        <h6 class="mt-3"> القسط الشهري: <span> 0.000 دينار كويتي </span></h6>
                        <h6 class="mt-3"> تاريخ السداد:<span> 2024/08/21 </span></h6>
                        <h6 class="mt-3"> اجمالي المبلغ المدفوع:<span> 2024/08/21 </span></h6>
                        <h6 class="mt-3"> تاريخ السداد:<span> 0.000 دينار كويتي </span></h6>
                        <h6 class="mt-3"> رقم اقرار الدين : <span> 2024/08/21 </span></h6>
                        <h6 class="mt-3"> تاريخ اقرار الدين:<span> 2024/08/21 </span></h6>
                        <h6 class="mt-3"> حالة الملف:<span> تم السداد </span></h6>
                        <h6 class="mt-3"> رقم الحساب: <span></span></h6>
                    </div>

                    <div class="col-md-6 col-sm-12 me-3">
                        <h6 class="mt-3">
                            :Applicant Name <span> </span></h6>
                        <h6 class="mt-3"> :Civil ID No <span>
                            </span></h6>
                        <h6 class="mt-3"> :Nationality <span> </span></h6>
                        <h6 class="mt-3"> :Contract Date <span> </span></h6>
                        <h6 class="mt-3">
                            :Monthly Installement <span> </span></h6>
                        <h6 class="mt-3"> :Contract Date <span></span></h6>
                    </div>
                </div>
                <div class="col-12 text-center  mb-4">
                    <h6>تشـــهـد شـــركة إلكتـــــرون بصحــة المعلومات أدنــاه</h6>
                    <h6>Electron Company certifies the accuracy of information</h6>
                </div>
                
            <div class="col-12 mx-5 py-1 d-flex justify-content-between">
                <h6> :User name </h6>
                <h6> : Date</h6>
            </div>
            </div>
        </div>

    <!-- </div> -->
   
    <script src="../assets/js/vendor.min.js"></script>
    <!-- Import Js Files -->
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/libs/simplebar/dist/simplebar.min.js"></script>
    <script src="../assets/js/theme/app.horizontal.init.js"></script>
    <script src="../assets/js/theme/theme.js"></script>
    <script src="../assets/js/theme/app.min.js"></script>
    <script src="../assets/js/theme/sidebarmenu.js"></script>
    <script src="../assets/js/theme/feather.min.js"></script>

    <!-- solar icons -->
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
    <script src="../assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../assets/js/datatable/datatable.init.js"></script>
</body>

</html>