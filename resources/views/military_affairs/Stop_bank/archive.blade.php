<div class="card mt-4 py-3">

    @php
        use Illuminate\Support\Facades\Request;
        if(Request::has('governorate_id')){
        $gov=Request::get('governorate_id');
        }else{
        $gov='';
        }

    @endphp

    <div class="d-flex flex-wrap ">
        <a href="{{route('stop_bank.archive')}}"
           class="btn-filter bg-warning-subtle text-warning px-2  mx-1 mb-2   {{ request()->get('governorate_id') == '' ? 'active' : '' }} ">
            العدد الكلي ({{ count_court('' ,'stop_bank_archive',null,null) }})
        </a>
        @foreach($courts as $court)

            <a href="{{route('stop_bank.archive',array('governorate_id' => $court->id))}}"
               class="btn-filter {{$court->style}}   px-2  mx-1 mb-2  {{ request()->get('governorate_id') == $court->id ? 'active' : '' }} "> {{$court->name_ar}}
                ({{ count_court($court->id ,'stop_bank_archive',null,null) }})
            </a>

        @endforeach
    </div>
</div>

<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0"> حجز بنوك </h4>
        <a class="btn me-1 mb-1 bg-success-subtle text-success px-4  " href="{{route('stop_bank.print_archive')}}">
            طباعة الإرشيف </a>
    </div>
    <div class="card-body">
        <div class="table-responsive pb-4">
            <table id="all-student" class="table table-bordered border text-nowrap align-middle">
                <thead>
                <!-- start row -->
                <tr>
                    <th>#</th>
                    <th>رقم المعاملة</th>
                    <th>اسم العميل</th>
                    <th> المحكمة</th>
                    <th>تاريخ الحجز</th>
                    <th> تاريخ اخر طلب</th>
                    <th>الوزارة</th>
                    <th> حالة الحساب</th>
                    <th> الإجراءات</th>

                </tr>
                <!-- end row -->
                </thead>
                <tbody>
                <!-- start row -->
                @foreach($items as $item)

                    @if($item->installment)

                        <tr>

                            <td>
                                {{ $item->i }}
                            </td>
                            <td>
                                {{$item->installment->id}}
                                <br>
                                {{$item->installment->client->civil_number}}

                                <br>

                            </td>

                            @php
                                $ministry = DB::table('client_ministries')->where('client_id',
                                $item->installment->client->id)->first();
                                $ministry_date = DB::table('ministries')->where('id', $ministry->ministry_id)->first();;
                            @endphp

                            <td>

                                {{$item->installment->client->name_ar}}
                                <br>

                                {{$item->issue_id}}

                            </td>

                            <td>
                                {{$item->installment->client->court->name_ar}}
                                {{$item->eqrar_dain_amount}}

                            </td>
                            <td>
                                {{$ministry_date->date}}
                                <!-- {{$item->booking_date}} -->
                            </td>
                            @php

                                $last_stop_bank = DB::table('military_affairs_deligations')->where('military_affairs_id',
                                $item->id)->first();

                            @endphp

                            <td>{{ $last_stop_bank?->bank_date ?? 'لا يوجد' }}</td>

                            <td> {{$ministry_date->name_ar}}</td>

                            <td>

                                @if($item->bank_account_status =='work')
                                    يعمل راتب
                                @elseif( $item->bank_account_status =='stop')
                                    موقوف راتب
                                @elseif( $item->bank_account_status =='visa')
                                    فيزا
                                @elseif( $item->bank_account_status =='wrong_bank')
                                    لا يوجد حساب
                                @elseif( $item->bank_account_status =='housing')
                                    يعمل بدل ايجار
                                @elseif( $item->bank_account_status =='account_closed')
                                    حساب مغلق
                                @elseif( $item->bank_account_status =='money_found')
                                    يوجد مبلغ
                                @else
                                    لايوجد

                                @endif

                            </td>

                            <td>
                                <div class="btn-group dropup mb-6 me-6 d-block ">
                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                            id="dropdownMenuButton"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                        الإجراءات <span class="badge ms-auto text-bg-primary">5</span>
                                    </button>
                                    <ul class="dropdown-menu rounded-0" aria-labelledby="dropdownMenuButton">
                                        <li>
                                            <a class="btn btn-success rounded-0 w-100 mt-2"
                                               href="{{ route('stop_bank.check_info_in_banks', ['id' => $item->id]) }}">
                                                استعلام بنك
                                            </a>
                                        </li>
                                        <li>
                                            <a class="btn btn-primary rounded-0 w-100 mt-2"
                                               href="{{ route('stop_bank.check_info_in_job', ['id' => $item->id]) }}">
                                                استعلام عمل </a>
                                        </li>
                                        <li>
                                            <a class="btn btn-warning text-white rounded-0 w-100 mt-2"
                                               data-bs-toggle="modal" data-bs-target="#open-details-{{$item->id}}">
                                                التفاصيل
                                            </a>
                                        </li>
                                        <li>
                                            <a class="btn btn-danger text-white rounded-0 w-100 mt-2"
                                               href="{{ route('stop_bank.cancel_archive', ['id' => $item->id]) }}">
                                                الغاء الارشيف
                                            </a>
                                        </li>

                                    </ul>


                                </div>
                                <button class="btn btn-secondary me-6 my-2 d-block" data-bs-toggle="modal"
                                        data-bs-target="#open-details-{{$item->id}}">
                                    الملاحظات
                                </button>


                                <div id="open-details-{{$item->id}}" class="modal fade" tabindex="-1"
                                     aria-labelledby="bs-example-modal-md" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                        <div class="modal-content">
                                            <form class="mega-vertical" action="{{url('add_notes')}}" method="post"
                                                  enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-header d-flex align-items-center">
                                                    <h4 class="modal-title" id="myModalLabel">
                                                        ملاحظات حجز بنوك</h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <ul class="nav nav-pills" role="tablist">
                                                        <li class="nav-item">
                                                            <a class="nav-link active" data-bs-toggle="tab"
                                                               href="#notes-{{$item->id}}" role="tab">
                                                                <span>الملاحظات</span>
                                                            </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" data-bs-toggle="tab"
                                                               href="#navpill-{{$item->id}}" role="tab">
                                                                <span>الإجراءات</span>
                                                            </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" data-bs-toggle="tab"
                                                               href="#actions-{{$item->id}}" role="tab">
                                                                <span>تتبع المعاملة</span>
                                                            </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" data-bs-toggle="tab"
                                                               href="#banks-{{ $item->id }}"
                                                               role="tab">
                                                                <span>استعلام بنك</span>
                                                            </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" data-bs-toggle="tab"
                                                               href="#jobs-{{ $item->id }}"
                                                               role="tab">
                                                                <span>استعلام عمل</span>
                                                            </a>
                                                        </li>

                                                    </ul>
                                                    <!-- Tab panes -->

                                                    <div class="tab-content border mt-2">
                                                        @php

                                                            $all_notes=get_all_notes('stop_bank',$item->id);
                                                            $all_actions = get_all_actions($item->id);
                                                            $get_all_delegations = get_all_delegations($item->id);
                                                            $get_all_banks = get_all_banks($item->id);

                                                            $get_all_jobs = get_all_jobs($item->id);
                                                        @endphp
                                                        <div class="tab-pane active p-3" id="notes-{{$item->id}}"
                                                             role="tabpanel">

                                                            <table id="notes1"
                                                                   class="table table-bordered border text-wrap align-middle">
                                                                <thead>
                                                                <!-- start row -->
                                                                <tr>
                                                                    <th>اليوزر</th>
                                                                    <th>النوع</th>
                                                                    <th>الملاحظة</th>
                                                                    <th> الساعة</th>
                                                                    <th>التاريخ</th>

                                                                </tr>
                                                                <!-- end row -->
                                                                </thead>
                                                                <tbody>


                                                                <!-- start row -->
                                                                @foreach($all_notes as $all_note)

                                                                    <tr data-bs-toggle="collapse"
                                                                        data-bs-target="#collapseExample"
                                                                        aria-expanded="false"
                                                                        aria-controls="collapseExample">
                                                                        <td>
                                                                            {{$all_note->created_by}}
                                                                        </td>
                                                                        <td>
                                                                            @php
                                                                                if($all_note->notes_type=='answered'){
                                                                                $type= 'رد' ;
                                                                                }elseif ($all_note->notes_type=='refused'){
                                                                                $type= 'لم يرد' ;
                                                                                }else{
                                                                                $type= 'ملاحظة' ;
                                                                                }

                                                                            @endphp
                                                                            {{$type}}
                                                                        </td>
                                                                        <td>
                                                                            <p>
                                                                                {{$all_note->note}}
                                                                            </p>
                                                                        </td>
                                                                        @php
                                                                            $time= explode(' ', $all_note->date)[1];
                                                                            $day= explode(' ', $all_note->date)[0];


                                                                        @endphp


                                                                        <td>{{formatTime($time)}}}}<span
                                                                                class="d-block"></span></td>
                                                                        <td>{{$day}}</td>

                                                                    </tr>

                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                            <div class="add-note">
                                                                <h4 class="mb-3">اضف ملاحظة</h4>

                                                                <input type="hidden" name="military_affairs_id"
                                                                       value="{{ $item->id }}">
                                                                @php
                                                                    if(Request::has('stop_bank_type')){
                                                                    $slug_stop_bank=Request::get('stop_bank_type');
                                                                    }else{
                                                                    $slug_stop_bank='stop_bank_request';
                                                                    }
                                                                @endphp

                                                                <input type="hidden" name="type" value="stop_bank">
                                                                <input type="hidden" name="type_id"
                                                                       value="{{$slug_stop_bank}}">
                                                                <div class="form-row">
                                                                    <div class="form-group">
                                                                        <label class="form-label"> الاتصال</label>
                                                                        <select class="form-select" name="notes_type">
                                                                            <option value="answered">
                                                                                رد
                                                                            </option>
                                                                            <option value="refused">
                                                                                لم يرد
                                                                            </option>
                                                                            <option value="note">
                                                                                ملاحظة
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <div class="my-3">
                                                                            <label class="form-label">الملاحظات</label>
                                                                            <textarea name="note" class="form-control"
                                                                                      rows="5"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="tab-pane p-3" id="navpill-{{$item->id}}"
                                                             role="tabpanel">
                                                            <table id="notes2"
                                                                   class="table table-bordered border text-wrap align-middle">
                                                                <thead>
                                                                <!-- start row -->
                                                                <tr>
                                                                    <th>اليوزر</th>
                                                                    <th>القسم</th>
                                                                    <th>التاريخ</th>
                                                                    <th> عدد الايام</th>
                                                                </tr>
                                                                <!-- end row -->
                                                                </thead>
                                                                <tbody>
                                                                <!-- start row -->
                                                                @foreach ($all_actions as $value)
                                                                    <tr>
                                                                        @php
                                                                            $created_by = DB::table('users')
                                                                            ->where('id', $value->created_by)
                                                                            ->first();

                                                                        @endphp
                                                                        <td>{{ $created_by->name_ar ?? 'لا يوجد' }}</td>
                                                                        <td> @if ($value->timesType)
                                                                                {{ $value->timesType->name_ar }}
                                                                            @elseif ($value->bankType)
                                                                                {{ $value->bankType->name_ar }}
                                                                            @elseif ($value->carType)
                                                                                {{ $value->carType->name_ar }}
                                                                            @elseif ($value->salaryType)
                                                                                {{ $value->salaryType->name_ar }}
                                                                            @elseif ($value->travelType)
                                                                                {{ $value->travelType->name_ar }}
                                                                            @else
                                                                                لا يوجد
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            @php

                                                                                $day_start = explode(' ',
                                                                                $value->date_start)[0];
                                                                                if (
                                                                                $value->date_end &&
                                                                                $value->date_end != '0000-00-00 00:00:00'
                                                                                ) {
                                                                                $day_end = explode(' ', $value->date_end)[0];
                                                                                $different_day = get_different_dates(
                                                                                $day_start,
                                                                                $day_end,
                                                                                );
                                                                                } else {
                                                                                $day_end = 'لم تنتهى';
                                                                                $different_day = get_different_dates(
                                                                                $day_start,
                                                                                now(),
                                                                                );
                                                                                }

                                                                            @endphp
                                                                            {{ $day_start }}
                                                                            </br>
                                                                            {{ $day_end }}
                                                                        </td>
                                                                        <td>{{ $different_day }}</td>


                                                                    </tr>
                                                                @endforeach

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="tab-pane p-3" id="actions-{{$item->id}}"
                                                             role="tabpanel">
                                                            <table id="notes2"
                                                                   class="table table-bordered border text-wrap align-middle">
                                                                <thead>
                                                                <!-- start row -->
                                                                <tr>
                                                                    <th>القسم</th>
                                                                    <th>المسئول</th>
                                                                    <th>تاريخ البدء</th>
                                                                    <th>تاريخ الانتهاء</th>
                                                                    <th> عدد الايام</th>
                                                                </tr>
                                                                <!-- end row -->
                                                                </thead>
                                                                <tbody>
                                                                <!-- start row -->
                                                                @foreach ($get_all_delegations as $value)
                                                                    <tr data-bs-toggle="collapse"
                                                                        data-bs-target="#collapseExample"
                                                                        aria-expanded="false"
                                                                        aria-controls="collapseExample">
                                                                        @php
                                                                            $created_by = DB::table('users')
                                                                            ->where('id', $value->emp_id)
                                                                            ->first();

                                                                        @endphp
                                                                        <td>
                                                                            {{ $value['execute_date'] ? 'اعلان التنفيذ' : (
                                                                        $value['image_date'] ? 'الايمج' : (
                                                                        $value['case_proof_date'] ? 'إثبات الحالة' : (
                                                                        $value['travel_date'] ? 'منع السفر' : (
                                                                        $value['car_date'] ? 'حجز السيارات' : (
                                                                        $value['bank_date'] ? 'حجز بنوك' : (
                                                                        $value['salary_date'] ? 'حجز راتب' : (
                                                                        $value['certificate_date'] ? 'إصدار شهادة العسكريين' : 'فتح ملف'
                                                                        )))))))
                                                                    }}
                                                                        </td>
                                                                        <td>
                                                                            {{ $created_by->name_ar ?? 'لا يوجد' }}
                                                                        </td>
                                                                        <td>
                                                                            @php

                                                                                $day_start = explode(' ',
                                                                                $value->assign_date)[0];
                                                                                if (is_numeric($day_start)) {
                                                                                $day_start = date('Y-m-d', $day_start);
                                                                                }

                                                                                // Check the end date
                                                                                if ($value->end_date && $value->end_date != '')
                                                                                {
                                                                                $day_end = explode(' ', $value->end_date)[0];
                                                                                if (is_numeric($day_end)) {
                                                                                $day_end = date('Y-m-d', $day_end);
                                                                                }
                                                                                $different_day = get_different_date($day_start,
                                                                                $day_end);
                                                                                } else {
                                                                                // Use current timestamp if end_date is missing
                                                                                $day_end = 'لم تنتهى';
                                                                                $different_day = get_different_date($day_start,
                                                                                now()->timestamp);
                                                                                }
                                                                            @endphp
                                                                            {{ $day_start }}

                                                                        </td>
                                                                        <td>{{ $day_end }}</td>

                                                                        <td>
                                                                            {{ $different_day }}
                                                                        </td>

                                                                    </tr>
                                                                @endforeach

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="tab-pane p-3" id="banks-{{ $item->id }}"
                                                             role="tabpanel">
                                                            <table id="notes2"
                                                                   class="table table-bordered border text-wrap align-middle">
                                                                <thead>
                                                                <!-- start row -->
                                                                <tr>
                                                                    <th>اليوزر</th>
                                                                    <th>الساعة</th>
                                                                    <th>التاريخ</th>
                                                                    <th>الملاحظة</th>
                                                                </tr>
                                                                <!-- end row -->
                                                                </thead>
                                                                <tbody>
                                                                <!-- start row -->
                                                                @if (count($get_all_banks) > 0)
                                                                    @foreach ($get_all_banks as $value)
                                                                        <tr data-bs-toggle="collapse"
                                                                            data-bs-target="#collapseExample"
                                                                            aria-expanded="false"
                                                                            aria-controls="collapseExample">
                                                                            @php
                                                                                $created_by = DB::table('users')
                                                                                    ->where('id', $value->created_by)
                                                                                    ->first();

                                                                            @endphp
                                                                            <td>
                                                                                {{ $created_by->name_ar ?? 'لا يوجد' }}
                                                                            </td>
                                                                            <td>
                                                                                {{ \Carbon\Carbon::parse($value->date)->format('H:i:s') ?? 'لا يوجد' }}
                                                                            </td>
                                                                            <td>
                                                                                {{ \Carbon\Carbon::parse($value->date)->format('Y-m-d') ?? 'لا يوجد' }}
                                                                            </td>
                                                                            <td>{{ $value->note }}</td>

                                                                        </tr>
                                                                    @endforeach
                                                                @else
                                                                    <tr>
                                                                        <td colspan="5"> لا يوجد بيانات</td>
                                                                    </tr>

                                                                @endif
                                                                </tbody>
                                                            </table>
                                                        </div>


                                                        <div class="tab-pane p-3" id="jobs-{{ $item->id }}"
                                                             role="tabpanel">
                                                            <table id="notes2"
                                                                   class="table table-bordered border text-wrap align-middle">
                                                                <thead>
                                                                <!-- start row -->
                                                                <tr>
                                                                    <th>القسم</th>
                                                                    <th>المسئول</th>
                                                                    <th>تاريخ البدء</th>
                                                                    <th>تاريخ الانتهاء</th>
                                                                    <th> عدد الايام</th>
                                                                </tr>
                                                                <!-- end row -->
                                                                </thead>
                                                                <tbody>
                                                                <!-- start row -->
                                                                @if (count($get_all_delegations) > 0)
                                                                    @foreach ($get_all_delegations as $value)
                                                                        <tr data-bs-toggle="collapse"
                                                                            data-bs-target="#collapseExample"
                                                                            aria-expanded="false"
                                                                            aria-controls="collapseExample">
                                                                            @php
                                                                                $created_by = DB::table('users')
                                                                                    ->where('id', $value->emp_id)
                                                                                    ->first();

                                                                            @endphp
                                                                            <td>
                                                                                {{ $value['execute_date']
                                                                                    ? 'اعلان التنفيذ'
                                                                                    : ($value['image_date']
                                                                                        ? 'الايمج'
                                                                                        : ($value['case_proof_date']
                                                                                            ? 'إثبات الحالة'
                                                                                            : ($value['travel_date']
                                                                                                ? 'منع السفر'
                                                                                                : ($value['car_date']
                                                                                                    ? 'حجز السيارات'
                                                                                                    : ($value['bank_date']
                                                                                                        ? 'حجز بنوك'
                                                                                                        : ($value['salary_date']
                                                                                                            ? 'حجز راتب'
                                                                                                            : ($value['certificate_date']
                                                                                                                ? 'إصدار شهادة العسكريين'
                                                                                                                : 'فتح ملف'))))))) }}
                                                                            </td>
                                                                            <td>
                                                                                {{ $created_by->name_ar ?? 'لا يوجد' }}
                                                                            </td>
                                                                            <td>
                                                                                @php

                                                                                    $day_start = explode(
                                                                                        ' ',
                                                                                        $value->assign_date,
                                                                                    )[0];
                                                                                    if (is_numeric($day_start)) {
                                                                                        $day_start = date('Y-m-d', $day_start);
                                                                                    }

                                                                                    // Check the end date
                                                                                    if (
                                                                                        $value->end_date &&
                                                                                        $value->end_date != ''
                                                                                    ) {
                                                                                        $day_end = explode(
                                                                                            ' ',
                                                                                            $value->end_date,
                                                                                        )[0];
                                                                                        if (is_numeric($day_end)) {
                                                                                            $day_end = date('Y-m-d', $day_end);
                                                                                        }
                                                                                        $different_day = get_different_date(
                                                                                            $day_start,
                                                                                            $day_end,
                                                                                        );
                                                                                    } else {
                                                                                        // Use current timestamp if end_date is missing
                                                                                        $day_end = 'لم تنتهى';
                                                                                        $different_day = get_different_date(
                                                                                            $day_start,
                                                                                            now()->timestamp,
                                                                                        );
                                                                                    }
                                                                                @endphp
                                                                                {{ $day_start }}

                                                                            </td>
                                                                            <td>{{ $day_end }}</td>

                                                                            <td>
                                                                                {{ $different_day }}
                                                                            </td>

                                                                        </tr>
                                                                    @endforeach
                                                                @else
                                                                    <tr>
                                                                        <td colspan="5"> لا يوجد بيانات</td>
                                                                    </tr>

                                                                @endif
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer d-flex ">
                                                    <button class="btn btn-primary" type="submit"> حفظ

                                                    </button>
                                                    <button type="button"
                                                            class="btn bg-danger-subtle text-danger  waves-effect"
                                                            data-bs-dismiss="modal">
                                                        إغلاق
                                                    </button>
                                                </div>
                                            </form>

                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>

                            </td>


                        </tr>

                    @endif

                @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>

<script>
    function change_bank_satues(val, id) {


        $.ajax({
            type: 'get',
            dataType: "json",
            url: "{{url('change_states_bank')}}/" + id + '/' + val.value,

        success: function(res) {

        },
        error: function(res) {

        }
    });
}

function showInputs(id) {

    document.getElementById("additionalInputs-" + id).style.display = "block";

}
</script>
