<div class="card mt-4 py-3">
    <div class="d-flex flex-wrap ">
        <a class=" btn-filter me-1 mb-1 bg-primary-subtle text-primary px-2  mx-1 mb-2 ">
            اجمالي قرارات الدين (1221)
        </a>
        <a class="btn-filter bg-info-subtle text-info  px-2  mx-1 mb-2">
            اجمالي المبلغ المتبقي (1221)
        </a>
        <a class="btn-filter bg-warning-subtle text-warning px-2  mx-1 mb-2">
            اجمالي المبلغ المحصل شيكات (1221)
        </a>
        <a class="btn-filter  bg-success-subtle text-success px-2  mx-1 mb-2">
            اصل الدين (1221)
        </a>
        <a class="btn-filter  bg-success-subtle text-success px-2  mx-1 mb-2">
            عدد الاستقطاعات (1221)
        </a>

        <a class="btn-filter bg-danger-subtle text-danger px-2  mx-1 mb-2">

            قيمة الاستقطاعات شهريا (1221) </a>
        <a class="btn-filter px-2 bg-primary-subtle text-primary mx-1 mb-2">
            الارباح (1221) </a>
        <a class="btn-filter bg-danger-subtle text-danger px-2  mx-1 mb-2">
            باقي اصل الدين (1221) </a>
        <a class="btn-filter me-1 mb-1  bg-warning-subtle text-warning  px-2  mx-1 mb-2 ">
            باقي الارباح (1221) </a>
    </div>
</div>


