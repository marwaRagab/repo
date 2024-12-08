<div class="card mt-4 py-3">
    <div class="d-flex flex-wrap ">

        @foreach($courts as $court)

            <a href="{{route('execute_alert',array('governorate_id' => $court->id))}}"
               class="btn-filter {{$court->style}}   px-4 fs-4 mx-1 mb-2"> {{$court->name_ar}}
            </a>

        @endforeach
    </div>
</div>

<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0">  الشيكات المستلمة</h4>
        <a class="btn me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4 " href="{{route('all_checks')}}">
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
                    @if($item->installment->finished==0)
                        @if( Request::has('governorate_id') &&  Request::get('governorate_id') == $item->installment->client->governorate_id)

                            <tr>
                                <td>
                                    {{ $loop->index + 1 }}

                                </td>
                                <td>
                                    {{$item->installment->client->name_ar}}
                                    <br>
                                    ({{$item->installment->id}})
                                    <br>
                                    {{$item->installment->client->	civil_number}}
                                </td>
                                <td>{{$item->issue_id}}</td>
                                <td>{{$item->madionia_amount}}</td>
                                <td>{{$iem->excute_actions_check_amount}} </td>
                                <td>{{$item->excute_actions_amount}}  </td>
                                <td> {{$item->excute_actions_counter}}</td>
                                <td> {{$item->military_amount}} </td>
                                <td> {{$item->reminder_amount}} </td>
                                <td>{{$item->excute_actions_last_date_check}}  </td>
                                <td>
                                    <div class="btn-group dropup mb-6 me-6 d-block ">
                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                                id="dropdownMenuButton"
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


                                                <a class="btn btn-warning rounded-0 w-100 mt-2" href="{{ route('installment.show-installment', ['id' => $item->id]) }}"
                                                >
                                                    التفاصيل<
                                            </li>
                                            <li>
                                                <a class="btn btn-success rounded-0 w-100 mt-2" data-bs-toggle="modal"
                                                   data-bs-target="#add-note"> اضافة استعلام
                                                </a>
                                            </li>
                                            <li>
                                                <a class="btn btn-primary rounded-0 w-100 mt-2" data-bs-toggle="modal"
                                                   data-bs-target="#open-settle">
                                                    تحويل للتسوية </a>
                                            </li>
                                        </ul>


                                    </div>
                                    <button class="btn btn-success me-6" data-bs-toggle="modal"
                                            data-bs-target="#add-note">
                                        ملاحظة
                                    </button>
                                </td>
                            </tr>
                        @endif
                        @if(!Request::has('governorate_id'))
                            <tr>
                                <td>
                                    {{ $loop->index + 1 }}

                                </td>
                                <td>
                                    {{$item->installment->client->name_ar}}
                                    <br>
                                    ({{$item->installment->id}})
                                    <br>
                                    {{$item->installment->client->	civil_number}}
                                </td>
                                <td>{{$item->issue_id}}</td>
                                <td>{{$item->eqrar_dain_amount}}</td>
                                <td>{{$item->excute_actions_check_amount}} </td>
                                <td>{{$item->excute_actions_amount}}  </td>
                                <td> {{$item->excute_actions_counter}}</td>
                                <td> {{count($item->military_amount)}} </td>
                                <td> {{$item->reminder_amount}} </td>
                                <td>{{$item->excute_actions_last_date_check}}  </td>
                                <td>
                                    <div class="btn-group dropup mb-6 me-6 d-block ">
                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                                id="dropdownMenuButton"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                            الإجراءات
                                        </button>
                                        <ul class="dropdown-menu rounded-0" aria-labelledby="dropdownMenuButton">
                                            <li>
                                                <a class="btn btn-success rounded-0 w-100 mt-2" href=""
                                                > صورة الاجراءات المالية
                                                </a>
                                            </li>
                                            <li>
                                                <a class="btn btn-warning rounded-0 w-100 mt-2" href="{{ route('installment.show-installment', ['id' => $item->id]) }}"
                                                >
                                                    التفاصيل</a>
                                            </li>

                                            <li>
                                                <a class="btn btn-primary rounded-0 w-100 mt-2" href=""
                                                >
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
                                                <form class="mega-vertical"
                                                      action="{{url('add_amount')}}" method="post"
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
                                                                           onclick="showInputs()"> يوجد
                                                                </label>
                                                                <label>
                                                                    <input type="radio" name="check_found" value="0"
                                                                           onclick="hideInput()"> لا يوجد
                                                                </label>
                                                                <input type="hidden" name="military_affairs_id"
                                                                       value="{{$item->id}}">
                                                                <div id="additionalInputs" class="hidden">
                                                                    <div class="form-group mb-3">
                                                                        <label class="form-label"> المبلغ </label>
                                                                        <input type="text" name="amount"
                                                                               class="form-control">
                                                                        @error('check_amount')
                                                                        <div style='color:red'>{{$message}}</div>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="form-row mb-3 ">
                                                                        <div class="form-group">
                                                                            <label class="form-label">
                                                                                مصدر الحجز</label>
                                                                            <select class="form-select"
                                                                                    name="check_type">
                                                                                <option
                                                                                    value="salary">
                                                                                    حجز راتب
                                                                                </option>
                                                                                <option
                                                                                    value="banks">
                                                                                    حجز بنوك
                                                                                </option>
                                                                                <option
                                                                                    value="cars">
                                                                                    حجز سيارة
                                                                                </option>
                                                                                <option
                                                                                    value="mahkama_madionia_sadad">
                                                                                    سداد مديونية محكمة
                                                                                </option>

                                                                                <option
                                                                                    value="mahkama_installment">
                                                                                    تقسيط محكمة
                                                                                </option>
                                                                            </select>
                                                                            @error('check_amount')
                                                                            <div style='color:red'>{{$message}}</div>
                                                                            @enderror
                                                                        </div>

                                                                    </div>

                                                                    <div class="form-group mb-3">
                                                                        <label class="form-label">التاريخ</label>
                                                                        <input type="date" name="date"
                                                                               class="form-control">
                                                                        @error('date')
                                                                        <div style='color:red'>{{$message}}</div>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="form-group my-3">
                                                                        <label for="formFile"
                                                                               class="form-label">الصورة </label>
                                                                        <input class="form-control" name="img_dir"
                                                                               type="file" id="formFile">
                                                                        @error('date')
                                                                        <div style='color:red'>{{$message}}</div>
                                                                        @enderror
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
                                    <div id="add-check-{{$item->id}}" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                            <form class="mega-vertical"
                                                  action="{{url('add_check')}}" method="post"
                                                  enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-content">
                                                    <div class="modal-header d-flex align-items-center">
                                                        <h4 class="modal-title" id="myModalLabel">
                                                            الملاحظة</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        @php
                                                            $check_amount = $item->military_amount->where('military_affairs_check_id',0)->sum('amount');
                                                        @endphp
                                                        <input type="hidden"  name="military_affairs_id" value="{{$item->id}}"/>

                                                        <div class="form-row">
                                                            <div class="form-group mb-3">
                                                                <label class="form-label">مبلغ الشيك  </label>
                                                                <input type="text" name="check_amount"  readonly onchange="check(this)" value="{{$check_amount}}"  class="form-control">
                                                            </div>
                                                            <div class="form-group mb-3">
                                                                <label class="form-label">رقم الشيك  </label>
                                                                <input type="text" name="check_number"   value=""  class="form-control">
                                                            </div>
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


                                    <button class="btn btn-success me-6" data-bs-toggle="modal"
                                            data-bs-target="#add-note-{{$item->id}}">
                                        ملاحظة
                                    </button>

                                    <div id="add-note-{{$item->id}}" class="modal fade" tabindex="-1"
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

                                                        </ul>
                                                        <!-- Tab panes -->

                                                        <div class="tab-content border mt-2">
                                                            @php

                                                                $all_notes=get_all_notes('excute_actions',$item->id);
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


                                                                            <td>{{formatTime($time)}}}}<span
                                                                                    class="d-block"></span></td>
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
                                                                           value="{{$item_type_time->id}}">
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
                                                                                    <br>
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

                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>

                                </td>
                            </tr>

                        @endif
                    @endif

                @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>


