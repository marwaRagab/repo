@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
<div class="card mt-4 py-3">
    <form method="GET" action="{{ route('tawreed.purchaseOrdersArchive') }}" class="w-100">
        <!-- Ensure the correct route -->
        <div class="row pt-3 px-4">
            <div class="col-md-5">
                <div class="mb-5">
                    <input type="text" class="form-control" placeholder="رقم طلب الشراء" name="order_id"
                        value="{{ request('order_id') }}">
                </div>
            </div>
            <div class="col-md-5">
                <div class="mb-3">
                    <select class="form-select" name="company_id">
                        <option selected disabled>اختر الشركة</option>
                        @foreach ($companies as $company)
                            <option value="{{ $company->id }}"
                                {{ request('company_id') == $company->id ? 'selected' : '' }}>{{ $company->name_ar }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="mb-6">
                    <button class="btn btn-primary" type="submit">بحث</button>
                    <div class="mt-3">
                        <a href="{{ route('tawreed.purchaseOrdersArchive') }}" class="btn btn-secondary">إلغاء البحث</a>
                        <!-- Reset search -->
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0"> طلبات الشراء المرسلة </h4>
        <a class=" btn-filter  me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4 mx-1 mb-2 " type="submit"
            href="{{ route('tawreed.purchaseOrders') }}">
            طلبات الشراء الجديدة
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive pb-4">
            <table id="all-student" class="table table-bordered border text-nowrap align-middle">
                <thead>
                    <!-- start row -->
                    <tr>
                        <th>رقم طلب الشراء</th>
                        <th>اسم الشركة </th>
                        <th> الموديل </th>
                        <th> مكان التوريد </th>
                        <th> القيمة الإجمالية </th>
                        <th> طباعة طلب الشراء المرسل </th>
                        <th> تاريخ الإرسال </th>
                        <th> الحالة </th>
                    </tr>
                    <!-- end row -->
                </thead>
                <tbody>
                    <!-- start row -->
                    @forelse ($purchaseOrders as $order)
                        <tr>
                            <td>{{ $order->id }} </td>
                            <td>{{ $order->company->name_ar ?? ''}}</td>
                            <td>
                                @foreach ($order->purchase as $index => $item)
                                    {{ $item->product->model ?? '' }}@if (!$loop->last)
                                        <br>
                                    @endif
                                @endforeach
                            </td>
                            <td> {{ "المعرض" }}</td>
                            <td> {{ $order->amount }}</td>
                            <td> <a href="{{ route('tawreed.print_purchase',$order->id) }}" class="text-info">طباعة</a></td>
                            <td> {{ $order->send_date }}</td>
                            <td class="text-success"> فعال</td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">لا توجد طلبات شراء</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
    </div>
