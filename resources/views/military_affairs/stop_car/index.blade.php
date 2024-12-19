@php
    $arr = ['success', 'danger', 'primary', 'secondary', 'info', 'warning'];
@endphp
<div class="card mt-4 py-3">
    <div class="d-flex flex-wrap ">
        <a class="btn-filter bg-warning-subtle text-warning px-4 fs-4 mx-1 mb-2">
            العدد الكلي ({{ $govern_count_total }})
        </a>



        @foreach($courts as $court)

        <a href="{{route('stop_car',array('court' => $court->id ))}}"
            class="btn-filter {{$court->style}}   px-4 fs-4 mx-1 mb-2"> {{$court->name_ar}}
        </a>

        @endforeach
    </div>
</div>
<div class="card mt-4 py-3">
    <div class="d-flex flex-wrap ">



        @foreach($stop_car_types as $item_type)
        <a href="{{route('stop_car',array('court'=> request()->get('court')  ,'type' => $item_type->slug ))}}"
            class="btn-filter {{$item_type->style}}  px-4 fs-4 mx-1 mb-2">
            {{$item_type->name_ar}}
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
            <table id="file_export" class="table table-bordered border text-nowrap align-middle">
                <thead>
                    <!-- start row -->
                    <tr>
                        <th>#</th>

                        <th>رقم المعاملة </th>
                        <th>اسم العميل</th>
                        <th> المحكمة</th>
                        <th>المبلغ </th>
                        <th> الرقم الالي </th>
                        <th>تحديد مسئول</th>

                        <th> الإجراءات </th>

                    </tr>
                    <!-- end row -->
                </thead>
                <tbody>

                    <!-- start row -->
                    @php $i=1; @endphp
                    @foreach ($transactions as $item)
                        <tr>
                            <td>
                                {{ $i }}
                            </td>
                            <td>
                                <a href="#">{{ $item->installment->id ?? '' }}</a>
                            </td>
                            <td>{{ $item->installment->client->name_ar ?? '' }}
                                <br />{{ $item->installment->client->civil_number ?? '' }}
                                <br />
                                {{ $item->installment->client?->client_phone->first()?->phone }}
                            </td>
                            <td>{{ $item->installment->client->court ? \App\Models\Court::where('governorate_id', $item->installment->client->court->id)->first()->name_ar : '' }}
                                <br />
                                @include('military_affairs.Execute_alert.print.print')
                            </td>
                            <td>{{ $item->eqrar_dain_amount }}</td>
                            <td>{{ $item->issue_id }}</td>

                            <td>
                                @include('military_affairs.Open_file.partial.column_responsible')
                            </td>

                            <td>
                                <div class="btn-group dropup mb-6 me-6 d-block ">
                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                        id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
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
                                                href="{{ url('show_settlement/' . $item->id) }}">
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
                                                    ملاحظات حجز السيارات
                                                </h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">

                                                <!-- Tab panes -->
                                                <div class="tab-content border mt-2">
                                                    @php

                                                        $all_notes = get_all_notes('stop_cars', $item->id);
                                                    @endphp
                                                    <div class="tab-pane active p-3" id="navpill-{{ $item->id }}"
                                                        role="tabpanel">
                                                        <form class="mega-vertical" action="{{ url('add_notes') }}"
                                                            method="post" enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="form-row">
                                                                <input type="hidden" name="military_affairs_id"
                                                                    value="{{ $item->id }}">
                                                                <input type="hidden" name="type"
                                                                    value="{{ $item_type_time1->type }}">
                                                                <input type="hidden" name="type_id"
                                                                    value="{{ $item_type_time1->slug }}">



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
                                                                            <div style='color:red'>{{ $message }}
                                                                            </div>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <button type="submit"
                                                                    class="btn btn-primary">حفظ</button>
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
                                                                        data-bs-target="#collapseExample"
                                                                        aria-expanded="false"
                                                                        aria-controls="collapseExample">
                                                                        <td>
                                                                            {{ $all_note->created_by }}
                                                                        </td>
                                                                        <td>
                                                                            @php
                                                                                if (
                                                                                    $all_note->notes_type == 'answered'
                                                                                ) {
                                                                                    $type = 'رد';
                                                                                } elseif (
                                                                                    $all_note->notes_type == 'refused'
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
                                                                            $time = explode(' ', $all_note->date)[1];
                                                                            $day = explode(' ', $all_note->date)[0];

                                                                        @endphp
                                                                        <td>{{ $time }}<span
                                                                                class="d-block"></span>
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
                                </div>

                            </td>

                        </tr>
                        @php $i++; @endphp
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>
