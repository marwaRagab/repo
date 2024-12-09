<div class="card mt-4 py-3">
    <div class="d-flex flex-wrap ">
        <a class=" btn-filter me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4 mx-1 mb-2 "
            href="{{ route('myinstall.index', 'advanced') }}">
            المتقدميين ({{ $counts['advancedCount'] }})
        </a>
        <a class="btn-filter bg-info-subtle text-info  px-4 fs-4 mx-1 mb-2"
            href="{{ route('myinstall.index', 'under_inquiry') }}">
            قيد الاستعلام ({{ $counts['under_inquiryCount'] }})
        </a>
        <a class="btn-filter bg-warning-subtle text-warning px-4 fs-4 mx-1 mb-2"
            href="{{ route('myinstall.index', 'auditing') }}">
            التدقيق القضائي ({{ $counts['auditingCount'] }})
        </a>
        <a class="btn-filter  bg-success-subtle text-success px-4 fs-4 mx-1 mb-2"
            href="{{ route('myinstall.index', 'car_inquiry') }}">
            استعلام السيارات ({{ $counts['car_inquiryCount'] }})
        </a>
        <a class="btn-filter  bg-success-subtle text-success px-4 fs-4 mx-1 mb-2"
            href="{{ route('myinstall.index', 'inquiry_done') }}">
            تم الاستعلام ({{ $counts['inquiry_doneCount'] }})
        </a>

        <a class="btn-filter bg-danger-subtle text-danger px-4 fs-4 mx-1 mb-2"
            href="{{ route('myinstall.index', 'accepted') }}">

            مقبول ({{ $counts['acceptedCount'] }}) </a>
        <a class="btn-filter px-4 bg-primary-subtle text-primaryfs-4 mx-1 mb-2"
            href="{{ route('myinstall.index', 'accepted_condition') }}">
            مقبول بشرط ({{ $counts['accepted_conditionCount'] }}) </a>
        <a class="btn-filter bg-danger-subtle text-danger px-4 fs-4 mx-1 mb-2"
            href="{{ route('myinstall.index', 'rejected') }}">
            مرفوض ({{ $counts['rejectedCount'] }}) </a>

    </div>
</div>

