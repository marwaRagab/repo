<meta name="csrf-token" content="{{ csrf_token() }}">

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
    <table id="users-table" class="table table-bordered border text-nowrap align-middle">
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
                    <!-- <th>تحويل للأرشيف</th> -->
                    <th><input type="checkbox" class="form-check-input" id="select-all"></th>
                    </tr>
                </thead>
                
            </table>
            <button id="print-selected" value="1"  class="btn btn-primary"> طباعة</button>
            <!-- <button   class="btn btn-success test" value="1"    style="margin-right: 900px;     margin-bottom: -50px;"    onclick="valthisform(this);"  >طباعة</button> -->
                    <!-- <button   class="btn btn-danger test"  value="2"  style="margin-right: 1000px"  onclick="valthisform(this);"   >ارشفة</button> -->
                    <button class="btn btn-danger" value="2" id="archive-selected">ارشفة</button>

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

    document.getElementById('select-all').addEventListener('change', function () {
    // Select all checkboxes within the table
    const checkboxes = document.querySelectorAll('#users-table input[name="checkAll[]"]');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked; // Set checkbox state based on "select-all"
    });
});

$('#users-table').on('draw.dt', function () {
    const selectAllCheckbox = document.getElementById('select-all');
    const checkboxes = document.querySelectorAll('#users-table input[name="checkAll[]"]');
    
    // Sync "select-all" state with individual checkboxes
    const allChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);
    selectAllCheckbox.checked = allChecked; // Check the "select-all" if all checkboxes are selected

    // Optionally, you can disable "select-all" if there are no rows or rows without checkboxes
    selectAllCheckbox.disabled = checkboxes.length === 0;
});

// Ensure "select-all" checkbox works when the table is redrawn
$('#users-table').on('draw.dt', function () {
    const selectAllCheckbox = document.getElementById('select-all');
    const checkboxes = document.querySelectorAll('#users-table input[name="checkAll[]"]');
    
    // Sync the select-all checkbox with individual checkboxes
    const allChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);
    selectAllCheckbox.checked = allChecked;
});

function handleBulkAction(button) {
    const actionValue = button.value;
    const selectedItems = Array.from(document.querySelectorAll('input[name="checkAll[]"]:checked'))
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
// ///////////////////////////////////
function valthisform(button) {
    const checkboxes = document.getElementsByName("checkAll[]");
    const selectedCheckboxes = $('input[name="checkAll[]"]:checked');

    // Ensure at least one checkbox is selected
    if (selectedCheckboxes.length === 0) {
        alert("يجب اختيار عميل واحد على الاقل");
        return;
    }

    const arr = [];       // Array for items to print
    const arr_arch = [];  // Array for items to archive
    // const allserials = []; // Array for all selected serials

    // Loop through selected checkboxes
    let allserials = []; // Use let to allow reassignment

    selectedCheckboxes.each(function () {
        const checkbox = $(this);
        const value = Number(checkbox.val());
        const typeIdPrint = checkbox.data('print'); // Use data attribute

        if (!isNaN(value)) {
            if (typeIdPrint !== 'done') {
                arr.push(value);
                allserials.push(checkbox.attr('id')); // Push ID directly as string
            } else {
                arr_arch.push(value);
            }
        }
    });

    // Ensure all elements in allserials are strings (if needed)
    allserials = allserials.map(String);
    if (button.value == 1) {
        // Handle Print Action
        if (arr.length === 0) {
            alert("لا يوجد عناصر للطباعة");
            return;
        }

        console.log(allserials);

        $.ajax({
            type: 'GET',
            url: `print_all/${arr.join(',')}/${allserials.join(',')}`, // Construct URL dynamically
            headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    },
    success: function (response) {
                // const data = JSON.parse(response);
                console.log(response);
                if (response.redirect_url) {
                        window.location.href = response.redirect_url; // Redirect to the URL from the response
                    }

            },
            error: function (error) {
                console.error("Error in Print All:", error.responseText);
                alert("حدث خطأ أثناء الطباعة");
            },
        });
    } else if (button.value == 2) {
        // Handle Archive Action
        if (arr_arch.length === 0) {
            alert("لا يمكن الارشفة قبل الطباعة");
            return;
        }

        $.ajax({
            type: 'get',
            url: `/archieve_all/${arr_arch.join(',')}`, // Construct URL dynamically
            success: function (response) {
                const data = JSON.parse(response);
                console.log(data);
                window.location.href = data.redirect;
            },
            error: function (error) {
                console.error("Error in Archive All:", error.responseText);
                alert("حدث خطأ أثناء الأرشفة");
            },
        });
    }
}
///////////////////////////////

