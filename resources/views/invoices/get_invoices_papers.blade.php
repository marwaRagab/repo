<div class="card mt-4 py-3">
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <form method="POST" action="{{ route('invoices_cashier.export') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="payment_file_dir">صورة تصدير الحسابات</label>
                        <input type="file" name="payment_file_dir" id="payment_file_dir" class="form-control" required>
                        @error('payment_file_dir')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mt-10">
                        <button type="submit" class="btn btn-primary">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
