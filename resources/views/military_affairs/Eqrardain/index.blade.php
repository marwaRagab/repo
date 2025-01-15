

<div class="card mt-4 py-3">
    <div class="d-flex flex-wrap ">
        <a href="{{route('eqrardain')}}"    class="btn-filter bg-warning-subtle text-warning px-4  mx-1 mb-2">
            فعال </a>
        <a   href="{{route('eqrardain',array('eqrardain_type' =>'requre_cancel'))}}"   class="btn-filter  bg-success-subtle text-success px-4  mx-1 mb-2">
            مطلوب إلغاؤه </a>
        <a   href="{{route('eqrardain',array('eqrardain_type' =>'canceled'))}}"  class="btn-filter  bg-primary-subtle text-primary px-4  mx-1 mb-2">
            ملغي </a>
    </div>
</div>
<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0">إقرارات الدين </h4>
        <div class="button-group">
            {{--<button class="btn me-1 mb-1 bg-primary-subtle text-primary px-4  " data-bs-toggle="modal"
                    data-bs-target="#add">
                أضف إقرار دين </button>--}}
            <button class="btn me-1 mb-1 bg-success-subtle text-success px-4  " data-bs-toggle="modal"
                    data-bs-target="#data">
                الإحصائيات</button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive pb-4">
            <table id="all-student" class="table table-bordered border text-nowrap align-middle">
                <thead>
                <!-- start row -->
                <tr>
                    <th>#</th>
                    <th>الاسم</th>
                    <th>الرقم المدني</th>
                    <th> القسم</th>
                    <th>مبلغ إقرار الدين</th>
                    <th> جهة الإقرار
                    </th>
                    <th>الرقم </th>
                    <th> الصورة</th>
                    <th> مطلوب إلغاؤه</th>
                </tr>
                <!-- end row -->
                </thead>
                <tbody>
                <!-- start row -->


                @foreach($items as $item)

                    <tr data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false"
                        aria-controls="collapseExample">
                        <td>
                            {{ $loop->index + 1 }}

                        </td>
                        <td>
                        {{$item->client->name_ar}}
                        </td>

                        <td>
                            {{$item->client->civil_number}}
                        </td>
                        <td>الأقساط</td>
                        <td> {{$item->eqrardain_amount}}</td>
                        <td> {{$item->qard_place}}</td>
                        <td> {{$item->qard_number}}</td>

                        <td>
                            <a class="btn btn-primary" href="{{isset($item->qard_paper)?url($item->qard_paper):'#'}}">صورة</a>
                        </td>
                        <td>
                            <a class="btn btn-success me-6" href="{{url('please_cancel_eqrar/'.$item->id)}}">
                                مطلوب إلغاؤه</a>
                        </td>
                    </tr>




                @endforeach


                </tbody>
            </table>

        </div>
    </div>
</div>
<div id="add" class="modal fade" tabindex="-1" aria-labelledby="add" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myModalLabel">
                    أضف إقرار دين</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-row">
                        <div class="form-group ">
                            <label class="form-label">اسم العميل</label>
                            <select class="form-select">
                                <option>تقى</option>
                                <option>حسن</option>
                                <option>رافت</option>
                                <option>احمد</option>
                            </select>
                        </div>
                        <div class="form-group my-3">
                            <label for="formFile" class="form-label">إقرار الدين</label>
                            <input class="form-control" type="file" id="formFile">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="input1 "> مبلغ إقرار الدين </label>
                            <input type="text" class="form-control mb-2" id="input1">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="input2 "> جهة التوثيق </label>
                            <input type="text" class="form-control mb-2" id="input2">
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer d-flex ">
                <button type="submit" class="btn btn-primary">حفظ</button>
                <button type="button" class="btn bg-danger-subtle text-danger  waves-effect" data-bs-dismiss="modal">
                    الغاء
                </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div id="data" class="modal fade" tabindex="-1" aria-labelledby="data" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myModalLabel">
                    أضف منطقة</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex flex-wrap justify-content-center gap-3">
                <div class="p-3 border rounded-2 mb-3 bg-success-subtle text-success w-25">
                        <p> {{$eqrar_all}} د.ك </p>
                        <h6>اجمالى اقرارات الدين
                        </h6>
                    </div>
                    <div class="p-3 border rounded-2 mb-3 bg-warning-subtle text-warning  w-25">
                        <p> {{$reminder}} د.ك </p>
                        <h6>اجمالى المبلغ المتبقى

                        </h6>
                    </div>
                    <div class="p-3 border rounded-2 mb-3 bg-primary-subtle text-primary  w-25">
                        <p> {{$eqrar_2023}} د.ك </p>
                        <h6>اجمالى اقرارات الدين 2023

                        </h6>
                    </div>
                    <div class="p-3 border rounded-2 mb-3 bg-danger-subtle text-danger  w-25">
                        <p> {{$amount_military_affairs}} د.ك </p>
                        <h6>اجمالى مبالغ المحولين للشئون

                        </h6>
                    </div>
                    <div class="p-3 border rounded-2 mb-3 bg-info-subtle text-info  w-25">
                        <p> {{$installment_military_affairs_2023}} د.ك </p>
                        <h6>اجمالى مبالغ المحولين للشئون2023
                        </h6>
                    </div>
                    <div class="p-3 border rounded-2 mb-3 bg-success-subtle text-success  w-25">
                        <p>  {{$items_not_laws}} د.ك </p>
                        <h6> اجمالى مبالغ غير المحولين للشئون
                        </h6>2023
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex ">
                <button type="button" class="btn bg-danger-subtle text-danger  waves-effect" data-bs-dismiss="modal">
                    إغلاق
                </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
