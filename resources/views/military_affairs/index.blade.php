<div class="card mt-4 py-3">
    <div class="d-flex flex-wrap ">
        <a class="btn-filter bg-warning-subtle text-warning px-4 fs-4 mx-1 mb-2">
            العدد الكلي ({{ $count['all_military_affairs_count'] }})
        </a>
        <a class="btn-filter  bg-success-subtle text-success px-4 fs-4 mx-1 mb-2" href="{{ route('open_file') }}">
            فتح ملف ({{ $count['open_file_count'] }})
        </a>
        <a class="btn-filter  bg-primary-subtle text-primary px-4 fs-4 mx-1 mb-2" href="{{ route('image') }}">
            الايمج
            ({{ $count['images_count'] }}) </a>

        <a class="btn-filter bg-info-subtle text-info px-4 fs-4 mx-1 mb-2" href="{{ route('execute_alert') }}">

            أعلان التنفيذ
            ({{ $count['execute_alert_count'] }}) </a>
        <a class="btn-filter px-4 bg-danger-subtle text-danger px-4 fs-4 mx-1 mb-2" href="{{ route('case_proof') }}">
            أثبات الحالة ({{ $count['case_proof_count'] }})
        </a>
        <a class="btn-filter bg-info-subtle text-info px-4 fs-4 mx-1 mb-2" href="{{ route('Certificate') }}">
            أصدار الشهادة العسكرية ({{ $count['Military_certificate_count'] }})
        </a>
        <a class="btn-filter me-1 mb-1  bg-warning-subtle text-warning  px-4 fs-4 mx-1 mb-2 "
            href="{{ route('stop_travel') }}">
            منع السفر ({{ $count['stop_travel_count'] }})
        </a>
        <a class="btn-filter  bg-success-subtle text-success px-4 fs-4 mx-1 mb-2" href="{{ route('stop_car') }}">
            حجز السيارات
            ({{ $count['stop_car_count'] }}) </a>

        <a class="btn-filter bg-success-subtle text-success px-4 fs-4 mx-1 mb-2" href="{{ route('stop_salary') }}">

            حجز راتب
            ({{ $count['stop_salary_count'] }}) </a>
        <a class="btn-filter px-4 bg-primary-subtle text-primaryfs-4 mx-1 mb-2" href="{{ route('stop_bank') }}">
            حجز بنوك ({{ $count['stop_bank_count'] }})
        </a>
        <a class="btn-filter bg-danger-subtle text-danger px-4 fs-4 mx-1 mb-2" href="{{ route('papers.eqrar_dain') }}">
            اقرارات الدين غير مستلمة ({{ $count['eqrar_dain_count'] }})
        </a>
        <a class="btn-filter px-4 bg-warning-subtle text-pwarningfs-4 mx-1 mb-2"
            href="{{ route('papers.eqrar_dain_received') }}">
            اقرارات الدين مستلمة ({{ $count['eqrar_dain_received_count'] }})
        </a>
        <a class="btn-filter bg-info-subtle text-info px-4 fs-4 mx-1 mb-2" href="{{ route('settle.index') }}">
            رصيد التنفيذ ({{ $count['excute_actions_count'] }})
        </a>
        <a class="btn-filter me-1 mb-1  bg-warning-subtle text-warning  px-4 fs-4 mx-1 mb-2 "
            href="{{ route('excute_actions') }}">
            التسوية ({{ $count['settlement_count'] }})
        </a>
    </div>
</div>
<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0">{{ $title }} </h4>
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
                        <th>الرقم المدني</th>
                        <th> الهاتف </th>
                        <th> المحكمة</th>
                        <th> التاريخ</th>
                    </tr>
                    <!-- end row -->
                </thead>
                <tbody>
                    @php $i=1; @endphp
                    @foreach ($transactions as $one_1)
                        <!-- start row -->

                        <tr>
                            <td>{{ $i }}</td>
                            <td><a href="#">{{ $one_1->id }}</a></td>
                            <td>{{ $one_1->name_ar }}</td>
                            <td>{{ $one_1->civil_number }}</td>
                            <td>{{ $one_1->phone_ids }}</td>
                            <td>{{ $one_1->governorate_id }}</td>
                            <td>{{ $one_1->date }}</td>
                        </tr>
                        <!-- end row -->

                        @php $i++; @endphp
                    @endforeach

                    <!-- end row -->
                </tbody>
            </table>

        </div>

    </div>
</div>
