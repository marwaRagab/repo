

<div class="card mt-4 py-3">
    <div class="d-flex flex-wrap ">
        <a class=" btn-filter me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4 mx-1 mb-2 "
            href="{{ route('installmentClient.index', 'advanced') }}">
            المتقدميين ({{ $data['counts']['advancedCount'] }})
        </a>
        <a class="btn-filter bg-info-subtle text-info  px-4 fs-4 mx-1 mb-2"
            href="{{ route('installmentClient.index', 'under_inquiry') }}">
            قيد الاستعلام ({{ $data['counts']['under_inquiryCount'] }})
        </a>
        <a class="btn-filter bg-warning-subtle text-warning px-4 fs-4 mx-1 mb-2"
            href="{{ route('installmentClient.index', 'auditing') }}">
            التدقيق القضائي ({{ $data['counts']['auditingCount'] }})
        </a>
        <a class="btn-filter  bg-success-subtle text-success px-4 fs-4 mx-1 mb-2"
            href="{{ route('installmentClient.index', 'car_inquiry') }}">
            استعلام السيارات ({{ $data['counts']['car_inquiryCount'] }})
        </a>
        <a class="btn-filter  bg-success-subtle text-success px-4 fs-4 mx-1 mb-2"
            href="{{ route('installmentClient.index', 'inquiry_done') }}">
            تم الاستعلام ({{ $data['counts']['inquiry_doneCount'] }})
        </a>

        <a class="btn-filter bg-danger-subtle text-danger px-4 fs-4 mx-1 mb-2"
            href="{{ route('installmentClient.index', 'accepted') }}">

            مقبول ({{ $data['counts']['acceptedCount'] }}) </a>
        <a class="btn-filter px-4 bg-primary-subtle text-primaryfs-4 mx-1 mb-2"
            href="{{ route('installmentClient.index', 'accepted_condition') }}">
            مقبول بشرط ({{ $data['counts']['accepted_conditionCount'] }}) </a>
        <a class="btn-filter bg-danger-subtle text-danger px-4 fs-4 mx-1 mb-2"
            href="{{ route('installmentClient.index', 'rejected') }}">
            مرفوض ({{ $data['counts']['rejectedCount'] }}) </a>

    </div>
</div>
<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0"> العملاء المتقدمين</h4>
        <div class="d-flex">
            <a href="{{ route('advanced.addnew') }}" class="btn me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4 " >
                أضف جديد </a>

            <a class="btn me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4 "
                href="{{ route('installmentClient.index', ['status' => 'archive']) }}">
                الارشيف </a>
            <a class="btn me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4 " href="{{ route('broker.index') }}">
                الوسطاء </a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive pb-4">
            <table id="users-table" class="table table-bordered border text-nowrap align-middle">
                <thead>
                    <!-- start row -->
                    <tr>
                        <th>#</th>
                        <th>اسم العميل</th>
                        {{-- <th>الرقم المدنى</th> --}}
                        <th>الهاتف</th>
                        <th>الوسيط </th>
                        <th>الراتب </th>
                        <th>الوظيفة</th>
                        @if (request()->route('status') === 'car_inquiry')
                            <th>استعلام سيارات</th>
                        @endif
                        @if (request()->route('status') === 'auditing' || request()->route('status') === 'under_inquiry')
                            <th>استعلام قضائي </th>
                        @endif
                        <th>استعلام</th>
                        <th>البنك </th>
                        <th> مجموع الاقساط </th>
                        <th> التاريخ</th>
                        @if (request()->route('status') === 'accepted')
                            <th>مبلغ القبول</th>
                        @endif
                        @if (request()->route('status') === 'rejected')
                            <th>سبب الرفض</th>
                        @endif
                        </tr>
                    </thead>
                </table>
            </div>

                       


        </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{-- <script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script> --}}

    <script type="text/javascript">
        $(document).ready(function() {
            var status = '{{ request()->route('status') }}';
            $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('installmentClient.getall', ':status') }}".replace(':status', status),
                    data: {
                        status: status // Pass the status parameter
                    }
                },
                columns: [{
                        data: 'id',
                        name: 'id',
                        className: 'text-center'
                    },
                    {
                        data: 'client',
                        name: 'client',
                       
                        className: 'text-center'
                        
                        
                    },
                    // {
                    //     data: 'civil_number',
                    //     name: 'civil_number',
                    //     className: 'text-center'
                       
                    // },

                  
                    {
                        data: 'phone',
                        name: 'phone',
                        className: 'text-center'
                    },
                    {
                        data: 'boker',
                        name: 'boker',
                        className: 'text-center'
                    },
                    // installment_issue_count
                    {
                        data: 'salary',
                        name: 'salary',
                        className: 'text-center'
                    },
                    {
                        data: 'ministry',
                        name: 'ministry',
                        className: 'text-center'
                    },

                    @if (request()->route('status') === 'car_inquiry')
                    { data: 'car', name: 'car', orderable: false, searchable: false },
                    @endif
                    // issue
                    @if (request()->route('status') === 'auditing' || request()->route('status') === 'under_inquiry')
                    { data: 'issue', name: 'issue', orderable: false, searchable: false },
                    @endif
                    // inquery
                    {
                        data: 'inquery',
                        name: 'inquery',
                        className: 'text-center'
                    },
                    // bank
                    {
                        data: 'bank',
                        name: 'bank',
                        className: 'text-center'
                    },
                    // installment_total
                    {
                        data: 'installment_total',
                        name: 'installment_total',
                        className: 'text-center'
                    },
                    // created_at
                    {
                        data: 'created_at',
                        name: 'created_at',
                        className: 'text-center'
                    },
                    @if (request()->route('status') === 'accepted')
                    { data: 'accept', name: 'accept', orderable: false, searchable: false },
                    @endif
                    @if (request()->route('status') === 'rejected')
                    { data: 'rejected', name: 'rejected', orderable: false, searchable: false },
                    @endif
                    
                ],
                


                "oLanguage": {
                    "sSearch": "",
                    "sSearchPlaceholder": "بحث",
                    "sInfo": 'اظهار صفحة _PAGE_ من _PAGES_',
                    "sInfoEmpty": 'لا توجد بيانات متاحه',
                    "sInfoFiltered": '(تم تصفية  من _MAX_ اجمالى البيانات)',
                    "sLengthMenu": 'اظهار _MENU_ عنصر لكل صفحة',
                    "sZeroRecords": 'نأسف لا توجد نتيجة',
                    "oPaginate": {
                        "sFirst": '<i class="fa fa-fast-backward" aria-hidden="true"></i>', // This is the link to the first page
                        "sPrevious": '<i class="fa fa-chevron-left" aria-hidden="true"></i>', // This is the link to the previous page
                        "sNext": '<i class="fa fa-chevron-right" aria-hidden="true"></i>', // This is the link to the next page
                        "sLast": '<i class="fa fa-step-forward" aria-hidden="true"></i>' // This is the link to the last page
                    }
                },
                layout: {
                    bottomEnd: {
                        paging: {
                            firstLast: false
                        }
                    }
                },
                "pagingType": "full_numbers",
                "fnDrawCallback": function(oSettings) {
                    console.log('Page ' + this.api().page.info().pages)
                    var page = this.api().page.info().pages;
                    console.log($('#users-table tr').length);
                    if (page == 1) {
                        //   $('.dataTables_paginate').hide();//css('visiblity','hidden');
                        $('.dataTables_paginate').css('visibility', 'hidden'); // to hide

                    }
                }
            });
        });
           
    </script>
