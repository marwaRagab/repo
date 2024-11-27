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

<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0"> المستخدمين</h4>
        <div class="d-flex">
            <button class="btn me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4" data-bs-toggle="modal"
                data-bs-target="#add-user-modal">
                أضف جديد
            </button>
            <!-- Add User Modal -->
            <div id="add-user-modal" class="modal fade" tabindex="-1" aria-labelledby="add-user-modal"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-lg">
                    <div class="modal-content">
                        <div class="modal-header d-flex align-items-center">
                            <h4 class="modal-title" id="myModalLabel">اضف جديد</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row pt-3">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">الإسم المستخدم <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="username" class="form-control" required />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">العضو <span class="text-danger">*</span></label>
                                            <select name="name" class="form-select" required>
                                                <option selected disabled>اختر العضو</option>
                                                @php
                                                    $roleUsers = 0; // Counter for users with role_id
                                                @endphp
                                                @foreach ($users as $user)
                                                    @if (is_null($user->role_id))
                                                        <option value="{{ $user->name_ar }}">{{ $user->name_ar }}
                                                        </option>
                                                    @else
                                                        @php
                                                            $roleUsers++;
                                                        @endphp
                                                    @endif
                                                @endforeach
                                                @if ($roleUsers > 0)
                                                    <option disabled>لا يوجد اعضاء غير مسجلين</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">الفرع <span class="text-danger">*</span></label>
                                            <select name="branch_id" class="form-select" required>
                                                <option selected disabled>اختر الفرع</option>
                                                @foreach ($branches as $branch)
                                                    <option value="{{ $branch->id }}">{{ $branch->name_ar }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">الوظيفة <span class="text-danger">*</span></label>
                                            <select name="role_id" class="form-select" required>
                                                <option selected disabled>اختر الوظيفة</option>
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->id }}">{{ $role->name_ar }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">كلمة السر <span
                                                    class="text-danger">*</span></label>
                                            <input type="password" name="password" class="form-control" required />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">تأكيد كلمة السر <span
                                                    class="text-danger">*</span></label>
                                            <input type="password" name="password_confirmation" class="form-control"
                                                required />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">مستخدم شئون<span
                                                    class="text-danger">*</span></label>
                                            <div>
                                                <label><input type="radio" name="type" value="emp" required>
                                                    مسئول</label>
                                                <label><input type="radio" name="type" value="user"> غير
                                                    مسئول</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">حالة المستخدم <span
                                                    class="text-danger">*</span></label>
                                            <div>
                                                <label><input type="radio" name="active" value="1" required>
                                                    مفعل</label>
                                                <label><input type="radio" name="active" value="0"> غير
                                                    مفعل</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label"> صورة الملف الشخصي</label>
                                            <div>
                                                <input type="file" id="image" name="image" class="form-control"
                                                    accept="image/*"><br><br>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                        </div>
                        <div class="modal-footer d-flex ">
                            <button type="submit" class="btn btn-primary">حفظ</button>
                            <button type="button" class="btn bg-danger-subtle text-danger waves-effect"
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
    </div>

    <div class="card-body">
        <div class="table-responsive pb-4">
            <table id="file_export" class="table table-bordered border text-nowrap align-middle">
                <thead>
                    <tr>
                        <th>الاسم</th>
                        <th>الوظيفة</th>
                        <th>الفرع</th>
                        <th>الاجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $noRoleUsers = 0; // Counter for users without role_id
                    @endphp
                    @forelse ($users as $user)
                        @if ($user->role_id)
                            <tr>
                                <td>{{ $user->name_ar }}</td>
                                <td>{{ $user->roles ? $user->roles->name_ar : 'غير محدد' }}</td>
                                <td>{{ $user->branches ? $user->branches->name_ar : 'غير محدد' }}</td>
                                <td>
                                    <div class="d-block">
                                        <button class="btn me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4"
                                            data-bs-toggle="modal"
                                            data-bs-target="#edit-example-modal-md-{{ $user->id }}">
                                            تعديل
                                        </button>
                                        <!-- Edit User Modal -->
                                        <div id="edit-example-modal-md-{{ $user->id }}" class="modal fade"
                                            tabindex="-1" aria-labelledby="edit-example-modal-md"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header d-flex align-items-center">
                                                        <h4 class="modal-title" id="myModalLabel">تعديل</h4>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="POST" enctype="multipart/form-data"
                                                            action="{{ route('users.update', $user->id) }}">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="row pt-3">
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">الإسم المستخدم <span
                                                                                class="text-danger">*</span></label>
                                                                        <input type="text" name="username"
                                                                            class="form-control"
                                                                            value="{{ $user->username }}" required />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">الفرع</label>
                                                                        <select class="form-select" name="branch_id"
                                                                            required>
                                                                            <option disabled>اختر الفرع</option>
                                                                            @foreach ($branches as $branch)
                                                                                <option value="{{ $branch->id }}"
                                                                                    {{ $user->branch_id == $branch->id ? 'selected' : '' }}>
                                                                                    {{ $branch->name_ar }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">الوظيفة</label>
                                                                        <select class="form-select" name="role_id"
                                                                            required>
                                                                            <option disabled>اختر الوظيفة</option>
                                                                            @foreach ($roles as $role)
                                                                                <option value="{{ $role->id }}"
                                                                                    {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                                                                    {{ $role->name_ar }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">كلمة السر</label>
                                                                        <input type="password" name="password"
                                                                            class="form-control" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">تأكيد كلمة
                                                                            السر</label>
                                                                        <input type="password"
                                                                            name="password_confirmation"
                                                                            class="form-control" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">نوع المستخدم</label>
                                                                        <div>
                                                                            <label><input type="radio"
                                                                                    name="type" value="emp"
                                                                                    required
                                                                                    {{ $user->type == 'emp' ? 'checked' : '' }}>
                                                                                مسئول</label>
                                                                            <label><input type="radio"
                                                                                    name="type" value="user"
                                                                                    {{ $user->type == 'user' ? 'checked' : '' }}>
                                                                                غير مسئول</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">حالة المستخدم</label>
                                                                        <div>
                                                                            <label><input type="radio"
                                                                                    name="active" value="1"
                                                                                    required
                                                                                    {{ $user->active ? 'checked' : '' }}>
                                                                                مفعل</label>
                                                                            <label><input type="radio"
                                                                                    name="active" value="0"
                                                                                    {{ !$user->active ? 'checked' : '' }}>
                                                                                غير مفعل</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label"> صورة الملف
                                                                            الشخصي</label>
                                                                        <div>
                                                                            <input type="file" id="image"
                                                                                name="image" class="form-control"
                                                                                accept="image/*"><br><br>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer d-flex">
                                                                <button type="submit"
                                                                    class="btn btn-primary">حفظ</button>
                                                                <button type="button"
                                                                    class="btn bg-danger-subtle text-danger"
                                                                    data-bs-dismiss="modal">الغاء</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @else
                            @php
                                $noRoleUsers++;
                            @endphp
                        @endif
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">لا يوجد مستخدمين</td>
                        </tr>
                    @endforelse

                    @if ($noRoleUsers > 0)
                        <tr>
                            <td colspan="4" class="text-center">يوجد {{ $noRoleUsers }} أعضاء غير مسجلين</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
