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
              <h4 class="card-title mb-0">نسب التقسيط</h4>
              <button class="btn me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4" data-bs-toggle="modal"
    data-bs-target="#bs-example-modal-md">
    أضف نسبة
</button>

<!-- sample modal content -->
<div id="bs-example-modal-md" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myModalLabel">أضف نسبة</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="percentForm" action="{{ route('installment__percentages.store') }}" method="POST" enctype="multipart/form-data" onsubmit="return validatePercentForm(event)">
                @csrf
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="input1">الشهر</label>
                            <input type="text" name="name" class="form-control mb-2" id="input1">
                            <small id="input1-error" class="text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="input2">النسبة</label>
                            <input type="text" name="percent" class="form-control mb-2" id="input2">
                            <small id="input2-error" class="text-danger"></small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex">
                    <button type="submit" class="btn btn-primary">حفظ</button>
                    <button type="button" class="btn bg-danger-subtle text-danger waves-effect" data-bs-dismiss="modal">
                        الغاء
                    </button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

                 <!-- Edit Modal -->
        <div id="editModal" class="modal fade" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header d-flex align-items-center">
                        <h4 class="modal-title" id="editModalLabel">تعديل نسبة</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="editForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="edit_name_ar">الشهر</label>
                                <input type="text" name="name" class="form-control mb-2" id="edit_name_ar" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_name_en">النسبة</label>
                                <input type="text" name="percent" class="form-control mb-2" id="edit_name_en" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">تحديث</button>
                            <button type="button" class="btn bg-danger-subtle text-danger" data-bs-dismiss="modal">الغاء</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
            </div>
            <div class="card-body">
              <div class="table-responsive pb-4">
                <table id="all-student" class="table table-bordered border text-nowrap align-middle">
                  <thead>
                    <!-- start row -->
                    <tr>
                      <th>#</th>
                      <th> الشهر </th>
                      <th>النسبة</th>
                      <th> انشأ بواسطة</th>
                      <th>الإجراءات</th>
   
                    </tr>
                    <!-- end row -->
                  </thead>
                  <tbody>
                    <!-- start row -->
                    @foreach( $installment__percentages as $item)
                        <tr>
                        <td>
                        {{ $loop->index + 1 }}
                        </td>
                        <td>
                        {{$item->name}}
                        </td> 
                            <td>{{$item->percent}}</td>
                        <td>
                        {{$item->user->name_ar ?? null}}
                        </td>
                        <td>
                            <div class="action-btn">
                            <a href="javascript:void(0)" class="text-primary edit" data-id="{{ $item->id }}" data-name_ar="{{ $item->name }}" data-name_en="{{ $item->percent }}" data-bs-toggle="modal" data-bs-target="#editModal">
                                <i class="ti ti-pencil fs-5"></i>
                            </a>
                            <form id="delete-form-{{ $item->id }}" action="{{ route('installment__percentages.destroy', $item->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <a href="javascript:void(0);" class="text-danger" onclick="confirmDelete({{$item->id}})">
                                        <i class="ti ti-trash fs-5"></i>
                                    </a>
                                </form>
                            </div>
                        </td>
                        </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <script>
            function validatePercentForm(event) {
                event.preventDefault();
        
                // Get input values and error display elements
                const nameInput = document.getElementById('input1');
                const percentInput = document.getElementById('input2');
                const nameError = document.getElementById('input1-error');
                const percentError = document.getElementById('input2-error');
                
                let isValid = true;
        
                // Clear previous error messages
                nameError.textContent = '';
                percentError.textContent = '';
        
                // Validate name input
                if (!nameInput.value.trim()) {
                    nameError.textContent = 'الرجاء إدخال الإسم';
                    isValid = false;
                }
        
                // Validate percentage input
                const percentValue = parseFloat(percentInput.value);
                if (!percentInput.value.trim()) {
                    percentError.textContent = 'الرجاء إدخال النسبة';
                    isValid = false;
                } else if (isNaN(percentValue) || percentValue < 0 || percentValue > 100) {
                    percentError.textContent = 'النسبة يجب أن تكون رقماً بين 0 و 100';
                    isValid = false;
                }
        
                // Submit form if all fields are valid
                if (isValid) {
                    document.getElementById('percentForm').submit();
                }
            }
        </script>

<script>
    
    // delete
    function confirmDelete(id) {
        if (confirm('هل أنت متأكد أنك تريد حذف هذه النسبة؟')) {
            document.getElementById('delete-form-' + id).submit();
        }
    }

    // edit
    document.addEventListener('DOMContentLoaded', function () {
    // Edit button handler
    document.querySelectorAll('.edit').forEach(button => {
        button.addEventListener('click', function () {
            let id = this.getAttribute('data-id');
            let name_ar = this.getAttribute('data-name_ar');
            let name_en = this.getAttribute('data-name_en');

            document.getElementById('editForm').setAttribute('action', `/installment__percentages/update/${id}`);
            document.getElementById('edit_name_ar').value = name_ar;
            document.getElementById('edit_name_en').value = name_en;
        });
    });

});

</script>