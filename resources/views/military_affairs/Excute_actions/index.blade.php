<div class="card mt-4 py-3">
    <div class="d-flex flex-wrap ">
        <a class="btn-filter bg-warning-subtle text-warning px-2  mx-1 mb-2 {{ request()->get('governorate_id') == '' ? 'active' : '' }}" href="{{route('excute_actions')}}">
            الكل ({{ count_court('' ,'excute_actions',null,null) }})
        </a>
        @foreach($courts as $court)

        <a href="{{route('excute_actions',array('governorate_id' => $court->id))}}"
            class="btn-filter {{$court->style}}   px-2  mx-1 mb-2 {{ request()->get('governorate_id') == $court->id ? 'active' : '' }}"> {{$court->name_ar}}
            ({{ count_court($court->id ,'excute_actions',null,null) }})
        </a>

        @endforeach
    </div>
</div>
<div class="card">
    <div class="d-flex align-items-center justify-content-between px-2 py-3 border-bottom">
        <h4 class="card-title mb-0"> الشيكات المستلمة</h4>
        <a class="btn me-1 mb-1 bg-primary-subtle text-primary px-2  " href="{{route('all_checks')}}">
            الشيكات المستلمة</a>
    </div>

    <div class="card-body">
        <div class="table-responsive pb-4">
            <table id="all-student" class="table table-bordered border text-nowrap align-middle">
                <thead>
                    <!-- start row -->
                    <tr>
                        <th>#</th>


                        <th> اسم العميل</th>
                        <th> الرقم الالي
                        </th>
                        <th>مبلغ المديونية</th>

                        <th>المحصل تنفيذ</th>
                        <th> رصيد التنفيذ</th>
                        <th> عدد الدفعات</th>
                        <th> عدد الاستعلامات</th>
                        <th> المتبقى</th>
                        <th> تاريخ اخر استعلام</th>
                        <th> الاجراءات</th>

                    </tr>
                    <!-- end row -->
                </thead>
                <tbody>
                    <!-- start row -->
                    @foreach( $items as $item)
                    @if($item->installment)


                    <tr>
                        <td>
                             {{ $loop->iteration }}

                        </td>
                        <td>
                            {{$item->installment->client->name_ar}}
                            <br>
                            ({{$item->installment->id}})
                            <br>
                            {{$item->installment->client-> civil_number}}
                        </td>
                        <td>{{$item->issue_id}}</td>
                        <td>{{$item->eqrar_dain_amount}}</td>
                        <td>{{$item->military_check->sum('amount')}} </td>
                        <td>{{$item->military_amount->where('military_affairs_check_id',0)->sum('amount')}} </td>

                        <td> {{$item->military_amount->where('military_affairs_check_id',0)->where('check_type','!=','0')->count()}}</td>
                        <td> {{$item->military_amount ? count($item->military_amount) : 0 }} </td>
                        <td> {{$item->reminder_amount}} </td>
                        <td>{{$item->excute_actions_last_date_check}} </td>
                        <td>
                            <div class="btn-group dropup mb-6 me-6 d-block ">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    الإجراءات
                                </button>
                                <ul class="dropdown-menu rounded-0" aria-labelledby="dropdownMenuButton">
                                    <li>
                                        <a class="btn btn-success rounded-0 w-100 mt-2" href=""> صورة الاجراءات المالية
                                        </a>
                                    </li>
                                    <li>
                                        <a class="btn btn-warning rounded-0 w-100 mt-2"
                                            href="{{ route('installment.show-installment', ['id' => $item->installment->id]) }}">
                                            التفاصيل</a>
                                    </li>

                                    <li>
                                        <a class="btn btn-primary rounded-0 w-100 mt-2" href="">
                                            تحويل للتسوية </a>
                                    </li>
                                    <li>
                                        <a class="btn btn-success rounded-0 w-100 mt-2" data-bs-toggle="modal"
                                            data-bs-target="#add-amount-{{$item->id}}"> اضافة استعلام
                                        </a>
                                    </li>

                                    @if($item->excute_actions_amount)
                                    <li>
                                        <a class="btn btn-primary rounded-0 w-100 mt-2" data-bs-toggle="modal"
                                            data-bs-target="#add-check-{{$item->id}}"> استلام الشيكات
                                        </a>
                                    </li>
                                    @endif


                                </ul>


                            </div>
                            <div id="add-amount-{{$item->id}}" class="modal fade" tabindex="-1"
                                aria-labelledby="bs-example-modal-md" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                    <div class="modal-content">
                                        <form class="mega-vertical" action="{{url('add_amount')}}" method="post"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-header d-flex align-items-center">
                                                <h4 class="modal-title" id="myModalLabel">
                                                    الملاحظة</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">

                                                <div class="form-row">

                                                    <div class="mb-7">
                                                        <label>
                                                            <input type="radio" name="check_found" value="1"
                                                                onclick="showInputs({{$item->id}})"> يوجد
                                                        </label>
                                                        <label>
                                                            <input type="radio" name="check_found" value="0"
                                                                onclick="hideInput({{$item->id}})"> لا يوجد
                                                        </label>
                                                        <input type="hidden" name="military_affairs_id"
                                                            value="{{$item->id}}">
                                                        <div id="additionalInputs-{{$item->id}}" class="hidden">
                                                            <div class="form-group mb-3">
                                                                <label class="form-label"> المبلغ </label>
                                                                <input type="text" name="amount"   class="form-control">

                                                            </div>
                                                            <div class="form-row mb-3 ">
                                                                <div class="form-group">
                                                                    <label class="form-label">
                                                                        مصدر الحجز</label>
                                                                    <select class="form-select" name="check_type">
                                                                        <option value="0">
                                                                           اختر
                                                                        </option>
                                                                        <option value="salary">
                                                                            حجز راتب
                                                                        </option>
                                                                        <option value="banks">
                                                                            حجز بنوك
                                                                        </option>
                                                                        <option value="cars">
                                                                            حجز سيارة
                                                                        </option>
                                                                        <option value="mahkama_madionia_sadad">
                                                                            سداد مديونية محكمة
                                                                        </option>

                                                                        <option value="mahkama_installment">
                                                                            تقسيط محكمة
                                                                        </option>
                                                                    </select>

                                                                </div>

                                                            </div>

                                                            <div class="form-group mb-3">
                                                                <label class="form-label">التاريخ</label>
                                                                <input type="date" name="date" class="form-control">

                                                            </div>
                                                            <div class="form-group my-3">
                                                                <label for="formFile" class="form-label">الصورة </label>
                                                                <input class="form-control" name="img_dir" type="file"
                                                                    id="formFile">

                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                            <div class="modal-footer d-flex ">
                                                <button type="submit" class="btn btn-primary">حفظ</button>
                                                <button type="button"
                                                    class="btn bg-danger-subtle text-danger  waves-effect"
                                                    data-bs-dismiss="modal">
                                                    الغاء
                                                </button>
                                            </div>

                                        </form>
                                    </div>

                                </div>
                            </div>
                            <div id="add-check-{{$item->id}}" class="modal fade" tabindex="-1"
                                aria-labelledby="bs-example-modal-md" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                    <form class="mega-vertical_open" action="{{url('add_check')}}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header d-flex align-items-center">
                                                <h4 class="modal-title" id="myModalLabel">
                                                    الملاحظة</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                @php
                                                $check_amount =
                                                $item->military_amount->where('military_affairs_check_id',0)->sum('amount');
                                                @endphp
                                                <input type="hidden" name="military_affairs_id" value="{{$item->id}}" />
                                                   <input type="hidden" name="check_value"  id="check_value" value="{{$check_amount}}">
                                                <div class="form-row">
                                                    <div class="form-group mb-3">
                                                        <label class="form-label">مبلغ الشيك </label>
                                                        @if(Auth::user()->username =='ahmedkh222')
                                                            <input type="text" name="check_amount"   value="{{$check_amount}}"  class="form-control">
                                                        @else
                                                            <input type="text" name="check_amount" readonly
                                                                   value="{{$check_amount}}"
                                                                   class="form-control">
                                                        @endif

                                                        @error('check_amount')
                                                        <div style='color:red'>{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label class="form-label">رقم الشيك </label>
                                                        <input type="text" name="check_number" value=""
                                                            class="form-control">
                                                        @error('check_number')
                                                        <div style='color:red'>{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label class="form-label">تاريخ </label>
                                                        <input type="date" name="date" class="form-control">
                                                        @error('date')
                                                        <div style='color:red'>{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <div class="form-group my-3">
                                                        <label for="formFile" class="form-label">الصورة </label>
                                                        <input class="form-control" name="img_dir" accept="image/*"
                                                            type="file" id="formFile">
                                                        @error('img_dir')
                                                        <div style='color:red'>{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                </div>

                                            </div>
                                            <div class="modal-footer d-flex ">
                                                <button type="submit" class="btn btn-primary">حفظ</button>
                                                <button type="button"
                                                    class="btn bg-danger-subtle text-danger  waves-effect"
                                                    data-bs-dismiss="modal">
                                                    الغاء
                                                </button>
                                            </div>

                                        </div>
                                    </form>
                                </div>
                            </div>


                            <button class="btn btn-success me-6" data-bs-toggle="modal"
                                data-bs-target="#add-note-{{$item->id}}">
                                ملاحظة
                            </button>

                            <div id="add-note-{{$item->id}}" class="modal fade" tabindex="-1"
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

                                                </ul>
                                                <!-- Tab panes -->

                                                <div class="tab-content border mt-2">
                                                    @php

                                                    $all_notes=get_all_notes('excute_actions',$item->id);
                                                    $all_actions=get_all_actions($item->id);
                                                    $get_all_delegations = get_all_delegations($item->id);

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
                                                                @if (count($all_notes) > 0 )
                                                                @foreach($all_notes as $all_note)

                                                                <tr data-bs-toggle="collapse"
                                                                    data-bs-target="#collapseExample"
                                                                    aria-expanded="false"
                                                                    aria-controls="collapseExample">
                                                                    <td>
                                                                        {{\App\Models\User::findorfail($all_note->created_by)->first() ?    \App\Models\User::findorfail($all_note->created_by)->first()->name_ar : ''}}
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


                                                                    <td>{{$time}}}<span class="d-block"></span></td>
                                                                    <td>{{$day}}</td>

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
                                                                value="{{ $item->id }}">


                                                            <input type="hidden" name="type"
                                                                value="{{$item_type_time->type}}">
                                                            <input type="hidden" name="type_id"
                                                                value="{{$item_type_time->id}}">
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

                                                                        $day_start = explode(' ',
                                                                        $value->date_start)[0];
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
                                                                @if (count($get_all_delegations) > 0 )
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


<!-- modals -->
<script>
function showInputs(id) {
    document.getElementById('additionalInputs-'+id).classList.remove('hidden');
}

function hideInput(id) {
    document.getElementById('additionalInputs-'+id).classList.add('hidden');
}


document.addEventListener("DOMContentLoaded", function () {
    const forms = document.querySelectorAll('.mega-vertical_open');

    forms.forEach(form => {
        form.addEventListener("submit", function (event) {
            let isValid = true;

            // Clear previous error messages
            form.querySelectorAll(".error-message").forEach(e => e.remove());

            // Validate date
            const dateInput = form.querySelector("input[name='date']");
            if (!dateInput.value) {
                showError(dateInput, "التاريخ   مطلوب");
                isValid = false;
            } const checknumber = form.querySelector("input[name='check_number']");
            if (!checknumber.value) {
                showError(checknumber, "رقم الشيك   مطلوب");
                isValid = false;
            }

            // Validate issue_id
            const checkInput = form.querySelector("input[name='check_amount']");
            const  checkvalue= form.querySelector("input[name='check_value']");
            const  check_img= form.querySelector("input[name='img_dir']");
            if ( checkInput.value == 0 ) {
                showError(checkInput, "مبلغ الشيك مطلوب");
                isValid = false;
            }else if (checkInput.value > checkvalue.value) {
                showError(checkInput,   "مبلغ الشيك لابد ان يكون اقل من" + checkvalue.value);
                isValid = false;
            }else if (!check_img.value) {
                showError(check_img,   "صورة الشيك مطلوبة " );
                isValid = false;
            }

            // Validate place


            if (!isValid) {
                event.preventDefault(); // Prevent form submission if validation fails
            }
        });
    });


});






</script>
