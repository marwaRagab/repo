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
    <div class="d-flex flex-wrap mb-3">
        <a href="{{ route('supportRequest.index', ['status' => 'all']) }}"
            class="btn btn-secondary {{ $status === 'all' ? 'active' : '' }} px-4 fs-4 mx-1 mb-2">الكل</a>
        @php
            $btnColors = [
                1 => 'info',
                2 => 'warning',
                3 => 'success',
                4 => 'danger',
                5 => 'info',
                6 => 'warning',
                7 => 'success',
                8 => 'dark',
            ];
        @endphp
        @foreach ($statusMapping as $key => $label)
            <a href="{{ route('supportRequest.index', ['status' => $key]) }}"
                class="btn btn-{{ $btnColors[$key] ?? 'primary' }} {{ $status == $key ? 'active' : '' }} {{ $status == $key ? 'active' : '' }} px-4 fs-4 mx-1 mb-2">
                {{ $label }} ({{ $statusCounts[$key] ?? 0 }})
            </a>
        @endforeach
    </div>
</div>
<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0">الطلبات
        </h4>
        <div class="button-group">
            <button class="btn me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4 " data-bs-toggle="modal"
                data-bs-target="#add">
                أضف طلب جديد </button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive pb-4">
            <table id ="all-student" class="table table-bordered border text-nowrap align-middle">
                <thead>
                    <tr>
                        <th>م</th>
                        <th>رقم المعاملة</th>
                        <th>العنوان</th>
                        <th>التاريخ</th>
                        <th>الحالة</th>
                        <th>اسم المستخدم</th>
                        <th>الرابط</th>
                        <th>الإعدادات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $request)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ $request->installement_id }}</td>
                            <td>{{ $request->title }}</td>
                            <td>
                                <p class="m-0">{{ \Carbon\Carbon::parse($request->created_at)->format('Y/m/d') }}
                                </p>
                                <p class="m-0">{{ \Carbon\Carbon::parse($request->created_at)->format('h:i:s A') }}
                                </p>
                                <span class="badge bg-success">
                                    {{ \Carbon\Carbon::parse($request->created_at)->diffForHumans(null, true, true, 2) }}
                                </span>
                            </td>
                            <td> <span class="badge bg-primary">{{ $statusMapping[$request->status] }}</span>
                            </td>
                            <td>{{ $request->user->name_ar }}</td>
                            <td> <a href="{{ $request->link }}" class="btn btn-link" target="_blank">الرابط</a></td>
                            <td>
                                <div class="btn-group dropup mb-6 me-6 d-block">
                                    @if (auth()->user()->support == 1)
                                        <form
                                            action="{{ route('supportRequest.updateStatus', ['id' => $request->id]) }}"
                                            method="POST">
                                            @csrf
                                            @method('POST')
                                            <button class="btn btn-secondary dropdown-toggle btn-sm rounded"
                                                type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                تحديث الحالة
                                            </button>
                                            <ul class="dropdown-menu rounded-0" aria-labelledby="dropdownMenuButton">
                                                <li>
                                                    <button type="submit"
                                                        class="btn btn-info rounded-0 btn-sm w-100 mt-2" name="status"
                                                        value="1">جديد</button>
                                                </li>
                                                <li>
                                                    <button type="submit"
                                                        class="btn btn-warning rounded-0 btn-sm w-100 mt-2"
                                                        name="status" value="2">قيد التدقيق</button>
                                                </li>
                                                <li>
                                                    <button type="submit"
                                                        class="btn btn-success rounded-0 btn-sm w-100 mt-2"
                                                        name="status" value="3">موافق عليها</button>
                                                </li>
                                                <li>
                                                    <button type="submit"
                                                        class="btn btn-danger rounded-0 btn-sm w-100 mt-2"
                                                        name="status" value="4">مرفوضة</button>
                                                </li>
                                                <li>
                                                    <button type="submit"
                                                        class="btn btn-warning rounded-0 btn-sm w-100 mt-2"
                                                        name="status" value="5">قيد العمل</button>
                                                </li>
                                                <li>
                                                    <button type="submit"
                                                        class="btn btn-warning rounded-0 btn-sm w-100 mt-2"
                                                        name="status" value="6">قيد المراجعة</button>
                                                </li>
                                                <li>
                                                    <button type="submit"
                                                        class="btn btn-success rounded-0 btn-sm w-100 mt-2"
                                                        name="status" value="7">تم الانتهاء منها</button>
                                                </li>
                                                <li>
                                                    <button type="submit"
                                                        class="btn btn-dark rounded-0 btn-sm w-100 mt-2"
                                                        name="status" value="8">مغلقة</button>
                                                </li>
                                            </ul>
                                        </form>
                                    @endif
                                </div>
                                <a class="btn btn-success btn-sm rounded me-6"
                                    href="{{ route('supportRequest.show', $request->id) }}">مشاهدة
                                    التفاصيل</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">لا يوجد طلبات</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
</div>


</div>

</div>


<!-- modals -->
<div id="add" class="modal fade" tabindex="-1" aria-labelledby="add" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myModalLabel">
                    إضافة طلب جديد
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('supportRequest.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="input1 "> رقم المعاملة </label>
                            <input type="text" class="form-control mb-2" id="input1" name="installement_id">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="input2 "> العنوان</label>
                            <input type="text" class="form-control mb-2" id="input2" name="title">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="input3"> الرابط</label>
                            <input type="text" class="form-control mb-2" id="input3" name="link">
                        </div>
                        <div class="form-group">
                            <label class="form-label"> الوصف</label>
                            <textarea class="form-control" rows="5" name="descr"></textarea>
                        </div>
                        <div class="form-group my-3">
                            <label for="formFile" class="form-label">ارفاق صورة أو فيديو</label>
                            <input class="form-control" type="file" id="formFile" name="file">
                        </div>

                        <div class="modal-footer d-flex ">
                            <button type="submit" class="btn btn-primary">حفظ</button>
                            <button type="button" class="btn bg-danger-subtle text-danger  waves-effect"
                                data-bs-dismiss="modal">
                                الغاء
                            </button>
                        </div>
                    </div>

                </form>
            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
