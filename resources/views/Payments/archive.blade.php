<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0">أرشيف عمليات الدفع</h4>
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
    <table id="users-table" class="table table-bordered border text-nowrap align-middle">
                <thead class="thead-dark">
                    <tr>
                    <th>م</th>
                    <th>اسم العميل</th>
                    <th>المبلغ</th>
                    <th>طريقة الدفع</th>
                    <th>رقم العملية</th>
                    <th>التفاصيل</th>
                    <th>التاريخ</th>
                    <th>استرجاع</th>
                    <!-- <th>تحويل للأرشيف</th> -->
                    </tr>
                </thead>
                
            </table>

        </div>
    </div>
</div>

<script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>

<script>
    function addUrlParameter(name, value) {
        const searchParams = new URLSearchParams(window.location.search);
        searchParams.set(name, value);
        window.location.search = searchParams.toString();
    }
;

// ///////////////////////////////////

</script>

<script type="text/javascript">
        $(document).ready(function() {
            // var status = '{{ request()->route('status') }}';
            $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('archive_payments.data') }}",
                    // data: {
                    //     status: status // Pass the status parameter
                    // }
                    
                data: function (d) {
                    d.month = $('#dateSelect').val(); // Pass selected month
                }
                },
                columns: [{
                    data: 'installment_id',
                    name: 'id',
                    className: 'text-center',
                    render: function(data, type, row) {
                        var url = 'installment/show-installment/' + data;
                        return `<a href="${url}">${data}</a>`;
                    }
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
                        data: 'serial_no',
                        name: 'serial_no',
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
                    {
                        data: 'actions',
                        name: 'actions',
                        className: 'text-center'
                    }
                    // {
                    //     data: 'archive_button',
                    //     name: 'archive_button',
                    //     className: 'text-center'
                    // },
                    
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
            $('#users-table').DataTable().ajax.reload();
        });
        });
           
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Set the default value to the current month (YYYY-MM format)
        const currentMonth = new Date().toISOString().slice(0, 7); // Get current month in 'YYYY-MM' format
        const dateSelect = document.getElementById('dateSelect');
        
        // Set the default value for the dropdown
        dateSelect.value = currentMonth;

    });

</script>