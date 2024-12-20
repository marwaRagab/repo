<div class="card mt-4 py-3">
    <div class="d-flex flex-wrap ">
        <a class="btn-filter bg-warning-subtle text-warning px-4 fs-4 mx-1 mb-2" href="{{route('stop_salary')}}">
            الكل
        </a>

        @foreach($courts as $court)

        <a href="{{route('stop_salary',array('court' => $court->id ))}}"
            class="btn-filter {{$court->style}}   px-4 fs-4 mx-1 mb-2"> {{$court->name_ar}} ({{ $court->counter}})
        </a>

        @endforeach

    </div>
</div>
@if( request()->has('court') && count($ministries) > 0)
<div class="card mt-4 py-3">
    <div class="d-flex flex-wrap ">
        @foreach($ministries as $one)

        <a href="{{route('stop_salary',array('court'=> request()->get('court') , 'minsitry_id' => $one->id ))}}"
            class="btn-filter bg-primary-subtle text-primary px-4 fs-4 mx-1 mb-2"> {{$one->name_ar}} ({{ $one->counter}})
        </a>

        @endforeach
    </div>
</div>
@endif
@if( request()->has('court') && request()->has('minsitry_id'))
<div class="card mt-4 py-3">
    <div class="d-flex flex-wrap ">

        @foreach($item_type_time as $item_type)
        <a href="{{route('stop_salary',array('court'=> request()->get('court') , 'minsitry_id' => request()->get('minsitry_id') ,'type' => $item_type->slug ))}}"
            class="btn-filter bg-success-subtle text-success  px-4 fs-4 mx-1 mb-2">
            {{$item_type->name_ar}}
        </a>
        @endforeach
    </div>
</div>
@endif
<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0"> حجز راتب </h4>
    </div>
    <div class="card-body">
        <div class="table-responsive pb-4">
            <table id="all-student" class="table table-bordered border text-nowrap align-middle">
                <thead>
                    <!-- start row -->
                    @php
                    $type_name =
                    \App\Models\Military_affairs\Military_affairs_stop_salary_type::where('slug',request()->get('type'))?->first()?->name_ar;

                    @endphp
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
                        @if(request()->has('type'))
                        <th>{{ $type_name }}</th>
                        @endif
                        <th>تحديد مسئول</th>
                        <th> الاجراءات</th>

                    </tr>
                    <!-- end row -->
                </thead>
                <tbody>

                    <!-- start row -->
                    @foreach ($items as $item)

                    <tr>
                        <td>
                            {{ $loop->iteration }}
                        </td>
                        <td>
                            <a href="{{url('installment/show-installment/'.$item->installment->id)}}">
                                {{$item->installment->id}}</a>
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
                                data-bs-target="#convert_command-{{$item->id}}"> {{ $type_name }}
                            </button>
                            <div id="convert_command-{{$item->id}}" class="modal fade" tabindex="-1"
                                aria-labelledby="bs-example-modal-md" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                    <div class="modal-content">
                                        <form class="mega-vertical" action="{{route('stop_salary_convert', $item->id)}}"
                                            method="post" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="military_affairs_id" value="{{$item->id}}">
                                            <input type="hidden" name="minist_id"
                                                value="{{$item->installment->client->get_ministry->id}}">
                                            <input type="hidden" name="type" value="{{$item_type_time1->type}}">
                                            <input type="hidden" name="type_id" value="{{$item_type_time1->slug}}">
                                            <input type="hidden" name="item_type_new"
                                                value="{{request()->get('type')}}">
                                            <input type="hidden" name="item_type_old" value="{{$item_type_time1->id}}">

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
                                        <a class="btn btn-warning rounded-0 w-100 mt-2" data-bs-toggle="modal"
                                            data-bs-target="#open-details-{{ $item->id }}">
                                            ملاحظات</a>
                                    </li>
                                    <li>
                                        <a class="btn btn-primary rounded-0 w-100 mt-2"
                                            href="{{url('show_settlement/'.$item->id)}}">
                                            تحويل للتسوية </a>
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

                                            <!-- Tab panes -->
                                            <div class="tab-content border mt-2">
                                                @php

                                                $all_notes=get_all_notes('stop_salary',$item->id);
                                                @endphp
                                                <div class="tab-pane active p-3" id="navpill-{{ $item->id }}"
                                                    role="tabpanel">
                                                    <form class="mega-vertical" action="{{url('add_notes')}}"
                                                        method="post" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="form-row">
                                                            <input type="hidden" name="military_affairs_id"
                                                                value="{{ $item->id }}">
                                                            <input type="hidden" name="type"
                                                                value="{{$item_type_time1->type}}">
                                                            <input type="hidden" name="type_id"
                                                                value="{{$item_type_time1->slug}}">



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

                                                            <tr data-bs-toggle="collapse"
                                                                data-bs-target="#collapseExample" aria-expanded="false"
                                                                aria-controls="collapseExample">
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
                </tbody>
            </table>

        </div>
    </div>
</div>