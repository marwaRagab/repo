
    <tr data-bs-toggle="collapse" data-bs-target="#collapseExample"
        aria-expanded="false"
        aria-controls="collapseExample">
        <!--    <td>
        {{ $loop->index + 1 }}

        </td>-->


        <td>

            <a href="{{url('installment/show-installment/'.$item->installment->id)}}"> {{$item->installment->id}}</a>

        </td>
        <td>{{$item->installment->client->name_ar}}
            <br>
            {{$item->installment->client->client_phone->first()->phone}}
            <br>
            {{$item->installment->client->civil_number}}
        </td>
        <td>
            {{$item->installment->client->court ?  \App\Models\Court::where('governorate_id', $item->installment->client->court->id)->first()->name_ar : ''}}

            <br>
            {{$item->eqrar_dain_amount}}
        </td>

        <td>
            <span>بداية التحويل :  {{ $item->different_date_tranfer}}</span>
            <br>
            @if(Request::get('stop_travel_type')=='command')
                <span> طلب منع السفر :  {{$item->different_date_command}}</span>
                <br>
            @endif
            @if(Request::get('stop_travel_type')=='stop_travel_finished')
                <span>طلب منع السفر  :  {{$item->different_date_finshied_command}}</span>
                <br>
                <span> امر منع السفر :  {{ $item->different_date_finshied}}</span>

            @endif

        </td>
        <td>
            {{$item->open_file_date}}
        </td>

        <td>
            {{$item->issue_id}}
            {{--
                {{$item->status_all->where('type_id','request')->first()->date}}
                --}}
        </td>
        @if(Request::get('stop_travel_type')=='command')
            <td>

                {{$item->final_date_command ? $item->final_date_command[0] : ''}}
                <br>
                @if($item->item_command)
                    <a href="https://electron-kw.net/{{$item->item_command->img_dir}}"
                       target=" _blank">
                                                            <span class="btn btn-info"> صورة
                                                                 </span>
                    </a>
                @endif

            </td>
            <td>
                <button class="btn btn-success me-6 my-2" data-bs-toggle="modal"
                        data-bs-target="#convert_command-{{$item->id}}"   {{ $item->emp_id == 0 || $item->emp_id == null ? 'disabled' : '' }}>

                    منع السفر
                </button>
                <div id="convert_command-{{$item->id}}" class="modal fade" tabindex="-1"
                     aria-labelledby="bs-example-modal-md" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable modal-lg">
                        <div class="modal-content">
                            <form class="mega-vertical"
                                  action="{{url('stop_travel_convert')}}" method="post"
                                  enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="military_affairs_id"
                                       value="{{$item->id}}">
                                <input type="hidden" name="type"
                                       value="{{$item_type_time2->type}}">
                                <input type="hidden" name="type_id"
                                       value="{{$item_type_time2->slug}}">
                                <input type="hidden" name="item_type_new"
                                       value="{{$item_type_time3->id}}">
                                <input type="hidden" name="item_type_old"
                                       value="{{$item_type_time2->id}}">

                                <div class="modal-header d-flex align-items-center">
                                    <h4 class="modal-title" id="myModalLabel">
                                        منع السفر</h4>
                                    <button type="button" class="btn-close"
                                            data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <div class="form-row">
                                        <div class="form-group">
                                            <label class="form-label" for="input1 ">
                                                تاريخ </label>
                                            <input type="date" name="date"
                                                   class="form-control mb-2"
                                                   id="input1">
                                            @error('date')
                                            <div style='color:red'>{{$message}}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="formFile" class="form-label">اختر
                                                صورة </label>
                                            <input class="form-control" name="img_dir"
                                                   accept="image/*" type="file"
                                                   id="formFile"/>
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


            </td>
        @elseif(Request::get('stop_travel_type')=='stop_travel_finished')

            <td>
                {{$item->final_date_finished_command[0]}}

                <br>
                <a href="https://electron-kw.net/{{$item->item_finished_command->img_dir}}"
                   target=" _blank">
                                                            <span class="btn btn-info"> صورة
                                                                 </span>
                </a>
            </td>
            <td>  {{$item->final_date_finished[0]}}

                <br>
                <a href="https://electron-kw.net/{{$item->item_finished->img_dir}}"
                   target=" _blank">
                                                            <span class="btn btn-info"> صورة
                                                                 </span>
                </a>
            </td>
        @elseif(Request::get('stop_travel_type')=='stop_travel_cancel_request')
            <td>
                @php
                    $date_convert_cancel=$item->status_all->where('type_id','stop_travel_cancel_request')->first()->date;
                    $final_date=explode(' ',$date_convert_cancel);
                @endphp
                {{$final_date[0]}}

            </td>
            <td>
                <button class="btn btn-success me-6 my-2" data-bs-toggle="modal"
                        data-bs-target="#cancel_stop_travel-{{$item->id}}" {{ $item->emp_id == 0 || $item->emp_id == null ? 'disabled' : '' }}>

                    منع السفر
                </button>
                <div id="cancel_stop_travel-{{$item->id}}" class="modal fade"
                     tabindex="-1"
                     aria-labelledby="bs-example-modal-md" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable modal-lg">
                        <div class="modal-content">
                            <form class="mega-vertical"
                                  action="{{url('stop_travel_convert')}}" method="post"
                                  enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="military_affairs_id"
                                       value="{{$item->id}}">
                                <input type="hidden" name="type"
                                       value="{{$item_type_time4->type}}">
                                <input type="hidden" name="type_id"
                                       value="{{$item_type_time5->slug}}">
                                <input type="hidden" name="item_type_new"
                                       value="{{$item_type_time5->id}}">
                                <input type="hidden" name="item_type_old"
                                       value="{{$item_type_time4->id}}">

                                <div class="modal-header d-flex align-items-center">
                                    <h4 class="modal-title" id="myModalLabel">
                                        منع السفر</h4>
                                    <button type="button" class="btn-close"
                                            data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <div class="form-row">
                                        <div class="form-group">
                                            <label class="form-label" for="input1 ">
                                                تاريخ </label>
                                            <input type="date" name="date"
                                                   class="form-control mb-2"
                                                   id="input1">
                                            @error('date')
                                            <div style='color:red'>{{$message}}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="formFile" class="form-label">اختر
                                                صورة </label>
                                            <input class="form-control" name="img_dir"
                                                   accept="image/*" type="file"
                                                   id="formFile"/>
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


            </td>
        @elseif(Request::get('stop_travel_type')=='stop_travel_cancel')
            @php


                $date_convert_cancel=$item->status_all->where('type_id','stop_travel_cancel')->first()->date;
                $final_date=explode(' ',$date_convert_cancel);
                $date_convert_cancel_request=$item->status_all->where('type_id','stop_travel_cancel_request')->where('flag',1)->first() ?  $item->status_all->where('type_id','stop_travel_cancel_request')->first()->date : '';
                $final_date_request= $date_convert_cancel_request ?  explode(' ',$date_convert_cancel_request) : '';
            @endphp


            <td>{{$final_date_request ?   $final_date_request[0] : ''}}</td>
            <td>{{$final_date[0]}}</td>
           
        @else
        
            <td>
                <button class="btn btn-success me-6 my-2" data-bs-toggle="modal"
                        data-bs-target="#convert_resuest-{{$item->id}}"   {{ $item->emp_id == 0 || $item->emp_id == null ? 'disabled' : '' }}>

                    منع السفر
                </button>
                <div id="convert_resuest-{{$item->id}}" class="modal fade" tabindex="-1"
                     aria-labelledby="bs-example-modal-md" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable modal-lg">
                        <div class="modal-content">
                            <form class="mega-vertical"
                                  action="{{url('stop_travel_convert')}}" method="post"
                                  enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="military_affairs_id"
                                       value="{{$item->id}}">
                                <input type="hidden" name="type"
                                       value="{{$item_type_time1->type}}">
                                <input type="hidden" name="type_id"
                                       value="{{$item_type_time2->slug}}">
                                <input type="hidden" name="item_type_new"
                                       value="{{$item_type_time2->id}}">
                                <input type="hidden" name="item_type_old"
                                       value="{{$item_type_time1->id}}">

                                <div class="modal-header d-flex align-items-center">
                                    <h4 class="modal-title" id="myModalLabel">
                                        منع السفر</h4>
                                    <button type="button" class="btn-close"
                                            data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <div class="form-row">
                                        <div class="form-group">
                                            <label class="form-label" for="input1 ">
                                                تاريخ </label>
                                            <input type="date" name="date"
                                                   class="form-control mb-2"
                                                   id="input1">
                                            @error('date')
                                            <div style='color:red'>{{$message}}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="formFile" class="form-label">اختر
                                                صورة </label>
                                            <input class="form-control" name="img_dir"
                                                   accept="image/*" type="file"
                                                   id="formFile"/>
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

            </td>

        @endif
        <td>
            @include('military_affairs.Open_file.partial.column_responsible')
        </td>

        <td>
            <div class="btn-group dropup mb-6 me-6">
                <button class="btn btn-secondary dropdown-toggle" type="button"
                        id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-expanded="false">
                    الإجراءات
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <li>
                        <a class="btn btn-success rounded-0 w-100 mt-2"

                           href="{{url('installment/show-installment/'.$item->installment->id)}}">
                            التفاصيل</a>
                    </li>
                    <li>
                        <a class="btn btn-primary rounded-0 w-100 mt-2"
                           data-bs-toggle="modal"
                           data-bs-target="#open-details-{{$item->id}}">
                            الملاحظات</a>
                    </li>

                </ul>
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
                                            @php

                                                $all_notes=get_all_notes('stop_travel',$item->id);
                                                $all_actions=get_all_actions($item->id);
                                            @endphp
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


                                                    <!-- start row -->
                                                    @foreach($all_notes as $all_note)

                                                        <tr data-bs-toggle="collapse"
                                                            data-bs-target="#collapseExample"
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
                                                            <td>{{$time}}<span
                                                                    class="d-block"></span>
                                                            </td>
                                                            <td>{{$day}}</td>

                                                        </tr>

                                                    @endforeach
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
                                                    <!-- start row -->
                                                    @foreach($all_actions as $value)



                                                        <tr data-bs-toggle="collapse"
                                                            data-bs-target="#collapseExample"
                                                            aria-expanded="false"
                                                            aria-controls="collapseExample">
                                                            <td>
                                                                {{\App\Models\User::findorfail($value->created_by)->name_ar}}
                                                            </td>
                                                            <td>
                                                                {{$value->times_type_id}}



                                                            </td>
                                                            <td>
                                                                @php

                                                                    $day_start= explode(' ', $value->date_start)[0];
                                                                    if($value->date_end) {
                                                                    $day_end= explode(' ',$value->date_end)[0];
                                                                    }else{
                                                                    $day_end=date('Y-m-d');
                                                                    }
                                                                    $different_day=get_different_dates($day_start,$day_end);

                                                                @endphp
                                                                {{$day_start}}
                                                                <br>
                                                                {{$day_end}}
                                                            </td>

                                                            <td>
                                                                {{$different_day}}
                                                            </td>

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
                                                                    @foreach($all_actions as $value)
                                                                       
                                                                            <tr data-bs-toggle="collapse"
                                                                                data-bs-target="#collapseExample"
                                                                                aria-expanded="false"
                                                                                aria-controls="collapseExample">
                                                                                @php
                                                                                $created_by = DB::table('users')->where('id', $value->created_by)->first();
                                                                                @endphp
                                                                                <td>
                                                                                @if ($value->timesType)
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
                                                                                  {{$created_by->name_ar ?? 'لا يوجد'}}
                                                                                </td>
                                                                                <td>
                                                                                    @php

                                                                                        $day_start= explode(' ', $value->date_start)[0];
                                                                                        if ($value->date_end && $value->date_end != '0000-00-00 00:00:00') {
                                                                                            $day_end = explode(' ', $value->date_end)[0];
                                                                                            $different_day = get_different_dates($day_start, $day_end);
                                                                                        } else {
                                                                                            $day_end = 'لم تنتهى';
                                                                                            $different_day = get_different_dates($day_start, now());
                                                                                        }
                                                                                       

                                                                                    @endphp
                                                                                    {{$day_start}}
                                                                                    
                                                                                </td>
                                                                                <td>{{$day_end}}</td>

                                                                                <td>
                                                                                    {{$different_day}}
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

            </div>
        </td>


    </tr>
