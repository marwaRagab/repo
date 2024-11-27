<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0"> العهده <span class="text-info"> (تامر عبدالعظيم )</span></h4>
        <div class="d-flex">
            <a class="btn me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4 " href="./invoices.html">
                الرسوم الادارية </a>
            <a class="btn me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4 " href="./fees.html">
                العهد </a>
            <button class="btn me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4 " data-bs-toggle="modal"
                data-bs-target="#bs-example-modal-md">
                أضف مبلغ جديد </button>
        </div>
        <!-- sample modal content -->
        <div id="bs-example-modal-md" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header d-flex align-items-center">
                        <h4 class="modal-title" id="myModalLabel">
                            أضف مبلغ جديد</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label" for="input1 "> المبلغ </label>
                                    <input type="text" class="form-control mb-2" id="input1">
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="input2 ">صورة </label>
                                    <input type="file" class="form-control mb-2" id="input2">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">النوع</label>
                                    <select class="form-select">
                                        <option>النوع</option>
                                        <option>النوع</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="input2 ">الوصف </label>
                                    <input type="text" class="form-control mb-2" id="input2">
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
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive pb-4">
            <table id="all-student" class="table table-bordered border text-nowrap align-middle">
                <thead>
                    <!-- start row -->
                    <tr>
                        <th>#</th>
                        <th> الرصيد </th>
                        <th>داخل </th>
                        <th>خارج</th>
                        <th> التفاصيل</th>
                        <th> التاريخ</th>
                        <th> صورة المستند</th>

                        <th>حذف</th>

                    </tr>
                    <!-- end row -->
                </thead>
                <tbody>
                    <!-- start row -->
                    <tr>
                        <td>
                            1
                        </td>
                        <td>
                            1
                        </td>
                        <td>
                            1
                        </td>
                        <td>
                            تقى
                        </td>
                        <td>touka</td>
                        <td>القاهرة</td>
                        <td>
                            <img src="../assets/images/image.jpg" height="50" alt="">
                        </td>
                        <td>
                            <a href="javascript:void(0)" class="text-dark delete ms-2">
                                <i class="ti ti-trash fs-5"></i>
                            </a>
        </div>
        </td>
        </tr>

        </tbody>
        </table>
    </div>
</div>