<!DOCTYPE html>
<html dir="rtl" lang="ar" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="horizontal">

<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Favicon icon-->
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/logo.jpg') }}" />

    <!-- Core Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}" />

    <title>Electron</title>
    <link rel="stylesheet" href="{{ asset('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
</head>



<body>
    {{-- {{ dd($item) }} --}}
    @php
        $data = specific_fixed_prin_data($data_id);
    @endphp
    <div class="container my-5">
        <div class="row">
            <div class="col-12 text-center py-3">
                <h5> البيانات الخاصة بأطراف القضية لملف التنفيذ

                </h5>
            </div>
            <div class="col-12 py-3 mx-5 ">
                <table class="table table-bordered">

                    <tbody>
                        <tr>
                            <th colspan="5" class="text-center fw-bolder text-underline ">أولا :-- بيانات المدعي
                            </th>
                        </tr>
                        <tr>
                            <th scope="row"> اسم المدعي </th>
                            <td colspan="4">شركة الكترون للأجهزة الالكترونية
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"> الرقم المدني </th>
                            <td colspan="4"> </td>
                        </tr>
                        <tr>
                            <th scope="row"> رقم القضية </th>
                            <td></td>
                            <td>نوع القضية </td>
                            <td>إقرار دين
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">عنوان السكن </th>
                            <td colspan="4"> العاصمة - الشرق - قطعة: 003 - قسيمة: 0
                            00010 - شارع ابن مسباح - مبنى
                                ورثة/ أحمد عبدالله الايوب - الدور 11
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">عنوان العمل </th>
                            <td colspan="4"> العاصمة - الشرق - قطعة: 003 - قسيمة: 000010 - شارع ابن مسباح - مبنى
                                ورثة/ أحمد عبدالله الايوب - الدور 11
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">اسم وكيل المدعي </th>
                            <td colspan="4"> {{ $data->name_ar }}
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">رقم الوكالة </th>
                            <td colspan="4"> {{ $data->agancy_id }}
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">رقم الهاتف </th>
                            <td colspan="4"> {{ $data->phone_number }}
                            </td>
                            
                        </tr>
                        <tr>
                            <th colspan="5" class="text-center fw-bolder text-underline ">ثانيا :-- بيانات المدعي
                                عليه
                            </th>
                        </tr>
                        <tr>
                            <th scope="row"> اسم المدعي </th>
                            <td colspan="4">{{ $item->installment->client->name_ar }}</td>
                        </tr>
                        <tr>
                            <th scope="row"> الرقم المدني </th>
                            <td colspan="4"> {{ $item->installment->client->civil_number }}</td>
                        </tr>
                       
                        <tr>
                            <th scope="row"> عنوان السكن </th>
                            <td colspan="4">
                                القطعه {{  $item->installment->client->client_address->last()->block  ?? ''}} 
                                -
                                الشارع {{  $item->installment->client->client_address->last()->street ?? '' }}
                                -
                                جاده {{  $item->installment->client->client_address->last()->jada ?? '' }}
                                -
                                المبنى {{  $item->installment->client->client_address->last()->building ?? '' }}
                                -
                                الدور {{  $item->installment->client->client_address->last()->floor ?? '' }}
                                -
                                الشقة {{  $item->installment->client->client_address->last()->flat ?? '' }}
                            </td>

                        </tr>
                        <tr>
                            <th scope="row">عنوان العمل </th>
                            <td colspan="4">
                            </td>
                        </tr>
                        
                        <tr>
                            <th scope="row">رقم الهاتف </th>
                            <td colspan="4">
                                @foreach($item->installment->client->client_phone as $phone)
                                    {{ $phone->phone }}{{ !$loop->last ? ' - ' : '' }}
                                @endforeach
                                
                                {{-- {{ ->phone }} --}}
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"> مبلغ إقرار الدين </th>
                            <td colspan="4">{{ $item->eqrar_dain_amount }}
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"> قيمة المبالغ المسددة خارج الإدارة بموجب الحكم المذكور أعلاه </th>
                            <td> المدفوع</td>
                            <td>{{ $item->payment_done}} د.ك </td>
                            <td> المتبقى</td>
                            <td> {{ floatval( $item->eqrar_dain_amount) - floatval( $item->payment_done)  }} د.ك
                            </td>

                        </tr>



                    </tbody>
                </table>
            </div>
            <div class="row  border-bottom">
                <div class="py-2">
                    <h6>اقر بأن البيانات المقدمة أعلاه صحيحة وعلى مسئوليتي
                    </h6>
                </div>
                <div class="mx-5 d-md-flex d-sm-block justify-content-between">

                    <h6>اعتماد رئيس قسم الإعلان
                        :</h6>

                    <h6>:الطالب</h6>
                </div>


            </div>

            



        </div>

    </div>


    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <!-- Import Js Files -->
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/dist/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/theme/app.horizontal.init.js') }}"></script>
    <script src="{{ asset('assets/js/theme/theme.js') }}"></script>
    <script src="{{ asset('assets/js/theme/app.min.js') }}"></script>
    <script src="{{ asset('assets/js/theme/sidebarmenu.js') }}"></script>
    <script src="{{ asset('assets/js/theme/sidebarmenu.js') }}"></script>
    <script src="{{ asset('assets/js/theme/feather.min.js') }}"></script>

    <!-- solar icons -->
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
    <script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable.init.js') }}"></script>
</body>

</html>
