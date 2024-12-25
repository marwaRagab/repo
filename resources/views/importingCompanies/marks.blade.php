<div class="card mt-4 py-3">
    <div class="d-flex flex-wrap ">
        <button class="btn me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4 " data-bs-toggle="modal"
            data-bs-target="#bs-example-modal-md">
            أضف ماركة جديدة </button>
        <!-- sample modal content -->
        <div id="bs-example-modal-md" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header d-flex align-items-center">
                        <h4 class="modal-title" id="myModalLabel">
                            أضف ماركة جديدة</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('mark.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row pt-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label"> الإسم بالعربية </label>
                                        <input type="text" id="firstName" name="name_ar" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label"> الإسم بالانجليزية </label>
                                        <input type="text" id="firstName" name="name_en" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label"> الشركة الموردة </label>
                                        <select class="form-select" name="company_id" required>
                                            <option disabled selected>اختر الشركة</option>
                                            @foreach ($companies as $company)
                                            <option value="{{ $company->id }}">{{ $company->name_ar }}
                                            </option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label"> الصورة </label>
                                        <input type="file" id="firstName" name="img" class="form-control" />

                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label"> نسبة الخصم
                                        </label>
                                        <input type="text" id="firstName" name="discount" class="form-control"
                                            placeholder="%" />
                                    </div>
                                </div>
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
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

    </div>
</div>
<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0"> الماركات</h4>

    </div>
    <div class="card-body">
        <div class="table-responsive pb-4">
            <table id="all-student" class="table table-bordered border text-nowrap align-middle">
                <thead>
                    <!-- start row -->
                    <tr>
                        <th>الماركة</th>
                        <th>الشركة الموردة </th>
                        <th> النسبة </th>
                        <th> الصورة </th>

                        <th> تعديل </th>

                    </tr>
                    <!-- end row -->
                </thead>
                <tbody>
                    <!-- start row -->
                    @forelse ($marks as $mark)
                    <tr>
                        <td>{{ $mark->name_ar }}</td>
                        <td>{{ $mark->company->name_ar }}</td>
                        <td>{{ number_format($mark->discount, 2) }} %</td>
                        <td>
                            <img src="{{ asset('storage/' . $mark->img) }}" alt="{{ $mark->name_en }}"
                                style="max-width: 100px; max-height: 100px;" />
                        </td>
                        <td>
                            <button class="btn me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4 "
                                data-bs-toggle="modal" data-bs-target="#bs-example-modal-edit-{{ $mark->id }}">
                                تعديل </button>
                            <!-- edit model  -->

                            <!-- sample modal content -->
                            <div id="bs-example-modal-edit-{{ $mark->id }}" class="modal fade" tabindex="-1"
                                aria-labelledby="bs-example-modal-edit" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header d-flex align-items-center">
                                            <h4 class="modal-title" id="myModalLabel">
                                                تعديل</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST" action="{{ route('mark.update', $mark->id) }}"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="row pt-3">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label"> الإسم بالعربية </label>
                                                            <input type="text" id="firstName" class="form-control"
                                                                name="name_ar" value="{{ $mark->name_ar }}" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label"> الإسم بالانجليزية </label>
                                                            <input type="text" id="firstName" class="form-control"
                                                                name="name_en" value="{{ $mark->name_en }}" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label"> الشركة الموردة </label>
                                                            <select class="form-select" name="company_id" required>
                                                                <option disabled>اختر الشركة</option>
                                                                @foreach ($companies as $company)
                                                                <option value="{{ $company->id }}"
                                                                    {{ $mark->company_id == $company->id ? 'selected' : '' }}>
                                                                    {{ $company->name_ar }}
                                                                </option>
                                                                @endforeach
                                                            </select>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label"> الصورة </label>
                                                            <input type="file" id="firstName" class="form-control"
                                                                name="img" />
                                                            @if ($mark->img)
                                                            <img src="{{ asset('storage/' . $mark->img) }}"
                                                                alt="{{ $mark->name_en }}"
                                                                style="max-width: 100px; max-height: 100px;">
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label"> نسبة الخصم
                                                            </label>
                                                            <input type="text" id="firstName" placeholder="%"
                                                                class="form-control" name="discount"
                                                                value="{{ $mark->discount }}" />
                                                        </div>
                                                    </div>
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
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">لا توجد ماركات</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
</div>