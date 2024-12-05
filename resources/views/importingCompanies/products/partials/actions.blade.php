<div class="d-flex">
    <button class="btn me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4" data-bs-toggle="modal"
        data-bs-target="#edit-example-modal-md-{{ $product->id }}">
        تعديل
    </button>
    @php

$user_id=Auth::user()->id;
$user= \App\Models\User::findorfail($user_id);
 $per= $user->hasPermission('delete_products');
    @endphp
    @if(auth()->user()->hasPermission('delete_products'))
    <form method="POST" action="{{ route('deleting', $product->id) }}"
        onsubmit="return confirm('هل أنت متأكد أنك تريد حذف هذا المنتج؟');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn bg-danger-subtle text-danger waves-effect" title="حذف">
            <i class="fas fa-trash-alt"></i>
        </button>
    </form>
    @endif

    <div id="edit-example-modal-md-{{ $product->id }}" class="modal fade" tabindex="-1"
        aria-labelledby="edit-example-modal-md" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="myModalLabel">تعديل المنتج</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('updating', $product->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-row">
                            <div class="form-group mb-3">
                                <label class="form-label">الشركة الموردة</label>
                                <select name="company_id" class="form-select">
                                    @foreach ($Allcompany as $company)
                                        <option value="{{ $company->id }}"
                                            {{ $company->id == $product->company_id ? 'selected' : '' }}>
                                            {{ $company->name_ar }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label">الماركة</label>
                                <select name="mark_id" class="form-select">
                                    @foreach ($marks as $mark)
                                        <option value="{{ $mark->id }}"
                                            {{ $mark->id == $product->mark_id ? 'selected' : '' }}>
                                            {{ $mark->name_ar }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label">الصنف</label>
                                <select name="class_id" class="form-select">
                                    @foreach ($classes as $class)
                                        <option value="{{ $class->id }}"
                                            {{ $class->id == $product->class_id ? 'selected' : '' }}>
                                            {{ $class->name_ar }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="input1"> الموديل
                                </label>
                                <input type="text" class="form-control mb-2" id="input1" name="model"
                                    value="{{ $product->model }}">
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="input2"> السعر
                                </label>
                                <input type="text" class="form-control mb-2" id="input2" name="price"
                                    value="{{ $product->price }}">
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="input2"> صافي
                                    التكلفة </label>
                                <input type="text" class="form-control mb-2" id="input2" name="net_price"
                                    value="{{ $product->net_price }}">
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label"> صورة المنتج </label>
                                <input type="file" name="img" class="form-control mb-2">
                                @if ($product->img)
                                    <img src="{{ asset('storage/' . $product->img) }}" alt="Current Image"
                                        style="width:70px;height:70px;">
                                @endif
                            </div>
                        </div>
                        <div class="mb-3 text-center">
                            <button type="button" class="btn bg-danger-subtle text-danger"
                                data-bs-dismiss="modal">اغلاق</button>
                            <button class="btn bg-info-subtle text-info" type="submit">تعديل</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
