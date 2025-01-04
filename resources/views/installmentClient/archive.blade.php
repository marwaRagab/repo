<div class="card">
    <div class="card mt-4 py-3">
        <div class="d-flex flex-wrap ">
            <a class=" btn-filter me-1 mb-1 bg-primary-subtle text-primary px-4  mx-1 mb-2 ">

                @if (request()->route('status') === 'submit_archiveCount')
                    العدد الكلي ({{ $data['counts']['submit_archiveCount'] }})
                @else
                    العدد الكلي ({{ $data['counts']['accepted_archiveCount'] }})
                @endif

            </a>

        </div>
    </div>
</div>

<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0"> الارشيف </h4>
        <div class="d-flex">
            <a class="btn me-1 mb-1 bg-primary-subtle text-primary px-4  " href="./intermediaries.html">
                الوسطاء </a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive pb-4">
            <table id="all-student" class="table table-bordered border text-nowrap align-middle">
                <thead>
                    <!-- start row -->
                    <tr>
                        <th>#</th>
                        <th>اسم العميل</th>
                        <th>الوسيط </th>
                        <th>الراتب </th>
                        <th>الوظيفة</th>
                        <th>استعلام قضائي </th>
                        <th>استعلام سيارات</th>
                        <th>مجموع الاقساط</th>
                        <th>سبب الارشفه </th>
                        <th> الملاحظات</th>
                    </tr>
                    <!-- end row -->
                </thead>
                <tbody>

                    <!-- start row -->
                    @if ($data['Installment']->count() == 0)
                        <p>لا يوجد داتا متوفرة</p>
                    @else
                        @foreach ($data['Installment'] as $item)
                            <tr>

                                <td>
                                    {{ $item->id }}
                                </td>
                                <td>
                                    {{ $item->name_ar }}
                                </td>
                                <td>{{ $item->boker->name_ar }}</td>
                                <td>
                                    {{ $item->salary }}
                                </td>
                                <td>
                                    {{ $item->ministry_working->name_ar }}
                                </td>
                                <td>
                                    <a class="btn btn-secondary w-100 mt-2"data-bs-toggle="modal"
                                        data-bs-target="#done">

                                        تم الاستعلام</a>
                                    <div id="done" class="modal fade" tabindex="-1"
                                        aria-labelledby="bs-example-modal-md" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header d-flex align-items-center">
                                                    <h4 class="modal-title mt-2" id="myModalLabel">
                                                        القضايا</h4>

                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <h5 class="mb-4 text-warning"> عفوا لا يوجد قضايا</h5>
                                                    <div class="d-flex flex-wrap ">
                                                        <a
                                                            class="  me-1 mb-1 bg-primary-subtle text-primary px-4  mx-1 mb-2 ">
                                                            المفتوحة :
                                                            {{ $item->installment_issue->sum('opening_amount') }}
                                                            د.ك
                                                        </a>
                                                        <a class=" bg-success-subtle text-success  px-4  mx-1 mb-2">
                                                            المغلقة :
                                                            {{ $item->installment_issue->sum('closing_amount') }}
                                                            د.ك
                                                        </a>
                                                        <a class=" bg-warning-subtle text-warning px-4  mx-1 mb-2">
                                                            الإجمالي :
                                                            {{ $item->installment_issue->sum('closing_amount') + $item->installment_issue->sum('opening_amount') }}
                                                            د.ك
                                                        </a>
                                                    </div>
                                                    <table id="notes1"
                                                        class="table table-bordered border text-wrap align-middle">
                                                        <thead>
                                                            <!-- start row -->
                                                            <tr>
                                                                <th>اليوزر</th>
                                                                <th>رقم القضية</th>
                                                                <th>الحالة</th>
                                                                <th>الجهه</th>
                                                                <th> المبلغ المفتوح</th>
                                                                <th> المبلغ المغلق</th>
                                                                <th>التاريخ</th>
                                                                <th> صوره القضية</th>
                                                            </tr>
                                                            <!-- end row -->
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($item->installment_issue as $case)
                                                                <!-- start row -->
                                                                <tr data-bs-toggle="collapse"
                                                                    data-bs-target="#collapseExample"
                                                                    aria-expanded="false"
                                                                    aria-controls="collapseExample">
                                                                    <td>
                                                                        {{ $case->user->name_ar ?? 'لا يوجد' }}
                                                                    </td>
                                                                    <td>
                                                                        {{ $case->number_issue }}
                                                                    </td>
                                                                    <td>
                                                                        {{ $case->status }}
                                                                    </td>
                                                                    <td>
                                                                        {{ $case->working_company }}
                                                                    </td>
                                                                    <td>
                                                                        {{ $case->opening_amount }}
                                                                    </td>
                                                                    <td>
                                                                        {{ $case->closing_amount }}
                                                                    </td>
                                                                    <td>
                                                                        {{ $case->date }}
                                                                    </td>
                                                                    <td>
                                                                        <a href="#" class="text-info"
                                                                            onclick="toggleImage('{{ $case->image }}', this); return false;">صورة
                                                                            القضية</a>
                                                                        <div class="expandable-image mt-2"
                                                                            style="display: none;">
                                                                            <img src="{{ $case->image }}"
                                                                                alt="صورة القضية" class="img-fluid"
                                                                                style="max-width: 100%; max-height: 300px;">
                                                                        </div>
                                                                    </td>

                                                                </tr>
                                                            @endforeach

                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="modal-footer d-flex ">
                                                    {{-- <button type="submit" class="btn btn-primary">ارسال </button> --}}
                                                    <button type="button"
                                                        class="btn bg-danger-subtle text-danger  waves-effect"
                                                        data-bs-dismiss="modal">
                                                        الغاء
                                                    </button>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                    </div>
                                </td>

                                <td>

                                    <a class="btn btn-secondary w-100 mt-2"data-bs-toggle="modal"
                                        data-bs-target="#done-2">

                                        تم الاستعلام</a>
                                    <div id="done-2" class="modal fade" tabindex="-1"
                                        aria-labelledby="bs-example-modal-md" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header d-flex align-items-center">
                                                    <h4 class="modal-title mt-2" id="myModalLabel">
                                                        السيارات
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <h5 class="mb-4 text-warning"> عفوا لا يوجد سيارات</h5>
                                                    <div class="d-flex flex-wrap ">
                                                        {{-- <a
                                                    class="  me-1 mb-1 bg-primary-subtle text-primary px-4  mx-1 mb-2 ">
                                                    المفتوحة : {{$item->installment_car->sum('opening_amount')}} د.ك
                                                </a>
                                                <a class=" bg-success-subtle text-success  px-4  mx-1 mb-2">
                                                    المغلقة : 2276.000 د.ك
                                                </a> --}}
                                                        <a class=" bg-warning-subtle text-warning px-4  mx-1 mb-2">
                                                            الإجمالي :
                                                            {{ $item->installment_car->sum('average_price') }}
                                                            د.ك
                                                        </a>
                                                    </div>
                                                    <table id="notes1"
                                                        class="table table-bordered border text-wrap align-middle">
                                                        <thead>
                                                            <!-- start row -->
                                                            <tr>
                                                                <th>اليوزر</th>
                                                                <th> نوغ السيارة</th>
                                                                <th>السنة</th>
                                                                <th>المبلغ</th>
                                                                <th>التاريخ</th>
                                                                <th> صوره السيارة</th>
                                                            </tr>
                                                            <!-- end row -->
                                                        </thead>
                                                        <tbody>

                                                            @foreach ($item->installment_car as $car)
                                                                <!-- start row -->
                                                                <tr data-bs-toggle="collapse"
                                                                    data-bs-target="#collapseExample"
                                                                    aria-expanded="false"
                                                                    aria-controls="collapseExample">
                                                                    <td>
                                                                        {{ $car->user->name_ar ?? 'لايوجد' }}
                                                                    </td>
                                                                    <td>
                                                                        {{ $car->type_car ?? 'لايوجد' }}
                                                                    </td>
                                                                    <td>
                                                                        {{ $car->model_year ?? 'لايوجد' }}
                                                                    </td>
                                                                    <td>
                                                                        {{ $car->average_price ?? 'لايوجد' }}
                                                                    </td>
                                                                    <td>
                                                                        {{ $car->created_at ? $car->created_at->format('Y-m-d') : 'لايوجد' }}
                                                                    </td>
                                                                    <td>
                                                                        <a href="#" class="text-info"
                                                                            onclick="toggleImage('{{ $car->image }}', this); return false;">صورة
                                                                            السيارة</a>
                                                                        <div class="expandable-image mt-2"
                                                                            style="display: none;">
                                                                            <img src="{{ $car->image }}"
                                                                                alt="صورة السيارة" class="img-fluid"
                                                                                style="max-width: 100%; max-height: 300px;">
                                                                        </div>
                                                                    </td>

                                                                </tr>
                                                            @endforeach

                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="modal-footer d-flex ">
                                                    {{-- <button type="submit" class="btn btn-primary">ارسال </button> --}}
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


                                </td>
                                <td>
                                    {{ $item->installment_total }}
                                </td>
                                <td>
                                    {{ $item->reason ?? 'لايوجد' }}
                                </td>
                                <td>
                                    <div class="block">
                                        {{-- <h5>01022</h5> --}}
                                        <a class="btn btn-secondary w-100 mt-2"  href="{{ route('advanced.notes',  $item->id) }}">

                                            الملاحظات</a>
                                    </div>


                                </td>
                            </tr>
                        @endforeach
                    @endif




                </tbody>
            </table>
        </div>
    </div>
</div>



<!-- modals  -->




<script>
    function toggleImage(imageUrl, link) {
        // Find the expandable image container
        const imageContainer = link.nextElementSibling;

        // Toggle display of the image container
        if (imageContainer.style.display === 'none') {
            imageContainer.style.display = 'block';
        } else {
            imageContainer.style.display = 'none';
        }
    }
</script>
