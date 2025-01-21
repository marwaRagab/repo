<link rel="stylesheet" href="{{ asset('assets/libs/owl.carousel/dist/assets/owl.carousel.min.css') }}" />

<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0"> نظام الاقساط</h4>
    </div>

</div>

@if ($Installment->laws == 1)
<div data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $militaryAffair->id }}">
    <div class="alert alert-danger text-center" role="alert">
        المعاملة محولة للشئون القانونية
    </div>
</div>
@endif

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <div class="accordion accordion-flush" id="accordionFlushExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingOne">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                            <i class="ti ti-user-check fs-6 d-block mx-1" style="color: rgb(1, 122, 58);"></i> بيانات
                            العميل <span class="text-gray mx-1">( قم بالضغط هنا لاظهار البيانات العميل)</span>
                        </button>
                    </h2>
                    <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne"
                        data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <div class="table-responsive pb-4">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th>الاسم</th>
                                            <td>{{$Installment->client->name_ar ?? 'لا يوجد '}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>الرقم المدني</th>
                                            <td>{{$Installment->client->civil_number ?? 'لا يوجد'}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>الهاتف</th>
                                            @if($Client && $Client->client_phone && $Client->client_phone->last())
                                            <td>{{ $Client->client_phone->last()->phone }}</td>
                                            @else
                                            <td>لا يوجد</td>
                                            @endif

                                        </tr>
                                        <tr>
                                            <th>المقدم الاساسي</th>
                                            <td>{{$Installment->part ?? 'لا يوجد'}} </td>
                                        </tr>
                                        <tr>
                                            <th>المقدم الاضافي</th>
                                            <td>{{$Installment->extra_first_amount ?? 'لا يوجد'}}</td>
                                        </tr>
                                        <tr>
                                            <th>اجمالي المقدم</th>
                                            <!-- <td>{{ number_format($Installment->first_amount + $Installment->extra_first_amount , 3)}} -->
                                            <!-- </td> -->
                                            <td>{{number_format($Installment->total_first_amount, 3)}}</td>

                                        </tr>
                                        <tr>
                                            <th>المبالغ المدفوعة</th>
                                            <td>
                                                {{ number_format(($done_amount + $Installment->total_first_amount  + $done_amount_settlement), '3') }}
                                                {{ number_format(($done_amount ), '3') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>المبلغ الاجمالي</th>
                                            <td>{{ number_format(($done_amount + $not_done_amount), '3') }}</td>
                                        </tr>
                                        <!-- <tr>
                                            <th>المتبقي</th>
                                            @if($Installment->law == 0)
                                        <td>{{ number_format(($Installment->total + $Installment->first_amount - $done_amount) ,3)}}</td>


                                    @else
                                        <td>{{ number_format(($Installment->total - $mil_amount),3)}}</td>


                                    @endif
                                    </tr> -->
                                        <tr>
                                            <th>المبلغ المتبقى</th>
                                            @if (!empty($data["military_affairs_item"]))
                                            <td>
                                                {{ number_format(
                                                    $data["military_affairs_item"]->eqrar_dain_amount
                                                    - $done_amount
                                                    - $data["military_affairs_item"]->excute_actions_amount
                                                    - $data["military_affairs_item"]->excute_actions_check_amount
                                                    - $done_amount_settlement,
                                                    3
                                                ) }}
                                            </td>
                                            @else
                                            <td>{{ number_format( ((($done_amount + $not_done_amount)) - $Installment->total_first_amount ), '3')}}
                                            </td>
                                            @endif

                                        </tr>
                                        <tr>
                                            <th>مبلغ اقرار الدين</th>
                                            <td>{{$Installment->eqrardain_amount}}</td>
                                        </tr>
                                        <tr>
                                            <th>عدد الاقساط</th>
                                            <td>{{$Installment->count_months}}</td>
                                        </tr>
                                        <tr>
                                            <th>عدد الاقساط المتأخرة</th>
                                            <td>{{ $not_done_count_lated }}</td>
                                        </tr>
                                        <tr>
                                            <th>عدد الاقساط المدفوعة</th>
                                            <td>{{$Installment['months'] - $not_done_count}}</td>
                                        </tr>
                                        <tr>
                                            <th>قيمة الخصم</th>
                                            <!-- <td> {{ count($install_discount) > 0  ? $install_discount->amount : 0}}</td> -->
                                            <td>{{$nstallment_discount}}</td>
                                        </tr>
                                        <tr>
                                            <th>عدد الاقساط المستحقة</th>
                                            <td>{{$not_done_count}}</td>
                                        </tr>
                                        <tr>
                                            <th>القسط الشهري</th>
                                            <td>{{$Installment->monthly_amount }}</td>
                                        </tr>
                                        <tr>
                                            <th>القسط الداخلي</th>
                                            <td>{{$Installment->intrenal_installment}}</td>
                                        </tr>
                                        <tr>
                                            <th>قسط الساينت</th>
                                            <td>{{$Installment->installment_client->cinet_installment ?? ''}}</td>
                                        </tr>
                                        <tr>
                                            <th>بنك العميل</th>
                                            @php
                                                    $ClientWorking = App\Models\ClientWorking::where('installment_clients_id', $data['Installment_Client']->id)->first();
                                                    $bank = $ClientWorking ? App\Models\Bank::find($ClientWorking->bank_id) : null;
                                                    @endphp
                             
                                                <td> {{ $bank->name_ar ?? $data['Installment_Client']->bank->name_ar ?? 'لايوجد' }}</td>
                                           
                                        </tr>
                                        <tr>
                                            <th>كويت فايندر</th>
                                            <td>{{$Installment->client->kwfinder}}</td>
                                        </tr>

                                        <tr>
                                            <th>جهة العمل (1)</th>
                                            <td>
                                                 @if(empty($data['ministries']))
                                                    @foreach ($data['ministries'] as $ministry)
                                                        {{ $ministry->name_ar }}<br>
                                                    @endforeach
                                                @else
                                                   {{ $Installment->installment_client?->ministry_working?->name_ar ?? '' }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>رقم الحساب (1)</th>
                                            @if($Installment->client && $Installment->client->ipan)
                                            <td>{{$Installment->client->ipan}}</td>
                                            @elseif($data['client_banks'])
                                            <td>{{$data['client_banks']->bank_account_number}}</td>
                                            @else
                                            <td>لا يوجد</td>
                                            @endif

                                        </tr>
                                        <tr>
                                            <th>العنوان</th>
                                            <td>
                                                المنطقة {{$data['regions']->name_ar ?? ''}}}
                                                القطعة :- {{$Client->client_address->first()->block}}
                                                شارع :- {{$Client->client_address->first()->street}}
                                                مبنى :- {{$Client->client_address->first()->building}}</td>

                                        </tr>
                                        <tr>
                                            <th>الراتب</th>
                                            <td>{{$Client->salary ?? 'لا يوجد'}}</td>
                                        </tr>
                                        <tr>
                                            <th>بنك الاستقطاع</th>
                                            <td>
                                                <button id="btnGroupDrop1" type="button"
                                                    class="btn bg-primary-subtle text-primary  dropdown-toggle"
                                                    data-bs-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    طباعة
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1"
                                                    style="text-align: right;">
                                                    <a class="dropdown-item"
                                                        href="{{route('installment/edit_images',array('id' => $Installment->id))}}">تعديل</a>
                                                    <a class="dropdown-item"
                                                        href="{{ route('installment.madionia_certificate',$Installment->id) }}">شهادة
                                                        المديونية</a>
                                                    <a class="dropdown-item"
                                                        href="{{url('installment/recive_install_paper/'.$Installment->id)}}">إيصال
                                                        إستلام الأوراق</a>
                                                    <a class="dropdown-item"
                                                        href="{{url('installment/show_upload_papers/'.$Installment->id)}}">طباعة
                                                        العقود</a>
                                                    <a class="dropdown-item"
                                                        href="{{url('installment/print_install_paper_info/'.$Installment->id)}}">طباعة
                                                        النموذج الورقي</a>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <div class="accordion accordion-flush" id="accordionFlushExampleNotes">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                            <i class="ti ti-message-2 fs-6 d-block mx-1" style="color: blueviolet;"></i> الملاحظات <span
                                class="text-gray mx-1">( قم بالضغط هنا لاظهار الملاحظات)</span>
                        </button>
                    </h2>
                    <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo"
                        data-bs-parent="#accordionFlushExampleNotes">
                        <div class="accordion-body">


                            <ul class="nav nav-pills" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active bg-info-subtle text-info px-4 fs-4 mx-1 mb-2"
                                        data-bs-toggle="tab" href="#navpill-1" role="tab">
                                        <span> كل الملاحظات </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link bg-warning-subtle text-warning px-4 fs-4 mx-1 mb-2"
                                        data-bs-toggle="tab" href="#navpill-2" role="tab">
                                        <span> ملاحظات التقديم </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link bg-success-subtle text-success px-4 fs-4 mx-1 mb-2"
                                        data-bs-toggle="tab" href="#navpill-3" role="tab">
                                        <span>ملاحظات اقبول </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link bg-danger-subtle text-danger px-4 fs-4 mx-1 mb-2"
                                        data-bs-toggle="tab" href="#navpill-4" role="tab">
                                        <span> SMS </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link bg-primary-subtle text-primary px-4 fs-4 mx-1 mb-2"
                                        data-bs-toggle="tab" href="#navpill-5" role="tab">
                                        <span>السيارات </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link bg-warning-subtle text-warning px-4 fs-4 mx-1 mb-2"
                                        data-bs-toggle="tab" href="#navpill-6" role="tab">
                                        <span>القضايا </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link bg-info-subtle text-info px-4 fs-4 mx-1 mb-2"
                                        data-bs-toggle="tab" href="#navpill-7" role="tab">
                                        <span> قضايا التنفيذ </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link bg-warning-subtle text-warning px-4 fs-4 mx-1 mb-2"
                                        data-bs-toggle="tab" href="#navpill-8" role="tab">
                                        <span> التدقيق </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link bg-success-subtle text-success px-4 fs-4 mx-1 mb-2"
                                        data-bs-toggle="tab" href="#navpill-9" role="tab">
                                        <span> الشئون القانونية </span>
                                    </a>
                                </li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content border mt-2">
                                <div class="tab-pane active p-3" id="navpill-1" role="tabpanel">
                                    <div class="table-responsive pb-4">
                                        <table id="all-student"
                                            class="table table-bordered border text-nowrap align-middle">
                                            <thead>
                                                <!-- start row -->
                                                <tr>
                                                    <th> اليوزر</th>
                                                    <th>الاتصال</th>
                                                    <th> الساعة</th>
                                                    <th>التاريخ</th>
                                                    <th> الملاحظة</th>

                                                </tr>
                                                <!-- end row -->
                                            </thead>
                                            <tbody>
                                                <!-- start row -->
                                                {{-- $data['InstallmentClientNote'] --}}
                                                @if(isset($data['InstallmentClientNote']))
                                                @foreach( $data['InstallmentClientNote'] as $item)
                                                <tr>
                                                    <td>
                                                        {{$item->user->name_ar ?? 'لا يوجد'}}
                                                    </td>
                                                    <td>{{$item->rely}} </td>
                                                    <td>{{$item->time}}</td>
                                                    <td>{{$item->date}}</td>
                                                    <td>{{$item->note}}</td>

                                                </tr>
                                                @endforeach
                                                @endif
                                                @foreach( $data['InstallmentNote'] as $item)
                                                <tr>
                                                    <td>
                                                        {{$item->user->name_ar ?? 'لا يوجد'}}
                                                    </td>
                                                    <td>{{$item->connect}} </td>
                                                    <td>{{$item->time}}</td>
                                                    <td>{{$item->date}}</td>
                                                    <td>{{$item->note}}</td>

                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane p-3" id="navpill-2" role="tabpanel">
                                    <div class="table-responsive pb-4">
                                        <table id="all-student"
                                            class="table table-bordered border text-nowrap align-middle">
                                            <thead>
                                                <!-- start row -->
                                                <tr>
                                                    <th> اليوزر</th>
                                                    <th>الاتصال</th>
                                                    <th> الساعة</th>
                                                    <th>التاريخ</th>
                                                    <th> الملاحظة</th>

                                                </tr>
                                                <!-- end row -->
                                            </thead>
                                            <tbody>
                                                <!-- start row -->
                                                @if(isset($data['InstallmentClientNote']))
                                                @foreach( $data['InstallmentClientNote'] as $item)
                                                <tr>
                                                    <td>
                                                        {{$item->user->name_ar ?? 'لا يوجد'}}
                                                    </td>

                                                    <td>{{$item->rely}} </td>
                                                    <td>{{$item->time}}</td>
                                                    <td>{{$item->date}}</td>
                                                    <td>{{$item->note}}</td>

                                                </tr>
                                                @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane p-3" id="navpill-3" role="tabpanel">
                                    <div class="table-responsive pb-4">
                                        <table id="all-student"
                                            class="table table-bordered border text-nowrap align-middle">
                                            <thead>
                                                <!-- start row -->
                                                <tr>
                                                    <th> اليوزر</th>
                                                    <th>الاتصال</th>
                                                    <th> الساعة</th>
                                                    <th>التاريخ</th>
                                                    <th> الملاحظة</th>

                                                </tr>
                                                <!-- end row -->
                                            </thead>
                                            <tbody>
                                                <!-- start row -->
                                                @foreach( $data['InstallmentNote'] as $item)
                                                <tr>
                                                    <td>
                                                        {{$item->user->name_ar ?? 'لا يوجد'}}
                                                    </td>
                                                    <td>{{$item->connect}} </td>
                                                    <td>{{$item->time}}</td>
                                                    <td>{{$item->date}}</td>
                                                    <td>{{$item->note}}</td>

                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane p-3" id="navpill-4" role="tabpanel">
                                    <div class="table-responsive pb-4">
                                        <table id="all-student"
                                            class="table table-bordered border text-nowrap align-middle">
                                            <thead>
                                                <!-- start row -->
                                                <tr>
                                                    <th> اليوزر</th>
                                                    <th>الاتصال</th>
                                                    <th> الساعة</th>
                                                    <th>التاريخ</th>
                                                    <th> الملاحظة</th>

                                                </tr>
                                                <!-- end row -->
                                            </thead>
                                            <tbody>
                                                <!-- start row -->
                                                @foreach( $data['InstallmentNote'] as $item)
                                                <tr>
                                                    <td>
                                                        {{$item->user->name_ar ?? 'لا يوجد'}}
                                                    </td>
                                                    <td>{{$item->connect}} </td>
                                                    <td>{{$item->time}}</td>
                                                    <td>{{$item->date}}</td>
                                                    <td>{{$item->note}}</td>

                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane p-3" id="navpill-5" role="tabpanel">
                                    <div class="table-responsive pb-4">
                                        <table id="all-student"
                                            class="table table-bordered border text-nowrap align-middle">
                                            <thead>
                                                <!-- start row -->
                                                <tr>
                                                    <th> اليوزر</th>
                                                    <th>النوع</th>
                                                    <th> السنة</th>
                                                    <th>متوسط السعر</th>


                                                </tr>
                                                <!-- end row -->
                                            </thead>
                                            <tbody>
                                                <!-- start row -->
                                                @if(isset($data['Installmentcar']))
                                                @foreach( $data['Installmentcar'] as $item)
                                                <tr>
                                                    <td>
                                                        {{$item->user->name_ar ?? 'لا يوجد'}}
                                                    </td>
                                                    <td>{{$item->type_car}} </td>
                                                    <td>{{$item->model_year}}</td>
                                                    <td>{{$item->average_price}}</td>
                                                    <td>{{$item->note}}</td>

                                                </tr>
                                                @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane p-3" id="navpill-6" role="tabpanel">
                                    <div class="table-responsive pb-4">
                                        <table id="all-student"
                                            class="table table-bordered border text-nowrap align-middle">
                                            <thead>
                                                <!-- start row -->
                                                <tr>
                                                    <th> اليوزر</th>
                                                    <th> رقم القضايا</th>
                                                    <th>الحالة</th>
                                                    <th> المبلغ</th>
                                                    <th> الجهة</th>
                                                    <th>التاريخ</th>


                                                </tr>
                                                <!-- end row -->
                                            </thead>
                                            <tbody>
                                                <!-- start row -->

                                                @if(isset($data['Installmentissue']))
                                                @foreach( $data['Installmentissue'] as $item)
                                                <tr>
                                                    <td>
                                                        {{$item->user->name_ar ?? 'لا يوجد'}}
                                                    </td>
                                                    <td>
                                                        {{$item->number_issue ?? 'لا يوجد'}}
                                                    </td>
                                                    <td>{{$item->status == "open" ? 'مفتوح' : 'مغلق'}} </td>
                                                    <td>{{$item->status == "open" ? $item->opening_amount : $item->closing_amount }}
                                                    </td>
                                                    <td>{{$item->working_company}}</td>
                                                    <td>{{$item->date}}</td>


                                                </tr>
                                                @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane p-3" id="navpill-7" role="tabpanel">
                                    <div class="table-responsive pb-4">
                                        <table id="all-student"
                                            class="table table-bordered border text-nowrap align-middle">
                                            <thead>
                                                <!-- start row -->
                                                <tr>
                                                    <th> اليوزر</th>
                                                    <th>الاتصال</th>
                                                    <th> الساعة</th>
                                                    <th>التاريخ</th>
                                                    <th> الملاحظة</th>

                                                </tr>
                                                <!-- end row -->
                                            </thead>
                                            <tbody>
                                                <!-- start row -->
                                                @foreach( $data['InstallmentNote'] as $item)
                                                <tr>
                                                    <td>
                                                        {{$item->user->name_ar ?? 'لا يوجد'}}
                                                    </td>
                                                    <td>{{$item->connect}} </td>
                                                    <td>{{$item->time}}</td>
                                                    <td>{{$item->date}}</td>
                                                    <td>{{$item->note}}</td>

                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane p-3" id="navpill-8" role="tabpanel">
                                    <div class="table-responsive pb-4">
                                        <table id="all-student"
                                            class="table table-bordered border text-nowrap align-middle">
                                            <thead>
                                                <!-- start row -->
                                                <tr>
                                                    <th> اليوزر</th>
                                                    <th>الاتصال</th>
                                                    <th> الساعة</th>
                                                    <th>التاريخ</th>
                                                    <th> الملاحظة</th>

                                                </tr>
                                                <!-- end row -->
                                            </thead>
                                            <tbody>
                                                <!-- start row -->
                                                @foreach( $data['InstallmentNote'] as $item)
                                                <tr>
                                                    <td>
                                                        {{$item->user->name_ar ?? 'لا يوجد'}}
                                                    </td>
                                                    <td>{{$item->connect}} </td>
                                                    <td>{{$item->time}}</td>
                                                    <td>{{$item->date}}</td>
                                                    <td>{{$item->note}}</td>

                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane p-3" id="navpill-9" role="tabpanel">
                                    <ul class="nav nav-pills" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active bg-warning-subtle text-warning px-4 fs-4 mx-1 mb-2"
                                                data-bs-toggle="tab" href="#navpill-inside-1" role="tab">
                                                <span>الكل</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link bg-info-subtle text-info px-4 fs-4 mx-1 mb-2"
                                                data-bs-toggle="tab" href="#navpill-inside-2" role="tab">
                                                <span> فتح ملف </span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link bg-success-subtle text-success px-4 fs-4 mx-1 mb-2"
                                                data-bs-toggle="tab" href="#navpill-inside-3" role="tab">
                                                <span>اعلان التنفيذ </span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link bg-danger-subtle text-danger px-4 fs-4 mx-1 mb-2"
                                                data-bs-toggle="tab" href="#navpill-inside-4" role="tab">
                                                <span> الامج </span>
                                            </a>
                                        </li>
                                    </ul>
                                    <!-- Tab panes -->
                                    <div class="tab-content border mt-2">
                                        <div class="tab-pane active p-3" id="navpill-inside-1" role="tabpanel">
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

                                                    <tr data-bs-toggle="collapse" data-bs-target="#collapseExample"
                                                        aria-expanded="false" aria-controls="collapseExample">
                                                        <td>
                                                            تقى
                                                        </td>
                                                        <td>
                                                            ملاحظة
                                                        </td>
                                                        <td>
                                                            <p>
                                                                تم مراجعة قسم الاعلان للوقوف على سبب تاخر الامج وتيبن
                                                                تاخير
                                                                المندوب فى تسليم الملف للامج وتم عمل
                                                                اللازم وادخال الملف امج وسيتم عمل الحسبه ومتابعة باقى
                                                                الاجراءات
                                                            </p>
                                                        </td>
                                                        <td>12:00 <span class="d-block">مساءا</span></td>
                                                        <td>29/10/2024</td>

                                                    </tr>
                                                    @foreach( $data['InstallmentNote'] as $item)
                                                    <tr>
                                                        <td>
                                                            {{$item->user->name_ar ?? 'لا يوجد'}}
                                                        </td>
                                                        <td>{{$item->type}} </td>
                                                        <td>{{$item->note}}</td>
                                                        <td>{{ \Carbon\Carbon::parse($item->date)->format('h:i A') }}
                                                        </td>
                                                        <td>{{ \Carbon\Carbon::parse($item->date)->format('d/m/Y') }}
                                                        </td>


                                                    </tr>
                                                    @endforeach

                                                </tbody>
                                            </table>

                                        </div>
                                        <div class="tab-pane p-3" id="navpill-inside-2" role="tabpanel">
                                            <table id="notes2"
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
                                                    <tr data-bs-toggle="collapse" data-bs-target="#collapseExample"
                                                        aria-expanded="false" aria-controls="collapseExample">
                                                        <td>
                                                            تقى
                                                        </td>
                                                        <td>
                                                            ملاحظة
                                                        </td>
                                                        <td>
                                                            <p>
                                                                تم مراجعة قسم الاعلان للوقوف على سبب تاخر الامج وتيبن
                                                                تاخير
                                                                المندوب فى تسليم الملف للامج وتم عمل
                                                                اللازم وادخال الملف امج وسيتم عمل الحسبه ومتابعة باقى
                                                                الاجراءات
                                                            </p>
                                                        </td>
                                                        <td>12:00 <span class="d-block">مساءا</span></td>
                                                        <td>29/10/2024</td>

                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="tab-pane p-3" id="navpill-inside-3" role="tabpanel">
                                            <table id="notes3"
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
                                                    <tr data-bs-toggle="collapse" data-bs-target="#collapseExample"
                                                        aria-expanded="false" aria-controls="collapseExample">
                                                        <td>

                                                        </td>
                                                        <td>
                                                            ملاحظة
                                                        </td>
                                                        <td>
                                                            <p>
                                                                تم مراجعة قسم الاعلان للوقوف على سبب تاخر الامج وتيبن
                                                                تاخير
                                                                المندوب فى تسليم الملف للامج وتم عمل
                                                                اللازم وادخال الملف امج وسيتم عمل الحسبه ومتابعة باقى
                                                                الاجراءات
                                                            </p>
                                                        </td>
                                                        <td>12:00 <span class="d-block">مساءا</span></td>
                                                        <td>29/10/2024</td>

                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="tab-pane p-3" id="navpill-inside-4" role="tabpanel">
                                            <table id="notes3"
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
                                                    <tr data-bs-toggle="collapse" data-bs-target="#collapseExample"
                                                        aria-expanded="false" aria-controls="collapseExample">
                                                        <td>

                                                        </td>
                                                        <td>
                                                            ملاحظة
                                                        </td>
                                                        <td>
                                                            <p>
                                                                تم مراجعة قسم الاعلان للوقوف على سبب تاخر الامج وتيبن
                                                                تاخير
                                                                المندوب فى تسليم الملف للامج وتم عمل
                                                                اللازم وادخال الملف امج وسيتم عمل الحسبه ومتابعة باقى
                                                                الاجراءات
                                                            </p>
                                                        </td>
                                                        <td>12:00 <span class="d-block">مساءا</span></td>
                                                        <td>29/10/2024</td>

                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@if ($Installment->laws == 1)
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <div class="accordion accordion-flush" id="accordionFlushExampleTransaction">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseThree" aria-expanded="false"
                            aria-controls="flush-collapseThree">
                            <i class="ti ti-ad-2 fs-6 mx-1" style="color: rgb(245, 105, 18);"></i> تتبع المعاملة
                            <span class="text-gray mx-1">( قم بالضغط هنا لاظهار تتبع المعاملة)</span>
                        </button>
                    </h2>
                    <div id="flush-collapseThree" class="accordion-collapse collapse"
                        aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExampleTransaction">
                        <div class="accordion-body">
                            <div class="table-responsive pb-4">
                                <table id="all-student" class="table table-bordered border text-nowrap align-middle">
                                    <thead>
                                        <!-- start row -->
                                        <tr>
                                            <th> القسم</th>
                                            <th>المسؤل</th>
                                            <th> تاريخ البدأ</th>
                                            <th>تاريخ الانتهاء</th>
                                            <th> عدد الايام</th>
                                        </tr>
                                        <!-- end row -->
                                    </thead>
                                    <tbody>
                                        <!-- start row -->
                                        @if (count($data['get_all_delegations']) > 0 )
                                        @foreach( $data['get_all_delegations'] as $value)
                                        <tr>
                                            @php

                                            $created_by = DB::table('users')
                                            ->where('id', $value->emp_id)
                                            ->first();


                                            @endphp
                                            <td> {{ $value['execute_date'] ? 'اعلان التنفيذ' : (
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
                </div>
            </div>
        </div>
    </div>
</div>
@endif


<!--<div class="card">-->
<!--    <div class="card-body">-->
<!--        <div class="table-responsive">-->
<!--            <div class="accordion accordion-flush" id="accordionFlushExampleItems">-->
<!--                <div class="accordion-item">-->
<!--                    <h2 class="accordion-header" id="flush-headingFour">-->
<!--                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"-->
<!--                            data-bs-target="#flush-collapseFour" aria-expanded="false"-->
<!--                            aria-controls="flush-collapseFour">-->
<!--                            <i class="ti ti-sort-descending-2 fs-6 mx-1" style="color: rgb(245, 18, 18);"></i> عدد-->
<!--                            الاصناف <span class="text-gray mx-1">( قم بالضغط هنا لاظهار عدد الاصناف)</span>-->
<!--                        </button>-->
<!--                    </h2>-->
<!--                    <div id="flush-collapseFour" class="accordion-collapse collapse" aria-labelledby="flush-headingFour"-->
<!--                        data-bs-parent="#accordionFlushExampleItems">-->
<!--                        <div class="accordion-body">-->
<!--                            <div class="table-responsive pb-4">-->
<!--                                <table id="all-student" class="table table-bordered border text-nowrap align-middle">-->
<!--                                    <thead>-->
<!-- start row -->

<!--                                        <tr>-->
<!--                                            <th> الماركة </th>-->
<!--                                            <th>الصنف </th>-->
<!--                                            <th> الموديل </th>-->
<!--                                            <th>سعر البيع </th>-->
<!--                                            <th> سعر المعروض</th>-->
<!--                                            <th> سعر تكلفة الوحدة</th>-->
<!--                                            <th> العدد </th>-->
<!--                                            <th> اجمالي التكلفة </th>-->
<!--                                        </tr>-->
<!-- end row -->
<!--                                    </thead>-->
<!--                                    <tbody>-->
<!-- start row -->
<!--                                        @foreach( $purchase_orders_items as $item)-->

<!--                                        <tr>-->
<!--                                            <td>-->
<!--                                                {{$item->product->mark->name_ar}}-->
<!--                                            </td>-->
<!--                                            <td>{{$item->product->class->name_ar}} </td>-->
<!--                                            <td>{{$item->product->model}}</td>-->
<!--                                            <td>{{$item->product->price}}</td>-->
<!--                                            <td>{{$item->product->price}}</td>-->
<!--                                            <td>{{$item->product->net_price}}</td>-->
<!--                                            <td>{{$item->count}}</td>-->
<!--                                            <td>{{$item->count * $item->product->price}}</td>-->
<!--                                        </tr>-->
<!--                                        @endforeach-->

<!--                                    </tbody>-->
<!--                                </table>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <div class="accordion accordion-flush" id="accordionFlushExampleItems">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingFour">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseFour" aria-expanded="false"
                            aria-controls="flush-collapseFour">
                            <i class="ti ti-sort-descending-2 fs-6 mx-1" style="color: rgb(245, 18, 18);"></i> عدد
                            الاصناف <span class="text-gray mx-1">( قم بالضغط هنا لاظهار عدد الاصناف)</span>
                        </button>
                    </h2>
                    <div id="flush-collapseFour" class="accordion-collapse collapse" aria-labelledby="flush-headingFour"
                        data-bs-parent="#accordionFlushExampleItems">
                        <div class="accordion-body">
                            <div class="table-responsive pb-4">
                                <table id="all-student" class="table table-bordered border text-nowrap align-middle">
                                    <thead>
                                        <!-- start row -->

                                        <tr>
                                            <th> الماركة</th>
                                            <th>الصنف</th>
                                            <th> الموديل</th>
                                            <th>سعر البيع</th>
                                            <th> سعر المعروض</th>
                                            <th> سعر تكلفة الوحدة</th>
                                            <th> العدد</th>
                                            <th> اجمالي التكلفة</th>
                                        </tr>
                                        <!-- end row -->
                                    </thead>
                                    <tbody>

                                        <!-- start row -->
                                        @foreach( $purchase_orders_array as $item)

                                        <tr>
                                            <td>
                                                {{ $item['product_order']->first()?->mark->name_ar ?? '' }}
                                            </td>
                                            <td>{{$item['product_order']->first()?->class->name_ar}} </td>
                                            <td>{{$item['product_order']->first()?->model}}</td>
                                            <td>{{$item['product_order']->first()?->price}}</td>
                                            <td>{{floatval($item['product_order']->first()?->cost)+(floatval($item['product_order']->first()?->cost)*35/100)}}
                                            </td>
                                            <td>{{$item['product_order']->first()?->net_price}}</td>
                                            <td>{{ $item['counter'] }}</td>
                                            @if (($item['counter'] != "") || ($item['counter']!= null) )
                                            <td>{{floatval($item['product_order']->first()?->net_price)* floatval($item['counter'])}}
                                            </td>
                                            @else
                                            <td>{{floatval($item['product_order']->first()?->net_price)}}</td>
                                            @endif

                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- <div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <div class="accordion accordion-flush" id="accordionFlushExampleFiles">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingFive">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseFive" aria-expanded="false"
                            aria-controls="flush-collapseFive">
                            <i class="ti ti-bookmark fs-6 mx-1" style="color: rgb(245, 234, 18);"></i> الملفات المرفوعة
                            <span class="text-gray mx-1">( قم بالضغط هنا لاظهار الملفات المرفوعة)</span>
                        </button>
                    </h2>
                    <div id="flush-collapseFive" class="accordion-collapse collapse" aria-labelledby="flush-headingFive"
                        data-bs-parent="#accordionFlushExampleFiles">
                        <div class="accordion-body">
                            <div class="scroll-container">
                                @foreach($installment_months as $item)
                                <div class="item" data-file="{{ $item->img_dir }}">
<img src="{{ $item->img_dir }}" alt="{{ $item->notes ?? 'Image' }}">
</div>
@endforeach

</div>

<div class="modal" id="modal">
    <span class="close" id="close">&times;</span>
    <iframe id="modal-content" src="" frameborder="0"></iframe>
    <div class="modal-buttons d-flex ">
        <div>
            <button class="btn-primary mx-1 " id="print">طباعة</button>
        </div>
        <div>
            <button class="btn-primary mx-1" id="download" href="" download>تحميل</button>
        </div>
    </div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div> --}}

<!--<div class="card">-->
<!--    <div class="card-body">-->
<!--        <div class="table-responsive">-->
<!--            <div class="accordion accordion-flush" id="accordionFlushExampleFiles">-->
<!--                <div class="accordion-item">-->
<!--                    <h2 class="accordion-header" id="flush-headingFive">-->
<!--                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"-->
<!--                            data-bs-target="#flush-collapseFive" aria-expanded="false"-->
<!--                            aria-controls="flush-collapseFive">-->
<!--                            <i class="ti ti-bookmark fs-6 mx-1" style="color: rgb(245, 234, 18);"></i> الملفات المرفوعة-->
<!--                            <span class="text-gray mx-1">( قم بالضغط هنا لاظهار الملفات المرفوعة)</span>-->
<!--                        </button>-->
<!--                    </h2>-->
<!--                    <div id="flush-collapseFive" class="accordion-collapse collapse" aria-labelledby="flush-headingFive"-->
<!--                        data-bs-parent="#accordionFlushExampleFiles">-->
<!--                        <div class="accordion-body">-->
<!--                            <div class="scroll-container">-->
<!--{{-- @foreach($installment_months as $item)-->
<!--<div class="item" data-file="{{ $item->img_dir }}">-->
<!--    <img src="{{ $item->img_dir }}" alt="{{ $item->notes ?? 'Image' }}">-->
<!--</div>-->
<!--@endforeach --}}-->

<!--                                <div class="owl-carousel leadership-carousel owl-theme mt-lg-5 mb-lg-7">-->


<!--                                    @if ($Installment->contract_1 != Null)-->
<!--                                        <div class="item">-->
<!--                                            <div class="meet-our-team position-relative rounded-4 overflow-hidden">-->
<!--                                            <img src="{{ asset('assets/images/PDF_file_icon.png') }}" alt="PDF Thumbnail">-->
<!--                                            <div class="leadership-card z-1 bg-white rounded py-3 px-8 mx-6 my-6 w-90 text-center">-->
<!--                                                {{-- <button type="button" -->
<!--                                                 onclick="checkFileAndRedirect('https://electron-kw.net/{{ $Installment->contract_1 }}', 'https://electron-kw.com/test_vr/{{ $Installment->contract_1 }}');"-->
<!--                                                class="btn waves-effect waves-light bg-primary-subtle text-primary btn-sm">-->
<!--                                                تحميل-->
<!--                                                </button>-->
<!--                                                <button type="button" -->
<!--                                                 onclick="checkFileAndPRINT('https://electron-kw.net/{{ $Installment->contract_1 }}', 'https://electron-kw.com/test_vr/{{ $Installment->contract_1 }}');"-->
<!--                                                class="btn waves-effect waves-light bg-secondary-subtle text-secondary btn-sm">-->
<!--                                                طباعة-->
<!--                                                </button>-->
<!--                                                 --}}-->
<!--                                                 <p for="">العقد 1</p>-->
<!--                                                <a -->
<!--                                                     target="_blank"-->
<!--                                                    onclick="checkFileAndRedirect('https://electron-kw.net/{{$Installment->contract_1 }}', 'https://electron-kw.com/test_vr/{{$Installment->contract_1 }}'); return false;"-->
<!--                                                    class="btn waves-effect waves-light bg-primary-subtle text-primary btn-sm"-->
<!--                                                    title="Download the file from the primary or fallback server.">-->
<!--                                                    تحميل-->
<!--                                                </a>-->

<!--                                                <a -->
<!--                                                     target="_blank"-->
<!--                                                    onclick="checkFileAndPRINT('https://electron-kw.net/{{ $Installment->contract_1 }}', 'https://electron-kw.com/test_vr/{{ $Installment->contract_1}}'); return false;"-->
<!--                                                    class="btn waves-effect waves-light bg-secondary-subtle text-secondary btn-sm"-->
<!--                                                    title="Print the file from the primary or fallback server.">-->
<!--                                                    طباعة-->
<!--                                                </a>-->
<!--                                            </div>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    @endif-->
<!--                                    @if ($Installment->contract_2 != Null)-->
<!--                                    <div class="item">-->
<!--                                        <div class="meet-our-team position-relative rounded-4 overflow-hidden">-->
<!--                                        <img src="{{ asset('assets/images/PDF_file_icon.png') }}" alt="PDF Thumbnail">-->
<!--                                        <div class="leadership-card z-1 bg-white rounded py-3 px-8 mx-6 my-6 w-90 text-center">-->

<!--                                            {{-- <button type="button" -->
<!--                                                 onclick="checkFileAndRedirect('https://electron-kw.net/{{ $Installment->contract_2 }}', 'https://electron-kw.com/{{ $Installment->contract_2 }}');"-->
<!--                                                class="btn waves-effect waves-light bg-primary-subtle text-primary btn-sm">-->
<!--                                                تحميل-->
<!--                                                </button>-->
<!--                                                <button type="button" -->
<!--                                                 onclick="checkFileAndPRINT('https://electron-kw.net/{{ $Installment->contract_2 }}', 'https://electron-kw.com/{{ $Installment->contract_2 }}');"-->
<!--                                                class="btn waves-effect waves-light bg-secondary-subtle text-secondary btn-sm">-->
<!--                                                طباعة-->
<!--                                                </button> --}}-->
<!--                                                <p for="">العقد 2</p>-->
<!--                                                <a -->
<!--                                                     target="_blank"-->
<!--                                                    onclick="checkFileAndRedirect('https://electron-kw.net/{{$Installment->contract_2}}', 'https://electron-kw.com/test_vr/{{ $Installment->contract_2 }}'); return false;"-->
<!--                                                    class="btn waves-effect waves-light bg-primary-subtle text-primary btn-sm"-->
<!--                                                    title="Download the file from the primary or fallback server.">-->
<!--                                                    تحميل-->
<!--                                                </a>-->

<!--                                                <a -->
<!--                                                     target="_blank"-->
<!--                                                    onclick="checkFileAndPRINT('https://electron-kw.net/{{ $Installment->contract_2 }}', 'https://electron-kw.com/test_vr/{{ $Installment->contract_2 }}'); return false;"-->
<!--                                                    class="btn waves-effect waves-light bg-secondary-subtle text-secondary btn-sm"-->
<!--                                                    title="Print the file from the primary or fallback server.">-->
<!--                                                    طباعة-->
<!--                                                </a>-->
<!--                                        </div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                    @endif-->
<!--                                    @if ($Installment->contract_cinet_1 != Null)-->
<!--                                    <div class="item">-->
<!--                                        <div class="meet-our-team position-relative rounded-4 overflow-hidden">-->
<!--                                        <img src="{{ asset('assets/images/PDF_file_icon.png') }}" alt="PDF Thumbnail">-->
<!--                                        <div class="leadership-card z-1 bg-white rounded py-3 px-8 mx-6 my-6 w-90 text-center">-->
<!--                                            {{-- <button type="button" -->
<!--                                            onclick="checkFileAndRedirect('https://electron-kw.net/{{ $Installment->contract_cinet_1 }}', 'https://electron-kw.com/{{ $Installment->contract_1 }}');"-->
<!--                                           class="btn waves-effect waves-light bg-primary-subtle text-primary btn-sm">-->
<!--                                           تحميل-->
<!--                                           </button>-->
<!--                                           <button type="button" -->
<!--                                            onclick="checkFileAndPRINT('https://electron-kw.net/{{ $Installment->contract_cinet_1 }}', 'https://electron-kw.com/{{ $Installment->contract_1 }}');"-->
<!--                                           class="btn waves-effect waves-light bg-secondary-subtle text-secondary btn-sm">-->
<!--                                           طباعة-->
<!--                                           </button> --}}-->

<!--                                           <p for="">عقد الساينت 1</p>-->
<!--                                           <a -->
<!--                                                     target="_blank"-->
<!--                                                    onclick="checkFileAndRedirect('https://electron-kw.net/{{ $Installment->contract_cinet_1 }}', 'https://electron-kw.com/test_vr/{{ $Installment->contract_cinet_1 }}'); return false;"-->
<!--                                                    class="btn waves-effect waves-light bg-primary-subtle text-primary btn-sm"-->
<!--                                                    title="Download the file from the primary or fallback server.">-->
<!--                                                    تحميل-->
<!--                                                </a>-->

<!--                                                <a -->
<!--                                                     target="_blank"-->
<!--                                                    onclick="checkFileAndPRINT('https://electron-kw.net/{{ $Installment->contract_cinet_1 }}', 'https://electron-kw.com/test_vr/{{ $Installment->contract_cinet_1 }}'); return false;"-->
<!--                                                    class="btn waves-effect waves-light bg-secondary-subtle text-secondary btn-sm"-->
<!--                                                    title="Print the file from the primary or fallback server.">-->
<!--                                                    طباعة-->
<!--                                                </a>-->
<!--                                        </div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                    @endif-->
<!--                                    @if ($Installment->contract_cinet_2 != Null)-->
<!--                                    <div class="item">-->
<!--                                        <div class="meet-our-team position-relative rounded-4 overflow-hidden">-->
<!--                                        <img src="{{ asset('assets/images/PDF_file_icon.png') }}" alt="PDF Thumbnail">-->
<!--                                        <div class="leadership-card z-1 bg-white rounded py-3 px-8 mx-6 my-6 w-90 text-center">-->
<!--                                            {{-- <button type="button" -->
<!--                                            onclick="checkFileAndRedirect('https://electron-kw.net/{{ $Installment->contract_cinet_2 }}', 'https://electron-kw.com/test_vr/{{ $Installment->contract_1 }}');"-->
<!--                                           class="btn waves-effect waves-light bg-primary-subtle text-primary btn-sm">-->
<!--                                           تحميل-->
<!--                                           </button>-->
<!--                                           <button type="button" -->
<!--                                            onclick="checkFileAndPRINT('https://electron-kw.net/{{ $Installment->contract_cinet_2 }}', 'https://electron-kw.com/test_vr/{{ $Installment->contract_1 }}');"-->
<!--                                           class="btn waves-effect waves-light bg-secondary-subtle text-secondary btn-sm">-->
<!--                                           طباعة-->
<!--                                           </button> --}}-->
<!--                                           <p for="">عقد الساينت 2</p>-->
<!--                                           <a -->
<!--                                                     target="_blank"-->
<!--                                                    onclick="checkFileAndRedirect('https://electron-kw.net/{{ $Installment->contract_cinet_2  }}', 'https://electron-kw.com/test_vr/{{ $Installment->contract_cinet_2  }}'); return false;"-->
<!--                                                    class="btn waves-effect waves-light bg-primary-subtle text-primary btn-sm"-->
<!--                                                    title="Download the file from the primary or fallback server.">-->
<!--                                                    تحميل-->
<!--                                                </a>-->

<!--                                                <a -->
<!--                                                     target="_blank"-->
<!--                                                    onclick="checkFileAndPRINT('https://electron-kw.net/{{ $Installment->contract_cinet_2  }}', 'https://electron-kw.com/test_vr/{{ $Installment->contract_cinet_2  }}'); return false;"-->
<!--                                                    class="btn waves-effect waves-light bg-secondary-subtle text-secondary btn-sm"-->
<!--                                                    title="Print the file from the primary or fallback server.">-->
<!--                                                    طباعة-->
<!--                                                </a>-->
<!--                                        </div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                    @endif-->
<!--                                    @if ($Installment->prods_recieved_img != Null)-->
<!--                                    <div class="item">-->
<!--                                        <div class="meet-our-team position-relative rounded-4 overflow-hidden">-->
<!--                                        <img src="{{ asset('assets/images/PDF_file_icon.png') }}" alt="PDF Thumbnail">-->
<!--                                        <div class="leadership-card z-1 bg-white rounded py-3 px-8 mx-6 my-6 w-90 text-center">-->

<!--                                            {{-- <button type="button" -->
<!--                                                 onclick="checkFileAndRedirect('https://electron-kw.net/{{ $Installment->prods_recieved_img }}', 'https://electron-kw.com/{{ $Installment->contract_1 }}');"-->
<!--                                                class="btn waves-effect waves-light bg-primary-subtle text-primary btn-sm">-->
<!--                                                تحميل-->
<!--                                                </button>-->
<!--                                                <button type="button" -->
<!--                                                 onclick="checkFileAndPRINT('https://electron-kw.net/{{ $Installment->prods_recieved_img }}', 'https://electron-kw.com/{{ $Installment->contract_1 }}');"-->
<!--                                                class="btn waves-effect waves-light bg-secondary-subtle text-secondary btn-sm">-->
<!--                                                طباعة-->
<!--                                                </button> --}}-->
<!--                                                <p for="">صورة استسلام المنتجات</p>-->
<!--                                                <a -->
<!--                                                     target="_blank"-->
<!--                                                    onclick="checkFileAndRedirect('https://electron-kw.net/{{ $Installment->prods_recieved_img   }}', 'https://electron-kw.com/test_vr/{{ $Installment->prods_recieved_img   }}'); return false;"-->
<!--                                                    class="btn waves-effect waves-light bg-primary-subtle text-primary btn-sm"-->
<!--                                                    title="Download the file from the primary or fallback server.">-->
<!--                                                    تحميل-->
<!--                                                </a>-->

<!--                                                <a -->
<!--                                                     target="_blank"-->
<!--                                                    onclick="checkFileAndPRINT('https://electron-kw.net/{{ $Installment->prods_recieved_img   }}', 'https://electron-kw.com/test_vr/{{ $Installment->prods_recieved_img   }}'); return false;"-->
<!--                                                    class="btn waves-effect waves-light bg-secondary-subtle text-secondary btn-sm"-->
<!--                                                    title="Print the file from the primary or fallback server.">-->
<!--                                                    طباعة-->
<!--                                                </a>-->
<!--                                        </div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                    @endif-->
<!--                                    {{-- client --}}-->

<!--                                    @foreach ($data['Client']->client_image as $img_Client)-->

<!--                                    @if ($img_Client->type == "my_img")-->
<!--                                    <div class="item">-->
<!--                                        <div class="meet-our-team position-relative rounded-4 overflow-hidden">-->
<!--                                        <img src="{{ asset('assets/images/PDF_file_icon.png') }}" alt="PDF Thumbnail">-->
<!--                                        <div class="leadership-card z-1 bg-white rounded py-3 px-8 mx-6 my-6 w-90 text-center">-->
<!--                                            {{-- <a -->
<!--                                                id="downloadLink"-->
<!--                                                href="https://electron-kw.net/{{ $img_Client->path }}" -->
<!--                                                onclick="handleRedirect(event, 'https://electron-kw.net/{{ $img_Client->path }}', 'https://electron-kw.com/{{ $img_Client->path }}');"-->
<!--                                                class="btn waves-effect waves-light bg-primary-subtle text-primary btn-sm"-->
<!--                                                title="Download the file from the primary or fallback server.">-->
<!--                                                تحميل-->
<!--                                            </a>-->

<!--                                            <a -->
<!--                                                id="printLink"-->
<!--                                                href="https://electron-kw.net/{{ $img_Client->path }}" -->
<!--                                                onclick="handlePrint(event, 'https://electron-kw.net/{{ $img_Client->path }}', 'https://electron-kw.com/{{ $img_Client->path }}');"-->
<!--                                                class="btn waves-effect waves-light bg-secondary-subtle text-secondary btn-sm"-->
<!--                                                title="Print the file from the primary or fallback server.">-->
<!--                                                طباعة-->
<!--                                            </a> --}}-->

<!--                                            <p for="">هويتى</p>-->
<!--                                            {{-- <br> --}}-->
<!--                                                <a -->
<!--                                                    target="_blank"-->
<!--                                                    onclick="checkFileAndRedirect('https://electron-kw.net/{{ $img_Client->path   }}', 'https://electron-kw.com/test_vr/{{$img_Client->path   }}'); return false;"-->
<!--                                                    class="btn waves-effect waves-light bg-primary-subtle text-primary btn-sm"-->
<!--                                                    title="Download the file from the primary or fallback server.">-->
<!--                                                    تحميل-->
<!--                                                </a>-->

<!--                                                <a -->
<!--                                                    target="_blank" -->
<!--                                                    onclick="checkFileAndPRINT('https://electron-kw.net/{{ $img_Client->path   }}', 'https://electron-kw.com/test_vr/{{ $img_Client->path   }}'); return false;"-->
<!--                                                    class="btn waves-effect waves-light bg-secondary-subtle text-secondary btn-sm"-->
<!--                                                    title="Print the file from the primary or fallback server.">-->
<!--                                                    طباعة-->
<!--                                                </a>-->


<!--                                        </div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                    @endif-->

<!--                                    @if ($img_Client->type == "work_img")-->
<!--                                    <div class="item">-->
<!--                                        <div class="meet-our-team position-relative rounded-4 overflow-hidden">-->
<!--                                        <img src="{{ asset('assets/images/PDF_file_icon.png') }}" alt="PDF Thumbnail">-->
<!--                                        <div class="leadership-card z-1 bg-white rounded py-3 px-8 mx-6 my-6 w-90 text-center">-->
<!--                                            {{-- <button type="button" -->
<!--                                                 onclick="checkFileAndRedirect('https://electron-kw.net/{{ $img_Client->path }}', 'https://electron-kw.com/{{ $img_Client->path }}');"-->
<!--                                                class="btn waves-effect waves-light bg-primary-subtle text-primary btn-sm">-->
<!--                                                تحميل-->
<!--                                                </button>-->
<!--                                                <button type="button" -->
<!--                                                 onclick="checkFileAndPRINT('https://electron-kw.net/{{ $img_Client->path }}', 'https://electron-kw.com/{{ $img_Client->path }}');"-->
<!--                                                class="btn waves-effect waves-light bg-secondary-subtle text-secondary btn-sm">-->
<!--                                                طباعة-->
<!--                                                </button> --}}-->

<!--                                                <p for="">صورة هوية العمل</p>-->
<!--                                                <a -->
<!--                                                     target="_blank"-->
<!--                                                    onclick="checkFileAndRedirect('https://electron-kw.net/{{ $img_Client->path   }}', 'https://electron-kw.com/test_vr/{{$img_Client->path   }}'); return false;"-->
<!--                                                    class="btn waves-effect waves-light bg-primary-subtle text-primary btn-sm"-->
<!--                                                    title="Download the file from the primary or fallback server.">-->
<!--                                                    تحميل-->
<!--                                                </a>-->

<!--                                                <a -->
<!--                                                     target="_blank" -->
<!--                                                    onclick="checkFileAndPRINT('https://electron-kw.net/{{ $img_Client->path   }}', 'https://electron-kw.com/test_vr/{{ $img_Client->path   }}'); return false;"-->
<!--                                                    class="btn waves-effect waves-light bg-secondary-subtle text-secondary btn-sm"-->
<!--                                                    title="Print the file from the primary or fallback server.">-->
<!--                                                    طباعة-->
<!--                                                </a>-->
<!--                                        </div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                    @endif-->

<!--                                    @if ($img_Client->type == "salary_img")-->
<!--                                    <div class="item">-->
<!--                                        <div class="meet-our-team position-relative rounded-4 overflow-hidden">-->
<!--                                        <img src="{{ asset('assets/images/PDF_file_icon.png') }}" alt="PDF Thumbnail">-->
<!--                                        <div class="leadership-card z-1 bg-white rounded py-3 px-8 mx-6 my-6 w-90 text-center">-->
<!--                                            {{-- <button type="button" -->
<!--                                                 onclick="checkFileAndRedirect('https://electron-kw.net/{{ $img_Client->path }}', 'https://electron-kw.com/{{ $img_Client->path }}');"-->
<!--                                                class="btn waves-effect waves-light bg-primary-subtle text-primary btn-sm">-->
<!--                                                تحميل-->
<!--                                                </button>-->
<!--                                                <button type="button" -->
<!--                                                 onclick="checkFileAndPRINT('https://electron-kw.net/{{ $img_Client->path }}', 'https://electron-kw.com/{{ $img_Client->path }}');"-->
<!--                                                class="btn waves-effect waves-light bg-secondary-subtle text-secondary btn-sm">-->
<!--                                                طباعة-->
<!--                                                </button> --}}-->

<!--                                                <p for="">شهادة الراتب  </p>-->
<!--                                                <a -->
<!--                                                     target="_blank"-->
<!--                                                    onclick="checkFileAndRedirect('https://electron-kw.net/{{ $img_Client->path   }}', 'https://electron-kw.com/test_vr/{{$img_Client->path   }}'); return false;"-->
<!--                                                    class="btn waves-effect waves-light bg-primary-subtle text-primary btn-sm"-->
<!--                                                    title="Download the file from the primary or fallback server.">-->
<!--                                                    تحميل-->
<!--                                                </a>-->

<!--                                                <a -->
<!--                                                     target="_blank"-->
<!--                                                    onclick="checkFileAndPRINT('https://electron-kw.net/{{ $img_Client->path   }}', 'https://electron-kw.com/test_vr/{{ $img_Client->path   }}'); return false;"-->
<!--                                                    class="btn waves-effect waves-light bg-secondary-subtle text-secondary btn-sm"-->
<!--                                                    title="Print the file from the primary or fallback server.">-->
<!--                                                    طباعة-->
<!--                                                </a>-->
<!--                                        </div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                    @endif-->
<!--                                    @if ($img_Client->type == "cid_img1")-->
<!--                                    <div class="item">-->
<!--                                        <div class="meet-our-team position-relative rounded-4 overflow-hidden">-->
<!--                                        <img src="{{ asset('assets/images/PDF_file_icon.png') }}" alt="PDF Thumbnail">-->
<!--                                        <div class="leadership-card z-1 bg-white rounded py-3 px-8 mx-6 my-6 w-90 text-center">-->
<!--                                            {{-- <button type="button" -->
<!--                                                 onclick="checkFileAndRedirect('https://electron-kw.net/{{ $img_Client->path }}', 'https://electron-kw.com/{{ $img_Client->path }}');"-->
<!--                                                class="btn waves-effect waves-light bg-primary-subtle text-primary btn-sm">-->
<!--                                                تحميل-->
<!--                                                </button>-->
<!--                                                <button type="button" -->
<!--                                                 onclick="checkFileAndPRINT('https://electron-kw.net/{{ $img_Client->path }}', 'https://electron-kw.com/{{ $img_Client->path }}');"-->
<!--                                                class="btn waves-effect waves-light bg-secondary-subtle text-secondary btn-sm">-->
<!--                                                طباعة-->
<!--                                                </button> --}}-->

<!--                                                <p for="">صورة  البطاقة المدنية وجه</p>-->
<!--                                                <a -->
<!--                                                     target="_blank"-->
<!--                                                    onclick="checkFileAndRedirect('https://electron-kw.net/{{ $img_Client->path   }}', 'https://electron-kw.com/test_vr/{{$img_Client->path   }}'); return false;"-->
<!--                                                    class="btn waves-effect waves-light bg-primary-subtle text-primary btn-sm"-->
<!--                                                    title="Download the file from the primary or fallback server.">-->
<!--                                                    تحميل-->
<!--                                                </a>-->

<!--                                                <a -->
<!--                                                     target="_blank"-->
<!--                                                    onclick="checkFileAndPRINT('https://electron-kw.net/{{ $img_Client->path   }}', 'https://electron-kw.com/test_vr/{{ $img_Client->path   }}'); return false;"-->
<!--                                                    class="btn waves-effect waves-light bg-secondary-subtle text-secondary btn-sm"-->
<!--                                                    title="Print the file from the primary or fallback server.">-->
<!--                                                    طباعة-->
<!--                                                </a>-->
<!--                                        </div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                    @endif-->

<!--                                    @if ($img_Client->type == "cid_img_2")-->
<!--                                    <div class="item">-->
<!--                                        <div class="meet-our-team position-relative rounded-4 overflow-hidden">-->
<!--                                        <img src="{{ asset('assets/images/PDF_file_icon.png') }}" alt="PDF Thumbnail">-->
<!--                                        <div class="leadership-card z-1 bg-white rounded py-3 px-8 mx-6 my-6 w-90 text-center">-->
<!--                                            {{-- <button type="button" -->
<!--                                                 onclick="checkFileAndRedirect('https://electron-kw.net/{{ $img_Client->path }}', 'https://electron-kw.com/{{ $img_Client->path }}');"-->
<!--                                                class="btn waves-effect waves-light bg-primary-subtle text-primary btn-sm">-->
<!--                                                تحميل-->
<!--                                                </button>-->
<!--                                                <button type="button" -->
<!--                                                 onclick="checkFileAndPRINT('https://electron-kw.net/{{ $img_Client->path }}', 'https://electron-kw.com/{{ $img_Client->path }}');"-->
<!--                                                class="btn waves-effect waves-light bg-secondary-subtle text-secondary btn-sm">-->
<!--                                                طباعة-->
<!--                                                </button> --}}-->

<!--                                                <p for=""> صورة البطاقة المدنية ضهر </p>-->
<!--                                                <a -->
<!--                                                     target="_blank"-->
<!--                                                    onclick="checkFileAndRedirect('https://electron-kw.net/{{ $img_Client->path   }}', 'https://electron-kw.com/test_vr/{{$img_Client->path   }}'); return false;"-->
<!--                                                    class="btn waves-effect waves-light bg-primary-subtle text-primary btn-sm"-->
<!--                                                    title="Download the file from the primary or fallback server.">-->
<!--                                                    تحميل-->
<!--                                                </a>-->

<!--                                                <a -->
<!--                                                     target="_blank"-->
<!--                                                    onclick="checkFileAndPRINT('https://electron-kw.net/{{ $img_Client->path   }}', 'https://electron-kw.com/test_vr/{{ $img_Client->path   }}'); return false;"-->
<!--                                                    class="btn waves-effect waves-light bg-secondary-subtle text-secondary btn-sm"-->
<!--                                                    title="Print the file from the primary or fallback server.">-->
<!--                                                    طباعة-->
<!--                                                </a>-->
<!--                                        </div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                    @endif-->

<!--                                    @if ($img_Client->type == "cinet_img")-->
<!--                                    <div class="item">-->
<!--                                        <div class="meet-our-team position-relative rounded-4 overflow-hidden">-->
<!--                                        <img src="{{ asset('assets/images/PDF_file_icon.png') }}" alt="PDF Thumbnail">-->
<!--                                        <div class="leadership-card z-1 bg-white rounded py-3 px-8 mx-6 my-6 w-90 text-center">-->
<!--                                            {{-- <button type="button" -->
<!--                                                 onclick="checkFileAndRedirect('https://electron-kw.net/{{ $img_Client->path }}', 'https://electron-kw.com/{{ $img_Client->path }}');"-->
<!--                                                class="btn waves-effect waves-light bg-primary-subtle text-primary btn-sm">-->
<!--                                                تحميل-->
<!--                                                </button>-->
<!--                                                <button type="button" -->
<!--                                                 onclick="checkFileAndPRINT('https://electron-kw.net/{{ $img_Client->path }}', 'https://electron-kw.com/{{ $img_Client->path }}');"-->
<!--                                                class="btn waves-effect waves-light bg-secondary-subtle text-secondary btn-sm">-->
<!--                                                طباعة-->
<!--                                                </button> --}}-->

<!--                                                <p for="">عقد الساينت</p>-->
<!--                                                <a -->
<!--                                                    target="_blank" -->
<!--                                                    onclick="checkFileAndRedirect('https://electron-kw.net/{{ $img_Client->path   }}', 'https://electron-kw.com/test_vr/{{$img_Client->path   }}'); return false;"-->
<!--                                                    class="btn waves-effect waves-light bg-primary-subtle text-primary btn-sm"-->
<!--                                                    title="Download the file from the primary or fallback server.">-->
<!--                                                    تحميل-->
<!--                                                </a>-->

<!--                                                <a -->
<!--                                                     target="_blank"-->
<!--                                                    onclick="checkFileAndPRINT('https://electron-kw.net/{{ $img_Client->path   }}', 'https://electron-kw.com/test_vr/{{ $img_Client->path   }}'); return false;"-->
<!--                                                    class="btn waves-effect waves-light bg-secondary-subtle text-secondary btn-sm"-->
<!--                                                    title="Print the file from the primary or fallback server.">-->
<!--                                                    طباعة-->
<!--                                                </a>-->
<!--                                        </div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                    @endif-->

<!--                                    @if ($img_Client->type == "civil_img")-->
<!--                                    <div class="item">-->
<!--                                        <div class="meet-our-team position-relative rounded-4 overflow-hidden">-->
<!--                                        <img src="{{ asset('assets/images/PDF_file_icon.png') }}" alt="PDF Thumbnail">-->
<!--                                        <div class="leadership-card z-1 bg-white rounded py-3 px-8 mx-6 my-6 w-90 text-center">-->
<!--                                            {{-- <button type="button" -->
<!--                                                 onclick="checkFileAndRedirect('https://electron-kw.net/{{ $img_Client->path }}', 'https://electron-kw.com/{{ $img_Client->path }}');"-->
<!--                                                class="btn waves-effect waves-light bg-primary-subtle text-primary btn-sm">-->
<!--                                                تحميل-->
<!--                                                </button>-->
<!--                                                <button type="button" -->
<!--                                                 onclick="checkFileAndPRINT('https://electron-kw.net/{{ $img_Client->path }}', 'https://electron-kw.com/{{ $img_Client->path }}');"-->
<!--                                                class="btn waves-effect waves-light bg-secondary-subtle text-secondary btn-sm">-->
<!--                                                طباعة-->
<!--                                                </button> --}}-->
<!--                                                <p for="">الرقم المدنى  </p>-->
<!--                                                <a -->

<!--                                                   target="_blank"-->
<!--                                                    onclick="checkFileAndRedirect('https://electron-kw.net/{{ $img_Client->path   }}', 'https://electron-kw.com/test_vr/{{$img_Client->path   }}'); return false;"-->
<!--                                                    class="btn waves-effect waves-light bg-primary-subtle text-primary btn-sm"-->
<!--                                                    title="Download the file from the primary or fallback server.">-->
<!--                                                    تحميل-->
<!--                                                </a>-->

<!--                                                <a -->
<!--                                                    target="_blank"-->
<!--                                                    onclick="checkFileAndPRINT('https://electron-kw.net/{{ $img_Client->path   }}', 'https://electron-kw.com/test_vr/{{ $img_Client->path   }}'); return false;"-->
<!--                                                    class="btn waves-effect waves-light bg-secondary-subtle text-secondary btn-sm"-->
<!--                                                    title="Print the file from the primary or fallback server.">-->
<!--                                                    طباعة-->
<!--                                                </a>-->
<!--                                        </div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                    @endif-->


<!--                                    @endforeach-->





<!--                                  </div>-->

<!--                            </div>-->


<!--                        </div>-->
<!--                    </div>-->


<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <div class="accordion accordion-flush" id="accordionFlushExampleFiles">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingFive">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseFive" aria-expanded="false"
                            aria-controls="flush-collapseFive">
                            <i class="ti ti-bookmark fs-6 mx-1" style="color: rgb(245, 234, 18);"></i> الملفات المرفوعة
                            <span class="text-gray mx-1">( قم بالضغط هنا لاظهار الملفات المرفوعة)</span>
                        </button>
                    </h2>
                    <div id="flush-collapseFive" class="accordion-collapse collapse" aria-labelledby="flush-headingFive"
                        data-bs-parent="#accordionFlushExampleFiles">
                        <div class="accordion-body">
                            <div class="scroll-container">
                                <!--{{-- @foreach($installment_months as $item)-->
                                <!--<div class="item" data-file="{{ $item->img_dir }}">-->
                                <!--    <img src="{{ $item->img_dir }}" alt="{{ $item->notes ?? 'Image' }}">-->
                                <!--</div>-->
                                <!--@endforeach --}}-->

                                <div class="owl-carousel leadership-carousel owl-theme mt-lg-5 mb-lg-7">


                                    @if ($Installment->contract_1 != Null)
                                    <div class="item">
                                        <div class="meet-our-team position-relative rounded-4 overflow-hidden">
                                            <img src="{{ asset('assets/images/PDF_file_icon.png') }}"
                                                alt="PDF Thumbnail">
                                            <div
                                                class="leadership-card z-1 bg-white rounded py-3 px-8 mx-6 my-6 w-90 text-center">
                                                {{-- <button type="button"
                                                     onclick="checkFileAndRedirect('https://electron-kw.net/{{ $Installment->contract_1 }}',
                                                'https://electron-kw.com/{{ $Installment->contract_1 }}');"
                                                class="btn waves-effect waves-light bg-primary-subtle text-primary
                                                btn-sm">
                                                تحميل
                                                </button>
                                                <button type="button"
                                                    onclick="checkFileAndPRINT('https://electron-kw.net/{{ $Installment->contract_1 }}', 'https://electron-kw.com/{{ $Installment->contract_1 }}');"
                                                    class="btn waves-effect waves-light bg-secondary-subtle text-secondary btn-sm">
                                                    طباعة
                                                </button>
                                                --}}
                                                <p for="">العقد 1</p>
                                                <a target="_blank"
                                                    onclick="checkFileAndRedirect('https://electron-kw.net/{{$Installment->contract_1 }}', 'https://electron-kw.com/{{$Installment->contract_1 }}'); return false;"
                                                    class="btn waves-effect waves-light bg-primary-subtle text-primary btn-sm"
                                                    title="Download the file from the primary or fallback server.">
                                                    تحميل
                                                </a>

                                                <a target="_blank"
                                                    onclick="checkFileAndPRINT('https://electron-kw.net/{{ $Installment->contract_1 }}', 'https://electron-kw.com/{{ $Installment->contract_1}}'); return false;"
                                                    class="btn waves-effect waves-light bg-secondary-subtle text-secondary btn-sm"
                                                    title="Print the file from the primary or fallback server.">
                                                    طباعة
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @if ($Installment->contract_2 != Null)
                                    <div class="item">
                                        <div class="meet-our-team position-relative rounded-4 overflow-hidden">
                                            <img src="{{ asset('assets/images/PDF_file_icon.png') }}"
                                                alt="PDF Thumbnail">
                                            <div
                                                class="leadership-card z-1 bg-white rounded py-3 px-8 mx-6 my-6 w-90 text-center">

                                                {{-- <button type="button"
                                                         onclick="checkFileAndRedirect('https://electron-kw.net/{{ $Installment->contract_2 }}',
                                                'https://electron-kw.com/{{ $Installment->contract_1 }}');"
                                                class="btn waves-effect waves-light bg-primary-subtle text-primary
                                                btn-sm">
                                                تحميل
                                                </button>
                                                <button type="button"
                                                    onclick="checkFileAndPRINT('https://electron-kw.net/{{ $Installment->contract_2 }}', 'https://electron-kw.com/{{ $Installment->contract_1 }}');"
                                                    class="btn waves-effect waves-light bg-secondary-subtle text-secondary btn-sm">
                                                    طباعة
                                                </button> --}}
                                                <p for="">العقد 2</p>
                                                <a target="_blank"
                                                    onclick="checkFileAndRedirect('https://electron-kw.net/{{$Installment->contract_2}}', 'https://electron-kw.com/{{ $Installment->contract_2 }}'); return false;"
                                                    class="btn waves-effect waves-light bg-primary-subtle text-primary btn-sm"
                                                    title="Download the file from the primary or fallback server.">
                                                    تحميل
                                                </a>

                                                <a target="_blank"
                                                    onclick="checkFileAndPRINT('https://electron-kw.net/{{ $Installment->contract_2 }}', 'https://electron-kw.com/{{ $Installment->contract_2 }}'); return false;"
                                                    class="btn waves-effect waves-light bg-secondary-subtle text-secondary btn-sm"
                                                    title="Print the file from the primary or fallback server.">
                                                    طباعة
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @if ($Installment->contract_cinet_1 != Null)
                                    <div class="item">
                                        <div class="meet-our-team position-relative rounded-4 overflow-hidden">
                                            <img src="{{ asset('assets/images/PDF_file_icon.png') }}"
                                                alt="PDF Thumbnail">
                                            <div
                                                class="leadership-card z-1 bg-white rounded py-3 px-8 mx-6 my-6 w-90 text-center">
                                                {{-- <button type="button"
                                                    onclick="checkFileAndRedirect('https://electron-kw.net/{{ $Installment->contract_cinet_1 }}',
                                                'https://electron-kw.com/{{ $Installment->contract_1 }}');"
                                                class="btn waves-effect waves-light bg-primary-subtle text-primary
                                                btn-sm">
                                                تحميل
                                                </button>
                                                <button type="button"
                                                    onclick="checkFileAndPRINT('https://electron-kw.net/{{ $Installment->contract_cinet_1 }}', 'https://electron-kw.com/{{ $Installment->contract_1 }}');"
                                                    class="btn waves-effect waves-light bg-secondary-subtle text-secondary btn-sm">
                                                    طباعة
                                                </button> --}}

                                                <p for="">عقد الساينت 1</p>
                                                <a target="_blank"
                                                    onclick="checkFileAndRedirect('https://electron-kw.net/{{ $Installment->contract_cinet_1 }}', 'https://electron-kw.com/{{ $Installment->contract_cinet_1 }}'); return false;"
                                                    class="btn waves-effect waves-light bg-primary-subtle text-primary btn-sm"
                                                    title="Download the file from the primary or fallback server.">
                                                    تحميل
                                                </a>

                                                <a target="_blank"
                                                    onclick="checkFileAndPRINT('https://electron-kw.net/{{ $Installment->contract_cinet_1 }}', 'https://electron-kw.com/{{ $Installment->contract_cinet_1 }}'); return false;"
                                                    class="btn waves-effect waves-light bg-secondary-subtle text-secondary btn-sm"
                                                    title="Print the file from the primary or fallback server.">
                                                    طباعة
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @if ($Installment->contract_cinet_2 != Null)
                                    <div class="item">
                                        <div class="meet-our-team position-relative rounded-4 overflow-hidden">
                                            <img src="{{ asset('assets/images/PDF_file_icon.png') }}"
                                                alt="PDF Thumbnail">
                                            <div
                                                class="leadership-card z-1 bg-white rounded py-3 px-8 mx-6 my-6 w-90 text-center">
                                                {{-- <button type="button"
                                                    onclick="checkFileAndRedirect('https://electron-kw.net/{{ $Installment->contract_cinet_2 }}',
                                                'https://electron-kw.com/{{ $Installment->contract_1 }}');"
                                                class="btn waves-effect waves-light bg-primary-subtle text-primary
                                                btn-sm">
                                                تحميل
                                                </button>
                                                <button type="button"
                                                    onclick="checkFileAndPRINT('https://electron-kw.net/{{ $Installment->contract_cinet_2 }}', 'https://electron-kw.com/{{ $Installment->contract_1 }}');"
                                                    class="btn waves-effect waves-light bg-secondary-subtle text-secondary btn-sm">
                                                    طباعة
                                                </button> --}}
                                                <p for="">عقد الساينت 2</p>
                                                <a target="_blank"
                                                    onclick="checkFileAndRedirect('https://electron-kw.net/{{ $Installment->contract_cinet_2  }}', 'https://electron-kw.com/{{ $Installment->contract_cinet_2  }}'); return false;"
                                                    class="btn waves-effect waves-light bg-primary-subtle text-primary btn-sm"
                                                    title="Download the file from the primary or fallback server.">
                                                    تحميل
                                                </a>

                                                <a target="_blank"
                                                    onclick="checkFileAndPRINT('https://electron-kw.net/{{ $Installment->contract_cinet_2  }}', 'https://electron-kw.com/{{ $Installment->contract_cinet_2  }}'); return false;"
                                                    class="btn waves-effect waves-light bg-secondary-subtle text-secondary btn-sm"
                                                    title="Print the file from the primary or fallback server.">
                                                    طباعة
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @if ($Installment->prods_recieved_img != Null)
                                    <div class="item">
                                        <div class="meet-our-team position-relative rounded-4 overflow-hidden">
                                            <img src="{{ asset('assets/images/PDF_file_icon.png') }}"
                                                alt="PDF Thumbnail">
                                            <div
                                                class="leadership-card z-1 bg-white rounded py-3 px-8 mx-6 my-6 w-90 text-center">

                                                {{-- <button type="button"
                                                         onclick="checkFileAndRedirect('https://electron-kw.net/{{ $Installment->prods_recieved_img }}',
                                                'https://electron-kw.com/{{ $Installment->contract_1 }}');"
                                                class="btn waves-effect waves-light bg-primary-subtle text-primary
                                                btn-sm">
                                                تحميل
                                                </button>
                                                <button type="button"
                                                    onclick="checkFileAndPRINT('https://electron-kw.net/{{ $Installment->prods_recieved_img }}', 'https://electron-kw.com/{{ $Installment->contract_1 }}');"
                                                    class="btn waves-effect waves-light bg-secondary-subtle text-secondary btn-sm">
                                                    طباعة
                                                </button> --}}
                                                <p for="">صورة استسلام المنتجات</p>
                                                <a target="_blank"
                                                    onclick="checkFileAndRedirect('https://electron-kw.net/{{ $Installment->prods_recieved_img   }}', 'https://electron-kw.com/{{ $Installment->prods_recieved_img   }}'); return false;"
                                                    class="btn waves-effect waves-light bg-primary-subtle text-primary btn-sm"
                                                    title="Download the file from the primary or fallback server.">
                                                    تحميل
                                                </a>

                                                <a target="_blank"
                                                    onclick="checkFileAndPRINT('https://electron-kw.net/{{ $Installment->prods_recieved_img   }}', 'https://electron-kw.com/{{ $Installment->prods_recieved_img   }}'); return false;"
                                                    class="btn waves-effect waves-light bg-secondary-subtle text-secondary btn-sm"
                                                    title="Print the file from the primary or fallback server.">
                                                    طباعة
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    {{-- client --}}

                                    @foreach ($data['Client']->client_image as $img_Client)

                                    @if ($img_Client->type == "my_img")
                                    <div class="item">
                                        <div class="meet-our-team position-relative rounded-4 overflow-hidden">
                                            <img src="{{ asset('assets/images/PDF_file_icon.png') }}"
                                                alt="PDF Thumbnail">
                                            <div
                                                class="leadership-card z-1 bg-white rounded py-3 px-8 mx-6 my-6 w-90 text-center">
                                                {{-- <a
                                                            id="downloadLink"
                                                            href="https://electron-kw.net/{{ $img_Client->path }}"
                                                onclick="handleRedirect(event,
                                                'https://electron-kw.net/{{ $img_Client->path }}',
                                                'https://electron-kw.com/{{ $img_Client->path }}');"
                                                class="btn waves-effect waves-light bg-primary-subtle text-primary
                                                btn-sm"
                                                title="Download the file from the primary or fallback server.">
                                                تحميل
                                                </a>

                                                <a id="printLink" href="https://electron-kw.net/{{ $img_Client->path }}"
                                                    onclick="handlePrint(event, 'https://electron-kw.net/{{ $img_Client->path }}', 'https://electron-kw.com/{{ $img_Client->path }}');"
                                                    class="btn waves-effect waves-light bg-secondary-subtle text-secondary btn-sm"
                                                    title="Print the file from the primary or fallback server.">
                                                    طباعة
                                                </a> --}}

                                                <p for="">هويتى</p>
                                                {{-- <br> --}}
                                                <a target="_blank"
                                                    onclick="checkFileAndRedirect('https://electron-kw.net/{{ $img_Client->path   }}', 'https://electron-kw.com/{{$img_Client->path   }}'); return false;"
                                                    class="btn waves-effect waves-light bg-primary-subtle text-primary btn-sm"
                                                    title="Download the file from the primary or fallback server.">
                                                    تحميل
                                                </a>

                                                <a target="_blank"
                                                    onclick="checkFileAndPRINT('https://electron-kw.net/{{ $img_Client->path   }}', 'https://electron-kw.com/{{ $img_Client->path   }}'); return false;"
                                                    class="btn waves-effect waves-light bg-secondary-subtle text-secondary btn-sm"
                                                    title="Print the file from the primary or fallback server.">
                                                    طباعة
                                                </a>


                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    @if ($img_Client->type == "work_img")
                                    <div class="item">
                                        <div class="meet-our-team position-relative rounded-4 overflow-hidden">
                                            <img src="{{ asset('assets/images/PDF_file_icon.png') }}"
                                                alt="PDF Thumbnail">
                                            <div
                                                class="leadership-card z-1 bg-white rounded py-3 px-8 mx-6 my-6 w-90 text-center">
                                                {{-- <button type="button"
                                                             onclick="checkFileAndRedirect('https://electron-kw.net/{{ $img_Client->path }}',
                                                'https://electron-kw.com/{{ $img_Client->path }}');"
                                                class="btn waves-effect waves-light bg-primary-subtle text-primary
                                                btn-sm">
                                                تحميل
                                                </button>
                                                <button type="button"
                                                    onclick="checkFileAndPRINT('https://electron-kw.net/{{ $img_Client->path }}', 'https://electron-kw.com/{{ $img_Client->path }}');"
                                                    class="btn waves-effect waves-light bg-secondary-subtle text-secondary btn-sm">
                                                    طباعة
                                                </button> --}}

                                                <p for="">صورة هوية العمل</p>
                                                <a target="_blank"
                                                    onclick="checkFileAndRedirect('https://electron-kw.net/{{ $img_Client->path   }}', 'https://electron-kw.com/{{$img_Client->path   }}'); return false;"
                                                    class="btn waves-effect waves-light bg-primary-subtle text-primary btn-sm"
                                                    title="Download the file from the primary or fallback server.">
                                                    تحميل
                                                </a>

                                                <a target="_blank"
                                                    onclick="checkFileAndPRINT('https://electron-kw.net/{{ $img_Client->path   }}', 'https://electron-kw.com/{{ $img_Client->path   }}'); return false;"
                                                    class="btn waves-effect waves-light bg-secondary-subtle text-secondary btn-sm"
                                                    title="Print the file from the primary or fallback server.">
                                                    طباعة
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    @if ($img_Client->type == "salary_img")
                                    <div class="item">
                                        <div class="meet-our-team position-relative rounded-4 overflow-hidden">
                                            <img src="{{ asset('assets/images/PDF_file_icon.png') }}"
                                                alt="PDF Thumbnail">
                                            <div
                                                class="leadership-card z-1 bg-white rounded py-3 px-8 mx-6 my-6 w-90 text-center">
                                                {{-- <button type="button"
                                                             onclick="checkFileAndRedirect('https://electron-kw.net/{{ $img_Client->path }}',
                                                'https://electron-kw.com/{{ $img_Client->path }}');"
                                                class="btn waves-effect waves-light bg-primary-subtle text-primary
                                                btn-sm">
                                                تحميل
                                                </button>
                                                <button type="button"
                                                    onclick="checkFileAndPRINT('https://electron-kw.net/{{ $img_Client->path }}', 'https://electron-kw.com/{{ $img_Client->path }}');"
                                                    class="btn waves-effect waves-light bg-secondary-subtle text-secondary btn-sm">
                                                    طباعة
                                                </button> --}}

                                                <p for="">شهادة الراتب </p>
                                                <a target="_blank"
                                                    onclick="checkFileAndRedirect('https://electron-kw.net/{{ $img_Client->path   }}', 'https://electron-kw.com/{{$img_Client->path   }}'); return false;"
                                                    class="btn waves-effect waves-light bg-primary-subtle text-primary btn-sm"
                                                    title="Download the file from the primary or fallback server.">
                                                    تحميل
                                                </a>

                                                <a target="_blank"
                                                    onclick="checkFileAndPRINT('https://electron-kw.net/{{ $img_Client->path   }}', 'https://electron-kw.com/{{ $img_Client->path   }}'); return false;"
                                                    class="btn waves-effect waves-light bg-secondary-subtle text-secondary btn-sm"
                                                    title="Print the file from the primary or fallback server.">
                                                    طباعة
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @if ($img_Client->type == "cid_img1")
                                    <div class="item">
                                        <div class="meet-our-team position-relative rounded-4 overflow-hidden">
                                            <img src="{{ asset('assets/images/PDF_file_icon.png') }}"
                                                alt="PDF Thumbnail">
                                            <div
                                                class="leadership-card z-1 bg-white rounded py-3 px-8 mx-6 my-6 w-90 text-center">
                                                {{-- <button type="button"
                                                             onclick="checkFileAndRedirect('https://electron-kw.net/{{ $img_Client->path }}',
                                                'https://electron-kw.com/{{ $img_Client->path }}');"
                                                class="btn waves-effect waves-light bg-primary-subtle text-primary
                                                btn-sm">
                                                تحميل
                                                </button>
                                                <button type="button"
                                                    onclick="checkFileAndPRINT('https://electron-kw.net/{{ $img_Client->path }}', 'https://electron-kw.com/{{ $img_Client->path }}');"
                                                    class="btn waves-effect waves-light bg-secondary-subtle text-secondary btn-sm">
                                                    طباعة
                                                </button> --}}

                                                <p for="">صورة البطاقة المدنية وجه</p>
                                                <a target="_blank"
                                                    onclick="checkFileAndRedirect('https://electron-kw.net/{{ $img_Client->path   }}', 'https://electron-kw.com/{{$img_Client->path   }}'); return false;"
                                                    class="btn waves-effect waves-light bg-primary-subtle text-primary btn-sm"
                                                    title="Download the file from the primary or fallback server.">
                                                    تحميل
                                                </a>

                                                <a target="_blank"
                                                    onclick="checkFileAndPRINT('https://electron-kw.net/{{ $img_Client->path   }}', 'https://electron-kw.com/{{ $img_Client->path   }}'); return false;"
                                                    class="btn waves-effect waves-light bg-secondary-subtle text-secondary btn-sm"
                                                    title="Print the file from the primary or fallback server.">
                                                    طباعة
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    @if ($img_Client->type == "cid_img_2")
                                    <div class="item">
                                        <div class="meet-our-team position-relative rounded-4 overflow-hidden">
                                            <img src="{{ asset('assets/images/PDF_file_icon.png') }}"
                                                alt="PDF Thumbnail">
                                            <div
                                                class="leadership-card z-1 bg-white rounded py-3 px-8 mx-6 my-6 w-90 text-center">
                                                {{-- <button type="button"
                                                             onclick="checkFileAndRedirect('https://electron-kw.net/{{ $img_Client->path }}',
                                                'https://electron-kw.com/{{ $img_Client->path }}');"
                                                class="btn waves-effect waves-light bg-primary-subtle text-primary
                                                btn-sm">
                                                تحميل
                                                </button>
                                                <button type="button"
                                                    onclick="checkFileAndPRINT('https://electron-kw.net/{{ $img_Client->path }}', 'https://electron-kw.com/{{ $img_Client->path }}');"
                                                    class="btn waves-effect waves-light bg-secondary-subtle text-secondary btn-sm">
                                                    طباعة
                                                </button> --}}

                                                <p for=""> صورة البطاقة المدنية ضهر </p>
                                                <a target="_blank"
                                                    onclick="checkFileAndRedirect('https://electron-kw.net/{{ $img_Client->path   }}', 'https://electron-kw.com/{{$img_Client->path   }}'); return false;"
                                                    class="btn waves-effect waves-light bg-primary-subtle text-primary btn-sm"
                                                    title="Download the file from the primary or fallback server.">
                                                    تحميل
                                                </a>

                                                <a target="_blank"
                                                    onclick="checkFileAndPRINT('https://electron-kw.net/{{ $img_Client->path   }}', 'https://electron-kw.com/{{ $img_Client->path   }}'); return false;"
                                                    class="btn waves-effect waves-light bg-secondary-subtle text-secondary btn-sm"
                                                    title="Print the file from the primary or fallback server.">
                                                    طباعة
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    @if ($img_Client->type == "cinet_img")
                                    <div class="item">
                                        <div class="meet-our-team position-relative rounded-4 overflow-hidden">
                                            <img src="{{ asset('assets/images/PDF_file_icon.png') }}"
                                                alt="PDF Thumbnail">
                                            <div
                                                class="leadership-card z-1 bg-white rounded py-3 px-8 mx-6 my-6 w-90 text-center">
                                                {{-- <button type="button"
                                                             onclick="checkFileAndRedirect('https://electron-kw.net/{{ $img_Client->path }}',
                                                'https://electron-kw.com/{{ $img_Client->path }}');"
                                                class="btn waves-effect waves-light bg-primary-subtle text-primary
                                                btn-sm">
                                                تحميل
                                                </button>
                                                <button type="button"
                                                    onclick="checkFileAndPRINT('https://electron-kw.net/{{ $img_Client->path }}', 'https://electron-kw.com/{{ $img_Client->path }}');"
                                                    class="btn waves-effect waves-light bg-secondary-subtle text-secondary btn-sm">
                                                    طباعة
                                                </button> --}}

                                                <p for="">عقد الساينت</p>
                                                <a target="_blank"
                                                    onclick="checkFileAndRedirect('https://electron-kw.net/{{ $img_Client->path   }}', 'https://electron-kw.com/{{$img_Client->path   }}'); return false;"
                                                    class="btn waves-effect waves-light bg-primary-subtle text-primary btn-sm"
                                                    title="Download the file from the primary or fallback server.">
                                                    تحميل
                                                </a>

                                                <a target="_blank"
                                                    onclick="checkFileAndPRINT('https://electron-kw.net/{{ $img_Client->path   }}', 'https://electron-kw.com/{{ $img_Client->path   }}'); return false;"
                                                    class="btn waves-effect waves-light bg-secondary-subtle text-secondary btn-sm"
                                                    title="Print the file from the primary or fallback server.">
                                                    طباعة
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    @if ($img_Client->type == "civil_img")
                                    <div class="item">
                                        <div class="meet-our-team position-relative rounded-4 overflow-hidden">
                                            <img src="{{ asset('assets/images/PDF_file_icon.png') }}"
                                                alt="PDF Thumbnail">
                                            <div
                                                class="leadership-card z-1 bg-white rounded py-3 px-8 mx-6 my-6 w-90 text-center">
                                                {{-- <button type="button"
                                                             onclick="checkFileAndRedirect('https://electron-kw.net/{{ $img_Client->path }}',
                                                'https://electron-kw.com/{{ $img_Client->path }}');"
                                                class="btn waves-effect waves-light bg-primary-subtle text-primary
                                                btn-sm">
                                                تحميل
                                                </button>
                                                <button type="button"
                                                    onclick="checkFileAndPRINT('https://electron-kw.net/{{ $img_Client->path }}', 'https://electron-kw.com/{{ $img_Client->path }}');"
                                                    class="btn waves-effect waves-light bg-secondary-subtle text-secondary btn-sm">
                                                    طباعة
                                                </button> --}}
                                                <p for="">الرقم المدنى </p>
                                                <a target="_blank"
                                                    onclick="checkFileAndRedirect('https://electron-kw.net/{{ $img_Client->path   }}', 'https://electron-kw.com/{{$img_Client->path   }}'); return false;"
                                                    class="btn waves-effect waves-light bg-primary-subtle text-primary btn-sm"
                                                    title="Download the file from the primary or fallback server.">
                                                    تحميل
                                                </a>

                                                <a target="_blank"
                                                    onclick="checkFileAndPRINT('https://electron-kw.net/{{ $img_Client->path   }}', 'https://electron-kw.com/{{ $img_Client->path   }}'); return false;"
                                                    class="btn waves-effect waves-light bg-secondary-subtle text-secondary btn-sm"
                                                    title="Print the file from the primary or fallback server.">
                                                    طباعة
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    @endforeach

                                    <!-- client working -->
                                    @foreach ($data['ClientWorking'] as $index=>$img_Client)

                                        <div class="item">
                                            <div class="meet-our-team position-relative rounded-4 overflow-hidden">
                                                <img src="{{ asset('assets/images/PDF_file_icon.png') }}"
                                                    alt="PDF Thumbnail">
                                                <div
                                                    class="leadership-card z-1 bg-white rounded py-3 px-8 mx-6 my-6 w-90 text-center">

                                                    <p for="">شهادة الراتب {{ $index + 1 }}</p>
                                                    {{-- <br> --}}
                                                    <a target="_blank"
                                                        onclick="checkFileAndRedirect('https://electron-kw.net/{{ $img_Client->image   }}', 'https://electron-kw.com/{{$img_Client->image   }}'); return false;"
                                                        class="btn waves-effect waves-light bg-primary-subtle text-primary btn-sm"
                                                        title="Download the file from the primary or fallback server.">
                                                        تحميل
                                                    </a>

                                                    <a target="_blank"
                                                        onclick="checkFileAndPRINT('https://electron-kw.net/{{ $img_Client->image   }}', 'https://electron-kw.com/{{ $img_Client->image   }}'); return false;"
                                                        class="btn waves-effect waves-light bg-secondary-subtle text-secondary btn-sm"
                                                        title="Print the file from the primary or fallback server.">
                                                        طباعة
                                                    </a>


                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                    @foreach ($data['Installment_Clients'] as $index=>$img_Client)

                                        <div class="item">
                                            <div class="meet-our-team position-relative rounded-4 overflow-hidden">
                                                <img src="{{ asset('assets/images/PDF_file_icon.png') }}"
                                                    alt="PDF Thumbnail">
                                                <div
                                                    class="leadership-card z-1 bg-white rounded py-3 px-8 mx-6 my-6 w-90 text-center">

                                                    <p for="">ملف الساينت </p>
                                                    {{-- <br> --}}
                                                    <a target="_blank"
                                                        onclick="checkFileAndRedirect('https://electron-kw.net/{{ $img_Client->cinet_pdf   }}', 'https://electron-kw.com/{{$img_Client->cinet_pdf   }}'); return false;"
                                                        class="btn waves-effect waves-light bg-primary-subtle text-primary btn-sm"
                                                        title="Download the file from the primary or fallback server.">
                                                        تحميل
                                                    </a>

                                                    <a target="_blank"
                                                        onclick="checkFileAndPRINT('https://electron-kw.net/{{ $img_Client->cinet_pdf   }}', 'https://electron-kw.com/{{ $img_Client->cinet_pdf   }}'); return false;"
                                                        class="btn waves-effect waves-light bg-secondary-subtle text-secondary btn-sm"
                                                        title="Print the file from the primary or fallback server.">
                                                        طباعة
                                                    </a>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="item">
                                            <div class="meet-our-team position-relative rounded-4 overflow-hidden">
                                                <img src="{{ asset('assets/images/PDF_file_icon.png') }}"
                                                    alt="PDF Thumbnail">
                                                <div
                                                    class="leadership-card z-1 bg-white rounded py-3 px-8 mx-6 my-6 w-90 text-center">

                                                    <p for="">الصورة المدنية </p>
                                                    {{-- <br> --}}
                                                    <a target="_blank"
                                                        onclick="checkFileAndRedirect('https://electron-kw.net/{{ $img_Client->upload_img_2   }}', 'https://electron-kw.com/{{$img_Client->upload_img_2   }}'); return false;"
                                                        class="btn waves-effect waves-light bg-primary-subtle text-primary btn-sm"
                                                        title="Download the file from the primary or fallback server.">
                                                        تحميل
                                                    </a>

                                                    <a target="_blank"
                                                        onclick="checkFileAndPRINT('https://electron-kw.net/{{ $img_Client->upload_img_2   }}', 'https://electron-kw.com/{{ $img_Client->upload_img_2   }}'); return false;"
                                                        class="btn waves-effect waves-light bg-secondary-subtle text-secondary btn-sm"
                                                        title="Print the file from the primary or fallback server.">
                                                        طباعة
                                                    </a>

                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    @if ($Installment->qard_paper != "")
                                            <div class="item">
                                                <div class="meet-our-team position-relative rounded-4 overflow-hidden">
                                                    <img src="{{ asset('assets/images/PDF_file_icon.png') }}"
                                                         alt="PDF Thumbnail">
                                                    <div
                                                        class="leadership-card z-1 bg-white rounded py-3 px-8 mx-6 my-6 w-90 text-center">
                                                        
                                                        <p for="">اقرار الدين </p>
                                                        <a target="_blank"
                                                           onclick="checkFileAndRedirect('https://electron-kw.net/{{ $Installment->qard_paper   }}', 'https://electron-kw.com/{{$Installment->qard_paper  }}'); return false;"
                                                           class="btn waves-effect waves-light bg-primary-subtle text-primary btn-sm"
                                                           title="Download the file from the primary or fallback server.">
                                                            تحميل
                                                        </a>

                                                        <a target="_blank"
                                                           onclick="checkFileAndPRINT('https://electron-kw.net/{{ $Installment->qard_paper   }}', 'https://electron-kw.com/{{ $Installment->qard_paper  }}'); return false;"
                                                           class="btn waves-effect waves-light bg-secondary-subtle text-secondary btn-sm"
                                                           title="Print the file from the primary or fallback server.">
                                                            طباعة
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif


                                </div>

                            </div>


                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>


