
<tr >
        <td>
        {{ $item->i}}

    </td>


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
            @if (isset($item->final_date_command[0]) && is_numeric($item->final_date_command[0]) && (int)$item->final_date_command[0] > 0)
                {{ \Carbon\Carbon::createFromTimestamp($item->final_date_command[0] ?? '')->format('d-m-Y') }}

            @else
                {{ $item->final_date_command[0] }}
            @endif
            <br>
            @if($item->item_command)
                <a  target="_blank"
                    onclick="checkFileAndRedirect(
                            '{{ $item && $item->item_command && $item->item_command->img_dir !== '0' ? 'https://electron-kw.net/' . $item->item_command->img_dir : '#' }}',
                            '{{ $item && $item->item_command && $item->item_command->img_dir !== '0' ? 'https://electron-kw.com/' . $item->item_command->img_dir : '#' }}'
                        ); return false;">
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
                                   value="{{$item_type_time3->type}}">
                            <input type="hidden" name="type_id"
                                   value="{{$item_type_time3->slug}}">
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
            @if (isset($item->final_date_finished_command[0]) && is_numeric($item->final_date_finished_command[0]) && (int)$item->final_date_finished_command[0] > 0)
                {{ \Carbon\Carbon::createFromTimestamp($item->final_date_finished_command[0] ?? '')->format('d-m-Y') }}

            @else
                {{ $item->final_date_finished_command[0] }}
            @endif
            <br>
            <a  target="_blank"
                onclick="checkFileAndRedirect(
                            '{{ $item && $item->item_finished_command && $item->item_finished_command->img_dir !== '0' ? 'https://electron-kw.net/' . $item->item_finished_command->img_dir : '#' }}',
                            '{{ $item && $item->item_finished_command && $item->item_finished_command->img_dir !== '0' ? 'https://electron-kw.com/' . $item->item_finished_command->img_dir : '#' }}'
                        ); return false;">

                                                            <span class="btn btn-info"> صورة
                                                                 </span>
            </a>
        </td>
        <td>             @if (isset($item->final_date_finished_command[0]) && is_numeric($item->final_date_finished_command[0]) && (int)$item->final_date_finished_command[0] > 0)
                {{ \Carbon\Carbon::createFromTimestamp($item->final_date_finished_command[0] ?? '')->format('d-m-Y') }}

            @else
                {{ $item->final_date_finished_command[0] }}
            @endif


            <br>
            <a  target="_blank"
                onclick="checkFileAndRedirect(
                            '{{ $item && $item->item_finished && $item->item_finished->img_dir !== '0' ? 'https://electron-kw.net/' . $item->item_finished->img_dir : '#' }}',
                            '{{ $item && $item->item_finished && $item->item_finished->img_dir !== '0' ? 'https://electron-kw.com/' . $item->item_finished->img_dir : '#' }}'
                        ); return false;">
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

                رفع منع السفر
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
            <button class="btn btn-success me-6 my-2 @if ($item->emp_id == 0 || $item->emp_id == null  ) disabled @endif" data-bs-toggle="modal"
                    data-bs-target="#convert_resuest-{{$item->id}}"   {{ ($item->status_all->where('type_id','stop_travel_finished')->first() ) ? 'disabled' : '' }}>

                امر منع السفر
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
                        <span class="badge ms-auto text-bg-secondary">{{count($item->all_notes)}}</span>
                        الملاحظات </a>
                </li>

            </ul>


        </div>
        @include('military_affairs.notes_military')
        @include('military_affairs.Execute_alert.print.print')

    </td>


</tr>
@include('military_affairs.Execute_alert.print.script')
