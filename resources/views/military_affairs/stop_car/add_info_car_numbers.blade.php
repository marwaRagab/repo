<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0"> ادخال بيانات السيارات</h4>
        <div class="d-flex">
        </div>
    </div>
    <div class="card-body">
<form class="mega-vertical" action="{{ route('update_info_cars_numbers', $item->id) }}" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
    @csrf

    @for ($i = 0; $i < $item->stop_car_car_num; $i++)
        <div class="row mb-3">
            <div class="col-md-2">
                <div class="form-group">
                    <label for="car_type_{{ $i }}" class="form-label">نوع السيارة</label>
                    <input type="text" name="car_type[]" id="car_type_{{ $i }}" class="form-control" required>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="car_number_{{ $i }}" class="form-label">رقم اللوحة</label>
                    <input type="text" name="car_number[]" id="car_number_{{ $i }}" class="form-control" required>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="car_price_{{ $i }}" class="form-label">قيمة السيارة</label>
                    <input type="number" name="car_price[]" id="car_price_{{ $i }}" class="form-control" required>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="car_modal_{{ $i }}" class="form-label">الموديل</label>
                    <input type="text" name="car_modal[]" id="car_modal_{{ $i }}" class="form-control">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="car_color_{{ $i }}" class="form-label">اللون</label>
                    <input type="color" name="car_color[]" id="car_color_{{ $i }}" class="form-control">
                </div>
            </div>
        </div>
    @endfor

    <div class="form-group">
        <button type="submit" class="btn btn-success mt-3">حفظ</button>
    </div>
</form>
    </div>
</div>


<script>
    function validateForm() {
        let valid = true;

        // Clear previous error highlights
        document.querySelectorAll('input[required]').forEach(input => {
            input.classList.remove('is-invalid');
        });

        // Check each required input
        document.querySelectorAll('input[required]').forEach(input => {
            if (!input.value.trim()) {
                valid = false;
                input.classList.add('is-invalid'); // Highlight invalid input
            }
        });

        // Show error message if validation fails
        if (!valid) {
            Swal.fire({
                icon: 'error',
                title: 'خطأ...',
                text: 'يجب إدخال جميع البيانات المطلوبة!',
            });
        }

        return valid;
    }
</script>
