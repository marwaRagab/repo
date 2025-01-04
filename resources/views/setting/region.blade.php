<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0">المناطق</h4>
        <button class="btn me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4" data-bs-toggle="modal"
            data-bs-target="#bs-example-modal-md">
            أضف منطقة
        </button>

        <div id="bs-example-modal-md" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header d-flex align-items-center">
                        <h4 class="modal-title" id="myModalLabel">أضف منطقة</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="regionForm" action="{{ route('region.store') }}" method="POST"
                        enctype="multipart/form-data" onsubmit="return validateRegionForm(event)">
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
                                    <label class="form-label" for="police_station_id">المخفر</label>
                                    <select id="police_station_id" name="police_station_id" class="form-control mb-2">
                                        <option value="">اختر المخفر</option>
                                        @foreach ($data['Police_station'] as $item)
                                            <option value="{{ $item->id }}">{{ $item->name_ar }}</option>
                                        @endforeach
                                    </select>
                                    <small id="police_station_id-error" class="text-danger"></small>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer d-flex">
                            <button type="submit" form="regionForm" class="btn btn-primary">حفظ</button>
                            <button type="button" class="btn bg-danger-subtle text-danger waves-effect"
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
                    <th> الإسم </th>
                    <th>المخفر</th>
                    <th> انشأ بواسطة</th>
                    <th> اخر تحديث بواسطة </th>
                    <th>الإجراءات</th>
                </tr>
                <!-- end row -->
            </thead>
            <tbody>
                <!-- start row -->
                @foreach ($data['region'] as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>
                            {{ $item->name_ar }}
                        </td>
                        <td>
                            {{ $item->police_station->name_ar ?? null }}
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
                                <a href="{{ route('region.destroy', $item->id) }}" class="text-dark delete ms-2">
                                    <i class="ti ti-trash fs-5"></i>
                                </a>
                                <div id="bs-example-modal-edit" class="modal fade" tabindex="-1"
                                    aria-labelledby="bs-example-modal-md" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header d-flex align-items-center">
                                                <h4 class="modal-title" id="myModalLabel">
                                                    تعديل منطقة</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="editregionForm" method="get" enctype="multipart/form-data">
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
                                                                for="police_station_id ">المخفر</label>
                                                            <select id="police_station_id " name="police_station_id "
                                                                class="form-control mb-2">
                                                                @foreach ($data['Police_station'] as $it)
                                                                    <option value="{{ $it->id }}"
                                                                        {{ $it->id == $item->police_station_id ? 'selected' : '' }}>
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
    function validateRegionForm(event) {
        event.preventDefault();

        // Fields to validate
        const input1 = document.getElementById('input1');
        const input2 = document.getElementById('input2');
        const policeStation = document.getElementById('police_station_id');

        // Error message elements
        const input1Error = document.getElementById('input1-error');
        const input2Error = document.getElementById('input2-error');
        const policeStationError = document.getElementById('police_station_id-error');

        let isValid = true;

        // Clear previous error messages
        input1Error.textContent = '';
        input2Error.textContent = '';
        policeStationError.textContent = '';

        // Arabic name validation (only Arabic characters allowed)
        const arabicRegex = /^[\u0600-\u06FF\s]+$/;
        if (!input1.value.trim()) {
            input1Error.textContent = 'الرجاء إدخال الاسم بالعربية';
            isValid = false;
        } else if (!arabicRegex.test(input1.value)) {
            input1Error.textContent = 'الاسم بالعربية يجب أن يحتوي على أحرف عربية فقط';
            isValid = false;
        }

        // English name validation (only English characters allowed)
        const englishRegex = /^[A-Za-z\s]+$/;
        if (!input2.value.trim()) {
            input2Error.textContent = 'الرجاء إدخال الاسم بالإنجليزية';
            isValid = false;
        } else if (!englishRegex.test(input2.value)) {
            input2Error.textContent = 'الاسم بالإنجليزية يجب أن يحتوي على أحرف إنجليزية فقط';
            isValid = false;
        }

        // Police station selection validation
        if (!policeStation.value) {
            policeStationError.textContent = 'الرجاء اختيار المخفر';
            isValid = false;
        }

        // If all fields are valid, submit the form
        if (isValid) {
            document.getElementById('regionForm').submit();
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
                fetch(`region/edit/${itemId}`)
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        // Populate modal fields with fetched data
                        document.getElementById('name_ar_e').value = data?.name_ar ??
                            'لايوجد';
                        document.getElementById('name_en_e').value = data?.name_en ??
                            'لايوجد';
                        document.getElementById('editregionForm').setAttribute('action',
                            `/region/update/${itemId}`);

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
