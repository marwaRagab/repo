@php
    $arr = ['success', 'danger', 'primary', 'secondary', 'info', 'warning'];
    //dd($governorates[2]);
@endphp
<div class="card mt-4 py-3">
    <div class="d-flex flex-wrap ">
        <a class="btn-filter bg-warning-subtle text-warning px-4 fs-4 mx-1 mb-2">
            العدد الكلي ({{ $govern_count_total }})
        </a>

        @for ($i = 0; $i < count($governorates); $i++)
            <a href="{{ url('military_affairs/stop_car/' . ($governate_id ?? '') . '/' . ($stop_car_type ?? '')) }}"
                class="btn-filter  bg-{{ $arr[$i] }}-subtle text-{{ $arr[$i] }} px-4 fs-4 mx-1 mb-2">
                محكمة {{ $governorates[$i]->name_ar }} ({{ $count['govern_counter_' . $governorates[$i]->id] }})
            </a>
        @endfor

    </div>
</div> @php
    //  dd($stop_car_request_counter);
@endphp
<div class="card mt-4 py-3">
    <div class="d-flex flex-wrap ">

        @foreach (collect($types)->zip($classes) as [$type, $class])
            <a class="btn-filter  {{ $class }} px-4 fs-4 mx-1 mb-2"
                href="{{ url('military_affairs/stop_car/' . ($governate_id ?? '') . '/' . ($stop_car_type ?? '')) }}">
                {{ $type->name_ar }} ( )
            </a>
        @endforeach


    </div>
