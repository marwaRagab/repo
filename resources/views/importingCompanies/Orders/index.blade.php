<div class="card mt-4 py-3">
    <form method="GET" id="filter-form" class="w-100">
        <div class="row pt-3 px-4">
            <div class="col-md-5">
                <div class="mb-5">
                    <input type="text" class="form-control" placeholder="رقم طلب الشراء" name="order_id" id="order_id">
                </div>
            </div>
            <div class="col-md-5">
                <div class="mb-3">
                    <select class="form-select" name="company_id" id="company_id">
                        <option selected disabled>اختر الشركة</option>
                        @foreach ($companies as $company)
                            <option value="{{ $company->id }}">{{ $company->name_ar }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="mb-6">
                    <button type="button" class="btn btn-primary" id="filter-btn">بحث</button>
                    <button type="button" class="btn btn-secondary" id="reset-btn">إلغاء البحث</button>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive pb-4">
            <table id="orders-table" class="table table-bordered border text-nowrap align-middle">
                <thead>
                    <tr>
                        <th>م</th>
                        <th>اسم العميل</th>
                        <th>رقم الفاتورة</th>
                        <th>عدد المنتجات</th>
                        <th>قيمة الفاتورة</th>
                        <th> اجراءات </th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>

<script>
    $(document).ready(function() {
        const table = $('#orders-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('orders.index') }}",
                data: function(d) {
                    d.order_id = $('#order_id').val();
                    d.company_id = $('#company_id').val();
                }
            },
            columns: [{
                    data: 'DT_RowIndex', // This field comes from addIndexColumn
                    name: 'DT_RowIndex',
                    orderable: false, // Optional: Prevent sorting
                    searchable: false // Optional: Prevent searching
                },
                {
                    data: 'client_name',
                    name: 'client.name_ar'
                },
                {
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'products_count',
                    name: 'order_item.count'
                },
                {
                    data: 'invoice_value',
                    name: 'order_item.price_qabila'
                },
                {
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false
                }
            ],
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.25/i18n/Arabic.json"
            }
        });

        $('#filter-btn').on('click', function() {
            table.ajax.reload();
        });

        $('#reset-btn').on('click', function() {
            $('#filter-form')[0].reset();
            table.ajax.reload();
        });
    });
</script>
