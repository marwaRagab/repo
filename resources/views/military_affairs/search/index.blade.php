<div class="card mt-4 p-4">
    <h5 class="pb-3">البحث</h5>
    <form class="mega-vertical" action="{{ route('search.get_searched')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-rows row align-items-end justify-content-center">
            <div class="form-group col-md-3">
                <label for="name" class="form-label">الاسم</label>
                <input type="text" class="form-control" name="name">
            </div>
            <div class="form-group col-md-3">
                <label for="phone" class="form-label">الهاتف</label>
                <input type="number" class="form-control" name="phone">
            </div>
            <div class="form-group col-md-3">
                <label for="civil_id" class="form-label">الرقم المدني</label>
                <input type="number" class="form-control" name="civil_id">
            </div>
            <div class="form-group col-md-2">
                <button type="submit" class="btn btn-primary w-100 rounded-2">بحث</button>
            </div>
        </div>
    </form>
</div>
<div class="card mt-4 py-3">
    <div class="d-flex flex-wrap ">
        <a href="?" class="btn-filter bg-warning-subtle text-warning px-4 fs-4 mx-1 mb-2">
            العدد الكلي (5857)
        </a>

        <a href="?" class="btn-filter  bg-success-subtle text-success px-4 fs-4 mx-1 mb-2">
            محكمة الجهراء (5)
        </a>
        <a class="btn-filter  bg-success-subtle text-success px-4 fs-4 mx-1 mb-2">
            محكمة مبارك الكبير
            (0) </a>

        <a class="btn-filter bg-danger-subtle text-danger px-4 fs-4 mx-1 mb-2">

            محكمة الأحمدي
            (0) </a>
    </div>
