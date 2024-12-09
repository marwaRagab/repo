<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0">المعاملات </h4>
        
    </div>
    
</div>

<div class="card">
    <div class="card-body">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myModalLabel"> اضف سبب</h4>
            </div>
            <form  action="{{ route('myinstall.update', $Installment_client ) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="item_id" id="item-id"> <!-- Hidden field for item ID -->
                <div class="modal-body">
                    <div id="formRows">
                        <div class="form-row">
                            <div class="form-group mb-3">
                                <label class="form-label block mx-1">
                                    الحالة</label>
                                <input class="form-control" placeholder="الحالة" type="text" name="status"
                                    value="accepted_condition" readonly />
                            </div>
                            <div class="form-group mb-3">

                                <label class="form-label block mx-1">
                                    السبب</label>
                                <input class="form-control" placeholder="السبب" type="text" name="reason" />
                            </div>
                        </div>
                     
                    </div>
                </div>
                <div class="modal-footer d-flex ">
                    <button type="submit" class="btn btn-primary">حفظ</button>
                    <button type="button" class="btn bg-danger-subtle text-danger waves-effect"
                        data-bs-dismiss="modal">
                        الغاء
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


