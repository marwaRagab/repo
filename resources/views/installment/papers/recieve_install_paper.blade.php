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
    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            .print-container, .print-container * {
                visibility: visible;
            }
            .print-container {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
        }
        body {
            font-family: 'Arial', sans-serif;
            font-size: 14px;
        }
        .container {
            max-width: 800px;
            margin: auto;
        }
        .card-body {
            padding: 10px;
        }
        .row {
            margin-bottom: 10px;
        }
        .col-md-6, .col-md-12 {
            padding: 5px;
        }
        .checkbox-label {
            display: flex;
            align-items: center;
        }
        .checkbox-label input {
            margin-left: 10px;
        }
    </style>
</head>

<body>
<div class="container my-5 print-container">
    <div class="border-bottom">
        <div class="text-center py-3">
            <h5>إيصال استلام أوراق عميل</h5>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            التاريخ: {{ date('d/m/Y') }}
                        </div>
                        <div class="col-md-12">
                            إستلمت أنا / {{ auth()->user()->name }}
                        </div>
                        <div class="col-md-12">
                            الأوراق المطلوبة من العميل
                        </div>
                        <div class="col-md-6">
                            اسم العميل: {{ $client->name_ar }}
                        </div>
                        <div class="col-md-6">
                            الرقم المدني: {{ $client->civil_number }}
                        </div>
                        <div class="col-md-6">
                            رقم الهاتف: {{ $client->phone }}
                        </div>
                        <div class="col-md-6">
                            البنك: {{ $bankName }}
                        </div>
                        <div class="col-md-6">
                            جهة العمل: {{ $ministryName }}
                        </div>
                        <div class="col-md-6">
                            جهة الدخل: {{ $ministryName }}
                        </div>
                        <div class="col-md-6">
                            رقم إقرار الدين: {{ $installment->part_paper_number }}
                        </div>
                        <div class="col-md-6">
                            رقم المعاملة: {{ $installment->id }}
                        </div>
                        <div class="col-md-12">
                            وآنا مسئول عن صحة تطابقها وهي كالآتي:
                        </div>
                        <div class="col-md-4 mb-3 checkbox-label">
                            <input type="checkbox" id="civil_image" name="documents[]" value="civil_image">
                            <label for="civil_image">صورة مدنية</label>
                        </div>
                        <div class="col-md-4 mb-3 checkbox-label">
                            <input type="checkbox" id="salary_certificate" name="documents[]" value="salary_certificate">
                            <label for="salary_certificate">شهادة الراتب</label>
                        </div>
                        <div class="col-md-4 mb-3 checkbox-label">
                            <input type="checkbox" id="account_statement" name="documents[]" value="account_statement">
                            <label for="account_statement">كشف حساب</label>
                        </div>
                        <div class="col-md-4 mb-3 checkbox-label">
                            <input type="checkbox" id="sign" name="documents[]" value="sign">
                            <label for="sign">ساينت</label>
                        </div>
                        <div class="col-md-4 mb-3 checkbox-label">
                            <input type="checkbox" id="installment_contract" name="documents[]" value="installment_contract">
                            <label for="installment_contract">عقد أقساط</label>
                        </div>
                        <div class="col-md-4 mb-3 checkbox-label">
                            <input type="checkbox" id="bank_deduction" name="documents[]" value="bank_deduction">
                            <label for="bank_deduction">إستقطاع بنكي</label>
                        </div>
                        <div class="col-md-4 mb-3 checkbox-label">
                            <input type="checkbox" id="deduction_fees" name="documents[]" value="deduction_fees">
                            <label for="deduction_fees">رسوم إستقطاع</label>
                        </div>
                        <div class="col-md-4 mb-3 checkbox-label">
                            <input type="checkbox" id="debt_declaration" name="documents[]" value="debt_declaration">
                            <label for="debt_declaration">إقرار دين</label>
                        </div>
                        <div class="col-md-4 mb-3 checkbox-label">
                            <input type="checkbox" id="guarantor_debt_declaration" name="documents[]" value="guarantor_debt_declaration">
                            <label for="guarantor_debt_declaration">إقرار دين كفيل</label>
                        </div>
                        <div class="col-md-4 mb-3 checkbox-label">
                            <input type="checkbox" id="judicial_inquiry" name="documents[]" value="judicial_inquiry">
                            <label for="judicial_inquiry">إستعلام قضائي</label>
                        </div>
                        <div class="col-md-4 mb-3 checkbox-label">
                            <input type="checkbox" id="items_receipt" name="documents[]" value="items_receipt">
                            <label for="items_receipt">استلام اغراض</label>
                        </div>
                        <div class="col-md-6">
                            مستلم الأوراق
                            <br>........................
                        </div>
                        <div class="col-md-6 text-center">
                            التوقيع
                            <br>........................
                        </div>
                        <div class="col-md-12">
                            ملاحظات الموظف:
                            <br>..............................................................................................................................................................
                            <br>..............................................................................................................................................................
                        </div>
                        <div class="col-md-6">
                            المدقق
                            <br>........................
                        </div>
                        <div class="col-md-6 text-center">
                            التوقيع
                            <br>........................
                        </div>
                        <div class="col-md-12">
                            ملاحظات المدقق:
                            <br>..............................................................................................................................................................
                            <br>..............................................................................................................................................................
                        </div>
                        <div class="col-md-6"></div>
                        <div class="col-md-6 text-center">
                            إعتماد المدير العام
                            <br>........................
                        </div>
                    </div>
                </div>
            </div>
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
<script src="{{asset('assets/js/theme/feather.min.js')}}"></script>

<!-- solar icons -->
<script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
<script src="{{asset('assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/js/datatable/datatable.init.js')}}"></script>
</body>

</html>

