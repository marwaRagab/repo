<tr>


    <td>
        {{ $loop->index + 1 }}
    </td>
    <td>
        <a href="{{url('installment/show-installment/'.$item->installment->id)}}"> {{$item->installment->id}}</a>
        <br>
        {{$item->different_date}} يوم
    </td>
    <td>{{$item->installment->client->name_ar}}</td>

    <td>{{  $item->final_data   ?   $item->final_data[0] : ''}}


    </td>


    <td>{{$item->open_file_date  }}</td>


    <td>{{$item->issue_id}}</td>

    @if(count($item->jalasaat_all)>=1)

    <td>
        @foreach( $item->jalasaat_all as $jalasaat )

        @if($jalasaat->jalasat_alert_date)
        <p class="mb-2">{{  expolde_date($jalasaat->jalasat_alert_date)[0]    }}</p>

        @else
        <p class="mb-2 text-danger" >لايوجد</p>
        @endif
        @endforeach
    </td>
    <td>
        @foreach( $item->jalasaat_all as $jalasaat )

        @if($jalasaat->jalasat_alert_reason)
        <p class="mb-2">{{$jalasaat->jalasat_alert_reason}}</p>
        @else
        <p class="mb-2 text-danger" >لايوجد</p>
        @endif
        @endforeach
    </td>

    <td>
        @foreach( $item->jalasaat_all as $jalasaat )
        @if($jalasaat->jalasat_alert_img)
        <a 
            onclick="checkFileAndRedirect(
                    '{{ $jalasaat && $jalasaat->jalasat_alert_img && $jalasaat->jalasat_alert_img !== '0' ? 'https://electron-kw.net/' . $jalasaat->jalasat_alert_img : '#' }}',
                    '{{ $jalasaat && $jalasaat->jalasat_alert_img && $jalasaat->jalasat_alert_img !== '0' ? 'https://electron-kw.com/' . $jalasaat->jalasat_alert_img : '#' }}'
                ); return false;"
            
            class="d-block btn rounded-0 bg-success-subtle text-success mb-2"> الصورة</a>
        @else
        <p class="mb-2 text-danger" >لايوجد</p>
        @endif
        @endforeach
    </td>
    <td>
        @foreach( $item->jalasaat_all as $jalasaat )
        @if($jalasaat->a3lan_paper_date)


        <p class="mb-2">{{ expolde_date($jalasaat->a3lan_paper_date)[0] }}</p>

        @else
        <p class="mb-2 text-danger" >لايوجد</p>
        @endif
        @endforeach
    </td>

    @else
    <td>
        <p class="mb-2 text-danger" >لايوجد</p>
    </td>
    <td> <p class="mb-2 text-danger" >لايوجد</p></td>
    <td> <p class="mb-2 text-danger" >لايوجد</p></td>
    <td> <p class="mb-2 text-danger" >لايوجد</p> </td>

    @endif


    <td>
        @include('military_affairs.Open_file.partial.column_responsible')
    </td>

    <td>
        @php

        $all_notes=get_all_notes('execute_alert',$item->id);
        $all_actions=get_all_actions($item->id);
        $get_all_delegations = get_all_delegations($item->id);

        @endphp

        <div class="btn-group dropup mb-6 me-6">

            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-bs-toggle="dropdown" aria-expanded="false">
                الإجراءات
            </button>

            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <li>
                    <a class="btn btn-success rounded-0 w-100 mt-2"
                       href="{{ url('installment/show-installment/' . $item->installment->id) }}">
                        التفاصيل</a>


                </li>
                <li>



                    <button class="btn btn-primary rounded-0 w-100 mt-2" data-bs-toggle="modal"
                            data-bs-target="#open-details-{{$item->id}}">
                        الملاحظات <span class="badge ms-auto text-bg-secondary">{{count($all_notes)}}</span>
                    </button>



                </li>
                @php
                    $new_a3lan= $item->jalasaat_all->where('status',NULL)->first();
                @endphp

                <li>




                    @if(isset($new_a3lan))
                        <button class="btn btn-success  rounded-0 w-100 mt-2" data-bs-toggle="modal" data-bs-target="#add-note-{{$item->id}}" {{ $item->emp_id == 0 || $item->emp_id == null ? 'disabled' : '' }}>
                            إيداع  النتيجة</button>
                    @else
                        <button class="btn btn-success  rounded-0 w-100 mt-2" data-bs-toggle="modal" data-bs-target="#add-note-{{$item->id}}" {{ $item->emp_id == 0 || $item->emp_id == null ? 'disabled' : '' }}>
                            إيداع الإعلان أولا</button>
                    @endif

                </li>





            </ul>




            <!-- /.modal-dialog -->

        </div>




        @include('military_affairs.Execute_alert.print.print')


        

        <div id="open-details-{{$item->id}}" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <form class="mega-vertical"
                          action="{{url('add_notes')}}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header d-flex align-items-center">
                            <h4 class="modal-title" id="myModalLabel">
                                ملاحظات  اعلان التنفيذ </h4>
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
                                        @if (count($all_notes) > 0 )
                                        @foreach($all_notes as $all_note)

                                            <tr data-bs-toggle="collapse" data-bs-target="#collapseExample"
                                                aria-expanded="false"
                                                aria-controls="collapseExample">
                                                <td>
                                                    @php
                                                        $user = \App\Models\User::find($all_note->created_by);
                                                    @endphp
                                                
                                                    {{ $user ? $user->name_ar : '' }}
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
                                                <td><span class="d-block">{{$time}}</span></td>
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
                                    <div class="add-note text-end">
                                        <h4 class="mb-3">اضف ملاحظة</h4>
                                        <input type="hidden" name="military_affairs_id"
                                               value="{{ $item->id }}">
                                        <input type="hidden" name="id_time_type_old"
                                               value="{{$item_type_time->id}}">
                                        <input type="hidden" name="id_time_type_new"
                                               value="{{$item_type_time_new->id}}">
                                        <input type="hidden" name="type"
                                               value="{{$item_type_time->type}}">
                                        <input type="hidden" name="type_id"
                                               value="{{$item_type_time->id}}">
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
                      action="{{url('add_a3lan')}}" method="post"
                      enctype="multipart/form-data">
                    @csrf


                    <input type="hidden" name="military_affairs_id" value="{{$item->id}}">
                    <input type="hidden" name="jalasat_id" value="{{$new_a3lan ? $new_a3lan->id : ''}}">
                    <input type="hidden" name="type" value="execute_alert">

                    <input type="hidden" name="military_affairs_id"
                           value="{{ $item->id }}">
                    <input type="hidden" name="id_time_type_old"
                           value="{{$item_type_time->id}}">
                    <input type="hidden" name="id_time_type_new"
                           value="{{$item_type_time_new->id}}">
                    <input type="hidden" name="type"
                           value="{{$item_type_time->type}}">
                    <input type="hidden" name="type_id"
                           value="{{$item_type_time->id}}">
                    <div class="modal-header d-flex align-items-center">
                        <h4 class="modal-title" id="myModalLabel">
                            اعلان جلسة</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="form-row">
                            <div class="form-group mb-3">
                                <label class="form-label">تاريخ الاعلان</label>
                                @if($new_a3lan)

                                <input type="date" name="a3lan_paper_date"  readonly  value="{{expolde_date($new_a3lan->a3lan_paper_date)[0] }}" class="form-control">
                                @else
                                <input type="date" name="a3lan_paper_date"   value="" class="form-control">

                                @endif

                                @error('a3lan_paper_date')
                                <div style='color:red'>{{$message}}</div>
                                @enderror
                            </div>

                            <div class="mb-7">
                                <label>
                                    <input type="radio" name="status" value="refused" onclick="showInputs({{$item->id}})"> معاد
                                </label>
                                <label>
                                    <input type="radio" name="status" value="accepted" onclick="showInputs({{$item->id}})"> تم التبليغ
                                </label>
                                <div id="additionalInputs-{{$item->id}}"  style="display: none">
                                    <div class="form-group mb-3">
                                        <label class="form-label">التاريخ</label>
                                        <input type="date" name="jalasat_alert_date" class="form-control">
                                        @error('jalasat_alert_date')
                                        <div style='color:red'>{{$message}}</div>
                                        @enderror

                                    </div>
                                    <div class="form-group my-3">
                                        <label for="formFile" class="form-label">الصورة </label>
                                        <input class="form-control" name="jalasat_alert_img" accept="image/*"   type="file" id="formFile">
                                        @error('jalasat_alert_img')
                                        <div style='color:red'>{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <div class="my-3">
                                            <label class="form-label">الملاحظات</label>
                                            <textarea class="form-control"  name="jalasat_alert_reason" rows="5"></textarea>
                                            @error('jalasat_alert_reason')
                                            <div style='color:red'>{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer d-flex ">
                        <button type="submit" class="btn btn-primary">حفظ</button>
                        <button type="button" class="btn bg-danger-subtle text-danger  waves-effect" data-bs-dismiss="modal">
                            الغاء
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


</tr>



@include('military_affairs.Execute_alert.print.script')