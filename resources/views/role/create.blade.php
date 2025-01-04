<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0"> اضافة مجموعه عمل</h4>
        <div class="d-flex">

        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('roles.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="row pt-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label"> الإسم بالعربية <span class="text-danger">*</span></label>
                            <input type="text" name="name_ar" id="name_ar" class="form-control" required />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label"> الإسم بالانجليزية <span class="text-danger">*</span></label>
                            <input type="text" name="name_en" id="name_en" class="form-control" required />
                        </div>
                    </div>

                    <div class="col-12">
                        <h5>اختر الصلاحيات :</h5>
                    </div>
                </div>


                <div class="form-row">
                    <ul class="category-tree">
                        <div class="row">
                            @foreach ($Permissions as $item)
                                <div class="col-md-3 col-sm-12 my-3">
                                    <li>
                                        <label class="text-indigo my-2">
                                            {{-- <input type="text" name="permissions[]"
                                                value="{{ $item->id }}" class="m-2" readonly> --}}
                                            {{ $item->title_ar }}
                                        </label>
                                        <ul class="category-tree">
                                            @if ($item->childrenRecursive->count() > 0)
                                                @foreach ($item->childrenRecursive as $childrenRecursive)
                                                    <li>
                                                        <label class="text-warning my-2">
                                                            <input type="checkbox" name="permissions[]"
                                                                value="{{ $childrenRecursive->id }}" class="m-2">
                                                            {{ $childrenRecursive->title_ar }}
                                                        </label>
                                                        @if ($childrenRecursive->childrenRecursive->count() > 0)
                                                            <ul class="category-tree d-flex align-items-center">
                                                                @foreach ($childrenRecursive->childrenRecursive as $subchild)
                                                                    <li>
                                                                        <label class="text-muted m-2">
                                                                            <input type="checkbox" name="permissions[]"
                                                                                value="{{ $subchild->id }}"
                                                                                class="m-2">
                                                                            {{ $subchild->title_ar }}
                                                                        </label>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            @endif
                                        </ul>
                                    </li>
                                </div>
                            @endforeach
                        </div>
                    </ul>
                </div>
            </div>
            <div class="modal-footer d-flex ">
                <button type="submit" class="btn btn-primary">حفظ</button>
                <button type="button" class="btn bg-danger-subtle text-danger waves-effect" data-bs-dismiss="modal">
                    الغاء
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
