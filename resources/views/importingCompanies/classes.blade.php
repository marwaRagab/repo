<div class="card mt-4 py-3">
    <div class="d-flex align-items-center justify-content-between px-4  ">
        <h4 class="card-title mb-0"> الصنف</h4>
        <div class="d-flex">
            <button class="btn me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4 ">طباعة</button>
            <button class="btn me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4 " data-bs-toggle="modal"
                data-bs-target="#bs-example-modal-md">
                أضف صنف جديد </button>
        </div>
        <!-- sample modal content -->
        <div id="bs-example-modal-md" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header d-flex align-items-center">
                        <h4 class="modal-title" id="myModalLabel">
                            أضف صنف جديدة</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('class.store') }}">
                            @csrf
                            <div class="row pt-3">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label"> اسم الصنف بالعربي</label>
                                        <input type="text" id="firstName" name="name_ar" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label"> اسم الصنف بالانجليزي</label>
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
<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">

    </div>
    <div class="card-body">
        <div class="table-responsive pb-4">
            <table id="file_export" class="table table-bordered border text-nowrap align-middle">
                <thead>
                    <!-- start row -->
                    <tr>
                        <th>التسلسل</th>
                        <th> الاسم </th>
                        <th> تعديل </th>

                    </tr>
                    <!-- end row -->
                </thead>
                <tbody>
                    <!-- start row -->
                    @forelse ($classes as $class)
                        <tr>
                            <td> {{ $loop->index + 1 }}</td>
                            <td> {{ $class->name_ar }}</td>
                            <td>
                                <button class="btn me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4 "
                                    data-bs-toggle="modal" data-bs-target="#bs-example-modal-edit-{{ $class->id }}">
                                    تعديل </button>
                                <!-- edit model  -->

                                <!-- sample modal content -->
                                <div id="bs-example-modal-edit-{{ $class->id }}" class="modal fade" tabindex="-1"
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
                                                <form method="POST" action="{{ route('class.update', $class->id) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="row pt-3">
                                                        <div class="col-md-12">
                                                            <div class="mb-3">
                                                                <label class="form-label"> اسم الصنف بالعربي</label>
                                                                <input type="text" id="firstName" name="name_ar"
                                                                    class="form-control"
                                                                    value="{{ $class->name_ar }}" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="mb-3">
                                                                <label class="form-label"> اسم الصنف بالانجليزي</label>
                                                                <input type="text" id="firstName" name="name_en"
                                                                    class="form-control"
                                                                    value="{{ $class->name_en }}" />
                                                            </div>
                                                        </div>


                                                    </div>
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

                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">لا توجد اصناف</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
</div>
