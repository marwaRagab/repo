<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0">الاقسام</h4>
        <button class="btn me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4" data-bs-toggle="modal"
            data-bs-target="#bs-example-modal-md">
            أضف قسم
        </button>

        <!-- sample modal content -->
        <div id="bs-example-modal-md" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header d-flex align-items-center">
                        <h4 class="modal-title" id="myModalLabel">أضف قسم</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="departmentForm" action="{{ route('departments.store') }}" method="POST"
                        enctype="multipart/form-data" onsubmit="return validateNationalityForm(event)">
                        @csrf
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label" for="input1">الإسم بالعربية</label>
                                    <input type="text" name="name_ar" class="form-control mb-2" id="input1">
                                    <small id="input1-error" class="text-danger"></small>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="input2">الإسم بالإنجليزية</label>
                                    <input type="text" name="name_en" class="form-control mb-2" id="input2">
                                    <small id="input2-error" class="text-danger"></small>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer d-flex">
                            <button type="submit" class="btn btn-primary">حفظ</button>
                            <button type="button" class="btn bg-danger-subtle text-danger waves-effect"
                                data-bs-dismiss="modal">
                                الغاء
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Modal -->
        <div id="editModal" class="modal fade" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header d-flex align-items-center">
                        <h4 class="modal-title" id="editModalLabel">تعديل جنسية</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="editForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="edit_name_ar">الإسم بالعربية</label>
                                <input type="text" name="name_ar" class="form-control mb-2" id="edit_name_ar"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="edit_name_en">الإسم بالإنجليزية</label>
                                <input type="text" name="name_en" class="form-control mb-2" id="edit_name_en"
                                    required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">تحديث</button>
                            <button type="button" class="btn bg-danger-subtle text-danger"
                                data-bs-dismiss="modal">الغاء</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive pb-4">
            <table id="file-export" class="table table-bordered border text-nowrap align-middle">
                <thead>
                    <!-- start row -->
                    <tr>
                        <th>#</th>
                        <th> الإسم </th>
                        <th> انشأ بواسطة</th>
                        <th>الإجراءات</th>

                    </tr>
                    <!-- end row -->
                </thead>
                <tbody>
                    <!-- start row -->
                    @foreach ($department as $item)
                        <tr>
                            <td>
                                {{ $loop->index + 1 }}
                            </td>
                            <td>
                                {{ $item->name_ar }}
                            </td>
                            <td>
                                {{ $item->user->name_ar ?? null }}
                            </td>
                            <td>
                                <div class="action-btn">
                                    <a href="javascript:void(0)" class="text-primary edit" data-id="{{ $item->id }}"
                                        data-name_ar="{{ $item->name_ar }}" data-name_en="{{ $item->name_en }}"
                                        data-bs-toggle="modal" data-bs-target="#editModal">
                                        <i class="ti ti-pencil fs-5"></i>
                                    </a>
                                    <form id="delete-form-{{ $item->id }}"
                                        action="{{ route('nationality.destroy', $item->id) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <a href="javascript:void(0);" class="text-danger"
                                            onclick="confirmDelete({{ $item->id }})">
                                            <i class="ti ti-trash fs-5"></i>
                                        </a>
                                    </form>
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
    function validateNationalityForm(event) {
        event.preventDefault();

        const nameAr = document.getElementById('input1');
        const nameEn = document.getElementById('input2');
        const nameArError = document.getElementById('input1-error');
        const nameEnError = document.getElementById('input2-error');

        let isValid = true;

        // Clear previous error messages
        nameArError.textContent = '';
        nameEnError.textContent = '';

        // Regular expressions for validation
        const arabicRegex = /^[\u0600-\u06FF\s]+$/;
        const englishRegex = /^[A-Za-z\s]+$/;

        // Validate Arabic name field
        if (!nameAr.value.trim()) {
            nameArError.textContent = 'الرجاء إدخال الاسم بالعربية';
            isValid = false;
        } else if (!arabicRegex.test(nameAr.value)) {
            nameArError.textContent = 'الاسم بالعربية يجب أن يحتوي على أحرف عربية فقط';
            isValid = false;
        }

        // Validate English name field
        if (!nameEn.value.trim()) {
            nameEnError.textContent = 'الرجاء إدخال الاسم بالإنجليزية';
            isValid = false;
        } else if (!englishRegex.test(nameEn.value)) {
            nameEnError.textContent = 'الاسم بالإنجليزية يجب أن يحتوي على أحرف إنجليزية فقط';
            isValid = false;
        }

        // If all fields are valid, submit the form
        if (isValid) {
            document.getElementById('nationalityForm').submit();
        }
    }
</script>

<script>
    // delete
    function confirmDelete(id) {
        if (confirm('هل أنت متأكد أنك تريد حذف هذه الجنسية؟')) {
            document.getElementById('delete-form-' + id).submit();
        }
    }

    // edit
    document.addEventListener('DOMContentLoaded', function() {
        // Edit button handler
        document.querySelectorAll('.edit').forEach(button => {
            button.addEventListener('click', function() {
                let id = this.getAttribute('data-id');
                let name_ar = this.getAttribute('data-name_ar');
                let name_en = this.getAttribute('data-name_en');

                document.getElementById('editForm').setAttribute('action',
                    `/nationality/update/${id}`);
                document.getElementById('edit_name_ar').value = name_ar;
                document.getElementById('edit_name_en').value = name_en;
            });
        });

    });
</script>