</div>
<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0"> الإجراءات</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive pb-4">
            <table id="all-student" class="table table-bordered border text-nowrap align-middle">
                <thead>
                    <!-- start row -->
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        <th>القسم</th>

                        <th> الوزارة </th>
                        <th> الرقم الالي
                        </th>
                        <th>المديونية</th>
                        <th>المحصل </th>
                        <th> المتبقي </th>
                        <th> منع السفر</th>
                        <th>حجز راتب</th>
                        <th>حجز سيارات</th>
                        <th> الإجراءات </th>

                    </tr>
                    <!-- end row -->
                </thead>
                <tbody>
                    <!-- start row -->
                    @foreach($results as $one)
                    <tr>
                        <td> {{ $loop->iteration }}</td>
                        <td>
                            {{ $one->name_ar}} <br>
                            {{ $one->phone_ids}} <br>
                            {{ $one->civil_number}} <br>
                            {{ $one->installment_id}} <br>
                        </td>
                        <td>
                            <button class="btn btn-sm bg-danger-subtle text-danger d-block mb-2"> منع السفر </button>
                            <button class="btn btn-sm bg-danger-subtle text-danger d-block mb-2"> حجز سيارات</button>
                            <button class="btn btn-sm bg-danger-subtle text-danger d-block mb-2"> حجز بنوك</button>
                        </td>
                        <td>{{ $one->ministry_ids}} </td>
                        <td>{{ $one->issue_id}} </td>
                        <td>{{ $one->madionia_amount}}</td>
                        <td></td>
                        <td>{{ $one->reminder_amount}}</td>
                        <td>
                            @if( $one->stop_travel )
                            <span class="fs-6 text-success"><i class="fa fa-check"></i></span>
                            @else
                            <span class="fs-6 text-danger"><i class="fa fa-times"></i></span>
                            @endif
                        </td>
                        <td>
                            @if( $one->stop_salary )
                            <span class="fs-6 text-success"><i class="fa fa-check"></i></span>
                            @else
                            <span class="fs-6 text-danger"><i class="fa fa-times"></i></span>
                            @endif
                        </td>
                        <td>
                            @if( $one->stop_car )
                            <span class="fs-6 text-success"><i class="fa fa-check"></i></span>
                            @else
                            <span class="fs-6 text-danger"><i class="fa fa-times"></i></span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group mb-6 me-6 d-block ">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    الإجراءات
                                </button>
                                <ul class="dropdown-menu rounded-0" aria-labelledby="dropdownMenuButton">
                                    <li>
                                        <input type="hidden" name="mil_id" value="{{ $one->mil_id }}">
                                        <a class="btn btn-success rounded-0 w-100 mt-2" data-bs-toggle="modal"
                                            data-bs-target="#open-file_{{ $one->mil_id}}"> الصور
                                        </a>
                                        <div id="open-file_{{ $one->mil_id}}" class="modal fade" tabindex="-1"
                                            aria-labelledby="bs-example-modal-md" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                                <div class="modal-content">
                                                    <form action="{{ route('show_images',$one->mil_id) }}" method="get">
                                                        <div class="modal-header d-flex align-items-center">
                                                            <h4 class="modal-title" id="myModalLabel">
                                                                الصور </h4>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row mx-0">

                                                                <div class="col-md-3 mb-3">
                                                                    @if ($one->test->command_img )
                                                                    <a href="{{   $one->command_img ?? '/' }}"
                                                                        target=" _blank"><img
                                                                            src="{{ asset( $one->command_img)}}"
                                                                            alt="gallery" class="img-fluid" /> </a>
                                                                    @endif
                                                                </div>
                                                                <div class="col-md-3 mb-3">
                                                                    @if ($one->test->stop_travel_finished_img )
                                                                    <a href="{{   $item->stop_travel_finished_img ?? '/' }}"
                                                                        target=" _blank"><img
                                                                            src="{{ asset( $item->stop_travel_finished_img)}}"
                                                                            alt="gallery" class="img-fluid" /> </a>
                                                                    @endif
                                                                </div>
                                                                <div class="col-md-3 mb-3">
                                                                    @if ($one->test->stop_salary_doing_img )
                                                                    <a href="{{   $one->stop_salary_doing_img ?? '/' }}"
                                                                        target=" _blank"><img
                                                                            src="{{ asset( $one->stop_salary_doing_img)}}"
                                                                            alt="gallery" class="img-fluid" /> </a>
                                                                    @endif
                                                                </div>
                                                                <div class="col-md-3 mb-3">
                                                                    @if ($one->test->stop_salary_request_img )
                                                                    <a href="{{   $one->stop_salary_request_img ?? '/' }}"
                                                                        target=" _blank"><img
                                                                            src="{{ asset( $one->stop_salary_request_img)}}"
                                                                            alt="gallery" class="img-fluid" /> </a>
                                                                    @endif
                                                                </div>
                                                                <div class="col-md-3 mb-3">
                                                                    @if ($one->stop_salary_money_img )
                                                                    <a href="{{   $one->stop_salary_money_img ?? '/' }}"
                                                                        target=" _blank"><img
                                                                            src="{{ asset( $one->stop_salary_money_img)}}"
                                                                            alt="gallery" class="img-fluid" /> </a>
                                                                    @endif
                                                                </div>
                                                                <div class="col-md-3 mb-3">
                                                                    @if ($one->stop_car_img_catch )
                                                                    <a href="{{   $one->stop_car_img_catch ?? '/' }}"
                                                                        target=" _blank"><img
                                                                            src="{{ asset( $one->stop_car_img_catch)}}"
                                                                            alt="gallery" class="img-fluid" /> </a>
                                                                    @endif
                                                                </div>
                                                                <div class="col-md-3 mb-3">
                                                                    @if ($one->stop_car_img_request )
                                                                    <a href="{{   $one->stop_car_img_request ?? '/' }}"
                                                                        target=" _blank"><img
                                                                            src="{{ asset( $one->stop_car_img_request)}}"
                                                                            alt="gallery" class="img-fluid" /> </a>
                                                                    @endif
                                                                </div>
                                                                <div class="col-md-3 mb-3">
                                                                    @if ($one->stop_car_img_print )
                                                                    <a href="{{   $one->stop_car_img_print ?? '/' }}"
                                                                        target=" _blank"><img
                                                                            src="{{ asset( $one->stop_car_img_print)}}"
                                                                            alt="gallery" class="img-fluid" /> </a>
                                                                    @endif
                                                                </div>
                                                                <div class="col-md-3 mb-3">
                                                                    @if ($one->stop_car_request_img )
                                                                    <a href="{{   $one->stop_car_request_img ?? '/' }}"
                                                                        target=" _blank"><img
                                                                            src="{{ asset( $one->stop_car_request_img)}}"
                                                                            alt="gallery" class="img-fluid" /> </a>
                                                                    @endif
                                                                </div>
                                                           
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer d-flex ">

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
                                    </li>
                                    <li>
                                        <a class="btn btn-warning rounded-0 w-100 mt-2" data-bs-toggle="modal"
                                            data-bs-target="#open-details">
                                            التفاصيل</a>
                                    </li>
                                    <li>
                                        <a class="btn btn-primary rounded-0 w-100 mt-2" data-bs-toggle="modal"
                                            data-bs-target="#open-settle">
                                            تحويل للتسوية </a>
                                    </li>
                                </ul>


                            </div>
                            <button class="btn btn-success me-6" data-bs-toggle="modal" data-bs-target="#add-note">
                                ملاحظة</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>

