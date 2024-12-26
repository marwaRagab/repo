<tr>
    <td>
        {{ $item->i  }}
    </td>
    <td>
        <a href="{{ url('installment/show-installment/' . $item->installment->id) }}"> {{ $item->installment->id }}</a>

    </td>
    <td>{{ $item->installment->client->name_ar }}</td>

    <td>{{ $item->phone_now ? $item->phone_now : '' }}</td>

    <td>
        {{ $item->final_data[0] }}
        <br>
        {{ $item->different_date }} يوم
    </td>

    <td>{{ $item->type_papar }}</td>
    <td>
        {{ $item->eqrar_dain_amount }}
    </td>

    <td>

        <button class="btn me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4 " data-bs-toggle="modal"
            data-bs-target="#open-file-{{ $item->id }}"
            {{ $item->emp_id == 0 || $item->emp_id == null ? 'disabled' : '' }}>
            فتح ملف
        </button>

        <!-- sample modal content -->
        <div id="open-file-{{ $item->id }}" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <form class="mega-vertical_open" action="{{ route('to_ex_alert') }}" method="post"
                        enctype="multipart/form-data">
                        <div class="modal-header d-flex align-items-center">
                            <h4 class="modal-title" id="myModalLabel">
                                فتح ملف </h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <h6><span class="fw-semibold">
                                    الإسم :
                                </span>
                                {{ $item->installment->client->name_ar }}
                            </h6>
                            @if (isset($item->adress))
                                <p>
                                    <span class="fw-semibold">
                                        عنوان السكن :

                                    </span>
                                    المنطقة : - قطعة
                                    : {{ $item->adress->block ? $item->adress->block : '' }}
                                    -
                                    شارع
                                    : {{ $item->adress->street ? $item->adress->street : '' }}

                                    -
                                    مبني
                                    : {{ $item->adress->building ? $item->adress->building : '' }}
                                    - الرقم الآلي
                                    : {{ $item->installment->client->house_id }}
                                </p>
                            @endif

                            @csrf

                            <input type="hidden" name="military_affairs_id" value="{{ $item->id }}">
                            <input type="hidden" name="id_time_type_old" value="{{ $item_type_time->id }}">
                            <input type="hidden" name="id_time_type_new" value="{{ $item_type_time_new->id }}">
                            <input type="hidden" name="type" value="{{ $item_type_time->type }}">
                            <input type="hidden" name="type_id" value="{{ $item_type_time->slug }}">
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label"> الجهة</label>
                                    <select class="form-select" name="place">
                                        @foreach ($courts as $court)
                                            <option value="{{ $court->id }}"
                                                {{ $item->installment->client->governorate_id == $court->id ? 'selected' : '' }}>
                                                {{ $court->name_ar }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('place')
                                        <div style='color:red'>{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="input1 "> تاريخ فتح
                                        الملف </label>
                                    <input type="date" name="date" value="{{ old('date') }}"
                                        class="form-control mb-2" id="input1">
                                    @error('date')
                                        <div style='color:red'>{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="input2 ">الرقم الآلي
                                        للقضية
                                    </label>
                                    <input type="text" name="issue_id" value="{{ old('issue_id') }}"
                                        class="form-control mb-2" id="input2">
                                    @error('issue_id')
                                        <div style='color:red'>{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>

                        </div>
                        <div class="modal-footer d-flex ">
                            <button type="submit" class="btn btn-primary">حفظ
                                وتحويل لأعلان التنفيذ
                            </button>
                            <button type="button" class="btn bg-danger-subtle text-danger  waves-effect"
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
        <br>
        <button class="btn me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4 " data-bs-toggle="modal"
            data-bs-target="#return_to_lated-{{ $item->id }}">
            الرجوع الى العملاء المتاخرين
        </button>
        <!-- sample modal content -->
        <div id="return_to_lated-{{ $item->id }}" class="modal fade" tabindex="-1"
            aria-labelledby="bs-example-modal-md" aria-hidden="true">
            <form class="mega-vertical" action="{{ url('return_to_lated') }}" method="post"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-dialog modal-dialog-scrollable modal-lg">
                    <div class="modal-content">
                        <div class="modal-header d-flex align-items-center">
                            <h4 class="modal-title" id="myModalLabel">
                                الرجوع للمتاخرين </h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>
                                <input type="hidden" name="installment_id" value="{{ $item->installment->id }}">
                                <input type="hidden" name="military_affairs_id" value="{{ $item->id }}">

                            <div class="form-row">

                                <div class="form-group">
                                    <label class="form-label" for="input1 ">
                                        السبب </label>
                                    <textarea name="return_reason" class="form-control mb-2">

                                                        </textarea>
                                    @error('return_reason')
                                        <div style='color:red'>{{ $message }}</div>
                                    @enderror

                                </div>


                            </div>

                        </div>
                        <div class="modal-footer d-flex ">
                            <button type="submit" class="btn btn-primary">
                                حفظ
                            </button>
                            <button type="button" class="btn bg-danger-subtle text-danger  waves-effect"
                                data-bs-dismiss="modal">
                                الغاء
                            </button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
            </form>
            <!-- /.modal-dialog -->
        </div>

    </td>
    {{-- تحديد مسئول --}}
    <td>
        @include('military_affairs.Open_file.partial.column_responsible')
    </td>
    <td>
        {{ $item->installment->client->court ? \App\Models\Court::where('governorate_id', $item->installment->client->court->id)->first()->name_ar : '' }}


    </td>




    <td>
        @include('military_affairs.Execute_alert.print.print')
        <div class="btn-group dropup mb-6 me-6">

            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                data-bs-toggle="dropdown" aria-expanded="false">
                الإجراءات
            </button>

            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <li>
                    <a class="btn btn-success rounded-0 w-100 mt-2" data-bs-toggle="modal"
                        href="{{ url('installment/show-installment/' . $item->installment->id) }}">
                        التفاصيل</a>
                </li>
                <li>
                    <a class="btn btn-primary rounded-0 w-100 mt-2" data-bs-toggle="modal"
                        data-bs-target="#open-details-{{ $item->id }}">
                        الملاحظات</a>
                </li>




            </ul>



            <div id="open-details-{{ $item->id }}" class="modal fade" tabindex="-1"
                aria-labelledby="bs-example-modal-md" aria-hidden="true">

                <div class="modal-dialog modal-dialog-scrollable modal-lg">
                    <div class="modal-content">
                        <form class="mega-vertical" action="{{ url('add_notes') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="modal-header d-flex align-items-center">
                                <h4 class="modal-title" id="myModalLabel">
                                    ملاحظات فتح الملف </h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <ul class="nav nav-pills" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab"
                                            href="#navpill-{{ $item->id }}" role="tab">
                                            <span>الملاحظات</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#notes-{{ $item->id }}"
                                            role="tab">
                                            <span>الإجراءات</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#actions-{{ $item->id }}"
                                            role="tab">
                                            <span>تتبع المعاملة</span>
                                        </a>
                                    </li>

                                </ul>
                                <!-- Tab panes -->
                                @if (count($items) >= 1)

                                    <div class="tab-content border mt-2">
                                        @php
                                            $all_notes = get_all_notes('open_file', $item->id);
                                            // dd();
                                            $all_actions = get_all_actions($item->id);
                                            $get_all_delegations = get_all_delegations($item->id);

                                        @endphp
                                        <div class="tab-pane active p-3" id="navpill-{{ $item->id }}"
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


                                                    @if (count($all_notes) > 0)
                                                        <!-- start row -->
                                                        @foreach ($all_notes as $all_note)
                                                            <tr data-bs-toggle="collapse"
                                                                data-bs-target="#collapseExample"
                                                                aria-expanded="false" aria-controls="collapseExample">
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
                                                    @else
                                                        <tr>
                                                            <td colspan="5"> لا يوجد بيانات</td>
                                                        </tr>

                                                    @endif

                                                </tbody>
                                            </table>
                                            <div class="add-note">
                                                <h4 class="mb-3">اضف ملاحظة</h4>
                                                <input type="hidden" name="military_affairs_id"
                                                    value="{{ $item->installment_id }}">
                                                <input type="hidden" name="id_time_type_old"
                                                    value="{{ $item_type_time->id }}">
                                                <input type="hidden" name="id_time_type_new"
                                                    value="{{ $item_type_time_new->id }}">
                                                <input type="hidden" name="type"
                                                    value="{{ $item_type_time->type }}">
                                                <input type="hidden" name="type_id"
                                                    value="{{ $item_type_time->slug }}">
                                                <div class="form-row">
                                                    <div class="form-group">
                                                        <label class="form-label">
                                                            الاتصال</label>
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
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane p-3" id="notes-{{ $item->id }}" role="tabpanel">
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
                                                    @if (count($all_actions) > 0)
                                                        @foreach ($all_actions as $value)
                                                            <tr>
                                                                @php
                                                                    $created_by = DB::table('users')
                                                                        ->where('id', $value->created_by)
                                                                        ->first();

                                                                @endphp
                                                                <td>{{ $created_by->name_ar ?? 'لا يوجد' }}</td>
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
                                                                    @php

                                                                        $day_start = explode(
                                                                            ' ',
                                                                            $value->date_start,
                                                                        )[0];
                                                                        if (
                                                                            $value->date_end &&
                                                                            $value->date_end != '0000-00-00 00:00:00'
                                                                        ) {
                                                                            $day_end = explode(
                                                                                ' ',
                                                                                $value->date_end,
                                                                            )[0];
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
                                        <div class="tab-pane p-3" id="actions-{{ $item->id }}" role="tabpanel">
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
                                                    @if (count($get_all_delegations) > 0)
                                                        @foreach ($get_all_delegations as $value)
                                                            <tr data-bs-toggle="collapse"
                                                                data-bs-target="#collapseExample"
                                                                aria-expanded="false" aria-controls="collapseExample">
                                                                @php
                                                                    $created_by = DB::table('users')
                                                                        ->where('id', $value->emp_id)
                                                                        ->first();

                                                                @endphp
                                                                <td>
                                                                    {{ $value['execute_date']
                                                                        ? 'اعلان التنفيذ'
                                                                        : ($value['image_date']
                                                                            ? 'الايمج'
                                                                            : ($value['case_proof_date']
                                                                                ? 'إثبات الحالة'
                                                                                : ($value['travel_date']
                                                                                    ? 'منع السفر'
                                                                                    : ($value['car_date']
                                                                                        ? 'حجز السيارات'
                                                                                        : ($value['bank_date']
                                                                                            ? 'حجز بنوك'
                                                                                            : ($value['salary_date']
                                                                                                ? 'حجز راتب'
                                                                                                : ($value['certificate_date']
                                                                                                    ? 'إصدار شهادة العسكريين'
                                                                                                    : 'فتح ملف'))))))) }}
                                                                </td>
                                                                <td>
                                                                    {{ $created_by->name_ar ?? 'لا يوجد' }}
                                                                </td>
                                                                <td>
                                                                    @php

                                                                        $day_start = explode(
                                                                            ' ',
                                                                            $value->assign_date,
                                                                        )[0];
                                                                        if (is_numeric($day_start)) {
                                                                            $day_start = date('Y-m-d', $day_start);
                                                                        }

                                                                        // Check the end date
                                                                        if (
                                                                            $value->end_date &&
                                                                            $value->end_date != ''
                                                                        ) {
                                                                            $day_end = explode(
                                                                                ' ',
                                                                                $value->end_date,
                                                                            )[0];
                                                                            if (is_numeric($day_end)) {
                                                                                $day_end = date('Y-m-d', $day_end);
                                                                            }
                                                                            $different_day = get_different_date(
                                                                                $day_start,
                                                                                $day_end,
                                                                            );
                                                                        } else {
                                                                            // Use current timestamp if end_date is missing
                                                                            $day_end = 'لم تنتهى';
                                                                            $different_day = get_different_date(
                                                                                $day_start,
                                                                                now()->timestamp,
                                                                            );
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

                        {{-- @endif --}}
                    </form>

                    </div>
                    <div class="modal-footer d-flex ">
                        <button class="btn btn-primary" type="submit"> حفظ

                        </button>
                        <button type="button" class="btn bg-danger-subtle text-danger  waves-effect"
                            data-bs-dismiss="modal">
                            إغلاق
                        </button>
                    </div>

                    @endif
                </div>

                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->

        </div>



    </td>
</tr>


<script>
    document.addEventListener("DOMContentLoaded", function () {
       const forms = document.querySelectorAll('.mega-vertical_open');

       forms.forEach(form => {
           form.addEventListener("submit", function (event) {
               let isValid = true;

               // Clear previous error messages
               form.querySelectorAll(".error-message").forEach(e => e.remove());

               // Validate date
               const dateInput = form.querySelector("input[name='date']");
               if (!dateInput.value) {
                   showError(dateInput, "تاريخ فتح الملف مطلوب");
                   isValid = false;
               }

               // Validate issue_id
               const issueIdInput = form.querySelector("input[name='issue_id']");
               if (!issueIdInput.value.trim()) {
                   showError(issueIdInput, "الرقم الآلي للقضية مطلوب");
                   isValid = false;
               } else if (!/^\d+$/.test(issueIdInput.value)) {
                   showError(issueIdInput, "يجب أن يحتوي الرقم الآلي للقضية على أرقام فقط");
                   isValid = false;
               } else if (issueIdInput.value.length < 9) {
                   showError(issueIdInput, "يجب أن يتكون الرقم الآلي للقضية من 9 أرقام على الأقل");
                   isValid = false;
               }

               // Validate place
               const placeSelect = form.querySelector("select[name='place']");
               if (!placeSelect.value) {
                   showError(placeSelect, "يرجى اختيار الجهة");
                   isValid = false;
               }

               if (!isValid) {
                   event.preventDefault(); // Prevent form submission if validation fails
               }
           });
       });

       function showError(input, message) {
           const errorDiv = document.createElement("div");
           errorDiv.className = "error-message text-danger";
           errorDiv.textContent = message;
           input.closest(".form-group").appendChild(errorDiv);
       }
   });
   </script>
