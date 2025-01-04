<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0">الوسطاء</h4>
        <button class="btn me-1 mb-1 bg-primary-subtle text-primary px-4  " data-bs-toggle="modal"
            data-bs-target="#bs-example-modal-md">
            أضف وسيط جديد </button>
        <!-- sample modal content -->
        <div id="bs-example-modal-md" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header d-flex align-items-center">
                        <h4 class="modal-title" id="myModalLabel">
                            أضف وسيط جديد</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('broker.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label" for="input1 "> الاسم بالعربى </label>
                                    <input type="text" name="name_ar" class="form-control mb-2">
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="input1 "> الاسم بالانجليزى </label>
                                    <input type="text" name="name_en" class="form-control mb-2">
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="input2 "> الهاتف </label>
                                    <input type="text" name="phone" class="form-control mb-2">
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="input2 "> النسبة </label>
                                    <input type="text" name="percentage" class="form-control mb-2">
                                </div>
                                <div class="form-group">
                                    <select name="percentage_amount"
                                        class="form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        id="percentage_amount">
                                        <option value="percentage">النسبة</option>
                                        <option value="amount">كمية</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer d-flex ">
                            <button type="submit" class="btn btn-primary">حفظ</button>
                            <button type="button" class="btn bg-danger-subtle text-danger  waves-effect"
                                data-bs-dismiss="modal">
                                الغاء
                            </button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive pb-4">
            <table id="all-student" class="table table-bordered border text-nowrap align-middle">
                <thead>
                    <!-- start row -->
                    <tr>
                        <th>اسم الوسيط</th>
                        <th> الهاتف </th>
                        <th> النسبة</th>
                        <th>عدد المعاملات</th>
                        <th> عدد الزيارات </th>
                        <th>تعديل</th>
                        <th>ارسال الرابط</th>
                    </tr>
                    <!-- end row -->
                </thead>
                <tbody>
                    <!-- start row -->
                    @foreach ($Boker as $item)
                        <tr>

                            <td>
                                {{ $item->name_ar }}
                            </td>
                            <td>{{ $item->phone }}</td>
                            <td>{{ $item->percentage }}</td>
                            <td>
                                {{ App\Models\Installment_Client::where('boker_id', $item->id)->count() }}
                            </td>
                            <td>
                                0
                            </td>
                            <td>
                                <div class="action-btn">
                                    <a href="javascript:void(0)" class="text-primary edit" data-bs-toggle="modal"
                                        data-bs-target="#edit-example-modal-md-{{ $item->id }}">
                                        <i class="ti ti-pencil fs-5"></i>
                                    </a>
                                    <div id="edit-example-modal-md-{{ $item->id }}" class="modal fade"
                                        tabindex="-1" aria-labelledby="edit-example-modal-md" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header d-flex align-items-center">
                                                    <h4 class="modal-title" id="myModalLabel">
                                                        تعديل بيانات الوسيط</h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('broker.update', $item->id) }}"
                                                        method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT') <!-- Use PUT for update -->
                                                        <div class="form-row">
                                                            <div class="form-group">
                                                                <label class="form-label" for="input1">الإسم
                                                                    بالعربى</label>
                                                                <input type="text" name="name_ar"
                                                                    class="form-control mb-2"
                                                                    value="{{ $item->name_ar }}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label" for="input1">الإسم
                                                                    بالانجليزى</label>
                                                                <input type="text" name="name_en"
                                                                    class="form-control mb-2"
                                                                    value="{{ $item->name_en }}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label"
                                                                    for="input2">الهاتف</label>
                                                                <input type="text" name="phone"
                                                                    class="form-control mb-2"
                                                                    value="{{ $item->phone }}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label"
                                                                    for="input2">النسبة</label>
                                                                <input type="text" name="percentage"
                                                                    class="form-control mb-2"
                                                                    value="{{ $item->percentage }}">
                                                            </div>
                                                            <div class="form-group">
                                                                <select name="percentage_amount" class="form-select">
                                                                    <option value="percentage"
                                                                        {{ $item->percentage_amount === 'percentage' ? 'selected' : '' }}>
                                                                        النسبة</option>
                                                                    <option value="amount"
                                                                        {{ $item->percentage_amount === 'amount' ? 'selected' : '' }}>
                                                                        كمية</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                </div>
                                                <div class="modal-footer d-flex ">
                                                    <button type="submit" class="btn btn-primary">حفظ</button>
                                                    <button type="button"
                                                        class="btn bg-danger-subtle text-danger waves-effect"
                                                        data-bs-dismiss="modal">الغاء</button>
                                                </div>
                                                </form>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                </div>
                            </td>

                            <td>
                                <a class="text-info text-underline" href="{{ route('myinstall.install',$item->id) }}"> ارسال الرابط</a>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>

{{--  --}}
