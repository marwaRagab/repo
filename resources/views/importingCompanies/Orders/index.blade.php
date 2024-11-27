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
    <form method="GET" action="{{ route('orders.index') }}" class="w-100">
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
                        <a href="{{ route('orders.index') }}" class="btn btn-secondary">إلغاء البحث</a>
                        <!-- Reset search -->
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <form class="nav-link position-relative shadow-none">
            <iconify-icon icon="solar:magnifer-linear"
                class="text-dark position-absolute top-50 start-0 translate-middle-y text-dark ms-3"></iconify-icon>

            <input type="text" class="form-control rounded-3 py-2 ps-5 text-dark" placeholder="ابحث هنا ....">
        </form>
        <a class=" btn-filter  me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4 mx-1 mb-2 " type="submit"
            href="{{ route('tawreed.purchaseOrdersArchive') }}">
            الارشيف </a>
    </div>
    <div class="card-body">
        <div class="table-responsive pb-4">
            <table id="all-student" class="table table-bordered border text-nowrap align-middle">
                <thead>
                    <!-- start row -->
                    <tr>
                        <th>م</th>
                        <th>اسم العميل</th> 
                        <th>رقم الفاتورة </th>
                        <th> عدد المنتجات</th>
                        <th> قيمة الفاتورة </th>
                        <!--<th> طباعة الفاتورة </th>-->
                        <th> منتجات طلب الشراء</th>
                        <!--<th> طباعة طلب الشراء</th>-->
                        <th> ارسال الي </th>
                    </tr>
                    <!-- end row -->
                </thead>
                <tbody>
                    <!-- start row -->
                    @forelse ($purchaseOrders as $order)
                    @php
                    $client =
                    \App\Models\Order::with('client')->where('id',$order->id)->first()->client;
                    $productsCount =
                    \App\Models\OrderItem::where('order_id',$order->id)->count('counter');
                    $qabila =
                    \App\Models\OrderItem::where('order_id',$order->id)->sum('price_qabila');
                   
                    @endphp
                    <tr>
                        
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $client->name_ar ?? '' }} </td> 
                        <td>{{ $order->id }}</td>
                        <td>{{ $productsCount }}</td>
                        <td> {{ $qabila }}</td>
                        <!--<td> <a href="{{ route('orders.print_invoice', $order->id) }}" class="text-info">طباعة الفاتورة-->
                        <!--    </a></td>-->
                        <td> <a href="{{ route('orders.products', $order->id) }}" class="text-info">منتجات طلب
                                الشراء</a></td>

                        <!--<td> <a href="" class="text-info">طباعة</a></td>-->

                        <td>
                            <div class="btn-group dropup mb-6 me-6">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    ارسال الي </button>

                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li>
                                        <a class="btn btn-success rounded-0 w-100 mt-2" data-bs-toggle="modal"
                                            data-bs-target="#open-file-{{ $order->id }}">

                                            الشركات</a>
                                    </li>
                                    <li>
                                        <form method="POST" action="{{ route('purchaseOrders.delete', $order->id) }}"
                                            onsubmit="return confirm('هل أنت متأكد أنك تريد الغاء هذا الطلب؟');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger rounded-0 w-100 mt-2">
                                                الغاء الطلب
                                            </button>
                                        </form>
                                    </li>

                                </ul>
                            </div>
                        </td>
                    </tr>
                    <!-- model open file  -->
                    <div id="open-file-{{ $order->id }}" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel">إرسال طلبات الشراء</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <h5>طلب شراء <span class="text-info">
                                        @php
                                        $item = \App\Models\ImportingCompanies\Tawreed\purchase_items::with('product')->where('order_id',$order->id)->first();
                                        @endphp
                                        </span></h5>
                                    <form method="POST" action="{{ route('orders.sending', $order->id) }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="file" class="form-label">Upload Image (Optional)</label>
                                            <input type="file" class="form-control" name="img" id="file"
                                                accept="image/*">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">ارسال</button>
                                            <button type="button" class="btn btn-danger"
                                                data-bs-dismiss="modal">الغاء</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
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