</div>
<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0"> حجز السيارات</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive pb-4">
            <table id="all-student" class="table table-bordered border text-nowrap align-middle">
                <thead>
                    <!-- start row -->
                    <tr>
                        <th>#</th>



                        <th>رقم المعاملة </th>
                        <th>اسم العميل</th>
                        <th> المحكمة</th>
                        <th>المبلغ </th>
                        <th> الرقم الالي </th>

                        <th> الإجراءات </th>

                    </tr>
                    <!-- end row -->
                </thead>
                <tbody>

                    <!-- start row -->
                    @php $i=1; @endphp
                    @foreach ($transactions as $one)
                        <tr data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false"
                            aria-controls="collapseExample">
                            <td>
                                {{ $i }}
                            </td>
                            <td>
                                <a href="#">{{ $one->id }}</a>
                            </td>
                            <td>{{ $one->name_ar }}<br />{{ $one->civil_number }}<br />{{ $one->phone_ids }}</td>
                            <td>{{ $one->governate_id }}</td>
                            <td>{{ $one->eqrar_dain_amount }}</td>
                            <td>{{ $one->issue_id }}</td>

                            <td>
                                <div class="btn-group dropup mb-6 me-6 d-block ">
                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                        id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        الإجراءات
                                    </button>
                                    <ul class="dropdown-menu rounded-0" aria-labelledby="dropdownMenuButton">
                                        <li>
                                            <a class="btn btn-success rounded-0 w-100 mt-2" data-bs-toggle="modal"
                                                data-bs-target="#open-file"> رفع الصور
                                            </a>
                                        </li>
                                        <li>
                                            <a class="btn btn-warning rounded-0 w-100 mt-2" data-bs-toggle="modal"
                                                data-bs-target="#open-details-{{ $one->id }}">
                                                ملاحظات</a>
                                        </li>
                                        <li>
                                            <a class="btn btn-primary rounded-0 w-100 mt-2" data-bs-toggle="modal"
                                                data-bs-target="#open-settle-{{ $one->id }}">
                                                تحويل للتسوية </a>
                                        </li>
                                    </ul>


                                </div>

                            </td>
                        </tr>

                        <div id="open-details-{{ $one->id }}" class="modal fade" tabindex="-1"
                            aria-labelledby="bs-example-modal-md" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header d-flex align-items-center">
                                        <h4 class="modal-title" id="myModalLabel">
                                            ملاحظات حجز السيارات
                                        </h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">

                                        <!-- Tab panes -->
                                        <div class="tab-content border mt-2">
                                            @php

                                                $all_notes = get_all_notes('stop_car', $one->military_affairs_id);
                                            @endphp
                                            <div class="tab-pane active p-3" id="navpill-1" role="tabpanel">
                                                <form class="mega-vertical" action="{{ url('add_notes') }}"
                                                    method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="form-row">
                                                        <input type="hidden" name="military_affairs_id"
                                                            value="{{ $one->id }}">
                                                        <input type="hidden" name="id_time_type_old"
                                                            value="{{ $item_type_time->id }}">
                                                        <input type="hidden" name="id_time_type_new"
                                                            value="{{ $item_type_time_new->id }}">
                                                        <input type="hidden" name="type"
                                                            value="{{ $item_type_time->type }}">
                                                        <input type="hidden" name="type_id"
                                                            value="{{ $item_type_time->id }}">

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
                                                                <textarea name="note" class="form-control" rows="5"></textarea>

                                                                @error('note')
                                                                    <div style='color:red'>{{ $message }}</div>
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
                                                        @foreach ($all_notes as $all_note)
                                                            <tr data-bs-toggle="collapse"
                                                                data-bs-target="#collapseExample" aria-expanded="false"
                                                                aria-controls="collapseExample">
                                                                <td>
                                                                    {{ $all_note->created_by }}
                                                                </td>
                                                                <td>
                                                                    @php
                                                                        if ($all_note->notes_type == 'answered') {
                                                                            $type = 'رد';
                                                                        } elseif ($all_note->notes_type == 'refused') {
                                                                            $type = 'لم يرد';
                                                                        } else {
                                                                            $type = 'ملاحظة';
                                                                        }

                                                                    @endphp
                                                                    {{ $type }}
                                                                </td>
                                                                <td>
                                                                    <p>
                                                                        {{ $all_note->note }}
                                                                    </p>
                                                                </td>
                                                                @php
                                                                    $time = explode(' ', $all_note->date)[1];
                                                                    $day = explode(' ', $all_note->date)[0];

                                                                @endphp
                                                                <td>{{ $time }}<span class="d-block"></span>
                                                                </td>
                                                                <td>{{ $day }}</td>

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

                            <div id="open-settle{{ $one->id }}" class="modal fade" tabindex="-1"
                                aria-labelledby="bs-example-modal-md" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header d-flex align-items-center">
                                            <h4 class="modal-title" id="myModalLabel">
                                                إثبات حالة</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
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
                                                        <label for="amount" class="form-label"> مبلغ التسوية
                                                        </label>
                                                        <input type="text" name="amount" id="amount"
                                                            value="1,955.000" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="first_amount_settle" class="form-label"> مقدم
                                                            التسوية </label>
                                                        <input type="text" name="first_amount_settle"
                                                            id="first_amount_settle" class="form-control ">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="remainder" class="form-label"> المتبقى </label>
                                                        <input type="text" name="remainder" id="remainder"
                                                            class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="installment_no" class="form-label"> عدد الاقساط
                                                        </label>
                                                        <select class="form-control" name="installment_no"
                                                            id="installment_no">
                                                            <option value=" ">اختار العدد </option>
                                                            <option value="1">1</option>
                                                            <option value="2">2</option>
                                                            <option value="3">3</option>
                                                            <option value="4">4</option>
                                                        </select>

                                                    </div>

                                                    <div class="form-group">
                                                        <label for="inst_value" class="form-label"> قيمة القسط الشهرى
                                                        </label>
                                                        <input type="text" class="form-control" name="inst_value"
                                                            id="inst_value">

                                                    </div>
                                                    <div class="form-group">
                                                        <label for="last_inst_value" class="form-label"> قيمة القسط
                                                            الاخير </label>
                                                        <input type="text" class="form-control"
                                                            name="last_inst_value" id="last_inst_value">

                                                    </div>
                                                    <div class="form-group">
                                                        <label for="settle_date" class="form-label"> تاريخ دفع المقدم
                                                        </label>
                                                        <input type="date" class="form-control "
                                                            name="settle_date" id="settle_date">
                                                    </div>
                                                    <div class="form-group">

                                                        <label for="action_id" class="form-label"> اختر الاجراء
                                                        </label>
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
                                            <button type="button"
                                                class="btn bg-danger-subtle text-danger  waves-effect"
                                                data-bs-dismiss="modal">
                                                الغاء
                                            </button>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>

                            @php $i++; @endphp
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>
