<div class="row">
    <div class="col-lg-8 ">
        <div class="card overflow-hidden">
            <div class="bg-primary text-white px-4 py-3 border-bottom">
                <h4 class="card-title text-white mb-0">عدد المنتجات ({{ $items->sum('total_count') }})</h4>
            </div>

            <div class="card-body">
                <div class="table-responsive pb-4">
                    <table id="file-export" class="table table-bordered border text-wrap align-middle">
                        <thead>
                            <!-- start row -->
                            <tr>
                                <th>الموديل</th>
                                <th>التفاصيل</th>
                                <th>السعر</th>
                                <th>العدد</th>
                                <th> المجموع</th>
                                <th>حذف</th>
                            </tr>
                            <!-- end row -->
                        </thead>
                        <tbody>
                            <!-- Start row -->
                            @forelse ($items as $item)
                                <tr>
                                    <td>{{ $item->product->model }}</td>
                                    <td>{{ $item->product->description }}</td>
                                    <td>{{ $item->product->price }}</td>
                                    <td>{{ $item->total_count }}</td>
                                    <td>{{ number_format($item->total_price, 2) }}</td>
                                    <td>
                                        <div class="action-btn text-center">
                                            <form method="POST" action="{{ route('cart.delete', $item->product_id) }}"
                                                class="delete-form"
                                                onsubmit="return confirm('هل أنت متأكد أنك تريد حذف هذا المنتج؟');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-danger"
                                                    style="background: none; border: none; cursor: pointer;">
                                                    <i class="ti ti-trash fs-5"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">لا توجد منتجات في السلة.</td>
                                </tr>
                            @endforelse
                            <!-- End row -->
                        </tbody>
                    </table>
                    <div class="row pt-3 px-4">
                        <div class="col-md-6 mb-3">
                            @if ($items->isNotEmpty())
                                <form method="GET"
                                    action="{{ route('tawreed.searchForm', ['companyId' => $items->first()->product->company_id]) }}">
                                    <button type="submit"
                                        class="btn-filter me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4 mx-1 mb-2">
                                        متــابعة الشراء
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('tawreed.index') }}"
                                    class="btn-filter me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4 mx-1 mb-2">
                                    العودة إلى قائمة المنتجات
                                </a>
                            @endif
                        </div>
                        <div class="col-md-6 mb-3 text-end">
                            <form method="POST" action="{{ route('tawreed.addToPurchaseOrders') }}">
                                @csrf
                                <button type="submit" class="btn bg-primary text-white">تحويل طلب شراء</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">مجموع السلة</h4>
                <div class="py-3 border-bottom border-top">
                    <p class="fs-2 mb-3">المجموع</p>
                    <h3>{{ $items->sum('total_price') }} دينار</h3>
                </div>
                <form method="POST" action="{{ route('cart.clear') }}" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger rounded-0 mt-4"
                        onclick="return confirm('هل أنت متأكد أنك تريد حذف جميع العناصر من السلة؟');">
                        إلغاء العملية
                    </button>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4"> بيانات الشركة</h4>
                <div class="py-3 border-top">
                    @if ($items->isNotEmpty())
                        <h6 class="mb-3"><span> الاسم: </span> {{ $items->first()->product->company->name_ar }}</h6>
                        <h6 class="mb-3"><span> الهاتف: </span> {{ $items->first()->product->company->phone }}</h6>
                    @else
                        <h6 class="mb-3">لا توجد بيانات للشركة.</h6>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
