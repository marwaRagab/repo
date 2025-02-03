<style>
    /* Ensure Select2 matches Bootstrap theme */
    .select2-container .select2-selection--single {
        height: 40px;
        padding: 6px 12px;
        font-size: 16px;
        border-radius: 4px;
        border: 1px solid #ced4da;
        background-color: #fff;
        transition: border-color 0.2s ease-in-out;
    }

    /* Focus Effect */
    .select2-container--default .select2-selection--single:focus {
        border-color: #80bdff;
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, .25);
    }

    /* Placeholder Text */
    .select2-container--default .select2-selection--single .select2-selection__placeholder {
        color: #6c757d;
        font-style: italic;
    }

    /* Arrow Icon */
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 38px;
        width: 38px;
        background: #f8f9fa;
        border-left: 1px solid #ced4da;
        border-radius: 0 4px 4px 0;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background-color 0.3s;
    }

    /* Hover Effect */
    .select2-container--default .select2-selection--single:hover {
        border-color: #007bff;
    }

    /* Dropdown Menu */
    .select2-dropdown {
        border-radius: 4px;
        border: 1px solid #ced4da;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        background: #fff;
    }

    /* Dropdown Items */
    .select2-container--default .select2-results__option {
        padding: 10px;
        font-size: 16px;
        transition: background-color 0.2s;
    }

    /* Highlight Hovered Item */
    .select2-container--default .select2-results__option--highlighted {
        background-color: #007bff !important;
        color: white !important;
    }

    /* Selected Item */
    .select2-container--default .select2-results__option[aria-selected="true"] {
        background-color: #e9ecef;
        color: #000;
        font-weight: bold;
    }
</style>
<div class="card">
    <h4 class="card-title mb-3">إضافة صلاحية</h4>
    <div class="card-body">
        <form action="{{ route('permissions.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-sm-6">
                    <label class="form-label">اسم الصلاحية</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-6">
                    <label class="form-label">الصلاحية الرئيسية (اختياري)</label>
                    <select name="parent_id" id="parent-permission" class="form-control select2" style="direction: rtl !important;"
                        data-selected-id="{{ old('parent_id') }}">
                        <option value="">بدون</option>
                    </select>
                </div>
            </div>
<br><br>
            <button type="submit" class="btn btn-success">حفظ</button>
            <a href="{{ route('permissions.index') }}" class="btn btn-secondary">إلغاء</a>
        </form>
    </div>
</div>
<script>
    $(document).ready(function() {
        // Check if jQuery and Select2 are properly loaded
        jQuery.noConflict();
        $('#parent-permission').select2({
            placeholder: "ابحث للاضافة...",
            allowClear: true,
            dropdownAutoWidth: true,
            width: '100%',
            dropdownParent: $('#parent-permission').parent(),
            ajax: {
                url: '/permissions/search',
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
            url: '/permissions/search',
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
                url: '/permissions/search?q=' + selectedPermissionId,
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
