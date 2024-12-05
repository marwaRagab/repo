<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0"> المخافر</h4>
        <button class="btn me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4" data-bs-toggle="modal"
            data-bs-target="#bs-example-modal-md">
            أضف المخفر
        </button>

        <!-- Sample modal content -->
        <div id="bs-example-modal-md" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header d-flex align-items-center">
                        <h4 class="modal-title" id="myModalLabel">أضف المخفر</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="policeStationForm" action="{{ route('police_stations.store') }}" method="POST"
                        enctype="multipart/form-data" onsubmit="return validateForm(event)">
                        @csrf
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label" for="input1">الاسم بالعربى</label>
                                    <input type="text" name="name_ar" class="form-control mb-2" id="name_ar">
                                    <small id="name_ar-error" class="text-danger"></small>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="input2">الاسم بالانجليزى</label>
                                    <input type="text" name="name_en" class="form-control mb-2" id="name_en">
                                    <small id="name_en-error" class="text-danger"></small>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="ministry_percentage_id">المنطقة</label>
                                    <select id="ministry_percentage_id" name="governorate_id" class="form-control mb-2">
                                        <option value="">اختر المنطقة</option>
                                        @foreach ($governments as $ite)
                                            <option value="{{ $ite->id }}">{{ $ite->name_ar }}</option>
                                        @endforeach
                                    </select>
                                    <small id="governorate-error" class="text-danger"></small>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer d-flex">
                            <button type="submit" class="btn btn-primary">حفظ</button>
                            <button type="button" class="btn bg-danger-subtle text-danger waves-effect"
                                data-bs-dismiss="modal">الغاء</button>
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
                        <h4 class="modal-title" id="editModalLabel">تعديل مخفر</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="editForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="edit_name_ar">الإسم بالعربي</label>
                                <input type="text" name="name_ar" class="form-control mb-2" id="edit_name_ar"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="edit_name_en">الاسم بالانجليزى</label>
                                <input type="text" name="name_en" class="form-control mb-2" id="edit_name_en"
                                    required>
                            </div>

                            <div class="form-group">
                                <label for="governorate_id">المنطقة</label>
                                <select id="governorate_id" name="governorate_id" class="form-control mb-2">
                                    @foreach ($governments as $ite)
                                        <option value="{{ $ite->id }}">{{ $ite->name_ar }}</option>
                                    @endforeach
                                </select>
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
            <table id="all-student" class="table table-bordered border text-nowrap align-middle">
                <thead>
                    <!-- start row -->
                    <tr>
                        <th>#</th>
                        <th> الاسم </th>
                        <th>المنطقة</th>
                        <th> انشأ بواسطة</th>
                        <th>الإجراءات</th>

                    </tr>
                    <!-- end row -->
                </thead>
                <tbody>
                    <!-- start row -->
                    @foreach ($police_stations as $item)
                        <tr>
                            <td>
                                {{ $loop->index + 1 }}
                            </td>
                            <td>
                                {{ $item->name_ar }}
                            </td>
                            <td>{{ $item->government->name_ar ?? null }}</td>
                            <td>
                                {{ $item->user->name_ar ?? null }}
                            </td>
                            <td>
                                <div class="action-btn">
                                    <a href="javascript:void(0)" class="text-primary edit"
                                        data-id="{{ $item->id }}" data-name_ar="{{ $item->name_ar }}"
                                        data-name_en="{{ $item->name_en }}"
                                        data-ministry_percentage_id="{{ $item->region_id }}" data-bs-toggle="modal"
                                        data-bs-target="#editModal">
                                        <i class="ti ti-pencil fs-5"></i>
                                    </a>

                                    <form id="delete-form-{{ $item->id }}"
                                        action="{{ route('police_stations.destroy', $item->id) }}" method="POST"
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
    function validateForm(event) {
        event.preventDefault();

        // Input elements
        const nameAr = document.getElementById('name_ar');
        const nameEn = document.getElementById('name_en');
        const governorate = document.getElementById('ministry_percentage_id');

        // Error elements
        const nameArError = document.getElementById('name_ar-error');
        const nameEnError = document.getElementById('name_en-error');
        const governorateError = document.getElementById('governorate-error');

        let isValid = true;

        // Clear previous error messages
        nameArError.textContent = '';
        nameEnError.textContent = '';
        governorateError.textContent = '';

        // Arabic name validation
        const arabicRegex = /^[\u0600-\u06FF\s]+$/;
        if (!nameAr.value.trim()) {
            nameArError.textContent = 'الرجاء إدخال الاسم بالعربية';
            isValid = false;
        } else if (!arabicRegex.test(nameAr.value)) {
            nameArError.textContent = 'الاسم بالعربية يجب أن يحتوي على أحرف عربية فقط';
            isValid = false;
        }

        // English name validation
        const englishRegex = /^[A-Za-z\s]+$/;
        if (!nameEn.value.trim()) {
            nameEnError.textContent = 'الرجاء إدخال الاسم بالإنجليزية';
            isValid = false;
        } else if (!englishRegex.test(nameEn.value)) {
            nameEnError.textContent = 'الاسم بالإنجليزية يجب أن يحتوي على أحرف إنجليزية فقط';
            isValid = false;
        }

        // Governorate selection validation
        if (!governorate.value) {
            governorateError.textContent = 'الرجاء اختيار المحافظة';
            isValid = false;
        }

        // Submit form if all fields are valid
        if (isValid) {
            document.getElementById('policeStationForm').submit();
        }
    }
</script>


<script>
    // delete
    function confirmDelete(id) {
        if (confirm('هل أنت متأكد أنك تريد حذف هذا المخفر')) {
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
                let ministryPercentageId = this.getAttribute('data-ministry_percentage_id');

                // Set form action dynamically
                document.getElementById('editForm').setAttribute('action',
                    `/police_stations/update/${id}`);

                // Populate the form fields
                document.getElementById('edit_name_ar').value = name_ar;
                document.getElementById('edit_name_en').value = name_en;

                // Set the selected option in the dropdown
                let selectElement = document.getElementById('region_id');
                selectElement.value = ministryPercentageId;

                $('#editModal').modal('show');
            });
        });
    });
</script>
