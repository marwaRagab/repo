@extends('ClientDashboard.layouts.app')

@section('crumb')
    <span> المدفوعات</span>
@endsection

@section('content')
<div class="card mt-4 p-4">
    <h5 class="pb-3">المدفوعات</h5>
    <div class="form-rows row align-items-end justify-content-center">

        <div class="form-group col-md-6">
            <label for="durationSelect" class="form-label"> الفترة</label>
            <select class="form-control form-select" id="durationSelect">
                <option value="3"> اخر شهر</option>
                <option value="2"> اخر 3 شهور</option>
                <option value="1"> اخر سنة</option>
            </select>
        </div>
        <div class="form-group col-md-6">
            <label for="monthSelect" class="form-label">الحالة </label>
            <select class="form-control form-select" id="monthSelect">
                <option value="4">ناجح</option>
                <option value="5">فشل</option>
                <option value="6">معلق</option>
            </select>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="table-responsive pb-4">
            <table class="table table-bordered border text-nowrap align-middle">
                <thead>
                    <!-- start row -->
                    <tr>
                        <th>رقم المعاملة </th>
                        <th> التاريخ </th>
                        <th> نوع العملية</th>
                        <th> طريقة الدفع</th>
                        <th> الحالة العملية</th>
                        <th> رقم الاشعار</th>
                        <th> تاريخ الاستحقاق</th>
                        <th> المبلغ </th>

                    </tr>
                    <!-- end row -->
                </thead>
                <tbody>
                    <!-- start row -->
                    <tr>
                        <td>12345</td>
                        <td>2025-01-21</td>
                        <td>إيداع</td>
                        <td>بطاقة ائتمان</td>
                        <td>مكتملة</td>
                        <td>67890</td>
                        <td>2025-02-01</td>
                        <td>500.00 ريال</td>
                    </tr>
                    <tr>
                        <td>67890</td>
                        <td>2025-01-15</td>
                        <td>سحب</td>
                        <td>تحويل بنكي</td>
                        <td>قيد الانتظار</td>
                        <td>12345</td>
                        <td>2025-01-25</td>
                        <td>1000.00 ريال</td>
                    </tr>
                    <tr>
                        <td>54321</td>
                        <td>2025-01-10</td>
                        <td>دفع فاتورة</td>
                        <td>نقداً</td>
                        <td>مرفوضة</td>
                        <td>98765</td>
                        <td>2025-01-20</td>
                        <td>250.00 ريال</td>
                    </tr>

                </tbody>
            </table>

        </div>
    </div>
</div>

@endsection
