<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">تحديث ناجح</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
            </div>
            <div class="modal-body">
                تم تحديث البيانات بنجاح!
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">إغلاق</button>
            </div>
        </div>
    </div>
</div>



<script>
    document.querySelectorAll('.form-select').forEach(select => {
    select.addEventListener('change', function () {
        const form = this.closest('form');
        form.querySelector('.submit-button').click();

        const successModal = new bootstrap.Modal(document.getElementById('successModal'));
                            successModal.show();
                            
    });
});

</script>