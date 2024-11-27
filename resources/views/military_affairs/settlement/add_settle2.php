


<div class="card mt-4 py-3" style="width: -webkit-fill-available;">
    <div class="card-header mt-4">

    </div>
    <div class="card-header mt-4">

    </div>
    <div class="card-body">
        <form action="{{ route('settle.add_settlement',1) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-row">
                <div class="form-group mb-3">
                    <label class="form-label"> مبلغ التسوية </label>
                    <input type="text" name="amount" id="amount" readonly value="1000">
                </div>
                <div class="form-group mb-3">
                    <label class="form-label"> مقدم التسوية </label>
                    <input type="text" name="first_amount_settle"  oninput="get_remamider()" value=""
                        id="first_amount_settle">
                </div>
                <div class="form-group mb-3">
                    <label class="form-label"> المتبقى </label>
                    <input type="text" name="settle_reminder" id="settle_reminder"  value="{{}}">
                </div>
                <div class="form-group mb-3">
                    <label class="form-label"> عدد الاقساط </label>
                    <select class="form-control" onchange="get_inst_val(this)" name="installment_no"
                        id="installment_no">
                        <option value=" "><?php echo 'اختار العدد ' ?></option>
                        <?php for ($i = 1; $i <= 36; $i++) { ?>
                        <option value="<?php echo $i ?>"><?php echo $i ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label class="form-label"> قيمة القسط الشهرى </label>
                    <input type="text" name="inst_value" readonly id="inst_value">
                </div>
                <div class="form-group mb-3">
                    <label class="form-label"> قيمة القسط الاخير </label>
                    <input type="text" name="last_inst_value" readonly id="last_inst_value">
                </div>

                <div class="form-group my-3">
                    <label for="settle_date" class="control-label"> تاريخ دفع المقدم </label>
                    <input type="date"
                        class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                        name="settle_date" id="settle_date"  value=""
                        placeholder="yyyy/mm/dd">
                </div>
                <div class="form-group my-3">
                    <label for="xxxx" class="control-label"> اختر الاجراء </label>
                    <select class="form-control" name="action[]" id="action_id">
                        <option onchange="selected_all()" id="all" class="option_selected" value="all">
                            <?php echo 'الكل  ' ?></option>
                        <option class="option_selected" value="0"><?php echo ' رفع  منع سفر ' ?></option>
                        <option class="option_selected" value="1"><?php echo 'رفع  حجز سيارات  ' ?></option>
                        <option class="option_selected" value="3"><?php echo 'رفع حجز بنك  ' ?></option>
                        <option class="option_selected" value="2"><?php echo 'رفع حجز راتب  ' ?></option>
                    </select>
                </div>
            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-primary">حفظ</button>
            </div>
        </form>
    </div>
</div>

<script>
function get_remamider() {

    var total_madionia = document.getElementById('amount').value;
    var first_amount_settle = document.getElementById('first_amount_settle').value;

    var remainder = Number(total_madionia) - Number(first_amount_settle);
    // alert(remainder);
    if (Number(total_madionia) < Number(first_amount_settle)) {
        Swal.fire({
            icon: 'error',
            title: ' خطا...',
            text: 'مقدم التسوية يجب ان يكون اقل من مبلغ المديونية !',
        })
        return false;
    }

    document.getElementById('inst_value').value = '';
    document.getElementById('last_inst_value').value = '';
    document.getElementById('installment_no').value = '';

    document.getElementById('settle_reminder').value = remainder;

}

function get_inst_val(instalment_no) {
    var number_inst = instalment_no.value;
    var total_madionia = document.getElementById('amount').value;
    var first_amount_settle = document.getElementById('first_amount_settle').value;
    var remainder = Number(total_madionia) - Number(first_amount_settle);
    var val_inst = remainder / number_inst;

    if (!val_inst) {
        var final_inst_moth = Math.round(val_inst) - 1;
    } else {
        var final_inst_moth = Math.round(val_inst);
    }

    var final_remainder = final_inst_moth * number_inst;
    var reminder_amount_inst = remainder - final_remainder;

    document.getElementById('inst_value').value = final_inst_moth;
    document.getElementById('last_inst_value').value = final_inst_moth + reminder_amount_inst;
}
</script>

