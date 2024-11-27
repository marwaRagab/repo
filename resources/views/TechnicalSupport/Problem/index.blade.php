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
        <a href="{{ route('supportProblem.index', ['status' => 'all']) }}"
            class="btn btn-secondary {{ $status === 'all' ? 'active' : '' }} px-4 fs-4 mx-1 mb-2" style="display:none;">الكل</a>
        @php
            $btnColors = [
                1 => 'info',
                2 => 'warning',
                3 => 'danger',
                4 => 'primary',
                5 => 'secondary',
                6 => 'success',
                7 => 'dark',
            ];
        @endphp
        @foreach ($statusMapping as $key => $label)
            <a href="{{ route('supportProblem.index', ['status' => $key]) }}"
             class="btn-filter bg-{{ $btnColors[$key] ?? 'primary' }}-subtle text-{{ $btnColors[$key] ?? 'primary' }} {{ $status == $key ? 'active' : '' }} {{ $status == $key ? 'active' : '' }} px-4 fs-4 mx-1 mb-2"
                >
                {{ $label }} ({{ $statusCounts[$key] ?? 0 }})
            </a>
        @endforeach
    </div>
</div>
<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0">الدعم الفني
        </h4>
        <div class="button-group">
            <button class="btn me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4 " data-bs-toggle="modal"
                data-bs-target="#add">
                أضف مشكلة جديدة </button>
            <a class="btn me-1 mb-1 bg-success-subtle text-success px-4 fs-4 "
                href="{{ route('supportRequest.index') }}">
                التطوير</a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive pb-4">
            <table id ="file-export" class="table table-bordered border text-nowrap align-middle">
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
                    @forelse ($data as $problem)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ $problem->installement_id }}</td>
                            <td>{{ $problem->title }}</td>
                            <td>
                                <p class="m-0">{{ \Carbon\Carbon::parse($problem->created_at)->format('Y/m/d') }}
                                </p>
                                <p class="m-0">{{ \Carbon\Carbon::parse($problem->created_at)->format('h:i:s A') }}
                                </p>
                                <span class="badge bg-success">
                                    {{ \Carbon\Carbon::parse($problem->created_at)->diffForHumans(null, true, true, 2) }}
                                </span>
                            </td>
                            <td> <span class="badge bg-primary">{{ $statusMapping[$problem->status] }}</span>
                            </td>
                            <td>{{ $problem->user->name_ar }}</td>
                            <td> <a href="{{ $problem->link }}" class="btn btn-link" target="_blank">الرابط</a></td>
                            <td>
                                <a class="btn btn-success btn-sm rounded me-6"
                                    href="{{ route('supportProblem.show', $problem->id) }}">مشاهدة
                                    التفاصيل</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">لا يوجد مشكلات</td>
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
                    إضافة مشكلة جديدة
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('supportProblem.store') }}" enctype="multipart/form-data">
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
