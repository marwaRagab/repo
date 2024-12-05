<form method="POST" action="{{ route('company.update', $company->id) }}">
    @csrf
    @method('PUT')
    <div class="card">

        <div class="card-body">
            <h5 class="mb-4">إضافة جديد
            </h5>
            <div class="row form-rows">
                <div class="form-group col-md-6 mb-4">
                    <label for="companyName"> اسم الشركة بالعربي</label>
                    <input type="text" class="form-control" name="name_ar" id="companyName"
                        value="{{ $company->name_ar }}">
                </div>
                <div class="form-group col-md-6 mb-4">
                    <label for="companyName"> اسم الشركة بالانجليزي</label>
                    <input type="text" class="form-control" name="name_en" id="companyName"
                        value="{{ $company->name_en }}">
                </div>
                <div class="form-group col-md-6 mb-4">
                    <label for="companyPhone">الهاتف</label>
                    <input type="tel" class="form-control" name="phone" id="companyPhone"
                        value="{{ $company->phone }}">
                </div>
                <div class="form-group col-md-6 mb-4">
                    <label for="companyFax">الفاكس</label>
                    <input type="tel" class="form-control" name="fax" id="companyFax"
                        value="{{ $company->fax }}">
                </div>
                <div class="form-group col-md-6 mb-4">
                    <label for="companyEmail">البريد الإلكتروني</label>
                    <input type="email" class="form-control" name="email" id="companyEmail"
                        value="{{ $company->email }}">
                </div>
                <div class="form-group col-md-6 mb-4">
                    <label for="companyAddress">عنوان الشركة</label>
                    <input type="text" class="form-control" name="address" id="companyAddress"
                        value="{{ $company->address }}">
                </div>
                <div class="form-group col-md-6 mb-4">
                    <label for="warehousePhone">هاتف المخزن</label>
                    <input type="tel" class="form-control" name="store_phone" id="warehousePhone"
                        value="{{ $company->store_phone }}">
                </div>
                <div class="form-group col-md-6 mb-4">
                    <label for="repName">اسم المندوب</label>
                    <input type="text" class="form-control" name="delegate_name" id="repName"
                        value="{{ $company->deligate_name }}">
                </div>
                <div class="form-group col-md-6 mb-4">
                    <label for="repPhone">هاتف المندوب</label>
                    <input type="tel" class="form-control" name="delegate_phone" id="repPhone"
                        value="{{ $company->deligate_phone }}">
                </div>
                <div class="form-group col-md-6 mb-4">
                    <label for="repEmail">البريد الإلكتروني للمندوب</label>
                    <input type="email" class="form-control" name="delegate_email" id="repEmail"
                        value="{{ $company->deligate_email }}">
                </div>
                <div class="form-group col-md-6 mb-4">
                    <div class="form-check-inline">
                        <input type="checkbox" class="form-check-input" id="activation">
                        <label class="form-check-label" for="activation">تفعيل</label>
                    </div>
                    <input type="hidden" name="active" id="activation_value" value="{{ $company->active }}">
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h5 class="mb-4">التركيب والتوصيل</h5>
            <div class="row form-rows">
                <div class="form-group col-md-6 mb-4">
                    <input type="text" class="form-control" id="employee1Name" name="delivery"
                        value="{{ $company->delivery }}">
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h5 class="mb-4"> الصيانة
            </h5>
            <div class="row form-rows">
                <div class="form-group col-md-6 mb-4">
                    <input type="text" class="form-control" name="maintenance" id="employee1Name"
                        value="{{ $company->maintenance }}">
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h5 class="mb-4"> المبيعات
            </h5>
            <div class="row form-rows">
                <div class="form-group col-md-6 mb-4">
                    <input type="text" class="form-control" name="sales" id="employee1Name"
                        value="{{ $company->sales }}">
                </div>
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary mt-3">حفظ</button>
</form>
<script>
    document.getElementById('activation').addEventListener('change', function() {
        var hiddenInput = document.getElementById('activation_value');

        if (this.checked) {
            hiddenInput.value = 1;
        } else {
            hiddenInput.value = 0;
        }
    });
</script>
