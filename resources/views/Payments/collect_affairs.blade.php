<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0">التحصيل </h4>
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
    <table id="users-tables" class="table table-bordered border text-nowrap align-middle">
                <thead class="thead-dark">
                    <tr>
                    <th>م</th>
                    <th>اسم العميل</th>
                    <th>المبلغ</th>
                    <th>طريقة الدفع</th>
                    <th>التفاصيل</th>
                    <th>التاريخ</th>
                    </tr>
                </thead>
                
            </table>
        </div>
    </div>
</div>

<script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>

{{-- <script>
    function addUrlParameter(name, value) {
        const searchParams = new URLSearchParams(window.location.search);
        searchParams.set(name, value);
        window.location.search = searchParams.toString();
    }

    document.getElementById('select-all').addEventListener('change', function () {
    // Select all checkboxes within the table
    const checkboxes = document.querySelectorAll('#users-table input[name="action[]"]');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked; // Set checkbox state based on "select-all"
    });
});

// Ensure new rows are bound correctly after DataTable redraw
$('#users-table').on('draw.dt', function () {
    const selectAllCheckbox = document.getElementById('select-all');
    const checkboxes = document.querySelectorAll('#users-table input[name="action[]"]');

    // Sync "select-all" state with individual checkboxes
    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAllCheckbox.checked;
    });
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
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    $.ajax({
        type: 'POST',
        url: actionUrl,
        data: { items: selectedItems },
        headers: { 'X-CSRF-TOKEN': csrfToken },
        success: function (response) {
            alert(response.message || 'تم تنفيذ العملية بنجاح');
            $('#users-table').DataTable().ajax.reload();
        },
        error: function (error) {
            alert(error.responseJSON?.message || 'حدث خطأ أثناء تنفيذ العملية');
        }
    });
}
</script> --}}


<script type="text/javascript">
        $(document).ready(function() {
            // var status = '{{ request()->route('status') }}';
            $('#users-tables').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('payments.getcollect_affairsData') }}",
                  
                    
                data: function (d) {
                    d.month = $('#dateSelect').val(); // Pass selected month
                }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        className: 'text-center'
                    },
                    {
                        data: 'installment_name',
                        name: 'installment_name',
                       
                        className: 'text-center'
                        
                    },
                    {
                        data: 'amount',
                        name: 'amount',
                        className: 'text-center'
                       
                    },

                    {
                        data: 'pay_method',
                        name: 'pay_method',
                        className: 'text-center'
                    },
                   
                    {
                        data: 'description',
                        name: 'description',
                        className: 'text-center'
                    },

                    {
                        data: 'date',
                        name: 'date',
                        className: 'text-center'
                    },
                    
                    
                ],
                // language: {
                // url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json', // Arabic translations
                // }
                language: {
                "sProcessing": "جاري التحميل...",
                "sLengthMenu": "عرض _MENU_ سجل",
                "sZeroRecords": "لم يتم العثور على نتائج",
                "sEmptyTable": "لا توجد بيانات متاحة في هذا الجدول",
                "sInfo": "عرض السجلات من _START_ إلى _END_ من إجمالي _TOTAL_ سجل",
                "sInfoEmpty": "عرض السجلات من 0 إلى 0 من إجمالي 0 سجل",
                "sInfoFiltered": "(تمت التصفية من إجمالي _MAX_ سجل)",
                "sSearch": "بحث:",
                "oPaginate": {
                    "sFirst": "الأول",
                    "sPrevious": "السابق",
                    "sNext": "التالي",
                    "sLast": "الأخير"
                }
            },
            });
            // Reload DataTable on month selection change
        $('#dateSelect').change(function () {
            $('#users-tables').DataTable().ajax.reload();
        });
        });
           
    </script>