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
                7 => 'dark',
                8 => 'primary',
            ];
        @endphp
       @foreach ($statusMapping as $key => $label)
    <a href="{{ route('supportProblem.index', ['status' => $key, 'department_id' => $request->department_id, 'sub_department_id' => $request->sub_department_id]) }}"
    class="btn-filter bg-{{ $btnColors[$key] ?? 'primary' }}-subtle text-{{ $btnColors[$key] ?? 'primary' }} {{ $status == $key ? 'active' : '' }} px-4 fs-4 mx-1 mb-2">
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
        <div class="table-responsive pb-4">
            <table id ="file_export" class="table table-bordered border text-nowrap align-middle">
                <thead>
                    <tr>
                        <th>م</th>
                        {{-- <th>رقم المعاملة</th> --}}
                        <th>رقم التذكرة</th>
                        <th>القسم</th>
                        <th>القسم الفرعى</th>
                        <th>العنوان</th>
                        <th>التاريخ</th>
                        <th>الحالة</th>
                        <th>اسم المستخدم</th>
                        <!-- <th>الرابط</th> -->
                        @if (request('status') != "1")
                        <th>المبرمج</th>   
                        <!-- <th>عدد الايام</th>   -->
                        <th>الاولوية</th>  
                        @endif
                        @if (request('status') == "6" || request('status') == "7" || request('status') == "8")
                        <th>تاريخ الانتهاء</th>   
                        @endif
                        <th>الإعدادات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $problem)
                    
                        <tr>
                            
                            <td>{{ $loop->index + 1 }}</td>
                            {{-- <td>{{ $problem->installement_id }}</td> --}}
                            <td>{{ $problem->id }}</td>
                            <td>
                                @if($problem->department != NuLL)
                                    {{ $problem->department->name_ar  }}
                                @else
                                &nbsp;&nbsp;&nbsp;&nbsp;   لا يوجد
                                @endif
                            </br>
                                <a href="{{ $problem->link }}" class="btn btn-link" target="_blank">الرابط</a>
                            </td>
                            <td>
                                @if($problem->department && $problem->department->subdepartment)
                                    {{ $problem->department->subdepartment->first()->name_ar }}
                                @else
                                    لا يوجد
                                @endif
                            </td>
                            <td>{{ $problem->title }}   </td>
                            <td>
                                <p class="m-0">{{ \Carbon\Carbon::parse($problem->created_at)->format('Y/m/d') }}
                                </p>
                                <p class="m-0">{{ \Carbon\Carbon::parse($problem->created_at)->format('h:i:s A') }}
                                </p>
                                <span class="badge bg-success">
                                {{ \Carbon\Carbon::parse($problem->created_at)->diffForHumans(null, true, false, 2) }}
                                </span>
                            </td>
                            <td> <span class="badge bg-primary">{{ $statusMapping[$problem->status] }}</span>
                            </td>
                            <td>{{ $problem->user->name_ar }}</td>
                            <!-- <td> <a href="{{ $problem->link }}" class="btn btn-link" target="_blank">الرابط</a></td> -->

                           
                            @if (request('status') != "1")
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
                                <td>
                                    {{ $problem->priority == "high" 
                                    ? "مرتفعة" 
                                    : ($problem->priority == "medium" 
                                        ? "متوسطة" 
                                        : "منخفضة") 
                                }}
                                </td>

                            @endif


                            @if (request('status') == "6" || request('status') == "7" || request('status') == "8")
                                 <td> {{ \Carbon\Carbon::parse($problem->end_task)->format('Y/m/d') ?? 'لا يوجد' }}</td>   
                            @endif
                            <td>
                                <a class="btn btn-success btn-sm rounded me-6"
                                    href="{{ route('supportProblem.show', $problem->id) }}">مشاهدة
                                    التفاصيل</a>
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
