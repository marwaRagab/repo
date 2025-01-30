<script src="https://cdn.tailwindcss.com"></script>

<div class="row">

    @foreach($roles as $role)
    <div class="col-sm-3">
        <div class="shadow-md rounded-lg p-4 w-100 card overflow-hidden">
            <p class="text-gray-500 text-sm">
                العدد <span class="font-medium">:{{ $role->users->count() }}</span>
            </p>

            <div class="flex items-center mt-2">
                <div class="flex -space-x-2">
                    @foreach($role->users->take(4) as $user)
                        <img class="w-8 h-8 rounded-full border-2 border-white"
                            src="{{ isset($user->img) ? asset('user_profile/' . $user->img) : asset('user_profile/Screenshot 2024-12-03 112316.png')  }}"
                            alt="{{ $user->name }}">
                    @endforeach
                </div>
            </div>

            <h2 class="text-lg font-semibold mt-3">{{ $role->name_ar }}</h2>

            <a href="{{ route('roles.edit', $role->id) }}"
               class="flex items-center justify-center bg-blue-500 text-white p-3 rounded-full shadow-lg transition-transform transform hover:scale-110 w-12 h-12">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 2.487a2.073 2.073 0 0 1 2.932 0l1.719 1.718a2.073 2.073 0 0 1 0 2.932L8.75 19.9a4.15 4.15 0 0 1-1.848 1.086l-4.202 1.05a.9.9 0 0 1-1.092-1.092l1.05-4.202a4.15 4.15 0 0 1 1.086-1.848L16.862 2.487zM15 5l4 4"/>
                </svg>
            </a>
        </div>
    </div>
    @endforeach

    <div class="col-sm-3">
        <div class="flex items-center space-x-6 bg-white shadow-md rounded-lg p-10 w-100  overflow-hidden">
            <!-- Illustration -->
            <div>
                <img src="https://demos.themeselection.com/sneat-bootstrap-html-admin-template/assets/img/illustrations/lady-with-laptop-light.png"
                    alt="User Illustration" class="w-32 h-32">
            </div>

            <!-- Text & Button -->
            <a href="{{ route('role.create') }}" class="flex items-center justify-center bg-purple-500 text-white p-3 rounded-full shadow-lg transition-transform transform hover:scale-110 w-12 h-12">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                </svg>
            </a>

        </div>

    </div>


</div>

<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0">  الكل </h4>

    </div>
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">

 <!-- Search and Filter Form -->
 <form method="GET" action="{{ route('roles.index') }}" id="filterForm">
    <div class="row">
        <!-- Search by Name or Civil Number -->
        <div class="col-md-4">
            <input type="text" name="search" id="searchInput" class="form-control" placeholder="بحث عن المستخدم..." value="{{ request('search') }}">
        </div>

        <!-- Filter by Role -->
        <div class="col-md-4">
            <select name="role" id="roleFilter" class="form-control">
                <option value="">اختر مجموعة العمل</option>
                @foreach($roles as $role)
                    <option value="{{ $role->name }}" {{ request('role') == $role->name ? 'selected' : '' }}>
                        {{ $role->name_ar }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</form>
</div>



    <div class="card-body">
        <div class="table-responsive pb-4">
            <table class="table table-bordered">
                <thead>
                    <!-- start row -->
                    <tr>
                        <th> المستخدم </th>
                        {{-- <th>رقم حساب البنك</th> --}}
                        <th>مجموعة العمل</th>
                        <th> انشأ بواسطة</th>
                        <th>الحالة</th>
                        <th>الإجراءات</th>
                    </tr>
                    <!-- end row -->
                </thead>
                <tbody>
                    <!-- start row -->

                    @forelse($users as $user)
                    <tr>
                        <td>

                            <div class="d-flex justify-content-left align-items-center">
                                <div class="avatar-wrapper">
                                  <div class="avatar avatar-sm me-4">
                                    <img src="{{ isset($user->img) ? asset('user_profile/' . $user->img) : asset('user_profile/Screenshot 2024-12-03 112316.png') }}" alt="" style="    width: 25px;" class="rounded-circle">
                                  </div>
                                </div>
                                <div class="d-flex flex-column">
                                  <a href="app-user-view-account.html" class="text-heading text-truncate"><span class="fw-medium">{{$user->name_ar}}</span></a>
                                  <small>{{$user->phone}}</small>
                                </div>
                              </div>




                    </td>

                        <td>
                            @foreach($user->roles as $role)
                                <span class="badge bg-success">
                                    <i class="{{ getRoleIcon($role->name) }}"></i>
                                    {{ $role->name }}
                                </span>
                            @endforeach
                        </td>
                        <td>{{$user->created_by}}</td>
                        <td>
                            @if($user->active)
                                <span class="badge bg-success">نشط</span>
                            @else
                                <span class="badge bg-danger">غير نشط</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('users.user-profile', $user->id) }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد من الحذف؟')">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">لم يتم العثور على مستخدمين</td>
                    </tr>
                    @endforelse


                </tbody>
            </table>
            <!-- Pagination -->
            <div class="pagination-container">
                {{ $users->links() }}
            </div>

            <style>
                .pagination-container p.text-sm.text-gray-700.leading-5 {
                    display: none !important;
                }
            </style>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- JavaScript for Auto Filter -->
<script>
    document.getElementById('searchInput').addEventListener('input', function() {
        document.getElementById('filterForm').submit();
    });

    document.getElementById('roleFilter').addEventListener('change', function() {
        document.getElementById('filterForm').submit();
    });
</script>
