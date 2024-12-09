<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0">المعاملات </h4>
        
    </div>
    
</div>

<div class="card">
    <div class="card-body">
        <div class="modal-header d-flex align-items-center">
            <h4 class="modal-title" id="myModalLabel">
             أضف  جديد</h4>
        </div>
        <div class="modal-body">
            <form id="installment-form" action="{{ route('installmentClient.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="row pt-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label"> الإسم </label>
                            <input type="text" id="name_ar" name="name_ar" class="form-control"
                                required />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label"> الرقم المدني </label>
                            <input type="text" id="civil_number" name="civil_number" class="form-control"
                                required />
                            <small id="civil-number-error" class="text-danger" style="display: none;">الرقم
                                المدني موجود من قبل </small>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label"> الهاتف </label>
                            <input type="text" id="phone" class="form-control" name="phone"
                                required />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label"> الراتب </label>
                            <input type="text" id="salary" class="form-control" name="salary"
                                required />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label"> البنك </label>
                            <select class="form-select" id="bank" name="bank_id" required>
                                <option value="">اختر</option>
                                @foreach ($bank as $item)
                                    <option value="{{ $item->id }}">{{ $item->name_ar }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label"> المحافظة </label>
                            <select class="form-select" name="governorate_id" required>
                                <option value="">اختر</option>
                                @foreach ($government as $item)
                                    <option value="{{ $item->id }}">{{ $item->name_ar }}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label"> المنطقة </label>
                            <select class="form-select" name="area_id" required>
                                <option value="">اختر</option>
                                @foreach ($region as $item)
                                    <option value="{{ $item->id }}">{{ $item->name_ar }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label"> جهه العمل </label>
                            <select class="form-select" id="work" name="ministry_id" required>
                                <option value="">اختر</option>
                                @foreach ($data['ministry'] as $item)
                                    <option value="{{ $item->id }}">{{ $item->name_ar }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label"> مجموع الاقساط </label>
                            <input type="text" name="installment_total" id="installment_total"
                                class="form-control" required />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label"> الوسيط </label>
                            <select class="form-select" id="boker" name="boker_id" required>
                                <option value="">اختر</option>
                                @foreach ($boker as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label"> الملاحظات </label>
                            <input type="text" id="firstName" class="form-control" />
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer d-flex ">
            <button type="button" class="btn btn-primary" onclick="validateForm()">حفظ</button>
            <button type="button" class="btn bg-danger-subtle text-danger  waves-effect"
                data-bs-dismiss="modal">
                الغاء
            </button>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>

    function validateForm() {
            const name = document.getElementById('name_ar').value.trim();
            const civilNumber = document.getElementById('civil_number').value.trim();
            const phone = document.getElementById('phone').value.trim();
            const salary = document.getElementById('salary').value.trim();
            const installmentTotal = document.getElementById('installment_total').value.trim();

            // Validate fields
            if (name === "") {
                alert("يرجى إدخال الإسم.");
                return false;
            }
            if (civilNumber.length !== 12 || (civilNumber[0] !== '2' && civilNumber[0] !== '3')) {
                alert("يجب أن يتكون الرقم المدني من 12 رقم ويبدأ بالرقم 2 أو 3.");
                return false;
            }
            if (phone === "" || phone.length !== 8 || isNaN(phone)) {
                alert("يجب أن يتكون الهاتف من 8 أرقام.");
                return false;
            }

            if (salary === "" || isNaN(salary)) {
                alert("يرجى إدخال راتب صالح.");
                return false;
            }
            if (installmentTotal === "") {
                alert("يرجى إدخال مجموع الاقساط.");
                return false;
            }
            // If all validations pass, submit the form
            document.getElementById('installment-form').submit();
    }
</script>

