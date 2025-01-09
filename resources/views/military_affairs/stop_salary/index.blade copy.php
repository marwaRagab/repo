@php
$arr=['success','danger','primary','secondary','info','warning'];

@endphp
<div class="card mt-4 py-3">
    <div class="d-flex flex-wrap ">
        <a class="btn-filter bg-warning-subtle text-warning px-2  mx-1 mb-2">

            العدد الكلي ({{ count($govern_count_total) }})
        </a>


    </div>
</div>

<div class="card mt-4 py-3">
    <div class="d-flex flex-wrap ">

        <a class="btn-filter  bg-success-subtle text-success px-4  mx-1 mb-2">
            طلب حجز الراتب ()
        </a>
        <a class="btn-filter  bg-success-subtle text-success px-4  mx-1 mb-2">
            أمر حجز الراتب
            () </a>

        <a class="btn-filter bg-danger-subtle text-danger px-4  mx-1 mb-2">

            صباح السالم
            () </a>
        <a class="btn-filter px-4 bg-primary-subtle text-primary mx-1 mb-2">
            شئون القوة ()
        </a>
        <a class="btn-filter bg-danger-subtle text-danger px-4  mx-1 mb-2">
            المالية ()
        </a>
        <a class="btn-filter me-1 mb-1  bg-warning-subtle text-warning  px-4  mx-1 mb-2 ">
            الاستقطاع ()
        </a>

        <a class="btn-filter bg-danger-subtle text-danger px-4  mx-1 mb-2">
            طلب رفع الحجز ()
        </a>
        <a class="btn-filter me-1 mb-1  bg-warning-subtle text-warning  px-4  mx-1 mb-2 ">
            رفع الحجز ()
        </a>
    </div>
