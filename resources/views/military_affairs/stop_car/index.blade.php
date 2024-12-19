@php
    $arr = ['success', 'danger', 'primary', 'secondary', 'info', 'warning'];
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
</div>
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
                        <tr data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false"
                            aria-controls="collapseExample">
                            <td>
                                {{ $i }}
                            </td>
                            <td>
                                <a href="#">{{ $item->id }}</a>
                            </td>
                            <td>{{ $item->name_ar }}<br />{{ $item->civil_number }}<br />{{ $item->phone_ids }}</td>
                            <td>{{ $item->governate_id }}</td>
                            <td>{{ $item->eqrar_dain_amount }}</td>
                            <td>{{ $item->issue_id }}</td>

                            <td>
                                @include('military_affairs.Open_file.partial.column_responsible')
                            </td>

                            <td> الاجراءات </td>

                        </tr>
                        @php $i++; @endphp
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>
