@php use Illuminate\Support\Facades\Request; @endphp
<div class="card mt-4 py-3">
    <div class="d-flex flex-wrap ">
        <a href="{{route('stop_travel')}}"

           class="btn border border-info font-medium text-info hover:bg-info hover:text-white focus:bg-info focus:text-white active:bg-info/90 ml-3 mt-3">
            العدد الكلي ({{count($items)}})
        </a>
        @php
            if(Request::has('governorate_id')){
                $gov=Request::get('governorate_id');
            }else{
               $gov='';
            }
             if(Request::has('stop_travel_type')){
                $travel_type=Request::get('stop_travel_type');
            }else{
             $travel_type='';
            }
        @endphp

        @foreach($courts as $court)

            <a href="{{route('stop_travel',array('governorate_id' => $court->id,'stop_travel_type'=>$travel_type))}}"
               class="btn border border-secondary font-medium text-secondary hover:bg-secondary hover:text-white focus:bg-secondary focus:text-white active:bg-secondary/90 dark:text-secondary-light dark:hover:bg-secondary dark:hover:text-white dark:focus:bg-secondary dark:focus:text-white dark:active:bg-secondary/90 ml-3 mt-3">
                {{$court->name_ar}}
            </a>

        @endforeach


    </div>
    <div class="d-flex flex-wrap ">

        @php
            if(Request::has('governorate_id')){
                $gov=Request::get('governorate_id');
            }else{
               $gov='';
            }
             if(Request::has('stop_travel_type')){
                $travel_type=Request::get('stop_travel_type');
            }else{
             $travel_type='';
            }
        @endphp

        @foreach($stop_travel_types as $stop_travel_type)

            <a href="{{route('stop_travel',array('stop_travel_type' => $stop_travel_type->slug,'governorate_id'=>$gov ))}}"
               class="btn border border-secondary font-medium text-secondary hover:bg-secondary hover:text-white focus:bg-secondary focus:text-white active:bg-secondary/90 dark:text-secondary-light dark:hover:bg-secondary dark:hover:text-white dark:focus:bg-secondary dark:focus:text-white dark:active:bg-secondary/90 ml-3 mt-3">
                {{$stop_travel_type->name_ar}}
            </a>

        @endforeach
    </div>

</div>


