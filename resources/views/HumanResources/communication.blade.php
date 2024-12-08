<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0"> طرق التواصل </h4>
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
                            <form method="POST" action="{{ route('communication.store') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row pt-3">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label"> الإسم بالعربية <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="firstName" name="name_ar" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label"> الإسم بالانجليزية <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="firstName" name="name_en" class="form-control" />
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

    <div class="card-body">
        <div class="table-responsive pb-4">
            <table id="file_export" class="table table-bordered border text-nowrap align-middle">
                <thead>
                    <!-- start row -->
                    <tr>
                        <th>الاسم </th>
                        <th>انشأ بواسطة</th>
                        <th>الاجراءات </th>
                    </tr>
                    <!-- end row -->
                </thead>
                <tbody>
                    <!-- start row -->
                    @foreach ($data as $method)
                        <tr>
                            <td>
                                {{ $method->name_ar }}
                            </td>
                            <td>{{ $method->created_by }}</td>
                            <td>
                                <div class="d-block">

                                    <div>
                                        <button class="btn me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4 "
                                            data-bs-toggle="modal"
                                            data-bs-target="#edit-example-modal-md-{{ $method->id }}">
                                            تعديل </button>
                                        <!-- sample modal content -->
                                        <div id="edit-example-modal-md-{{ $method->id }}" class="modal fade"
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
                                                            action="{{ route('communication.update', $method->id) }}">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="row pt-3">
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label"> الإسم
                                                                            بالعربية</label>
                                                                        <input type="text" id="firstName"
                                                                            class="form-control" name="name_ar"
                                                                            value="{{ $method->name_ar }}" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label"> الإسم
                                                                            بالانجليزية</label>
                                                                        <input type="text" id="firstName"
                                                                            class="form-control" name="name_en"
                                                                            value="{{ $method->name_en }}" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer d-flex ">
                                                                <button type="submit"
                                                                    class="btn btn-primary">حفظ</button>
                                                                <button type="button"
                                                                    class="btn bg-danger-subtle text-danger  waves-effect"
                                                                    data-bs-dismiss="modal">
                                                                    الغاء
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>

                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                    </div>
                                    <div>
                                        <form action="{{ route('communication.delete', $method->id) }}" method="POST"
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
</div>
</div>
</div>
