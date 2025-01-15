<div class="card mt-4 py-3">

        <form method="POST" action="{{ route('tawreed.searchResults', $companyId) }}" class="w-100">
            @csrf    <div class="row pt-3 ">
            <div class="col-md-6 col-sm-12 mb-3">
                <input type="text" class="form-control" placeholder="الموديل" name="model">
            </div>
            <div class="col-md-6 col-sm-12 mb-3">
                <input type="text" class="form-control" placeholder="السريال/الباركود" name="number">
            </div>
            <div class="col-md-6 col-sm-12 mb-3">
                <select class="form-select" name="mark_id">
                    <option selected disabled>الماركة</option>
                    @foreach ($marks as $mark)
                    <option value="{{ $mark->id }}">{{ $mark->name_ar }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 col-sm-12 mb-3">
                <select class="form-select" name="class_id">
                    <option selected disabled>الصنف</option>
                    @foreach ($classes as $class)
                    <option value="{{ $class->id }}">{{ $class->name_ar }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12">
                <button class="btn btn-primary w-100" type="submit">بحث</button>
            </div> </div>
        </form>
        <div class="col-12 my-3">
                <a href=" {{ route('tawreed.cart') }}"
                    class=" btn btn-info  mb-1 bg-primary-subtle text-primary w-100  mb-2">
                    متــابعة
                </a>
           
       
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive pb-4">
            <table id="all-student" class="table table-bordered border text-nowrap align-middle">
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
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>