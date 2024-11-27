<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0"> نظام الاقساط</h4>
    </div>

</div>

<form action="{{ route('installment.store_approved') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <div class="accordion accordion-flush" id="accordionFlushExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseOneone" aria-expanded="false"
                                aria-controls="flush-collapseOne">
                                <i class="ti ti-message-2 fs-6 d-block mx-1" style="color: rgb(202, 226, 43);"></i>
                                <span class="text-gray mx-1"> نظام الاقساط( قم بالضغط هنا لملئ المدخلات)</span>
                            </button>
                        </h2>
                        <div id="flush-collapseOneone" class="accordion-collapse collapse"
                            aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">

                            <div class="row pt-3">

                                <div class="card-custom block">
                                    <input type="hidden" name="installment_clients"
                                        value="{{ $Installment_Client->id }}" />

                                        <div class="form-row row pt-3">

                                            <div class="card-custom block">
                                                <input type="hidden" name="installment_clients"
                                                    value="{{ $Installment_Client->id }}" />

                                                <input onchange="calculate();" type="hidden" name="price_cost" id="price_cost"
                                                    value="{{ $Installment_Client->accept_cost }}" class="form-control">
                                                <input onchange="calculate();" type="hidden" name="rate" class="form-control"
                                                    id="rate" value="{{ $Installment_Client->accept_cost }}">

                                                <div style=" display: none;" class="col-md-3">
                                                    <h5 class="m-t-30 m-b-10"> المبلغ المتبقي</h5>
                                                    <input onchange="calculate();" type="text" name="reminder_amount"
                                                        class="form-control" id="reminder_amount" value="">
                                                </div>
                                                <div class="col-md-3" style=" display: none;">
                                                    <h5 class="m-t-30 m-b-10"> القسط المسموح</h5>
                                                    <input onchange="calculate();" type="text"
                                                        value="{{ $Installment_Client->cinet_installments_total }}"
                                                        name="cinet_amount_limit" id="cinet_amount_limit" class="form-control">
                                                </div>
                                                <div class="form-row row pt-3">
                                                    <div class="form-group mb-3 col-lg-4 col-md-6">
                                                        <label class="form-label">
                                                            مبلغ الموافقة (التكلفة) (1000.000 د.ك )
                                                        </label>
                                  
                                    
                                       @if (!empty($Installment_Client->accept_cost))
                                                        <input class="form-control m-2" type="text"
                                                            onchange="calculate();" id="cost_install"
                                                            name="cost_install"
                                                            value="{{ number_format((float) ($Installment_Client->accept_cost ?? 0), 3, '.', '') }}"
                                                            required />
                                                    @else
                                                        <input class="form-control m-2" type="text"
                                                            onchange="calculate();" id="cost_install"
                                                            name="cost_install" value="" required />
                                                    @endif

                                                    </div>
                                                    <div class="form-group mb-3 col-lg-4 col-md-6">
                                                        <label class="form-label">
                                                            المقدم
                                                        </label>
                                                        <input class=" form-control m-2" type="text" value="0.000"
                                                            onchange="calculate();" id="part" name="part" required readonly/>
                                                    </div>

                                                    <div style=" display: none;" class="form-group mb-3 col-lg-4 col-md-6">
                                                        <label class="form-label"> المبلغ المتبقي</label>
                                                        <input onchange="calculate();" type="text" name="reminder_amount"
                                                            class="form-control" id="reminder_amount" value="">
                                                    </div>
                                                    <div class="form-group mb-3 col-lg-4 col-md-6">
                                                        <label class="form-label">
                                                            المبلغ المقسط
                                                        </label>
                                                        <input class=" form-control m-2" placeholder="المبلغ المقسط"
                                                            onchange="calculate();" id="final_installment_amount" type="text"
                                                            name="final_installment_amount" required/>
                                                    </div>
                                                    <div class="form-group mb-3 col-lg-4 col-md-6">
                                                        <label class="form-label">
                                                            عدد الاقساط
                                                        </label>
                                                        <select id="count_months" name="count_months" class="form-select" onchange="calculate();" required>
                                                        <option value="">اختر</option>
                                                            <option value="36">36 شهر (200.0 %)</option>
                                                            <option value="35">35 شهر (200.0 %)</option>
                                                            <option value="34">34 شهر (200.0 %)</option>
                                                            <option value="33">33 شهر (200.0 %)</option>
                                                            <option value="32">32 شهر (200.0 %)</option>
                                                            <option value="31">31 شهر (200.0 %)</option>
                                                            <option value="30">30 شهر (200.0 %)</option>
                                                            <option value="29">29 شهر (200.0 %)</option>
                                                            <option value="28">28 شهر (200.0 %)</option>
                                                            <option value="27">27 شهر (200.0 %)</option>
                                                            <option value="26">26 شهر (200.0 %)</option>
                                                            <option value="25">25 شهر (200.0 %)</option>
                                                            <option value="24">24 شهر (200.0 %)</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group mb-3 col-lg-4 col-md-6">
                                                        <label class="form-label">
                                                            شهور بدون نسبة
                                                        </label>
                                                            <select onchange="calculate();" id="count_months_without"
                                                                name="count_months_without" class="form-select" required>
                                                                <option value="36">36 شهر</option>
                                                                <option value="35">35 شهر</option>
                                                                <option value="34">34 شهر</option>
                                                                <option value="33">33 شهر</option>
                                                                <option value="32">32 شهر</option>
                                                                <option value="31">31 شهر</option>
                                                                <option value="30">30 شهر</option>
                                                                <option value="29">29 شهر</option>
                                                                <option value="28">28 شهر</option>
                                                                <option value="27">27 شهر</option>
                                                                <option value="26">26 شهر</option>
                                                                <option value="25">25 شهر</option>
                                                                <option value="24">24 شهر</option>
                                                            </select>
                                                    </div>

                                                    <div class="form-group mb-3 col-lg-4 col-md-6">
                                                        <label class="form-label">
                                                        اجمالى المبلغ المقسط
                                                        </label>
                                                        <input class=" form-control m-2" placeholder="اجمالى المبلغ المقسط"
                                                            onchange="calculate();" id="total" type="text"
                                                            name="total" required readonly/>
                                                    </div>
                                                    <div class="form-group mb-3 col-lg-4 col-md-6">
                                                        <label class="form-label">
                                                        القسط الشهرى
                                                        </label>
                                                        <input class=" form-control m-2" placeholder="القسط الشهرى"
                                                            onchange="calculate();" id="monthly_amount" type="text"
                                                            name="monthly_amount" required readonly/>
                                                    </div>
                                                    <div class="form-group mb-3 col-lg-4 col-md-6">
                                                        <label class="form-label">
                                                            قسط الساينت
                                                        </label>
                                                            <input class=" form-control m-2 " placeholder="قسط الساينت"
                                                                onchange="calculate();" id="cinet_installment" type="text"
                                                                name="cinet_installment" value="{{ $Installment_Client->cinet_amount_limit }}" required readonly/>
                                                    </div>


                                                    <div class="form-group mb-3 col-lg-4 col-md-6">
                                                        <label class="form-label">
                                                            القسط الداخلى
                                                        </label>
                                                            <input class=" form-control m-2" placeholder="القسط الداخلى"
                                                                onchange="calculate();" id="intrenal_installment" type="text"
                                                                name="intrenal_installment" required readonly/>
                                                    </div>
                                                    <div class="form-group mb-3 col-lg-4 col-md-6">
                                                        <label class="form-label">
                                                            بداية اول قسط
                                                        </label>
                                                             <select name="start_date" class="form-control form-select">
                                                             @for ($i = 0; $i < 3; $i++)
                                                                @php
                                                                    $date = new DateTime($ministry->date); // Initialize with the original date
                                        
                                                                    $day = $date->format('d'); // Extract the day
                                        
                                                                    // Get the current month and year
                                                                    $currentDate = new DateTime(); // Use DateTime for current date
                                                                    $currentDate->modify("+$i month"); // Increment month by $i
                                                                    $currentYear = $currentDate->format('Y');
                                                                    $currentMonth = $currentDate->format('m');
                                        
                                                                    // Combine to form the display date
                                                                    $displayDate = "$currentYear-$currentMonth-$day";
                                        
                                                                    // Set the new date
                                                                    $date = $displayDate;
                                                                @endphp
                                                                <option value="{{ $date }}">{{ $date }}</option>
                                                            @endfor
                                                        </select>
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
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <div class="accordion accordion-flush" id="accordionFlushExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseOne" aria-expanded="false"
                                aria-controls="flush-collapseOne">
                                <i class="ti ti-user-check fs-6 d-block mx-1" style="color: rgb(1, 122, 58);"></i>
                                بيانات العميل
                                <span class="text-gray mx-1">( قم بالضغط هنا لاظهار بيانات العميل)</span>
                            </button>
                        </h2>
                        <div id="flush-collapseOne" class="accordion-collapse collapse"
                            aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <div class="table-responsive pb-4">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <th>
                                                    الاسم
                                                </th>
                                                <td>{{ $Installment_Client->name_ar  ?? 'لايوجد'}}</td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    الرقم المدني
                                                </th>
                                                <td>{{ $Installment_Client->civil_number ?? 'لايوجد' }}</td>

                                            </tr>
                                            <tr>
                                                <th>
                                                    الهاتف </th>
                                                <td>{{ $Installment_Client->phone ?? 'لايوجد' }}</td>

                                            </tr>
                                            <tr>
                                                <th>
                                                    البنك
                                                </th>
                                                <td> {{ $Installment_Client->bank->name_ar ?? 'لايوجد' }}</td>

                                            </tr>
                                            <tr>
                                                <th>
                                                    المحافظة
                                                </th>
                                                <td> {{ $Installment_Client->governorate->name_ar ?? 'لايوجد' }}</td>

                                            </tr>
                                            <tr>
                                                <th>
                                                    جهة العمل
                                                </th>
                                                <td> {{ $Installment_Client->ministry_working->name_ar ?? 'لايوجد' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    مجموع الأقساط </th>
                                                <td> {{ $Installment_Client->installment_total  ?? 'لايوجد'}}
                                                </td>

                                            </tr>
                                            <tr>
                                                <th>
                                                    مجموع مديونية الساينت </th>
                                                <td> {{ $Installment ? $Installment->total_madionia : 'لا يوجد' }}
                                                </td>

                                            </tr>
                                            <tr>
                                                <th>
                                                    الوسيط </th>
                                                <td> {{ $Installment_Client->installmentBroker->name ?? 'لايوجد' }}
                                                </td>

                                            </tr>
                                            <tr>
                                                <th>
                                                    جهة الدخل ( 1 ) </th>
                                                <td>
                                                    {{ $Installment_Client->ministry_working->name_ar ?? 'لايوجد' }}
                                                </td>



                                            </tr>
                                            <tr>
                                                <th>
                                                    الراتب (1) </th>
                                                <td> {{ $Installment_Client->salary  ?? 'لايوجد'}}</td>

                                            </tr>
                                            <tr>
                                                <th>
                                                    اجمالي الدخل </th>
                                                <td> {{ $Installment_Client->cinet_total_income  ?? 'لايوجد'}}</td>

                                            </tr>

                                            <tr>
                                                <th>
                                                    اقرار دين </th>
                                                <td> <input class="form-checkbox" type="checkbox"
                                                        name="eqrar_dain" required /> </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    دخول الساينت </th>
                                                <td> <input class="form-checkbox" type="checkbox"
                                                        name="cinet_enter" required /> </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    وصل امانة </th>
                                                <td> <input class="form-checkbox" type="checkbox"
                                                        name="amana_paper"  /> </td>
                                            </tr>
                                            <tr>

                                                <th> </th>
                                                <td><button type="submit" class="btn btn-primary">موافقة</button>
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
</form>


{{-- <div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <div class="accordion accordion-flush" id="accordionFlushExampleNotes">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingTwotwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseTwotwo" aria-expanded="false"
                            aria-controls="flush-collapseTwo">
                            <i class="ti ti-message-2 fs-6 d-block mx-1" style="color: blueviolet;"></i> صور الاوراق
                            <span class="text-gray mx-1">( قم بالضغط هنا لاظهار صور الاوراق)</span>
                        </button>
                    </h2>
                    <div id="flush-collapseTwotwo" class="accordion-collapse collapse"
                        aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExampleNotes">
                        <div class="accordion-body">
                            <div>
                                <!-- هنا -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <div class="accordion accordion-flush" id="accordionFlushExampleItems">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingFour">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseFour" aria-expanded="false"
                            aria-controls="flush-collapseFour">
                            <i class="ti ti-sort-descending-2 fs-6 mx-1" style="color: rgb(245, 18, 18);"></i> ملفات
                            الساينت
                            <span class="text-gray mx-1">( قم بالضغط هنا لاظهار ملفات الساينت)</span>
                        </button>
                    </h2>
                    <div id="flush-collapseFour" class="accordion-collapse collapse"
                        aria-labelledby="flush-headingFour" data-bs-parent="#accordionFlushExampleItems">
                        <div class="accordion-body">
                            <div class="table-responsive pb-4">
                                <table id="all-student" class="table table-bordered border text-nowrap align-middle">
                                    <thead>
                                        <!-- start row -->
                                        <tr>
                                            <th> # </th>
                                            <th>الجهة </th>
                                            <th> تاريخ فتح حساب </th>
                                            <th> الرصيد المتبقي </th>
                                            <th> قيمة القسط </th>
                                            <th> قيمة المديونية </th>
                                            <th> فتره السداد </th>
                                            <th> مبلغ القرض </th>
                                            <th> إعادة الجدولة </th>
                                        </tr>
                                        <!-- end row -->
                                    </thead>
                                    <tbody>
                                        <!-- start row -->
                                        @foreach ($Installment_Client_cinet as $item)
                                            <tr
                                                class="border border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">{{ $loop->iteration }}
                                                </td>
                                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                    {{ $item->file_dis_1 }}
                                                </td>
                                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                    {{ $item->file_date_1 }}
                                                </td>
                                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                    {{ $item->file_remindes_amount_1 }}</td>
                                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                    {{ $item->file_installment_amount_1 }} </td>
                                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                    {{ $item->file_debit_amount_1 }} </td>
                                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                    {{ $item->file_all_times_1 }}</td>
                                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                    {{ $item->new_loan_amount_1 }} </td>
                                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                    {{ $item->new_loan_date_1 }} شهر
                                                </td>
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
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <div class="accordion accordion-flush" id="accordionFlushExampleFiles">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingFive">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseFive" aria-expanded="false"
                            aria-controls="flush-collapseFive">
                            <i class="ti ti-bookmark fs-6 mx-1" style="color: rgb(245, 234, 18);"></i> السيارات <span
                                class="text-gray mx-1">( قم بالضغط هنا لاظهار السيارات)</span>
                        </button>
                    </h2>
                    <div id="flush-collapseFive" class="accordion-collapse collapse"
                        aria-labelledby="flush-headingFour" data-bs-parent="#accordionFlushExampleItems">
                        <div class="accordion-body">

                            <table id="notes1" class="table table-bordered border text-wrap align-middle">
                                <thead>
                                    <!-- start row -->
                                    <tr>
                                        <th>#</th>
                                        <th>النوع</th>
                                        <th> السنه</th>
                                        <th>متوسط السعر</th>
                                    </tr>
                                    <!-- end row -->
                                </thead>
                                <tbody>
                                    <!-- start row -->
                                    @foreach ($Installment_Client_car as $item)
                                        <tr
                                            class="border border-transparent border-b-slate-200 dark:border-b-navy-500">
                                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">{{ $loop->iteration }}
                                            </td>
                                            <td class="whitespace-nowrap px-4 py-3 sm:px-5"> {{ $item->type_car }}
                                            </td>
                                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                {{ $item->model_year }}
                                            </td>
                                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                {{ $item->average_price }}</td>

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
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <div class="accordion accordion-flush" id="accordionFlushExampleFiles">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingsix">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapsesix" aria-expanded="false"
                            aria-controls="flush-collapseFive">
                            <i class="ti ti-bookmark fs-6 mx-1" style="color: rgb(245, 234, 18);"></i> القضايا <span
                                class="text-gray mx-1">( قم بالضغط هنا لاظهار القضايا)</span>
                        </button>
                    </h2>
                    <div id="flush-collapsesix" class="accordion-collapse collapse"
                        aria-labelledby="flush-headingFour" data-bs-parent="#accordionFlushExampleItems">
                        <div class="accordion-body">
                            <div class="d-flex flex-wrap ">
                                <a class="  me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4 mx-1 mb-2 ">
                                    المفتوحة : 0.000 د.ك
                                </a>
                                <a class=" bg-success-subtle text-success  px-4 fs-4 mx-1 mb-2">
                                    المغلقة : 2276.000 د.ك
                                </a>
                                <a class=" bg-warning-subtle text-warning px-4 fs-4 mx-1 mb-2">
                                    الإجمالي : 2276.000 د.ك
                                </a>
                            </div>
                            <table id="notes1" class="table table-bordered border text-wrap align-middle">
                                <thead>
                                    <!-- start row -->
                                    <tr>
                                        <th>اليوزر</th>
                                        <th>رقم القضية</th>
                                        <th>الحالة</th>
                                        <th>الجهه</th>
                                        <th>المبلغ</th>
                                        <th>التاريخ</th>



                                    </tr>
                                    <!-- end row -->
                                </thead>
                                <tbody>
                                    <!-- start row -->
                                    @foreach ($Installment_Client_issue as $item)
                                    <tr
                                        class="border border-transparent border-b-slate-200 dark:border-b-navy-500">
                                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">{{ $loop->iteration }}
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-3 sm:px-5"> {{ $item->number_issue }}
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                            @if ($item->status == 'open')
                                                مفتوح
                                            @else
                                                مغلق
                                            @endif
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                            {{ $item->working_company }}</td>
                                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                            {{ $item->opening_amount }}</td>
                                        <td class="whitespace-nowrap px-4 py-3 sm:px-5"> {{ $item->date }}</td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <hr>
                            {{-- <div class="d-flex my-2 ">
                                <h5>قضايا التنفيذ</h5>
                                <div class="my-1">
                                    <a class="  me-1 bg-primary-subtle text-primary px-4 fs-4 mx-1 mb-2 ">
                                        الإجمالي : 0 د.ك
                                    </a>
                                </div>

                            </div>
                            <table id="notes1" class="table table-bordered border text-wrap align-middle">
                                <thead>
                                    <!-- start row -->
                                    <tr>
                                        <th>اليوزر</th>
                                        <th>الاتصال </th>
                                        <th>الساعه</th>
                                        <th>التاريخ</th>
                                        <th>الملاحظة</th>



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
                                            تقى
                                        </td>
                                        <td>
                                            ملاحظة
                                        </td>
                                        <td>
                                            29/10/2024
                                        </td>


                                    </tr>
                                </tbody>
                            </table> --}}
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
                            data-bs-target="#flush-collapseSix" aria-expanded="false"
                            aria-controls="flush-collapseSix">
                            <i class="ti ti-inbox fs-6 mx-1" style="color: rgb(18, 245, 226);"></i> الملاحظات <span
                                class="text-gray mx-1">( قم بالضغط هنا لاظهار الملاحظات)</span>
                        </button>
                    </h2>
                    <div id="flush-collapseSix" class="accordion-collapse collapse"
                        aria-labelledby="flush-headingSix" data-bs-parent="#accordionFlushExampleAccount">
                        <div class="accordion-body">
                            <div class="table-responsive pb-4">
                                <table id="all-student" class="table table-bordered border text-nowrap align-middle">
                                    <thead>
                                        <!-- start row -->
                                        <tr>
                                            <th>#</th>
                                            <th>اليوزر </th>
                                            <th> الاتصال </th>
                                            <th> الساعة </th>
                                            <th> التاريخ</th>
                                            <th> الملاحظة </th>
                                        </tr>
                                        <!-- end row -->
                                    </thead>
                                    <tbody>
                                        <!-- start row -->
                                        @foreach ($Installment_Client_note as $item)
                                            <tr
                                                class="border border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">{{ $loop->iteration }}
                                                </td>
                                                <td class="whitespace-nowrap px-4 py-3 sm:px-5"> {{ $item->created_by }}
                                                </td>
                                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">reply
                                                    {{ $item->reply }}
                                                </td>
                                                <td class="whitespace-nowrap px-4 py-3 sm:px-5"> {{ $item->time }}</td>
                                                <td class="whitespace-nowrap px-4 py-3 sm:px-5"> {{ $item->date }}</td>
                                                <td class="whitespace-nowrap px-4 py-3 sm:px-5"> {{ $item->note }}</td>

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


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // Function to update the installation cost
    function update_install_cost() {
        var total_prods_cost = parseFloat($('#total_prods_cost').val()) || 0;
        $('#cost_install').val(total_prods_cost.toFixed(3));
    }

    // Function to calculate installment values
    function calculate() {
        // Get the cost_install input value and parse it as a float
        let costInstall = parseFloat($('#cost_install').val());
        const cinetInstallment = parseFloat(document.getElementById('cinet_installment').value) || 0;


        // Check if the parsed value is valid
        if (!isNaN(costInstall)) {

            let totalInstallmentAmount = costInstall * 3;
            $('#total').val(totalInstallmentAmount.toFixed(3));

        // Get the number of installments (عدد الاقساط)
        let countMonths = parseFloat($('#count_months').val()) || 0;
        if (countMonths === 0) {
            countMonths = parseFloat($('#count_months_without').val()) || 0;
        }

        if (countMonths > 0) {
            // Calculate المقدم
            let monthlyInstallment = totalInstallmentAmount / countMonths;
            let fractionalPart = monthlyInstallment - Math.floor(monthlyInstallment);
            let upfrontAmount = Math.round(fractionalPart * countMonths * 10) / 10;
            $('#part').val(upfrontAmount.toFixed(3)); // Display المقدم

            // Step 3: Calculate المبلغ المقسط
            let finalInstallmentAmount = totalInstallmentAmount - upfrontAmount;
            $('#final_installment_amount').val(finalInstallmentAmount.toFixed(3)); // Display المبلغ المقسط

            // Calculate القسط الشهرى without decimal places
           // Calculate القسط الشهرى without decimal places
            let monthlyInstallmentRounded = Math.floor(monthlyInstallment);
            $('#monthly_amount').val(monthlyInstallmentRounded); // Display القسط الشهرى without decimals

            // Step 5: Calculate القسط الداخلى as القسط الشهرى - قسط الساينت
            let intrenalInstallment = monthlyInstallment - cinetInstallment;
             document.getElementById('intrenal_installment').value = intrenalInstallment.toFixed(3);
        }

            } else {
                console.error("Invalid cost_install input"); // Log error if the input is invalid
            }
    }

    function check_currency(value, field) {
        // Check for currency formatting or validation (e.g., limit to 3 decimal places)
        if (!/^\d+(\.\d{0,3})?$/.test(value)) {
            alert("Please enter a valid amount up to 3 decimal places");
            document.getElementById(field).value = '';
        }
    }
</script>
