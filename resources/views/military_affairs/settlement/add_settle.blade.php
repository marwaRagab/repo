<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0"> طلب التسوية </h4>
    </div>
    <div class="card-body">
        <h6>
            الإسم :
            <span class="text-muted">{{$item_military->installment->client->name_ar}}( {{$item_military->installment->id}} ) </span>
        </h6>
        <h6>
            الرقم المدنى :
            <span class="text-muted">{{$item_military->installment->client->civil_number}} </span>
        </h6>
        <h6>
            رقم الهاتف :
            <span class="text-muted">{{$item_military->installment->client->client_phone->last()  ?  $item_military->installment->client->client_phone->last()->phone  : ''}} </span>
        </h6>
        <h6>
            مبلغ المديونية :
            <span class="text-muted">{{$item_military->eqrar_dain_amount}} </span>
        </h6>
        <h6>
            المدفوع :
            <span class="text-muted"> {{$item_military->eqrar_dain_amount}} </span>
        </h6>
        <h6>
            المبلغ المتبقى :
            <span class="text-muted">{{$item_military->reminder_amount}}</span>
        </h6>
        <form class="mega-vertical"
              action="{{url('add_settlement')}}" method="post"
              enctype="multipart/form-data">
            @csrf
            <input type="hidden"  name="military_affairs_id" value="{{$item_military->id}}"  >

            <div class="form-row flex-wrap d-flex gap-3 p-3 border mt-3">
                <div class="form-group">
                    <label for="amount" class="form-label"> مبلغ التسوية </label>
                    <input type="text"  name="amount" id="amount" readonly value="{{$item_military->reminder_amount}}"
                           class="form-control">

                </div>
                <div class="form-group">
                    <label for="first_amount_settle" class="form-label"> مقدم التسوية </label>
                    <input type="text" name="first_amount_settle"  oninput="get_remamider()" id="first_amount_settle"  value="{{old('first_amount_settle')}}"
                           class="form-control ">
                    @error('first_amount_settle')
                    <div style='color:red'>{{$message}}</div>
                    @enderror
                </div>
                <input type="hidden" name="" >
                <div class="form-group">
                    <label for="remainder" class="form-label"> المتبقى </label>
                    <input type="text"   name="settle_reminder"  readonly  id="settle_reminder" class="form-control"  value="{{old('settle_reminder')}}">

                </div>
                <div class="form-group">
                    <label for="installment_no" class="form-label"> عدد الاقساط  </label>

                    <select class="form-control" onchange="get_inst_val(this)" name="installment_no"  value ="{{old('installment_no')}}"
                            id="installment_no">
                        @for($i=1; $i<=36 ;$i++)
                            <option value ="{{$i}}">{{$i}} </option>

                        @endfor

                    </select>
                    @error('installment_no')
                    <div style='color:red'>{{$message}}</div>
                    @enderror

                </div>

                <div class="form-group">
                    <label for="inst_value" class="form-label"> قيمة القسط الشهرى </label>
                    <input type="text" class="form-control"    name="inst_value" readonly id="inst_value">


                </div>
                <div class="form-group">
                    <label for="last_inst_value" class="form-label"> قيمة القسط الاخير </label>
                    <input type="text" class="form-control" name="last_inst_value" readonly id="last_inst_value"
                    >

                </div>
                <div class="form-group">
                    <label for="settle_date" class="form-label"> تاريخ دفع المقدم </label>
                    <input type="date" class="form-control "  name="date" id="settle_date"  value="{{old('settle_date')}}" >
                    @error('date')
                    <div style='color:red'>{{$message}}</div>
                    @enderror
                </div>
                <div class="form-group">

                    <label for="action_id" class="form-label"> اختر الاجراء </label>
                    <div id="action_id">
                        <div class="form-check form-check-inline">
                            <input type="checkbox" class="form-check-input" name="action[]" value="all" id="select-all">
                            <label for="action_all" class="form-check-label">الكل</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" class="form-check-input" name="action[]" value="3" id="action_bank_hold">
                            <label for="action_bank_hold" class="form-check-label">رفع حجز بنك</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" class="form-check-input" name="action[]" value="2" id="action_salary_hold">
                            <label for="action_salary_hold" class="form-check-label">رفع حجز راتب</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" class="form-check-input" name="action[]" value="1" id="action_car_hold">
                            <label for="action_car_hold" class="form-check-label">رفع حجز سيارات</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" class="form-check-input" name="action[]" value="0" id="action_travel_ban">
                            <label for="action_travel_ban" class="form-check-label">رفع منع سفر</label>
                        </div>
                    </div>




                </div>
            </div>
            <button type="submit" class="btn btn-success">حفظ </button>
        </form>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script>

    $('#select-all').click(function(event) {
        if(this.checked) {
            // Iterate each checkbox
            $(':checkbox').each(function() {
                this.checked = true;
            });
        } else {
            $(':checkbox').each(function() {
                this.checked = false;
            });
        }
    });
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
