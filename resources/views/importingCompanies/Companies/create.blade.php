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
<form method="POST" action="{{ route('company.store') }}">
    @csrf
    <div class="card">

        <div class="card-body">
            <h5 class="mb-4">إضافة جديد
            </h5>
            <div class="row form-rows">
                <div class="form-group col-md-6 mb-4">
                    <label for="companyName"> اسم الشركة بالعربي</label>
                    <input type="text" class="form-control" name="name_ar" id="companyName">
                </div>
                <div class="form-group col-md-6 mb-4">
                    <label for="companyName"> اسم الشركة بالانجليزي</label>
                    <input type="text" class="form-control" name="name_en" id="companyName">
                </div>
                <div class="form-group col-md-6 mb-4">
                    <label for="companyPhone">الهاتف</label>
                    <input type="tel" class="form-control" name="phone" id="companyPhone">
                </div>
                <div class="form-group col-md-6 mb-4">
                    <label for="companyFax">الفاكس</label>
                    <input type="tel" class="form-control" name="fax" id="companyFax">
                </div>
                <div class="form-group col-md-6 mb-4">
                    <label for="companyEmail">البريد الإلكتروني</label>
                    <input type="email" class="form-control" name="email" id="companyEmail">
                </div>
                <div class="form-group col-md-6 mb-4">
                    <label for="companyAddress">عنوان الشركة</label>
                    <input type="text" class="form-control" name="address" id="companyAddress">
                </div>
                <div class="form-group col-md-6 mb-4">
                    <label for="warehousePhone">هاتف المخزن</label>
                    <input type="tel" class="form-control" name="store_phone" id="warehousePhone">
                </div>
                <div class="form-group col-md-6 mb-4">
                    <label for="repName">اسم المندوب</label>
                    <input type="text" class="form-control" name="delegate_name" id="repName">
                </div>
                <div class="form-group col-md-6 mb-4">
                    <label for="repPhone">هاتف المندوب</label>
                    <input type="tel" class="form-control" name="delegate_phone" id="repPhone">
                </div>
                <div class="form-group col-md-6 mb-4">
                    <label for="repEmail">البريد الإلكتروني للمندوب</label>
                    <input type="email" class="form-control" name="delegate_email" id="repEmail">
                </div>
                <div class="form-group col-md-6 mb-4">
                    <div class="form-check-inline">
                        <input type="checkbox" class="form-check-input" id="activation">
                        <label class="form-check-label" for="activation">تفعيل</label>
                    </div>
                    <input type="hidden" name="active" id="activation_value" value="0">
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h5 class="mb-4">التركيب والتوصيل</h5>
            <div class="row form-rows">
                <div class="form-group col-md-6 mb-4">
                    <label for="employee1Name">اسم موظف 1</label>
                    <input type="text" class="form-control" id="employee1Name" name="employee1Name">
                </div>
                <div class="form-group col-md-6 mb-4">
                    <label for="employee1Phone">هاتف موظف 1</label>
                    <input type="tel" class="form-control" id="employee1Phone" name="employee1Phone">
                </div>
                <div class="form-group col-md-6 mb-4">
                    <label for="employee1Email">بريد موظف 1</label>
                    <input type="email" class="form-control" id="employee1Email" name="employee1Email">
                </div>
                <div class="form-group col-md-6 mb-4">
                    <label for="employee2Phone">هاتف موظف 2</label>
                    <input type="tel" class="form-control" id="employee2Phone" name="employee2Phone">
                </div>
                <div class="form-group col-md-6 mb-4">
                    <label for="employee2Email">بريد موظف 2</label>
                    <input type="email" class="form-control" id="employee2Email" name="employee2Email">
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
                    <label for="employee1Name">اسم موظف 1</label>
                    <input type="text" class="form-control" name="maintenanceEmp1name" id="employee1Name">
                </div>
                <div class="form-group col-md-6 mb-4">
                    <label for="employee1Phone">هاتف موظف 1</label>
                    <input type="tel" class="form-control" name="maintenanceEmp1phone" id="employee1Phone">
                </div>
                <div class="form-group col-md-6 mb-4">
                    <label for="employee1Email">بريد موظف 1</label>
                    <input type="email" class="form-control" name="maintenanceEmp1email" id="employee1Email">
                </div>
                <div class="form-group col-md-6 mb-4">
                    <label for="employee2Phone">هاتف موظف 2</label>
                    <input type="tel" class="form-control" name="maintenanceEmp2phone" id="employee2Phone">
                </div>
                <div class="form-group col-md-6 mb-4">
                    <label for="employee2Email">بريد موظف 2</label>
                    <input type="email" class="form-control" name="maintenanceEmp2email" id="employee2Email">
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
                    <label for="employee1Name">اسم موظف 1</label>
                    <input type="text" class="form-control" name="salesEmp1name" id="employee1Name">
                </div>
                <div class="form-group col-md-6 mb-4">
                    <label for="employee1Phone">هاتف موظف 1</label>
                    <input type="tel" class="form-control" name="salesEmp1phone" id="employee1Phone">
                </div>
                <div class="form-group col-md-6 mb-4">
                    <label for="employee1Email">بريد موظف 1</label>
                    <input type="email" class="form-control" name="salesEmp1email" id="employee1Email">
                </div>
                <div class="form-group col-md-6 mb-4">
                    <label for="employee2Phone">هاتف موظف 2</label>
                    <input type="tel" class="form-control" name="salesEmp2phone" id="employee2Phone">
                </div>
                <div class="form-group col-md-6 mb-4">
                    <label for="employee2Email">بريد موظف 2</label>
                    <input type="email" class="form-control" name="salesEmp2email" id="employee2Email">
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
