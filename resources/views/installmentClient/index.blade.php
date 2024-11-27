@extends('header.index')
@section('content')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css">

    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Include Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


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
            <a href="{{ route('installmentClient.index', 0) }}"
                class="btn border border-secondary font-medium text-secondary hover:bg-secondary hover:text-white focus:bg-secondary focus:text-white active:bg-secondary/90
            dark:text-secondary-light dark:hover:bg-secondary dark:hover:text-white dark:focus:bg-secondary dark:focus:text-white dark:active:bg-secondary/90 ml-3 mt-3
            {{ request()->route('status') === '0' ? 'bg-secondary text-white' : '' }}">
                العدد الكلي ({{ $data['counts']['total'] }})
            </a>
            <a href="{{ route('installmentClient.index', 'advanced') }}"
                class="btn border border-secondary font-medium text-secondary hover:bg-secondary hover:text-white focus:bg-secondary focus:text-white active:bg-secondary/90
                dark:text-secondary-light dark:hover:bg-secondary dark:hover:text-white dark:focus:bg-secondary dark:focus:text-white dark:active:bg-secondary/90 ml-3 mt-3
                {{ request()->route('status') === 'advanced' ? 'bg-secondary text-white' : '' }}">
                المتقدميين ({{ $data['counts']['advancedCount'] }})
            </a>
            <a href="{{ route('installmentClient.index', 'under_inquiry') }}"
                class="btn border border-secondary font-medium text-secondary hover:bg-secondary hover:text-white focus:bg-secondary focus:text-white active:bg-secondary/90
            dark:text-secondary-light dark:hover:bg-secondary dark:hover:text-white dark:focus:bg-secondary dark:focus:text-white dark:active:bg-secondary/90 ml-3 mt-3
            {{ request()->route('status') === 'under_inquiry' ? 'bg-secondary text-white' : '' }}">
                قيد الاستعلام ({{ $data['counts']['under_inquiryCount'] }})
            </a>
            <a href="{{ route('installmentClient.index', 'auditing') }}"
                class="btn border border-secondary font-medium text-secondary hover:bg-secondary hover:text-white focus:bg-secondary focus:text-white active:bg-secondary/90
            dark:text-secondary-light dark:hover:bg-secondary dark:hover:text-white dark:focus:bg-secondary dark:focus:text-white dark:active:bg-secondary/90 ml-3 mt-3
            {{ request()->route('status') === 'auditing' ? 'bg-secondary text-white' : '' }}">
                التدقسق القضائي
                ({{ $data['counts']['auditingCount'] }})
            </a>
            <a href="{{ route('installmentClient.index', 'car_inquiry') }}"
                class="btn border border-secondary font-medium text-secondary hover:bg-secondary hover:text-white focus:bg-secondary focus:text-white active:bg-secondary/90
            dark:text-secondary-light dark:hover:bg-secondary dark:hover:text-white dark:focus:bg-secondary dark:focus:text-white dark:active:bg-secondary/90 ml-3 mt-3
            {{ request()->route('status') === 'car_inquiry' ? 'bg-secondary text-white' : '' }}">
                استعلام السيارات ({{ $data['counts']['car_inquiryCount'] }})
            </a>
            <a href="{{ route('installmentClient.index', 'inquiry_done') }}"
                class="btn border border-secondary font-medium text-secondary hover:bg-secondary hover:text-white focus:bg-secondary focus:text-white active:bg-secondary/90
            dark:text-secondary-light dark:hover:bg-secondary dark:hover:text-white dark:focus:bg-secondary dark:focus:text-white dark:active:bg-secondary/90 ml-3 mt-3
            {{ request()->route('status') === 'inquiry_done' ? 'bg-secondary text-white' : '' }}">
                تم الاستعلام ({{ $data['counts']['inquiry_doneCount'] }})
            </a>
            <a href="{{ route('installmentClient.index', 'accepted') }}"
                class="btn border border-secondary font-medium text-secondary hover:bg-secondary hover:text-white focus:bg-secondary focus:text-white active:bg-secondary/90
            dark:text-secondary-light dark:hover:bg-secondary dark:hover:text-white dark:focus:bg-secondary dark:focus:text-white dark:active:bg-secondary/90 ml-3 mt-3
            {{ request()->route('status') === 'accepted' ? 'bg-secondary text-white' : '' }}">
                مقبول ({{ $data['counts']['acceptedCount'] }})
            </a>
            <a href="{{ route('installmentClient.index', 'accepted_condition') }}"
                class="btn border border-secondary font-medium text-secondary hover:bg-secondary hover:text-white focus:bg-secondary focus:text-white active:bg-secondary/90
            dark:text-secondary-light dark:hover:bg-secondary dark:hover:text-white dark:focus:bg-secondary dark:focus:text-white dark:active:bg-secondary/90 ml-3 mt-3
            {{ request()->route('status') === 'accepted_condition' ? 'bg-secondary text-white' : '' }}">
                مقبول بشرط ({{ $data['counts']['accepted_conditionCount'] }})
            </a>
            <a href="{{ route('installmentClient.index', 'rejected') }}"
                class="btn border border-secondary font-medium text-secondary hover:bg-secondary hover:text-white focus:bg-secondary focus:text-white active:bg-secondary/90
            dark:text-secondary-light dark:hover:bg-secondary dark:hover:text-white dark:focus:bg-secondary dark:focus:text-white dark:active:bg-secondary/90 ml-3 mt-3
            {{ request()->route('status') === 'rejected' ? 'bg-secondary text-white' : '' }}">
                مرفوض ({{ $data['counts']['rejectedCount'] }})
            </a>


        </div>
        <div class=" card-custom my-5 flex items-center justify-between">
            <div id="notesModal" class="modal" tabindex="-1" role="dialog" style="display: none;">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">الملاحظات</h5>
                            <button type="button" class="close" aria-label="Close" onclick="closeModal()">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>اليوزر </th>
                                        <th>الاتصال</th>
                                        <th>التاريخ</th>
                                        <th>الوقت</th>
                                        <th>الملاحظة </th>
                                    </tr>
                                </thead>
                                <tbody id="notesTableBody">
                                    <!-- Notes will be populated here -->
                                </tbody>
                            </table>
                             <!-- Form to add a new note -->
                <form id="addNoteForm" onsubmit="submitNoteForm(event)">
                    <div class="form-group">
                        <label for="reply">الاتصال</label>
                        <select id="reply" name="reply" class="form-control">
                            <option value="" disabled selected>الاتصال </option>
                            <option value="answered">رد</option>
                            <option value="refused">لم يرد</option>
                            <option value="note_under_info">ملاحظة</option>
                            <!-- Add more options as needed -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="note">الملاحظة</label>
                        <input type="text" id="note" name="note" class="form-control" placeholder="الملاحظة" required>

                    </div>
                    <input type="hidden" id="installment_clients_id" name="installment_clients_id">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">إضافة ملاحظة</button>
                    </div>
                </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" onclick="closeModal()">إغلاق</button>
                        </div>
                    </div>
                </div>
             </div>

            {{-- hanan --}} 
             <button class="btn me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4 " data-bs-toggle="modal"
                        data-bs-target="#bs-example-modal-md">
                        أضف جديد </button>

                        <div id="bs-example-modal-md" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                          <div class="modal-content">
                            <div class="modal-header d-flex align-items-center">
                              <h4 class="modal-title" id="myModalLabel">
                                أضف </h4>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                             <form action="{{ route('installmentClient.store') }}" method="POST"
                                                        enctype="multipart/form-data">
                                                        @csrf
                              <div class="row pt-3">
                                <div class="col-md-6">
                                  <div class="mb-3">
                                    <label class="form-label"> الإسم </label>
                                    <input type="text" id="name_ar" name="name_ar" class="form-control" />
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="mb-3">
                                    <label class="form-label"> الرقم المدني </label>
                                    <input type="text" id="civil_number" name="civil_number" class="form-control" />
                    
                                  </div>
                                </div>
                    
                                <div class="col-md-6">
                                  <div class="mb-3">
                                    <label class="form-label"> الهاتف </label>
                                    <input type="text" id="phone" class="form-control" name="phone"  />
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="mb-3">
                                    <label class="form-label"> الراتب </label>
                                    <input type="text" id="salary" class="form-control" name="salary"  />
                    
                                  </div>
                                </div>
                    
                                <div class="col-md-6">
                                  <div class="mb-3">
                                    <label class="form-label"> البنك </label>
                                    <select class="form-select" id="bank" name="bank_id">
                                      @foreach ($bank as $item)
                                                                            <option value="{{ $item->id }}">{{ $item->name_ar }}</option>
                                                                        @endforeach
                                    </select>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="mb-3">
                                    <label class="form-label"> المحافظة </label>
                                    <select class="form-select" name="governorate_id">
                                       @foreach ($government as $item)
                                                                            <option value="{{ $item->id }}">{{ $item->name_ar }}</option>
                                                                        @endforeach
                                    </select>
                    
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="mb-3">
                                    <label class="form-label"> المنطقة </label>
                                    <select class="form-select"  name="area_id">
                                       @foreach ($region as $item)
                                                                            <option value="{{ $item->id }}">{{ $item->name_ar }}</option>
                                                                        @endforeach
                                    </select>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="mb-3">
                                    <label class="form-label"> جهه العمل </label>
                                    <select class="form-select" id="work" name="ministry_id">
                                        @foreach ($ministry as $item)
                                                                            <option value="{{ $item->id }}">{{ $item->name_ar }}</option>
                                                                        @endforeach
                                    </select>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="mb-3">
                                    <label class="form-label"> مجموع الاقساط </label>
                                    <input type="text" name="installment_total"  class="form-control" />
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="mb-3">
                                    <label class="form-label"> الوسيط </label>
                                    <select class="form-select"  id="boker" name="boker_id">
                                      @foreach ($boker as $item)
                                                                            <option value="{{ $item->id }}">{{ $item->name_ar }}</option>
                                                                        @endforeach
                                    </select>
                                  </div>
                                </div>
                                <div class="col-md-12">
                                  <div class="mb-3">
                                    <label class="form-label"> الملاحظات </label>
                                    <input type="text" id="firstName" class="form-control" />
                                  </div>
                                </div>
                              </div>
                              </form>
                            </div>
                            <div class="modal-footer d-flex ">
                              <button type="submit" class="btn btn-primary">حفظ</button>
                              <button type="button" class="btn bg-danger-subtle text-danger  waves-effect" data-bs-dismiss="modal">
                                الغاء
                              </button>
                            </div>
                          </div>
                          <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                      </div>
                    


            <div class="flex">
                <div class="flex items-center" x-data="{ isInputActive: false }">
                    <label class="block">
                        <input x-effect="isInputActive === true && $nextTick(() => { $el.focus()});"
                            :class="isInputActive ? 'w-32 lg:w-48' : 'w-0'"
                            class="form-input bg-transparent px-1 text-left transition-all duration-100 placeholder:text-slate-500 dark:placeholder:text-navy-200"
                            placeholder="Search here..." type="text" />
                    </label>
                    <button @click="isInputActive = !isInputActive"
                        class="btn h-8 w-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </div>

            </div>
        </div>
        <div class="card p-5">
            <div class="">
                <table id="users-table" class="users-table is-hoverable w-full text-center">
                    <thead class="text-center">
                        <tr class="text-center">
                            <th scope="col">#</th>
                            <th scope="col"> اسم العميل</th>
                            <th scope="col">الوسيط</th>
                            <th scope="col">الراتب</th>
                            <th scope="col">الوظيفة</th>
                            <th scope="col">استعلام قضائى</th>
                            <th scope="col">البنك</th>
                            <th scope="col">استعلام</th>
                            <th scope="col">الارشيف</th>
                            {{-- <th scope="col">مجموع الاقساط</th> --}}
                            <th scope="col"> التاريخ</th>
                            <th scope="col">انشأ بواسطة</th>
                            <th scope="col">الملاحظات</th>
                            <th scope="col">مبلغ القبول</th>
                            {{-- <th scope="col">الاجراءات</th> --}}
                        </tr>
                    </thead>
                </table>
            </div>

                         <!-- Modal accept -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h3 class="text-base font-medium text-slate-700 dark:text-navy-100">التفاصيل</h3>
                                                <button type="button" class="btn-close" id="closeModalBtn" aria-label="Close">&times;</button>
                                            </div>
                                            <form id="modalForm" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="px-4 py-4 sm:px-5">
                                                        <div class="flex mt-4">
                                                            <label class="block mx-1">
                                                                <input class="form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                                                    placeholder="الحالة" type="text" name="status" value="accepted" />
                                                            </label>
                                                            <label class="block mx-1">
                                                                <input class="form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                                                    placeholder="السبب" type="text" name="reason" />
                                                            </label>
                                                           
                                                        </div>
                                                        <div class="flex mt-4">
                                                        <label class="block mx-1">
                                                                <input class="form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                                                    placeholder="مبلغ القبول" type="text" name="accept_cost" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" id="closeModalFooterBtn">اغلاق</button>
                                                    <button type="submit" class="btn btn-primary">حفظ</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal reject -->
                                <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h3 class="text-base font-medium text-slate-700 dark:text-navy-100">التفاصيل</h3>
                                                <!-- <button type="button" class="btn-close" id="closeModalBtn" aria-label="Close">&times;</button> -->
                                            </div>
                                            <form id="modalForm1" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="px-4 py-4 sm:px-5">
                                                        <div class="flex mt-4">
                                                            <label class="block mx-1">
                                                                <input class="form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                                                    placeholder="الحالة" type="text" name="status" value="rejected" />
                                                            </label>
                                                            <label class="block mx-1">
                                                                <input class="form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                                                    placeholder="السبب" type="text" name="reason" />
                                                            </label>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" id="closeModalFooterBtn1">اغلاق</button>
                                                    <button type="submit" class="btn btn-primary">حفظ</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

        </div>

        </div>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>

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
                    // installment_issue_count
                    {
                        data: 'installment_issue_count',
                        name: 'installment_issue_count',
                        className: 'text-center'
                    },
                    {
                        data: 'bank',
                        name: 'bank',
                        className: 'text-center'
                    },
                    {
                        data: 'inquery',
                        name: 'inquery',
                        className: 'text-center',
                        orderable: false,
                        searchable: false
                    },

                    {
                        data: 'archive',
                        name: 'archive',
                        className: 'text-center',
                        orderable: false,
                        searchable: false
                    },
                    // inquery
                    {
                        data: 'created_at',
                        name: 'created_at',
                        className: 'text-center',
                        render: function(data) {
                            // Use JavaScript's Date object to format the date
                            if (data) {
                                const date = new Date(data);
                                // Format as 'YYYY-MM-DD'
                                const formattedDate = date.getFullYear() + '-' +
                                    ('0' + (date.getMonth() + 1)).slice(-2) + '-' +
                                    ('0' + date.getDate()).slice(-2);
                                return formattedDate;
                            }
                            return ''; // Return empty if the date is not available
                        }
                    },
                    // created_by
                    {
                        data: 'created_by',
                        name: 'created_by',
                        className: 'text-center'
                    },
                    // note
                    {
                        data: 'note',
                        name: 'note',
                        className: 'text-center',
                        render: function(data, type, row) {
                    return '<button class="btn btn-sm btn-primary" onclick="fetchNotes(' + row.id + ')">الملاحظات</button>';
                },
            },
            {
                        data: 'acceptcost',
                        name: 'acceptcost',
                        className: 'text-center',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            // Check if the status is "accepted"
                            if (row.status === "accepted") {
                                return data; // Display the acceptcost value
                            }
                            return ''; // Return empty if the status is not "accepted"
                        }
                    }

                    // {
                    //     data: 'action',
                    //     name: 'action',
                    //     className: 'text-center',
                    //     orderable: false,
                    //     searchable: false
                    // }
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
            function fetchNotes(id) {
                $.ajax({
                    url: "{{ route('InstallmentClientNote.getall', '') }}/" + id,
                    method: 'GET',
                    success: function(data) {
                        // Assuming `data` is an array of notes
                        const notes = data.installmentClientNotes.data; // Adjust to access the array of notes
                        showModal2(notes); // Show the modal with the fetched notes
                    },
                    error: function(err) {
                        console.error(err);
                        alert('Failed to fetch notes.');
                    }
                });
            }

            function showModal2(notes) {
    const notesTableBody = document.getElementById('notesTableBody');
    notesTableBody.innerHTML = ''; // Clear previous notes

    // Check if notes is an array and has at least one element
    if (Array.isArray(notes) && notes.length > 0) {
        // Set the hidden input with the `installment_clients_id` from the first note
        document.getElementById('installment_clients_id').value = notes[0].installment_clients_id;

        // Populate the notes in the table
        notes.forEach(note => {
            const row = document.createElement('tr');

            // Map the `reply` values to more user-friendly terms
            note.reply = note.reply === 'note_under_info' ? 'ملاحظة' :
                         note.reply === 'refused' ? 'لم يرد' :
                         note.reply === 'answered' ? 'رد' : note.reply;

            // Create cells for each property
            const createdByCell = document.createElement('td');
            createdByCell.textContent = note.created_by;

            const replyCell = document.createElement('td');
            replyCell.textContent = note.reply;

            const dateCell = document.createElement('td');
            dateCell.textContent = note.date;

            const timeCell = document.createElement('td');
            timeCell.textContent = note.time;

            const noteCell = document.createElement('td');
            noteCell.textContent = note.note;

            // Append cells to the row
            row.appendChild(createdByCell);
            row.appendChild(replyCell);
            row.appendChild(dateCell);
            row.appendChild(timeCell);
            row.appendChild(noteCell);

            // Append the row to the table body
            notesTableBody.appendChild(row);
        });
    } else {
        // If notes is empty, show a message
        document.getElementById('installment_clients_id').value = ''; // Clear the hidden input
        notesTableBody.innerHTML = '<tr><td colspan="5">لا توجد ملاحظات متاحة.</td></tr>';
    }

    // Display the modal
    const modal = document.getElementById('notesModal');
    modal.style.display = 'block'; // Show the modal
}

            function submitNoteForm(event) {
                event.preventDefault(); // Prevent default form submission

                const reply = document.getElementById('reply').value;
                const note = document.getElementById('note').value;
                const installment_clients_id = document.getElementById('installment_clients_id').value;

                $.ajax({
                    url: '/InstallmentClientNote/store', // Your backend route for storing the note
                    method: 'POST',
                    data: {
                        reply: reply,
                        note: note,
                        installment_clients_id: installment_clients_id,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        console.log('Note added successfully:', response);
                        document.getElementById('addNoteForm').reset(); // Reset the form
                        fetchNotes(installment_clients_id); // Refresh the notes list
                    },
                    error: function(error) {
                        console.error('Error adding note:', error);
                        alert('Failed to add note. Please try again.');
                    }
                });
            }


            function closeModal() {
                const modal = document.getElementById('notesModal');
                modal.style.display = 'none'; // Hide the modal
            }

            // Close modal on clicking outside
            window.onclick = function(event) {
    const modal = document.getElementById('notesModal');
    if (event.target === modal) {
        closeModal();
    }
};
// modal accept
function openModal(id) {
    // Update the form action with the correct id
    $('#modalForm').attr('action', '/installmentClient/update/' + id);

    // Show the modal
    $('#exampleModal').modal('show');
}

// Close modal when "إغلاق" button is clicked
$('#closeModalBtn, #closeModalFooterBtn').on('click', function() {
    $('#exampleModal').modal('hide');
});

// modal reject
function openModal1(id) {
    // Update the form action with the correct id
    $('#modalForm1').attr('action', '/installmentClient/update/' + id);

    // Show the modal
    $('#exampleModal1').modal('show');
}

// Close modal when "إغلاق" button is clicked
$('#closeModalBtn1, #closeModalFooterBtn1').on('click', function() {
    $('#exampleModal1').modal('hide');
});

        </script>
@endsection