</div>
<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0"> حجز راتب </h4>
    </div>
    <div class="card-body">
        <div class="table-responsive pb-4">
            <table id="all-student" class="table table-bordered border text-nowrap align-middle">
                <thead>
                    <!-- start row -->
                    <tr>
                        <th>م</th>
                        <th> رقم المعاملة</th>
                        <th>اسم العميل</th>
                        <th> الوزارة</th>
                        <th> المحكمة</th>
                        <th> المبلغ</th>
                        <th> تاريخ فتح الملف</th>
                        <th>
                            الرقم الآلي
                        </th>
                        <?php if ($stop_salary_type === 'stop_salary_request') { ?>
                        <th> طلب حجز راتب</th>
                        <?php } ?>
                        <?php if ($stop_salary_type === 'stop_salary_doing') { ?>
                        <th>
                            أمر حجز راتب
                        </th>
                        <?php } ?>
                        <?php if ($stop_salary_type === 'stop_salary_military_judgement') { ?>
                        <th>
                            القضاء العسكري
                        </th>
                        <?php } ?>
                        <?php if ($stop_salary_type === 'stop_salary_sabah_salem') { ?>
                        <th>
                            صباح السالم
                        </th>
                        <?php } ?>
                        <?php if ($stop_salary_type === 'stop_salary_force_affairs') { ?>
                        <th>
                            القضاء العسكري
                        </th>
                        <?php } ?>


                        <?php if ($stop_salary_type === 'stop_salary_money') { ?>
                        <th>
                            المالية
                        </th>
                        <?php } ?>
                        <?php if ($stop_salary_type === 'stop_salary_part') { ?>
                        <th>
                            الاستقطاع
                        </th>
                        <th>
                            تعديل الاستقطاع
                        </th>
                        <?php } ?>
                        <?php if ($stop_salary_type == 'stop_salary_money') { ?>

                        <?php } ?>
                        <?php if ($stop_salary_type === 'stop_salary_cancel_request') { ?>
                        <th>
                            طلب رفع الحجز
                        </th>
                        <?php } ?>
                        <?php if ($stop_salary_type === 'stop_salary_cancel') { ?>
                        <th>
                            تفاصيل رف الحجز
                        </th>
                        <?php } ?>

                        <th> الاجراءات</th>

                    </tr>
                    <!-- end row -->
                </thead>
                <tbody>

                    <!-- start row -->
                    @php $i=1; @endphp
                    @foreach ($transactions as $one)
                    <tr data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false"
                        aria-controls="collapseExample">
                        <td>
                            {{$i}}
                        </td>
                        <td>
                            <a href="#">{{$one->id}}</a>
                        </td>
                        <td>{{$one->name_ar}}<br />{{ $one->civil_number }}<br />{{ $one->phone_ids }}</td>
                        <td>{{ $one->governate_id }}</td>
                        <td>{{ $one->eqrar_dain_amount }}</td>
                        <td>{{$one->issue_id}}</td>

                        <td>
                            <div class="btn-group dropup mb-6 me-6 d-block ">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    الإجراءات
                                </button>
                                <ul class="dropdown-menu rounded-0" aria-labelledby="dropdownMenuButton">
                                    <li>
                                        <a class="btn btn-success rounded-0 w-100 mt-2" data-bs-toggle="modal"
                                            data-bs-target="#open-file"> رفع الصور
                                        </a>
                                    </li>
                                    <li>
                                        <a class="btn btn-warning rounded-0 w-100 mt-2" data-bs-toggle="modal"
                                            data-bs-target="#open-details-{{ $one->id }}">
                                            ملاحظات</a>
                                    </li>
                                    <li>
                                        <a class="btn btn-primary rounded-0 w-100 mt-2" data-bs-toggle="modal"
                                            data-bs-target="#open-settle-{{ $one->id }}">
                                            تحويل للتسوية </a>
                                    </li>
                                </ul>


                            </div>

                        </td>
                    </tr>

                    <div id="open-details-{{ $one->id }}" class="modal fade" tabindex="-1"
                        aria-labelledby="bs-example-modal-md" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                            <div class="modal-content">
                                <div class="modal-header d-flex align-items-center">
                                    <h4 class="modal-title" id="myModalLabel">
                                        ملاحظات حجز السيارات
                                    </h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <!-- Tab panes -->
                                    <div class="tab-content border mt-2">
                                        @php

                                        $all_notes=get_all_notes('stop_car',$item->id);
                                        @endphp
                                        <div class="tab-pane active p-3" id="navpill-1" role="tabpanel">
                                            <form class="mega-vertical" action="{{url('add_notes')}}" method="post"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-row">
                                                    <input type="hidden" name="military_affairs_id"
                                                        value="{{ $item->id }}">
                                                    <input type="hidden" name="id_time_type_old"
                                                        value="{{$item_type_time->id}}">
                                                    <input type="hidden" name="id_time_type_new"
                                                        value="{{$item_type_time_new->id}}">
                                                    <input type="hidden" name="type" value="{{$item_type_time->type}}">
                                                    <input type="hidden" name="type_id" value="{{$item_type_time->id}}">

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

                                                            @error('note')
                                                            <div style='color:red'>{{$message}}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">حفظ</button>
                                                    <button type="button"
                                                        class="btn bg-danger-subtle text-danger  waves-effect"
                                                        data-bs-dismiss="modal">
                                                        الغاء
                                                    </button>
                                                </div>
                                            </form>

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
                                                    <!-- start row -->
                                                    @foreach($all_notes as $all_note)

                                                    <tr data-bs-toggle="collapse" data-bs-target="#collapseExample"
                                                        aria-expanded="false" aria-controls="collapseExample">
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
                                                        <td>{{$time}}<span class="d-block"></span>
                                                        </td>
                                                        <td>{{$day}}</td>

                                                    </tr>

                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                    <div class="modal-footer d-flex ">
                                        <button type="button" class="btn bg-danger-subtle text-danger  waves-effect"
                                            data-bs-dismiss="modal">
                                            إغلاق
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="open-settle{{ $one->id }}" class="modal fade" tabindex="-1"
                            aria-labelledby="bs-example-modal-md" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header d-flex align-items-center">
                                        <h4 class="modal-title" id="myModalLabel">
                                            إثبات حالة</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <h6>
                                            الإسم :
                                            <span class="text-muted">ناصر علي محمد المرى ( 649 ) </span>
                                        </h6>
                                        <h6>
                                            الرقم المدنى :
                                            <span class="text-muted">275071100845 </span>
                                        </h6>
                                        <h6>
                                            رقم الهاتف :
                                            <span class="text-muted">97845338 </span>
                                        </h6>
                                        <h6>
                                            مبلغ المديونية :
                                            <span class="text-muted">2,550.000 </span>
                                        </h6>
                                        <h6>
                                            المدفوع :
                                            <span class="text-muted"> 595.000 </span>
                                        </h6>
                                        <h6>
                                            المبلغ المتبقى :
                                            <span class="text-muted"> 1,955.000</span>
                                        </h6>
                                        <form>
                                            <div class="form-row flex-wrap d-flex gap-3 p-3 border mt-3">
                                                <div class="form-group">
                                                    <label for="amount" class="form-label"> مبلغ التسوية </label>
                                                    <input type="text" name="amount" id="amount" value="1,955.000"
                                                        class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label for="first_amount_settle" class="form-label"> مقدم التسوية
                                                    </label>
                                                    <input type="text" name="first_amount_settle"
                                                        id="first_amount_settle" class="form-control ">
                                                </div>

                                                <div class="form-group">
                                                    <label for="remainder" class="form-label"> المتبقى </label>
                                                    <input type="text" name="remainder" id="remainder"
                                                        class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label for="installment_no" class="form-label"> عدد الاقساط </label>
                                                    <select class="form-control" name="installment_no"
                                                        id="installment_no">
                                                        <option value=" ">اختار العدد </option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                    </select>

                                                </div>

                                                <div class="form-group">
                                                    <label for="inst_value" class="form-label"> قيمة القسط الشهرى
                                                    </label>
                                                    <input type="text" class="form-control" name="inst_value"
                                                        id="inst_value">

                                                </div>
                                                <div class="form-group">
                                                    <label for="last_inst_value" class="form-label"> قيمة القسط الاخير
                                                    </label>
                                                    <input type="text" class="form-control" name="last_inst_value"
                                                        id="last_inst_value">

                                                </div>
                                                <div class="form-group">
                                                    <label for="settle_date" class="form-label"> تاريخ دفع المقدم
                                                    </label>
                                                    <input type="date" class="form-control " name="settle_date"
                                                        id="settle_date">
                                                </div>
                                                <div class="form-group">

                                                    <label for="action_id" class="form-label"> اختر الاجراء </label>
                                                    <select class="form-control" name="action[]" id="action_id">
                                                        <option value="all">الكل </option>
                                                        <option value="3">رفع حجز بنك </option>
                                                        <option value="2">رفع حجز راتب </option>
                                                        <option value="1">رفع حجز سيارات </option>
                                                        <option value="0"> رفع منع سفر </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer d-flex ">
                                        <button type="submit" class="btn btn-primary">حفظ </button>
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

                        @php $i++; @endphp
                        @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>


