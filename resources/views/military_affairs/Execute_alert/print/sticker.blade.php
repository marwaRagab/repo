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
    <div class="container my-2">
        <div class="row">

            <div class="col-12 py-5  ">
                <table class="table table-bordered">

                    <tbody>
                        <tr>
                            <th scope="row">المدعي </th>
                            <td colspan="9">شركة الكترون للأجهزة الالكترونية </td>
                        </tr>
                        <tr>
                            <th scope="row">المدعى عليه </th>
                            <td colspan="9">{{ $item->installment->client->name_ar }}</td>
                        </tr>
                        <tr>
                            <th scope="row">الرقم الآلي </th>
                            <td></td>
                            <td> </td>
                            <td></td>
                            <td></td>
                            <td> </td>
                            <td></td>
                            <td></td>
                            <td> </td>
                            <td></td>

                        </tr>
                        <tr>
                            <th scope="row">رقم الإعلان </th>
                            <td></td>
                            <td> </td>
                            <td></td>
                            <td></td>
                            <td> </td>
                            <td></td>
                            <td></td>
                            <td> </td>
                            <td></td>
                        </tr>
                        <tr>
                            <th scope="row">المندوب </th>
                            <td colspan="9"> </td>
                        </tr>
                        <tr>
                            <th scope="row">عنوان السكن </th>
                            <td colspan="9">
                                @php

                                    $area_name = $item->installment->client->client_address->last()->area_id
                                        ? \App\Models\Region::Findorfail(
                                            $item->installment->client->client_address->last()->area_id,
                                        )->name_ar
                                        : '';
                                @endphp
                                المنطقة: {{ $area_name ?? '' }},
                                القطعه: {{ $item->installment->client->client_address->last()->block ?? ' ' }},

                                الشارع: {{ $item->installment->client->client_address->last()->street ?? ' ' }},

                                جاده: {{ $item->installment->client->client_address->last()->jada ?? ' ' }},

                                المبنى :{{ $item->installment->client->client_address->last()->building ?? '' }},

                                الدور: {{ $item->installment->client->client_address->last()->floor ?? ' ' }},

                                الشقة: {{ $item->installment->client->client_address->last()->flat ?? '  ' }},

                                الرقم الالى :{{ $item->installment->client->house_id ?? '' }}
                            </td>
                        </tr>




                    </tbody>
                </table>
            </div>





        </div>

        <div class="row">

            <div class="col-12 py-5  ">
                <table class="table table-bordered">

                    <tbody>
                        <tr>
                            <th scope="row">المدعي </th>
                            <td colspan="9">شركة الكترون للأجهزة الالكترونية </td>
                        </tr>
                        <tr>
                            <th scope="row">المدعى عليه </th>
                            <td colspan="9">{{ $item->installment->client->name_ar }}</td>
                        </tr>
                        <tr>
                            <th scope="row">الرقم الآلي </th>
                            <td></td>
                            <td> </td>
                            <td></td>
                            <td></td>
                            <td> </td>
                            <td></td>
                            <td></td>
                            <td> </td>
                            <td></td>
                        </tr>
                        <tr>
                            <th scope="row">رقم الإعلان </th>
                            <td></td>
                            <td> </td>
                            <td></td>
                            <td></td>
                            <td> </td>
                            <td></td>
                            <td></td>
                            <td> </td>
                            <td></td>
                        </tr>
                        <tr>
                            <th scope="row">المندوب </th>
                            <td colspan="9"> </td>
                        </tr>
                        <tr>
                            <th scope="row">عنوان السكن </th>
                            <td colspan="9">
                                @php

                                    $area_name = $item->installment->client->client_address->last()->area_id
                                        ? \App\Models\Region::Findorfail(
                                            $item->installment->client->client_address->last()->area_id,
                                        )->name_ar
                                        : '';
                                @endphp
                                المنطقة: {{ $area_name ?? '' }},
                                القطعه: {{ $item->installment->client->client_address->last()->block ?? ' ' }},

                                الشارع: {{ $item->installment->client->client_address->last()->street ?? ' ' }},

                                جاده: {{ $item->installment->client->client_address->last()->jada ?? ' ' }},

                                المبنى :{{ $item->installment->client->client_address->last()->building ?? '' }},

                                الدور: {{ $item->installment->client->client_address->last()->floor ?? ' ' }},

                                الشقة: {{ $item->installment->client->client_address->last()->flat ?? '  ' }},

                                الرقم الالى :{{ $item->installment->client->house_id ?? '' }}
                            </td>
                        </tr>




                    </tbody>
                </table>
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