<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <div class="accordion accordion-flush" id="accordionFlushExampleAccount">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingSix">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseSix" aria-expanded="false" aria-controls="flush-collapseSix">
                            <i class="ti ti-inbox fs-6 mx-1" style="color: rgb(18, 245, 226);"></i> كشف الحساب <span
                                class="text-gray mx-1">( قم بالضغط هنا لاظهار كشف الحساب)</span>
                        </button>
                    </h2>
                    <div id="flush-collapseSix" class="accordion-collapse collapse" aria-labelledby="flush-headingSix"
                        data-bs-parent="#accordionFlushExampleAccount">
                        <div class="accordion-body">
                            <div class="table-responsive pb-4">
                                <table id="all-student" class="table table-bordered border text-nowrap align-middle">
                                    <thead>
                                        <!-- start row -->
                                        <tr>
                                            <th> م</th>
                                            <th>الرصيد</th>
                                            <th> الدائن</th>
                                            <th> المدين</th>
                                            <th> التاريخ</th>
                                            <th> طريقة الدفع</th>
                                            <th> صورة المستند</th>
                                        </tr>
                                        <!-- end row -->
                                    </thead>
                                    <tbody>
                                    <!-- start row -->
                                    @php
                                     if ($Installment->extra_first_amount > 0 && $first_amount )
                                       $extra = $Installment->extra_first_amount ;
                                       else
                                       $extra = 0; 
                                       
                                        $total_madionia1= $total_madionia1  +  $Installment->first_amount + $extra ;
                                             $i=1; $the_balance = $total_madionia1 ;

                                             ; @endphp

                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ number_format($total_madionia1  ,3)}}
                                        </td>
                                        <td>{{ number_format ($total_madionia1 ,3)}}
                                        </td>
                                        <td>-</td>
                                        <td>{{ $Installment->created_at ? $Installment->created_at->format('Y-m-d') : 'N/A' }}
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>

                                    @if($Installment->months == 24 && $Installment->laws==1 )
                                    
                                        <tr>
                                            <td> {{$i}} </td>
                                            <td>{{ number_format($total_madionia1,3)}}
                                            </td>
                                            <td>{{ $Installment->installment_months->firstWhere('installment_type','law_percent')->amount }}
                                            </td>
                                            <td>-</td>
                                            <td><span class="btn btn-info"> لا يوجد</span></td>
                                            <td></td>
                                            <td><span class="btn btn-danger"> أتعاب المحامى </span></td>
                                        </tr>
                                    @endif
                                    @php $i++ @endphp
                                    @php
                                        $total_madionia = $total_madionia1 ;

                                    @endphp
                                    @foreach($invoices as $one)

                                        @if($one->amount !=0 )
                                            <tr>
                                                <td>{{$i }}</td>
                                                <td>
                                                    @php $total_madionia = $total_madionia - $one->sum_amount; @endphp
                                                    {{ number_format(($total_madionia), 3, '.', ',') }}
                                                </td>
                                                <td>-</td>
                                                <td>{{$one->sum_amount}}</td>
                                                <td>{{($one->payment_date != 0) ? \Carbon\Carbon::parse($one->payment_date)->format('Y-m-d')  :  date('Y-m-d',$one->created_at) }}
                                                </td>
                                                @if($one->payment_type=='cash')
                                                    <td> <span class="btn btn-success"> كاش</span></td>
                                                @endif
                                                @if ($one->payment_type=='knet')
                                                    <td> <span class="btn btn-success">كى نت</span></td>
                                                @endif
                                                @if ($one->payment_type == 'check')
                                                    <td> <span class="btn btn-success">شيك </span></td>
                                                @endif
                                                @if($one->payment_type == 'part')
                                                    <td>
                                                <span class="btn btn-success">
                                                    رابط </span>
                                                    </td>
                                                @endif
                                                <td>



                                                    <!--                                                    <a href="{{ asset($one->img ?? '/') }}" target=" _blank">
                                                        <span class="btn btn-info"> صورة
                                                            الايصال </span>
                                                    </a>-->

                                                    @if(!empty($one->img))
                                                        <a target="_blank"
                                                           onclick="checkFileAndRedirect('https://electron-kw.net/{{$one->img}}', 'https://electron-kw.com/{{$one->img}}'); return false;"
                                                           title="Download the file from the primary or fallback server.">
                                                    <span class="btn btn-info"> صورة
                                                        الايصال </span>
                                                        </a>
                                                    @else
                                                        <a href="{{ route('noimage') }}" target=" _blank">
                                                        <span class="btn btn-info"> صورة
                                                            الايصال </span>
                                                        </a>
                                                    @endif

                                                </td>
                                            </tr>
                                        @endif
                                        @php $i++ @endphp
                                    @endforeach

                                    @php $total_amounts = 0;
                                        $total_checkat=0;
                                    @endphp


                                    @if (!empty($mil_check) && count($mil_check) > 0 )

                                        @foreach($mil_check as $military_affairs_check)
                                            @php
                                                $total_amounts = $total_amounts + $military_affairs_check->amount;
                                                $total_diff = $total_amounts - $total_checkat;


                                            @endphp
                                            @if($military_affairs_check->military_affairs_check_id !=-1)

                                                @if($total_diff>0)
                                                    @php
                                                        $total_madionia = $total_madionia - $military_affairs_check->amount;
                                                    @endphp
                                                    <tr>
                                                        <td> {{ $i }} </td>
                                                        <td> {{ number_format(($total_madionia), 3, '.', ',') }}
                                                        </td>
                                                        <td>-</td>
                                                        <td>{{ $military_affairs_check->amount }}
                                                        </td>
                                                        <td>{{ \Carbon\Carbon::parse($military_affairs_check->date)->format('Y-m-d') }}
                                                        </td>
                                                        <td>
                                                            <span class="btn btn-success font-weight-100 "> شيك</span>
                                                        </td>
                                                        <td>

                                                            @if(!empty($military_affairs_check->img_dir))
                                                                <a target="_blank"
                                                                   onclick="checkFileAndRedirect('https://electron-kw.net/{{ $military_affairs_check->img_dir}}', 'https://electron-kw.com/{{$military_affairs_check->img_dir}}'); return false;"
                                                                   title="Download the file from the primary or fallback server.">
                                                        <span class="btn btn-info"> صورة
                                                            الايصال </span>
                                                                </a>
                                                            @else
                                                                <a href="{{ route('noimage') }}" target=" _blank">
                                                        <span class="btn btn-info"> صورة
                                                            الايصال </span>
                                                                </a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endif
                                            @php $i++ @endphp
                                        @endforeach
                                    @endif
                                    @if (!empty($mil_amount))

                                        @foreach($mil_amount as $military_affairs_amount)
                                            @php
                                                $total_amounts = $total_amounts + $military_affairs_amount->amount;
                                                $total_diff = $total_amounts - $total_checkat;


                                            @endphp
                                            @if($military_affairs_amount->military_affairs_check_id !=-1)

                                                @if($total_diff>0)
                                                    @php
                                                        $total_madionia = $total_madionia - $military_affairs_amount->amount;
                                                    @endphp
                                                    <tr>
                                                        <td> {{$i}} </td>
                                                        <td> {{ number_format(($total_madionia), 3, '.', ',') }}
                                                        </td>
                                                        <td>-</td>
                                                        <td>{{ $military_affairs_amount->amount }}
                                                        </td>
                                                        <td>{{ \Carbon\Carbon::parse($military_affairs_amount->date)->format('Y-m-d')}}
                                                        </td>
                                                        <td>
                                                <span class="btn btn-danger font-weight-100 ">

                                                    @if($military_affairs_amount->check_type=='salary' )

                                                        حجز راتب

                                                    @elseif($military_affairs_amount->check_type=='banks' )
                                                        حجز بنوك

                                                    @elseif($military_affairs_amount->check_type=='cars' )
                                                        حجز سيارة

                                                    @elseif($military_affairs_amount->check_type=='mahkama_installment'
                                                    )
                                                        تقسيط محكمة

                                                    @elseif($military_affairs_amount->check_type=='mahkama_madionia_sadad'
                                                    )
                                                        سداد مديونية محكمة
                                                    @else
                                                        رصيد تنفيذ
                                                    @endif

                                                </span>
                                                        </td>
                                                        <td>

                                                            @if(!empty($military_affairs_amount->img_dir))
                                                                <a target="_blank"
                                                                   onclick="checkFileAndRedirect('https://electron-kw.net/{{ $military_affairs_amount->img_dir  }}', 'https://electron-kw.com/{{$military_affairs_amount->img_dir}}'); return false;"
                                                                   title="Download the file from the primary or fallback server.">
                                                    <span class="btn btn-info"> صورة
                                                        الايصال </span>
                                                                </a>
                                                            @else
                                                                <a href="{{ route('noimage') }}" target=" _blank">
                                                    <span class="btn btn-info"> صورة
                                                        الايصال </span>
                                                                </a>
                                                            @endif
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
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <div class="accordion accordion-flush" id="accordionFlushExampleInstallments">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingSeven">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseSeven" aria-expanded="false"
                            aria-controls="flush-collapseSeven">
                            <i class="ti ti-basket fs-6 mx-1" style="color: rgb(245, 18, 226);"></i> الاقساط
                            <span class="text-gray mx-1">( قم بالضغط هنا لاظهار الاقساط)</span>
                        </button>
                    </h2>
                    <div id="flush-collapseSeven" class="accordion-collapse collapse"
                        aria-labelledby="flush-headingSeven" data-bs-parent="#accordionFlushExampleInstallments">

                        <div class="accordion-body">
                            <div class="d-flex flex-wrap ">
                                <a  class=" btn-filter me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4 mx-1 mb-2 "
                                    @if($sum != 0) data-bs-toggle="modal" data-bs-target="#pay-total-discount_{{$id}}" @endif>
                                    دفع المديونية مع الخصم </a>
                                <div id="pay-total-discount_{{$id}}" class="modal fade" tabindex="-1"
                                    aria-labelledby="pay-total-discountLabel{{$id}}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header d-flex align-items-center">
                                                <h4 class="modal-title mt-2" id="myModalLabel">
                                                    دفع المديونية مع خصم </h4>
                                                <hr>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-header">
                                                <label class="form-label" for="input1"> المبلغ
                                                    المطلوب : {{ $sum }} دينار
                                                </label>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('installment.pay_total_discount',$id) }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="form-group mb-3">
                                                        <label class="form-label" for="real_price"> اجمالى المديونية
                                                        </label>
                                                        <input type="text" class="form-control mb-2" id="total"
                                                            name="total" disabled value="{{ $sum }}">
                                                        @error('total')
                                                        <div style='color:red'>{{$message}}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label class="form-label" for="cash"> الخصم
                                                        </label>
                                                        <input type="text" class="form-control mb-2" id="discount"
                                                            name="discount"
                                                            onchange="calculate(this.value,'discount_amount');">
                                                        @error('discount')
                                                        <div style='color:red'>{{$message}}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label class="form-label" for="amount"> المدفوع
                                                        </label>
                                                        <input type="text" class="form-control mb-2" id="amount"
                                                            name="amount" disabled value="{{ $sum }}"
                                                            onchange="calculate_2(this.value,'amount');">
                                                        @error('amount')
                                                        <div style='color:red'>{{$message}}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label class="form-label" for="cash"> المبلغ
                                                            النقدي
                                                        </label>
                                                        <input type="text" class="form-control mb-2" id="discount_cash"
                                                            name="discount_cash"  value="{{ $sum }}"
                                                            onchange="calculate_2(this.value,'discount_cash');">
                                                        @error('discount_cash')
                                                        <div style='color:red'>{{$message}}</div>
                                                        @enderror
                                                    </div>
                                                    <input type="hidden" name="discount_cash" value="{{ $sum }}">
                                                    <!-- <input type="hidden" name="discount_knet" value="{{ $sum }}"> -->

                                                    <div class="form-group mb-3">
                                                        <label class="form-label" for="discount_knet"> المبلغ
                                                            بالكي نت
                                                        </label>
                                                        <input type="text" class="form-control mb-2" id="discount_knet"
                                                            name="discount_knet"
                                                            onchange="calculate_2(this.value,'discount_knet');">
                                                        @error('discount_knet')
                                                        <div style='color:red'>{{$message}}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label class="form-label" for="discount_knet_code">
                                                            رقم وصل الكي نت
                                                        </label>
                                                        <input type="text" class="form-control mb-2"
                                                            id="discount_knet_code" name="discount_knet_code">
                                                        @error('discount_knet_code')
                                                        <div style='color:red'>{{$message}}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <input type="file" name="discount_img_dir"
                                                            class="form-control" />
                                                        @error('discount_img_dir')
                                                        <div style='color:red'>{{$message}}</div>
                                                        @enderror
                                                    </div>

                                                    <div class="modal-footer d-flex ">
                                                        <button type="submit" class="btn btn-primary">دفع</button>
                                                        <button type="button"
                                                            class="btn bg-danger-subtle text-danger  waves-effect"
                                                            data-bs-dismiss="modal">
                                                            الغاء
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>

                                <a @if($sum != 0) data-bs-toggle="modal" data-bs-target="#pay-total_{{$id}}" @endif
                                    class=" btn-filter bg-info-subtle text-info px-4 fs-4 mx-1 mb-2  @if($sum == 0)  disabled  @endif"
                                     onclick="return confirm('برجاء التأكد من قيمة المديونية\n قيمة المديونية هى {{ $sum }} دينار \n هل تريد دفع كامل المديونية');"  >
                                    دفع كامل المديونية
                                </a>
                                <div id="pay-total_{{$id}}" class="modal fade" tabindex="-1"
                                    aria-labelledby="pay-totalLabel{{$id}}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header d-flex align-items-center">
                                                <h4 class="modal-title mt-2" id="myModalLabel">
                                                    دفع كامل المديونية </h4>
                                                <hr>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-header">
                                                <label class="form-label" for="input1"> المبلغ
                                                    المطلوب : {{ $sum }} دينار
                                                </label>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('installment.pay_total',$id) }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="form-group mb-3">
                                                        <label class="form-label" for="cash"> المبلغ
                                                            النقدي
                                                        </label>
                                                        <input type="text" class="form-control mb-2" id="cash_total"
                                                            name="cash" onchange="calculate(this.value,'cash_amount');">
                                                        @error('cash')
                                                        <div style='color:red'>{{$message}}</div>
                                                        @enderror
                                                    </div>
                                                    <input type="hidden" id="real_price_total" value="{{ $sum }}">
                                                    <div class="form-group mb-3">
                                                        <label class="form-label" for="knet"> المبلغ
                                                            بالكي نت
                                                        </label>
                                                        <input type="text" class="form-control mb-2" id="knet_total"
                                                            name="knet">
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label class="form-label" for="knet_code">
                                                            رقم وصل الكي نت
                                                        </label>
                                                        <input type="text" class="form-control mb-2" id="knet_code"
                                                            name="knet_code">
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <input type="file" name="paper_img_dir" class="form-control" />
                                                        @error('paper_img_dir')
                                                        <div style='color:red'>{{$message}}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="modal-footer d-flex ">
                                                        <button type="submit" class="btn btn-primary">دفع</button>
                                                        <button type="button"
                                                            class="btn bg-danger-subtle text-danger  waves-effect"
                                                            data-bs-dismiss="modal">
                                                            الغاء
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>

                                <a data-bs-toggle="modal" data-bs-target="#pay-some_{{$id}}"
                                    class="btn-filter bg-warning-subtle text-warning px-4 fs-4 mx-1 mb-2">
                                    دفع جزء </a>
                                <div id="pay-some_{{$id}}" class="modal fade" tabindex="-1"
                                    aria-labelledby="pay-someLabel{{$id}}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header d-flex align-items-center">
                                                <h4 class="modal-title mt-2" id="myModalLabel">
                                                    دفع جزء </h4>
                                                <hr>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-header">
                                                <label class="form-label" for="input1"> اجمالي المبلغ المتأخر
                                                    : {{ $sum }} دينار
                                                </label>
                                            </div>
                                            <div class="modal-header">
                                                <label class="form-label" for="input1"> أقل مبلغ للدفع
                                                    : {{ $install_amount }} دينار
                                                </label>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('installment.pay_some',$id) }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="form-group mb-3">
                                                        <label class="form-label" for="some_amount"> المبلغ
                                                            النقدي
                                                        </label>
                                                        <input type="text" class="form-control mb-2" id="some_amount"
                                                            name="some_amount"
                                                            onchange="calculate(this.value,'some_amount');">
                                                        @error('some_amount')
                                                        <div style='color:red'>{{$message}}</div>
                                                        @enderror
                                                    </div>
                                                    <input type="hidden" id="real_price_some"
                                                        value="{{$install_amount}}">
                                                    <div class="form-group mb-3">
                                                        <label class="form-label" for="knet">
                                                            طريقة الدفع
                                                        </label>
                                                        <select name="pay_way" id="pay_way" class="form-control mb-2"
                                                            onchange="show_knet_code(this.value)">
                                                            <option value="cash">كاش</option>
                                                            <option value="knet">كى نت</option>
                                                        </select>
                                                        @error('pay_way')
                                                        <div style='color:red'>{{$message}}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group mb-3" style="display:none;" id="some_code_div">
                                                        <label class="form-label" for="some_code">
                                                            رقم وصل الكي نت
                                                        </label>
                                                        <input type="text" class="form-control mb-2" id="some_code"
                                                            name="some_code" >
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <input type="file" name="img_dir" class="form-control" />
                                                        @error('img_dir')
                                                        <div style='color:red'>{{$message}}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="modal-footer d-flex ">
                                                        <button type="submit" class="btn btn-primary">دفع</button>
                                                        <button type="button"
                                                            class="btn bg-danger-subtle text-danger  waves-effect"
                                                            data-bs-dismiss="modal">
                                                            الغاء
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                @if ($Installment['laws'] == 0)
                                <a class=" btn-filter me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4 mx-1 mb-2 "
                                    onclick="valthisform()">
                                    دفع </a>
                                @endif
                                <div id="pay-total-checked_{{$id}}" class="modal fade" tabindex="-1"
                                    aria-labelledby="pay-total-checkedLabel{{$id}}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header d-flex align-items-center">
                                                <h4 class="modal-title mt-2" id="myModalLabel">
                                                    دفع </h4>
                                                <hr>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-header">
                                                    <label class="form-label" for="input1"> المبلغ
                                                        المطلوب : {{   request()->has('payment_order_id')}} دينار
                                                    </label>
                                                </div>
                                            <div class="modal-body">
                                                <form action="{{ route('installment.pay_all',$id) }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="form-group mb-3">
                                                        <label class="form-label" for="cash"> المبلغ
                                                            النقدي
                                                        </label>
                                                        <input type="text" class="form-control mb-2" id="cash"
                                                            name="cash"
                                                            onchange="calculate(this.value,'cash_checked');">
                                                        @error('cash')
                                                        <div style='color:red'>{{$message}}</div>
                                                        @enderror
                                                    </div>
                                                    <input type="hidden" id="real_price_checked" value="{{ $sum }}">

                                                    <div class="form-group mb-3">
                                                        <label class="form-label" for="knet"> المبلغ
                                                            بالكي نت
                                                        </label>
                                                        <input type="text" class="form-control mb-2" id="knet_checked"
                                                            name="knet">
                                                        @error('knet')
                                                        <div style='color:red'>{{$message}}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label class="form-label" for="knet_code">
                                                            رقم وصل الكي نت
                                                        </label>
                                                        <input type="text" class="form-control mb-2" id="knet_code"
                                                            name="knet_code">
                                                        @error('knet_code')
                                                        <div style='color:red'>{{$message}}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <input type="file" name="paper_img_dir" class="form-control" />
                                                        @error('paper_img_dir')
                                                        <div style='color:red'>{{$message}}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="modal-footer d-flex ">
                                                        <button type="submit" class="btn btn-primary">دفع</button>
                                                        <button type="button"
                                                            class="btn bg-danger-subtle text-danger  waves-effect"
                                                            data-bs-dismiss="modal">
                                                            الغاء
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->

                                </div>

                            </div>
                            <!-- <div class="mb-3 d-block">
                                <label for="exampleFormControlInput1" class="form-label mt-2 text-center ">نظام الاقساط </label>
                                <input type="email" class="form-control w-75 mt-2 mb-2 " id="exampleFormControlInput1">
                                </div> -->
                            <div class="table-responsive pb-4">
                                <table id="all-student" class="table table-bordered border text-nowrap align-middle">
                                    <thead>
                                        <!-- start row -->
                                        <tr>
                                            <th> م</th>
                                            <th>تاريخ الاستحقاق</th>
                                            <th> المبلغ (دينار)</th>
                                            <th> دفع يدوي</th>
                                            <th> دفع رابط</th>
                                            <th> تاريخ الدفع</th>
                                            @if ($Installment['laws'] == 0)
                                            <th>
                                                <input type="checkbox" class="form-check-input" name="checkAll"
                                                    id="checkAll">
                                            </th>
                                            @endif
                                        </tr>
                                        <!-- end row -->
                                    </thead>
                                    <tbody>
                                        <!-- start row -->
                                        @foreach($installment_months as $month)
                                        @if($month->amount !=0 )
                                        <tr>
                                            <td> {{ $loop->index + 1 }} </td>
                                            <td>{{ $month->date }} </td>
                                            <td>{{ $month->amount }}
                                                @if ($month->installment_type == "first_amount")
                                                <label class="btn btn-success ">المقدم</label>
                                                @endif
                                                @if ($month->installment_type == "law_percent")
                                                <label class="btn btn-success ">اتعاب
                                                    محامى</label>
                                                @endif
                                            </td>
                                            @if($month->status=='not_done')
                                            <td>
                                                <a class="btn btn-info " data-bs-toggle="modal"
                                                    data-bs-target="#pay-one_{{$month->id}}">
                                                    <label> دفع </label>
                                                    @if ($month->installment_type == "first_amount")
                                                    المقدم
                                                    @endif </a>
                                                <div id="pay-one_{{$month->id}}" class="modal fade" tabindex="-1"
                                                    aria-labelledby="pay-oneLabel{{$month->id}}" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header d-flex align-items-center">
                                                                <h4 class="modal-title mt-2" id="myModalLabel">
                                                                    دفع قسط </h4>
                                                                <hr>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-header">
                                                                <label class="form-label" for="input1"> المبلغ
                                                                    المطلوب : {{ $month->amount }} دينار
                                                                </label>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form
                                                                    action="{{ route('installment.pay_one',$month->installment_id) }}"
                                                                    method="POST" enctype="multipart/form-data">
                                                                    @csrf
                                                                    <div class="form-group mb-3">
                                                                        <label class="form-label" for="cash">
                                                                            المبلغ
                                                                            النقدي
                                                                        </label>
                                                                        <input type="text" class="form-control mb-2"
                                                                            id="cash_one" name="cash"
                                                                            onchange="calculate(this.value,'cash_one');">
                                                                        @error('cash')
                                                                        <div style='color:red'>{{$message}}</div>
                                                                        @enderror
                                                                    </div>
                                                                    <input type="hidden" id="real_price_one"
                                                                        value="{{$month->amount}}">
                                                                    <div class="form-group mb-3">
                                                                        <label class="form-label" for="knet_one">
                                                                            المبلغ
                                                                            بالكي نت
                                                                        </label>
                                                                        <input type="text" class="form-control mb-2"
                                                                            id="knet_one" name="knet">
                                                                    </div>
                                                                    <div class="form-group mb-3">
                                                                        <label class="form-label" for="knet_code">
                                                                            رقم وصل الكي نت
                                                                        </label>
                                                                        <input type="text" class="form-control mb-2"
                                                                            id="knet_code" name="knet_code">
                                                                    </div>
                                                                    <div class="form-group mb-3">
                                                                        <input type="file" name="img_dir"
                                                                            class="form-control" />
                                                                    </div>
                                                                    <div class="modal-footer d-flex ">
                                                                        <button type="submit"
                                                                            class="btn btn-primary">دفع
                                                                        </button>
                                                                        <button type="button"
                                                                            class="btn bg-danger-subtle text-danger  waves-effect"
                                                                            data-bs-dismiss="modal">
                                                                            الغاء
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <!-- /.modal-content -->
                                                    </div>
                                                    <!-- /.modal-dialog -->
                                                </div>
                                            </td>
                                            <td>
                                                @if ($month->installment_type == "installment")
                                                <a class="btn btn-info " data-bs-toggle="modal"
                                                    data-bs-target="#pay-part_{{$month->id}}">
                                                    <label>دفع رابط </label>
                                                </a>
                                                <div id="pay-part_{{$month->id}}" class="modal fade" tabindex="-1"
                                                    aria-labelledby="pay-partLabel{{$month->id}}" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header d-flex align-items-center">
                                                                <h4 class="modal-title mt-2" id="myModalLabel">
                                                                    دفع قسط </h4>
                                                                <hr>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-header">
                                                                <label class="form-label" for="input1">
                                                                    المبلغ
                                                                    المطلوب : {{ $month->amount }} دينار
                                                                </label>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form
                                                                    action="{{ route('installment.pay_part',$month->installment_id) }}"
                                                                    method="POST" enctype="multipart/form-data">
                                                                    @csrf
                                                                    <div class="form-group mb-3">
                                                                        <input type="file" name="img_dir"
                                                                            class="form-control" />
                                                                    </div>
                                                                    <div class="form-group mb-3">
                                                                        <label class="form-label" for="knet_code">
                                                                            كود الرابط
                                                                        </label>
                                                                        <input type="text" class="form-control mb-2"
                                                                            id="knet_code" name="knet_code">
                                                                    </div>
                                                                    <div class="modal-footer d-flex ">
                                                                        <button type="submit"
                                                                            class="btn btn-primary">دفع
                                                                        </button>
                                                                        <button type="button"
                                                                            class="btn bg-danger-subtle text-danger  waves-effect"
                                                                            data-bs-dismiss="modal">
                                                                            الغاء
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <!-- /.modal-content -->
                                                    </div>
                                                    <!-- /.modal-dialog -->
                                                </div>
                                                @elseif ($month->installment_type == "law_percent")
                                                <a class="btn btn-danger  ">
                                                    أتعاب المحامي
                                                </a>
                                                @elseif ($month->installment_type == "2_._5_percent")
                                                <a class="btn btn-danger  ">رسوم
                                                    المحكمة
                                                </a>
                                                @else
                                                <a class="btn btn-success  "
                                                    href="{{ route('installment.pay_one',$month->installment_id) }}">دفع
                                                    المقدم
                                                </a>
                                                @endif
                                            </td>
                                            <td>
                                                لا يوجد
                                            </td>
                                            @elseif ($month->status == "delay")
                                            <td>
                                                <a class="btn btn-warning  " href="#">سماح </a>
                                            </td>
                                            <td>
                                                <a class="btn btn-warning  " href="#">سماح </a>
                                            </td>
                                            <td>
                                                <a class="btn btn-warning  " href="#">سماح </a>
                                            </td>
                                            @else
                                            <td>
                                                @if ($month->installment_type == 'discount')
                                                <span class="btn btn-warning">
                                                    خصم </span>
                                                @elseif ($month->payment_type != "part")
                                                <a href="#">
                                                    <span class="btn btn-success">
                                                        تم الدفع </span></a>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($month->payment_type == "part")
                                                <a href="#"> <span class="btn btn-success">
                                                        تم الدفع </span> </a>
                                                @endif
                                            </td>
                                            <td>

                                                <h6>{{ $month->payment_date }}</h6>
                                                <h6>
                                                     @if(!empty($month->img_dir))
                                                    <a href="{{ asset($month->img_dir) }}" target=" _blank">
                                                        <span class="btn btn-info"> صورة
                                                            الايصال </span>
                                                    </a>
                                                    @else
                                                    <a href="{{ route('noimage') }}" target=" _blank">
                                                        <span class="btn btn-info"> صورة
                                                            الايصال </span>
                                                    </a>
                                                    @endif
                                                    </h6>

                                                <a target="_blank"
                                                    href="{{ route('installment.print_recive_ins_money', ['id' => $Installment->id, 'id2' => $month['id']]) }}">
                                                    <i class="fa fa-print text-dark m-r-10"></i>
                                                </a>
                                                <!--  <a href="installment/admin/get_papers/ $month->id ?>">
                                                  <i class="fa fa-edit text-dark m-r-10"></i>
                                                  </a> -->
                                            </td>

                                            @endif
                                            <td>
                                                @if ($month->status == "not_done" && $Installment->law == 0)
                                                <input type="checkbox" disc="{{ $month->amout}}"
                                                    class="form-check-input"
                                                    id="payment_order_id_{{$month->id}}" name="payment_order_id[]"
                                                    value="{{ $month->id }}">
                                                <input type="hidden" name="sum_check" id="sum_check">
                                                @endif
                                            </td>
                                        </tr>
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@include('military_affairs.Execute_alert.print.script')

