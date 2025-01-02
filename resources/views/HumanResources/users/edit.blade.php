
<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0"> الملف الشخصي</h4>
        <div class="d-flex">


        </div>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">الاسم بالعربية</label>
                <input type="text" name="name_ar" class="form-control" value="{{ $user->name_ar }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">الاسم بالإنجليزية</label>
                <input type="text" name="name_en" class="form-control" value="{{ $user->name_en }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">اسم المستخدم</label>
                <input type="text" name="username" class="form-control" value="{{ $user->username }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">البريد الإلكتروني</label>
                <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">كلمة المرور</label>
                <input type="password" name="password" class="form-control">
                <small class="text-muted">اترك الحقل فارغًا إذا لم تكن تريد تغيير كلمة المرور</small>
            </div>

            <div class="mb-3">
                <label class="form-label">رقم الهاتف</label>
                <input type="text" name="phone" class="form-control" value="{{ $user->phone }}" required>
            </div>


            <div class="mb-3">
                <label class="form-label">الفرع</label>
                <select name="branch_id" class="form-select">
                    <option selected disabled>اختر الفرع</option>
                    @foreach ($branches as $branch)
                        <option value="{{ $branch->id }}" {{ $user->branch_id == $branch->id ? 'selected' : '' }}>
                            {{ $branch->name_ar }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">الوظيفة</label>
                <select name="role_id" class="form-select">
                    <option selected disabled>اختر الوظيفة</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                            {{ $role->name_ar }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">حالة المستخدم</label>
                <div>
                    <label><input type="radio" name="active" value="1" {{ $user->active ? 'checked' : '' }}> مفعل</label>
                    <label><input type="radio" name="active" value="0" {{ !$user->active ? 'checked' : '' }}> غير مفعل</label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">حفظ</button>
        </form>
</div>
</div>