<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0"> منع السفر</h4>
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
                    <th> العددات</th>
                    <th> تاريخ فتح ملف</th>
                    <th>الرقم الالى</th>


                    @if(Request::get('stop_travel_type')=='command')
                        )
                        <th>تاريخ طلب منع سفر</th>
                        <th> منع سفر</th>
                    @elseif(Request::get('stop_travel_type')=='stop_travel_finished')
                        )
                        <th>تاريخ طلب منع سفر</th>
                        <th> تاريخ منع سفر</th>
                    @elseif(Request::get('stop_travel_type')=='stop_travel_cancel_request')
                        )
                        <th> تاريخ طلب رفع منع سفر</th>
                        <th> رفع منع سفر</th>
                    @elseif(Request::get('stop_travel_type')=='stop_travel_cancel')
                        )
                        <th> تاريخ طلب رفع منع سفر</th>
                        <th> تاريخ رفع منع سفر</th>
                    @else
                        <th>امر منع سفر</th>

                    @endif

                    <th> الإجراءات</th>

                </tr>
                <!-- end row -->
                </thead>
                <tbody>

                <!-- start row -->
                @if(isset($items))
                    @foreach( $items as $item)
                        @if($item->installment->finished==0)
                            @if( Request::has('governorate_id') &&  Request::get('governorate_id') == $item->installment->client->governorate_id)
                                <tr data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false"
                                    aria-controls="collapseExample">
                                    <td>
                                        {{ $loop->index + 1 }}
                                    </td>
                                    <td>
                                        <a href=""> {{$item->installment->id}}</a>

                                    </td>
                                    <td>{{$item->installment->client->name_ar}}</td>
                                    <td>{{$item->installment->client->court->name_ar}}
                                        <br>
                                        {{$item->type_papar}}
                                    </td>

                                    <td>
                                        {{$item->date}}
                                        <br>
                                        {{$item->different_date}}
                                    </td>
                                    <td>
                                        {{$item->open_file_date}}
                                    </td>

                                    <td>
                                        {{$item->issue_id}}
                                        {{$item->status_all->where('type_id','request')->first()->date}}
                                    </td>
                                    @if(Request::get('stop_travel_type')=='command')
                                        <td>
                                            @php
                                                $date_request=$item->status_all->where('type_id','request')->first()->date;
                                              // $final_date=explode('',$date_request);
                                            @endphp
                                            {{$date_request}}
                                        </td>
                                        <td>
                                            <button class="btn btn-success me-6 my-2" data-bs-toggle="modal"
                                                    data-bs-target="#convert_command-{{$item->id}}">

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
                                                                               class="form-control mb-2" id="input1">
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
                                        @php
                                            $date_request=$item->status_all->where('type_id','request')->first()->date;
                                            $date_command=$item->status_all->where('type_id','command')->first()->date;
                                          // $final_date=explode('',$date_request);
                                        @endphp

                                        <td>{{$date_request}}</td>
                                        <td>   {{$date_command}}</td>
                                    @elseif(Request::get('stop_travel_type')=='stop_travel_cancel_request')
                                        <td>ر
                                            @php
                                                $date_convert_cancel=$item->status_all->where('type_id','stop_travel_cancel_request')->first()->date;
                                              // $final_date=explode('',$date_request);
                                            @endphp
                                            {{$date_convert_cancel}}

                                        </td>
                                        <td>
                                            <button class="btn btn-success me-6 my-2" data-bs-toggle="modal"
                                                    data-bs-target="#cancel_stop_travel-{{$item->id}}">

                                                منع السفر
                                            </button>
                                            <div id="cancel_stop_travel-{{$item->id}}" class="modal fade" tabindex="-1"
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
                                                                   value="{{$item_type_time4->slug}}">
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
                                                                               class="form-control mb-2" id="input1">
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
                                        <td> تاريخ طلب رفع منع سفر</td>
                                        <td> تاريخ رفع منع سفر</td>
                                    @else
                                        <td>
                                            <button class="btn btn-success me-6 my-2" data-bs-toggle="modal"
                                                    data-bs-target="#convert_resuest-{{$item->id}}">

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
                                                                   value="{{$item_type_time1->slug}}">
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
                                                                               class="form-control mb-2" id="input1">
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
                                        <div class="btn-group dropup mb-6 me-6">
                                            <button class="btn btn-secondary dropdown-toggle" type="button"
                                                    id="dropdownMenuButton"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                الإجراءات
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <li>
                                                    <a class="btn btn-success rounded-0 w-100 mt-2"
                                                       data-bs-toggle="modal"
                                                       href="">
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
                                                                        <a class="nav-link active" data-bs-toggle="tab"
                                                                           href="#navpill-1" role="tab">
                                                                            <span>الملاحظات</span>
                                                                        </a>
                                                                    </li>
                                                                    <li class="nav-item">
                                                                        <a class="nav-link" data-bs-toggle="tab"
                                                                           href="#navpill-2" role="tab">
                                                                            <span>الإجراءات</span>
                                                                        </a>
                                                                    </li>

                                                                </ul>
                                                                <!-- Tab panes -->
                                                                @if(count($items)>=1)

                                                                    <div class="tab-content border mt-2">
                                                                        @php

                                                                            $all_notes=get_all_notes('stop_travel',$item->id);
                                                                        @endphp
                                                                        <div class="tab-pane active p-3" id="navpill-1"
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
                                                                                            <label class="form-label">الملاحظات</label>
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
                                                                        <div class="tab-pane p-3" id="navpill-2"
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
                                                                                @foreach($all_notes as $value)
                                                                                    @php
                                                                                        $types=['answered','note','refused'];
                                                                                    @endphp

                                                                                    @if(!in_array($value->notes_type, $types))
                                                                                        <tr data-bs-toggle="collapse"
                                                                                            data-bs-target="#collapseExample"
                                                                                            aria-expanded="false"
                                                                                            aria-controls="collapseExample">
                                                                                            <td>
                                                                                                {{$value->created_by}}
                                                                                            </td>
                                                                                            <td>

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
                                                                                                {{$day_end}}
                                                                                            </td>

                                                                                            <td>
                                                                                                {{$different_day}}
                                                                                            </td>

                                                                                        </tr>

                                                                                    @endif

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

                            @endif
                            @if(!Request::has('governorate_id'))
                                <tr data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false"
                                    aria-controls="collapseExample">
                                    <td>
                                        {{ $loop->index + 1 }}
                                    </td>
                                    <td>
                                        <a href=""> {{$item->installment->id}}</a>

                                    </td>
                                    <td>{{$item->installment->client->name_ar}}</td>
                                    <td>{{$item->installment->client->court->name_ar}}
                                        <br>
                                        {{$item->type_papar}}
                                    </td>

                                    <td>
                                        {{$item->date}}
                                        <br>
                                        {{$item->different_date}}
                                    </td>
                                    <td>
                                        {{$item->open_file_date}}
                                    </td>

                                    <td>
                                        {{$item->issue_id}}
                                        {{$item->status_all->where('type_id','request')->first()->date}}
                                    </td>
                                    @if(Request::get('stop_travel_type')=='command')
                                        <td>
                                            @php
                                                $date_request=$item->status_all->where('type_id','request')->first()->date;
                                              // $final_date=explode('',$date_request);
                                            @endphp
                                            {{$date_request}}
                                        </td>
                                        <td>
                                            <button class="btn btn-success me-6 my-2" data-bs-toggle="modal"
                                                    data-bs-target="#convert_command-{{$item->id}}">

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
                                                                               class="form-control mb-2" id="input1">
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
                                        @php
                                            $date_request=$item->status_all->where('type_id','request')->first()->date;
                                            $date_command=$item->status_all->where('type_id','command')->first()->date;
                                          // $final_date=explode('',$date_request);
                                        @endphp

                                        <td>{{$date_request}}</td>
                                        <td>   {{$date_command}}</td>
                                    @elseif(Request::get('stop_travel_type')=='stop_travel_cancel_request')
                                        <td>ر
                                            @php
                                                $date_convert_cancel=$item->status_all->where('type_id','stop_travel_cancel_request')->first()->date;
                                              // $final_date=explode('',$date_request);
                                            @endphp
                                            {{$date_convert_cancel}}

                                        </td>
                                        <td>
                                            <button class="btn btn-success me-6 my-2" data-bs-toggle="modal"
                                                    data-bs-target="#cancel_stop_travel-{{$item->id}}">

                                                منع السفر
                                            </button>
                                            <div id="cancel_stop_travel-{{$item->id}}" class="modal fade" tabindex="-1"
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
                                                                   value="{{$item_type_time4->slug}}">
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
                                                                               class="form-control mb-2" id="input1">
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
                                        <td> تاريخ طلب رفع منع سفر</td>
                                        <td> تاريخ رفع منع سفر</td>
                                    @else
                                        <td>
                                            <button class="btn btn-success me-6 my-2" data-bs-toggle="modal"
                                                    data-bs-target="#convert_resuest-{{$item->id}}">

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
                                                                   value="{{$item_type_time1->slug}}">
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
                                                                               class="form-control mb-2" id="input1">
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
                                        <div class="btn-group dropup mb-6 me-6">
                                            <button class="btn btn-secondary dropdown-toggle" type="button"
                                                    id="dropdownMenuButton"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                الإجراءات
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <li>
                                                    <a class="btn btn-success rounded-0 w-100 mt-2"
                                                       data-bs-toggle="modal"
                                                       href="">
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
                                                                        <a class="nav-link active" data-bs-toggle="tab"
                                                                           href="#navpill-1" role="tab">
                                                                            <span>الملاحظات</span>
                                                                        </a>
                                                                    </li>
                                                                    <li class="nav-item">
                                                                        <a class="nav-link" data-bs-toggle="tab"
                                                                           href="#navpill-2" role="tab">
                                                                            <span>الإجراءات</span>
                                                                        </a>
                                                                    </li>

                                                                </ul>
                                                                <!-- Tab panes -->
                                                                @if(count($items)>=1)

                                                                    <div class="tab-content border mt-2">
                                                                        @php

                                                                            $all_notes=get_all_notes('stop_travel',$item->id);
                                                                        @endphp
                                                                        <div class="tab-pane active p-3" id="navpill-1"
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
                                                                                            <label class="form-label">الملاحظات</label>
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
                                                                        <div class="tab-pane p-3" id="navpill-2"
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
                                                                                @foreach($all_notes as $value)
                                                                                    @php
                                                                                        $types=['answered','note','refused'];
                                                                                    @endphp

                                                                                    @if(!in_array($value->notes_type, $types))
                                                                                        <tr data-bs-toggle="collapse"
                                                                                            data-bs-target="#collapseExample"
                                                                                            aria-expanded="false"
                                                                                            aria-controls="collapseExample">
                                                                                            <td>
                                                                                                {{$value->created_by}}
                                                                                            </td>
                                                                                            <td>

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
                                                                                                {{$day_end}}
                                                                                            </td>

                                                                                            <td>
                                                                                                {{$different_day}}
                                                                                            </td>

                                                                                        </tr>

                                                                                    @endif

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

                            @endif
                        @endif
                    @endforeach

                @endif
                </tbody>
            </table>

        </div>

    </div>
</div>


<script>


</script>
