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
        <h4 class="card-title mb-0"> جهات العمل</h4>
        <button class="btn me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4 " data-bs-toggle="modal"
            data-bs-target="#bs-example-modal-md">
            أضف الجهة </button>
        <!-- sample modal content -->
        <div id="bs-example-modal-md" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header d-flex align-items-center">
                        <h4 class="modal-title" id="myModalLabel">
                            أضف الجهة</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="regionForm" onsubmit="return validateRegionForm(event)"
                        action="{{ route('WorkingIncome.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="form-row">
                                <!-- Name in Arabic -->
                                <div class="form-group">
                                    <label class="form-label" for="input1">الاسم بالعربى</label>
                                    <input type="text" name="name_ar" class="form-control mb-2" id="input1">
                                    <small id="input1-error" class="text-danger"></small>
                                </div>

                                <!-- Name in English -->
                                <div class="form-group">
                                    <label class="form-label" for="input2">الاسم بالانجليزى</label>
                                    <input type="text" name="name_en" class="form-control mb-2" id="input2">
                                    <small id="input2-error" class="text-danger"></small>
                                </div>

                                <!-- Date -->
                                <div class="form-group">
                                    <label class="form-label" for="input3">التاريخ</label>
                                    <input type="date" name="date" class="form-control mb-2" id="input3">
                                    <small id="input3-error" class="text-danger"></small>
                                </div>

                                <!-- Ministry Percentage -->
                                <div class="form-group">
                                    <label class="form-label" for="ministry_percentage_id">النسبة</label>
                                    <select id="ministry_percentage_id" name="ministry_percentage_id"
                                        class="form-control mb-2">
                                        @foreach ($ministryPercentages as $ite)
                                            <option value="{{ $ite->id }}">{{ $ite->percent }}</option>
                                        @endforeach
                                    </select>
                                    <small id="ministry_percentage_id-error" class="text-danger"></small>
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
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <!-- Edit Modal -->
        <div id="editModal" class="modal fade" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header d-flex align-items-center">
                        <h4 class="modal-title" id="editModalLabel">تعديل جهة</h4>
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
                                <label for="edit_date">التاريخ</label>
                                <input type="date" name="date" class="form-control mb-2" id="edit_date">
                            </div>
                            <div class="form-group">
                                <label for="edit_ministry_percentage">النسبة</label>
                                <select id="edit_ministry_percentage" name="ministry_percentage_id"
                                    class="form-control mb-2">
                                    @foreach ($ministryPercentages as $ite)
                                        <option value="{{ $ite->id }}">{{ $ite->percent }}</option>
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
                        <th>النسبة</th>
                        <th> انشأ بواسطة</th>
                        <th>الإجراءات</th>

                    </tr>
                    <!-- end row -->
                </thead>
                <tbody>
                    <!-- start row -->
                    @foreach ($WorkingIncome as $item)
                        <tr>
                            <td>
                                {{ $loop->index + 1 }}
                            </td>
                            <td>
                                {{ $item->name_ar }}
                            </td>
                            <td>{{ $item->ministryPercentage->percent }}</td>
                            <td>
                                {{ $item->user->name_ar ?? null }}
                            </td>
                            <td>
                                <div class="action-btn">
                                    <a href="javascript:void(0)" class="text-primary edit"
                                        data-id="{{ $item->id }}" data-name_ar="{{ $item->name_ar }}"
                                        data-name_en="{{ $item->name_en }}" data-date="{{ $item->date }}"
                                        data-ministry_percentage_id="{{ $item->ministry_percentage_id }}"
                                        data-bs-toggle="modal" data-bs-target="#editModal">
                                        <i class="ti ti-pencil fs-5"></i>
                                    </a>

                                    <form id="delete-form-{{ $item->id }}"
                                        action="{{ route('WorkingIncome.destroy', $item->id) }}" method="POST"
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
    function validateRegionForm(event) {
        // Prevent form submission to handle validation
        event.preventDefault();

        // Get the values of the fields
        const nameAr = document.getElementById('input1').value.trim();
        const nameEn = document.getElementById('input2').value.trim();
        const date = document.getElementById('input3').value.trim();
        const ministryPercentageId = document.getElementById('ministry_percentage_id').value.trim();

        // Validation flags
        let valid = true;

        // Clear any previous error messages
        const errorMessages = document.querySelectorAll('.text-danger');
        errorMessages.forEach(msg => msg.textContent = '');

        // Validate 'name_ar' field
        if (nameAr === "") {
            valid = false;
            document.getElementById('input1-error').textContent = "الاسم بالعربى مطلوب";
        }

        // Validate 'name_en' field
        if (nameEn === "") {
            valid = false;
            document.getElementById('input2-error').textContent = "الاسم بالانجليزى مطلوب";
        }

        // Validate 'date' field
        if (date === "") {
            valid = false;
            document.getElementById('input3-error').textContent = "التاريخ مطلوب";
        }

        // Validate 'ministry_percentage_id' field
        if (ministryPercentageId === "") {
            valid = false;
            document.getElementById('ministry_percentage_id-error').textContent = "النسبة مطلوبة";
        }

        // If the form is valid, allow submission
        if (valid) {
            // Submit the form programmatically
            document.getElementById('regionForm').submit();
        }

        // Return false to prevent form submission if there are errors
        return valid;
    }
</script>

<script>
    // delete
    function confirmDelete(id) {
        if (confirm('هل أنت متأكد أنك تريد حذف هذه الجهة')) {
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
                let date = this.getAttribute('data-date');
                let ministryPercentageId = this.getAttribute('data-ministry_percentage_id');

                // Set form action dynamically
                document.getElementById('editForm').setAttribute('action',
                    `/WorkingIncome/update/${id}`);

                // Populate the form fields
                document.getElementById('edit_name_ar').value = name_ar;
                document.getElementById('edit_name_en').value = name_en;
                document.getElementById('edit_date').value = date;

                // Set the selected option in the dropdown
                let selectElement = document.getElementById('edit_ministry_percentage');
                selectElement.value = ministryPercentageId;

                $('#editModal').modal('show');
            });
        });
    });
</script>
