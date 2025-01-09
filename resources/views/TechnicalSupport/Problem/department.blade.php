<div class="card mt-4 py-3">
    <div class="d-flex flex-wrap mb-3">
       
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
      
    </div>
</div>
<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0">الاقسام الرئيسية 
        </h4>

        <button class="btn me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4" data-bs-toggle="modal"
            data-bs-target="#bs-example-modal-md">
            أضف قسم
        </button>
        
    </div>

     <!-- sample modal content -->
     <div id="bs-example-modal-md" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md"
     aria-hidden="true">
     <div class="modal-dialog modal-dialog-scrollable modal-lg">
         <div class="modal-content">
             <div class="modal-header d-flex align-items-center">
                 <h4 class="modal-title" id="myModalLabel">أضف قسم</h4>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <form id="departmentForm" action="{{ route('departments.store') }}" method="POST"
                 enctype="multipart/form-data" onsubmit="return validateNationalityForm(event)">
                 @csrf
                 <div class="modal-body">
                     <div class="form-row">
                         <div class="form-group">
                             <label class="form-label" for="input1">الإسم بالعربية</label>
                             <input type="text" name="name_ar" class="form-control mb-2" id="input1">
                             <small id="input1-error" class="text-danger"></small>
                         </div>
                         <div class="form-group">
                             <label class="form-label" for="input2">الإسم بالإنجليزية</label>
                             <input type="text" name="name_en" class="form-control mb-2" id="input2">
                             <small id="input2-error" class="text-danger"></small>
                         </div>
                     </div>
                 </div>
                 <div class="modal-footer d-flex">
                     <button type="submit" class="btn btn-primary">حفظ</button>
                     <button type="button" class="btn bg-danger-subtle text-danger waves-effect"
                         data-bs-dismiss="modal">
                         الغاء
                     </button>
                 </div>
             </form>
         </div>
     </div>
 </div>

    <div class="card-body">
        <div class="table-responsive pb-4">
            <table id ="file_export" class="table table-bordered border text-nowrap align-middle">
                <thead>
                    <tr>
                        <th>م</th>
                        <th>اسم القسم</th>
                        <th>عدد الاقسام الفرعية</th>
                        <th>عدد التذاكر </th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $problem)
                        <tr>
                            
                            <td>{{ $loop->index + 1 }}</td>
                            <td>
                                @if($problem != NuLL)
                                    {{ $problem->name_ar  }}
                                @else
                                   لا يوجد
                                @endif
                            </td>
                                                        
                            <td> <a href="{{ route('supportProblem.getSubDepartments', $problem->id) }}"><span class="badge bg-primary">{{ $problem->subdepartment->count() }}</span></a>
                            </td>
                            <td><a href="{{ route('supportProblem.index', ['status' => 'all' ,'department_id'=> $problem->id ,'sub_department_id'=> null ]) }}"><span class="badge bg-success">{{ $problem->problems->count() }}</span></a></td>
                            
                        </tr>
                   
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


