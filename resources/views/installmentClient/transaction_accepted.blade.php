@extends('header.index')
@section('content')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css">

    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        <div class="flex items-center justify-between space-x-4 space-x-reverse py-5 lg:py-6">
            <ul class="hidden flex-wrap items-center space-x-2 space-x-reverse sm:flex">
                <li class="flex items-center space-x-2 space-x-reverse">
                    <a class="text-primary transition-colors hover:text-primary-focus dark:text-accent-light dark:hover:text-accent"
                        href="#">المعاملات المقدمة</a>
                    <svg x-ignore xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </li>
                <li>المتقدمين</li>
            </ul>

        </div>


        <div class=" filters ">
            <button
                class="btn border border-secondary font-medium text-secondary hover:bg-secondary hover:text-white focus:bg-secondary focus:text-white active:bg-secondary/90
            dark:text-secondary-light dark:hover:bg-secondary dark:hover:text-white dark:focus:bg-secondary dark:focus:text-white dark:active:bg-secondary/90 ml-3 mt-3
           ">
                العدد الكلي ({{ $data['counts']['transaction_acceptedCount'] }})
            </button>
           
        </div>
        <div class="card p-5">
            <div class="">
                <table id="users-table" class="users-table is-hoverable w-full text-center">
                    <thead class="text-center">
                        <tr class="text-center" style="text-align: center !important;">
                            <th scope="col">#</th>
                            <th scope="col"> اسم العميل</th>
                            <th scope="col">الوسيط</th>
                            <th scope="col">الراتب</th>
                            <th scope="col">الوظيفة</th>
                            <th scope="col">البنك</th>
                            <th scope="col">مجموع الاقساط</th>
                            <th scope="col"> التاريخ</th>
                            <th scope="col">انشأ بواسطة</th>
                            <th scope="col">تقديم</th>
                        </tr>
                    </thead>
                </table>
            </div>


        </div>

        </div>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
<!-- Include Moment.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

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
                        data: 'name_ar',
                        name: 'name_ar',
                        className: 'text-center'
                    },
                    {
                        data: 'boker',
                        name: 'boker',
                        className: 'text-center'
                    },
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
                    {
                        data: 'bank',
                        name: 'bank',
                        className: 'text-center'
                    },
                    {
                        data: 'installment_total',
                        name: 'installment_total',
                        className: 'text-center'
                    },
                   
                    // inquery
                    {
                        data: 'created_at',
                        name: 'created_at',
                        className: 'text-center',
                        render: function (data, type, row) {
                            return data ? moment(data).format('YYYY-MM-DD') : ''; // Adjust format as needed
                        }
                    },
                    // created_by
                    {
                        data: 'created_by',
                        name: 'created_by',
                        className: 'text-center'
                    },
                    // transaction_submited
                    
                    {
                        data: 'transaction_accepted',
                        name: 'transaction_accepted',
                        className: 'text-center'
                    },
        

                    
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
@endsection
