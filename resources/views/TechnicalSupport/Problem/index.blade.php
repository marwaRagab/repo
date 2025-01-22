<style>
    small {
    color: gray;
    font-size: 85%;
}
</style>
<div class="card mt-4 py-3">
    <div class="d-flex flex-wrap mb-3">
        <a href="{{ route('supportProblem.index', ['status' => 'all' ,'department_id'=> $request->department_id ,'sub_department_id'=> $request->sub_department_id]) }}"
            class="btn btn-secondary {{ $status === 'all' ? 'active' : '' }} px-4 fs-4 mx-1 mb-2"
            style="display:none;">الكل</a>
        @php
            $btnColors = [
                1 => 'info',
                2 => 'warning',
                3 => 'danger',
                4 => 'primary',
                5 => 'secondary',
                6 => 'success',
                7 => 'primary',
               //  8 => 'primary',
            ];
        @endphp
    @foreach ($statusMapping as $key => $label)
        <a href="{{ route('supportProblem.index', ['status' => $key, 'department_id' => $request->department_id, 'sub_department_id' => $request->sub_department_id]) }}"
        class="btn-filter bg-{{ $btnColors[$key] ?? 'primary' }}-subtle text-{{ $btnColors[$key] ?? 'primary' }} {{ request('status') == $key ? 'active' : '' }} px-4 fs-4 mx-1 mb-2">
            {{ $label }} ({{ $statusCounts[$key] ?? 0 }})
        </a>
    @endforeach
    </div>
