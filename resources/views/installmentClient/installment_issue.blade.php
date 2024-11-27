@extends('header.index')
@section('content')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css">

    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Include Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        <div class="flex items-center justify-between space-x-4 space-x-reverse py-5 lg:py-6">
            <ul class="hidden flex-wrap items-center space-x-2 space-x-reverse sm:flex">
                <li class="flex items-center space-x-2 space-x-reverse">
                    <a class="text-primary transition-colors hover:text-primary-focus dark:text-accent-light dark:hover:text-accent"
                        href="#">المعاملات المقدمة</a>
                    <svg x-ignore xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </li>
                <li>المتقدمين</li>
            </ul>

        </div>


        <div class="row">
            <div class="col-md-12">
                <div class="card mx-auto" style="">
                    <div class="card-body p-5">
                        <form action="{{ route('installmentIssue.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" name="installment_clients_id" value="{{ $data }}">

                            <div id="formRows">
                                <div class="row issue-row mb-3" data-index="0">
                                    <div class="col">
                                        <p>رقم القضية</ح>
                                            <input type="text" name="installment_issue[0][number_issue]"
                                                class="form-control" required />
                                    </div>
                                    <div class="col">
                                        <p> الحالة</p>
                                        <div class="form-check">
                                            <label class="" for="flexRadioDefault1">
                                                مفتوح
                                            </label>
                                            <input class="" type="radio" name="installment_issue[0][status]"
                                                id="flexRadioDefault1" >

                                        </div>
                                        <div class="form-check">
                                            <label class="" for="flexRadioDefault2">
                                                مغلق
                                            </label>
                                            <input class="" type="radio"  name="installment_issue[0][status]"
                                                id="flexRadioDefault2" value="close" checked>

                                        </div>
                                    </div>
                                    <div class="col">
                                        <p>الجهه</p>
                                        <input type="text" name="installment_issue[0][working_company]"
                                            class="form-control" required />
                                    </div>
                                    <div class="col">
                                        <p>مبلغ المفتوح</p>
                                        <input type="text" name="installment_issue[0][opening_amount]"
                                            class="form-control" required />
                                    </div>
                                    <div class="col">
                                        <p>مبلغ المغلق</p>
                                        <input type="text" name="installment_issue[0][closing_amount]"
                                            class="form-control" required />
                                    </div>
                                    <div class="col">
                                        <p>صورة القضية</p>
                                            <input type="file" name="installment_issue[0][image]" required>

                                    </div>
                                    <div class="col">
                                        <p>التاريخ</p>
                                        <input type="date" name="installment_issue[0][date]" class="form-control"
                                            required />
                                    </div>
                                    <div class="col">
                                        <p>ازالة</p>
                                        <button type="button" class="btn btn-danger remove-row-btn">Remove</button>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 text-left">
                                <button type="button" class="btn btn-secondary" id="addRowBtn">Add Another Issue</button>
                            </div>
                            <div class="row" id ="total" style="display: none;">
                                <div class="mb-3 col">
                                    <p>مجموع المفنوح</p>
                                    <input type="text" name="opening_total" id="opening_total"
                                                class="form-control" readonly />

                                </div>
                                <div class="mb-3 col">
                                    <p>مجموع المغلق</p>
                                    <input type="text" name="closing_total" id="closing_total"
                                                class="form-control" readonly />
                                </div>
                                <div class="mb-3 col">
                                    <p>مجموع الكلى</p>
                                    <input type="text" id="totalll" name="total_IC" class="form-control" readonly />
                                </div>
                            </div>


                            <div class="text-left">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>



        </div>
        </div>
    </main>

    <script>
        document.getElementById('addRowBtn').addEventListener('click', function() {
            const formRows = document.getElementById('formRows');
            const index = formRows.children.length;

            const newRow = document.createElement('div');
            newRow.classList.add('row', 'issue-row', 'mb-3');
            newRow.setAttribute('data-index', index);

            newRow.innerHTML = `
                            <div class="col">
                                                            <p>رقم القضية</ح>
                                                            <input type="text" name="installment_issue[${index}][number_issue]" class="form-control"
                                                                required />
                                                        </div>
                                                        <div class="col" >
                                                            <p> الحالة</p>
                                                                <div class="form-check">
                                                                    <label class="" for="flexRadioDefault1">
                                                                        مفتوح
                                                                    </label>
                                                                    <input class="" type="radio" name="installment_issue[${index}][status]" value="open" id="flexRadioDefault1">

                                                                </div>
                                                                <div class="form-check">
                                                                    <label class="" for="flexRadioDefault2">
                                                                        مغلق
                                                                    </label>
                                                                    <input class="" type="radio" name="installment_issue[${index}][status]" value="close" id="flexRadioDefault2" checked>

                                                                </div>
                                                        </div>
                                                        <div class="col">
                                                            <p>الجهه</p>
                                                            <input type="text" name="installment_issue[${index}][working_company]" class="form-control"
                                                                required />
                                                        </div>
                                                        <div class="col">
                                                            <p>مبلغ المفتوح</p>
                                                            <input type="text" name="installment_issue[${index}][opening_amount]" class="form-control"
                                                                required />
                                                        </div>
                                                        <div class="col">
                                                            <p>مبلغ المغلق</p>
                                                            <input type="text" name="installment_issue[${index}][closing_amount]" class="form-control"
                                                                required />
                                                        </div>
                                                        <div class="col">
                                                            <p>صورة القضية</p>
                                                            <input type="file" name="installment_issue[${index}][image]">

                                                        </div>
                                                        <div class="col">
                                                            <p>التاريخ</p>
                                                            <input type="date" name="installment_issue[${index}][date]" class="form-control"
                                                                required />
                                                        </div>
                            <div class="col-auto ">
                            <p>ازالة</p>
                                <button type="button" class="btn btn-danger remove-row-btn">Remove</button>
                            </div>
                             `;

            formRows.appendChild(newRow);
            document.getElementById('total').style.display ="flex";
            addRemoveRowFunctionality();
        });

        function addRemoveRowFunctionality() {
            document.querySelectorAll('.remove-row-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const row = this.closest('.issue-row');
                    row.remove();
                    updateRowIndices();
                });
            });
        }

        function updateRowIndices() {
            document.querySelectorAll('.issue-row').forEach((row, index) => {
                row.setAttribute('data-index', index);
                row.querySelector('input[name^="issue"]').name = `issue[${index}][name_en]`;
                row.querySelector('input[name^="issue"]').name = `issue[${index}][name_ar]`;
            });
        }

        // Initialize remove functionality on initial row
        addRemoveRowFunctionality();
    </script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
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
            const openingAmountInputs = formRows.querySelectorAll('input[name^="installment_issue"][name$="[opening_amount]"]');
            const closingAmountInputs = formRows.querySelectorAll('input[name^="installment_issue"][name$="[closing_amount]"]');

            openingAmountInputs.forEach(input => {
                const value = parseFloat(input.value) || 0; // Convert value to float, default to 0 if NaN
                openingTotal += value;
                total+= value;
            });

            closingAmountInputs.forEach(input => {
                const value = parseFloat(input.value) || 0; // Convert value to float, default to 0 if NaN
                closingTotal += value;
                total+= value;
            });

            // total = openingTotal + closingTotal;

            // Update total inputs and format them
            openingTotalInput.value = openingTotal.toFixed(2);
            closingTotalInput.value = closingTotal.toFixed(2);
            totalInputt.value = total.toFixed(2);

            // console.log(`Opening Total: ${openingTotal}, Closing Total: ${closingTotal}, Total: ${total}`); // Debugging log
        }

        // Attach event listeners to all relevant fields
        formRows.addEventListener('input', function (event) {
            if (event.target.name.endsWith('[opening_amount]') || event.target.name.endsWith('[closing_amount]')) {
                calculateTotals();
            }
        });

        // Initial calculation in case there are pre-filled values
        calculateTotals();
    });
</script>


@endsection
