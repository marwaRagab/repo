<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0"> تعديل بيانات عميل
        </h4>
    </div>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif





    <div class="card-body">
        <form class="mega-vertical"
              action="{{url('installment/upload_papers')}}" method="post"
              enctype="multipart/form-data">
            @csrf
            <div class="form-row row">
                <!-- Contract Image 1 with Print Button -->
                <div class="form-group mb-3 col-md-6">
                    <label for="contractImage1" class="form-label">صورة العقد (1)</label>
                    <div class="d-flex align-items-center">
                        <input type="file" class="form-control" id="contractImage1" name="contract_1" >
                        <a href="{{url('installment/print_contrct/'.$item['id'])}}" class="btn btn-secondary me-3">طباعةالعقد </a>
                    </div>
                </div>

                <!-- Contract Image 2 -->

                <input type="hidden" name="installment_id" value="{{$item['id']}}" >
                <div class="form-group mb-3 col-md-6">
                    <label for="contractImage2" class="form-label">صورة العقد (2)</label>
                    <input type="file"  name="contract_2"  class="form-control" id="contractImage2">
                </div>

                <!-- Saint Contract Image 1 with Print Button -->
                <div class="form-group mb-3 col-md-6">
                    <label for="saintContractImage1" class="form-label">صورة عقد الساينت (1)</label>
                    <div class="d-flex align-items-center">
                        <input type="file" class="form-control" name="contract_cinet_1"  id="saintContractImage1">
                        <button type="button" class="btn btn-secondary me-3"> عقد الساينت </button>
                    </div>
                </div>

                <!-- Saint Contract Image 2 -->
                <div class="form-group mb-3 col-md-6">
                    <label for="saintContractImage2" class="form-label"> عقد الساينت (2)</label>
                    <input type="file" class="form-control" name="contract_cinet_2" id="saintContractImage2">
                </div>

                <!-- Product Receipt Image with Print Button -->
                <div class="form-group mb-3 col-md-6">
                    <label for="productReceiptImage" class="form-label">صورة استلام المنتجات</label>
                    <div class="d-flex align-items-center">
                        <input type="file" class="form-control" name="prods_recieved_img" id="productReceiptImage">
                        <a type="button"  href="" class="btn btn-secondary me-3 ">  صورة استلام المنتجات </a>

                    </div>
                </div>

                <!-- Debt Statement Image -->
                <div class="form-group mb-3 col-md-6">
                    <label for="debtStatementImage" class="form-label">صورة اقرار الدين</label>
                    <input type="file" class="form-control"  name="qard_paper_img" id="debtStatementImage">
                </div>
            </div>

            <button type="submit" class="btn btn-primary">انهاء المعاملة</button>
        </form>
    </div>
</div>
