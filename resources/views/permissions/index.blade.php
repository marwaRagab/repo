<div class="card">
    <h4 class="card-title mb-3">إدارة الصلاحيات</h4>
    <div class="card-body">
        <a href="{{ route('permissions.create') }}" class="btn btn-primary mb-3">إضافة صلاحية جديدة</a>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>الاسم</th>
                    <th>الأب</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($permissions as $permission)
                <tr>
                    <td>{{ $permission->name }}</td>
                    <td>{{ $permission->parent ? $permission->parent->name : '—' }}</td>
                    <td>
                        <a href="{{ route('permissions.edit', $permission->id) }}" class="btn btn-warning btn-sm">تعديل</a>
                        <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد؟')">حذف</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
