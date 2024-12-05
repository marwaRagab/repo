<div class="card mt-4 py-3">
    <div class="d-flex flex-wrap ">
        <a class="btn-filter me-1 mb-1  bg-primary-subtle text-primary  px-4 fs-4 mx-1 mb-2 ">
            المتوفر ({{ $allProducts->sum('count_prods') }})
        </a>
    </div>
</div>
<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0">المنتجات المتاحة</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive pb-4">
            <table id="file-export" class="table table-bordered border text-nowrap align-middle">
                <thead>
                    <!-- start row -->
                    <tr>
                        <th>التسلسل</th>
                        <th>الصنف</th>
                        <th>العدد</th>
                    </tr>
                    <!-- end row -->
                </thead>
                <tbody>
                    <!-- start row -->
                    @foreach ($allProducts as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                {{ $item['class_name'] }}</td>
                            <td>
                                <a href="{{ route('Transfer.showAvailableProducts', ['classId' => $item['class_id']]) }}"
                                    class="btn-filter me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4 mx-1 mb-2">
                                    @if ($item['class_id'] == 63)
                                        {{ $item['count_prods'] }}
                                    @else
                                        {{ $item['sum_pro'] }}
                                    @endif
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

    </div>
</div>
