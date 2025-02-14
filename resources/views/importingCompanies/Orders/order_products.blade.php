<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0">عدد المنتجات {{ $productsCount }}</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive pb-4">
            <table id="file-export" class="table table-bordered border text-nowrap align-middle">
                <thead>
                    <!-- start row -->
                    <tr>
                        <th>الماركة</th>
                        <th>الصنف</th>
                        <th>الموديل</th>
                        <th>السعر النهائي</th>
                        <th>سعر البيع</th>
                        <th>العدد</th>
                    </tr>
                    <!-- end row -->
                </thead>
                <tbody>
                    <!-- start row -->
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $item->product_order_items->mark->name_ar }}</td>
                            <td>{{ $item->product_order_items->class->name_ar }}</td>
                            <td>{{ $item->product_order_items->model }}</td>
                            <td>{{ number_format($item->product_order_items->net_price, 2) }}</td>
                            <td>{{ number_format($item->product_order_items->price, 2) }} K.D</td>
                            <td>{{ $item->counter }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

    </div>
</div>