<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0"> العملاء المتقدمين</h4>
        <div class="d-flex">
            <a href="{{ route('advanced.addnew') }}" class="btn me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4 " >
                أضف جديد </a>

            <a class="btn me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4 "
                href="{{ route('myinstall.index', ['status' => 'archive']) }}">
                الارشيف </a>
            <a class="btn me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4 " href="{{ route('broker.index') }}">
                الوسطاء </a>
        </div>
    </div>
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
                    <!-- end row -->
                </thead>
                <tbody>
                    <!-- start row -->
                    @foreach ($Installment as $item)
                        <tr>
                            <!--<td>-->
                            <!--    {{ $loop->index + 1 }}-->
                            <!--</td>-->
                            <td>
                                {{ $item->id }}
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



                            <td>
                                @switch($item->ministry_id)
                                    @case('ministry_employe')
                                        موظف وزارة
                                    @break

                                    @case('help_socity')
                                        مساعدة اجتماعية
                                    @break

                                    @case('work_finish')
                                        متقاعد
                                    @break

                                    @case('military')
                                        عسكري
                                    @break

                                    @case('arm_student_help')
                                        إعانة طالب عسكري
                                    @break

                                    @case('student_help')
                                        إعانة طالب دراسة
                                    @break

                                    @case('worker_help')
                                        دعم عمالة
                                    @break

                                    @case('special_needs_help')
                                        ذوي الإحتياجات الخاصة
                                    @break

                                    @case('dead_help')
                                        راتب مرحوم
                                    @break

                                    @case('special_needs_care_help')
                                        رعاية ذوي الإحتياجات الخاصة
                                    @break

                                    @default
                                        @php
                                            $ministry = \App\Models\Ministry::find($item->ministry_id);
                                        @endphp
                                        {{ $ministry ? $ministry->name_ar : 'لايوجد' }}
                                @endswitch
                            </td>


                            @if (request()->route('status') === 'car_inquiry')
                                <td>
                                    <div class="d-block">
                                        <div>
                                            <a class="btn me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4 "
                                                 href="{{ route('advanced.car', $item->id) }}">
                                                استعلام سيارات
                                                {{-- ({{ App\Models\InstallmentCar::where('installment_clients_id', $item->id)->count() }}) --}}
                                                ({{$item->installment_car_count}})

                                            </a>
                                        </div>

                                        @if ($item->installment_car->isNotEmpty() || $item->installment_car->count() > 0)
                                            <div>
                                                {{-- {{ dd($item->installment_car) }} --}}
                                                @if ($item->installment_car->first()->image != null)
                                                    <a class="btn me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4 "
                                                        href="{{ $item->installment_car->first()->image }}"
                                                        download="car.jpg">
                                                        صوره الاستعلام </a>
                                                @else
                                                    <h6>لا يوجد صورة</h6>
                                                @endif


                                            </div>
                                        @else
                                            <h6>لا يوجد صورة</h6>
                                        @endif
                                    </div>
                                </td>
                            @endif
                            @if (request()->route('status') === 'auditing' || request()->route('status') === 'under_inquiry')
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
                                            <a class="btn me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4 "
                                                href="{{ route('advanced.issue', $item->id) }}">
                                                استعلام قضائي
                                                {{-- ({{ App\Models\InstallmentIssue::where('installment_clients_id', $item->id)->count() }}) --}}
                                                ({{$item->installment_issue_count}})
                                            </a>
                                        </div>
                                        @if ($item->installment_issue->isNotEmpty() || $item->installment_issue->count() > 0)
                                            <div>
                                                <a class="btn me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4 "
                                                    href="{{ asset($item->issue_pdf) }}" download="issue.pdf">
                                                    صوره الاستعلام </a>
                                            </div>
                                        @else
                                            <h6>لا يوجد صورة</h6>
                                        @endif

                                    </div>
                                </td>
                            @endif

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
                                                <input type="hidden" name="status" value="advanced">
                                                <button class="btn btn-success rounded-0 w-100 mt-2" type="submit">
                                                    المتقدمين
                                                </button>
                                            </form>
                                        </li>
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
                                            <a class="btn btn-info rounded-0 w-100 mt-2" href="{{ route('advanced.acceptCondation',  $item->id) }}">
                                                مقبول بشرط </a>

                                        </li>
                                        <li>
                                            <a class="btn btn-info rounded-0 w-100 mt-2" href="{{ route('advanced.accept',  $item->id) }}">
                                                مقبول </a>

                                            </form>
                                        </li>
                                        <li>
                                            <a class="btn btn-warning rounded-0 w-100 mt-2"  href="{{ route('advanced.reject',  $item->id) }}">
                                                مرفوض</a>
                                        </li>

                                    </ul>
                                </div>
                                <div>
                                    @if ($item->status == 'archive')
                                        <form action="{{ route('myinstall.update', $item->id) }}" method="post"
                                            style="display:inline;">
                                            @csrf
                                            <input type="hidden" name="status" value="advanced">
                                            <button class="btn btn-danger">
                                                الغاء الارشفة
                                            </button>
                                        @else
                                            <form action="{{ route('myinstall.update', $item->id) }}" method="post"
                                                style="display:inline;">
                                                @csrf
                                                <input type="hidden" name="status" value="archive">
                                                {{-- <a class="btn btn-secondary w-100 mt-2" data-bs-toggle="modal" data-bs-target="#archive"> --}}
                                                <button class="btn btn-success rounded-0 w-100 mt-2" type="submit">

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

                                    <a class="btn btn-secondary w-100 mt-2" href="{{ route('advanced.notes',  $item->id) }}">
                                        الملاحظات</a>
                                </div>

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


    <!-- open file model  -->
    {{-- <div id="open-file" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="myModalLabel">
                        إثبات حالة</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
    </div> --}}

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


