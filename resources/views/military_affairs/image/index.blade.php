
@php
$arr=['success','danger','primary','secondary','info','warning'];
//dd($governorates[2]);
@endphp
<div class="card mt-4 py-3">
  <div class="d-flex flex-wrap ">

    <a class="btn-filter bg-warning-subtle text-warning px-4 fs-4 mx-1 mb-2">
      العدد الكلي ({{ $count_total }})
    </a>

@for ($i=0;$i<count($governorates);$i++)

<a  href="{{ route('image',$governorates[$i]->id) }}" class="btn-filter  bg-{{ $arr[$i] }}-subtle text-{{ $arr[$i] }} px-4 fs-4 mx-1 mb-2">
  محكمة {{ $governorates[$i]->name_ar }} ({{ $count['counter_'.$governorates[$i]->id]}})
</a>
@endfor




  </div>
</div>
<div class="card">
  <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
      <h4 class="card-title mb-0">{{ $title }}</h4>
  </div>
<div class="card-body">

  <div class="table-responsive pb-4">
    <table id="all-student" class="table table-bordered border text-nowrap align-middle">
      <thead>
        <!-- start row -->
        <tr>
                                <th>م</th>
                                <th >رقم المعاملة </th>
                                <th>اسم العميل </th>
                                <th>تاريخ البدء</th>
                                <th> المبلغ </th>
                                <th>تاريخ فتح الملف </th>
                                <th>الرقم الالي</th>
                                 <th>تاريخ النتيجه</th>
                                 <th>المحكمة</th>
                                 <th>نتيجه الاعلان</th>
                                 <th>إيداع الاعلان</th>
                                 <th> تحديد مسئول</th>
                                 <th>الاجراءات</th>


        </tr>
        <!-- end row -->
      </thead>
      <tbody>
       @php $i=1; @endphp
                  @foreach ($transactions as $item)


                <!-- start row -->
                 @if($item->installment)
                <tr>
                    <td>{{$i}}</td>
                  <td><a href="{{url('installment/show-installment/'.$item->installment->id)}}">{{$item->installment->id}}</a></td>

                    <td>
                        {{$item->installment->client->name_ar}}
                        <br>
                        {{$item->installment->client->civil_number}}
                        <br>
                        {{$item->phitem}}


                    </td>

                  <td>{{$item->date}}</td>
                  <td>{{$item->eqrar_dain_amount}}</td>
                  <td>{{$item->open_file_date}}</td>
                  <td>{{$item->issue_id}}</td>
                  <td>{{ $item->jalasaat_all->first() ? ($item->jalasaat_all->first()->a3lan_jalsa_ditem_date) : ''}}</td> <!-- هجيبه من الجلسات وانا بتيست-->
                  <td>
                      {{$item->installment->client->court ?  \App\Models\Court::where('governorate_id', $item->installment->client->court->id)->first()->name_ar : ''}}
                  </td>
                    <td>{{ $item->jalasaat_all->first() ? $item->jalasaat_all->first()->jalasat_alert_reason : ''}}</td> <!-- هجيبه من الجلسات وانا بتيست-->
                    <td>{{ $item->jalasaat_all->first() ? ($item->jalasaat_all->first()->a3lan_paper_date) : ''}}</td> <!-- هجيبه من الجلسات وانا بتيست-->
                    <td>
                        @include('military_affairs.Open_file.partial.column_responsible')
                    </td>
                  {{--  <td>

                  <div id="add_a3lan" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable modal-lg">
                      <div class="modal-content">
                        <div class="modal-header d-flex align-items-center">
                          <h4 class="modal-title" id="myModalLabel">
                            ايداع الاعلان</h4>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <form class="ps-3 pr-3" action="{{ route('image.to_a3lan_eda3') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-row">

                              <div class="form-group">
                                <div class="my-3">
                                  <label class="form-label">تاريخ ايداع الاعلان</label>
                                  <input class="form-control" name="jalsaat_alert_paper_date" type="date" />
                                  @error('jalsaat_alert_paper_date')
                                  <div class="alert alert-danger">{{ $message }}</div>
                                     @enderror
                                  <input class="form-control" type="text" style="display:nitem;" name="installment_id" value="12">

                                </div>
                              </div>
                            </div>
                          </form>
                        </div>
                        <div class="modal-footer d-flex ">
                          <button type="submit" class="btn btn-primary"> حفظ</button>
                          <button type="button" class="btn bg-danger-subtle text-danger  waves-effect" data-bs-dismiss="modal">
                            الغاء
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>

                    </td>--}}
                    <td>
                        @php

                            $all_notes=get_all_notes('images',$item->id);
                            $all_actions=get_all_actions($item->id);
                            $get_all_delegations = get_all_delegations($item->id);

                        @endphp
                        <div class="btn-group dropup mb-6 me-6 d-block ">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                الإجراءات
                            </button>
                            <ul class="dropdown-menu rounded-0" aria-labelledby="dropdownMenuButton">
                                <li>

                                    <button class="btn btn-warning rounded-0 w-100 mt-2" data-bs-toggle="modal"
                                            data-bs-target="#open-details-{{$item->id}}">
                                        الملاحظات <span class="badge ms-auto text-bg-secondary">{{count($all_notes)}}</span>
                                    </button>



                                </li>
                                <li>
                                    <a class="btn btn-primary rounded-0 w-100 mt-2" href="{{url('installment/show-installment/'.$item->installment->id)}}">
                                        التفاصيل</a>
                                <li>
                                    <a class="btn btn-info rounded-0 w-100 mt-2"
                                       href="{{ url('military_affairs/image/athbat_7ala/'.$item->id) }}">طباعة كتاب اثبات
                                    </a>
                                </li>
                                <li >
                                    @if($item->jalasaat_all->first())
                                    <a class="btn btn-success rounded-0 w-100 mt-2"
                                      href="">الصورة</a>
                                    @endif
                                </li>


                            </ul>


                        </div>
                        @include('military_affairs.Execute_alert.print.print')




                        <!-- sample modal content -->
                        <div id="notes_{{ $item->id }}" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md"
                             aria-hidden="true">
                            <form class="mega-vertical"
                                  action="{{url('add_notes')}}" method="post"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header d-flex align-items-center">
                                            <h4 class="modal-title" id="myModalLabel">
                                                اضافة ملاحظة </h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">


                                            <div class="form-row">
                                                <div class="form-group">
                                                    <label class="form-label"> الجهة</label>
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
                                                    <label class="form-label" for="input1 ">
                                                        الملاحظة </label>
                                                    <textarea name="note" class="form-control mb-2">

                                             </textarea>
                                                    <input type="text"  name="note" value="{{ $item->id }}"class="form-control mb-2" style="display:nitem;"/>
                                                </div>


                                            </div>

                                        </div>
                                        <div class="modal-footer d-flex ">
                                            <button type="submit" class="btn btn-primary">
                                                حفظ
                                            </button>
                                            <button type="button"
                                                    class="btn bg-danger-subtle text-danger  waves-effect"
                                                    data-bs-dismiss="modal">
                                                الغاء
                                            </button>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                            </form>
                            <!-- /.modal-dialog -->
                        </div>
                        <div id="open-details-{{$item->id}}" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                <div class="modal-content">
                                    <form class="mega-vertical"
                                          action="{{url('add_notes')}}" method="post"
                                          enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-header d-flex align-items-center">
                                            <h4 class="modal-title" id="myModalLabel">
                                                ملاحظات الايمج   </h4>
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
                                                                    {{\App\Models\User::findorfail($all_note->created_by)->name_ar}}
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

                </tr>
                <!-- end row -->
                 @endif

          @php $i++; @endphp
                @endforeach
      </tbody>
    </table>

  </div>

</div>
</div>