<div id="open-settle" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myModalLabel">
                    إثبات حالة</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6>
                    الإسم :
                    <span class="text-muted">ناصر علي محمد المرى ( 649 ) </span>
                </h6>
                <h6>
                    الرقم المدنى :
                    <span class="text-muted">275071100845 </span>
                </h6>
                <h6>
                    رقم الهاتف :
                    <span class="text-muted">97845338 </span>
                </h6>
                <h6>
                    مبلغ المديونية :
                    <span class="text-muted">2,550.000 </span>
                </h6>
                <h6>
                    المدفوع :
                    <span class="text-muted"> 595.000 </span>
                </h6>
                <h6>
                    المبلغ المتبقى :
                    <span class="text-muted"> 1,955.000</span>
                </h6>
                <form>
                    <div class="form-row flex-wrap d-flex gap-3 p-3 border mt-3">
                        <div class="form-group">
                            <label for="amount" class="form-label"> مبلغ التسوية </label>
                            <input type="text" name="amount" id="amount" value="1,955.000" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="first_amount_settle" class="form-label"> مقدم التسوية </label>
                            <input type="text" name="first_amount_settle" id="first_amount_settle"
                                class="form-control ">
                        </div>

                        <div class="form-group">
                            <label for="remainder" class="form-label"> المتبقى </label>
                            <input type="text" name="remainder" id="remainder" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="installment_no" class="form-label"> عدد الاقساط </label>
                            <select class="form-control" name="installment_no" id="installment_no">
                                <option value=" ">اختار العدد </option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                            </select>

                        </div>

                        <div class="form-group">
                            <label for="inst_value" class="form-label"> قيمة القسط الشهرى </label>
                            <input type="text" class="form-control" name="inst_value" id="inst_value">

                        </div>
                        <div class="form-group">
                            <label for="last_inst_value" class="form-label"> قيمة القسط الاخير </label>
                            <input type="text" class="form-control" name="last_inst_value" id="last_inst_value">

                        </div>
                        <div class="form-group">
                            <label for="settle_date" class="form-label"> تاريخ دفع المقدم </label>
                            <input type="date" class="form-control " name="settle_date" id="settle_date">
                        </div>
                        <div class="form-group">

                            <label for="action_id" class="form-label"> اختر الاجراء </label>
                            <select class="form-control" name="action[]" id="action_id">
                                <option value="all">الكل </option>
                                <option value="3">رفع حجز بنك </option>
                                <option value="2">رفع حجز راتب </option>
                                <option value="1">رفع حجز سيارات </option>
                                <option value="0"> رفع منع سفر </option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer d-flex ">
                <button type="submit" class="btn btn-primary">حفظ </button>
                <button type="button" class="btn bg-danger-subtle text-danger  waves-effect" data-bs-dismiss="modal">
                    الغاء
                </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div id="open-details" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myModalLabel">
                    ملاحظات فتح ملف
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-pills" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#navpill-1" role="tab">
                            <span>الملاحظات</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#navpill-2" role="tab">
                            <span>الإجراءات</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#navpill-3" role="tab">
                            <span>تتبع المعاملة</span>
                        </a>
                    </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content border mt-2">
                    <div class="tab-pane active p-3" id="navpill-1" role="tabpanel">
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
                                <tr data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false"
                                    aria-controls="collapseExample">
                                    <td>
                                        تقى
                                    </td>
                                    <td>
                                        ملاحظة
                                    </td>
                                    <td>
                                        <p>
                                            تم مراجعة قسم الاعلان للوقوف على سبب تاخر الامج وتيبن تاخير المندوب فى تسليم
                                            الملف للامج وتم عمل
                                            اللازم وادخال الملف امج وسيتم عمل الحسبه ومتابعة باقى الاجراءات
                                        </p>
                                    </td>
                                    <td>12:00 <span class="d-block">مساءا</span></td>
                                    <td>29/10/2024</td>

                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane p-3" id="navpill-2" role="tabpanel">
                        <table id="notes2" class="table table-bordered border text-wrap align-middle">
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
                                <tr data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false"
                                    aria-controls="collapseExample">
                                    <td>
                                        تقى
                                    </td>
                                    <td>
                                        ملاحظة
                                    </td>
                                    <td>
                                        <p>
                                            تم مراجعة قسم الاعلان للوقوف على سبب تاخر الامج وتيبن تاخير المندوب فى تسليم
                                            الملف للامج وتم عمل
                                            اللازم وادخال الملف امج وسيتم عمل الحسبه ومتابعة باقى الاجراءات
                                        </p>
                                    </td>
                                    <td>12:00 <span class="d-block">مساءا</span></td>
                                    <td>29/10/2024</td>

                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane p-3" id="navpill-3" role="tabpanel">
                        <table id="notes3" class="table table-bordered border text-wrap align-middle">
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
                                <tr data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false"
                                    aria-controls="collapseExample">
                                    <td>
                                        تقى
                                    </td>
                                    <td>
                                        ملاحظة
                                    </td>
                                    <td>
                                        <p>
                                            تم مراجعة قسم الاعلان للوقوف على سبب تاخر الامج وتيبن تاخير المندوب فى تسليم
                                            الملف للامج وتم عمل
                                            اللازم وادخال الملف امج وسيتم عمل الحسبه ومتابعة باقى الاجراءات
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
            <div class="modal-footer d-flex ">
                <!-- <a class="btn btn-primary" href="../installments/show-installment.html"> تفصيل المعاملة</a> -->
                <button type="button" class="btn bg-danger-subtle text-danger  waves-effect" data-bs-dismiss="modal">
                    إغلاق
                </button>
            </div>
        </div>
    </div>
</div>
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
                        <div class="form-group">
                            <label class="form-label"> الاتصال</label>
                            <select class="form-select">
                                <option value="3">
                                    رد </option>
                                <option value="2">
                                    لم يرد </option>
                                <option value="1">
                                    ملاحظة </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="my-3">
                                <label class="form-label">الملاحظات</label>
                                <textarea class="form-control" rows="5"></textarea>
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
<div id="travel" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myModalLabel">
                    منع السفر </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6>
                    <span class="fw-semibold">
                        منع السفر
                    </span>
                    علي سعيد مجيد عبد الواحد
                </h6>

                <form>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="input1"> التاريخ</label>
                            <input class="form-control" type="date" id="input1" />
                        </div>
                        <div class="form-group">
                            <label for="formFile" class="form-label">صورة </label>
                            <input class="form-control" type="file" id="formFile" />
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer d-flex ">
                <button type="submit" class="btn btn-primary">حفظ </button>
                <button type="button" class="btn bg-danger-subtle text-danger  waves-effect" data-bs-dismiss="modal">
                    الغاء
                </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>