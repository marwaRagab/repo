<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0"> تعديل بيانات عميل
        </h4>
    </div>
    <div class="card-body">
        <form class="mega-vertical"
              action="{{url('installment/upload_edit_images')}}" method="post"
              enctype="multipart/form-data">
            @csrf

            <input  type="hidden" value="{{$id}}"  name="installment_id" >
            <div class="form-row row">
                <div class="form-group mb-3 col-md-4 col-sm-6">
                    <label for="debtStatement" class="form-label">اقرار الدين</label>
                    <input type="file" name="qard_paper_img" class="form-control" id="debtStatement">
                </div>

                <div class="form-group mb-3 col-md-4 col-sm-6">
                    <label for="salaryCertificate" class="form-label">صورة شهادة الراتب</label>
                    <input type="file" name="salary_img" class="form-control" id="salaryCertificate">
                </div>

                <div class="form-group mb-3 col-md-4 col-sm-6">
                    <label for="civilIdFront" class="form-label">صورة البطاقة المدنية وجه</label>
                    <input type="file"  name="cid_img1" class="form-control" id="civilIdFront">
                </div>

                <div class="form-group mb-3 col-md-4 col-sm-6">
                    <label for="civilIdBack" class="form-label">صورة البطاقة المدنية ظهر</label>
                    <input type="file"  name="cid_img_2" class="form-control" id="civilIdBack">
                </div>

                <div class="form-group mb-3 col-md-4 col-sm-6">
                    <label for="assignmentInquiry" class="form-label">صورة إستعلام اساينيت</label>
                    <input type="file" name="cinet_img" class="form-control" id="assignmentInquiry">
                </div>

                <div class="form-group mb-3 col-md-4 col-sm-6">
                    <label for="workId" class="form-label">صورة هوية العمل</label>
                    <input type="file" name="work_img" class="form-control" id="workId">
                </div>

                <div class="form-group mb-3 col-md-4 col-sm-6">
                    <label for="myId" class="form-label">هويتى</label>
                    <input type="file" name="my_img" class="form-control" id="myId">
                </div>

                <div class="form-group mb-3 col-md-4 col-sm-6">
                    <label for="firstContract" class="form-label">صورة العقد الاول</label>
                    <input type="file" name="contract_1" class="form-control" id="firstContract">
                </div>

                <div class="form-group mb-3 col-md-4 col-sm-6">
                    <label for="secondContract" class="form-label">صورة العقد الثانى</label>
                    <input type="file"  name="contract_2"  class="form-control" id="secondContract">
                </div>

                <div class="form-group mb-3 col-md-4 col-sm-6">
                    <label for="saintContract1" class="form-label">عقد الساينت 1</label>
                    <input type="file" name="contract_cinet_1" class="form-control" id="saintContract1">
                </div>

                <div class="form-group mb-3 col-md-4 col-sm-6">
                    <label for="saintContract2" class="form-label">عقد الساينت 2</label>
                    <input type="file"  name="contract_cinet_2" class="form-control" id="saintContract2">
                </div>

                <div class="form-group mb-3 col-md-4 col-sm-6">
                    <label for="productReceipt" class="form-label">استلام المنتجات</label>
                    <input type="file" name="prods_recieved_img" class="form-control" id="productReceipt">
                </div>

                <div class="form-group mb-3 col-md-4 col-sm-6">
                    <label for="civilImage" class="form-label">صورة المدنية</label>
                    <input type="file"  name="civil_img" class="form-control" id="civilImage">
                </div>

                <div class="form-group mb-3 col-md-4 col-sm-6">
                    <label for="guarantorReceipt" class="form-label">وصل امانة الكفيل</label>
                    <input type="file"  name="kafil_amana"  class="form-control" id="guarantorReceipt">
                </div>

                <div class="form-group mb-3 col-md-4 col-sm-6">
                    <label for="legalInquiry" class="form-label">الاستعلام القضائى</label>
                    <input type="file" name="laws_paper_print_img" class="form-control" id="legalInquiry">
                </div>

                <div class="form-group mb-3 col-md-4 col-sm-6">
                    <label for="deductionCertificate" class="form-label">شهادة الاستقطاع</label>
                    <input type="file" name="part_paper" class="form-control" id="deductionCertificate">
                </div>

                <div class="form-group mb-3 col-md-4 col-sm-6">
                    <label for="deductionFee" class="form-label">رسوم الاستقطاع</label>
                    <input type="file"  name="part_10_dinar_img" class="form-control" id="deductionFee">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">إرسال</button>
        </form>
    </div>
</div>
