<div class="card mt-4 py-3">
    <div class="d-flex flex-wrap ">
        @if (request()->route('status') === 'submit_archive')
            <a class=" btn-filter me-1 mb-1 bg-primary-subtle text-primary px-4 mx-1 mb-2 "
                href="{{ route('myinstall.index', ['status' => 'submit_archive']) }}">
                العدد الكلي ({{ App\Models\Installment_Client::where('status', 'submit_archive')->count() }})
            </a>
        @else
            <a class=" btn-filter me-1 mb-1 bg-primary-subtle text-primary px-4 mx-1 mb-2 "
                href="{{ route('myinstall.index', ['status' => 'transaction_submited']) }}">
                العدد الكلي ({{ $data['counts']['transaction_submitedCount'] }})
            </a>
        @endif
    </div>
</div>

<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0"> المعاملات المقدمة</h4>
        <div class="d-flex">
            @if (request()->route('status') === 'submit_archive')
            @else
                <a class="btn me-1 mb-1 bg-primary-subtle text-primary px-4 "
                    href="{{ route('myinstall.index', ['status' => 'submit_archive']) }}">
                    الارشيف </a>
            @endif
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive pb-4">
            <table id="users-table" class="table table-bordered border text-nowrap align-middle">
                <thead>
                    <!-- start row -->

                    <th scope="col">#</th>
                        <th scope="col"> اسم العميل</th>
                        <th scope="col"> رقم المدنى</th>
                        <th scope="col"> رقم العميل</th>
                        <th scope="col">الوسيط</th>
                        <th scope="col">الراتب</th>
                        <th scope="col">الوظيفة</th>
                        <th scope="col">البنك</th>
                        <th scope="col">مجموع الاقساط</th>
                        <th scope="col"> التاريخ</th>
                        <th scope="col">تقديم</th>
                    </tr>

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
