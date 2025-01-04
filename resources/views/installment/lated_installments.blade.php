<div class="card mt-4 py-3">
    <div class="d-flex flex-wrap ">
        <a class=" btn-filter me-1 mb-1 bg-primary-subtle text-primary px-2  mx-1 mb-2 ">
            الكل </a>
        <a class="btn-filter bg-info-subtle text-info  px-2  mx-1 mb-2">
            استقطاع الشركة </a>
        <a class="btn-filter bg-warning-subtle text-warning px-2  mx-1 mb-2">
            الاستقطاع الشخصي </a>
        <a class="btn-filter  bg-success-subtle text-success px-2  mx-1 mb-2">
            دفع يدوي </a>


    </div>
</div>

<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0"> العملاء المتأخرون</h4>
        <!-- <div class="d-flex">
        <a class="btn me-1 mb-1 bg-primary-subtle text-primary px-4  " href="./installment-archive.html">
          الارشيف </a>
        <a class="btn me-1 mb-1 bg-primary-subtle text-primary px-4  "
          href="./transfer-admin-installments.html">
          تصدير عملاء الاقساط </a>
      </div> -->
    </div>


    <div class="card-body">
        <div class="table-responsive pb-4">
            <table id="all-student" class="table table-bordered border text-nowrap align-middle">
                <thead>
                    <!-- start row -->
                    <tr>
                        <th>#</th>
                        <th>رقم المعاملة </th>
                        <th>الرقم المدني </th>
                        <th>اسم العميل</th>
                        <th> طريقة الدفع </th>
                        <th> اسم البنك </th>
                        <th> الوزارة </th>
                        <th>بداية المعاملة </th>
                        <th>اخر دفع</th>
                        <th> الاقساط المتأخرة</th>
                        <th>المبالغ المتأخرة</th>
                        <th> الاقساط المدفوعة</th>
                        <th> المبالغ المدفوعة</th>

                        <th> روابط </th>
                    </tr>
                    <!-- end row -->
                </thead>
                <tbody>

                    @foreach ($data['Installment'] as $item)

                    <tr>
                        <td></td>
                        <td>
                            {{$item->id}}
                        </td>
                        <td> {{$item->client->civil_number ?? 'لايوجد'}} </td>
                        <td>
                            {{$item->client->name_ar ?? 'لايوجد'}}
                        </td>

                        <td>
                            <div class="bg-primary text-white p-2">
                                دفع يدوى
                            </div>
                            </td>
                        <td>{{$item->client->bank->name_ar ?? 'لايوجد'}}</td>
                        <td> {{$item->client->ministry->name_ar ?? 'لايوجد'}}</td>
                       {{-- {{ dd($item->installment_months)}} --}}
                        <td>
                            {{$item->installment_months['0']->date ?? 'لايوجد'}}
                        </td>
                        <td>
                            {{$item->installment_months->firstWhere('status', 'done')->date ?? 'لايوجد'}}

                        </td>

                        <td>{{ $item->installment_months->where('status', 'not_done')->where('date', '<', \Carbon\Carbon::now())->count() }}
                      <p>   <a href="{{url('installment/warning_print_paper/'.$item->id)}}">طباعة الانذار القضائى</a></p>
                        </td>

                        <td>{{ $item->installment_months->where('status', 'not_done')->where('date', '<', \Carbon\Carbon::now())->sum('amount') }}</td>
                        <td>
                            {{ $item->installment_months->where('status', 'done')->where('date', '<', \Carbon\Carbon::now())->count() }}
                        </td>
                        <td>{{ $item->installment_months->where('status', 'done')->where('date', '<', \Carbon\Carbon::now())->sum('amount') }}</td>
                        <td>
                            {{-- <div class="d-block">
                                <div>
                                    <a class="btn me-1 mb-1 bg-primary-subtle text-primary px-4  "
                                        href="./show-installment.html">
                                        عرض التفاصيل
                                    </a>
                                </div>
                                <button class="btn me-1 mb-1 bg-primary-subtle text-primary px-4  "
                                    data-bs-toggle="modal" data-bs-target="#bs-example-modal-md">
                                    تعديل الرابط </button>
                                <!-- sample modal content -->
                                <div id="bs-example-modal-md" class="modal fade" tabindex="-1"
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
                                                            <label class="mb-2" for="inputAddress">رابط جوجل
                                                                ماب</label>
                                                            <input type="text" class="form-control mb-2"
                                                                id="inputAddress">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="mb-2" for="inputAddress2 ">كويت
                                                                فايندر</label>
                                                            <input type="text" class="form-control mb-2"
                                                                id="inputAddress2">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="mb-2" for="inputAddress2 ">
                                                                الاحداثيات</label>
                                                            <input type="text" class="form-control mb-2"
                                                                id="inputAddress2">
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="mb-2" for="inputAddress2 ">خطوط الطول
                                                            </label>
                                                            <input type="text" class="form-control mb-2"
                                                                id="inputAddress2">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="mb-2" for="inputAddress2 ">دوائر العرض
                                                            </label>
                                                            <input type="text" class="form-control mb-2"
                                                                id="inputAddress2">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="mb-2" for="inputAddress2 "> الرقم الالي
                                                            </label>
                                                            <input type="text" class="form-control mb-2"
                                                                id="inputAddress2">
                                                        </div>


                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer d-flex ">
                                                <button type="submit" class="btn btn-primary">حفظ</button>
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
                            </div> --}}

                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                   روابط
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    {{-- <li><a class="dropdown-item" href="#" onclick="return false;">الاتصال</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="return false;">موعد</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="return false;">السماح</a></li> --}}
                                    <li><a class="dropdown-item" href="{{ route('installment.show-installment', $item->id) }}" onclick="return false;">التفاصيل والدفع</a></li>
                                    <li><a class="dropdown-item" href="{{ route('military_affairs.convert', $item->id) }}">تحويل شئون القانونية</a></li>
                                    {{-- <li><a class="dropdown-item" href="#" onclick="return false;">تحويل للمتعسرين</a></li> --}}
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    <!-- start row -->


                </tbody>
            </table>
        </div>
    </div>
</div>
