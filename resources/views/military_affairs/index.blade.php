<div class="card mt-4 py-3">
    <div class="d-flex flex-wrap ">
        <a class="btn-filter bg-warning-subtle text-warning px-2  mx-1 mb-2" href="{{ route('military_affairs') }}">
            العدد الكلي ({{ $count['all_military_affairs_count'] }})
        </a>
        <a class="btn-filter  bg-success-subtle text-success px-2  mx-1 mb-2" href="{{ route('open_file') }}">
            فتح ملف ({{ $count['open_file_count'] }})
        </a>
        <a class="btn-filter  bg-primary-subtle text-primary px-2  mx-1 mb-2" href="{{ route('image') }}">
            الايمج
            ({{ $count['images_count'] }}) </a>

        <a class="btn-filter bg-info-subtle text-info px-2  mx-1 mb-2" href="{{ route('execute_alert') }}">

            أعلان التنفيذ
            ({{ $count['execute_alert_count'] }}) </a>
        <a class="btn-filter px-2 bg-danger-subtle text-danger px-2  mx-1 mb-2" href="{{ route('case_proof') }}">
            أثبات الحالة ({{ $count['case_proof_count'] }})
        </a>
        <a class="btn-filter bg-info-subtle text-info px-2  mx-1 mb-2" href="{{ route('Certificate') }}">
            أصدار الشهادة العسكرية ({{ $count['Military_certificate_count'] }})
        </a>
        <a class="btn-filter me-1 mb-1  bg-warning-subtle text-warning  px-2  mx-1 mb-2 "
            href="{{ route('stop_travel') }}">
            منع السفر ({{ $count['stop_travel_count'] }})
        </a>
        <a class="btn-filter  bg-success-subtle text-success px-2  mx-1 mb-2" href="{{ route('stop_car') }}">
            حجز السيارات
            ({{ $count['stop_car_count'] }}) </a>

        <a class="btn-filter bg-success-subtle text-success px-2  mx-1 mb-2" href="{{ route('stop_salary') }}">

            حجز راتب
            ({{ $count['stop_salary_count'] }}) </a>
        <a class="btn-filter px-2 bg-primary-subtle text-primary  mx-1 mb-2" href="{{ route('stop_bank') }}">
            حجز بنوك ({{ $count['stop_bank_count'] }})
        </a>
        <a class="btn-filter bg-danger-subtle text-danger px-2  mx-1 mb-2" href="{{ route('papers.eqrar_dain') }}">
            اقرارات الدين غير مستلمة ({{ $count['eqrar_dain_count'] }})
        </a>
        <a class="btn-filter px-2 bg-warning-subtle text-pwarning  mx-1 mb-2"
            href="{{ route('papers.eqrar_dain_received') }}">
            اقرارات الدين مستلمة ({{ $count['eqrar_dain_received_count'] }})
        </a>
        <a class="btn-filter bg-info-subtle text-info px-2  mx-1 mb-2" href="{{ route('excute_actions') }}">
            رصيد التنفيذ ({{ $count['excute_actions_count'] }})
        </a>
        <a class="btn-filter me-1 mb-1  bg-warning-subtle text-warning  px-2  mx-1 mb-2 "
            href="{{ route('settle.index') }}">
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
                        <!-- <th> التاريخ</th> -->
                        <th> المرحلة</th>

                    </tr>
                    <!-- end row -->
                </thead>
                <tbody>
                    @php $i=1; @endphp
                    @foreach ($transactions as $one_1)
                    <!-- start row -->
                     
                    <tr>
                        <td>{{ $i }}</td>
                        <td><a
                                href="{{ route('installment.show-installment', ['id' => $one_1->installment_id]) }}">{{ $one_1->installment_id }}</a>
                        </td>
                        <td>{{ $one_1->name_ar }}</td>
                        <td>{{ $one_1->civil_number }}</td>
                        <td>{{ $one_1->phone_ids }}</td>
                        <td>{{ $one_1->governorate_id }}</td>
                        <!-- <td>{{ $one_1->date }}</td> -->
                        <td>
                            
                            @if ($one_1->status == 'military')
                            {{' فتح ملف' }}
                            @elseif ($one_1->status == 'execute_alert' && $one_1->jalasat_alert_status == 'accepted')
                            {{ 'الايمج' }}
                            @elseif ($one_1->status == 'execute_alert' && $one_1->jalasat_alert_status != 'accepted')
                            {{ 'إعلان التنفيذ '}}
                            @elseif ($one_1->status == 'case_proof' && $one_1->jalasat_alert_status == 'accepted')
                            {{ 'أثبات الحالة'}}
                            @elseif (($one_1->cancel_certificate == 1) && ($one_1->stop_salary == 0) && ($one_1->job_type == 'military') )
                            {{ 'أصدار الشهادة العسكرية'}}
                            @elseif ($one_1->status == 'execute' && $one_1->stop_bank == 1 && $one_1->bank_archive ==0)
                            {{ 'حجز بنوك '}}
                            @elseif ($one_1->status == 'execute' &&  $one_1->stop_car == 1)
                            {{ 'حجز سيارات '}}
                            @elseif ($one_1->status == 'execute' &&  $one_1->stop_salary == 1 && $one_1->job_type == 'military')
                            {{ 'حجز راتب '}}
                            @elseif ($one_1->status == 'execute' && $one_1->stop_travel == 1)
                            {{ 'منع سفر '}}
                            @elseif ($one_1->paper_eqrar_dain_received == 0 && $one_1->status =='null')
                            {{ 'اقرارات الدين غير مستلمة '}}
                            @elseif ($one_1->paper_eqrar_dain_received == 1 && $one_1->status =='null')
                            {{ 'اقرارات الدين  مستلمة '}}
                            @elseif ($one_1->status =='execute')
                            {{ 'رصيد التنفيذ '}}
                            @elseif ($one_1->type =='settlement')
                            {{ 'التسوية' }}
                          
                            @endif
                        </td>
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