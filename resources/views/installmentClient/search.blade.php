

<!-- Search Form -->
<form action="{{ route('installments.search') }}" method="GET">
    <div class="card">
        <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
            <h4 class="card-title mb-0">البحث</h4>
        </div>
        <div class="card-body">
            <div class="row pt-3">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">رقم المعاملة</label>
                        <input type="text" name="transaction_number" class="form-control" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">اسم العميل</label>
                        <input type="text" name="client_name" class="form-control" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">الرقم المدني</label>
                        <input type="text" name="civil_id" class="form-control" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">رقم الهاتف</label>
                        <input type="text" name="phone_number" class="form-control" />
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="mb-3 d-flex justify-content-end">
                        <button type="submit" class="btn me-1 mb-1 bg-primary text-light px-4  mx-1 mb-2">بحث</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@if($searchPerformed)
    @if($results->isNotEmpty())
<div class="card-body">
    <div class="table-responsive pb-4">
        <table id="all-student" class="table table-bordered border text-nowrap align-middle">
            <thead>
                <!-- start row -->
                <tr>
                    <th>#</th>
                    <th>اسم العميل</th>
                    <th>الرقم المدنى</th>
                    <th>الهاتف</th>
                    <th>الوسيط </th>
                    <th>الراتب </th>
                    <th>الوظيفة</th>
                    <th>استعلام سيارات</th>
                    <th>استعلام قضائي </th>
                    <th>استعلام</th>
                    <th>البنك </th>
                    <th> مجموع الاقساط </th>
                    <th> التاريخ</th>
                    <th> المرحلة</th>
                    @if (request()->route('status') === 'accepted')
                        <th>مبلغ القبول</th>
                    @endif
                    @if (request()->route('status') === 'rejected')
                        <th>سبب الرفض</th>
                    @endif

                </tr>
                <!-- end row -->
            </thead>
            <tbody>
                <!-- start row -->
                @foreach ($results as $item)
                    <tr>
                        <td>
                            {{ $loop->index + 1 }}
                        </td>
                        <td>
                            {{ $item->name_ar }}
                        </td>
                        <td>
                            {{ $item->civil_number }}
                        </td>
                        <td>
                            {{ $item->phone }}
                        </td>
                        <td>
                            {{ $item->installmentBroker->name }}
                        </td>
                        <td>{{ $item->salary }} </td>
                        <td>{{ $item->ministry_working->name_ar ?? 'لا يوجد' }}</td>
                        <td>
                            <div class="d-block">
                                <div>
                                    <a class="btn me-1 mb-1 bg-primary-subtle text-primary px-4 "
                                        data-bs-toggle="modal" data-bs-target="#car-modal-md"
                                        data-id="{{ $item->id }}" data-name="{{ $item->name_ar }}">
                                        استعلام سيارات ({{App\Models\InstallmentCar::where('installment_clients_id', $item->id)->count()}})</a>
                                </div>

                            </div>
                        </td>
                        <td>
                            <div class="d-block">
                                <h6>
                                    @if ($item->installment_issue->isNotEmpty() || $item->installment_issue->count() > 0)
                                        <h6>{{ $item->installment_issue->first()->date }}</h6>
                                    @else
                                        <h6>لا يوجد استعلام قضائى</h6>
                                    @endif
                                </h6>
                                <div>
                                    <a class="btn me-1 mb-1 bg-primary-subtle text-primary px-4 "
                                        data-bs-toggle="modal" data-bs-target="#estlaam-modal-md"
                                        data-id="{{ $item->id }}" data-name="{{ $item->name_ar }}">
                                        استعلام قضائي ({{App\Models\InstallmentIssue::where('installment_clients_id', $item->id)->count()}})</a>
                                </div>
                                <div>
                                    <a class="btn me-1 mb-1 bg-primary-subtle text-primary px-4 "
                                        href="{{ $item->issue_pdf }}"download="issue.pdf">
                                        صوره الاستعلام </a>
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="btn-group mb-6 me-6 d-block">
                                <button class="btn btn-secondary dropdown-toggle" type="button"
                                    id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    نتيجة الاستعلام </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li>
                                        <form action="{{ route('myinstall.update', $item->id) }}" method="post"
                                            style="display:inline;">
                                            @csrf
                                            <input type="hidden" name="status" value="under_inquiry">
                                            <button class="btn btn-success rounded-0 w-100 mt-2" type="submit">
                                                قيد الاستعلام
                                            </button>
                                        </form>
                                    </li>
                                    <li>
                                        <form action="{{ route('myinstall.update', $item->id) }}" method="post"
                                            style="display:inline;">
                                            @csrf
                                            <input type="hidden" name="status" value="auditing">
                                            <button class="btn btn-success rounded-0 w-100 mt-2" type="submit">
                                                التدقيق القضائي</button>
                                        </form>
                                    </li>
                                    <li>
                                        <form action="{{ route('myinstall.update', $item->id) }}" method="post"
                                            style="display:inline;">
                                            @csrf
                                            <input type="hidden" name="status" value="car_inquiry">
                                            <button class="btn btn-success rounded-0 w-100 mt-2" type="submit">
                                                استعلام سيارات
                                            </button>
                                        </form>
                                    </li>
                                    <li>
                                        <form action="{{ route('myinstall.update', $item->id) }}" method="post"
                                            style="display:inline;">
                                            @csrf
                                            <input type="hidden" name="status" value="inquiry_done">
                                            <button class="btn btn-success rounded-0 w-100 mt-2" type="submit">
                                                تم الاستعلام</button>
                                        </form>
                                    </li>
                                    <li>
                                        <a class="btn btn-info rounded-0 w-100 mt-2" data-bs-toggle="modal"
                                        data-bs-target="#acceptcondition-modal-md" data-id="{{ $item->id }}"
                                        data-name="{{ $item->name_ar }}" type="submit">
                                        مقبول بشرط </a>
                                      
                                    </li>
                                    <li>
                                        <a class="btn btn-info rounded-0 w-100 mt-2" data-bs-toggle="modal"
                                            data-bs-target="#accept-modal-md" data-id="{{ $item->id }}"
                                            data-name="{{ $item->name_ar }}" type="submit">
                                            مقبول </a>

                                        </form>
                                    </li>
                                    <li>
                                        <a class="btn btn-warning rounded-0 w-100 mt-2" data-bs-toggle="modal"
                                            data-bs-target="#reject-modal-md" data-id="{{ $item->id }}"
                                            data-name="{{ $item->name_ar }}" type="submit">
                                            مرفوض</a>
                                    </li>

                                </ul>
                            </div>
                            <div>
                                @if ($item->status == 'archive')
                                    <button class="btn btn-danger" disabled>
                                        تمت الارشفة
                                    </button>
                                @else
                                    <form action="{{ route('myinstall.update', $item->id) }}" method="post"
                                        style="display:inline;">
                                        @csrf
                                        <input type="hidden" name="status" value="archive">
                                        {{-- <a class="btn btn-secondary w-100 mt-2" data-bs-toggle="modal" data-bs-target="#archive"> --}}
                                        <button class="btn btn-success rounded-1 w-100 mt-2" type="submit">

                                            تحويل للارشيف</button>
                                    </form>
                                @endif

                                </li>
                        </td>
                        <td>
                        {{ $item->bank->name_ar ?? 'لا يوجد' }}
                        </td>
                        <td>
                            {{ $item->installment_total }}
                        </td>
                        <td>
                            <div class="block">
                                <h5>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</h5>
                                <a class="btn btn-secondary w-100 mt-2" data-bs-toggle="modal"
                                    data-bs-target="#open-details" data-id="{{ $item->id }}"
                                    data-name="{{ $item->name_ar }}">

                                    الملاحظات</a>
                            </div>

                        </td>
                        <td>
                            @if ( $item->status == 'advanced' )
                            المتقدمين
                            @elseif ($item->status == 'under_inquiry')
                            قيد الاستعلام
                            @elseif ($item->status == 'auditing')
                            التدقيق القضائى
                            @elseif ($item->status == 'car_inquiry')
                            استعلام سيارات
                            @elseif ($item->status == 'inquiry_done')
                            تم الاستعلام
                            @elseif ($item->status == 'accepted')
                            مقبول
                            @elseif ($item->status == 'accepted_condition')
                            مقبول بشرط
                            @elseif ($item->status == 'rejected')
                            مرفوض
                            @elseif ($item->status == 'transaction_submited')
                            المعاملات المقدمة
                            @elseif ($item->status == 'transaction_accepted')
                            المعاملات المقبولة
                            @endif
                        </td>
                        @if (request()->route('status') === 'accepted')
                            <td>
                                <h5>{{ $item->accept_cost }}</h5>
                                <a class="btn btn-secondary w-100 mt-2"
                                    href="{{ route('installmentsubmission.index', $item->id) }}">
                                    تقديم الاقساط</a>
                            </td>
                        @endif
                        @if (request()->route('status') === 'rejected')
                            <td>{{ $item->reason }}</td>
                        @endif
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</div>

