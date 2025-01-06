<div id="open-details-{{$item->id}}" class="modal fade" tabindex="-1"
     aria-labelledby="bs-example-modal-md" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <form class="mega-vertical"
                  action="{{url('add_notes')}}" method="post"
                  enctype="multipart/form-data">
                @csrf
                <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="myModalLabel">
                        ملاحظات منع السفر </h4>
                    <button type="button" class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-pills" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active"
                               data-bs-toggle="tab"
                               href="#navpill-{{$item->id}}" role="tab">
                                <span>الملاحظات</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab"
                               href="#notes-{{$item->id}}" role="tab">
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

                    @if(count($items)>=1)

                        <div class="tab-content border mt-2">



                            <div class="tab-pane active p-3"
                                 id="navpill-{{$item->id}}"
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


                                    @if (count($item->all_notes) > 0)
                                        <!-- start row -->
                                        @foreach ($item->all_notes as $all_note)
                                            <tr data-bs-toggle="collapse"
                                                data-bs-target="#collapseExample"
                                                aria-expanded="false" aria-controls="collapseExample">
                                                @php
                                                    $created_by = DB::table('users')
                                                        ->where('id', $all_note->created_by)
                                                        ->first();

                                                @endphp
                                                <td>{{ $created_by->name_ar ?? 'لا يوجد' }}</td>
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

                                    <input type="hidden"
                                           name="military_affairs_id"
                                           value="{{ $item->id }}">


                                    <input type="hidden" name="type"
                                           value="{{$item_type_time1->type}}">

                                    <div class="form-row">
                                        <div class="form-group">
                                            <label class="form-label">
                                                الاتصال</label>
                                            <select class="form-select"
                                                    name="notes_type">
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
                                                <label
                                                    class="form-label">الملاحظات</label>
                                                <textarea name="note"
                                                          class="form-control"
                                                          rows="5"></textarea>
                                                @error('note')
                                                <div
                                                    style='color:red'>{{$message}}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="tab-pane p-3" id="notes-{{$item->id}}"
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
                                    @if (count($item->all_actions) > 0 )
                                        @foreach ($item->all_actions as $value)
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
                                    @if (count($item->get_all_delegations) > 0 )
                                        @foreach ($item->get_all_delegations as $value)
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
            @endif
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
