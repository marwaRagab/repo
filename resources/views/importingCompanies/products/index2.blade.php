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
<div class="card mt-4 py-3">
    <div class="d-flex flex-wrap ">
        <a class="btn-filter me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4 mx-1 mb-2 ">
            عدد المنتجات ({{ $totalProducts }})
        </a>
        <a class="btn-filter bg-info-subtle text-info px-4 fs-4 mx-1 mb-2">
            اجمالي صافي التكلفة ({{ number_format($totalNetPrice, 2) }})
        </a>
        <a class="btn-filter bg-warning-subtle text-warning px-4 fs-4 mx-1 mb-2">
            اجمالي سعر البيع ({{ number_format($totalPrice, 2) }})
        </a>
    </div>

    <div class="card">
        <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
            <h4 class="card-title mb-0"> المنتجات</h4>
            <div class="d-flex">
                <button class="btn me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4" data-bs-toggle="modal"
                    data-bs-target="#bs-example-modal-md">
                    أضف جديد
                </button>
                <div id="bs-example-modal-md" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable modal-lg">
                        <div class="modal-content">
                            <div class="modal-header d-flex align-items-center">
                                <h4 class="modal-title" id="myModalLabel">اضف جديد</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="{{ route('saving') }}" enctype="multipart/form-data">
                                    @csrf
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <div class="form-row">
                                        <div class="form-group mb-3">
                                            <label class="form-label">الشركة الموردة</label>
                                            <select class="form-select" name="company_id" required>
                                                <option value="">اختر الشركة</option>
                                                @foreach ($Allcompany as $company)
                                                    <option value="{{ $company->id }}">{{ $company->name_ar }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label"> الماركة</label>
                                            <select class="form-select" name="mark_id" required>
                                                <option value="">اختر الماركة</option>
                                                @foreach ($marks as $mark)
                                                    <option value="{{ $mark->id }}">{{ $mark->name_ar }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label"> الصنف</label>
                                            <select class="form-select" name="class_id" required>
                                                <option value="">اختر الصنف</option>
                                                @foreach ($classes as $class)
                                                    <option value="{{ $class->id }}">{{ $class->name_ar }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="input1"> الموديل </label>
                                            <input type="text" class="form-control mb-2" id="input1"
                                                name="model" required>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="input2"> السعر </label>
                                            <input type="text" class="form-control mb-2" id="input2"
                                                name="price" required>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="input3"> صافي التكلفة </label>
                                            <input type="text" class="form-control mb-2" id="input3"
                                                name="net_price" required>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="form-label"> صورة المنتج </label>
                                            <input type="file" name="img" class="form-control mb-2">
                                        </div>
                                        <div class="form-group">
                                            <div class="d-flex justify-content-between mt-3">
                                                <div class="d-flex">
                                                    <label class="block mx-3 mt-3">
                                                        <input class="mx-2" type="radio" name="number_type" value=1
                                                            onclick="toggleInput('barcode')" />
                                                        باركود
                                                    </label>
                                                    <label class="block mt-3 mx-3">
                                                        <input class="mx-2" type="radio" name="number_type" value=0
                                                            onclick="toggleInput('serial')" />
                                                        سريال نمبر
                                                    </label>
                                                </div>
                                            </div>
                                            <div id="barcodeInput" class="hidden mx-3">
                                                <input class="form-input w-100" placeholder="الباركود" type="text"
                                                    name="barcode_number" />
                                            </div>
                                            <div id="serialInput" class="hidden mx-3">

                                                <input class="form-input w-100" placeholder="السريال نمبر"
                                                    type="text" name="serial_number" />
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
                </div>

                <a href=" {{ route('products.print_all') }}"
                    class="btn me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4 "> طباعه </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive pb-4">
                <table id="all-student1" class="table table-bordered border text-nowrap align-middle">
                    <thead>
                        <tr>
                            <th>التسلسل</th>
                            <th>الماركة</th>
                            <th>الموديل</th>
                            <th>الصنف</th>
                            <th>الباركود/السريال</th>
                            <th>صافي التكلفة</th>
                            <th>سعر البيع</th>
                            <th>العمليات</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#all-student1').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('products.data') }}',
            columns: [{
                    data: 'DT_RowIndex', // This field comes from addIndexColumn
                    name: 'DT_RowIndex',
                    orderable: false, // Optional: Prevent sorting
                    searchable: false // Optional: Prevent searching
                },
                {
                    data: 'mark',
                    name: 'mark'
                },
                {
                    data: 'model',
                    name: 'model'
                },
                {
                    data: 'class',
                    name: 'class'
                },
                {
                    data: 'number',
                    name: 'number'
                },
                {
                    data: 'net_price',
                    name: 'net_price'
                },
                {
                    data: 'price',
                    name: 'price'
                },
                {
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false
                },
            ],
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json', // Arabic translations
            }
        });
    });
</script>
<script>
    function toggleInput(type) {
        const barcodeInput = document.getElementById('barcodeInput');
        const serialInput = document.getElementById('serialInput');
        // const numberBarcode = document.getElementsById('barcode_number');
        // const numberSerial = document.getElementsById('serial_number');

        if (type === 'barcode') {
            barcodeInput.classList.remove('hidden');
            serialInput.classList.add('hidden');
            // numberSerial.value = '';
            numberInputField.placeholder = 'الباركود';
        } else if (type === 'serial') {
            serialInput.classList.remove('hidden');
            barcodeInput.classList.add('hidden');
            // numberBarcode.value = '';
            numberInputField.placeholder = 'السريال نمبر';
        }
    }


    window.onload = function() {
        document.getElementById('barcodeInput').classList.add('hidden');
        document.getElementById('serialInput').classList.add('hidden');
    };
</script>
