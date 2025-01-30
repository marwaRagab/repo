<style>
    .modal-dialog {
        max-width: 80%;
        width: 100%;
    }

    .modal-body {
        max-height: 60vh;
        overflow-y: auto;
    }
</style>

<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0"> مجموعات العمل</h4>
        <div class="d-flex">
            <a class="btn me-1 mb-1 bg-primary-subtle text-primary px-4  " href="{{ route('role.create') }}">
                أضف جديد </a>


        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive pb-4">
            <table id="all-student" class="table table-bordered border text-nowrap align-middle">
                <thead>
                    <!-- start row -->
                    <tr>
                        <th>#</th>
                        <th> الإسم </th>
                        {{-- <th>رقم حساب البنك</th> --}}
                        <th>عدد العاملين</th>
                        <th> انشأ بواسطة</th>
                        <th>الإجراءات</th>
                    </tr>
                    <!-- end row -->
                </thead>
                <tbody>
                    <!-- start row -->
                    foreach ($rolesWithUsers as $role) {
                        echo "Role: " . $role->name . "\n";
                        foreach ($role->users as $user) {
                            echo "- User: " . $user->name . "\n";
                        }
                    }


                    @foreach ($roles as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>
                                {{ $item->name_ar }}
                            </td>
                            <td>
                                {{ $item->users()->where('role_id', $item->id)->count() }}
                            </td>
                            <td>
                                {{ $item->user->name_ar ?? 'لايوجد' }}
                            </td>
                            <td>
                                <div class="action-btn">
                                    <a class="text-primary edit-btn" href="{{ route('roles.edit', $item->id) }}">
                                        <i class="ti ti-pencil fs-5"></i>
                                    </a>

                                    <a class="text-primary show-btn" href="{{ route('roles.show', $item->id) }}">
                                        <i class="ti ti-eye fs-5"></i>
                                    </a>

                                    <a href="{{ route('roles.destroy', $item->id) }}" class="text-dark delete ms-2">
                                        <i class="ti ti-trash fs-5"></i>
                                    </a>


                                    {{-- <div id="bs-example-modal-edit" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header d-flex align-items-center">
                                                    <h4 class="modal-title" id="myModalLabel">
                                                        تعديل </h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="editBankForm" method="get" enctype="multipart/form-data">
                                                        @csrf
                                                    <div class="row pt-3">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label"> الإسم بالعربية <span
                                                                        class="text-danger">*</span></label>
                                                                <input type="text" name="name_ar" id="name_ar_e"
                                                                    class="form-control" required  />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label"> الإسم بالانجليزية <span
                                                                        class="text-danger">*</span></label>
                                                                <input type="text" name="name_en" id="name_en_e"
                                                                    class="form-control" required />
                                                            </div>
                                                        </div>

                                                        <div class="col-12">
                                                            <h5>اختر الصلاحيات :</h5>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <ul class="category-tree">
                                                            <div class="row">
                                                                @foreach ($Permissions as $item)
                                                                    <div class="col-3 my-3">
                                                                        <li>
                                                                            <label class="text-indigo my-2">
                                                                                <input type="checkbox"
                                                                                    name="permissions[]"
                                                                                    value="{{ $item->id }}"
                                                                                    class="m-2">
                                                                                {{ $item->title_ar }}
                                                                            </label>
                                                                            <ul class="category-tree">
                                                                                @if ($item->childrenRecursive->count() > 0)
                                                                                    @foreach ($item->childrenRecursive as $childrenRecursive)
                                                                                        <li>
                                                                                            <label
                                                                                                class="text-warning my-2">
                                                                                                <input type="checkbox"
                                                                                                    name="permissions[]"
                                                                                                    value="{{ $childrenRecursive->id }}"
                                                                                                    class="m-2">
                                                                                                {{ $childrenRecursive->title_ar }}
                                                                                            </label>
                                                                                            @if ($childrenRecursive->childrenRecursive->count() > 0)
                                                                                                <ul
                                                                                                    class="category-tree d-flex align-items-center">
                                                                                                    @foreach ($childrenRecursive->childrenRecursive as $subchild)
                                                                                                        <li>
                                                                                                            <label
                                                                                                                class="text-muted m-2">
                                                                                                                <input
                                                                                                                    type="checkbox"
                                                                                                                    name="permissions[]"
                                                                                                                    value="{{ $subchild->id }}"
                                                                                                                    class="m-2">
                                                                                                                {{ $subchild->title_ar }}
                                                                                                            </label>
                                                                                                        </li>
                                                                                                    @endforeach
                                                                                                </ul>
                                                                                            @endif
                                                                                        </li>
                                                                                    @endforeach
                                                                                @endif
                                                                            </ul>
                                                                        </li>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="modal-footer d-flex ">
                                                    <button type="submit" class="btn btn-primary">حفظ</button>
                                                    <button type="button"
                                                        class="btn bg-danger-subtle text-danger waves-effect"
                                                        data-bs-dismiss="modal">
                                                        الغاء
                                                    </button>
                                                </div>
                                                </form>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div> --}}

                                    {{-- <div id="bs-example-modal-show" class="modal fade" tabindex="-1"
                                        aria-labelledby="bs-example-modal-md" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header d-flex align-items-center">
                                                    <h4 class="modal-title" id="myModalLabel">
                                                        عرض </h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row pt-3">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label"> الإسم بالعربية <span
                                                                        class="text-danger">*</span></label>
                                                                <input type="text" name="name_ar" id="name_ar_s"
                                                                    class="form-control" required />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label"> الإسم بالانجليزية <span
                                                                        class="text-danger">*</span></label>
                                                                <input type="text" name="name_en" id="name_en_s"
                                                                    class="form-control" required />
                                                            </div>
                                                        </div>

                                                        <div class="col-12">
                                                            <h5>اختر الصلاحيات :</h5>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <ul class="category-tree">
                                                            <div class="row">
                                                                @foreach ($Permissions as $item)
                                                                    <div class="col-3 my-3">
                                                                        <li>
                                                                            <label class="text-indigo my-2">
                                                                                <input type="checkbox"
                                                                                    name="permissions[]"
                                                                                    value="{{ $item->id }}"
                                                                                    class="m-2">
                                                                                {{ $item->title_ar }}
                                                                            </label>
                                                                            <ul class="category-tree">
                                                                                @if ($item->childrenRecursive->count() > 0)
                                                                                    @foreach ($item->childrenRecursive as $childrenRecursive)
                                                                                        <li>
                                                                                            <label
                                                                                                class="text-warning my-2">
                                                                                                <input type="checkbox"
                                                                                                    name="permissions[]"
                                                                                                    value="{{ $childrenRecursive->id }}"
                                                                                                    class="m-2">
                                                                                                {{ $childrenRecursive->title_ar }}
                                                                                            </label>
                                                                                            @if ($childrenRecursive->childrenRecursive->count() > 0)
                                                                                                <ul
                                                                                                    class="category-tree d-flex align-items-center">
                                                                                                    @foreach ($childrenRecursive->childrenRecursive as $subchild)
                                                                                                        <li>
                                                                                                            <label
                                                                                                                class="text-muted m-2">
                                                                                                                <input
                                                                                                                    type="checkbox"
                                                                                                                    name="permissions[]"
                                                                                                                    value="{{ $subchild->id }}"
                                                                                                                    class="m-2">
                                                                                                                {{ $subchild->title_ar }}
                                                                                                            </label>
                                                                                                        </li>
                                                                                                    @endforeach
                                                                                                </ul>
                                                                                            @endif
                                                                                        </li>
                                                                                    @endforeach
                                                                                @endif
                                                                            </ul>
                                                                        </li>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </ul>
                                                    </div>
                                                </div>


                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div> --}}
                                </div>
                            </td>
                        </tr>
                    @endforeach


                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


{{-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function() {
                const itemId = this.getAttribute('data-id');
                fetch(`/human-resources/roles/edit/${itemId}`)
                    .then(response => response.json())
                    .then(data => {

                        console.log(data);

                        // Populate the fields
                        document.getElementById('name_ar_e').value = data.role.name_ar ??
                            'لايوجد';
                        document.getElementById('name_en_e').value = data.role.name_en ??
                            'لايوجد';

                        // Handle permissions
                        data.permissions.forEach(permission => {
                            const mainCheckbox = document.querySelector(
                                `input[name="permissions[]"][value="${permission.id}"]`
                                );
                            if (mainCheckbox) {
                                // mainCheckbox.checked = false;
                                mainCheckbox.checked = permission.checked;
                            }

                            permission.children.forEach(child => {
                                console.log(`Child Data:`,child); // Log child data

                                var childCheckbox = document.querySelector(
                                    `input[name="permissions[]"][value="${child.id}"]`
                                    );
                                // console.log(`Child Checkbox Element:`, childCheckbox); // Log the checkbox element
                                if (childCheckbox) {

                                    // document.querySelector("m-2").checked = true;

                                     console.log("dd")
                                    childCheckbox.checked = child.checked; // Set checked state
                                    // childCheckbox.dispatchEvent(new Event('change'));
                                    console.log(
                                        `Child Checkbox with ID ${child.id} set to checked: ${childCheckbox.checked}`
                                        );
                                } else {
                                    console.error(
                                        `Child Checkbox with value "${child.id}" not found in the DOM.`
                                        );
                                }

                                // Check subchild permissions
                                if (child.subchildren) {
                                    child.subchildren.forEach(subchild => {
                                        const subchildCheckbox =
                                            document.querySelector(
                                                `input[name="permissions[]"][value="${subchild.id}"]`
                                                );
                                        console.log(
                                            `Subchild Checkbox Element:`,
                                            subchildCheckbox
                                            ); // Log the subchild checkbox element

                                        if (subchildCheckbox) {
                                            subchildCheckbox
                                                .checked = subchild
                                                .checked; // Set checked state
                                            console.log(
                                                `Subchild Checkbox with ID ${subchild.id} set to checked: ${subchildCheckbox.checked}`
                                                );
                                        } else {
                                            console.error(
                                                `Subchild Checkbox with value "${subchild.id}" not found in the DOM.`
                                                );
                                        }
                                    });
                                }
                            });
                        });

                        document.getElementById('editBankForm').setAttribute('action',
                            `/human-resources/roles/update/${itemId}`);

                        // Show the modal
                        var editModal = new bootstrap.Modal(document.getElementById(
                            'bs-example-modal-edit'));
                        editModal.show();
                    })
                    .catch(error => console.error('Error fetching item data:', error));
            });
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.show-btn').forEach(button => {
            button.addEventListener('click', function() {
                const itemId = this.getAttribute('data-id');
                console.log(itemId);
                // Fetch data for the selected item
                fetch(`/human-resources/roles/edit/${itemId}`)
                    .then(response => response.json())
                    .then(data => {
                        // console.log(data?.user);
                        // Populate modal fields with fetched data
                        document.getElementById('name_ar_s').value = data.role.name_ar ??
                            'لايوجد';
                        document.getElementById('name_en_s').value = data.role.name_en ??
                            'لايوجد';

                        // Handle permissions
                        data.permissions.forEach(permission => {
                            const mainCheckbox = document.querySelector(
                                `input[name="permissions[]"][value="${permission.id}"]`
                                );
                            if (mainCheckbox) {
                                mainCheckbox.checked =permission.checked; // Check main permission
                            }

                            permission.children.forEach(child => {
                                // console.log(`Child Data:`,child); // Log child data
                                var childCheckbox = document.querySelector(`input[name="permissions[]"][value="${child.id}"]`);
                                if (childCheckbox) {
                                    childCheckbox.checked = child.checked;
                                    console.log(`Child Checkbox with ID ${child.id} set to checked: ${childCheckbox.checked}`);
                                } else {
                                    console.error(
                                        `Child Checkbox with value "${child.id}" not found in the DOM.`
                                        );
                                }

                                // Check subchild permissions
                                if (child.subchildren) {
                                    child.subchildren.forEach(subchild => {
                                        const subchildCheckbox =
                                            document.querySelector(
                                                `input[name="permissions[]"][value="${subchild.id}"]`
                                                );
                                        console.log(
                                            `Subchild Checkbox Element:`,
                                            subchildCheckbox
                                            );

                                        if (subchildCheckbox) {
                                            subchildCheckbox.checked = subchild.checked; // Set checked state

                                        } else {
                                            console.error(
                                                `Subchild Checkbox with value "${subchild.id}" not found in the DOM.`
                                                );
                                        }
                                    });
                                }
                            });
                        });

                        // document.getElementById('editBankForm').setAttribute('action',
                        //     `/human-resources/roles/update/${itemId}`);

                        // Show the modal
                        var editModal = new bootstrap.Modal(document.getElementById(
                            'bs-example-modal-show'));
                        editModal.show();
                    })
                    .catch(error => console.error('Error fetching item data:', error));;
            });
        });
    });
</script> --}}
