@if (session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif

<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0">{{ $title }} ({{ $count }})</h4>
    </div>
    <div class="card-body">

        <div class="table-responsive pb-4">
            <table id="all-student" class="table table-bordered border text-nowrap align-middle">
                <thead>
                    <!-- start row -->
                    <tr>
                        <th>م</th>
                        <th>رقم المعاملة </th>
                        <th>اسم العميل </th>
                        <th>التاريخ</th>
                        <th>رقم الملف </th>
                        <th>تسليم إقرار الدين</th>

                    </tr>
                    <!-- end row -->
                </thead>
                <tbody>
                    <!-- start row -->

                    @php $i=1; @endphp
                    @foreach ($transactions as $one)
                        <tr>

                            <td>{{ $i }}</td>
                            <td><a href="{{ route('installment.show-installment', $one->id) }}">{{ $one->id }}</a>
                            </td>
                            <td>{{ $one->name_ar }}<br />{{ $one->civil_number }}</td>
                            <td>{{ $one->created_at }}</td>
                            <td>{{ $one->file_number }}</td>
                            <td>
                                <!-- Primary header modal -->


                                <div class="btn-group dropup mb-6 me-6">
                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                        id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        الإجراءات
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li>
                                            <a class="btn btn-warning rounded-0 w-100 mt-2" data-bs-toggle="modal"
                                                data-bs-target="#vertical-center-modal{{ $one->id }}">
                                                تسليم اقرار الدين</a>
                                        </li>
                                        <li>
                                            <a class="btn btn-primary rounded-0 w-100 mt-2" data-bs-toggle="modal"
                                                data-bs-target="#open-details-{{ $one->id }}">
                                                الملاحظات</a>
                                        </li>

                                    </ul>

                                    <div id="open-details-{{ $one->id }}" class="modal fade" tabindex="-1"
                                        aria-labelledby="bs-example-modal-md" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                            <div class="modal-content">
                                                <form class="mega-vertical" action="{{ url('add_notes') }}"
                                                    method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="modal-header d-flex align-items-center">
                                                        <h4 class="modal-title" id="myModalLabel">
                                                            ملاحظات اقرار الدين </h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
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
                                                        @if (count($transactions) >= 1)
                                                            <div class="tab-content border mt-2">
                                                                @php

                                                                    $all_notes = get_all_notes(
                                                                        'eqrar_dain',
                                                                        $one->m_a_id,
                                                                    );
                                                                    //   dd($all_notes);
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
                                                                            @foreach ($all_notes as $all_note)
                                                                                <tr data-bs-toggle="collapse"
                                                                                    data-bs-target="#collapseExample"
                                                                                    aria-expanded="false"
                                                                                    aria-controls="collapseExample">
                                                                                    <td>
                                                                                        {{ $all_note->created_by }}
                                                                                    </td>
                                                                                    <td>
                                                                                        @php
                                                                                            if (
                                                                                                $all_note->notes_type ==
                                                                                                'answered'
                                                                                            ) {
                                                                                                $type = 'رد';
                                                                                            } elseif (
                                                                                                $all_note->notes_type ==
                                                                                                'refused'
                                                                                            ) {
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
                                                                                        $time = explode(
                                                                                            ' ',
                                                                                            $all_note->date,
                                                                                        )[1];
                                                                                        $day = explode(
                                                                                            ' ',
                                                                                            $all_note->date,
                                                                                        )[0];

                                                                                    @endphp
                                                                                    <td>{{ $time }}<span
                                                                                            class="d-block"></span>
                                                                                    </td>
                                                                                    <td>{{ $day }}</td>

                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                    <div class="add-note">
                                                                        <h4 class="mb-3">اضف ملاحظة</h4>

                                                                        <input type="hidden" name="military_affairs_id"
                                                                            value="{{ $one->m_a_id }}">
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
                                                                                    الاتصال </label>
                                                                                <select class="form-select"
                                                                                    name="notes_type">
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
                                                                                    <label class="form-label"> الملاحظات
                                                                                        <span style="color: red">
                                                                                            *</span> </label>
                                                                                    <textarea name="note" class="form-control" rows="5"></textarea>

                                                                                    @error('note')
                                                                                        <div style='color:red'>
                                                                                            {{ $message }}</div>
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
                                                                            @foreach ($all_notes as $value)
                                                                                @php
                                                                                    $types = [
                                                                                        'answered',
                                                                                        'note',
                                                                                        'refused',
                                                                                    ];
                                                                                @endphp

                                                                                @if (!in_array($value->notes_type, $types))
                                                                                    <tr data-bs-toggle="collapse"
                                                                                        data-bs-target="#collapseExample"
                                                                                        aria-expanded="false"
                                                                                        aria-controls="collapseExample">
                                                                                        <td>
                                                                                            {{ $value->created_by }}
                                                                                        </td>
                                                                                        <td>
                                                                                            اقرار الدين
                                                                                        </td>
                                                                                        <td>
                                                                                            @php

                                                                                                $day_start = explode(
                                                                                                    ' ',
                                                                                                    $value->date_start,
                                                                                                )[0];
                                                                                                if ($value->date_end) {
                                                                                                    $day_end = explode(
                                                                                                        ' ',
                                                                                                        $value->date_end,
                                                                                                    )[0];
                                                                                                } else {
                                                                                                    $day_end = date(
                                                                                                        'Y-m-d',
                                                                                                    );
                                                                                                }
                                                                                                $different_day = get_different_dates(
                                                                                                    $day_start,
                                                                                                    $day_end,
                                                                                                );

                                                                                            @endphp
                                                                                            {{ $day_start }}
                                                                                            {{ $day_end }}
                                                                                        </td>

                                                                                        <td>
                                                                                            {{ $different_day }}
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








<!-- Primary Header Modal -->
<div id="vertical-center-modal{{ $one->id }}" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">

        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center mt-2 mb-4">
                    <a href="#" class="text-success" style="display:none;">
                        <span>
                            <img src="{{ asset('assets/images/logos/apple-touch-icon.png') }}" class="me-3 img-fluid"
                                alt="spike-img" />
                        </span>
                    </a>
                </div>

                <form class="ps-3 pr-3" action="{{ route('papers.to_eqrar_dain') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <a href="{{ route('papers.nmozag_eqrar', $one->id) }}" class="btn btn-primary">نموذج اقرار
                            الدين</a>

                    </div>
                    <div class="mb-3">
                        <label for="formFile" class="form-label">صورة نموذج استلام اقرار
                            الدين</label>
                        <input class="form-control" type="file" name="cinet_img" id="formFile">
                        <input class="form-control" type="text" style="display:none;" name="installment_id"
                            value="{{ $one->id }}">
                        @error('cinet_img')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">

                        <label class="mr-sm-2" for="inlineFormCustomSelect">اختر الموظف
                            المستلم</label>
                        <select class="form-select mr-sm-2" id="inlineFormCustomSelect" name="received_user_id">
                            <option value="" selected>اختر...</option>
                            @foreach ($users as $one)
                                <option value="{{ $one->id }}">
                                    {{ $one->name_ar }} </option>
                            @endforeach
                        </select>
                        @error('received_user_id')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror

                    </div>
                    <div class="mb-3">
                        <label for="message-text" class="">ملاحظة</label>
                        <textarea class="form-control" name="paper_recieved_note" id="message-text1"></textarea>
                        @error('paper_recieved_note')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 text-center">


                        <button class="btn bg-info-subtle text-info " type="submit">
                            حفظ
                        </button>

                        <button type="button" class="btn bg-danger-subtle text-danger " data-bs-dismiss="modal">
                            اغلاق
                        </button>
                    </div>
                </form>
            </div>



        </div>
    </div>
    <!-- /.modal-content -->


    <!-- /.modal -->

    </td>
    </tr>
    <!-- end row -->

    @php $i++; @endphp
    @endforeach
    </tbody>
    </table>

</div>

</div>
</div>
