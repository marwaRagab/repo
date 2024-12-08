<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0">المحاكم</h4>
        <button class="btn me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4" data-bs-toggle="modal"
            data-bs-target="#bs-example-modal-md">
            أضف محكمة
        </button>

        <!-- Sample modal content -->
        <div id="bs-example-modal-md" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header d-flex align-items-center">
                        <h4 class="modal-title" id="myModalLabel">أضف محكمة</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="courtForm" action="{{ route('courts.store') }}" method="POST"
                        enctype="multipart/form-data" onsubmit="return validateCourtForm(event)">
                        @csrf
                        <div class="modal-body">

                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label" for="input1">الإسم بالعربية</label>
                                    <input type="text" class="form-control mb-2" id="input1" name="name_ar">
                                    <small id="input1-error" class="text-danger"></small>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="input2">الإسم بالإنجليزية</label>
                                    <input type="text" class="form-control mb-2" id="input2" name="name_en">
                                    <small id="input2-error" class="text-danger"></small>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="governorate_id">المحافظة</label>
                                    <select id="governorate_id" name="governorate_id" class="form-control mb-2">
                                        @foreach ($data['government'] as $item)
                                            <option value="{{ $item->id }}">{{ $item->name_ar }}</option>
                                        @endforeach
                                    </select>
                                    <small id="governorate_id-error" class="text-danger"></small>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer d-flex">
                            <button type="submit" form="courtForm" class="btn btn-primary">حفظ</button>
                            <button type="button" class="btn bg-danger-subtle text-danger waves-effect"
                                data-bs-dismiss="modal">
                                الغاء
                            </button>
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
                        <th> الإسم بالعربية </th>
                        <th>المحافظة</th>
                        <th> انشأ بواسطة</th>
                        <th> اخر تحديث بواسطة </th>
                        <th>الإجراءات</th>
                    </tr>
                    <!-- end row -->
                </thead>
                <tbody>
                    <!-- start row -->
                    @foreach ($data['courts'] as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>
                                {{ $item->name_ar ?? 'لايوجد' }}
                            </td>
                            <td>
                                {{ $item->government->name_ar ?? 'لايوجد' }}
                            </td>
                            <td>
                                {{ $item->user->name_ar ?? 'لايوجد' }}
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
                                    <a href="{{ route('courts.destroy', $item->id) }}" class="text-dark delete ms-2">
                                        <i class="ti ti-trash fs-5"></i>
                                    </a>
                                    <div id="bs-example-modal-edit" class="modal fade" tabindex="-1"
                                        aria-labelledby="bs-example-modal-md" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header d-flex align-items-center">
                                                    <h4 class="modal-title" id="myModalLabel">
                                                        تعديل محكمة</h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="editcourtsForm" method="get"
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
                                                            <div class="form-group">
                                                                <label class="form-label"
                                                                    for="governorate_id">المحكمة</label>
                                                                <select id="governorate_id" name="governorate_id"
                                                                    class="form-control mb-2">
                                                                    @foreach ($data['government'] as $it)
                                                                        <option value="{{ $it->id }}"
                                                                            {{ $it->id == $item->governorate_id ? 'selected' : '' }}>
                                                                            {{ $it->name_ar }}</option>
                                                                    @endforeach
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
    function validateCourtForm(event) {
        event.preventDefault(); // Prevent form submission if validation fails

        // Get form fields
        const nameAr = document.getElementById('input1');
        const nameEn = document.getElementById('input2');
        const governorateId = document.getElementById('governorate_id');

        // Error message elements
        const nameArError = document.getElementById('input1-error');
        const nameEnError = document.getElementById('input2-error');
        const governorateIdError = document.getElementById('governorate_id-error');

        let isValid = true;

        // Clear previous error messages
        nameArError.textContent = '';
        nameEnError.textContent = '';
        governorateIdError.textContent = '';

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
        if (!governorateId.value) {
            governorateIdError.textContent = 'الرجاء اختيار المحافظة';
            isValid = false;
        }

        // Submit the form if all fields are valid
        if (isValid) {
            document.getElementById('courtForm').submit();
        }
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function() {
                const itemId = this.getAttribute('data-id');
                console.log(itemId);
                // Fetch data for the selected item
                fetch(`courts/edit/${itemId}`)
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        // Populate modal fields with fetched data
                        document.getElementById('name_ar_e').value = data?.name_ar ??
                            'لايوجد';
                        document.getElementById('name_en_e').value = data?.name_en ??
                            'لايوجد';
                        document.getElementById('editcourtsForm').setAttribute('action',
                            `/courts/update/${itemId}`);

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
