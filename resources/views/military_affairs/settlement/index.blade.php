@php use Illuminate\Support\Facades\Request; @endphp

<div class="card mt-4 py-3">

    @php
        if(Request::has('type') && Request::get('type')=='done' ){
            $settel_type=1;
        } if(Request::has('type') && Request::get('type')=='request' ){
            $settel_type=2;
        } if(Request::has('type') && Request::get('type')=='canceled' ){
            $settel_type=3;
        }


    @endphp

    <div class="d-flex flex-wrap ">
        <a class="btn-filter bg-warning-subtle text-warning px-4 fs-4 mx-1 mb-2" href="{{route('settle.index')}}">
            العدد الكلي ({{count($settlement_all)}})
        </a>
        <a class="btn-filter  bg-success-subtle text-success px-4 fs-4 mx-1 mb-2" href="{{route('settle.index',array('type' =>'request'))}}">
            طلبات التسوية ({{count($settlement_all->where('type',2))}})
        </a>
        <a class="btn-filter  bg-success-subtle text-success px-4 fs-4 mx-1 mb-2" href="{{route('settle.index',array('type' =>'done'))}}">
            اتمام التسوية
            ({{count($settlement_all->where('type',1))}}) </a>

        <a class="btn-filter bg-danger-subtle text-danger px-4 fs-4 mx-1 mb-2" href="{{route('settle.index',array('type' =>'canceled'))}}">
            الغاء التسوية ({{count($settlement_all->where('type',3))}}) </a>
    </div>


