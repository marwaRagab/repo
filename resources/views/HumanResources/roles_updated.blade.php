<!-- Bootstrap CSS -->
<!-- Font Awesome for Icons -->
<!-- Custom CSS -->
<style>
    .avatar-sm {
        width: 25px;
        height: 25px;
    }

    .rounded-circle {
        border-radius: 50%;
    }

    .shadow-md {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .overflow-hidden {
        overflow: hidden;
    }

    .bg-blue-500 {
        background-color: #007bff;
    }

    .bg-purple-500 {
        background-color: #6f42c1;
    }

    .text-gray-500 {
        color: #6c757d;
    }

    .text-lg {
        font-size: 1.25rem;
    }

    .font-semibold {
        font-weight: 600;
    }

    .font-medium {
        font-weight: 500;
    }

    .tw-p-4 {
        padding: 1rem;
    }

    .tw-p-3 {
        padding: 0.75rem;
    }

    .tw-p-10 {
        padding: 2.5rem;
    }
</style>
<div class="row">

    @foreach ($roles as $role)
        <div class="col-sm-3">
            <div class="card shadow-md rounded-lg p-4 w-100 overflow-hidden">

                <p class="text-muted small">
                    العدد <span class="font-weight-medium">:{{ $role->users->count() }}</span>
                    <a href="{{ route('roles.edit', $role->id) }}"
                        class="btn btn-primary btn-sm rounded-circle shadow-lg mr-2"
                        style="float: left;width: 30px; height: 30px;">
                        <i class="fas fa-edit"></i>
                    </a>
                </p>

                <div class="d-flex align-items-center mt-2">
                    @foreach ($role->users->take(4) as $user)
                        <img class="rounded-circle border border-white mr-2"
                            src="{{ isset($user->img) ? asset('user_profile/' . $user->img) : asset('user_profile/Screenshot 2024-12-03 112316.png') }}"
                            alt="{{ $user->name_ar }}" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="{{ $user->name_ar }}" style="width: 32px; height: 32px; cursor: pointer;">
                    @endforeach

                    @if ($role->users->count() > 4)
                        <div class="rounded-circle border border-white d-flex align-items-center justify-content-center bg-light text-dark"
                            style="width: 32px; height: 32px; font-size: 12px; font-weight: bold;">
                            +{{ $role->users->count() - 4 }}
                        </div>
                    @endif
                </div>

                <h2 class="h5 font-weight-semibold mt-3">{{ $role->name_ar ?? $role->name }}</h2>

            </div>
        </div>
    @endforeach
    <div class="col-sm-3">
        <div class="card shadow-md rounded-lg p-4 w-100 overflow-hidden">

            <div class="d-flex justify-content-between mt-auto">

                <img src="https://demos.themeselection.com/sneat-bootstrap-html-admin-template/assets/img/illustrations/lady-with-laptop-light.png"
                    alt="User Illustration" style="width: 100px; height: 100px;">

                <a href="{{ route('role.create') }}" class="btn btn-danger btn-sm rounded-circle shadow-lg mt-2"
                    style="width: 30px; height: 30px;">
                    <i class="fas fa-plus"></i>
                </a>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0"> الكل </h4>
        <a href="{{ route('permissions.index') }}" class="btn btn-info btn-sm">إدارة الصلاحيات</a>
    </div>
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">

        <!-- Search and Filter Form -->
        <form method="GET" action="{{ route('roles.index') }}" id="filterForm">
            <div class="row">
                <!-- Search by Name or Civil Number -->
                <div class="col-md-4">
                    <input type="text" name="search" id="searchInput" class="form-control text-muted"
                        placeholder="بحث عن المستخدم..." value="{{ request('search') }}">
                </div> <!-- Filter by Role -->
                <div class="col-md-4">
                    <select name="role" id="roleFilter" class="form-control">
                        <option value="">اختر مجموعة العمل</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}"
                                {{ request('role') == $role->name ? 'selected' : '' }}>
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
            <table class="table table-bordered" id="all-student">
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
                                            <img src="{{ isset($user->img) ? asset('user_profile/' . $user->img) : asset('user_profile/Screenshot 2024-12-03 112316.png') }}"
                                                alt="" style="    width: 25px;" class="rounded-circle">
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <a href="#" class="text-heading text-truncate"><span
                                                class="fw-medium">{{ $user->name_ar }}</span></a>
                                        <small>{{ $user->phone }}</small>
                                    </div>
                                </div>




                            </td>

                            <td>
                                @foreach ($user->roles as $role)
                                    <span class="badge bg-success">
                                        <i class="{{ getRoleIcon($role->name) }}"></i>
                                        {{ $role->name }}
                                    </span>
                                @endforeach
                            </td>
                            <td>{{ $user->created_by }}</td>
                            <td>
                                @if ($user->active)
                                    <span class="badge bg-success">نشط</span>
                                @else
                                    <span class="badge bg-danger">غير نشط</span>
                                @endif
                            </td>
                            <td>
                                <a href="#" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="#" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="#" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('هل أنت متأكد من الحذف؟')">
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
<!-- Enable Bootstrap Tooltip -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