</script>

<script type="text/javascript">
        $(document).ready(function() {
            // var status = '{{ request()->route('status') }}';
            $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('payments.data') }}",
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
                        data: 'print_status_label',
                        name: 'print_status_label',
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
                    },
                    // {
                    //     data: 'archive_button',
                    //     name: 'archive_button',
                    //     className: 'text-center'
                    // },
                    
                    {
                        // data: 'select_checkbox',
                        // name: 'select_checkbox',
                        // className: 'text-center'
                        data: null,
            name: 'select_checkbox', 
            className: 'text-center',
            orderable: false,
            searchable: false,
                //    render: function(data, type, row) {
                    //    return `<input type="checkbox" data-print="${row.print_status}" name="checkAll[]" id="${row.serial_no}" value="${row.installment_id}" class="form-check-input">`;  
                    //},

                    render: function (data, type, row) {
                        return `<input type="checkbox" class="row-select" value="${row.installment_id}" data-print="${row.print_status}" data-serial="${row.serial_no}">`;
                    }
            }
                    
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
    $('#print-selected').on('click', function () {
    // const selectedIds = [];
    // $('.row-select:checked').each(function () {
    //     selectedIds.push($(this).val());
    // });

    const selectedIds = []; // Collect selected IDs from checkboxes
const serialNumbers = []; // Collect serial numbers if needed

$('.row-select:checked').each(function () {
    selectedIds.push($(this).val());
    serialNumbers.push($(this).data('serial'));
});

// Make sure there are selected IDs
if (selectedIds.length === 0) {
    alert('No rows selected.');
    return;
}

const ids = selectedIds.join(',');
const seriall = serialNumbers.join(',');

    // Send selected rows to the server or handle them on the client
    $.ajax({
        url: '/print_all/' + ids + '/' + seriall, // Define the print route in your backend
        type: 'GET',
        success: function (response) {

            // Open a new window for printing
            const printWindow = window.open('', '_blank');
            printWindow.document.write(response);
            // response.forEach(row => {
            //     printWindow.document.write(`<p>ID: ${row.installment_id}, Name: ${row.installment_name}, Amount: ${row.amount}</p>`);
            // });
            // printWindow.document.write('</body></html>');
            printWindow.document.close();
            // printWindow.print();
        },
        error: function (xhr) {
            console.error(xhr.responseText);
            alert('An error occurred while processing the request.');
        }
    });
});
// ///////
document.getElementById('archive-selected').addEventListener('click', function () {
    // Get selected checkbox values
    const selectedIds = Array.from(document.querySelectorAll('.row-select:checked'))
        .map(checkbox => checkbox.value);

    if (selectedIds.length === 0) {
        alert('يجب اختيار عميل واحد على الأقل!');
        return;
    }

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const ids = selectedIds.join(','); // Join IDs into a comma-separated string

    $.ajax({
        type: 'GET',
        // url: `/archieve_all/${ids}`, // Pass IDs in the URL
        url: '/archieve_all/' + ids,
        headers: { 'X-CSRF-TOKEN': csrfToken }, // Include CSRF token
        success: function (response) {
            console.log('Archived IDs:', selectedIds);
            alert( 'تم أرشفة العناصر بنجاح');

            // Reload the DataTable without resetting pagination
            $('#users-table').DataTable().ajax.reload(null, false);
        },
        error: function (xhr) {
            console.error('Archive Error:', xhr.responseText);
            alert('حدث خطأ أثناء الأرشفة');
        }
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