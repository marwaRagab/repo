@php
    ini_set('memory_limit', '256M');
    $arr = ['success', 'danger', 'primary', 'secondary', 'info', 'warning'];
    $governateId = request()->get('governate_id');
    $stopCarType = request()->get('stop_car_type');
@endphp

<div class="card mt-4 py-3">
    <div class="d-flex flex-wrap">
        <a href="{{ route('stop_car') }}" class="btn-filter bg-warning-subtle text-warning px-4 fs-4 mx-1 mb-2">
            الكل
        </a>
        @foreach ($courts as $court)
            <a href="{{ route('stop_car', ['governate_id' => $court->id]) }}"
                class="btn-filter {{ $court->style }} px-4 fs-4 mx-1 mb-2 {{ $governateId == $court->id ? 'active' : '' }}">
                {{ $court->name_ar }} ({{ $count['govern_counter_' . $court->id] ?? 0 }})
            </a>
        @endforeach
    </div>
</div>

@if ($governateId)
    <div class="card mt-4 py-3">
        <div class="d-flex flex-wrap">
            @foreach ($stop_car_types as $itemType)
                <a href="{{ route('stop_car', ['stop_car_type' => $itemType->slug, 'governate_id' => $governateId]) }}"
                    class="btn-filter {{ $itemType->style }} px-4 fs-4 mx-1 mb-2 {{ $stopCarType == $itemType->slug ? 'active' : '' }}">
                    {{ $itemType->name_ar }} ({{ $counts['stop_car_count_' . $itemType->id] ?? 0 }})
                </a>
            @endforeach
        </div>
    </div>
@endif

<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0">حجز السيارات</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive pb-4">
            <table id="file_export" class="table table-bordered border text-nowrap align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>رقم المعاملة</th>
                        <th>اسم العميل</th>
                        <th>المحكمة</th>
                        @if ($stopCarType == 'stop_car_police_station')
                            <th>اسم المخفر</th>
                        @endif
                        <th>المبلغ</th>
                        <th>الرقم الالي</th>
                        @if ($stopCarType)
                            <th>{{ $col_name }}</th>
                        @endif
                        <th>تحديد مسئول</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $index => $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><a href="#">{{ $item->installment->id ?? '' }}</a></td>
                            <td>
                                {{ $item->installment->client->name_ar ?? '' }}<br />
                                {{ $item->installment->client->civil_number ?? '' }}<br />
                                {{ optional($item->installment->client->client_phone->first())->phone }}
                            </td>
                            <td>
                                {{ optional($item->installment->client->court)->name_ar }}<br />
                                @include('military_affairs.Execute_alert.print.print')
                            </td>

                            @if ($stopCarType == 'stop_car_police_station')
                                <td>{{ $item->installment->client->area->police_station->name_ar }} </td>
                            @endif


                            <td>{{ $item->eqrar_dain_amount }}</td>
                            <td>{{ $item->issue_id }}</td>
                            @if ($stopCarType && $stopCarType != 'stop_car_cancel')
                                <td>
                                    @if ($stopCarType == 'stop_car_finished')
                                        <a class="btn btn-primary me-6 my-2"
                                            href="{{ route('send_sms', $item->id) }}">ارسال sms</a><br />
                                    @endif

                                    @if ($stopCarType == 'stop_car_doing')
                                        <a class="btn btn-success me-6 my-2"
                                            href="{{ route('catch_car_done', $item->id) }}">{{ $col_name }}</a><br />
                                        <a class="btn btn-info me-6 my-2" href="1700611200"><span class="btn-label"><i
                                                    class="fa fa-map-marker"></i></span>الموقع</a>
                                    @else
                                        @if ($stopCarType == 'stop_car_cancel_request')
                                            {{ $item->status_all->where('flag', 0)->first()->date }}<br />
                                        @endif
                                        <button class="btn btn-success me-6 my-2" data-bs-toggle="modal"
                                            data-bs-target="#convert_command-{{ $item->id }}"
                                            onclick="check_delegate({{ $item->emp_id }})">
                                            {{ $col_name }}
                                        </button>
                                    @endif

                                    @if ($item->emp_id)
                                        @include(
                                            "military_affairs.stop_car.partials.{$stopCarType}",
                                            compact('item', 'col_name', 'item_type_time1'))
                                    @endif
                                </td>
                            @elseif ($stopCarType == 'stop_car_cancel')
                                <td>
                                    {{ $item->status_all->where('type', 'stop_cars')->where('type_id', 'stop_car_info')->where('flag', 1)->first()->date ?? '' }}
                                    <br />
                                    {{ $item->status_all->where('type', 'stop_cars')->where('flag', 0)->first()->date ?? '' }}
                                </td>
                            @endif
                            <td>
                                @include('military_affairs.Open_file.partial.column_responsible')
                            </td>
                            <td>
                                <div class="btn-group dropup">
                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                        id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        الإجراءات
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li>
                                            <a class="btn btn-success  w-100 mt-2"
                                                href="{{ route('advanced.archive', $item->installment->id) }}">تحويل
                                                للارشيف</a>

                                        </li>
                                        <li>
                                            <a class="btn btn-warning w-100 mt-2" data-bs-toggle="modal"
                                                data-bs-target="#open-details-{{ $item->id }}">
                                                ملاحظات
                                            </a>
                                        </li>
                                        <li>
                                            <a class="btn btn-primary w-100 mt-2"
                                                href="{{ url('show_settlement/' . $item->id) }}">
                                                تحويل للتسوية
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                @include('military_affairs/stop_car/partials/car_notes', ['item' => $item])
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function check_delegate(emp_id) {
        if (!emp_id) {
            alert('يجب تحديد مسئول اولا');
            return false;
        }
    }
</script>
