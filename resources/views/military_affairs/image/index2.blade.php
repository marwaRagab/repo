<div class="card mt-4 py-3">
  <div class="d-flex flex-wrap ">
    <a class="btn-filter bg-warning-subtle text-warning px-4 fs-4 mx-1 mb-2">
      العدد الكلي (5857)
    </a>
    <a class="btn-filter  bg-success-subtle text-success px-4 fs-4 mx-1 mb-2">
      محكمة الجهراء (5)
    </a>
    <a class="btn-filter  bg-success-subtle text-success px-4 fs-4 mx-1 mb-2">
      محكمة مبارك الكبير
      (0) </a>

    <a class="btn-filter bg-danger-subtle text-danger px-4 fs-4 mx-1 mb-2">

      محكمة الأحمدي
      (0) </a>
    <a class="btn-filter px-4 bg-primary-subtle text-primaryfs-4 mx-1 mb-2">
      محكمة حولي (1)
    </a>
    <a class="btn-filter bg-danger-subtle text-danger px-4 fs-4 mx-1 mb-2">
      محكمةالرقعي (1)
    </a>
    <a class="btn-filter me-1 mb-1  bg-warning-subtle text-warning  px-4 fs-4 mx-1 mb-2 ">
      محكمة قصر العدل (2)
    </a>
  </div>
</div>
<div class="card">
  <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
    <h4 class="card-title mb-0">فتح ملف</h4>
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
          <th> رقم الهاتف</th>
          <th>تاريخ البدء </th>
          <th> نوع الضمانات
          </th>
          <th>المبلغ </th>
          <th> فتح ملف </th>
          <th> المحكمة</th>
          <th> الإجراءات </th>

        </tr>
        <!-- end row -->
      </thead>
      <tbody>
        <!-- start row -->
        <tr data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false"
          aria-controls="collapseExample">
          <td>
            1
          </td>
          <td>
            احمد
          </td>
          <td>25/05/2012 </td>
          <td>12</td>
          <td>123 9988568</td>
          <td>2</td>
          <td>
            1232212
          </td>

          <td>

            <button class="btn me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4 " data-bs-toggle="modal"
              data-bs-target="#open-file">
              فتح ملف </button>
            <!-- sample modal content -->
            <div id="open-file" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md"
              aria-hidden="true">
              <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                  <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="myModalLabel">
                      فتح ملف </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                      aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <h6><span class="fw-semibold">
                        الإسم :
                      </span>
                      علي سعيد مجيد عبد الواحد
                    </h6>
                    <p>
                      <span class="fw-semibold">
                        عنوان السكن :

                      </span>
                      المنطقة : حولي - قطعة : 6- شارع : علي محمد خان -
                      مبني : 3414- الرقم الآلي : 17550172
                    </p>
                    <form>
                      <div class="form-row">
                        <div class="form-group">
                          <label class="form-label"> الجهة</label>
                          <select class="form-select">
                            <option value="6">
                              محكمة الجهراء
                            </option>
                            <option value="3">
                              محكمة مبارك الكبير
                            </option>
                            <option value="4">
                              محكمة الأحمدى
                            </option>
                            <option selected="" value="2 ">
                              محكمة حولي
                            </option>
                            <option value="5">محكمة الرقعي</option>
                            <option value=" 1">
                              محكمة قصر العدل
                            </option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label class="form-label" for="input1 "> تاريخ فتح الملف </label>
                          <input type="date" class="form-control mb-2" id="input1">
                        </div>
                        <div class="form-group">
                          <label class="form-label" for="input2 ">الرقم الآلي للقضية
                          </label>
                          <input type="text" class="form-control mb-2" id="input2">
                        </div>

                      </div>
                    </form>
                  </div>
                  <div class="modal-footer d-flex ">
                    <button type="submit" class="btn btn-primary">حفظ وتحويل لأعلان التنفيذ</button>
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
          </td>
          <td>
            محكمةالرقعي
          </td>
          <td>

          </td>
        </tr>
        <!-- <tr>
            <div class="collapse" id="collapseExample">
              <div class="card card-body">
                Anim pariatur cliche reprehenderit, enim eiusmod high
                life accusamus terry richardson ad squid. Nihil anim
                keffiyeh helvetica, craft beer labore wes anderson cred
                nesciunt sapiente ea proident.
              </div>
            </div>
        </tr> -->
      </tbody>
    </table>

  </div>

</div>
</div>