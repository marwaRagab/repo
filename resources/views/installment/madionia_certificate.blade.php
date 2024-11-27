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
    <div class="row mt-3 border-bottom">
        <div class="col-12 mx-5 py-1 d-flex justify-content-between">
            <h6>السيد /{{$installment->client->name_ar}}  </h6>
            <h6>التاريخ : {{ now()->format('Y-m-d') }}</h6>
        </div>
        <div class="col-12 mx-5 py-4 my-2">
            <div class="border p-4">
                <h6>مديونية السيد <span> {{$installment->client->name_ar}}</span></h6>
                @if($installment->client->nationality)
                <h6>الجنسية <span> {{ $installment->client->nationality->name_ar }}</span></h6>
                @endif
                <h6> الرقم المدني <span> {{$installment->client->civil_number}}</span></h6>

                <h6> تاريخ المعاملة<span> {{ $installment->created_at->format('Y-m-d') }}

                    </span></h6>

                <h6> اجمالي المديونية <span>

                        @if($installment->installment_clients >0)
                            {{$installment->total_madionia}}

                        @else
                            {{$installment->amount  + $installment->first_amount}}
                            {{number_format(($installment->amount + $installment->first_amount), '3', '.', ',')}}

                        @endif

                            د.ك</span></h6>

            </div>
        </div>
        <div class="col-12  py-2 mx-5 py-1 mb-2 ">
            <table class="table table-bordered">
                <tbody>
                <tr>
                    <th scope="row"> رقم المعاملة</th>
                    <td> {{$installment->id}}</td>
                </tr>
                <tr>
                    <th scope="row">التاريخ</th>
                    <td>{{ now()->format('Y-m-d') }}</td>
                </tr>
                <tr>
                    <th scope="row">المبلغ المتبقي</th>
                    <td> @if ($Military_affair)
                            {{ $Military_affair->eqrar_dain_amount - $installment->amount - $Military_affair->excute_actions_amount - $Military_affair->excute_actions_check_amount }}
                            دك
                    @else
                        {{(float)$installment->total_madionia + (float)$installment->extra_first_amount - ((float)$installment->amount + (float)($invoices_installment->amount ?? 0))}}

                    @endif
                </tr>
                <tr>
                    <th scope="row">قيمة القسط

                    </th>
                    <td> {{$installment->installment}} دك</td>
                </tr>

                <tr>
                    <th scope="row">عدد شهور التأخير

                    </th>
                    <td>{{$installment->lated_count}}</td>
                </tr>
                <tr>
                    <th scope="row">مبلغ التأخير

                    </th>
                    <td>{{$installment->lated_count * $installment->installment}} دك</td>
                </tr>
                <tr>
                    <th scope="row">تاريخ اخر عملية دفع

                    </th>
                    <td>{{$months->payment_date ?? null }}</td>
                </tr>
                <tr>
                    <th scope="row">حالة الملف

                    </th>
                    @if ($installment->laws == 0)
                        <td>أقساط</td>
                    @else
                        <td>شئون قانونية</td>
                    @endif
                </tr>


                </tbody>
            </table>
        </div>
        <div class="col-12 mx-5 py-1 d-flex justify-content-between">
            <h6> :اليوزر  </h6>
            <p class="text-dark">{{ Auth::user()->name_ar ?? 'Guest' }}</p>
            <h6> : التاريخ</h6>
            <p class="text-dark">{{ now()->format('Y-m-d') }}</p>

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
<script src="{{asset('assets/js/theme/sidebarmenu.js')}}"></script>
<script src="{{asset('assets/js/theme/feather.min.js')}}"></script>

<!-- solar icons -->
<script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
<script src="{{asset('assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/js/datatable/datatable.init.js')}}"></script>
</body>

</html>