<script>
$('#checkAll').click(function(event) {
    if (this.checked) {
        // Iterate each checkbox
        $(':checkbox').each(function() {
            this.checked = true;
        });
    } else {
        $(':checkbox').each(function() {
            this.checked = false;
        });
    }
});

function valthisform() {
    var checkboxs = document.getElementsByName("payment_order_id[]");
    var arr = [];
    var okay = false;
    for (var i = 0, l = checkboxs.length; i < l; i++) {
        if (checkboxs[i].checked) {
           
            arr.push(checkboxs[i].value);
            okay = true;
            // break;
        }

    }
    if (!okay) {
        alert("يجب اختيار قسط على الاقل");
        const checkbox = document.getElementById('checkAll');
        const modal = new bootstrap.Modal(document.getElementById('pay-total-checked_{{$Installment->id}}'), {
            keyboard: false
        });

        checkboxs.addEventListener('change', function() {
            if (checkboxs.checked) {
                modal.show();
            } else {
                modal.hide();
            }
        });

        // return false;
    } else {
        // alert(arr);
        // alert('in');
        // arr.push(checkboxs.value);
        alert(arr);
        $('#sum_check').val(arr);
        const modal = new bootstrap.Modal(document.getElementById('pay-total-checked_{{$Installment->id}}'), {
            keyboard: false
        });
        modal.show();
    }
}