<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0">عملاء الاقساط</h4>
        <div class="d-flex">
            <a class="btn me-1 mb-1 bg-primary-subtle text-primary px-4  "
                href="{{ route('installment.finished_installments') }}">
                الارشيف </a>
            <a class="btn me-1 mb-1 bg-primary-subtle text-primary px-4  " href="{{ route('installment.excel') }}">
                تصدير عملاء الاقساط </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="card-body">
        <div class="table-responsive pb-4">
            <table id="file_export" class="table table-bordered border text-nowrap align-middle">
                <thead>
                    <!-- start row -->
                    <tr>
                        <th>#</th>
                        <th>رقم المعاملة </th>
                        <th>اسم العميل</th>
                        <th>التاريخ</th>
                        <th>اجمالي الاقساط</th>
                        <th>المقدم</th>
                        <th>عدد الاقساط</th>
                        <th> قيمة القسط الشهري</th>
                        <th> عرض التفاصيل</th>
                    </tr>
                    <!-- end row -->
                </thead>
                <tbody>
                    <!-- start row -->
                    @foreach ($Installment as $item)
                        <tr>
                            <td>
                                {{ $loop->index + 1 }}
                            </td>
                            <td>
                                <a class="text-dark" href="{{ route('installment.show-installment', ['id' => $item->id]) }}">
                                {{ $item->id }}
                                </a>
                            </td>
                            <td>
                                {{ $item->installment_client->name_ar ?? 'لا يوجد' }} <br>
                                {{ $item->client->civil_number ?? '' }}
                            </td>
                            <td>
                            {{ $item->created_at ? $item->created_at->format('Y-m-d') : 'N/A' }}

                            </td>
                            <td>
                                {{ $item->total_madionia  + $item->extra_first_amount + $item->first_amount}}
                            </td>

                            <td>
                                {{ $item->total_first_amount }}
                            </td>
                            <td>
                                {{ $item->count_months ?? 'لا يوجد' }}
                            </td>
                            <td>
                                {{ $item->monthly_amount ?? 'لا يوجد' }}
                            </td>
                            <td>

                                <div class="d-block">
{{--                                    @if(auth()->user()->hasPermission('delete_products'))--}}
                                    <div>
                                        <a class="btn me-1 mb-1 bg-primary-subtle text-primary px-4  "
                                            href="{{ route('installment.show-installment', ['id' => $item->id]) }}">
                                            عرض التفاصيل
                                        </a>
                                    </div>
{{--                                    @endif--}}
                                    <button class="btn me-1 mb-1 bg-primary-subtle text-primary px-4  "
                                        data-bs-toggle="modal" data-bs-target="#open-file">
                                        تعديل الرابط </button>
                                    <!-- sample modal content -->

                                    <div id="open-file" class="modal fade" tabindex="-1"
                                        aria-labelledby="bs-example-modal-md" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header d-flex align-items-center">
                                                    <h4 class="modal-title" id="myModalLabel">
                                                        تعديل رابط </h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                @if ($item->client_id != null)
                                                    <form
                                                        action="{{ route('installment.location', ['client_id' => $item->client_id]) }}"
                                                        method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="modal-body">


                                                            <div class="form-row">
                                                                <div class="form-group">
                                                                    <label class="form-label"
                                                                        for="google_success{{ $item->installment_client->id ?? null }}">رابط
                                                                        جوجل ماب</label>
                                                                    <input type="text"
                                                                        id="google_success{{ $item->installment_client->id ?? null }}"
                                                                        name="location_google_map"
                                                                        class="form-control mb-2"
                                                                        value="{{ $item->client->location_google_map ?? null }}">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label class="form-label"
                                                                        for="queen_success{{ $item->installment_client->id ?? null }}">كويت
                                                                        فايندر</label>
                                                                    <input type="text"
                                                                        id="queen_success{{ $item->installment_client->id ?? null }}"
                                                                        name="kwfinder" class="form-control mb-2"
                                                                        value="{{ $item->client->kwfinder ?? null }}">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label class="form-label"
                                                                        for="location{{ $item->installment_client->id ?? null }}">الاحداثيات</label>
                                                                    <input type="text"
                                                                        id="location{{ $item->installment_client->id ?? null }}"
                                                                        name="location" class="form-control mb-2"
                                                                        value="{{ $item->client->location ?? null }}">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label class="form-label"
                                                                        for="Latitude_success{{ $item->installment_client->id ?? null }}">خط
                                                                        الطول</label>
                                                                    <input type="text"
                                                                        id="Latitude_success{{ $item->installment_client->id ?? null }}"
                                                                        name="Latitude" class="form-control mb-2"
                                                                        value="{{ $item->client->Latitude ?? null }}">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label class="form-label"
                                                                        for="Longitude_success{{ $item->installment_client->id ?? null }}">دوائر
                                                                        العرض</label>
                                                                    <input type="text"
                                                                        id="Longitude_success{{ $item->installment_client->id ?? null }}"
                                                                        name="Longitude" class="form-control mb-2"
                                                                        value="{{ $item->client->Longitude ?? null }}">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label class="form-label"
                                                                        for="house_id_success{{ $item->installment_client->id ?? null }}">الرقم
                                                                        الالى</label>
                                                                    <input type="text"
                                                                        id="house_id_success{{ $item->installment_client->id ?? null }}"
                                                                        name="house_id" class="form-control mb-2"
                                                                        value="{{ $item->client->house_id ?? null }}">
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="modal-footer d-flex ">
                                                            <button type="submit" class="btn btn-primary">حفظ </button>
                                                            <button type="button"
                                                                class="btn bg-danger-subtle text-danger  waves-effect"
                                                                data-bs-dismiss="modal">
                                                                الغاء
                                                            </button>
                                                        </div>
                                                    </form>
                                                @endif
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    {{-- <div id="bs-example-modal-md" class="modal fade" tabindex="-1"
                      aria-labelledby="bs-example-modal-md" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-scrollable modal-lg">
                        <div class="modal-content">
                          <div class="modal-header d-flex align-items-center">
                            <h4 class="modal-title" id="myModalLabel">
                              تعديل الرابط </h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                              aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <form>
                              <div class="form-row">
                                <div class="form-group">
                                  <label class="mb-2" for="inputAddress">رابط جوجل ماب</label>
                                  <input type="text" class="form-control mb-2" id="inputAddress">
                                </div>
                                <div class="form-group">
                                  <label class="mb-2" for="inputAddress2 ">كويت فايندر</label>
                                  <input type="text" class="form-control mb-2" id="inputAddress2">
                                </div>
                                <div class="form-group">
                                  <label class="mb-2" for="inputAddress2 "> الاحداثيات</label>
                                  <input type="text" class="form-control mb-2" id="inputAddress2">
                                </div>

                                <div class="form-group">
                                  <label class="mb-2" for="inputAddress2 ">خطوط الطول </label>
                                  <input type="text" class="form-control mb-2" id="inputAddress2">
                                </div>
                                <div class="form-group">
                                  <label class="mb-2" for="inputAddress2 ">دوائر العرض </label>
                                  <input type="text" class="form-control mb-2" id="inputAddress2">
                                </div>
                                <div class="form-group">
                                  <label class="mb-2" for="inputAddress2 "> الرقم الالي </label>
                                  <input type="text" class="form-control mb-2" id="inputAddress2">
                                </div>


                              </div>
                            </form>
                          </div>
                          <div class="modal-footer d-flex ">
                            <button type="submit" class="btn btn-primary">حفظ</button>
                            <button type="button" class="btn bg-danger-subtle text-danger  waves-effect"
                              data-bs-dismiss="modal">
                              الغاء
                            </button>
                          </div>
                        </div>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div> --}}
                                </div>


                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>
</div>


<script>
    //     function getlatlong2(id) {
    //     const isValid = checkvalidlocation(id);
    //     const loc = document.getElementById(`google_success${id}`).value;

    //     if (isValid) {
    //         $.ajax({
    //             type: 'POST',
    //             url: '/get-coordinates', // replace with actual route
    //             data: { loc: loc },
    //             success: function(data) {
    //                 const result = JSON.parse(data);
    //                 if (result.length !== 0) {
    //                     document.getElementById(`Longitude_success${id}`).value = result.lat;
    //                     document.getElementById(`Latitude_success${id}`).value = result.long;
    //                 } else {
    //                     document.getElementById(`Longitude_success${id}`).value = '';
    //                     document.getElementById(`Latitude_success${id}`).value = '';
    //                 }
    //             },
    //             error: function() {
    //                 alert('Error fetching coordinates.');
    //             }
    //         });
    //     } else {
    //         alert('رابط جوجل غير صحيح من فضلك قم بتعديله.');
    //         document.getElementById(`google_success${id}`).value = '';
    //     }
    // }

    // function checkvalidlocation(id) {
    //     const loc = document.getElementById(`google_success${id}`).value;
    //     const url = new URL(loc);
    //     return url.host === 'www.google.com';
    // }

    setTimeout(function() {
        document.querySelector('.alert-success').style.display = 'none';
    }, 5000); // Adjust time as needed (5000ms = 5 seconds)
</script>
