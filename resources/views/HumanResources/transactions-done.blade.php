<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0"> منجزين المعاملات</h4>
        <div class="d-flex">
            <button class="btn me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4 " data-bs-toggle="modal"
                data-bs-target="#bs-example-modal-md">
                أضف جديد </button>
            <!-- sample modal content -->
            <div id="bs-example-modal-md" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-lg">
                    <div class="modal-content">
                        <div class="modal-header d-flex align-items-center">
                            <h4 class="modal-title" id="myModalLabel">
                                اضف جديد</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('transactions.done.store') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row pt-3">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label"> الإسم بالعربية <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="firstName" name ="name_ar" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label"> الإسم بالانجليزية <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="firstName" name="name_en" class="form-control" />
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">المهنة <span class="text-danger">*</span></label>
                                            <select class="form-select" id="jobSelect" name="section_type"
                                                onchange="showAdditionalSelect()" required>
                                                <option value="" selected disabled>اختر المهنة</option>
                                                <option value="bank">موظف بنك</option>
                                                <option value="court">موظف محكمة</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12" id="bankSelectContainer" style="display: none;">
                                        <div class="mb-3">
                                            <select class="form-select" name="bank_id" id="bank_id" required>
                                                <option selected disabled>اختر البنك</option>
                                                @foreach ($banks as $bank)
                                                    <option value="{{ $bank->id }}">{{ $bank->name_ar }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12" id="courtSelectContainer" style="display: none;">
                                        <div class="mb-3">
                                            <select class="form-select" name="court_id" id="court_id" required>
                                                <option selected disabled>اختر المحكمة</option>
                                                @foreach ($courts as $court)
                                                    <option value="{{ $court->id }}">{{ $court->name_ar }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label"> طريقة التواصل<span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select" name="communication_method_id">
                                                <option selected disabled>اختر طريقة التواصل</option>
                                                @foreach ($methods as $method)
                                                    <option value="{{ $method->id }}">{{ $method->name_ar }}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label"> بيانات التواصل<span
                                                class="text-danger">*</span></label>
                                        <input type="text" id="firstName" name="Communication_method"
                                            class="form-control" />
                                    </div>
                                </div>
                                <div class="modal-footer d-flex ">
                                    <button type="submit" class="btn btn-primary">حفظ</button>
                                    <button type="button" class="btn bg-danger-subtle text-danger  waves-effect"
                                        data-bs-dismiss="modal">
                                        الغاء
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>

                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

    </div>
</div>

<div class="card-body">
    <div class="table-responsive pb-4">
        <table id="file_export" class="table table-bordered border text-nowrap align-middle">
            <thead>
                <!-- start row -->
                <tr>
                    <th>الاسم </th>
                    <th> المهنة </th>
                    <th> طريقة التواصل </th>
                    <th> بيانات التواصل </th>
                    <th>انشأ بواسطة</th>
                    <th>تعديل بواسطة </th>
                    <th>الاجراءات </th>
                </tr>
                <!-- end row -->
            </thead>
            <tbody>
                <!-- start row -->
                @foreach ($data as $person)
                    <tr>
                        <td>
                            {{ $person->name_ar }}
                        </td>
                        <td>
                            @if ($person->section_type === 'bank')
                                موظف بنك
                            @elseif ($person->section_type === 'court')
                                موظف محكمة
                            @else
                                غير محدد
                            @endif
                        </td>
                        <td>{{ $person->communcation_method->name_ar }}</td>
                        <td>{{ $person->Communication_method }}</td>
                        <td>{{ $person->created_by }}</td>
                        <td>{{ $person->updated_by }}</td>
                        <td>
                            <div class="d-block">

                                <div>
                                    <button class="btn me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4 "
                                        data-bs-toggle="modal"
                                        data-bs-target="#edit-example-modal-md-{{ $person->id }}">
                                        تعديل </button>
                                    <!-- sample modal content -->
                                    <div id="edit-example-modal-md-{{ $person->id }}" class="modal fade"
                                        tabindex="-1" aria-labelledby="edit-example-modal-md" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header d-flex align-items-center">
                                                    <h4 class="modal-title" id="myModalLabel">
                                                        تعديل </h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="POST"
                                                        action="{{ route('transactions.done.update', $person->id) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="row pt-3">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label"> الإسم بالعربية</label>
                                                                    <input type="text" id="firstName"
                                                                        class="form-control" name="name_ar"
                                                                        value="{{ $person->name_ar }}" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label"> الإسم
                                                                        بالانجليزية</label>
                                                                    <input type="text" id="firstName"
                                                                        class="form-control" name="name_en"
                                                                        value="{{ $person->name_en }}" />
                                                                </div>
                                                            </div>


                                                            <div class="col-md-12">
                                                                <div class="col-md-12">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">المهنة</label>
                                                                        <select class="form-select"
                                                                            name="section_type">
                                                                            <option selected disabled>اختر المهنة
                                                                            </option>
                                                                            <option value="bank"
                                                                                {{ $person->section_type == 'bank' ? 'selected' : '' }}>
                                                                                موظف بنك</option>
                                                                            <option value="court"
                                                                                {{ $person->section_type == 'court' ? 'selected' : '' }}>
                                                                                موظف محكمة</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="mb-3">
                                                                    <label class="form-label"> طريقة التواصل</label>
                                                                    <select class="form-select"
                                                                        name="communication_method_id">
                                                                        <option disabled>اختر طريقة التواصل
                                                                        </option>
                                                                        @foreach ($methods as $method)
                                                                            <option value="{{ $method->id }}"
                                                                                {{ $person->communcation_method_id == $method->id ? 'selected' : '' }}>
                                                                                {{ $method->name_ar }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="mb-3">
                                                                <label class="form-label"> بيانات التواصل</label>
                                                                <input type="text" id="firstName"
                                                                    name="Communication_method" class="form-control"
                                                                    value="{{ $person->Communication_method }}" />
                                                            </div>
                                                        </div>
                                                        {{-- <div class="col-md-12">
                                                            <div class="mb-3">
                                                                <label class="form-label"> واتس اب <span
                                                                        class="text-danger">*</span></label>
                                                                <input type="text" id="firstName"
                                                                    class="form-control" name="whatsapp"
                                                                    value="{{ $person->whatsapp }}" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="mb-3">
                                                                <label class="form-label"> البريد الالكترونى <span
                                                                        class="text-danger">*</span></label>
                                                                <input type="text" id="firstName"
                                                                    class="form-control" name="email"
                                                                    value="{{ $person->email }}" />
                                                            </div>
                                                        </div> --}}
                                                        {{-- <div class="col-md-12">
                                                            <div class="mb-3">
                                                                <label class="form-label"> رسالة نصية <span
                                                                        class="text-danger">*</span></label>
                                                                <input type="text" id="firstName"
                                                                    class="form-control" />
                                                            </div>
                                                        </div> --}}


                                                </div>
                                                <div class="modal-footer d-flex ">
                                                    <button type="submit" class="btn btn-primary">حفظ</button>
                                                    <button type="button"
                                                        class="btn bg-danger-subtle text-danger  waves-effect"
                                                        data-bs-dismiss="modal">
                                                        الغاء
                                                    </button>
                                                </div>
                                                </form>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                </div>
                                <div>
                                    <form action="{{ route('transactions.done.delete', $person->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('هل أنت متأكد أنك تريد حذف هذا العنصر؟');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="btn me-1 mb-1 bg-danger-subtle text-danger px-4 fs-4">
                                            حذف
                                        </button>
                                    </form>
                                </div>

                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>
    function showAdditionalSelect() {
        const jobSelect = document.getElementById("jobSelect");
        const bankSelectContainer = document.getElementById("bankSelectContainer");
        const courtSelectContainer = document.getElementById("courtSelectContainer");

        // Hide both containers initially
        bankSelectContainer.style.display = 'none';
        courtSelectContainer.style.display = 'none';

        // Show the relevant container based on selection
        if (jobSelect.value === "bank") {
            bankSelectContainer.style.display = 'block';
        } else if (jobSelect.value === "court") {
            courtSelectContainer.style.display = 'block';
        }
    }
</script>