@foreach ($items as $item)
                    @php
                     $new_date = $item->notes->where('type','stop_salary')->first();
                     $type_date = $item->notes->where('type','stop_salary')->where('cat2', request()->get('type'))->first();
                    @endphp
                    <tr>
                        <td>
                            {{ $loop->iteration }}
                        </td>
                        <td>
                            <a href="{{url('installment/show-installment/'.$item->installment->id)}}">
                                {{$item->installment->id}}</a>
                            <br />
                            {!! getDiffTodayDates($item->open_file_date, null) !!}
                            <br /> <br />
                            @if(request()->has('minsitry_id') && optional($type_date)->date )
                            {!! getDiffTodayDates(optional($new_)->date, null) !!} 
                            @endif

                            @if(request()->has('minsitry_id') && (request()->has('type') == false) && optional($new_date)->date )
                            {!! getDiffTodayDates(\Carbon\Carbon::parse(optional($item->notes->where('type','stop_salary')->first())->date)->format('Y-m-d'), null)  !!}**
                            @endif
                            @if(request()->has('type') && optional($type_date)->date)
                            {!! getDiffTodayDates(\Carbon\Carbon::parse(optional($item->notes->where('type','stop_salary')->where('cat2', request()->get('type'))->first()->date))->format('Y-m-d'), null) !!}
                            @endif
                        </td>
                        <td>{{$item->installment->client->name_ar}}
                        </td>
                        <td>{{$item->installment->client->get_ministry->name_ar }}
                        </td>
                        <td>{{$item->installment->client->court ?  \App\Models\Court::where('governorate_id', $item->installment->client->court->id)->first()->name_ar : ''}}
                        </td>
                        <td>{{ $item->eqrar_dain_amount }}</td>
                        <td>{{ $item->open_file_date}}</td>
                        <td>{{$item->issue_id}}</td>
                        @if(request()->has('type'))
                        <td>
                            <button class="btn btn-success me-6 my-2" data-bs-toggle="modal"
                                data-bs-target="#convert_command-{{$item->id}}"
                                onclick="check_delegate({{$item->emp_id}})"> {{ $type_name }}
                            </button>
                            @if($item->emp_id && $item->emp_id != '')
                            <div id="convert_command-{{$item->id}}" class="modal fade convert_command" tabindex="-1"
                                aria-labelledby="bs-example-modal-md" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                    <div class="modal-content">
                                        <form class="mega-vertical" action="{{route('stop_salary_convert', $item->id)}}"
                                            method="post" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="military_affairs_id" value="{{$item->id}}">
                                            <input type="hidden" name="ministry_id"
                                                value="{{$item->installment->client->get_ministry->id}}">
                                            <input type="hidden" name="type" value="{{$item_type_time1->type}}">
                                            <input type="hidden" name="type_id" value="{{request()->get('type')}}">
                                            <input type="hidden" name="item_type_new"
                                                value="{{request()->get('type')}}">
                                            <input type="hidden" name="item_type_old"
                                                value="{{request()->get('type')}}">

                                            <div class="modal-header d-flex align-items-center">
                                                <h4 class="modal-title" id="myModalLabel">
                                                    حجز راتب </h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">

                                                <div class="form-row">
                                                    <div class="form-group">
                                                        <label class="form-label" for="input1 ">
                                                            تاريخ </label>
                                                        <input type="date" name="date" class="form-control mb-2"
                                                            id="input1">
                                                        @error('date')
                                                        <div style='color:red'>{{$message}}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="formFile" class="form-label">اختر
                                                            صورة </label>
                                                        <input class="form-control" name="img_dir" accept="image/*"
                                                            type="file" id="formFile" />
                                                        @error('img_dir')
                                                        <div style='color:red'>{{$message}}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="modal-footer d-flex ">
                                                <button type="submit" class="btn btn-primary">حفظ
                                                </button>
                                                <button type="button"
                                                    class="btn bg-danger-subtle text-danger  waves-effect"
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
                            @endif
                        </td>
                        @endif
                        <td>
                            @include('military_affairs.Open_file.partial.column_responsible')
                        </td>
                        <td>

                            <div class="btn-group dropup mb-6 me-6 d-block ">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    الإجراءات
                                </button>
                                <ul class="dropdown-menu rounded-0" aria-labelledby="dropdownMenuButton">

                                    <li>
                                        <a class="btn btn-success rounded-0 w-100 mt-2" data-bs-toggle="modal"
                                            data-bs-target="#open-details-{{ $item->id }}">
                                            ملاحظات</a>
                                    </li>
                                    <li>
                                        @php $date =
                                        $item->status_all->where('type_id','stop_salary_doing')->whereNotNull('date')?->first()?->date;
                                        @endphp

                                        @if( $date != 0 )
                                        <span class="btn btn-warning rounded  w-100 mt-2"> يوجد تسوية </span>
                                        @elseif($item->installment->finished == 1)
                                        <span class="btn btn-danger rounded  w-100 mt-2">تم انهاء المعاملة</span>
                                        @else
                                        <a class="btn btn-primary rounded-0 w-100 mt-2  @if($item->emp_id == '') disabled @endif"
                                            @if($item->emp_id != '')
                                            href="{{url('show_settlement/'.$item->id)}}" @endif
                                            >
                                            تحويل للتسوية </a>
                                        @endif
                                    </li>
                                </ul>

                            </div>
                            <div id="open-details-{{ $item->id }}" class="modal fade" tabindex="-1"
                                aria-labelledby="bs-example-modal-md" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header d-flex align-items-center">
                                            <h4 class="modal-title" id="myModalLabel">
                                                ملاحظات حجز الراتب
                                            </h4>
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

                                            </ul>
                                            <!-- Tab panes -->

                                            <div class="tab-content border mt-2">
                                                @php

                                                $all_notes=get_all_notes('stop_salary',$item->id);
                                                $all_actions = get_all_actions($item->id);
                                                $get_all_delegations = get_all_delegations($item->id);
                                                @endphp

                                                <div class="tab-pane active p-3" id="notes-{{ $item->id }}"
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


                                                            @if (count($all_notes) > 0)
                                                            <!-- start row -->
                                                            @foreach ($all_notes as $all_note)
                                                            <tr data-bs-toggle="collapse"
                                                                data-bs-target="#collapseExample" aria-expanded="false"
                                                                aria-controls="collapseExample">
                                                                <td>
                                                                    {{ $all_note->created_by }}
                                                                </td>
                                                                <td>
                                                                    @php
                                                                    if ($all_note->notes_type == 'answered') {
                                                                    $type = 'رد';
                                                                    } elseif ($all_note->notes_type == 'refused') {
                                                                    $type = 'لم يرد';
                                                                    } else {
                                                                    $type = 'ملاحظة';
                                                                    }

                                                                    @endphp
                                                                    {{ $type }}
                                                                </td>
                                                                <td>
                                                                    <p>
                                                                        {{ $all_note->note }}
                                                                    </p>
                                                                </td>
                                                                @php
                                                                $time = explode(' ', $all_note->date)[1];
                                                                $day = explode(' ', $all_note->date)[0];

                                                                @endphp
                                                                <td>{{ $time }}<span class="d-block"></span>
                                                                </td>
                                                                <td>{{ $day }}</td>

                                                            </tr>
                                                            @endforeach
                                                            @else
                                                            <tr>
                                                                <td colspan="5"> لا يوجد بيانات</td>
                                                            </tr>

                                                            @endif

                                                        </tbody>
                                                    </table>
                                                    <div class="add-note">
                                                        <h4 class="mb-3">اضف ملاحظة</h4>
                                                        <input type="hidden" name="military_affairs_id"
                                                            value="{{ $item->installment_id }}">
                                                        <input type="hidden" name="id_time_type_old"
                                                            value="{{ $item_type_time->first()->id ?? '' }}">

                                                        <input type="hidden" name="id_time_type_new"
                                                            value="{{ $item_type_time_new->id ?? '' }}">

                                                        <input type="hidden" name="type"
                                                            value="{{ $item_type_time->first()->type ?? '' }}">

                                                        <input type="hidden" name="type_id"
                                                            value="{{ $item_type_time->first()->slug ?? '' }}">

                                                        <div class="form-row">
                                                            <div class="form-group">
                                                                <label class="form-label">
                                                                    الاتصال</label>
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
                                                                    @error('note')
                                                                    <div style='color:red'>{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane p-3" id="navpill-{{$item->id}}" role="tabpanel">
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
                                                            @if (count($all_actions) > 0 )
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
                                                                    $different_day = get_different_date(
                                                                    $day_start,
                                                                    $day_end,
                                                                    );
                                                                    } else {
                                                                    $day_end = 'لم تنتهى';
                                                                    $different_day = get_different_date(
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
                                                            @else
                                                            <tr>
                                                                <td colspan="5"> لا يوجد بيانات</td>
                                                            </tr>

                                                            @endif

                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="tab-pane p-3" id="actions-{{$item->id}}" role="tabpanel">
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
                                                            @if (count($get_all_delegations) > 0 )
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
                                                            @else
                                                            <tr>
                                                                <td colspan="5"> لا يوجد بيانات</td>
                                                            </tr>

                                                            @endif

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="modal-footer d-flex ">
                                                <button type="button"
                                                    class="btn bg-danger-subtle text-danger  waves-effect"
                                                    data-bs-dismiss="modal">
                                                    إغلاق
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </td>

                    </tr>



                    @endforeach



                    


@if(request()->has('minsitry_id') && !request()->has('type')  )
                            {!! getDiffTodayDates(\Carbon\Carbon::parse($item->notes->where('type','stop_salary')->first()->date)->format('Y-m-d'), null) !!}
                            @endif
                            @if(request()->has('type'))
                            {!! getDiffTodayDates(\Carbon\Carbon::parse($item->notes->where('type','stop_salary')->where('cat2', request()->get('type'))->first()->date)->format('Y-m-d'), null) !!}
                            @endif




                            @if(request()->has('minsitry_id') && (request()->has('type') == false) && optional($new_date)->date )
                            {!! getDiffTodayDates(\Carbon\Carbon::parse(optional($new_date)->date)->format('Y-m-d'), null)   !!}
                            @endif
                            @if(request()->has('type') && optional($type_date)->date)
                            {!! getDiffTodayDates(optional($type_date)->date, null)  !!}
                            @endif