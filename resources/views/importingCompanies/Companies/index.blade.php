
<div class="card mt-4 py-3">
    <div class="d-flex flex-wrap ">
        <a class="btn-static bg-warning-subtle text-warning px-4  mx-2 mb-2">
            <h5> {{ $newOrdersCount }}</h5>
            عدد طلبات الشراء الجديدة
        </a>
        <a class="btn-static bg-success-subtle text-success px-4  mx-2 mb-2">
            <h5> 717,803.945
            </h5>
            المدفوعات
        </a>
        <a class="btn-static bg-primary-subtle text-primary px-4  mx-2 mb-2">

            <h5>152,029.950</h5>
            الديون
        </a>
    </div>
</div>
<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0">الشركات الموردة</h4>
        <a class="btn me-1 mb-1 bg-primary-subtle text-primary px-4  " href="{{ route('company.create') }}">
            أضف شركة جديدة </a>
    </div>
    <div class="card-body">
        <div class="table-responsive pb-4">
            <table id="file_export" class="table table-bordered border text-nowrap align-middle">
                <thead>
                    <!-- start row -->
                    <tr>
                        <th>الاسم</th>
                        <th>طلبات الشراء الجديدة </th>
                        <th>إجمالي الدين</th>
                        <!-- <th>كشف الحساب </th> -->
                        <th> تعديل</th>

                    </tr>
                    <!-- end row -->
                </thead>
                <tbody>
                    <!-- start row -->
                    @forelse ($companies as $company)
                    <tr>
                        <td>{{ $company->name_ar }}</td>
                        <td>{{ $company->ordersFiles->count() }}</td>
                        <td></td>
                        <!-- <td><a class="btn btn-secondary btn-sm rounded-pill" href="">طلبات
                                    الشراء</a></td>  -->
                        <!-- <td><a class="btn btn-success btn-sm rounded-pill" href=""> كشف الحساب</a>
                            </td> -->
                        <td><a href="{{ route('company.edit', $company->id) }}" class="text-primary edit">
                                <i class="ti ti-pencil fs-5"></i>
                            </a></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">لا توجد شركات موردة</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>
</div>
</div>
</div>


