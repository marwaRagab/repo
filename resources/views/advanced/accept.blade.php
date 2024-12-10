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
                <input type="hidden" name="item_id" id="item-id"> 
                    <div class="modal-body">
                        <div id="formRows">
                            <div class="px-4 py-4 sm:px-5">
                                <div class="flex mt-4">
                                    <div class="form-group mb-3">
                                        <label class="block mx-1">
                                            الحالة</label>
                                        <input
                                            class="form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="الحالة" type="text" name="status" style=""
                                            value="accepted" readonly />
                                        </label>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="block mx-1">سبب القبول </label>
                                        <input
                                            class="form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="السبب" type="text" name="reason" />
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="block mx-1">مبلغ القبول </label>
                                        <input
                                            class="form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="مبلغ القبول" type="text" name="accept_cost" />
                                    </div>
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


{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}


