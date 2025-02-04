
   <!-- Load jQuery (Ensure it's before Select2) -->
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

   <!-- Load Select2 (Bootstrap Theme) -->
   <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
   <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

   <!-- Select2 Bootstrap Theme (Optional for better styling) -->

<style>

    .select2-container .select2-selection--single {
        height: 40px;


        border-radius: 4px;
        border: 1px solid #ced4da;
        background-color: #fff;
        transition: border-color 0.2s ease-in-out;
    }


    .select2-container--default .select2-selection--single:focus {
        border-color: #80bdff;
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, .25);
    }


    .select2-container--default .select2-selection--single .select2-selection__placeholder {
        color: #6c757d;

        direction: rtl;
        float: right;
    }


    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 38px;
        width: 38px;
        background: #f8f9fa;

        border-radius: 0 4px 4px 0;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background-color 0.3s;
    }


    .select2-container--default .select2-selection--single:hover {
        border-color: #007bff;
    }


    .select2-dropdown {
        border-radius: 4px;
        border: 1px solid #ced4da;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        background: #fff;
    }

    /* Dropdown Items */
    .select2-container--default .select2-results__option {
        padding: 10px;
        direction: rtl;

        transition: background-color 0.2s;
    }


    .select2-container--default .select2-results__option--highlighted {
        background-color: #007bff !important;
        color: white !important;
    }


    .select2-container--default .select2-results__option[aria-selected="true"] {
        background-color: #e9ecef;
        color: #000;
        font-weight: bold;
    }
</style>
<div class="card">
    <h4 class="card-title mb-3">تعديل الصلاحية</h4>
    <div class="card-body">
        <form action="{{ route('permissions.update', $permission->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">اسم الصلاحية (بالإنجليزية)</label>
                <input type="text" name="name" class="form-control" value="{{ $permission->name }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">اسم الصلاحية (بالعربية)</label>
                <input type="text" name="name_ar" class="form-control" value="{{ $permission->name_ar }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">الصلاحية الرئيسية : </label>
                @if($permission->parent)
                <span>{{ $permission->parent->name }}</span>
            @endif
                <select name="parent_id" id="parent-permission" class="form-control select2" style="width: 100%" data-selected-id="{{ $permission->parent_id }}">
                </select>
            </div>

            <button type="submit" class="btn btn-success">تحديث</button>
            <a href="{{ route('permissions.index') }}" class="btn btn-secondary">إلغاء</a>
        </form>
    </div>
</div>

@section('scripts')
<script>
    $(document).ready(function() {
        // Check if jQuery and Select2 are properly loaded
        jQuery.noConflict();
        $('#parent-permission').select2({
            placeholder: "{{ $permission->parent ? $permission->parent->name : 'ابحث للاضافة...' }}",
            allowClear: true,
            dropdownAutoWidth: true,
            width: '100%',
            dropdownParent: $('#parent-permission').parent(),
            dir: "rtl",
            language: {
                noResults: function() {
                    return " لا يوجد نتائج...";
                }
            },
            ajax: {
                url: '{{ route("permissions.search") }}',
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: data.map(function(permission) {
                            return {
                                id: permission.id,
                                text: permission.name
                            };
                        })
                    };
                },
                cache: true
            }
        });

        // Load Initial Data (All Permissions)
        $.ajax({
            url: '{{ route("permissions.search") }}',
            dataType: 'json',
            success: function(data) {
                data.forEach(function(permission) {
                    let option = new Option(permission.name, permission.id, false, false);
                    $('#parent-permission').append(option);
                });
            }
        });

        // If Editing, Load Selected Permission
        let selectedPermissionId = $('#parent-permission').data('selected-id');

        if (selectedPermissionId) {
            $.ajax({
                url: '{{ route("permissions.search") }}?q=' + selectedPermissionId,
                dataType: 'json',
                success: function(data) {
                    let selectedOption = data.find(p => p.id == selectedPermissionId);
                    if (selectedOption) {
                        let option = new Option(selectedOption.text, selectedOption.id, true, true);
                        $('#parent-permission').append(option).trigger('change');
                    }
                }
            });
        }

    });
</script>
