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
        <h4 class="card-title mb-0">البنوك</h4>
        <button class="btn me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4 " data-bs-toggle="modal"
            data-bs-target="#bs-example-modal-md">
            أضف بنك </button>
        <!-- sample modal content -->
        <div id="bs-example-modal-md" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header d-flex align-items-center">
                        <h4 class="modal-title" id="myModalLabel">
                            أضف بنك</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('bank.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label" for="input1 "> الإسم بالعربية</label>
                                    <input type="text" class="form-control mb-2" id="input1" name="name_ar">
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="input2 ">الإسم بالإنجليزية </label>
                                    <input type="text" class="form-control mb-2" id="input2" name="name_en">
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="input2 ">رقم الحساب البنكى</label>
                                    <input type="text" class="form-control mb-2" id="input2"
                                        name="bank_account_number">
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="input2 "> تاريخ الحساب البنكى </label>
                                    <input type="date" class="form-control mb-2" id="input2"
                                        name="bank_account_date">
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="input2 "> iban </label>
                                    <input type="text" class="form-control mb-2" id="input2" name="iban">
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="input2 ">الفرع</label>
                                    <input type="text" class="form-control mb-2" id="input2" name="branch">
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="input2 "> المفوض بالتوقيع 1 </label>
                                    <input type="text" class="form-control mb-2" id="input2"
                                        name="authorized_signatory_1">
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="input2 ">المفوض بالتوقيع 2</label>
                                    <input type="text" class="form-control mb-2" id="input2"
                                        name="authorized_signatory_2">
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="input2 ">المفوض بالتوقيع 3</label>
                                    <input type="text" class="form-control mb-2" id="input2"
                                        name="authorized_signatory_3">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">التفعيل</label>
                                    <select class="form-select" name="active">
                                        <option>أختر </option>
                                        <option value="1" selected>مفعل</option>
                                        <option value="0">غير مفعل</option>
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
                        <th> الإسم بالعربية </th>
                        <th>رقم حساب البنك</th>
                        <th>تاريخ الحساب</th>
                        <th>الفرع</th>
                        <th>IBAN</th>
                        <th>الحالة</th>
                        <th> انشأ بواسطة</th>
                        <th>الإجراءات</th>
                    </tr>
                    <!-- end row -->
                </thead>
                <tbody>
                    <!-- start row -->

                    @foreach ($data['bank'] as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>
                                {{ $item->name_ar }}
                            </td>
                            <td>
                                {{ $item->bank_account_number }}
                            </td>
                            <td>
                                {{ $item->bank_account_date }}
                            </td>
                            <td>
                                {{ $item->branch }}
                            </td>
                            <td>
                                {{ $item->iban }}
                            </td>
                            <td>
                            @if($item->active == 1)
                                    مفعل
                                @else
                                    غير مفعل
                                @endif
                            </td>
                            <td>
                                {{ $item->user->name_ar ?? 'لايوجد' }}
                            </td>
                            <td>
                                <div class="action-btn">
                                    <a class="text-primary edit-btn" data-bs-toggle="modal"
                                        data-bs-target="#bs-example-modal-edit" data-id ="{{ $item->id }}">
                                        <i class="ti ti-pencil fs-5"></i>
                                    </a>

                                    <a class="text-primary show-btn" data-bs-toggle="modal"
                                        data-bs-target="#bs-example-modal-show" data-id ="{{ $item->id }}">
                                        <i class="ti ti-eye fs-5"></i>
                                    </a>

                                    <a href="{{ route('bank.destroy', $item->id) }}" class="text-dark delete ms-2">
                                        <i class="ti ti-trash fs-5"></i>
                                    </a>


                                    <div id="bs-example-modal-edit" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myModalLabel">
                    تعديل بنك</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editBankForm" method="get" enctype="multipart/form-data">
                    @csrf
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="input1 "> الإسم
                                بالعربية</label>
                            <input type="text" class="form-control mb-2" id="name_ar_e" name="name_ar">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="input2 ">الإسم
                                بالإنجليزية </label>
                            <input type="text" class="form-control mb-2" id="name_en_e" name="name_en"
                                value="{{ $item->name_en }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="input2 ">رقم الحساب
                                البنكى</label>
                            <input type="text" class="form-control mb-2" id="bank_account_number_e"
                                name="bank_account_number" value="{{ $item->bank_account_number }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="input2 "> تاريخ الحساب
                                البنكى </label>
                            <input type="date" class="form-control mb-2" id="bank_account_date_e"
                                name="bank_account_date" value="{{ $item->bank_account_date }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="input2 "> iban
                            </label>
                            <input type="text" class="form-control mb-2" id="iban_e" name="iban"
                                value="{{ $item->iban }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="input2 ">الفرع</label>
                            <input type="text" class="form-control mb-2" id="branch_e" name="branch"
                                value="{{ $item->branch }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="input2 "> المفوض
                                بالتوقيع 1 </label>
                            <input type="text" class="form-control mb-2" id="authorized_signatory_1_e"
                                name="authorized_signatory_1" value="{{ $item->authorized_signatory_1 }}">

                            {{-- <img id="authorized_signatory_1_img" alt="" srcset=""> --}}
                            <!-- <img id="authorized_signatory_1_img" width="25%" alt="Signature 1"> -->

                        </div>
                        <div class="form-group">
                            <label class="form-label" for="input2 ">المفوض
                                بالتوقيع 2</label>
                            <input type="text" class="form-control mb-2" id="authorized_signatory_2_e"
                                name="authorized_signatory_2" value="{{ $item->authorized_signatory_2 }}">
                            {{-- <img id="authorized_signatory_2_img"  alt="" srcset=""> --}}
                            <!-- <img id="authorized_signatory_2_img" width="25%" alt="Signature 2"> -->
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="input2 ">المفوض
                                بالتوقيع 3</label>
                            <input type="text" class="form-control mb-2" id="authorized_signatory_3_e"
                                name="authorized_signatory_3" value="{{ $item->authorized_signatory_3 }}">
                            {{-- <img id="authorized_signatory_3_img"  alt="" srcset=""> --}}
                            <!-- <img id="authorized_signatory_3_img" width="25%" alt="Signature 3"> -->
                        </div>
                        <div class="form-group">
                            <label class="form-label">التفعيل</label>
                            <select class="form-select" id="active_e" name="active">
                                <option>أختر </option>
                                <option value="1" selected>مفعل</option>
                                <option value="0">غير مفعل</option>
                            </select>
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

                                    <div id="bs-example-modal-show" class="modal fade" tabindex="-1"
                                        aria-labelledby="bs-example-modal-md" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header d-flex align-items-center">
                                                    <h4 class="modal-title" id="myModalLabel">
                                                        عرض بنك</h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="input1 "> الإسم
                            بالعربية</label>
                        <input type="text" class="form-control mb-2" id="name_ar_s" name="name_ar" disabled>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="input2 ">الإسم
                            بالإنجليزية </label>
                        <input type="text" class="form-control mb-2" id="name_en_s" name="name_en" disabled>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="input2 ">رقم الحساب
                            البنكى</label>
                        <input type="text" class="form-control mb-2" id="bank_account_number_s"
                            name="bank_account_number"disabled>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="input2 "> تاريخ الحساب
                            البنكى </label>
                        <input type="date" class="form-control mb-2" id="bank_account_date_s"
                            name="bank_account_date" disabled>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="input2 "> iban
                        </label>
                        <input type="text" class="form-control mb-2" id="iban_s" name="iban" disabled>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="input2 ">الفرع</label>
                        <input type="text" class="form-control mb-2" id="branch_s" name="branch" disabled>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="input2 "> المفوض
                            بالتوقيع 1 </label>
                            <input type="text" class="form-control mb-2" id="authorized_signatory_1_s" name="authorized_signatory_1" disabled>
                        <!-- <img id="authorized_signatory_1_img_s" width="25%" alt="Signature 1"> -->

                    </div>
                    <div class="form-group">
                        <label class="form-label" for="input2 ">المفوض
                            بالتوقيع 2</label>
                            <input type="text" class="form-control mb-2" id="authorized_signatory_2_s" name="authorized_signatory_2" disabled>
                        <!-- <img id="authorized_signatory_2_img_s" width="25%" alt="Signature 2"> -->
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="input2 ">المفوض
                            بالتوقيع 3</label>
                            <input type="text" class="form-control mb-2" id="authorized_signatory_3_s" name="authorized_signatory_3" disabled>
                        <!-- <img id="authorized_signatory_3_img_s" width="25%" alt="Signature 3"> -->
                    </div>
                    <div class="form-group">
                        <label class="form-label">التفعيل</label>
                        <input class="form-control" id="active_s" name="active" disabled>
                    </div>
                    <div class="form-group">
                        <label class="form-label">انشأ بواسطة</label>
                        <input class="form-control" id="create_by_s" disabled>
                    </div>
                    <div class="form-group">
                        <label class="form-label">اخرتعديل بواسطة</label>
                        <input class="form-control" id="update_by_s" disabled>
                    </div>
                </div>


                                                </div>

                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
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


<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function() {
                const itemId = this.getAttribute('data-id');
                console.log(itemId);
                // Fetch data for the selected item
                fetch(`bank/edit/${itemId}`)
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);

                        // Populate modal fields with fetched data
                        document.getElementById('name_ar_e').value = data?.name_ar ??
                            'لايوجد';
                        document.getElementById('name_en_e').value = data?.name_en ??
                            'لايوجد';
                        document.getElementById('bank_account_number_e').value = data
                            ?.bank_account_number ?? 'لايوجد';
                        document.getElementById('bank_account_date_e').value = data
                            ?.bank_account_date ?? 'لايوجد';
                        document.getElementById('active_e').value = data?.active ??
                            'لايوجد';
                        document.getElementById('branch_e').value = data?.branch ??
                            'لايوجد';
                        document.getElementById('iban_e').value = data?.iban ?? 'لايوجد';

                        document.getElementById('authorized_signatory_1_e').value = data?.authorized_signatory_1 ?? 'لايوجد';
                        document.getElementById('authorized_signatory_2_e').value = data?.authorized_signatory_2 ?? 'لايوجد';
                        document.getElementById('authorized_signatory_3_e').value = data?.authorized_signatory_3 ?? 'لايوجد';
                        // document.getElementById('authorized_signatory_1_img').src = data
                        //     ?.authorized_signatory_1 || 'path/to/default-image1.jpg';
                        // document.getElementById('authorized_signatory_2_img').src = data
                        //     ?.authorized_signatory_2 || 'path/to/default-image2.jpg';
                        // document.getElementById('authorized_signatory_3_img').src = data
                        //     ?.authorized_signatory_3 || 'path/to/default-image3.jpg';


                        // Populate other fields as needed

                        // Set form action dynamically for the edit form
                        document.getElementById('editBankForm').setAttribute('action',
                            `/bank/update/${itemId}`);

                        // Show the modal
                        var editModal = new bootstrap.Modal(document.getElementById(
                            'bs-example-modal-edit'));
                        editModal.show();
                    })
                    .catch(error => console.error('Error fetching item data:', error));
            });
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.show-btn').forEach(button => {
            button.addEventListener('click', function() {
                const itemId = this.getAttribute('data-id');
                console.log(itemId);
                // Fetch data for the selected item
                fetch(`bank/show/${itemId}`)
                    .then(response => response.json())
                    .then(data => {
                        // console.log(data?.user);

                        // Populate modal fields with fetched data
                        document.getElementById('name_ar_s').value = data?.name_ar ??
                            'لايوجد';
                        document.getElementById('name_en_s').value = data?.name_en ??
                            'لايوجد';
                        document.getElementById('bank_account_number_s').value = data
                            ?.bank_account_number ?? 'لايوجد';
                        document.getElementById('bank_account_date_s').value = data
                            ?.bank_account_date ?? 'لايوجد';
                        document.getElementById('active_s').value = data?.active == "1" ?
                            'مفعل' : 'غير مفعل';
                        document.getElementById('branch_s').value = data?.branch ??
                            'لايوجد';
                        document.getElementById('iban_s').value = data?.iban ?? 'لايوجد';
                        document.getElementById('create_by_s').value = data?.user?.name_ar ?? 'لايوجد';
                        document.getElementById('update_by_s').value = data?.user?.name_ar ?? 'لايوجد';
                        document.getElementById('authorized_signatory_1_s').value = data?.authorized_signatory_1 ?? 'لايوجد';
                        document.getElementById('authorized_signatory_2_s').value = data?.authorized_signatory_2 ?? 'لايوجد';
                        document.getElementById('authorized_signatory_3_s').value = data?.authorized_signatory_3 ?? 'لايوجد';
                        // document.getElementById('authorized_signatory_1_img_s').src = data?.authorized_signatory_1 || 'path/to/default-image1.jpg';
                        // document.getElementById('authorized_signatory_2_img_s').src = data?.authorized_signatory_2 || 'path/to/default-image2.jpg';
                        // document.getElementById('authorized_signatory_3_img_s').src = data?.authorized_signatory_3 || 'path/to/default-image3.jpg';

                        // Show the modal
                        var showModal = new bootstrap.Modal(document.getElementById(
                            'bs-example-modal-show'));
                        showModal.show();
                    })
                    .catch(error => console.error('Error fetching item data:', error));
            });
        });
    });
</script>