</div>
<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0">{{ $title }}
        </h4>
        <div class="button-group">
            {{-- @if (Auth::user()->support != 1) --}}
                <button class="btn me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4 " data-bs-toggle="modal"
                    data-bs-target="#add">
                    أضف مشكلة جديدة </button>
            {{-- @endif --}}
            <a class="btn me-1 mb-1 bg-success-subtle text-success px-4 fs-4 "
                href="{{ route('supportRequest.index') }}">
                التطوير</a>
        </div>
    </div>
    <div class="card-body">
    <div class="d-flex justify-content-end mb-3">
        <form action="{{ route('supportProblem.index') }}" method="GET" class="d-flex">
            <input type="hidden" name="status" value="{{ request('status') }}">
            <input type="hidden" name="department_id" value="{{ request('department_id') }}">
            <input type="hidden" name="sub_department_id" value="{{ request('sub_department_id') }}">
            <select id="priority" class="form-control me-2" name="priority" onchange="this.form.submit()">
            <option value="" disabled selected>اختر الأولوية</option>
            <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>مرتفعة</option>
            <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>متوسطة</option>
            <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>منخفضة</option>
            </select>
        </form>
    </div>

        <div class="table-responsive pb-4">
            <table id ="file_export" class="table table-bordered border text-nowrap align-middle">
                <thead>
                    <tr>
                        <th>م</th>
                        {{-- <th>رقم المعاملة</th> --}}
                        <th>رقم التذكرة</th>
                        <th>القسم</th>
                        <th>التاريخ</th>

                        <th>اسم المستخدم</th>
                        <!-- <th>الرابط</th> -->
                        @if (request('status') != "1" )
                        @if (Auth::user()->roles->name_ar == "superadmin")
                        <th>المبرمج</th>
                        @endif

                        <!-- <th>عدد الايام</th>   -->
                        <th>الاولوية</th>
                        @endif
                        @if (request('status') == "6" || request('status') == "7" || request('status') == "8")
                        <th>تاريخ الانتهاء</th>
                        @endif
                        <th>اجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $problem)

                        <tr>

                            <td>{{ $loop->index + 1 }}</td>
                            {{-- <td>{{ $problem->installement_id }}</td> --}}
                            <td><a href="{{ route('supportProblem.show', $problem->id) }}">{{ $problem->id }}</a>
                                @php
                                    $lastTransition = DB::table('issue_status_history')
                                        ->where('issue_id', $problem->id)
                                        ->where('to_status', $problem->status)
                                        ->orderBy('transition_time', 'desc')
                                        ->first();
                                    $duration = $lastTransition ? now()->diff($lastTransition->transition_time)->format('%d أيام, %h ساعات, %i دقائق') : 'N/A';
                                    $duration = preg_replace('/0 أيام,? ?/', '', $duration);
                                    $duration = preg_replace('/,? 0 ساعات,? ?/', '', $duration);
                                   // $duration = preg_replace('/,? 0 [^,]*/', '', $duration);
                                @endphp
                                </br>
                                @if ($duration !== 'N/A')
                                    <span class="badge bg-success">
                                        {{ $duration }}
                                    </span>
                                @endif
                            </td>

                            <td>
                                @if($problem->department != null)
                                {{ $problem->department->name_ar }}
                                 @endif
                                @if(!empty( $problem->subdepartment->name_ar))
                                    <br>
                                    <small>{{  $problem->subdepartment->name_ar }}</small>
                                @endif
                                @if($problem->department == null)
                                <small>---</small>
                                 @endif
                            </td>


                            <td>
                                <p class="m-0">{{ \Carbon\Carbon::parse($problem->created_at)->format('Y/m/d') }}
                                </p>
                                <p class="m-0">{{ \Carbon\Carbon::parse($problem->created_at)->translatedFormat('h:i:s A') }}
                                </p>
                                <span class="badge bg-success">
                                {{ \Carbon\Carbon::parse($problem->created_at)->diffForHumans(null, true, false, 2) }}
                                </span>
                            </td>

                            <td>{{ $problem->user->name_ar }}</td>
                            <!-- <td> <a href="{{ $problem->link }}" class="btn btn-link" target="_blank">الرابط</a></td> -->


                            @if (request('status') != "1")
                                @if (Auth::user()->roles->name_ar == "superadmin")
                                <td>
                                    <form action="{{ route('updatedeveloper', ['id' => $problem->id]) }}" method="POST" id="developerForm">
                                        @csrf
                                        <select name="dev" id="dev" class="form-control"   @if (Auth::user()->developer == "3") onchange="this.form.submit()" @else disabled @endif>
                                            @if ($problem->developer_id !== null)
                                                @foreach ($developer as $dev)
                                                    <option value="{{ $dev->id }}" {{ $dev->id == $problem->developer_id ? 'selected' : '' }}>
                                                        {{ $dev->name_ar }}
                                                    </option>
                                                @endforeach
                                            @else
                                                <option selected disabled>اختر</option>
                                                @foreach ($developer as $dev)
                                                    <option value="{{ $dev->id }}">{{ $dev->name_ar }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </form>
                                    @if ($problem->assign_date)
                                        <p class="m-0">{{ \Carbon\Carbon::parse($problem->assign_date)->format('Y/m/d') }}
                                        </p>
                                        <!-- <p class="m-0">{{ \Carbon\Carbon::parse($problem->assign_date)->format('h:i:s A') }}
                                        </p> -->
                                        <span class="badge bg-success">
                                            {{ \Carbon\Carbon::parse($problem->assign_date)->diffForHumans(null, true, true, 2) }}
                                        </span>
                                    @else
                                        لم يتم تحديد مبرمج
                                    @endif
                                </td>
                                @endif

                                <!-- <td>
                                    @if ($problem->assign_date)
                                        <p class="m-0">{{ \Carbon\Carbon::parse($problem->assign_date)->format('Y/m/d') }}
                                        </p>
                                        <p class="m-0">{{ \Carbon\Carbon::parse($problem->assign_date)->format('h:i:s A') }}
                                        </p>
                                        <span class="badge bg-success">
                                            {{ \Carbon\Carbon::parse($problem->assign_date)->diffForHumans(null, true, true, 2) }}
                                        </span>
                                    @else
                                        لم يتم تحديد مبرمج
                                    @endif
                                </td> -->
                                <td >

                                   <p class="btn btn-{{ $problem->priority == 'high' ? 'danger' : ($problem->priority == 'medium' ? 'primary' : 'success')  }}  btn-sm rounded">
                                        {{ $problem->priority == "high"
                                            ? "مرتفعة"
                                            : ($problem->priority == "medium"
                                                ? "متوسطة"
                                                : "منخفضة")
                                        }}
                                    </p>
                                </td>

                            @endif


                            @if (request('status') == "6" || request('status') == "7" || request('status') == "8")
                                 <td> {{ \Carbon\Carbon::parse($problem->end_task)->format('Y/m/d') ?? 'لا يوجد' }}</td>
                            @endif
                            <td>
                                <form action="{{ route('supportProblem.updateStatus', ['id' => $problem->id]) }}"
                                    method="POST">
                                    @csrf
                                    @method('POST')
                                    <button class="btn btn-secondary dropdown-toggle btn-sm rounded" type="button"
                                        id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        تحديث الحالة
                                    </button>
                                    <ul class="dropdown-menu rounded-0" aria-labelledby="dropdownMenuButton">
                                        <li>
                                            <button type="submit" class="btn btn-success rounded-0 btn-sm w-100 mt-2"
                                                name="status" value="1">جديد</button>
                                        </li>
                                        <li>
                                            <button type="submit" class="btn btn-warning rounded-0 btn-sm w-100 mt-2"
                                                name="status" value="2">قيد التدقيق</button>
                                        </li>
                                        <li>
                                            <button type="submit" class="btn btn-primary rounded-0 btn-sm w-100 mt-2"
                                                name="status" value="3">قيد العمل</button>
                                        </li>
                                        <li>
                                            <button type="submit" class="btn btn-info rounded-0 btn-sm w-100 mt-2"
                                                name="status" value="4">بانتظار الرد</button>
                                        </li>
                                        <li>
                                            <button type="submit" class="btn btn-warning rounded-0 btn-sm w-100 mt-2"
                                                name="status" value="5">قيد المراجعة</button>
                                        </li>
                                        <li>
                                            <button type="submit" class="btn btn-warning rounded-0 btn-sm w-100 mt-2"
                                                name="status" value="6"> تم الانتهاء منها</button>
                                        </li>
                                        <li>
                                            <button type="submit" class="btn btn-success rounded-0 btn-sm w-100 mt-2"
                                                name="status" value="7">منجزة</button>
                                        </li>
                                        {{-- <li>
                                            <button type="submit" class="btn btn-dark rounded-0 btn-sm w-100 mt-2"
                                                name="status" value="7">مغلقة</button>
                                        </li> --}}
                                    </ul>
                                </form>

                                <a class="btn btn-danger btn-sm rounded" style="display: none"
                                    href="{{ route('supportProblem.show', $problem->id) }}">مشاهدة
                                    التفاصيل</a>
                                    <br/>
                                    @if ( filter_var($problem->link, FILTER_VALIDATE_URL))
                                 <a href="{{ $problem->link }}" class="btn btn-success btn-sm rounded" target="_blank">الرابط</a>
                                    @endif

                            </td>
                        </tr>
                    {{-- @empty
                        <tr>
                            <td colspan="8" class="text-center">لا يوجد مشكلات</td>
                        </tr> --}}
                    @endforeach
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
                            <label class="form-label" for="input1 "> القسم </label>
                            <select id="department"  class="form-control mb-2" name="department">
                                <option selected disabled>اختر</option>
                                @foreach ($department as $dep)
                                <option value="{{ $dep->id }}">{{ $dep->name_ar }}</option>
                                @endforeach

                            </select>
                        </div>

                        <div class="form-group" style="display: none" id="sub-department-group">
                            <label class="form-label" for="sub_department">الأقسام الفرعية</label>
                            <select id="sub_department" name="sub_department" class="form-select mb-2">
                                <!-- Sub-departments will be populated here -->
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="input1 "> الاولوية </label>

                            <select id="priority"  class="form-control mb-2" name="priority">

                                <option selected disabled>اختر</option>
                                <option value="high">مرتفعة</option>
                                <option value="medium">متوسطة</option>
                                <option value="low">منخفضة</option>
                            </select>
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

<script>
    document.getElementById('department').addEventListener('change', function() {
    let departmentId = this.value;

    // If no department is selected, hide the sub-department select field
    if (!departmentId) {
        document.getElementById('sub-department-group').style.display = 'none';
        return;
    }

    // Show the sub-department select field
    document.getElementById('sub-department-group').style.display = 'block';

    // Make an AJAX request to fetch the sub-departments
    fetch(`/getSubDepartments_Json/${departmentId}`)
        .then(response => response.json())
        .then(data => {
            let subDepartmentSelect = document.getElementById('sub_department');
            subDepartmentSelect.innerHTML = ''; // Clear the previous options
            subDepartmentSelect.innerHTML = '<option selected disabled>اختر القسم الفرعي</option>';

            data.subDepartments.forEach(subDept => {
                let option = document.createElement('option');
                option.value = subDept.id;
                option.textContent = subDept.name_ar;
                subDepartmentSelect.appendChild(option);
            });
        })
        .catch(error => console.error('Error fetching sub-departments:', error));
});

</script>
