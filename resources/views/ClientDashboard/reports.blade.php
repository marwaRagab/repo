@extends('ClientDashboard.layouts.app')

@section('crumb')
    <span> التقارير المالية</span>
@endsection

@section('content')
<div class="card mt-4 py-3">
    <div class="d-flex flex-wrap ">
        <a class="btn-static bg-warning-subtle text-warning px-4 fs-4 mx-2 mb-2">
            <h5> 79.000</h5>
            الاقساط المتبقية
        </a>
        <a class="btn-static bg-success-subtle text-success px-4 fs-4 mx-2 mb-2">
            <h5> 717,803.945
            </h5>
            الاقساط المدفوعة
        </a>

    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="table-responsive pb-4">
            <table class="table table-bordered border text-nowrap align-middle">
                <thead>
                    <!-- start row -->
                    <tr>
                        <th>اسم المنتج</th>
                        <th> التاريخ </th>
                        <th> الحالة</th>


                    </tr>
                    <!-- end row -->
                </thead>
                <tbody>
                    <!-- start row -->
                    <tr>
                        <td class="text-info">
                            غسالة
                        </td>
                        <td>
                            19-10
                        </td>
                        <td> مدفوع</td>

                    </tr>
                    <tr>
                        <td class="text-info">
                            ثلاجه
                        </td>
                        <td>
                            5-12
                        </td>
                        <td> مستحق</td>

                    </tr>
                    <tr>
                        <td class="text-info">
                            غسالة
                        </td>
                        <td>
                            19-10
                        </td>
                        <td> مدفوع</td>

                    </tr>
                    <tr>
                        <td class="text-info">
                            ثلاجه
                        </td>
                        <td>
                            5-12
                        </td>
                        <td> مستحق</td>

                    </tr>
                </tbody>
            </table>

        </div>
    </div>
</div>

@endsection
