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
        <input type="hidden" name="type_id" value="{{ request()->get('stop_car_type') }}">
        <input type="hidden" name="item_type_new" value="{{ request()->get('stop_car_type') }}">
        <input type="hidden" name="item_type_old" value="{{ request()->get('stop_car_type') }}">

        <div class="col-sm-12">
            <div class="white-box">

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                
                @foreach ($cars as $car)
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="car_type_{{ $car->id }}" class="control-label">نوع السيارة</label>
                                <input type="text" class="form-control" id="car_type_{{ $car->id }}"
                                       value="{{ $car->car_type }}" readonly>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="car_number_{{ $car->id }}" class="control-label">رقم اللوحة</label>
                                <input type="text" class="form-control" id="car_number_{{ $car->id }}"
                                       value="{{ $car->car_number }}" readonly>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="car_catch_{{ $car->id }}" class="control-label">حجز السيارة</label>
                                <input type="checkbox" class="form-check-input"
                                       id="car_catch_{{ $car->id }}" name="car_catch[]"
                                       value="{{ $car->id }}" {{ $car->car_catch ? 'checked disabled' : '' }}>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-success">حفظ</button>
                </div>
            </div>
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
