<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0"> حجز سيارات</h4>
        <div class="d-flex">
        </div>
    </div>
    <div class="card-body">


    <form class="mega-vertical"  action="{{ route('catch_car_done', $item->id) }}" method="POST">
        @csrf
        <input type="hidden" name="military_affairs_id" value="{{ $item->id }}">
        <input type="hidden" name="type" value="{{ $item_type_time1->type }}">
        <input type="hidden" name="type_id" value="{{ $item_type_time1->slug }}">
        <input type="hidden" name="item_type_new" value="{{ $item_type_time_new->slug }}">
        <input type="hidden" name="item_type_old" value="{{ $item_type_time1->slug }}">

        <div class="col-sm-12">
            <div class="white-box">

                <table class="table table-bordered" style="direction: rtl; text-align: right;">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" id="select-all" class="form-check-input">
                            </th>
                            <th>نوع السيارة</th>
                            <th>رقم اللوحة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cars as $car)
                            <tr>
                                <td>
                                    <input type="checkbox" class="form-check-input row-checkbox"
                                           name="car_catch[]"
                                           value="{{ $car->id }}"
                                           {{ $car->car_catch ? 'checked disabled' : '' }}>
                                </td>
                                <td>
                                    <input type="text" class="form-control"
                                           value="{{ $car->car_type }}"
                                           name="car_type_{{ $car->id }}" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control"
                                           value="{{ $car->car_number }}"
                                           name="car_number_{{ $car->id }}" readonly>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-success">حفظ</button>
                </div>
            </div>
        </div>
    </form>

    </div>
</div>


<script>
    // Select All Functionality
    document.getElementById('select-all').addEventListener('change', function () {
        const checkboxes = document.querySelectorAll('.row-checkbox');
        checkboxes.forEach(checkbox => {
            if (!checkbox.disabled) {
                checkbox.checked = this.checked;
            }
        });
    });



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