<!-- modals -->
<div id="add-note" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myModalLabel">
                    الملاحظة</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-row">
                        <div class="form-group mb-3">
                            <label class="form-label">تاريخ فتح الملف</label>
                            <input type="date" class="form-control">
                        </div>
                        <div class="mb-7">
                            <label>
                                <input type="radio" name="option" value="option1" onclick="showInputs()"> معاد
                            </label>
                            <label>
                                <input type="radio" name="option" value="option2" onclick="showInputs()"> تم التبليغ
                            </label>

                            <div id="additionalInputs" class="hidden">
                                <div class="form-group mb-3">
                                    <label class="form-label">التاريخ</label>
                                    <input type="date" class="form-control">
                                </div>
                                <div class="form-group my-3">
                                    <label for="formFile" class="form-label">الصورة </label>
                                    <input class="form-control" type="file" id="formFile">
                                </div>
                                <div class="form-group">
                                    <div class="my-3">
                                        <label class="form-label">الملاحظات</label>
                                        <textarea class="form-control" rows="5"></textarea>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer d-flex ">
                <button type="submit" class="btn btn-primary">حفظ</button>
                <button type="button" class="btn bg-danger-subtle text-danger  waves-effect" data-bs-dismiss="modal">
                    الغاء
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    function showInputs() {
        document.getElementById('additionalInputs').classList.remove('hidden');
    }

    function hideInput() {
        document.getElementById('additionalInputs').classList.add('hidden');
    }

    function check(id) {
        var amount=id.value;

        var  val = "<?php   echo $check_amount ;  ?>";

        if(amount > val){
            alert( val +'مبلغ الشيك لابد ان يكون اقل من ');

        }
        return false;

    }

</script>
