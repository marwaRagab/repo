<div class="card mt-4 py-3">
    <div class="d-flex flex-wrap ">
        <!-- <a class=" btn-filter me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4 mx-1 mb-2 "
            href="./sending-archive.html">
            الارشيف
        </a> -->

        <a class=" btn-filter me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4 mx-1 mb-2 "
            href="{{ route('tawreed.purchaseOrders') }}">
            ارسال طلبات التوريد
        </a>

    </div>
</div>
<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0"> توريد جديد</h4>

    </div>
    <div class="card-body">
        <div class="table-responsive pb-4">
            <table id="file_export" class="table table-bordered border text-nowrap align-middle">
                <thead>
                    <!-- start row -->
                    <tr>
                        <th>الاسم</th>
                        <th>طلب شراء جديد </th>
                    </tr>
                    <!-- end row -->
                </thead>
                <tbody>
                    <!-- start row -->
                    @foreach ($data as $company)
                        <tr>
                            <td> {{ $company->name_ar }}</td>
                            <td> <a class=" btn-filter me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4 mx-1 mb-2 "
                                    href="{{ route('tawreed.searchForm', $company->id) }}">
                                    طلب شراء جديد
                                </a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
