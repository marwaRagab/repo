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
                  <h2>اضافة استعلام سيارات جديد</h2>

        <div class="card mx-auto" style="width: -webkit-fill-available;">
            <div class="card-body">
                <form action="{{ route('InstallmentCar.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="installment_clients_id" value="{{$Installment_Client->id}}" >

                    <div id="formRows">
                        <div class="row issue-row mb-3" data-index="0">
                            <div class="col">
                                <input type="text" name="installment_car[0][type_car]" class="form-control" placeholder="نوع السيارة"
                                    required />
                            </div>
                            <div class="col">
                                <input type="text" name="installment_car[0][model_year]" class="form-control" placeholder="سنة الموديل"
                                    required />
                            </div>
                            <div class="col">
                                <input type="text" name="installment_car[0][average_price]" class="form-control" placeholder="متوسط السعر"
                                    required />
                            </div>
                            <div class="col">
                                <input type="file" name="installment_car[0][image]" class="form-control" placeholder="صورة"
                                    required />
                            </div>
                            <div class="col-auto">
                                <button type="button" class="btn btn-danger remove-row-btn">ازالة</button>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <button type="button" class="btn btn-secondary" id="addRowBtn">اضافة سيارة جديدة</button>
                    </div>

                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">حفظ</button>
                    </div>
                </form>
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
            <input type="text" name="installment_car[${index}][type_car]" class="form-control" placeholder="نوع السيارة" required>
        </div>
        <div class="col">
            <input type="text" name="installment_car[${index}][model_year]" class="form-control" placeholder="سنة الموديل" required>
        </div>
        <div class="col">
            <input type="text" name="installment_car[${index}][average_price]" class="form-control" placeholder="متوسط السعر" required>
        </div>
        <div class="col">
            <input type="file" name="installment_car[${index}][image]" class="form-control" placeholder="صورة" required>
        </div>
        <div class="col-auto">
            <button type="button" class="btn btn-danger remove-row-btn">ازالة</button>
        </div>
    `;

    formRows.appendChild(newRow);
    addRemoveRowFunctionality();
});

function addRemoveRowFunctionality() {
    document.querySelectorAll('.remove-row-btn').forEach(button => {
        button.addEventListener('click', function() {
            const row = this.closest('.issue-row');
            row.remove();
        });
    });
}

// Initialize remove functionality on initial row
addRemoveRowFunctionality();
    </script>
@endsection
