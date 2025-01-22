@extends('ClientDashboard.layouts.app')

@section('crumb')
    <span>الصفحة الرئيسية</span>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8 d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-body border-bottom position-relative">
                <h4 class="card-title mb-1">بيانات العميل </h4>
                <p class="card-subtitle mb-0">لقد قمت بزيادة مبيعاتك بنسبة 38%
                </p>
                <div class="mt-6">
                    <ul class="list-unstyled mb-0">
                        <li class="d-flex align-items-center mb-9">
                            <div
                                class="bg-success-subtle p-6 ms-3 rounded-circle d-flex align-items-center justify-content-center">
                                <iconify-icon icon="solar:cart-5-line-duotone"
                                    class="fs-7 text-success"></iconify-icon>
                            </div>
                            <div>
                                <h6 class="mb-1 fs-4">64 عدد المعاملات</h6>
                            </div>
                        </li>
                        <li class="d-flex align-items-center mb-9">
                            <div
                                class="bg-warning-subtle p-6 ms-3 rounded-circle d-flex align-items-center justify-content-center">
                                <iconify-icon icon="solar:pause-line-duotone"
                                    class="fs-6 text-warning"></iconify-icon>
                            </div>
                            <div>
                                <h6 class="mb-1 fs-4">4 عدد الاقساط المدفوعة</h6>
                            </div>
                        </li>
                        <li class="d-flex align-items-center mb-9">
                            <div
                                class="bg-indigo-subtle p-6 ms-3 rounded-circle d-flex align-items-center justify-content-center">
                                <iconify-icon icon="solar:bicycling-round-bold-duotone"
                                    class="fs-7 text-indigo"></iconify-icon>
                            </div>
                            <div>
                                <h6 class="mb-1 fs-4">12 عدد الاقساط المتأخرة</h6>
                            </div>
                        </li>
                        <li class="d-flex align-items-center">
                            <div
                                class="bg-success-subtle p-6 ms-3 rounded-circle d-flex align-items-center justify-content-center">
                                <iconify-icon icon="solar:cart-5-line-duotone"
                                    class="fs-7 text-success"></iconify-icon>
                            </div>
                            <div>
                                <h6 class="mb-1 fs-4">33 عدد الاقساط المتبقية</h6>
                            </div>
                        </li>
                    </ul>
                    <div class="man-working-on-laptop">
                        <img src="{{asset('client_assets')}}/images/backgrounds/man-working-on-laptop.png"
                            alt="spike-img" class="img-fluid">
                    </div>
                </div>
            </div>
            <div class="card-body pb-2">
                <div class="d-flex align-items-baseline justify-content-between">
                    <div>
                        <h4 class="card-title mb-1">إجمالي الطلبات
                        </h4>
                        <p class="card-subtitle mb-0">تحديثات الطلب الأسبوعية
                        </p>
                    </div>
                    <select class="form-select fw-bold w-auto shadow-none">
                        <option value="1">هذا الاسبوع</option>
                        <option value="2">إبريل 2024</option>
                        <option value="3">مايو 2024</option>
                        <option value="4">مارس 2024</option>
                    </select>
                </div>
                <div id="netsells" class="mx-n6"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 d-flex align-items-stretch">
        <div class="d-block w-100">
            <div class="card w-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title mb-1">الدخل</h4>
                            <p class="card-subtitle">السنوات</p>
                        </div>
                        <div>
                            <h4 class="card-title mb-1 text-end">432</h4>
                            <span
                                class="badge rounded-pill bg-success-subtle text-success border-success border text-end">+26.5%</span>
                        </div>
                    </div>
                    <div id="products" class="my-8"></div>
                    <p class="mb-0 text-center">$18k Profit more than last years</p>
                </div>
            </div>
            <div class="card w-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title mb-1">العملاء</h4>
                            <p class="card-subtitle">اخر 7 ايام</p>
                        </div>
                        <div>
                            <h4 class="card-title mb-1 text-end">6,380</h4>
                            <span
                                class="badge rounded-pill bg-success-subtle text-success border-success border text-end">+26.5%</span>
                        </div>
                    </div>
                    <div id="customers" class="my-5"></div>
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <p class="mb-0">April 07 - April 14</p>
                        <p class="mb-0">6,380</p>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <p class="mb-0">Last Week</p>
                        <p class="mb-0">4,298</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class=col-lg-12 d-flex align-items-stretch>
        <div class="card white-box w-100">
            <div class="px-4 py-3 border-bottom">
                <h4 class="card-title mb-0">  أحدث 5 عمليات </h4>
            </div>
            <div class="card-body">
                <div class="table-responsive pb-4">
                    <table class="table table-striped table-bordered border text-nowrap align-middle">
                        <thead class="thead-dark">
                            <tr>
                                <th>م</th>
                                <th>التاريخ</th>
                                <th> اسم المنتج</th>
                                <th>المبلغ المدفوع</th>
                                <th> المبلغ المتبقي</th>
                                <th> الحالة </th>
                                <th> الوسيلة المستحدمة</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>1-1</td>
                                <td> تكييف</td>
                                <td>131.000</td>
                                <td>124205200</td>
                                <td>خالص</td>
                                <td>  الوسيلة</td>

                            </tr>
                            <tr>
                                <td>2</td>
                                <td>1-1</td>
                                <td> تكييف</td>
                                <td>131.000</td>
                                <td>124205200</td>
                                <td>خالص</td>
                                <td>  الوسيلة</td>

                            </tr>
                            <tr>
                                <td>3</td>
                                <td>1-1</td>
                                <td> تكييف</td>
                                <td>131.000</td>
                                <td>124205200</td>
                                <td>خالص</td>
                                <td>  الوسيلة</td>

                            </tr>
                            <tr>
                                <td>4</td>
                                <td>1-1</td>
                                <td> تكييف</td>
                                <td>131.000</td>
                                <td>124205200</td>
                                <td>خالص</td>
                                <td>  الوسيلة</td>

                            </tr>
                            <tr>
                                <td>5</td>
                                <td>1-1</td>
                                <td> تكييف</td>
                                <td>131.000</td>
                                <td>124205200</td>
                                <td>خالص</td>
                                <td>  الوسيلة</td>

                            </tr>



                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