</div>
<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0"> التسوية</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive pb-4">
            <table id="all-student" class="table table-bordered border text-nowrap align-middle">
                <thead>
                <!-- start row -->


                <tr>
                    <th>#</th>
                    <th>اسم العميل</th>
                    <th>مبلغ الاقرار  </th>
                    <th>  الاقساط المدفوعة</th>
                    <th>مبلغ التسوية </th>
                    <th> المقدم </th>
                    <th> عدد الاقساط</th>

                    <th> قيمة القسط الشهري </th>

                    <th> قيمة القسط الاخير </th>
                    <th>الاجراءات</th>
                    <th> الملاحظة </th>

                </tr>


                <!-- end row -->
                </thead>
                <tbody>
                <!-- start row -->
                @foreach($settlement as $one)
                    @if($one->military_affair->installment)
                    <tr>

                        <td>{{ $loop->iteration }}</td>
                        <td> {{$one->military_affair->installment->client->name_ar}}
                            <br>
                            {{$one->military_affair->installment->client->civil_number}}
                            <br>
                            {{$one->military_affair->installment->id}}
                        </td>
                        <td>{{$one->military_affair->eqrar_dain_amount}}</td>
                        <td>{{$one->military_affair->payment_done}} </td>
                        <td>{{ $one->settle_amount }}</td>
                        <td> {{ $one->first_amount_settle  }}</td>
                        <td> {{ $one->installment_no  }}</td>
                        <td>{{$one->month_amount}} </td>


                        <td>{{$one->last_month_amount}}</td>
                        <td>
                            <div class="btn-group dropup me-6 my-2 d-block ">
                                <button class="btn bg-success-subtle text-success dropdown-toggle" type="button"
                                        id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    الإجراءات
                                </button>
                                <ul class="dropdown-menu rounded-0" aria-labelledby="dropdownMenuButton">

                                    @foreach(json_decode($one->actions,true) as $action)

                                        @if($action==0)
                                            <li>
                                                <h6 class="btn-static bg-secondary-subtle text-secondary rounded-0 w-100 mt-2">تحويل الطلب
                                                    تحويل طلب رفع  منع سفر</h6>
                                            </li>
                                        @endif
                                        @if($action==1)
                                            <li>
                                                <h6 class="btn-static bg-danger-subtle text-danger rounded-0 w-100 mt-2">
                                                    تحويل طلب رفع حجز سيارات </h6>
                                            </li>
                                        @endif
                                        @if($action==2)
                                            <li>
                                                <h6 class="btn-static bg-primary-subtle text-primary rounded-0 w-100 mt-2">
                                                    تحويل طلب رفع حجز بنك </h6>
                                            </li>
                                        @endif
                                        @if($action==3)
                                            <li>
                                                <h6 class="btn-static bg-secondary-subtle text-secondary rounded-0 w-100 mt-2">تحويل الطلب
                                                    رفع حجز راتب</h6>
                                            </li>
                                        @endif

                                    @endforeach



                                </ul>


                            </div>
                            <div id="cancel-settle-{{$one->id}}" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                    <div class="modal-content">
                                        <form class="mega-vertical"
                                              action="{{url('cancel_settlement')}}" method="post"
                                              enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="military_affairs_id" value="{{$one->military_affair->id}}">
                                            <input type="hidden" name="type" value="{{$item_type_time_old->type  ?? null}}">
                                            <input type="hidden" name="type_id" value="{{$item_type_time_old->id ?? null}}">
                                            <input type="hidden" name="settle_id" value="{{$one->id}}">

                                            <div class="modal-header d-flex align-items-center">
                                                <h4 class="modal-title" id="myModalLabel">
                                                </h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">

                                                <div class="form-row">
                                                    <div class="form-group">
                                                        <label class="form-label" for="input1 "> تاريخ </label>
                                                        <input type="date"  name="settle_date"  class="form-control mb-2" id="input1">
                                                        @error('settle_date')
                                                        <div style='color:red'>{{$message}}</div>
                                                        @enderror
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="my-3">
                                                            <label class="form-label">الملاحظات</label>
                                                            <textarea class="form-control" name="note"  rows="5"></textarea>
                                                            @error('note')
                                                            <div style='color:red'>{{$message}}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="modal-footer d-flex ">
                                                <button type="submit" class="btn btn-primary">حفظ   </button>
                                                <button type="button" class="btn bg-danger-subtle text-danger  waves-effect" data-bs-dismiss="modal">
                                                    الغاء
                                                </button>
                                            </div>
                                        </form>
                                    </div>

                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>

                            @if(Request::has('type') && Request::get('type')=='request' )



                                <button class="btn btn-danger me-6 my-2 d-block"  data-bs-toggle="modal"
                                        data-bs-target="#cancel-settle-{{$one->id}}">
                                    الغاء التسوية  </button>




                                <button class="btn btn-info me-6 my-2 d-block"  data-bs-toggle="modal"
                                        data-bs-target="#done-settle-{{$one->id}}">
                                    اتمام التسوية  </button>


                                <div id="done-settle-{{$one->id}}" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable modal-xl">
                                        <form class="mega-vertical"
                                              action="{{url('pay_settlement')}}" method="post"
                                              enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-content">
                                                <div class="modal-header d-flex align-items-center">
                                                    <h4 class="modal-title" id="myModalLabel">
                                                        إتمام التسوية</h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <h6 class="mb-3">
                                                                الإسم :
                                                                <span class="text-muted"> {{$one->military_affair->installment->client->name_ar}} ( {{$one->military_affair->installment->id}} ) </span>
                                                            </h6>
                                                            <h6 class="mb-3">
                                                                الرقم المدنى :
                                                                <span class="text-muted">{{$one->military_affair->installment->client->civil_number}} </span>
                                                            </h6>
                                                            <h6 class="mb-3">
                                                                رقم الهاتف :
                                                                <span class="text-muted">{{$one->phone}} </span>
                                                            </h6>
                                                            <h6 class="mb-3">
                                                                مبلغ المديونية :
                                                                <span class="text-muted">{{$one->military_affair->eqrar_dain_amount}}</span>
                                                            </h6>
                                                        </div>
                                                        <div class="col-6">
                                                            <h6 class="mb-3">
                                                                المدفوع :
                                                                <span class="text-muted">{{$one->military_affair->eqrar_dain_amount}}</span>
                                                            </h6>
                                                            <h6 class="mb-3">
                                                                قيمة القسط الشهرى :
                                                                <span class="text-muted">{{$one->month_amount}}</span>
                                                            </h6>
                                                            <h6 class="mb-3">
                                                                قيمة القسط الاخير :
                                                                <span class="text-muted"> {{$one->last_month_amount}}</span>
                                                            </h6>
                                                            <h6 class="mb-3">
                                                                عدد الأقساط :
                                                                <span class="text-muted"> {{$one->installment_no}} </span>
                                                            </h6>
                                                        </div>
                                                    </div>

                                                    <div class="form-row flex-nowrap d-flex gap-3 p-3 border mt-3">
                                                        <div class="form-group">
                                                            <label for="first_amount_settle" class="form-label"> المقدم </label>
                                                            <input type="text"   value="{{$one->first_amount_settle}}"    name="first_amount_settle" id="first_amount_settle" class="form-control ">
                                                            @error('first_amount_settle')
                                                            <div style='color:red'>{{$message}}</div>
                                                            @enderror
                                                        </div>
                                                        <input type="hidden" name="installment_id"  value="{{$one->military_affair->installment->id}}" >
                                                        <input type="hidden" name="military_affairs_id"  value="{{$one->military_affair->id}}" >
                                                        <input type="hidden" name="amount"  value="{{$one->month_amount}}" >
                                                        <input type="hidden" name="settle_id"  value="{{$one->id}}" >
                                                        <input type="hidden" name="item_type_time_old"  value="{{$item_type_time_old->id  ?? null}}" >
                                                        <input type="hidden" name="item_type_time_new"  value="{{$item_type_time_new->id ?? null }}" >
                                                        <input type="hidden" name="last_month_amount"  value="{{$one->last_month_amount}}" >
                                                        <input type="hidden" name="month_amount"  value="{{$one->month_amount}}" >

                                                        <div class="form-group">
                                                            <label for="uploadFile" class="form-label"> الصورة</label>
                                                            <input class="form-control"   accept="image/*" name="img" type="file" id="uploadFile">
                                                            @error('img')
                                                            <div style='color:red'>{{$message}}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="installment_no" class="form-label"> اختار طريقة الدفع </label>
                                                            <select class="form-control form-select" name="payment_type" id="payment_type"  onchange="show_pay_type(this)">
                                                                <option value="cash">كاش</option>
                                                                <option value="link">رابط</option>
                                                                <option value="knet">كى نت</option>
                                                            </select>
                                                            @error('payment_type')
                                                            <div style='color:red'>{{$message}}</div>
                                                            @enderror

                                                        </div>
                                                        <div class="form-group"    style="display: none"  id="pay_details_div">
                                                            <label for="first_amount_settle"  id="label_pay" class="form-label"> تفاصيل الرابط </label>
                                                            <input type="text"   value=""    name="pay_details" id="pay_details" class="form-control ">

                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="modal-footer d-flex ">
                                                    <button type="submit" class="btn btn-primary">حفظ </button>
                                                    <button type="button" class="btn bg-danger-subtle text-danger  waves-effect" data-bs-dismiss="modal">
                                                        الغاء
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>

                            @endif
                            @if(Request::has('type') && Request::get('type')=='done' )

                                <button class="btn btn-danger me-6 my-2 d-block"   data-bs-toggle="modal"
                                        data-bs-target="#cancel-settle-{{$one->id}}" >
                                    الإلغاء</button>


                            @endif
                            @if(Request::has('type') && Request::get('type')=='canceled' )

                                <button class="btn btn-danger me-6 my-2 d-block">
                                    {{$one->cancel_note}}</button>
                            @endif
                            @if(!Request::has('type'))

                                @if($one->type==3)
                                    <button class="btn btn-danger me-6 my-2">
                                        الإلغاء</button>
                                @elseif($one->type==1)
                                    <button class="btn btn-success me-6 my-2">
                                        اتمام التسوية</button>
                                @else
                                    <button class="btn btn-info me-6 my-2">
                                        طلب التسوية</button>
                                @endif
                            @endif



                        </td>
                        <td>
                            <a class="btn btn-success me-6 my-2 d-block" href="{{ url('installment/show-installment/' . $one->military_affair->installment->id) }}">
                                التفاصيل
                            </a>
                            @php
                                $all_notes=get_all_notes('settlement',$one->id);
                                $all_actions=get_all_actions($one->id);
                                $get_all_delegations = get_all_delegations($one->id);

                            @endphp
                            <button class="btn btn-primary me-6 my-2 d-block" data-bs-toggle="modal"
                                    data-bs-target="#open-details-{{$one->id}}">
                                الملاحظات <span class="badge ms-auto text-bg-secondary">{{count($all_notes)}}</span>
                            </button>
                            <div id="open-details-{{$one->id}}" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header d-flex align-items-center">
                                            <h4 class="modal-title" id="myModalLabel">
                                                ملاحظات التسوية </h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <ul class="nav nav-pills" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" data-bs-toggle="tab" href="#navpill-1-{{$one->id}}" role="tab">
                                                        <span>الملاحظات</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-bs-toggle="tab" href="#navpill-2-{{$one->id}}" role="tab">
                                                        <span>الإجراءات</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                                <a class="nav-link" data-bs-toggle="tab"
                                                                   href="#actions-{{$one->id}}" role="tab">
                                                                    <span>تتبع المعاملة</span>
                                                                </a>
                                                            </li>

                                            </ul>
                                            <!-- Tab panes -->
                                            <div class="tab-content border mt-2">
                                                <div class="tab-pane active p-3" id="navpill-1-{{$one->id}}" role="tabpanel">
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
                                                            <tr data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false"
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
                                                                <td>
                                                                    @php
                                                                        $time= explode(' ', $all_note->date)[1];
                                                                        $day= explode(' ', $all_note->date)[0];

                                                                    @endphp

                                                                    {{$time}} <span class="d-block">مساءا</span></td>
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
                                                    <h4 class="mb-3">أضف ملاحظة </h4>
                                                    <form class="mega-vertical"
                                                          action="{{url('add_notes')}}" method="post"
                                                          enctype="multipart/form-data">
                                                        @csrf

                                                        <input type="hidden"
                                                               name="military_affairs_id"
                                                               value="{{ $one->id }}">

                                                        <input type="hidden" name="type"
                                                               value="settlement">

                                                        <div class="form-row">
                                                            <div class="form-group">
                                                                <label class="form-label"> الاتصال</label>
                                                                <select class="form-select" name="notes_type">
                                                                    <option value="answered">
                                                                        رد </option>
                                                                    <option value="answered">
                                                                        لم يرد </option>
                                                                    <option value="note">
                                                                        ملاحظة </option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="my-3">
                                                                    <label class="form-label">الملاحظات</label>
                                                                    <textarea class="form-control" name="note"  rows="5"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary"> حفظ</button>
                                                    </form>


                                                </div>
                                                <div class="tab-pane p-3" id="navpill-2-{{$one->id}}" role="tabpanel">
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

                                            </div>
                                        </div>
                                        <div class="modal-footer d-flex ">
                                            <!-- <a class="btn btn-primary" href="../installments/show-installment.html"> تفصيل المعاملة</a> -->
                                            <button type="button" class="btn bg-danger-subtle text-danger  waves-effect" data-bs-dismiss="modal">
                                                إغلاق
                                            </button>
                                        </div>
                                    </div>
                                </div>
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
<script>

    function show_pay_type(val) {

        var pay_type = val.value;

        if (pay_type == "knet") {
            $("#pay_details_div").show();
            document.getElementById('label_pay').innerText = 'رقم وصل الكى نت';
        } else if (pay_type == "link") {
            $("#pay_details_div").show();
            document.getElementById('label_pay').innerText = 'الرابط';
        } else {
            $("#pay_details_div").hide();
        }


    }

</script>
