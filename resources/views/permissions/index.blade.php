<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
<div class="card">
    <h4 class="card-title mb-3">إدارة الصلاحيات</h4>
    <div class="card-body">
        <a href="{{ route('permissions.create') }}" class="btn btn-primary mb-3">إضافة صلاحية جديدة</a>
        <div class="card-body">
            <div class="table-responsive pb-4">
        <table id="file_export" class="table table-bordered border text-nowrap align-middle">
            <thead>
                <tr>
                    <th>م</th>
                    <th>الاسم</th>
                    <th>الصلاحية الرئيسية</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($permissions as $index => $permission)
    <tr>
        <td>{{ $index + 1 }}</td>
        <td>{{ $permission->name }}</td>
        <td>{{ $permission->parent ? $permission->parent->name : '-----' }}</td>
        <td>
            <a href="{{ route('permissions.edit', $permission->id) }}" class="btn btn-warning btn-sm">تعديل</a>
            <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد من الحذف؟')">حذف</button>
            </form>
        </td>
    </tr>
    @endforeach
            </tbody>
        </table>

    </div>    </div>
    </div>
</div>

