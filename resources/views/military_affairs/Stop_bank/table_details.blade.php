<tr>


    <td>
        {{$item->i }}
    </td>
    <td>
        {{$item->installment->client->name_ar}}
        <br>
        {{$item->installment->client->civil_number}}
        <br>
        {{$item->phone}}
        <br>
        <a href="{{url('installment/show-installment/'.$item->installment->id)}}"> {{$item->installment->id}}</a>
        <br>

    </td>
    <td>
        {{$item->installment->client->court ?  \App\Models\Court::where('governorate_id', $item->installment->client->court->id)->first()->name_ar : ''}}

        <br>
        {{$item->issue_id}}

        <br>
        <br>
        @include('military_affairs.Execute_alert.print.print')
    </td>

    <td>
        {{$item->eqrar_dain_amount}}

    </td>
    <td>

        {{$item->last_date}}

        <br>
        عدد الحجوزات
        {{$item->ministry_name->date}}



    </td>
    <td>
        @if($item->status_all->where('type_id','=','stop_bank_command')->first())
            {{$item->status_all->where('type_id','=','stop_bank_command')->first()->date}}
        @else
            لا يوجد
        @endif
        <br>
        <br>
        @if( request()->has('stop_bank_type') && request()->get('stop_bank_type')=='stop_bank_doing')
            <div class="btn-group dropup mb-6 me-6">
                <button class="btn btn-secondary dropdown-toggle" type="button"
                        id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-expanded="false">
                    نتيجة الحجز
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                    <li>
                        <button class="btn btn-success rounded-0 w-100 mt-2"
                           data-bs-toggle="modal"
                           data-type="tahseel"
                           onclick="get_type('tahseel')"
                           data-bs-target="#open-bank_request-{{$item->id}}"    {{ $item->emp_id ==0 || $item->emp_id ==null ? 'disabled'  : ''}}>
                            تحصيل مبلغ</button>
                    </li>
                    <li>
                        <button class="btn btn-primary rounded-0 w-100 mt-2"
                           data-bs-toggle="modal"

                           onclick="get_type('new_date')"
                           data-bs-target="#open-bank_request-{{$item->id}}"  {{ $item->emp_id ==0 || $item->emp_id ==null ? 'disabled'  : ''}}
                        >
                            تقويس</button>
                    </li>
                    <li>
                        <button class="btn btn-warning rounded-0 w-100 mt-2"
                           data-bs-toggle="modal"

                           onclick="get_type('not_found')"
                           data-bs-target="#open-bank_request-{{$item->id}}" {{ $item->emp_id ==0 || $item->emp_id ==null ? 'disabled'  : ' '}}
                        >
                            لايوجد</button>



                    </li>


                </ul>
                <div id="open-bank_request-{{$item->id}}" class="modal fade" tabindex="-1"
                     aria-labelledby="bs-example-modal-md" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable modal-lg">
                        <div class="modal-content">
                            <form class="mega-vertical"
                                  action="{{url('stop_bank/stop_bank_request_results')}}" method="post"
                                  enctype="multipart/form-data">
                                @csrf

                                <input type="hidden" name="military_affairs_id" value="{{ $item->id }}">
                                <input type="hidden" name="type" value="" id="type">
                                <div class="modal-header d-flex align-items-center">
                                    <h4 class="modal-title" id="myModalLabel">
                                        اضافة حجز بنوك</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <h6><span class="fw-semibold">
                                    حجز بنوك :
                                </span>
                                        {{ $item->installment->client->name_ar }}-{{$item->installment->client->civil_number}}
                                    </h6>

                                </div>
                                <div class="modal-body">

                                    <div class="form-row">
                                        <div class="form-group">
                                            <label class="form-label" for="input1 "> المبلغ </label>
                                            <input type="number" name="amount" class="form-control mb-2"
                                                   id="input1">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="input1 "> تاريخ </label>
                                            <input type="date" name="date" class="form-control mb-2"
                                                   id="input1">
                                        </div>

                                        <div class="form-group">
                                            <label for="formFile" class="form-label">اختر صورة </label>
                                            <input class="form-control" name="img_dir" accept="image/*"
                                                   type="file" id="formFile"/>
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


            </div>

        @endif
    </td>
    <td>

        {{$item->installment->client->ministry ?  \App\Models\Ministry::findorfail($item->installment->client->ministry->last()->ministry_id)->name_ar : ''}}

    </td>

    <td>
        @include('military_affairs.Open_file.partial.column_responsible')
    </td>

    <td>
        <select class="form-select form-control" name="statues" onchange="change_bank_satues(this,{{$item->id}})">
            <option  value="work"  {{ $item->bank_account_status =='work' ?   'selected' : ''}} >يعمل راتب</option>
            <option value="stop" {{ $item->bank_account_status =='stop' ?   'selected' : ''}}  >موقوف راتب </option>
            <option value="visa" {{ $item->bank_account_status =='visa' ?   'selected' : ''}}>فيزا</option>
            <option value="wrong_bank" {{ $item->bank_account_status =='wrong_bank' ?   'selected' : ''}}>لا يوجد حساب</option>
            <option value="housing" {{ $item->bank_account_status =='housing' ?   'selected' : ''}}>يعمل بدل ايجار</option>
            <option value="account_closed" {{ $item->bank_account_status =='account_closed' ?   'selected' : ''}} >حساب مغلق</option>
            <option value="money_found" {{ $item->bank_account_status =='money_found' ?   'selected' : ''}} >يوجد مبلغ بالحساب</option>
        </select>
    </td>


    <td>

        <div class="btn-group dropup mb-6 me-6">

            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-bs-toggle="dropdown" aria-expanded="false">
                الإجراءات
            </button>

            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <li>

                    <button class="btn btn-primary rounded-0 w-100 mt-2" data-bs-toggle="modal"
                            data-bs-target="#open-details-{{$item->id}}">
                        الملاحظات<span class="badge ms-auto text-bg-secondary">{{count($item->all_notes)}}</span>
                    </button>



                </li>
                <li>
                    <a class="btn btn-warning rounded-0 w-100 mt-2"
                       href="{{ url('installment/show-installment/' . $item->installment->id) }}">
                        التفاصيل</a>


                </li>
                @php



                    if(Request::has('stop_bank_type')){
                        if(Request::get('stop_bank_type')=='stop_bank_command'){
                            $button_title='تحويل لباحث قانونى';

                        }elseif(Request::get('stop_bank_type')=='stop_bank_request'){
                            $button_title='تحويل  لمأمور تنفيذ';

                        }elseif(Request::get('stop_bank_type')=='stop_bank_researcher'){
                            $button_title='تحويل  ';

                        }elseif(Request::get('stop_bank_type')=='banks'){
                            $button_title='  طلب الحجز';

                        }elseif(Request::get('stop_bank_type')=='stop_bank_cancel_request'){
                            $button_title='  طلب رفع حجز البنك';

                        }

                    }

                @endphp

                    @if( Request::has('stop_bank_type') &&  Request::get('stop_bank_type') == 'stop_bank_doing' )

                        <li>
                            <a class="btn btn-success rounded-0 w-100 mt-2   {{ $item->emp_id == null || $item->emp_id == '' ||  $item->emp_id == 0   ? 'disabled' : '' }}"
                               href="{{url('show_settlement/'.$item->id)}}">
                                تحويل للتسوية
                            </a>
                        </li>


                @endif

                @if(Request::has('stop_bank_type') &&  Request::get('stop_bank_type') !='stop_bank_doing' )
                    @if(Request::get('stop_bank_type') !='stop_bank_cancel')
                    <li>
                        <button class="btn btn-secondary rounded-0 w-100 mt-2" data-bs-toggle="modal"
                                data-bs-target="#change_type-{{$item->id}}" {{ $item->emp_id ==0 || $item->emp_id ==null ? 'disabled'  : ''}} >
                           {{$button_title}}
                        </button>
                    </li>
                @endif
                @endif
               {{-- @if( $item->bank_account_status)
                    <li>
                        <button class="btn btn-warning rounded-0 w-100 mt-2" data-bs-toggle="modal"
                                data-bs-target="#change_type-{{$item->id}}" {{ $item->emp_id !=0 || $item->emp_id !=null ? 'disabled'  : ''}} >
                          الارشيف
                        </button>
                    </li>
                @endif--}}






            </ul>




            <!-- /.modal-dialog -->

        </div>



        <div id="change_type-{{$item->id}}" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <form class="mega-vertical"
                      action="{{url('change_states')}}" method="post"
                      enctype="multipart/form-data">
                    @csrf
                    @php
                        if(Request::has('stop_bank_type')){
                        $slug_stop_bank=Request::get('stop_bank_type');
                        }else{
                        $slug_stop_bank='stop_bank_request';
                        }
                    @endphp

                    <div class="modal-content">
                        <div class="modal-header d-flex align-items-center">
                            <h4 class="modal-title" id="myModalLabel">
                                {{App\Models\Military_affairs\Military_affairs_stop_bank_type::where('slug',$slug_stop_bank)->first()->name_ar }}  </h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">



                            <input type="hidden" name="new_stop_type"  value="{{$item_type_time_new->id}}" >
                            <input type="hidden" name="old_stop_type"  value="{{$item_type_time_old->id}}" >
                            <input type="hidden" name="type_id"  value="{{$item_type_time_new->slug}}" >
                            <input type="hidden" name="type"  value="{{$item_type_time_new->type}}" >
                            <input type="hidden" name="military_affairs_id"  value="{{$item->id}}" >


                            <div class="form-row">


                                <div class="form-group mb-3">
                                    <label class="form-label">تاريخ  </label>
                                    <input type="date" name="date" class="form-control">
                                </div>

                                <div class="form-group my-3">
                                    <label for="formFile" class="form-label">الصورة </label>
                                    <input class="form-control"  name="img_dir"   accept="image/*" type="file" id="formFile">
                                </div>

                            </div>

                        </div>
                        <div class="modal-footer d-flex ">
                            <button type="submit" class="btn btn-primary">حفظ</button>
                            <button type="button" class="btn bg-danger-subtle text-danger  waves-effect" data-bs-dismiss="modal">
                                الغاء
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>



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
                                    <a class="nav-link" data-bs-toggle="tab" href="#actions-{{$item->id}}" role="tab">
                                        <span>تتبع المعاملة</span>
                                    </a>
                                </li>

                            </ul>
                            <!-- Tab panes -->

                            <div class="tab-content border mt-2">

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
                                        @if(count($item->all_notes)>0)
                                            @foreach($item->all_notes as $all_note)

                                                <tr data-bs-toggle="collapse"
                                                    data-bs-target="#collapseExample"
                                                    aria-expanded="false"
                                                    aria-controls="collapseExample">
                                                    <td>
                                                        @if(\App\Models\User::
                                                        where('id', $all_note->created_by)
                                                        ->first())
                                                            {{\App\Models\User::
                                                            where('id', $all_note->created_by)
                                                            ->first()->name_ar }}
                                                        @else
                                                            لايوجد
                                                        @endif

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


                                                    <td>{{formatTime($time)}}<span
                                                            class="d-block"></span></td>
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
                                        @php
                                            if(Request::has('stop_bank_type')){
                                            $slug_stop_bank=Request::get('stop_bank_type');
                                            }else{
                                            $slug_stop_bank='stop_bank_request';
                                            }
                                        @endphp

                                        <input type="hidden" name="type"
                                               value="stop_bank">
                                        <input type="hidden" name="type_id"
                                               value="{{$slug_stop_bank}}">
                                        <div class="form-row">
                                            <div class="form-group">
                                                <label class="form-label"> الاتصال</label>
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
                                        @if(count($item->all_actions)>0)
                                            @foreach($item->all_actions as $value)



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
                                    <table id="notes2" class="table table-bordered border text-wrap align-middle">
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
                                        @if(count($item->get_all_delegations)>0)
                                            @foreach ($item->get_all_delegations as $value)
                                                <tr data-bs-toggle="collapse" data-bs-target="#collapseExample"
                                                    aria-expanded="false" aria-controls="collapseExample">
                                                    @php
                                                        $created_by =\App\Models\User::
                                                        where('id', $value->emp_id)
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

                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

    </td>


</tr>


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
    function get_type(type){

        document.getElementById("type").value= type;
    }
</script>
