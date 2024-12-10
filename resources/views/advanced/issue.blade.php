<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0">المعاملات </h4>

    </div>

</div>

<div class="card">
    <div class="card-body">
        <div class="modal-header d-flex align-items-center">
            <h4 class="modal-title" id="myModalLabel">
                أضف استعلام قضائى</h4>
        </div>

        <div class="modal-content" style="overflow: auto !important;">

            <form action="{{ route('installmentIssue.store') }}" id="issueModelform" method="POST"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="installment_clients_id" id="installment_clients_id"
                    value="{{ $Installment_client }}">
                <div class="modal-body">
                    <div class="form-row row" data-index="0">
                        <div class="form-group mb-3 col-6">
                            <label class="form-label"> ملف القضية </label>
                            <input type="file" id="issue_pdf" name="issue_pdf" accept=".pdf" class="form-control"
                                required />
                        </div>
                    </div>
                    <div class="form-group col-12">
                        <label class="form-label"> هل لديه قضايا ؟ </label>
                        <div class="form-check-inline">
                            <input type="radio" name="exist1" id="exist1" value="exist">
                            <label for="exist">يوجد</label>
                        </div>
                        <div class="form-check-inline">
                            <input type="radio" name="exist1" id="notexist1" value="notexist" checked>
                            <label for="status_close">لا يوجد</label>
                        </div>
                    </div>
                    <div id="formRows">
                        <div class="form-row row issue-row" data-index="0">
                            <div class="form-group mb-3 col-6">
                                <label class="form-label"> رقم القضية </label>
                                <input type="text" name="installment_issue[0][number_issue]" class="form-control"
                                    required />
                            </div>
                            <div class="form-group mb-3 col-6">
                                <label class="form-label"> الجهة </label>
                                <input type="text" name="installment_issue[0][working_company]" class="form-control"
                                    required />
                            </div>
                            <div class="form-group mb-3 col-6">
                                <label class="form-label"> مبلغ المفتوح </label>
                                <input type="text" name="installment_issue[0][opening_amount]" class="form-control"
                                    required />
                            </div>
                            <div class="form-group mb-3 col-6">
                                <label class="form-label"> مبلغ المغلق </label>
                                <input type="text" name="installment_issue[0][closing_amount]" class="form-control"
                                    required />
                            </div>
                            <div class="form-group mb-3 col-6">
                                <label class="form-label"> صورة القضية </label>
                                <input class="form-control" type="file" name="installment_issue[0][image]"
                                    required />
                            </div>

                            <div class="form-group col-6">
                                <label class="form-label"> التاريخ </label>
                                <input type="date" name="installment_issue[0][date]" class="form-control" required />
                            </div>
                            <div class="form-group col-12">
                                <label class="form-label"> الحالة </label>
                                <div class="form-check-inline">
                                    <input class="" type="radio" name="installment_issue[0][status]"
                                        id="flexRadioDefault1">
                                    <label class="" for="flexRadioDefault1">
                                        مفتوح
                                    </label>
                                </div>
                                <div class="form-check-inline">
                                    <input class="" type="radio" name="installment_issue[0][status]"
                                        id="flexRadioDefault2" value="close" checked>
                                    <label class="" for="flexRadioDefault2">
                                        مغلق
                                    </label>


                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 d-flex align-items-center border-top pt-3">
                        {{-- <button type="button" class="btn btn-danger remove-row-btn ">حذف </button> --}}
                        <button type="button" class="btn btn-secondary mx-2" id="addRowBtn1">اضافة قضية
                            جديدة</button>
                    </div>
                    <div class="form-row" id="total">
                        <div class="form-group">
                            <label class="form-label"> مجموع المفنوح </label>
                            <input type="text" name="opening_total" id="opening_total" class="form-control"
                                readonly />
                        </div>
                        <div class="form-group">
                            <label class="form-label"> مجموع المغلق </label>
                            <input type="text" name="closing_total" id="closing_total" class="form-control"
                                readonly />
                        </div>
                        <div class="form-group">
                            <label class="form-label"> مجموع الكلي </label>
                            <input type="text" id="totalll" name="total_IC" class="form-control" readonly />
                        </div>
                    </div>

                </div>
                <div class="modal-footer d-flex ">
                    <button type="button" class="btn btn-primary" id="saveissue"
                        onclick="validateIssueModalForm()">حفظ</button>
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
    document.getElementById('issue_pdf').addEventListener('change', function(e) {
        const file = e.target.files[0]; // Get the file from input

        // Check if a file was selected
        if (file) {
            // Validate file type by checking extension or MIME type
            const fileType = file.type; // Get MIME type (e.g., "application/pdf")
            const fileExtension = file.name.split('.').pop().toLowerCase(); // Get file extension

            if (fileType !== 'application/pdf' && fileExtension !== 'pdf') {
                alert('يسمح لك فقط برفع ملف من نوع pdf');
                e.target.value = ''; // Clear the input field
            }
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        const formRows = document.getElementById('formRows');
        const openingTotalInput = document.getElementById('opening_total');
        const closingTotalInput = document.getElementById('closing_total');
        const totalInputt = document.getElementById('totalll');

        // console.log("sd",totalInputt);

        function calculateTotals() {
            let openingTotal = 0;
            let closingTotal = 0;
            let total = 0;

            // Select all opening_amount fields
            const openingAmountInputs = formRows.querySelectorAll(
                'input[name^="installment_issue"][name$="[opening_amount]"]');
            const closingAmountInputs = formRows.querySelectorAll(
                'input[name^="installment_issue"][name$="[closing_amount]"]');

            openingAmountInputs.forEach(input => {
                const value = parseFloat(input.value) ||
                    0; // Convert value to float, default to 0 if NaN
                openingTotal += value;
                total += value;
            });

            closingAmountInputs.forEach(input => {
                const value = parseFloat(input.value) ||
                    0; // Convert value to float, default to 0 if NaN
                closingTotal += value;
                total += value;
            });

            // total = openingTotal + closingTotal;

            // Update total inputs and format them
            openingTotalInput.value = openingTotal.toFixed(2);
            closingTotalInput.value = closingTotal.toFixed(2);
            totalInputt.value = total.toFixed(2);

            // console.log(`Opening Total: ${openingTotal}, Closing Total: ${closingTotal}, Total: ${total}`); // Debugging log
        }

        // Attach event listeners to all relevant fields
        formRows.addEventListener('input', function(event) {
            if (event.target.name.endsWith('[opening_amount]') || event.target.name.endsWith(
                    '[closing_amount]')) {
                calculateTotals();
            }
        });

        // Initial calculation in case there are pre-filled values
        calculateTotals();
    });

    document.addEventListener("DOMContentLoaded", function() {
        // Get radio buttons and extra form row
        const statusOpen1 = document.getElementById("exist1");
        const statusClose1 = document.getElementById("notexist1");
        const extraFormRowIsuue = document.getElementById("formRows");
        //
        // addRowBtn
        const addRowBtnIssue = document.getElementById("addRowBtn1");
        // Function to toggle form row visibility
        function toggleFormRow1() {
            if (statusOpen1.checked) {
                extraFormRowIsuue.style.display = "block"; // Show form row
                addRowBtnIssue.style.display = 'block';
            } else {
                extraFormRowIsuue.style.display = "none"; // Show form row
                addRowBtnIssue.style.display = 'none';

            }
        }

        // Add event listeners to radio buttons
        statusOpen1.addEventListener("change", toggleFormRow1);
        statusClose1.addEventListener("change", toggleFormRow1);

        // Initial check in case the page is loaded with "open" selected
        toggleFormRow1();
    });

    document.addEventListener('DOMContentLoaded', function() {
        const formRows = document.getElementById('formRows');

        document.getElementById('addRowBtn1').addEventListener('click', function() {
            const index = formRows.children.length;

            const newRow = document.createElement('div');
            newRow.classList.add('row', 'issue-row', 'mb-3');
            newRow.setAttribute('data-index', index);

            newRow.innerHTML = `
                    <div class="form-group mb-3 col-6">
                        <label class="form-label"> رقم القضية </label>
                        <input type="text" name="installment_issue[${index}][number_issue]" class="form-control" required />
                    </div>
                    <div class="form-group mb-3 col-6">
                        <label class="form-label"> الجهة  </label>
                        <input type="text" name="installment_issue[${index}][working_company]" class="form-control" required />
                    </div>
                    <div class="form-group mb-3 col-6">
                        <label class="form-label"> مبلغ المفتوح  </label>
                        <input type="text" name="installment_issue[${index}][opening_amount]" class="form-control"  />
                    </div>
                    <div class="form-group mb-3 col-6">
                        <label class="form-label"> مبلغ المغلق  </label>
                        <input type="text" name="installment_issue[${index}][closing_amount]" class="form-control"  />
                    </div>
                    <div class="form-group mb-3 col-6">
                        <label class="form-label">  صورة القضية  </label>
                        <input class="form-control" type="file" name="installment_issue[${index}][image]" required />
                    </div>
                    <div class="form-group col-6">
                        <label class="form-label">  التاريخ </label>
                        <input type="date" name="installment_issue[${index}][date]" class="form-control" required />
                    </div>
                    <div class="form-group col-12">
                        <label class="form-label"> الحالة  </label>
                        <div class="form-check-inline">
                            <input class="" type="radio" name="installment_issue[${index}][status]" id="flexRadioDefaultOpen${index}">
                            <label for="flexRadioDefaultOpen${index}"> مفتوح </label>
                        </div>
                        <div class="form-check-inline">
                            <input class="" type="radio" name="installment_issue[${index}][status]" value="close" id="flexRadioDefaultClose${index}" checked>
                            <label for="flexRadioDefaultClose${index}"> مغلق </label>
                        </div>
                        <div class="col-auto">
                                                <button type="button" class="btn btn-danger remove-row-btn">ازالة</button>
                                            </div>
                    </div>
                `;

            formRows.appendChild(newRow);
            const statusOpen1 = document.getElementById("exist1");
            if (statusOpen1 && statusOpen1.checked) {
                addToggleFunctionality(index); // Add toggle functionality for the new row
            }

        });
        formRows.addEventListener('click', function(event) {
            if (event.target.classList.contains('remove-row-btn')) {
                const row = event.target.closest('.issue-row');
                row.remove();
                updateRowIndices(); // Update indices after removing a row
            }
        });

        function addToggleFunctionality(index) {
            const closingAmountField = document.querySelector(
                `input[name="installment_issue[${index}][closing_amount]"]`);
            const openingAmountField = document.querySelector(
                `input[name="installment_issue[${index}][opening_amount]"]`);
            const openStatusRadio = document.getElementById(`flexRadioDefaultOpen${index}`);
            const closeStatusRadio = document.getElementById(`flexRadioDefaultClose${index}`);

            // Function to toggle the disabled state of opening and closing amount fields
            function toggleAmountFields() {
                if (openStatusRadio && openStatusRadio.checked) {
                    closingAmountField.disabled = true;
                    closingAmountField.value = 0;
                    openingAmountField.disabled = false;
                    openingAmountField.value = "";
                } else if (closeStatusRadio && closeStatusRadio.checked) {
                    openingAmountField.disabled = true;
                    openingAmountField.value = 0;
                    closingAmountField.disabled = false;
                    closingAmountField.value = "";
                }
            }

            // Add event listeners for both radio buttons
            if (openStatusRadio) openStatusRadio.addEventListener('change', toggleAmountFields);
            if (closeStatusRadio) closeStatusRadio.addEventListener('change', toggleAmountFields);

            // Initial check when row is added
            toggleAmountFields();
        }

        // Initialize toggle functionality for existing rows if any
        formRows.querySelectorAll('.issue-row').forEach((row, index) => {
            addToggleFunctionality(index);
        });

        function updateRowIndices() {
            document.querySelectorAll('.issue-row').forEach((row, index) => {
                row.setAttribute('data-index', index);
                row.querySelector('input[name^="installment_issue"][name$="[number_issue]"]').name =
                    `installment_issue[${index}][number_issue]`;
                row.querySelector('input[name^="installment_issue"][name$="[working_company]"]').name =
                    `installment_issue[${index}][working_company]`;
                row.querySelector('input[name^="installment_issue"][name$="[opening_amount]"]').name =
                    `installment_issue[${index}][opening_amount]`;
                row.querySelector('input[name^="installment_issue"][name$="[closing_amount]"]').name =
                    `installment_issue[${index}][closing_amount]`;
                row.querySelector('input[name^="installment_issue"][name$="[image]"]').name =
                    `installment_issue[${index}][image]`;
                row.querySelector('input[name^="installment_issue"][name$="[date]"]').name =
                    `installment_issue[${index}][date]`;
                row.querySelector('input[id^="flexRadioDefaultOpen"]').id =
                    `flexRadioDefaultOpen${index}`;
                row.querySelector('label[for^="flexRadioDefaultOpen"]').setAttribute("for",
                    `flexRadioDefaultOpen${index}`);
                row.querySelector('input[id^="flexRadioDefaultClose"]').id =
                    `flexRadioDefaultClose${index}`;
                row.querySelector('label[for^="flexRadioDefaultClose"]').setAttribute("for",
                    `flexRadioDefaultClose${index}`);
            });
        }

    });

    document.addEventListener('DOMContentLoaded', function() {
        const closingAmountField = document.querySelector('input[name="installment_issue[0][closing_amount]"]');
        const openingAmountField = document.querySelector('input[name="installment_issue[0][opening_amount]"]');
        const openStatusRadio = document.getElementById('flexRadioDefault1');
        const closeStatusRadio = document.getElementById('flexRadioDefault2');

        // Function to toggle the disabled state of opening and closing amount fields
        function toggleAmountFields() {
            if (openStatusRadio && closeStatusRadio && closingAmountField && openingAmountField) {
                if (openStatusRadio.checked) {
                    closingAmountField.disabled = true;
                    closingAmountField.value = 0; // Clear the value when disabled
                    openingAmountField.value = "";
                    openingAmountField.disabled = false; // Enable opening amount field
                } else if (closeStatusRadio.checked) {
                    openingAmountField.disabled = true;
                    openingAmountField.value = 0; // Clear the value when disabled
                    closingAmountField.value = "";
                    closingAmountField.disabled = false; // Enable closing amount field
                }
            }
        }

        // Listen for changes on both radio buttons, if they exist
        if (openStatusRadio) openStatusRadio.addEventListener('change', toggleAmountFields);
        if (closeStatusRadio) closeStatusRadio.addEventListener('change', toggleAmountFields);

        // Initial check when the modal is loaded
        toggleAmountFields();
    });

    function validateIssueModalForm() {

        const statusOpen1 = document.getElementById("exist1");
        const issue_pdf = document.getElementById('issue_pdf').value.trim();
        if (statusOpen1.checked) {
            const formRows1 = document.getElementById('formRows');
            const rows1 = formRows1.querySelectorAll('.issue-row');

            console.log(rows1);

            if (!issue_pdf) {
                alert("يرجى إدخال  ملف القضية.");
                return false;
            }
            // console.log(rows);
            for (const row of rows1) {
                const number_issue = row.querySelector('input[name$="[number_issue]"]').value.trim();
                const working_company = row.querySelector('input[name$="[working_company]"]').value.trim();
                const date = row.querySelector('input[name$="[date]"]').value.trim();
                const image = row.querySelector('input[name$="[image]"]').value.trim();

                if (!number_issue) {
                    alert("يرجى إدخال  رقم القضية.");
                    return false;
                }
                if (!working_company) {
                    alert("يرجى إدخال  الجهه.");
                    return false;
                }
                if (!date) {
                    alert("يرجى إدخال  التاريخ.");
                    return false;
                }
                if (!image) {
                    alert("يرجى إدخال الصورة.");
                    return false;
                }
            }


            // If all validations pass, submit the form
            document.getElementById('issueModelform').submit();
        } else {
            if (!issue_pdf) {
                alert("يرجى إدخال  ملف القضية.");
                return false;
            }
            // document.getElementById('saveissue').setAttribute("data-bs-dismiss", "modal");
            document.getElementById('issueModelform').submit();
        }
    }
</script>
