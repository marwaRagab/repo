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
        select.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const userId = selectedOption.getAttribute('data-user-id');
            const militaryId = selectedOption.getAttribute('data-military-id');
            const status = selectedOption.getAttribute('data-status');
            console.log(selectedOption);
            console.log(userId);
            console.log(militaryId);
            console.log(status);

            if (userId && militaryId && status) {
                fetch('/update-responsible', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token for security
                        },
                        body: JSON.stringify({
                            user_id: userId,
                            military_id: militaryId,
                            status: status,
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const successModal = new bootstrap.Modal(document.getElementById(
                                'successModal'));
                            successModal.show();
                            // Reload the page after the modal is closed
                            document.getElementById('successModal').addEventListener(
                                'hidden.bs.modal', () => {
                                    window.location.reload();
                                });

                        } else {
                            alert('حدث خطأ أثناء التحديث!');
                        }
                    })
                    .catch(error => {
                        alert('فشل في إرسال الطلب!');
                    });
            } else {
                alert('يرجى تحديد خيار صالح.');
            }
        });
    });
</script>