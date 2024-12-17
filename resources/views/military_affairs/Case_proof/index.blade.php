<div class="card mt-4 py-3">
    <div class="d-flex flex-wrap ">
        <a href="{{route('case_proof')}}"
           class="btn-filter bg-warning-subtle text-warning px-4 fs-4 mx-1 mb-2">
            العدد الكلي ({{count($items)}})
        </a>

        @foreach($courts as $court)


            <a href="{{route('case_proof',array('governorate_id' => $court->id))}}"
               class="btn-filter {{$court->style}}   px-4 fs-4 mx-1 mb-2"   > {{$court->name_ar}}
            </a>

        @endforeach
    </div>
</div>
<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0"> اثبات الحالة </h4>
    </div>
    <div class="card-body">
        <div class="table-responsive pb-4">
            <table id="all-student" class="table table-bordered border text-nowrap align-middle">

                <thead>

                <tr>
                    <th
                        class="whitespace-nowrap rounded-tr-lg bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                        #
                    </th>
                    <th
                        class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                        رقم المعاملة
                    </th>
                    <th
                        class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                        اسم العميل
                    </th>
                    <th
                        class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                        تاريخ البدء
                    </th>
                    <th
                        class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                        تاريخ فتح الملف
                    </th>
                    <th
                        class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                      المبلغ
                    </th>
                    <th
                        class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                        الرقم الآلي
                    </th>

                        <th
                            class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                            تاريخ النيجة
                        </th>

                    <th
                        class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                        المحكمة
                    </th>

                    <th>
                        تحديد مسئول
                    </th>

                    <th
                        class="whitespace-nowrap rounded-tl-lg bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                        الإجراءات
                    </th>
                </tr>
                </thead>

                <tbody>

                @foreach($items as $item)
                    @if($item->installment->finished==0)
                        @if( Request::has('governorate_id') &&  Request::get('governorate_id') == $item->installment->client->court->id)
                            <tr>
                                <td>
                                    {{ $loop->index + 1 }}
                                </td>
                                <td>
                                    <a href="{{url('installment/show-installment/'.$item->installment->id)}}"> {{$item->installment->id}}</a>



                                    <p>{{$item->different_date}}</p>
                                    <p>{{$item->different_date_open}}</p>

                                </td>
                                <td>
                                    {{$item->installment->client->name_ar}}

                                </td>

                                <td>
                                    {{  $item->final_data   ?   $item->final_data[0] : ''}}
                                </td>
                                <td>
                                    {{$item->open_file_date}}
                                </td>

                                <td>{{$item->eqrar_dain_amount}}</td>

                                <td>{{$item->issue_id}}</td>

                                <td>{{$item->installment->id}}</td>



                                <td>
                                    {{\App\Models\Court::findorfail($item->installment->client->court->id)->name_ar}}
                                </td>
                                <td>
                                    @include('military_affairs.Open_file.partial.column_responsible')
                                </td>
                                <td>
                                    @php

                                        $all_notes=get_all_notes('case_proof',$item->id);
                                        $all_actions=get_all_actions($item->id);
                                        $get_all_delegations = get_all_delegations($item->id);

                                    @endphp
                                    <a class="btn btn-success me-6 my-2"

                                       href="{{url('installment/show-installment/'.$item->installment->id)}}">
                                        التفاصيل</a>
                                    <button class="btn btn-primary me-6 my-2 d-block" data-bs-toggle="modal"
                                            data-bs-target="#open-details-{{$item->id}}">
                                        الملاحظات <span class="badge ms-auto text-bg-secondary">{{count($all_notes)}}</span>
                                    </button>

                                    <button class="btn btn-success me-6 my-2" data-bs-toggle="modal" data-bs-target="#add-note-{{$item->id}}">
                                        تحويل الطلب
                                        للتنفيذ</button>
                                    <div id="open-details-{{$item->id}}" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                            <div class="modal-content">
                                                <form class="mega-vertical"
                                                      action="{{url('add_notes')}}" method="post"
                                                      enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="modal-header d-flex align-items-center">
                                                        <h4 class="modal-title" id="myModalLabel">
                                                            ملاحظات اثبات الحالة  </h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <ul class="nav nav-pills" role="tablist">
                                                            <li class="nav-item">
                                                                <a class="nav-link active" data-bs-toggle="tab" href="#notes-{{$item->id}}" role="tab">
                                                                    <span>الملاحظات</span>
                                                                </a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" data-bs-toggle="tab" href="#navpill-{{$item->id}}" role="tab">
                                                                    <span>الإجراءات</span>
                                                                </a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" data-bs-toggle="tab"
                                                                   href="#actions-{{$item->id}}" role="tab">
                                                                    <span>تتبع المعاملة</span>
                                                                </a>
                                                            </li>

                                                        </ul>
                                                        <!-- Tab panes -->

                                                        <div class="tab-content border mt-2">

                                                            <div class="tab-pane active p-3" id="notes-{{$item->id}}" role="tabpanel">

                                                                <table id="notes1" class="table table-bordered border text-wrap align-middle">
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

                                                                        <tr data-bs-toggle="collapse" data-bs-target="#collapseExample"
                                                                            aria-expanded="false"
                                                                            aria-controls="collapseExample">
                                                                            <td>
                                                                                {{$all_note->created_by}}
                                                                            </td>
                                                                            <td>
                                                                                @php
                                                                                    if($all_note->notes_type=='answered'){
                                                                                      $type= 'رد'   ;
                                                                                    }elseif ($all_note->notes_type=='refused'){
                                                                                      $type= 'لم يرد'   ;
                                                                                    }else{
                                                                                     $type= 'ملاحظة'   ;
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
                                                                            <td>{{$time}}<span class="d-block"></span></td>
                                                                            <td>{{$day}}</td>

                                                                        </tr>

                                                                    @endforeach
                                                                    </tbody>
                                                                </table>
                                                                <div class="add-note">
                                                                    <h4 class="mb-3">اضف ملاحظة</h4>

                                                                    <input type="hidden" name="military_affairs_id"
                                                                           value="{{ $item->id }}">

                                                                    <input type="hidden" name="type"
                                                                           value="{{$item_type_time->type}}">
                                                                    <input type="hidden" name="type_id"
                                                                           value="{{$item_type_time->slug}}">
                                                                    <div class="form-row">
                                                                        <div class="form-group">
                                                                            <label class="form-label"> الاتصال</label>
                                                                            <select class="form-select" name="notes_type">
                                                                                <option
                                                                                    value="answered">
                                                                                    رد
                                                                                </option>
                                                                                <option
                                                                                    value="refused">
                                                                                    لم يرد
                                                                                </option>
                                                                                <option
                                                                                    value="note">
                                                                                    ملاحظة
                                                                                </option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <div class="my-3">
                                                                                <label class="form-label">الملاحظات</label>
                                                                                <textarea name="note" class="form-control" rows="5"></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="tab-pane p-3" id="navpill-{{$item->id}}" role="tabpanel">
                                                                <table id="notes2" class="table table-bordered border text-wrap align-middle">
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
                
                                                                                $day_start = explode(' ', $value->date_start)[0];
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
                                                            data-bs-target="#collapseExample" aria-expanded="false"
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
                                                                    
                                                                $day_start = explode(' ', $value->assign_date)[0];
                                                                    if (is_numeric($day_start)) {
                                                                        $day_start = date('Y-m-d', $day_start);
                                                                    }

                                                                    // Check the end date
                                                                    if ($value->end_date && $value->end_date != '') {
                                                                        $day_end = explode(' ', $value->end_date)[0];
                                                                        if (is_numeric($day_end)) {
                                                                            $day_end = date('Y-m-d', $day_end);
                                                                        }
                                                                        $different_day = get_different_date($day_start, $day_end);
                                                                    } else {
                                                                        // Use current timestamp if end_date is missing
                                                                        $day_end = 'لم تنتهى';
                                                                        $different_day = get_different_date($day_start, now()->timestamp);
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
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer d-flex ">
                                                        <button class="btn btn-primary" type="submit"> حفظ

                                                        </button>
                                                        <button type="button" class="btn bg-danger-subtle text-danger  waves-effect"
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
                                <div id="add-note-{{$item->id}}" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                        <div class="modal-content">
                                            <form class="mega-vertical"
                                                  action="{{url('convert_to_execute')}}" method="post"
                                                  enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="client_job" value="{{$item->installment->client->job_type}}">
                                                <input type="hidden" name="military_affairs_id" value="{{$item->id}}">
                                                <input type="hidden" name="type" value="{{$item_type_time->type}}">
                                                <input type="hidden" name="type_id" value="{{$item_type_time->id}}">
                                                <input type="hidden" name="item_type_travel" value="{{$item_type_travel->id}}">
                                                <input type="hidden" name="item_type_car" value="{{$item_type_car ?  $item_type_car->id : ''}}">
                                                <input type="hidden" name="item_type_bank" value="{{$item_type_bank ?   $item_type_bank->id : ''}}">
                                                <input type="hidden" name="item_type_certificate" value="{{$item_type_certificate ?  $item_type_certificate->id : ''}}">

                                                <div class="modal-header d-flex align-items-center">
                                                    <h4 class="modal-title" id="myModalLabel">
                                                        إثبات حالة</h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">

                                                    <div class="form-row">
                                                        <div class="form-group">
                                                            <label class="form-label" for="input1 "> تاريخ </label>
                                                            <input type="date"  name="date"  class="form-control mb-2" id="input1">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="formFile" class="form-label">اختر صورة </label>
                                                            <input class="form-control" name="img_dir"  accept="image/*" type="file" id="formFile" />
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="modal-footer d-flex ">
                                                    <button type="submit" class="btn btn-primary">حفظ وتحويل لأعلان التنفيذ</button>
                                                    <button type="button" class="btn bg-danger-subtle text-danger  waves-effect" data-bs-dismiss="modal">
                                                        الغاء
                                                    </button>
                                                </div>
                                            </form>
                                        </div>

                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>


                            </tr>
                        @endif
                        @if(!Request::has('governorate_id'))

                            <tr>


                                <td>
                                    {{ $loop->index + 1 }}
                                </td>
                                <td>
                                    <a href="{{url('installment/show-installment/'.$item->installment->id)}}"> {{$item->installment->id}}</a>



                                   <p>{{$item->different_date}}</p>
                                   <p>{{$item->different_date_open}}</p>

                                </td>
                                <td>
                                    {{$item->installment->client->name_ar}}

                                </td>

                                <td>
                                    {{  $item->final_data   ?   $item->final_data[0] : ''}}
                                </td>
                                <td>
                                    {{$item->open_file_date}}
                                </td>

                                <td>{{$item->eqrar_dain_amount}}</td>

                                <td>{{$item->issue_id}}</td>

                                <td>{{$item->a3lan_jalsa_done_date}}</td>



                                <td>
                                    {{\App\Models\Court::findorfail($item->installment->client->court->id)->name_ar}}
                                </td>
                                <td>
                                    @include('military_affairs.Open_file.partial.column_responsible')
                                </td>
                                <td>
                                    @php

                                        $all_notes=get_all_notes('case_proof',$item->id);
                                        $all_actions=get_all_actions($item->id);
                                        $get_all_delegations = get_all_delegations($item->id);

                                    @endphp
                                    <a class="btn btn-success me-6 my-2"

                                       href="{{url('installment/show-installment/'.$item->installment->id)}}">
                                        التفاصيل</a>
                                    <button class="btn btn-primary me-6 my-2 d-block" data-bs-toggle="modal"
                                            data-bs-target="#open-details-{{$item->id}}">
                                        الملاحظات <span class="badge ms-auto text-bg-secondary">{{count($all_notes)}}</span>
                                    </button>

                                    <button class="btn btn-success me-6 my-2" data-bs-toggle="modal" data-bs-target="#add-note-{{$item->id}}" {{ $item->emp_id == 0 || $item->emp_id == null ? 'disabled' : '' }}>
                                        تحويل الطلب
                                        للتنفيذ</button>
                                    <div id="open-details-{{$item->id}}" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                            <div class="modal-content">
                                                <form class="mega-vertical"
                                                      action="{{url('add_notes')}}" method="post"
                                                      enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="modal-header d-flex align-items-center">
                                                        <h4 class="modal-title" id="myModalLabel">
                                                            ملاحظات اثبات الحالة  </h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <ul class="nav nav-pills" role="tablist">
                                                            <li class="nav-item">
                                                                <a class="nav-link active" data-bs-toggle="tab" href="#notes-{{$item->id}}" role="tab">
                                                                    <span>الملاحظات</span>
                                                                </a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" data-bs-toggle="tab" href="#navpill-{{$item->id}}" role="tab">
                                                                    <span>الإجراءات</span>
                                                                </a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" data-bs-toggle="tab"
                                                                   href="#actions-{{$item->id}}" role="tab">
                                                                    <span>تتبع المعاملة</span>
                                                                </a>
                                                            </li>

                                                        </ul>
                                                        <!-- Tab panes -->

                                                        <div class="tab-content border mt-2">

                                                            <div class="tab-pane active p-3" id="notes-{{$item->id}}" role="tabpanel">

                                                                <table id="notes1" class="table table-bordered border text-wrap align-middle">
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

                                                                        <tr data-bs-toggle="collapse" data-bs-target="#collapseExample"
                                                                            aria-expanded="false"
                                                                            aria-controls="collapseExample">
                                                                            <td>
                                                                                {{$all_note->created_by}}
                                                                            </td>
                                                                            <td>
                                                                                @php
                                                                                    if($all_note->notes_type=='answered'){
                                                                                      $type= 'رد'   ;
                                                                                    }elseif ($all_note->notes_type=='refused'){
                                                                                      $type= 'لم يرد'   ;
                                                                                    }else{
                                                                                     $type= 'ملاحظة'   ;
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
                                                                            <td>{{$time}}<span class="d-block"></span></td>
                                                                            <td>{{$day}}</td>

                                                                        </tr>

                                                                    @endforeach
                                                                    </tbody>
                                                                </table>
                                                                <div class="add-note">
                                                                    <h4 class="mb-3">اضف ملاحظة</h4>

                                                                    <input type="hidden" name="military_affairs_id"
                                                                           value="{{ $item->id }}">

                                                                    <input type="hidden" name="type"
                                                                           value="{{$item_type_time->type}}">
                                                                    <input type="hidden" name="type_id"
                                                                           value="{{$item_type_time->slug}}">
                                                                    <div class="form-row">
                                                                        <div class="form-group">
                                                                            <label class="form-label"> الاتصال</label>
                                                                            <select class="form-select" name="notes_type">
                                                                                <option
                                                                                    value="answered">
                                                                                    رد
                                                                                </option>
                                                                                <option
                                                                                    value="refused">
                                                                                    لم يرد
                                                                                </option>
                                                                                <option
                                                                                    value="note">
                                                                                    ملاحظة
                                                                                </option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <div class="my-3">
                                                                                <label class="form-label">الملاحظات</label>
                                                                                <textarea name="note" class="form-control" rows="5"></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="tab-pane p-3" id="navpill-{{$item->id}}" role="tabpanel">
                                                                <table id="notes2" class="table table-bordered border text-wrap align-middle">
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

                                                                $day_start = explode(' ', $value->date_start)[0];
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
                                                            data-bs-target="#collapseExample" aria-expanded="false"
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
                                                                    
                                                                $day_start = explode(' ', $value->assign_date)[0];
                                                                    if (is_numeric($day_start)) {
                                                                        $day_start = date('Y-m-d', $day_start);
                                                                    }

                                                                    // Check the end date
                                                                    if ($value->end_date && $value->end_date != '') {
                                                                        $day_end = explode(' ', $value->end_date)[0];
                                                                        if (is_numeric($day_end)) {
                                                                            $day_end = date('Y-m-d', $day_end);
                                                                        }
                                                                        $different_day = get_different_date($day_start, $day_end);
                                                                    } else {
                                                                        // Use current timestamp if end_date is missing
                                                                        $day_end = 'لم تنتهى';
                                                                        $different_day = get_different_date($day_start, now()->timestamp);
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
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer d-flex ">
                                                        <button class="btn btn-primary" type="submit"> حفظ

                                                        </button>
                                                        <button type="button" class="btn bg-danger-subtle text-danger  waves-effect"
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
                                <div id="add-note-{{$item->id}}" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                        <div class="modal-content">
                                            <form class="mega-vertical"
                                                  action="{{url('convert_to_execute')}}" method="post"
                                                  enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="client_job" value="{{$item->installment->client->job_type}}">
                                                <input type="hidden" name="military_affairs_id" value="{{$item->id}}">
                                                <input type="hidden" name="type" value="{{$item_type_time->type}}">
                                                <input type="hidden" name="type_id" value="{{$item_type_time->id}}">
                                                <input type="hidden" name="item_type_travel" value="{{$item_type_travel->id}}">
                                                <input type="hidden" name="item_type_car" value="{{$item_type_car ?  $item_type_car->id : ''}}">
                                                <input type="hidden" name="item_type_bank" value="{{$item_type_bank ?   $item_type_bank->id : ''}}">
                                                <input type="hidden" name="item_type_certificate" value="{{$item_type_certificate ?  $item_type_certificate->id : ''}}">
                                                <div class="modal-header d-flex align-items-center">
                                                    <h4 class="modal-title" id="myModalLabel">
                                                        إثبات حالة</h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">

                                                    <div class="form-row">
                                                        <div class="form-group">
                                                            <label class="form-label" for="input1 "> تاريخ </label>
                                                            <input type="date"  name="date"  class="form-control mb-2" id="input1">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="formFile" class="form-label">اختر صورة </label>
                                                            <input class="form-control" name="img_dir"  accept="image/*" type="file" id="formFile" />
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="modal-footer d-flex ">
                                                    <button type="submit" class="btn btn-primary">حفظ وتحويل لأعلان التنفيذ</button>
                                                    <button type="button" class="btn bg-danger-subtle text-danger  waves-effect" data-bs-dismiss="modal">
                                                        الغاء
                                                    </button>
                                                </div>
                                            </form>
                                        </div>

                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>


                            </tr>
                        @endif

                    @endif
                @endforeach
                </tbody>

            </table>


        </div>


    </div>
</div>
<script>



</script>

