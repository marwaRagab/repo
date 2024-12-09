<div class="btn-group dropup  me-6">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
        aria-expanded="false">
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

<form id="delete-form-{{ $order->id }}" action="{{ route('purchaseOrders.delete', $order->id) }}" method="POST"
    style="display: none;">
    @csrf
    @method('DELETE')
</form>
<script>
    function confirmDelete(id) {
        if (confirm('هل أنت متأكد أنك تريد الغاء هذا الطلب؟')) {
            document.getElementById(`delete-form-${id}`).submit();
        }
    }
</script>
<div id="open-file-{{ $order->id }}" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">إرسال طلبات الشراء</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <h5>طلب شراء <span class="text-info">
                        @php
                            $item = \App\Models\ImportingCompanies\Tawreed\purchase_items::with('product')
                                ->where('order_id', $order->id)
                                ->first();
                        @endphp
                    </span></h5>
                <form method="POST" action="{{ route('orders.sending', $order->id) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="file" class="form-label">Upload Image (Optional)</label>
                        <input type="file" class="form-control" name="img" id="file" accept="image/*">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">ارسال</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">الغاء</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
