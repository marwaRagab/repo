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
    <div class="row pt-3 px-4">
        <form method="POST" action="{{ route('tawreed.searchResults', $companyId) }}" class="w-100">
            @csrf
            <div class="col-md-2 mb-3">
                <input type="text" class="form-control" placeholder="الموديل" name="model">
            </div>
            <div class="col-md-2 mb-3">
                <input type="text" class="form-control" placeholder="السريال/الباركود" name="number">
            </div>
            <div class="col-md-2 mb-3">
                <select class="form-select" name="mark_id">
                    <option selected disabled>الماركة</option>
                    @foreach ($marks as $mark)
                    <option value="{{ $mark->id }}">{{ $mark->name_ar }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 mb-3">
                <select class="form-select" name="class_id">
                    <option selected disabled>الصنف</option>
                    @foreach ($classes as $class)
                    <option value="{{ $class->id }}">{{ $class->name_ar }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 mb-3">
                <button class="btn btn-primary px-4" type="submit">بحث</button>
            </div>
        </form>
        <div class="col-md-2 mb-3">
            <div class="row pt-3 px-4">
                <a href=" {{ route('tawreed.cart') }}"
                    class="btn-filter me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4 mx-1 mb-2">
                    متــابعة
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive pb-4">
            <table id="file-export" class="table table-bordered border text-nowrap align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الماركة </th>
                        <th>الصنف </th>
                        <th>المواصفات </th>
                        <th>الموديل</th>
                        <th> الباركود  </th>
                        <th> سعر البيع </th>
                        <th>اضافة</th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($results) && $results->count())
                    @foreach ($results as $result)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $result->mark->name_ar ?? ''}}</td>
                        <td>{{ $result->class->name_ar }}</td>
                        <td>{!! nl2br(e($result->description)) !!}</td>
                        <td>{{ $result->model }}</td>
                        <td>{{ $result->number }}</td>
                        <td>{{ number_format( $result->price,3) }}</td>
                        <td class="whitespace-nowrap py-3 sm:px-5">
                            <form method="POST" action="{{ route('tawreed.addToCart') }}">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $result->id }}">
                                <input type="hidden" name="count" value="1" min="1">
                                <button type="submit" class="btn bg-primary text-white">اضافة</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="7" class="text-center">لا توجد نتائج</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>