function calculate(value, type) {
    var real_price = parseFloat($('#real_price').val()).toFixed(3);
    // alert(value);
    if (type == "cash_one") {

        var real_price = parseFloat($('#real_price_one').val()).toFixed(3);
        //alert(value);alert(real_price);
        var cash = convert(value);
        // alert(cash);
        var knet_n = parseFloat(((real_price * 1000) - cash) / 1000).toFixed(3);
        $('#knet_one').val(knet_n);

    }
    if (type == "knet") {
        // var knet = parseFloat($('#knet').val()).toFixed(3);
        var knet = convert(value);
        var cash_n = parseFloat(((real_price * 1000) - knet) / 1000).toFixed(3);
        $('#cash').val(cash_n);

    }
    if (type == 'discount_amount') {
        var real_price = parseFloat($('#total').val()).toFixed(3);
        var cash = convert(value);
        var knet_n = parseFloat(((real_price * 1000) - cash) / 1000).toFixed(3);
        var knet_n = parseFloat(((real_price * 1000) - cash) / 1000).toFixed(3);
        $('#amount').val(knet_n);
        $('#discount_cash').val(knet_n);
        $('#discount_knet').val('0.000');
        //  calculate_2(knet_n,'real_price');
    }
    if (type == 'cash_settle') {
        var real_price = parseFloat($('#real_price_settle').val()).toFixed(3);
        var cash = convert(value);
        var knet_n = parseFloat(((real_price * 1000) - cash) / 1000).toFixed(3);
        $('#knet_settle').val(knet_n);
    }

    if (type == 'some_amount') {
        var real_price = parseFloat($('#real_price_some').val()).toFixed(3);
        real_price = real_price * 1000;
        value = value * 1000;
        //  alert(real_price);alert(value);
        if (value < real_price) {
            alert(' مبلغ الدفع اقل من القسط الشهري ');
            return false;
        }
    }
    if (type == 'cash_checked') {
        var real_price = parseFloat($('#real_price_checked').val()).toFixed(3);
        var cash = convert(value);
        var knet_n = parseFloat(((real_price * 1000) - cash) / 1000).toFixed(3);
        $('#knet_checked').val(knet_n);
    }

    if (type == 'cash_amount') {
        var real_price = parseFloat($('#real_price_total').val()).toFixed(3);
        var cash = convert(value);
        var knet_n = parseFloat(((real_price * 1000) - cash) / 1000).toFixed(3);
        $('#knet_total').val(knet_n);
    }
    


    return false;
}

function convert(val) {
    if (isNaN(val)) {
        var val = 0;
    } else {
        var val = val * 1000;
    }
    return val;
}

function calculate_2(value, type) {
    var real_price = parseFloat($('#amount').val()).toFixed(3);
    var discount = parseFloat($('#discount').val()).toFixed(3);
   
    if (discount == 'NaN') {
        alert('برجاء ادخال قيمة الخصم');
        return false;
        // $('#knet').val('0.000');
    } else {
    if (type == "discount_cash") {
        var cash = parseFloat($('#discount_cash').val()).toFixed(3);
        var cash = convert(cash);
        var knet_n = parseFloat(((real_price * 1000) - cash) / 1000).toFixed(3);
        $('#discount_knet').val(knet_n);

    }
    if (type == "discount_knet") {
        var knet = parseFloat($('#discount_knet').val()).toFixed(3);
        var knet = convert(knet);
        var cash_n = parseFloat(((real_price * 1000) - knet) / 1000).toFixed(3);
        $('#discount_cash').val(cash_n);

    }
    }
    return false;
}

function show_knet_code(val) {
    if (val == 'knet') {
      $("#some_code_div").show();
    } else {
      $("#some_code_div").hide();
    }   
}
</script>
