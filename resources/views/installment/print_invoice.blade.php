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
        <div class="text-center py-3">
            <h5>نموذج استلام منتجات فاتورة رقم ({{$order->id}} ) </h5>
        </div>
        <div class="mx-5 py-1 d-block">

            <h5>{{date('Y-m-d')}}</h5>
            <h5>السيد / {{$client->name_ar}}</h5>
            <h5>هاتف : {{$client->client_phone->last()->phone}}</h5>
        </div>


    </div>
    <div class="row">
        <div class="col-12 py-2 mx-5 ">
            <table class="table table-bordered">
                <thead>
                <th> م</th>
                <th>الماركة</th>
                <th>الصنف</th>
                <th>الموديل</th>
                <th>العدد</th>
                <th>الرقم التسلسلى</th>

                </thead>

                <tbody>

                @php
                    $x=0;
                @endphp
                @foreach($order->order_items as $value)

                    <tr>
                        <td>{{$x++}} </td>
                        <td>{{$value->product->mark->name_ar}}</td>
                        <td>{{$value->product->class->name_ar}}</td>
                        <td>{{$value->model}}</td>
                        <td>{{$value->counter}}</td>
                        <td>{{$value->product_items->serial_number}}</td>


                    </tr>
                @endforeach


                </tbody>
            </table>
        </div>

        <div class="col-12  mb-1 py-4 mx-5 d-flex justify-content-between">
            <div class="col-md-6 col-sm-12">
                <p class="text-dark text-underline fw-bolder"> المحاسب</p>
                <p class="text-dark"> ............</p>
            </div>
            <div class="col-md-6 col-sm-12">
                <p class="text-dark"> المستلم</p>
                <p class="text-dark">..........</p>

            </div>


        </div>

        <div class="col-12 mx-5 py-1 d-flex justify-content-between">
            <h6> :User name </h6>
            <h6> : Date</h6>
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
