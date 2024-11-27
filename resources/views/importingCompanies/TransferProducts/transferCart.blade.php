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
<form action="{{ route('transferProduct.transfer') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card mt-4 p-4">
        <h5 class="pb-3">الفواتير</h5>
        <div class="form-rows row align-items-end justify-content-center">
            <div class="form-group col-md-5">
                <label for="monthSelect" class="form-label">المستلم </label>
                <select class="form-control form-select" id="monthSelect" name="transport_id">
                    <option disabled selected>اختر المستلم</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name_ar }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-5">
                <label for="durationSelect" class="form-label"> الفرع</label>
                <select class="form-control form-select" id="durationSelect" name="branch_id">
                    <option disabled selected>اختر الفرع</option>
                    @foreach ($branches as $branch)
                        <option value="{{ $branch->id }}">{{ $branch->name_ar }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-3">
                <label for="image" class="form-label"> صورة الفاتورة</label>
                <input type="file" class="form-control" id="image" accept="image/*" name="img">
            </div>
            <div class="form-group col-md-2">

                <button type="submit" class="btn btn-primary w-100 rounded-2">نقل</button>
            </div>
        </div>
    </div>
</form>
<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0"> عدد المنتجات ( )
        </h4>
    </div>
    <div class="card-body">
        <div class="table-responsive pb-4">
            @if ($cart->count())
                <table id="all" class="table table-bordered table-striped border text-nowrap align-middle">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>الموديل</th>
                            <th>التفاصيل</th>
                            <th>السريال/الباركود</th>
                            <th>حذف</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cart as $product)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $product->model }}</td>
                                <td>{{ $product->description }}</td>
                                <td>{{ $product->number }}</td>
                                <td>
                                    <form action="{{ route('transferProduct.deleteFromCart', $product->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('هل أنت متأكد أنك تريد حذف هذا المنتج؟');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"><i
                                                class="ti ti-trash fs-5"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>لا توجد منتجات في السلة</p>
            @endif
        </div>
    </div>
</div>