@else
        <div class="alert alert-warning mt-4">
            لا توجد نتائج مطابقة للبحث.
        </div>
    @endif
@endif

<div id="estlaam-modal-md" class="modal fade" tabindex="-1" aria-labelledby="estlaam-modal-md"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable scollable modal-lg" >
            <div class="modal-content" style="overflow: auto !important;">
                <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="myModalLabel">
                        استعلام قضائي </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('installmentIssue.store') }}" id="issueModelform" method="POST" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="installment_clients_id" id="installment_clients_id" value="">
                    <div class="modal-body">

                        <h5>معاملة جديدة <span class="text-info"> </span></h5>


                        <div class="form-row row" data-index="0">
                            <div class="form-group mb-3 col-6">
                                <label class="form-label"> ملف القضية </label>
                                    <input type="file" id="issue_pdf" name="issue_pdf" accept=".pdf" class="form-control" required />
                            </div>
                        </div>

                        <div class="form-group col-12">
                            <label class="form-label"> هل لديه قضايا ؟ </label>
                            <div class="form-check-inline">
                                <input type="radio" name="exist1" id="exist1" value="exist">
                                <label for="exist">يوجد</label>
                            </div>
                            <div class="form-check-inline">
                                <input type="radio" name="exist1" id="notexist1" value="notexist" checked>
                                <label for="status_close">لا يوجد</label>
                            </div>
                        </div>


                        <div id="formRows">
                            <div class="form-row row issue-row" data-index="0">
                                <div class="form-group mb-3 col-6">
                                    <label class="form-label"> رقم القضية </label>
                                        <input type="text" name="installment_issue[0][number_issue]"
                                            class="form-control" required />
                                </div>
                                <div class="form-group mb-3 col-6">
                                    <label class="form-label"> الجهة  </label>
                                    <input type="text" name="installment_issue[0][working_company]"
                                        class="form-control" required />
                                </div>
                                <div class="form-group mb-3 col-6">
                                    <label class="form-label"> مبلغ المفتوح  </label>
                                    <input type="text" name="installment_issue[0][opening_amount]"
                                        class="form-control" required />
                                </div>
                                <div class="form-group mb-3 col-6">
                                    <label class="form-label"> مبلغ المغلق  </label>
                                    <input type="text" name="installment_issue[0][closing_amount]"
                                        class="form-control" required />
                                </div>
                                <div class="form-group mb-3 col-6">
                                        <label class="form-label">  صورة القضية  </label>
                                        <input class="form-control" type="file" name="installment_issue[0][image]" required />
                                    </div>

                                    <div class="form-group col-6">
                                    <label class="form-label">  التاريخ </label>
                                    <input type="date" name="installment_issue[0][date]" class="form-control"
                                        required />
                                </div>
                                <div class="form-group col-12">
                                    <label class="form-label"> الحالة  </label>
                                    <div class="form-check-inline">
                                         <input class="" type="radio" name="installment_issue[0][status]"
                                            id="flexRadioDefault1">
                                        <label class="" for="flexRadioDefault1">
                                            مفتوح
                                        </label>


                                    </div>
                                    <div class="form-check-inline">
                                        <input class="" type="radio" name="installment_issue[0][status]"
                                            id="flexRadioDefault2" value="close" checked>
                                        <label class="" for="flexRadioDefault2">
                                            مغلق
                                        </label>


                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 d-flex align-items-center border-top pt-3">
                            {{-- <button type="button" class="btn btn-danger remove-row-btn ">حذف </button> --}}
                            <button type="button" class="btn btn-secondary mx-2" id="addRowBtn1">اضافة قضية
                                جديدة</button>
                        </div>
                        <div class="form-row" id ="total">
                            <div class="form-group">
                                <label class="form-label"> مجموع المفنوح  </label>
                                <input type="text" name="opening_total" id="opening_total" class="form-control"
                                    readonly />
                            </div>
                            <div class="form-group">
                                <label class="form-label"> مجموع المغلق </label>
                                <input type="text" name="closing_total" id="closing_total" class="form-control"
                                    readonly />
                            </div>
                            <div class="form-group">
                                <label class="form-label"> مجموع الكلي </label>
                                <input type="text" id="totalll" name="total_IC" class="form-control"
                                    readonly />
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer d-flex ">
                        <button type="button" class="btn btn-primary" id="saveissue" onclick="validateIssueModalForm()">حفظ</button>
                        <button type="button" class="btn bg-danger-subtle text-danger  waves-effect"
                            data-bs-dismiss="modal">
                            الغاء
                        </button>
                    </div>
                </form>
            </div>


            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
        <!-- open file model  -->
    <div id="open-file" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-lg">
                    <div class="modal-content">
                        <div class="modal-header d-flex align-items-center">
                            <h4 class="modal-title" id="myModalLabel">
                                إثبات حالة</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label class="form-label"> تاريخ </label>
                                        <input type="date" class="form-control mb-2" id="input1">
                                    </div>
                                    <div class="form-group">
                                        <label for="formFile" class="form-label">اختر صورة </label>
                                        <input class="form-control" type="file" id="formFile" />
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer d-flex ">
                            <button type="submit" class="btn btn-primary">حفظ وتحويل لأعلان التنفيذ</button>
                            <button type="button" class="btn bg-danger-subtle text-danger  waves-effect"
                                data-bs-dismiss="modal">
                                الغاء
                            </button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
    <!-- sample modal content -->
    {{-- <button class="btn me-1 mb-1 bg-primary-subtle text-primary px-4 " data-bs-toggle="modal"
    data-bs-target="#bs-example-modal-md">
    أضف جديد </button> --}}

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
            <form id="installment-form" action="{{ route('installmentClient.store') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
            <div class="row pt-3">
                <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label"> الإسم </label>
                    <input type="text" id="name_ar" name="name_ar" class="form-control" required/>
                </div>
                </div>
                <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label"> الرقم المدني </label>
                    <input type="text" id="civil_number" name="civil_number" class="form-control" required/>

                </div>
                </div>

                <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label"> الهاتف </label>
                    <input type="text" id="phone" class="form-control" name="phone"  required/>
                </div>
                </div>
                <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label"> الراتب </label>
                    <input type="text" id="salary" class="form-control" name="salary"  required/>

                </div>
                </div>

                <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label"> البنك </label>
                    <select class="form-select" id="bank" name="bank_id" required>
                    @foreach ($bank as $item)
                        <option value="{{ $item->id }}">{{ $item->name_ar }}</option>
                    @endforeach
                    </select>
                </div>
                </div>
                <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label"> المحافظة </label>
                    <select class="form-select" name="governorate_id" required>
                    @foreach ($government as $item)
                        <option value="{{ $item->id }}">{{ $item->name_ar }}</option>
                    @endforeach
                    </select>

                </div>
                </div>
                <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label"> المنطقة </label>
                    <select class="form-select"  name="area_id" required>
                    @foreach ($region as $item)
                        <option value="{{ $item->id }}">{{ $item->name_ar }}</option>
                    @endforeach
                    </select>
                </div>
                </div>
                <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label"> جهه العمل </label>
                    <select class="form-select" id="work" name="ministry_id" required>
                        @foreach ($ministry as $item)
                            <option value="{{ $item->id }}">{{ $item->name_ar }}</option>
                        @endforeach
                    </select>
                </div>
                </div>
                <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label"> مجموع الاقساط </label>
                    <input type="text" name="installment_total" id="installment_total" class="form-control" required/>
                </div>
                </div>
                <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label"> الوسيط </label>
                    <select class="form-select"  id="boker" name="boker_id"required>
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
            <button type="button" class="btn btn-primary" onclick="validateForm()">حفظ</button>
            <button type="button" class="btn bg-danger-subtle text-danger  waves-effect" data-bs-dismiss="modal">
                الغاء
            </button>
            </div>
        </div>
        <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    {{-- HR --}}

    <!-- car model  -->
    <div id="car-modal-md" class="modal fade" tabindex="-1" aria-labelledby="car-modal-md" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content" style="overflow: auto !important;">
                <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="myModalLabel">
                        استعلام سيارات </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('InstallmentCar.store') }}" id="CarModelform" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <h5 class="mb-3">معاملة جديدة <span class="text-info"></span></h5>
                        <input type="hidden" name="installment_clients_id" id="installment_clients_id" value="">
                        <div class="form-group col-12">
                            <label class="form-label"> هل لديه سياره ؟ </label>
                            <div class="form-check-inline">
                                <input type="radio" name="exist" id="exist" value="exist">
                                <label for="exist">يوجد</label>
                            </div>
                            <div class="form-check-inline">
                                <input type="radio" name="exist" id="notexist" value="notexist" checked>
                                <label for="status_close">لا يوجد</label>
                            </div>
                        </div>

                        <div id="formRows1">
                            <div class="form-row car-row" data-index="0">
                                <div class="form-group mb-3">
                                    <label class="form-label"> نوع السيارة</label>
                                    <input type="text" name="installment_car[0][type_car]" id="type_car" class="form-control"
                                        placeholder="نوع السيارة"  />
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label">  سنة الموديل </label>
                                    <input type="text" name="installment_car[0][model_year]" id="model_year" class="form-control"
                                        placeholder="سنة الموديل"  />
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label">   متوسط السعر </label>
                                       <input type="text" name="installment_car[0][average_price]" id="average_price"
                                        class="form-control" placeholder="متوسط السعر"  />
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label">   الصورة </label>
                                        <input type="file" name="installment_car[0][image]" id="image" class="form-control"
                                        placeholder="صورة"  />
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex ">
                        <button type="button" class="btn btn-secondary" id="addRowBtn">اضافة سيارة جديدة</button>
                        <button type="button" class="btn btn-primary" id="savecar"  onclick="validateCarModalForm()" >حفظ</button>
                        <button type="button" class="btn bg-danger-subtle text-danger  waves-effect"
                            data-bs-dismiss="modal">
                            الغاء
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- accept condition --}}

    <div id="acceptcondition-modal-md" class="modal fade" tabindex="-1" aria-labelledby="acceptcondition-modal-md"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="myModalLabel">نتيجة الاستعلام</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="accept-form" action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="item_id" id="item-id"> <!-- Hidden field for item ID -->
                    <div class="modal-body">
                        <div id="formRows">
                            <div class="px-4 py-4 sm:px-5">
                                <div class="flex mt-4">
                                    <label class="block mx-1">
                                        <input
                                            class="form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="الحالة" type="text" name="status" value="accepted_condition"
                                            readonly />
                                    </label>
                                    <label class="block mx-1">
                                        <input
                                            class="form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="السبب" type="text" name="reason" />
                                    </label>
                                </div>
                                {{-- <div class="flex mt-4">
                                    <label class="block mx-1">
                                        <input
                                            class="form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="مبلغ القبول" type="text" name="accept_cost" />
                                    </label>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex ">
                        <button type="submit" class="btn btn-primary">حفظ</button>
                        <button type="button" class="btn bg-danger-subtle text-danger waves-effect"
                            data-bs-dismiss="modal">
                            الغاء
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Accept Modal -->
    <div id="accept-modal-md" class="modal fade" tabindex="-1" aria-labelledby="accept-modal-md"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="myModalLabel">نتيجة الاستعلام</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="accept1-form" action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="item_id" id="item-id"> <!-- Hidden field for item ID -->
                    <div class="modal-body">
                        <div id="formRows">
                            <div class="px-4 py-4 sm:px-5">
                                <div class="flex mt-4">
                                    <label class="block mx-1">
                                        <input
                                            class="form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="الحالة" type="text" name="status"  style="display:none;" value="accepted"
                                            readonly />
                                    </label>
                                    {{-- <label class="block mx-1">
                                        <input
                                            class="form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="السبب" type="text" name="reason" />
                                    </label> --}}
                                    <label class="block mx-1">مبلغ القبول </label>
                                        <input
                                            class="form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="مبلغ القبول" type="text" name="accept_cost" />

                                </div>
                               
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex ">
                        <button type="submit" class="btn btn-primary">حفظ</button>
                        <button type="button" class="btn bg-danger-subtle text-danger waves-effect"
                            data-bs-dismiss="modal">
                            الغاء
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- reject Modal -->
    <div id="reject-modal-md" class="modal fade" tabindex="-1" aria-labelledby="reject-modal-md"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="myModalLabel">نتيجة الاستعلام</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="reject-form" action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="item_id" id="item-id"> <!-- Hidden field for item ID -->
                    <div class="modal-body">
                        <div id="formRows">
                            <div class="px-4 py-4 sm:px-5">
                                <div class="flex mt-4">
                                    <label class="block mx-1">
                                        <input
                                            class="form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="الحالة" type="text" name="status" value="rejected"
                                            readonly />
                                    </label>
                                    <label class="block mx-1">
                                        <input
                                            class="form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="السبب" type="text" name="reason" />
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex ">
                        <button type="submit" class="btn btn-primary">حفظ</button>
                        <button type="button" class="btn bg-danger-subtle text-danger waves-effect"
                            data-bs-dismiss="modal">
                            الغاء
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- notes model  -->
    <div id="open-details" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="myModalLabel">
                        ملاحظات  </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-pills" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#navpill-1" role="tab">
                                <span>الملاحظات</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#navpill-2" role="tab">
                                <span>الرد</span>
                            </a>
                        </li>

                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content border mt-2">
                        <div class="tab-pane active p-3" id="navpill-1" role="tabpanel">
                            
                            <table id="notes1" class="table table-bordered border text-wrap align-middle">
                                <thead>
                                    <!-- start row -->
                                    <tr>
                                        <th>اليوزر</th>
                                        <th>الاتصال</th>
                                        <th>الساعة</th>
                                        <th>التاريخ</th>
                                        <th> الملاحظه</th>

                                    </tr>
                                    <!-- end row -->
                                </thead>
                                <tbody>
                                    <!-- start row -->

                                </tbody>
                            </table>
                            <h3>ملاحظات القضايا</h3>
                            <table id="notesissue" class="table table-bordered border text-wrap align-middle">
                                <thead>
                                    <!-- start row -->
                                    <tr>
                                        <th>اليوزر</th>
                                        <th>رقم القضية</th>
                                        <th>الحالة</th>
                                        <th>الجهة</th>
                                        <th>المبلغ</th>
                                        <th> التاريخ</th>



                                    </tr>
                                    <!-- end row -->
                                </thead>
                                <tbody>
                                    <!-- start row -->

                                </tbody>
                            </table>
                            <h3>ملاحظات السيارات</h3>
                            <table id="notescar" class="table table-bordered border text-wrap align-middle">
                                <thead>
                                    <!-- start row -->
                                    <tr>
                                        <th>اليوزر</th>
                                        <th>النوع</th>
                                        <th>السنة</th>
                                        <th> متوسط  السعر</th>

                                    </tr>
                                    <!-- end row -->
                                </thead>
                                <tbody>
                                    <!-- start row -->

                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane p-3" id="navpill-2" role="tabpanel">
                            <form id="addNoteForm" onsubmit="submitNoteForm(event)">
                                <div class="form-row">
                                    <div class="form-group">
                                        <label class="form-label"> الاتصال</label>
                                        <select class="form-select" id="reply" name="reply">
                                            <option value="answered">
                                                رد </option>
                                            <option value="refused">
                                                لم يرد </option>
                                            <option value="note_under_info">
                                                ملاحظة </option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <div class="my-3">
                                            <label class="form-label">الملاحظات</label>
                                            <textarea class="form-control" rows="5" id="note" name="note"></textarea>
                                            <input type="hidden" id="installment_client_id"
                                                name="installment_clients_id" value="{{ $item->id }}">

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">إضافة ملاحظة</button>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex ">
                <!-- <a class="btn btn-primary" href="../installments/show-installment.html"> تفصيل المعاملة</a> -->
                <button type="button" class="btn bg-danger-subtle text-danger  waves-effect"
                    data-bs-dismiss="modal">
                    إغلاق
                </button>
            </div>
        </div>
    </div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>

document.addEventListener("DOMContentLoaded", function () {
            // Get radio buttons and extra form row
            const statusOpen = document.getElementById("exist");
            const statusClose = document.getElementById("notexist");
            const extraFormRow = document.getElementById("formRows1");

            //
            // addRowBtn
            const addRowBtn = document.getElementById("addRowBtn");

            // Function to toggle form row visibility
            function toggleFormRow() {
                if (statusOpen.checked) {
                    extraFormRow.style.display = "block"; // Show form row
                    addRowBtn.style.display='block';

                } else {
                    extraFormRow.style.display = "none"; // Hide form row
                    addRowBtn.style.display='none';


                }
            }

            // Add event listeners to radio buttons
            statusOpen.addEventListener("change", toggleFormRow);
            statusClose.addEventListener("change", toggleFormRow);

            // Initial check in case the page is loaded with "open" selected
            toggleFormRow();
        });

        document.addEventListener("DOMContentLoaded", function () {
            // Get radio buttons and extra form row
            const statusOpen1 = document.getElementById("exist1");
            const statusClose1 = document.getElementById("notexist1");
            const extraFormRowIsuue = document.getElementById("formRows");
            //
            // addRowBtn
            const addRowBtnIssue = document.getElementById("addRowBtn1");
            // Function to toggle form row visibility
            function toggleFormRow1() {
                if (statusOpen1.checked) {
                    extraFormRowIsuue.style.display = "block"; // Show form row
                    addRowBtnIssue.style.display='block';
                } else {
                    extraFormRowIsuue.style.display = "none"; // Show form row
                    addRowBtnIssue.style.display='none';

                }
            }

            // Add event listeners to radio buttons
            statusOpen1.addEventListener("change", toggleFormRow1);
            statusClose1.addEventListener("change", toggleFormRow1);

            // Initial check in case the page is loaded with "open" selected
            toggleFormRow1();
        });


    function validateForm() {
        const name = document.getElementById('name_ar').value.trim();
        const civilNumber = document.getElementById('civil_number').value.trim();
        const phone = document.getElementById('phone').value.trim();
        const salary = document.getElementById('salary').value.trim();
        const installmentTotal = document.getElementById('installment_total').value.trim();

        // Validate fields
        if (name === "") {
            alert("يرجى إدخال الإسم.");
            return false;
        }
        if (civilNumber.length < 8 || civilNumber.length > 12) {
            alert("يجب أن يتكون الرقم المدني من  12 رقم.");
            return false;
        }
        if (phone === "") {
            alert("يرجى إدخال الهاتف.");
            return false;
        }
        if (salary === "" || isNaN(salary)) {
            alert("يرجى إدخال راتب صالح.");
            return false;
        }
        if (installmentTotal === "") {
            alert("يرجى إدخال مجموع الاقساط.");
            return false;
        }
        // If all validations pass, submit the form
        document.getElementById('installment-form').submit();
    }

    function validateCarModalForm() {

        const statusOpen = document.getElementById("exist");
        if (statusOpen.checked) {
            const formRows = document.getElementById('formRows1');
            const rows = formRows.querySelectorAll('.car-row');
            // console.log(rows);
            for (const r of rows) {
                    const typeCar = r.querySelector('input[name$="[type_car]"]').value.trim();
                    const modelYear = r.querySelector('input[name$="[model_year]"]').value.trim();
                    const averagePrice = r.querySelector('input[name$="[average_price]"]').value.trim();
                    const image = r.querySelector('input[name$="[image]"]').value.trim();

                    if (!typeCar) {
                        alert("يرجى إدخال نوع السيارة.");
                        return false;
                    }
                    if (!modelYear) {
                        alert("يرجى إدخال موديل السيارة.");
                        return false;
                    }
                    if (!averagePrice) {
                        alert("يرجى إدخال متوسط السعر.");
                        return false;
                    }
                    if (!image) {
                        alert("يرجى إدخال الصورة.");
                        return false;
                    }
                }


        // If all validations pass, submit the form
        document.getElementById('CarModelform').submit();
        }
        else {
            document.getElementById('savecar').setAttribute("data-bs-dismiss", "modal");
        }
    }

    function validateIssueModalForm() {

        const statusOpen1 = document.getElementById("exist1");
        const issue_pdf = document.getElementById('issue_pdf').value.trim();
        if (statusOpen1.checked) {
            const formRows1 = document.getElementById('formRows');
            const rows1 = formRows1.querySelectorAll('.issue-row');

            console.log(rows1);


            if (!issue_pdf) {
                alert("يرجى إدخال  ملف القضية.");
                return false;
            }
            // console.log(rows);
            for (const row of rows1) {
                    const number_issue = row.querySelector('input[name$="[number_issue]"]').value.trim();
                    const working_company = row.querySelector('input[name$="[working_company]"]').value.trim();
                    const date = row.querySelector('input[name$="[date]"]').value.trim();
                    const image = row.querySelector('input[name$="[image]"]').value.trim();

                    if (!number_issue) {
                        alert("يرجى إدخال  رقم القصية.");
                        return false;
                    }
                    if (!working_company) {
                        alert("يرجى إدخال  الجهه.");
                        return false;
                    }
                    if (!date) {
                        alert("يرجى إدخال  التاريخ.");
                        return false;
                    }
                    if (!image) {
                        alert("يرجى إدخال الصورة.");
                        return false;
                    }
                }


        // If all validations pass, submit the form
        document.getElementById('issueModelform').submit();
        }

        else {
            if (!issue_pdf) {
                alert("يرجى إدخال  ملف القضية.");
                return false;
            }
            // document.getElementById('saveissue').setAttribute("data-bs-dismiss", "modal");
            document.getElementById('issueModelform').submit();
        }
    }


</script>
    <script>
        const baseUrl = `{{ url('/myinstall/update/') }}`;
    </script>
    <script>
        $(document).ready(function() {
            $('#open-details').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var itemId = button.data('id'); // Extract info from data-* attributes
                var modal = $(this);
                // Set the installment_clients_id in the hidden input
                modal.find('#installment_client_id').val(itemId);

                // Clear previous content to prevent duplication
                var notesTableBody = modal.find('#notes1 tbody');
                var notesIssueTableBody = modal.find('#notesissue tbody');
                var notesCarTableBody = modal.find('#notescar tbody');
                notesTableBody.empty();
                notesIssueTableBody.empty();
                notesCarTableBody.empty();

                // AJAX call to fetch notes for the specific item
                $.ajax({
                    url: '/myinstall/notes/' + itemId,
                    method: 'GET',
                    success: function(response) {
                        // Populate the table with new notes if available
                        if (response.notes && response.notes.length > 0) {
                            response.notes.forEach(function(note) {
                                notesTableBody.append(`
                            <tr>
                                <td>${note.user.name_ar}</td>
                                <td>${note.reply}</td>
                                <td>${note.time}</td>
                                <td>${note.date}</td>
                                <td><p>${note.note}</p></td>
                            </tr>
                        `);
                            });
                        } else {
                            // Display message if no notes found
                            notesTableBody.append(
                                '<tr><td colspan="5" class="text-center">لا توجد ملاحظات</td></tr>'
                            );
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching notes:", error);
                        notesTableBody.append(
                            '<tr><td colspan="5" class="text-center">خطأ في تحميل البيانات</td></tr>'
                        );
                    }
                });
                // issue
                //  const storageUrl = "{{ asset('public') }}";
                $.ajax({
                    url: '/myinstall/notesissue/' + itemId,
                    method: 'GET',
                    success: function(response) {
                        console.log(response);
                        // Populate the table with new issue notes if available
                        if (response.notesissue && response.notesissue.length > 0) {
                            response.notesissue.forEach(function(issue) {
                                let row = `
                                    <tr>
                                        <td>${issue.created_by_name}</td>
                                        <td>${issue.number_issue ?? 'لايوجد'}</td>
                                        ${issue.status === 'open' ? `<td>مفتوح</td>` : `<td>مغلق</td>`}
                                        <td><p>${issue.working_company ?? 'لا يوجد'}</p></td>
                                        ${issue.status === 'open' ? `<td>${issue.opening_amount}</td>` : `<td>${issue.closing_amount}</td>`}
                                        <td><p>${issue.date ?? 'لا يوجد'	}</p></td>
                                `;

                                // Check if car.image exists
                                if (issue.image) {
                                    row += `
                                        <td>
                                            <a href="/${issue.image}" target="_blank">
                                                <img src="/${issue.image}" alt="Issue Image" style="width: 50px; height: auto; cursor: pointer;">
                                            </a>
                                        </td>
                                    `;
                                } else {
                                    row += `<td><a href="/${response.pdf}" target="_blank">رابط</a></td>`; // Fallback if no image
                                }

                                // Close the row
                                row += `</tr>`;
                                // Append the row to the table body
                                notesIssueTableBody.append(row);



                            });
                        } else {
                            notesIssueTableBody.append(
                                '<tr><td colspan="5" class="text-center">لا توجد قضايا</td></tr>'
                            );
                        }
                        // Set open, close, and total issue counts in the designated elements
                        $('#openIssueCount').text(
                            `المفتوحة : ${response.openissuecount.toFixed(3)} د.ك`);
                        $('#closeIssueCount').text(
                            `المغلقة : ${response.closeissuecount.toFixed(3)} د.ك`);
                        $('#totalIssueCount').text(
                            `الإجمالي : ${response.totalissue.toFixed(3)} د.ك`);
                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching issue notes:", error);
                        notesIssueTableBody.append(
                            '<tr><td colspan="5" class="text-center">خطأ في تحميل بيانات القضايا</td></tr>'
                        );
                    }
                });

                // car
                $.ajax({
                    url: '/myinstall/notescar/' + itemId,
                    method: 'GET',
                    success: function(response) {
                        // Populate the table with new issue notes if available
                        if (response.notescar && response.notescar.length > 0) {
                            response.notescar.forEach(function(car) {
                                // Start building the row
                                let row = `
            <tr>
                <td>${car.user.name_ar}</td>
                <td>${car.type_car ?? 'لايوجد'}</td>
                <td>${car.model_year ?? 'لا يوجد'}</td>
                <td><p>${car.average_price ?? 'لا يوجد'}</p></td>
        `;

                                // Check if car.image exists
                                if (car.image) {
                                    row += `
                <td>
                    <a href="/${car.image}" target="_blank">
                        <img src="/${car.image}" alt="Issue Image" style="width: 50px; height: auto; cursor: pointer;">
                    </a>
                </td>
            `;
                                } else {
                                    row += `<td>لا يوجد</td>`; // Fallback if no image
                                }

                                // Close the row
                                row += `</tr>`;

                                // Append the row to the table body
                                notesCarTableBody.append(row);
                            });
                        } else {
                            notesCarTableBody.append(
                                '<tr><td colspan="5" class="text-center">لا يوجد استعلام سيارات</td></tr>'
                            );
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching car notes:", error);
                        notesCarTableBody.append(
                            '<tr><td colspan="5" class="text-center">خطأ في تحميل بيانات السيارات</td></tr>'
                        );
                    }
                });
            });
        });
        // ///////////

        function submitNoteForm(event) {
            event.preventDefault(); // Prevent default form submission

            const reply = document.getElementById('reply').value;
            const note = document.getElementById('note').value;
            const installment_clients_id = document.getElementById('installment_client_id').value;

            console.log("Submitting form with data:", { reply, note, installment_clients_id });

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
                    // Refresh the notes list
                },
                error: function(error) {
                    console.error('Error adding note:', error);
                    alert('Failed to add note. Please try again.');
                }
            });
        }

        // //////////////////
        document.addEventListener('DOMContentLoaded', function() {
            // Select all buttons that trigger the modal
            const modalTriggers = document.querySelectorAll('[data-bs-toggle="modal"]');

            modalTriggers.forEach(trigger => {
                trigger.addEventListener('click', function() {
                    const itemId = this.getAttribute('data-id');
                    const itemName = this.getAttribute('data-name');

                    // Handle "accept-form" action update
                    const acceptForm = document.getElementById('accept-form');
                    console.log('acceptForm:', acceptForm);
            if (acceptForm) {
                acceptForm.action = `${baseUrl}/${itemId}`;
            }
            const acceptForm1 = document.getElementById('accept1-form');
                    console.log('acceptForm1:', acceptForm1);
            if (acceptForm1) {
                acceptForm1.action = `${baseUrl}/${itemId}`;
            }

                    // Handle "reject-form" action update
                    const rejectForm = document.getElementById('reject-form');
                    if (rejectForm) {
                        rejectForm.action = `{{ url('/myinstall/update/') }}/${itemId}`;
                    }

                    // Set the hidden input field with the item ID for both forms
                    const itemIdField = document.getElementById('item-id');
                    if (itemIdField) {
                        itemIdField.value = itemId;
                    }

                    // Optionally, set the modal title or other dynamic content
                    const modalTitle = document.querySelector('.modal-title');
                    if (modalTitle) {
                        modalTitle.textContent = `نتيجة الاستعلام: ${itemName}`;
                    }
                });
            });
        });
    </script>
    {{-- car --}}
    <script>
        document.getElementById('addRowBtn').addEventListener('click', function() {
            const formRows = document.getElementById('formRows1');
            const index = formRows.children.length;

            const newRow = document.createElement('div');
            newRow.classList.add('row', 'car-row', 'mb-3');
            newRow.setAttribute('data-index', index);

            newRow.innerHTML = `
            <div class="form-row" data-index="0">
                                <div class="form-group mb-3">
                                    <label class="form-label"> نوع السيارة</label>
                                    <input type="text" name="installment_car[${index}][type_car]" class="form-control"
                                        placeholder="نوع السيارة" required />
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label">  سنة الموديل </label>
                                    <input type="text" name="installment_car[${index}][model_year]" class="form-control"
                                        placeholder="سنة الموديل" required />
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label">   متوسط السعر </label>
                                       <input type="text" name="installment_car[${index}][average_price]"
                                        class="form-control" placeholder="متوسط السعر" required />
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label">   الصورة </label>
                                        <input type="file" name="installment_car[${index}][image]" class="form-control"
                                        placeholder="صورة" required />
                                </div>

                            </div>
                         `;

            formRows.appendChild(newRow);
            document.getElementById('total').style.display = "flex";
            addRemoveRowFunctionality();
        });

        function addRemoveRowFunctionality() {
            document.querySelectorAll('.remove-row-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const row = this.closest('.car-row');
                    row.remove();
                    updateRowIndices();
                });
            });
        }

        function updateRowIndices() {
            document.querySelectorAll('.car-row').forEach((row, index) => {
                row.setAttribute('data-index', index);
                row.querySelector('input[name^="car"]').name = `car[${index}][name_en]`;
                row.querySelector('input[name^="car"]').name = `car[${index}][name_ar]`;
            });
        }


    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const formRows = document.getElementById('formRows');

            document.getElementById('addRowBtn1').addEventListener('click', function () {
                const index = formRows.children.length;

                const newRow = document.createElement('div');
                newRow.classList.add('row', 'issue-row', 'mb-3');
                newRow.setAttribute('data-index', index);

                newRow.innerHTML = `
                    <div class="form-group mb-3 col-6">
                        <label class="form-label"> رقم القضية </label>
                        <input type="text" name="installment_issue[${index}][number_issue]" class="form-control" required />
                    </div>
                    <div class="form-group mb-3 col-6">
                        <label class="form-label"> الجهة  </label>
                        <input type="text" name="installment_issue[${index}][working_company]" class="form-control" required />
                    </div>
                    <div class="form-group mb-3 col-6">
                        <label class="form-label"> مبلغ المفتوح  </label>
                        <input type="text" name="installment_issue[${index}][opening_amount]" class="form-control"  />
                    </div>
                    <div class="form-group mb-3 col-6">
                        <label class="form-label"> مبلغ المغلق  </label>
                        <input type="text" name="installment_issue[${index}][closing_amount]" class="form-control"  />
                    </div>
                    <div class="form-group mb-3 col-6">
                        <label class="form-label">  صورة القضية  </label>
                        <input class="form-control" type="file" name="installment_issue[${index}][image]" required />
                    </div>
                    <div class="form-group col-6">
                        <label class="form-label">  التاريخ </label>
                        <input type="date" name="installment_issue[${index}][date]" class="form-control" required />
                    </div>
                    <div class="form-group col-12">
                        <label class="form-label"> الحالة  </label>
                        <div class="form-check-inline">
                            <input class="" type="radio" name="installment_issue[${index}][status]" id="flexRadioDefaultOpen${index}">
                            <label for="flexRadioDefaultOpen${index}"> مفتوح </label>
                        </div>
                        <div class="form-check-inline">
                            <input class="" type="radio" name="installment_issue[${index}][status]" value="close" id="flexRadioDefaultClose${index}" checked>
                            <label for="flexRadioDefaultClose${index}"> مغلق </label>
                        </div>
                    </div>
                `;

                formRows.appendChild(newRow);
                const statusOpen1 = document.getElementById("exist1");
                if(statusOpen1.checked)
                {
                    addToggleFunctionality(index);  // Add toggle functionality for the new row
                }

            });


                function addToggleFunctionality(index) {
                const closingAmountField = document.querySelector(`input[name="installment_issue[${index}][closing_amount]"]`);
                const openingAmountField = document.querySelector(`input[name="installment_issue[${index}][opening_amount]"]`);
                const openStatusRadio = document.getElementById(`flexRadioDefaultOpen${index}`);
                const closeStatusRadio = document.getElementById(`flexRadioDefaultClose${index}`);

                // Function to toggle the disabled state of opening and closing amount fields
                function toggleAmountFields() {
                    if (openStatusRadio.checked) {
                        closingAmountField.disabled = true;
                        closingAmountField.value = 0; // Clear the value when disabled
                        openingAmountField.disabled = false; // Enable opening amount field
                        openingAmountField.value = "";
                    } else if (closeStatusRadio.checked) {
                        openingAmountField.disabled = true;
                        openingAmountField.value = 0; // Clear the value when disabled
                        closingAmountField.disabled = false; // Enable closing amount field
                        closingAmountField.value = "";
                    }
                }

                // Add event listeners for both radio buttons
                openStatusRadio.addEventListener('change', toggleAmountFields);
                closeStatusRadio.addEventListener('change', toggleAmountFields);

                // Initial check when row is added
                toggleAmountFields();
            }

            // Initialize toggle functionality for existing rows if any
            formRows.querySelectorAll('.issue-row').forEach((row, index) => {
                addToggleFunctionality(index);
            });




        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const formRows = document.getElementById('formRows');
            const openingTotalInput = document.getElementById('opening_total');
            const closingTotalInput = document.getElementById('closing_total');
            const totalInputt = document.getElementById('totalll');

            // console.log("sd",totalInputt);

            function calculateTotals() {
                let openingTotal = 0;
                let closingTotal = 0;
                let total = 0;

                // Select all opening_amount fields
                const openingAmountInputs = formRows.querySelectorAll(
                    'input[name^="installment_issue"][name$="[opening_amount]"]');
                const closingAmountInputs = formRows.querySelectorAll(
                    'input[name^="installment_issue"][name$="[closing_amount]"]');

                openingAmountInputs.forEach(input => {
                    const value = parseFloat(input.value) ||
                        0; // Convert value to float, default to 0 if NaN
                    openingTotal += value;
                    total += value;
                });

                closingAmountInputs.forEach(input => {
                    const value = parseFloat(input.value) ||
                        0; // Convert value to float, default to 0 if NaN
                    closingTotal += value;
                    total += value;
                });

                // total = openingTotal + closingTotal;

                // Update total inputs and format them
                openingTotalInput.value = openingTotal.toFixed(2);
                closingTotalInput.value = closingTotal.toFixed(2);
                totalInputt.value = total.toFixed(2);

                // console.log(`Opening Total: ${openingTotal}, Closing Total: ${closingTotal}, Total: ${total}`); // Debugging log
            }

            // Attach event listeners to all relevant fields
            formRows.addEventListener('input', function(event) {
                if (event.target.name.endsWith('[opening_amount]') || event.target.name.endsWith(
                        '[closing_amount]')) {
                    calculateTotals();
                }
            });

            // Initial calculation in case there are pre-filled values
            calculateTotals();
        });
    </script>
    <script>
        // car
        document.addEventListener('DOMContentLoaded', function() {
            const carModal = document.getElementById('car-modal-md');
            carModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget; // Button that triggered the modal
                const installmentId = button.getAttribute('data-id'); // Get ID from data-id
                const nameAr = button.getAttribute('data-name');

                console.log("Installment ID:", installmentId); // Log the ID to check if it's correct

                // Set the ID in the hidden input
                const inputField = carModal.querySelector('input[name="installment_clients_id"]');
                document.getElementById('installment_clients_id').value=installmentId;
                if (inputField) {
                    inputField.value = installmentId;
                    console.log("Hidden Input Value Set:", inputField
                        .value); // Log to confirm input value is set
                }

                const nameSpan = carModal.querySelector('.text-info');
                if (nameSpan) {
                    nameSpan.textContent = `(${nameAr})`;
                }
            });
        });

        // issue
        document.addEventListener('DOMContentLoaded', function() {
            const issueModal = document.getElementById('estlaam-modal-md');
            issueModal.addEventListener('show.bs.modal', function(
                event) { // Corrected the reference from carModal to issueModal
                const button = event.relatedTarget; // Button that triggered the modal
                const issueinstallmentId = button.getAttribute('data-id'); // Get ID from data-id
                console.log(issueinstallmentId);
                const issuenameAr = button.getAttribute('data-name'); // Get name from data-name

                console.log("Installment ID:", issueinstallmentId); // Log the ID to check if it's correct

                // Set the ID in the hidden input
                const inputField = issueModal.querySelector('input[name="installment_clients_id"]');
                document.getElementById('installment_clients_id').value=issueinstallmentId;
                if (inputField) {
                    inputField.value = issueinstallmentId;
                    console.log("Hidden Input Value Set:", inputField
                        .value); // Log to confirm input value is set
                }

                // Set the name inside the span
                const nameSpan = issueModal.querySelector('.text-info');
                if (nameSpan) {
                    nameSpan.textContent = `(${issuenameAr})`;
                }
            });
        });
        // modal accept
        function openModal(id) {
            // Update the form action with the correct id
            $('#modalForm').attr('action', '/myinstall/update/' + id);

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
            $('#modalForm1').attr('action', '/myinstall/update/' + id);

            // Show the modal
            $('#exampleModal1').modal('show');
        }

        // Close modal when "إغلاق" button is clicked
        $('#closeModalBtn1, #closeModalFooterBtn1').on('click', function() {
            $('#exampleModal1').modal('hide');
        });
        // /////
        document.getElementById('addRowBtn').addEventListener('click', function() {
        const formRows = document.getElementById('formRows');
        const index = formRows.children.length;

        // Set the name inside the span
        const nameSpan = issueModal.querySelector('.text-info');
        if (nameSpan) {
            nameSpan.textContent = `(${issuenameAr})`;
        }
        });
        // });
        // modal accept
        function openModal(id) {
            // Update the form action with the correct id
            $('#modalForm').attr('action', '/myinstall/update/' + id);

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
            $('#modalForm1').attr('action', '/myinstall/update/' + id);

            // Show the modal
            $('#exampleModal1').modal('show');
        }

        // Close modal when "إغلاق" button is clicked
        $('#closeModalBtn1, #closeModalFooterBtn1').on('click', function() {
            $('#exampleModal1').modal('hide');
        });
        // /////
        document.getElementById('addRowBtn').addEventListener('click', function() {
            const formRows = document.getElementById('formRows');
            const index = formRows.children.length;

            const newRow = document.createElement('div');
            newRow.classList.add('row', 'issue-row', 'mb-3');
            newRow.setAttribute('data-index', index);

            newRow.innerHTML = `
            <div class="col">
                <input type="text" name="installment_car[${index}][type_car]" class="form-control" placeholder="نوع السيارة" required>
            </div>
            <div class="col">
                <input type="text" name="installment_car[${index}][model_year]" class="form-control" placeholder="سنة الموديل" required>
            </div>
            <div class="col">
                <input type="text" name="installment_car[${index}][average_price]" class="form-control" placeholder="متوسط السعر" required>
            </div>
            <div class="col">
                <input type="file" name="installment_car[${index}][image]" class="form-control" placeholder="صورة" required>
            </div>
            <div class="col-auto">
                <button type="button" class="btn btn-danger remove-row-btn">ازالة</button>
            </div>
        `;

            formRows.appendChild(newRow);
            addRemoveRowFunctionality();
        });

        function addRemoveRowFunctionality() {
            document.querySelectorAll('.remove-row-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const row = this.closest('.issue-row');
                    row.remove();
                });
            });
        }

        addRemoveRowFunctionality();
    </script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const closingAmountField = document.querySelector('input[name="installment_issue[0][closing_amount]"]');
        const openingAmountField = document.querySelector('input[name="installment_issue[0][opening_amount]"]');
        const openStatusRadio = document.getElementById('flexRadioDefault1');
        const closeStatusRadio = document.getElementById('flexRadioDefault2');

        // Function to toggle the disabled state of opening and closing amount fields
        function toggleAmountFields() {
            if (openStatusRadio.checked) {
                closingAmountField.disabled = true;
                closingAmountField.value = 0; // Clear the value when disabled
                openingAmountField.value ="";
                openingAmountField.disabled = false; // Enable opening amount field
            } else if (closeStatusRadio.checked) {
                openingAmountField.disabled = true;
                openingAmountField.value = 0; // Clear the value when disabled
                closingAmountField.value = "";
                closingAmountField.disabled = false; // Enable closing amount field
            }
        }

        // Listen for changes on both radio buttons
        openStatusRadio.addEventListener('change', toggleAmountFields);
        closeStatusRadio.addEventListener('change', toggleAmountFields);

        // Initial check when the modal is loaded
        toggleAmountFields();
    });
</script>

<script>
    document.getElementById('issue_pdf').addEventListener('change', function (e) {
        const file = e.target.files[0]; // Get the file from input

        // Check if a file was selected
        if (file) {
            // Validate file type by checking extension or MIME type
            const fileType = file.type; // Get MIME type (e.g., "application/pdf")
            const fileExtension = file.name.split('.').pop().toLowerCase(); // Get file extension

            if (fileType !== 'application/pdf' && fileExtension !== 'pdf') {
                alert('يسمح لك فقط برفع ملف من نوع pdf');
                e.target.value = ''; // Clear the input field
            }
        }
    });
</script>
