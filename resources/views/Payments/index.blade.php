<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0">عمليات الدفع</h4>
        <div class="form-group">
    <select class="form-select" id="dateSelect" name="month">
        <option selected disabled>اختر التاريخ</option>
        @foreach($dates as $date)
            <option value="{{ $date }}" {{ request()->get('month') == $date ? 'selected' : '' }}>
                {{ $date }}
            </option>
        @endforeach
    </select>
</div>
    </div>

    <div class="card-body">
        <div class="table-responsive pb-4">
            <table id="all-student1" class="table table-bordered border text-nowrap align-middle">
                <thead class="thead-dark">
                    <tr>
                    <th>م</th>
                    <th>اسم العميل</th>
                    <th>المبلغ</th>
                    <th>طريقة الدفع</th>
                    <th>رقم العملية</th>
                    <th>حالة الطباعة</th>
                    <th>التفاصيل</th>
                    <th>التاريخ</th>
                    <th>طباعة</th>
                    <th>تحويل للأرشيف</th>
                    <th><input type="checkbox" class="form-check-input" id="select-all"></th>
                    </tr>
                </thead>
                
            </table>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script>
    $(document).ready(function () {
        $('#all-student1').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('payments.data') }}',
                data: function (d) {
                    d.month = $('#dateSelect').val(); // Pass selected month
                },
                success: function (response) {
                    // Log the response data to the console
                    console.log('Data received from server:', response);
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'installment.client.name_ar', name: 'installment.client.name_ar', defaultContent: 'لايوجد' },
                { data: 'amount', name: 'amount' },
                { data: 'pay_method', name: 'pay_method' },
                { data: 'serial_no', name: 'serial_no' },
                { data: 'print_status_label', name: 'print_status_label', orderable: false, searchable: false },
                { data: 'description', name: 'description' },
                { data: 'date', name: 'date' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false },
                { data: null, name: 'archive_button', defaultContent: '', orderable: false, searchable: false },
                { data: null, name: 'select_checkbox', defaultContent: '<input type="checkbox">', orderable: false, searchable: false },
            ],
        });

        // Reload DataTable on month selection change
        $('#dateSelect').change(function () {
            $('#all-student1').DataTable().ajax.reload();
        });
    });
</script>


<script>
    function addUrlParameter(name, value) {
        const searchParams = new URLSearchParams(window.location.search);
        searchParams.set(name, value);
        window.location.search = searchParams.toString();
    }

    document.getElementById('select-all').addEventListener('change', function () {
        const checkboxes = document.querySelectorAll('input[name="action[]"]');
        checkboxes.forEach(checkbox => checkbox.checked = this.checked);
    });

    function handleBulkAction(button) {
        const actionValue = button.value;
        const selectedItems = Array.from(document.querySelectorAll('input[name="action[]"]:checked'))
            .map(checkbox => checkbox.value);

        if (selectedItems.length === 0) {
            alert('يجب اختيار عميل واحد على الأقل!');
            return;
        }

        const actionUrl = actionValue == 1 ? '/print_all' : '/archieve_all';
        const csrfToken = '{{ csrf_token() }}'; // Add CSRF token for security

        $.ajax({
            type: 'POST',
            url: `${actionUrl}/${selectedItems}`,
            headers: { 'X-CSRF-TOKEN': csrfToken },
            success: function (response) {
                if (response.redirect) {
                    window.location.href = response.redirect;
                }
            },
            error: function (error) {
                alert('حدث خطأ أثناء تنفيذ العملية');
            }
        });
    }
</script>
