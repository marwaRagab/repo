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
        <h4 class="card-title mb-0">الصلاحيات</h4>
        <button class="btn me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4 " data-bs-toggle="modal"
            data-bs-target="#bs-example-modal-md">
             أضف  صلاحية </button>
        <!-- sample modal content -->
        <div id="bs-example-modal-md" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header d-flex align-items-center">
                        <h4 class="modal-title" id="myModalLabel">
                            أضف صلاحية</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('permission.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label" for="input2 ">اختر </label>
                                    <select name="name" class="form-control"  id="">
                                        <option value="view">view</option>
                                        <option value="create">create</option>
                                        <option value="update">update</option>
                                        <option value="delete">delete</option>
                                        <option value="export">export</option>
                                        <option value="print">print</option>
                                        <option value="import">import</option>

                                    </select>
                                </div>



                                <div class="form-group">
                                    <label class="form-label" for="input2 ">الرئيسى</label>
                                    <select name="perant_id" class="form-control" >
                                        @foreach ($data['permission'] as $item)
                                            <option value="{{ $item->id }}">
                                                {{ $item->title_ar . " " . ($item->parent->title_ar ?? "") }}
                                            </option>
                                        @endforeach
                                    </select>
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
    <div class="card-body">
        <div class="table-responsive pb-4">
            <table id="all-student" class="table table-bordered border text-nowrap align-middle">
                <thead>
                    <!-- start row -->
                    <tr>
                        <th>#</th>
                        <th> الإسم </th>
                        <th>الرئيسى</th>
                        <th> انشأ بواسطة</th>
                        <th> اخر تحديث بواسطة </th>
                        <th>الإجراءات</th>
                    </tr>
                    <!-- end row -->
                </thead>
                <tbody>
                    <!-- start row -->
                    @foreach ($data['permission'] as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>
                                {{ $item->title_ar }}
                            </td>
                            <td>
                                {{ $item->parent->title_ar ?? 'لايوجد'  }}
                            </td>
                            <td>
                                {{ $item->user->name_ar ?? 'لايوجد' }}
                            </td>
                            <td>
                                {{ $item->user->name_ar ?? 'لايوجد' }}
                            </td>
                            <td>
                                <div class="action-btn">
                                    {{-- <a class="text-primary edit-btn" data-bs-toggle="modal"
                                        data-bs-target="#bs-example-modal-edit" data-id ="{{ $item->id }}">
                                        <i class="ti ti-pencil fs-5"></i>
                                    </a> --}}
                                    <a href="{{ route('permission.destroy', $item->id) }}" class="text-dark delete ms-2">
                                        <i class="ti ti-trash fs-5"></i>
                                    </a>
                                    {{-- <div id="bs-example-modal-edit" class="modal fade" tabindex="-1"
                                        aria-labelledby="bs-example-modal-md" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header d-flex align-items-center">
                                                    <h4 class="modal-title" id="myModalLabel">
                                                        تعديل الصلاحية</h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="editpermissionForm" method="get"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="form-row">
                                                            <div class="form-group">
                                                                <label class="form-label" for="input1 "> الإسم
                                                                    بالعربية</label>
                                                                <input type="text" class="form-control mb-2"
                                                                    id="name_ar_e" name="name_ar">
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label" for="input2 ">الإسم
                                                                    بالإنجليزية </label>
                                                                <input type="text" class="form-control mb-2"
                                                                    id="name_en_e" name="name_en"
                                                                    value="{{ $item->name_en }}">
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
                                    </div> --}}
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


{{-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function() {
                const itemId = this.getAttribute('data-id');
                console.log(itemId);
                // Fetch data for the selected item
                fetch(`permission/edit/${itemId}`)
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        // Populate modal fields with fetched data
                        document.getElementById('name_ar_e').value = data?.name_ar ??'لايوجد';
                        document.getElementById('name_en_e').value = data?.name_en ??'لايوجد';
                        document.getElementById('editpermissionForm').setAttribute('action',
                            `/permission/update/${itemId}`);

                        // Show the modal
                        var editModal = new bootstrap.Modal(document.getElementById(
                            'bs-example-modal-edit'));
                        editModal.show();
                    })
                    .catch(error => console.error('Error fetching item data:', error));
            });
        });
    });
</> --}}


