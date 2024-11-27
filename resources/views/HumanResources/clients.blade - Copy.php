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
<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0"> العملاء</h4>
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
                            <h4 class="modal-title" id="myModalLabel">اضف جديد</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                        </div>
                        <form action="{{ route('clients.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                                <div class="row pt-3">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label"> الإسم بالعربية <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="name_ar" class="form-control" required />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label"> الإسم بالانجليزية <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="name_en" class="form-control" required />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label"> الرقم المدني <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="civil_number" class="form-control" required />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label"> الجنس <span class="text-danger">*</span></label>
                                            <select class="form-select" name="gender" required>
                                                <option value="male">ذكر</option>
                                                <option value="female">انثى</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label"> الجنسية <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select" name="nationality_id" required>
                                                <option disabled selected>اختر الجنسية</option>
                                                @foreach ($nationalities as $nationality)
                                                <option value="{{ $nationality->id }}">{{ $nationality->name_ar }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3"> <label for="edit_date">تاريخ الميلاد</label>
                                            <input type="date" name="birth_date" class="form-control mb-2"
                                                   id="edit_date">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label"> الهاتف <span class="text-danger">*</span></label>
                                            <input type="text" name="phone" class="form-control" required />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label"> البريد الالكترونى </label>
                                            <input type="email" name="email" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label"> هاتف العمل </label>
                                            <input type="text" name="phone_work" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label"> هاتف اقرب شخص </label>
                                            <input type="text" name="nearist_phone" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label"> الهاتف الارضي </label>
                                            <input type="text" name="phone_land" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label"> الرقم الالي </label>
                                            <input type="text" name="house_id" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label"> القطعة </label>
                                            <input type="text" name="block" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label"> شارع </label>
                                            <input type="text" name="street" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label"> جادة </label>
                                            <input type="text" name="jada" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label"> مبنى </label>
                                            <input type="text" name="building" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label"> الدور </label>
                                            <input type="text" name="floor" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label"> المنزل </label>
                                            <input type="text" name="flat" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label"> جهة العمل </label>
                                            <select class="form-select" name="ministry_id" required>
                                                <option disabled selected>اختر جهة العمل</option>
                                                @foreach ($ministries as $ministry)
                                                <option value="{{ $ministry->id }}">{{ $ministry->name_ar }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label"> المحافظة <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select" name="governorate_id" required>
                                                <option disabled selected>اختر المحافظة</option>
                                                @foreach ($governorates as $governorate)
                                                <option value="{{ $governorate->id }}">{{ $governorate->name_ar }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label"> المنطقة <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select" name="area_id" required>
                                                <option disabled selected>اختر المنطقة</option>
                                                @foreach ($areas as $area)
                                                <option value="{{ $area->id }}">{{ $area->name_ar }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label"> الفرع </label>
                                            <select class="form-select" name="branch_id">
                                                <option disabled selected>اختر الفرع</option>
                                                @foreach ($branches as $branch)
                                                <option value="{{ $branch->id }}">{{ $branch->name_ar }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label"> الراتب <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="salary" class="form-control" required />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label"> اسم البنك <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select" name="bank_id" required>
                                                <option disabled selected>اختر البنك</option>
                                                @foreach ($banks as $bank)
                                                <option value="{{ $bank->id }}">{{ $bank->name_ar }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label"> iban </label>
                                            <input type="text" name="iban" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label"> رقم الحساب البنكي </label>
                                            <input type="text" name="bank_account_number" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label"> صورة شهادة الراتب <span
                                                    class="text-danger">*</span></label>
                                            <input type="file" name="images[0][path]" class="form-control"
                                                   required />
                                            <input type="hidden" name="images[0][type]" value="contract" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label"> صورة البطاقة وجه <span
                                                    class="text-danger">*</span></label>
                                            <input type="file" name="images[1][path]" class="form-control"
                                                   required />
                                            <input type="hidden" name="images[1][type]" value="personal" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label"> صورة البطاقة ظهر <span
                                                    class="text-danger">*</span></label>
                                            <input type="file" name="images[2][path]" class="form-control"
                                                   required />
                                            <input type="hidden" name="images[2][type]" value="working" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label"> صورة استعلام الساينت <span
                                                    class="text-danger">*</span></label>
                                            <input type="file" name="images[3][path]" class="form-control"
                                                   required />
                                            <input type="hidden" name="images[3][type]" value="contract" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label"> صورة هوية العمل <span
                                                    class="text-danger">*</span></label>
                                            <input type="file" name="images[4][path]" class="form-control"
                                                   required />
                                            <input type="hidden" name="images[4][type]" value="personal" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer d-flex ">
                                <button type="submit" class="btn btn-primary">حفظ</button>
                                <button type="button" class="btn bg-danger-subtle text-danger waves-effect"
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
    </div>

    <div class="card-body">
        <div class="table-responsive pb-4">
            <table id="all-student" class="table table-bordered border text-nowrap align-middle">
                <thead>
                <!-- start row -->
                <tr>
                    <th>#</th>
                    <th>الاسم </th>
                    <th>الرقم المدني </th>
                    <th>الهاتف</th>
                    <th>الراتب </th>
                    <th>الاجراءات</th>

                </tr>
                <!-- end row -->
                </thead>
                <tbody>
                <!-- start row -->
                @forelse ($clients as $client)
                <tr>
                    <td>
                        {{ $loop->index + 1 }}
                    </td>
                    <td>
                        {{ $client->name_ar }}
                    </td>
                    <td>{{ $client->civil_number }}</td>
                    <td>
                        @if ($client->client_phone->isNotEmpty())
                        {{ $client->client_phone->last()->phone }}
                        @else
                        لا توجد أرقام هاتفية
                        @endif
                    </td>

                    <td>{{ $client->salary }}</td>

                    <td>
                        <div class="d-block">

                            <div>
                                <button class="btn me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4 "
                                        data-bs-toggle="modal"
                                        data-bs-target="#edit-example-modal-md-{{ $client->id }}">
                                    تعديل </button>
                                <!-- sample modal content -->
                                <div id="edit-example-modal-md-{{ $client->id }}" class="modal fade"
                                     tabindex="-1" aria-labelledby="edit-example-modal-md"
                                     aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header d-flex align-items-center">
                                                <h4 class="modal-title" id="myModalLabel">
                                                    تعديل </h4>
                                                <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('clients.update', $client->id) }}"
                                                  method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body"
                                                     style="max-height: 70vh; overflow-y: auto;">
                                                    <div class="row pt-3">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label"> الإسم
                                                                    بالعربية</label>
                                                                <input type="text" name="name_ar"
                                                                       class="form-control" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label"> الإسم
                                                                    بالانجليزية</label>
                                                                <input type="text" name="name_en"
                                                                       class="form-control" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label"> الرقم المدني</label>
                                                                <input type="text" name="civil_number"
                                                                       class="form-control" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label"> الجنس</label>
                                                                <select class="form-select" name="gender">
                                                                    <option value="male">
                                                                        ذكر</option>
                                                                    <option value="female">
                                                                        انثى</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label"> الجنسية</label>
                                                                <select class="form-select"
                                                                        name="nationality_id">
                                                                    <option disabled selected>اختر الجنسية
                                                                    </option>
                                                                    @foreach ($nationalities as $nationality)
                                                                    <option
                                                                        value="{{ $nationality->id }}">
                                                                        {{ $nationality->name_ar }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="edit_date">تاريخ
                                                                    الميلاد</label>
                                                                <input type="date" name="birth_date"
                                                                       class="form-control mb-2" id="edit_date">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label"> الهاتف</label>
                                                                <input type="text" name="phone"
                                                                       class="form-control" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label"> البريد
                                                                    الالكترونى</label>
                                                                <input type="email" name="email"
                                                                       class="form-control" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label"> هاتف العمل</label>
                                                                <input type="text" name="phone_work"
                                                                       class="form-control" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label"> هاتف اقرب
                                                                    شخص</label>
                                                                <input type="text" name="nearist_phone"
                                                                       class="form-control" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label"> الهاتف
                                                                    الارضي</label>
                                                                <input type="text" name="phone_land"
                                                                       class="form-control" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label"> الرقم الالي</label>
                                                                <input type="text" name="house_id"
                                                                       class="form-control" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label"> القطعة</label>
                                                                <input type="text" name="block"
                                                                       class="form-control" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label"> شارع</label>
                                                                <input type="text" name="street"
                                                                       class="form-control" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label"> جادة</label>
                                                                <input type="text" name="jada"
                                                                       class="form-control" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label"> مبنى</label>
                                                                <input type="text" name="building"
                                                                       class="form-control" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label"> الدور</label>
                                                                <input type="text" name="floor"
                                                                       class="form-control" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label"> المنزل</label>
                                                                <input type="text" name="flat"
                                                                       class="form-control" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label"> جهة العمل</label>
                                                                <select class="form-select"
                                                                        name="ministry_id">
                                                                    <option disabled selected>اختر جهة العمل
                                                                    </option>
                                                                    @foreach ($ministries as $ministry)
                                                                    <option value="{{ $ministry->id }}">
                                                                        {{ $ministry->name_ar }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label"> المحافظة</label>
                                                                <select class="form-select"
                                                                        name="governorate_id">
                                                                    <option disabled selected>اختر المحافظة
                                                                    </option>
                                                                    @foreach ($governorates as $governorate)
                                                                    <option
                                                                        value="{{ $governorate->id }}">
                                                                        {{ $governorate->name_ar }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label"> المنطقة</label>
                                                                <select class="form-select" name="area_id">
                                                                    <option disabled selected>اختر المنطقة
                                                                    </option>
                                                                    @foreach ($areas as $area)
                                                                    <option value="{{ $area->id }}">
                                                                        {{ $area->name_ar }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label"> الفرع</label>
                                                                <select class="form-select" name="branch_id">
                                                                    <option disabled selected>اختر الفرع
                                                                    </option>
                                                                    @foreach ($branches as $branch)
                                                                    <option value="{{ $branch->id }}">
                                                                        {{ $branch->name_ar }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label"> الراتب</label>
                                                                <input type="text" name="salary"
                                                                       class="form-control" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label"> اسم البنك</label>
                                                                <select class="form-select" name="bank_id">
                                                                    <option disabled selected>اختر البنك
                                                                    </option>
                                                                    @foreach ($banks as $bank)
                                                                    <option value="{{ $bank->id }}">
                                                                        {{ $bank->name_ar }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label"> iban </label>
                                                                <input type="text" name="iban"
                                                                       class="form-control" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label"> رقم الحساب
                                                                    البنكي</label>
                                                                <input type="text"
                                                                       name="bank_account_number"
                                                                       class="form-control" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label"> صورة شهادة
                                                                    الراتب</label>
                                                                <input type="file" name="images[0][path]"
                                                                       class="form-control" />
                                                                <input type="hidden" name="images[0][type]"
                                                                       value="contract" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label"> صورة البطاقة
                                                                    وجه</label>
                                                                <input type="file" name="images[1][path]"
                                                                       class="form-control" />
                                                                <input type="hidden" name="images[1][type]"
                                                                       value="personal" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label"> صورة البطاقة
                                                                    ظهر</label>
                                                                <input type="file" name="images[2][path]"
                                                                       class="form-control" />
                                                                <input type="hidden" name="images[2][type]"
                                                                       value="working" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label"> صورة استعلام
                                                                    الساينت</label>
                                                                <input type="file" name="images[3][path]"
                                                                       class="form-control" />
                                                                <input type="hidden" name="images[3][type]"
                                                                       value="contract" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label"> صورة هوية
                                                                    العمل</label>
                                                                <input type="file" name="images[4][path]"
                                                                       class="form-control" />
                                                                <input type="hidden" name="images[4][type]"
                                                                       value="personal" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer d-flex ">
                                                    <button type="submit"
                                                            class="btn btn-primary">حفظ</button>
                                                    <button type="button"
                                                            class="btn bg-danger-subtle text-danger waves-effect"
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
                                <form action="{{ route('clients.delete', $client->id) }}" method="POST"
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

                @empty
                <tr>
                    <td colspan="6" class="text-center">لا يوجد عملاء</td>
                </tr>
                @endforelse

                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
</div>
