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
        <a class=" btn-filter me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4 mx-1 mb-2 "
            href="../get_available_products">
            المنتجات المتوفرة
        </a>
    </div>
</div>
<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0"> المنتجات المتوفرة</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive pb-4">
            <table id="file-export" class="table table-bordered border text-nowrap align-middle">
                <thead>
                    <!-- start row -->
                    <tr>
                        <th>م</th>
                        <th>الموديل </th>
                        <!-- <th>الشركه الموردة </th> -->
                        <th> السريال / الباركود</th>


                    </tr>
                    <!-- end row -->
                </thead>
                <tbody>
                    <!-- start row -->
                    @foreach ($items as $item)

                    <tr data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false"
                        aria-controls="collapseExample">
                        <td class="whitespace-nowrap  py-3 sm:px-5">{{ $loop->iteration }}</td>
                        <td class="whitespace-nowrap  py-3 font-medium text-slate-700 dark:text-navy-100 lg:px-2">
                            {{ $item->product->model }}
                        </td>
                        <!-- <td class="whitespace-nowrap  py-3 sm:px-5">{{ $item->product->company->name_ar }}
                            </td> -->
                        @if ($item->product->class_id != 63)
                        <td class="whitespace-nowrap py-3 sm:px-5">
                            {{ $item->product->number }}
                        </td>
                        @else
                        <td class="whitespace-nowrap py-3 sm:px-5">
                            {{ $item->serial_number }}
                        </td>
                        @endif

                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>
