<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0">المعاملات </h4>

    </div>

</div>

<div class="card">
    <div class="card-body">
        <div class="modal-header d-flex align-items-center">
            <h4 class="modal-title" id="myModalLabel">
                أضف استعلام سيارات</h4>
        </div>

        <div class="modal-content" style="overflow: auto !important;">
            {{-- <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myModalLabel">
                    استعلام سيارات </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div> --}}
            <form action="{{ route('InstallmentCar.store') }}" id="CarModelform" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <h5 class="mb-3">معاملة جديدة <span class="text-info"></span></h5>
                    <input type="hidden" name="installment_clients_id" id="installment_clients_id"
                        value="{{ $Installment_client }}">
                    <div class="form-group col-12">
                        <label class="form-label"> هل لديه سياره ؟ </label>
                        <div class="form-check-inline">
                            <input type="radio" name="exist" id="exist" value="exist">
                            <label for="exist">يوجد</label>
                        </div>
                        <div class="form-check-inline">
                            <input type="radio" name="exist" id="notexist" value="notexist" checked>
                            <label for="status_close">لا يوجد</label>
                        </div>
                    </div>

                    <div id="formRows2">
                        <div class="form-row car-row" data-index="0">
                            <div class="form-group mb-3">
                                <label class="form-label"> نوع السيارة</label>
                                <input type="text" name="installment_car[0][type_car]" id="type_car"
                                    class="form-control" placeholder="نوع السيارة" />
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label"> سنة الموديل </label>
                                <input type="text" name="installment_car[0][model_year]" id="model_year"
                                    class="form-control" placeholder="سنة الموديل" />
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label"> متوسط السعر </label>
                                <input type="text" name="installment_car[0][average_price]" id="average_price"
                                    class="form-control" placeholder="متوسط السعر" />
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label"> الصورة </label>
                                <input type="file" name="installment_car[0][image]" id="image"
                                    class="form-control" placeholder="صورة" />
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex ">
                    <button type="button" class="btn btn-secondary" id="addRowBtn2">اضافة سيارة جديدة</button>
                    <button type="button" class="btn btn-primary" id="savecar"
                        onclick="validateCarModalForm()">حفظ</button>
                    <button type="button" class="btn bg-danger-subtle text-danger  waves-effect"
                        data-bs-dismiss="modal">
                        الغاء
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Get radio buttons and extra form row
        const statusOpen = document.getElementById("exist");
        const statusClose = document.getElementById("notexist");
        const extraFormRow = document.getElementById("formRows2");

        //
        // addRowBtn
        const addRowBtn = document.getElementById("addRowBtn2");

        // Function to toggle form row visibility
        function toggleFormRow() {
            if (statusOpen.checked) {
                extraFormRow.style.display = "block"; // Show form row
                addRowBtn.style.display = 'block';

            } else {
                extraFormRow.style.display = "none"; // Hide form row
                addRowBtn.style.display = 'none';


            }
        }

        // Add event listeners to radio buttons
        statusOpen.addEventListener("change", toggleFormRow);
        statusClose.addEventListener("change", toggleFormRow);

        // Initial check in case the page is loaded with "open" selected
        toggleFormRow();
    });

    function validateCarModalForm() {

        const statusOpen = document.getElementById("exist");
        if (statusOpen.checked) {
            const formRows = document.getElementById('formRows2');
            const rows = formRows.querySelectorAll('.car-row');
            // console.log(rows);
            for (const r of rows) {
                const typeCar = r.querySelector('input[name$="[type_car]"]').value.trim();
                const modelYear = r.querySelector('input[name$="[model_year]"]').value.trim();
                const averagePrice = r.querySelector('input[name$="[average_price]"]').value.trim();
                const image = r.querySelector('input[name$="[image]"]').value.trim();

                if (!typeCar) {
                    alert("يرجى إدخال نوع السيارة.");
                    return false;
                }
                if (!modelYear) {
                    alert("يرجى إدخال موديل السيارة.");
                    return false;
                }
                if (!averagePrice) {
                    alert("يرجى إدخال متوسط السعر.");
                    return false;
                }
                if (!image) {
                    alert("يرجى إدخال الصورة.");
                    return false;
                }
            }

            // If all validations pass, submit the form
            document.getElementById('CarModelform').submit();
        } else {
            document.getElementById('CarModelform').submit();
            // document.getElementById('savecar').setAttribute("data-bs-dismiss", "modal");
        }
    }

    document.getElementById('addRowBtn2').addEventListener('click', function() {
        const formRows = document.getElementById('formRows2');
        const index = formRows.children.length;

        const newRow = document.createElement('div');
        newRow.classList.add('row', 'car-row', 'mb-3');
        newRow.setAttribute('data-index', index);

        newRow.innerHTML = `
            <div class="form-row" data-index="0">
                                <div class="form-group mb-3">
                                    <label class="form-label"> نوع السيارة</label>
                                    <input type="text" name="installment_car[${index}][type_car]" class="form-control"
                                        placeholder="نوع السيارة" required />
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label">  سنة الموديل </label>
                                    <input type="text" name="installment_car[${index}][model_year]" class="form-control"
                                        placeholder="سنة الموديل" required />
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label">   متوسط السعر </label>
                                       <input type="text" name="installment_car[${index}][average_price]"
                                        class="form-control" placeholder="متوسط السعر" required />
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label">   الصورة </label>
                                        <input type="file" name="installment_car[${index}][image]" class="form-control"
                                        placeholder="صورة" required />
                                </div>
                                <div class="col-auto">
                                                <button type="button" class="btn btn-danger remove-car-row-btn">ازالة</button>
                                            </div>
                            </div>
                         `;

        formRows.appendChild(newRow);

    });

    // Event delegation for remove buttons
    document.getElementById('formRows2').addEventListener('click', function(event) {
        if (event.target.classList.contains('remove-car-row-btn')) {
            const row = event.target.closest('.car-row');
            row.remove();
            updateRowIndices();
        }
    });

    function updateRowIndices() {
        document.querySelectorAll('.car-row').forEach((row, index) => {
            row.setAttribute('data-index', index);
            row.querySelector('input[name^="car"]').name = `car[${index}][name_en]`;
            row.querySelector('input[name^="car"]').name = `car[${index}][name_ar]`;
        });
    }
</script>
