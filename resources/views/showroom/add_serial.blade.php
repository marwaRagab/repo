
<!--<div class="card mt-4 py-3">
     <div class="d-flex flex-wrap ">
        <a class=" btn-filter me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4 mx-1 mb-2 "
            href="./recieve-product-archieve.html">
            الارشيف
        </a>
    </div> 
</div>-->
<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0"> استلام  </h4>
    </div>
    <div class="card-body">
        <form action="{{ route('showroom.addSerial',$id) }}" method="POST" enctype="multipart/form-data">
            <input class="form-control" type="text" style="display:none;" name="order_id" value="{{ $id }}">
            @csrf
            <div class="table-responsive pb-4">
                <table id="file-export" class="table w-100 table-striped table-bordered display text-nowrap">
                    <thead>
                        <!-- start row -->
                        <tr>
                            <th>م</th>
                            <th> الماركة</th>
                            <th> الصنف</th>
                            <th> الموديل</th>
                            <th> السريال</th>
                            <th> الصورة</th>
                        </tr>
                        <!-- end row -->
                    </thead>
                    <tbody>
                        <!-- start row -->
                        @foreach ($new_items as $item)
                        <tr>
                            <td> {{ $loop->index + 1 }} </td>
                            <td> {{ $item->product->mark->name_ar }}</td>
                            <td>
                                {{ $item->product->class->name_ar }} <br>
                            </td>
                            <td>
                                {{$item->product->model }}<br>
                            </td>
                            <td>
                                <input type="text" class="form-control" name="serial_number_{{$item->id}}"
                                    id="serial_number_{{$item->id}}">
                                @error('serial_number_{{$item->id}}')
                                <div style='color:red'>{{$message}}</div>
                                @enderror
                            </td>
                            <td><input type="file" name="serial_number_img_{{ $item->id}}" class="form-control" /></td>
                            
                        </tr>
                        @endforeach
                        
                    </tbody>
                    
                </table>
                
            </div>
            <button type="submit" class="btn btn-primary">حفظ </button>
        </form>
    </div>
</div>



<script>
function check(id) {

    var recieved_counter = document.getElementById("counter_received_" + id).value;
    var counter = document.getElementById("counter_" + id).value;
    if (recieved_counter == '' || counter == '') {
        alert('  العدد المستلم مطلوب ');
        return false;
    }

    if (document.getElementById("receiving_" + id).checked) {
        if (recieved_counter > counter || recieved_counter < 1) {
            alert('   العدد غير صحيح');
            return false;
        }
    }
}

function test(val) {
    alert(val);
    var number = val;
    var tableBody = document.getElementById('tableBody');

    tableBody.innerHTML = '';

    if (!isNaN(number) && number > 0) {
        for (var i = 1; i <= number; i++) {
            var row = document.createElement('tr');

            var tdLabel = document.createElement('td');
            var label = document.createElement('label');
            var model_input = document.createElement('input');

            label.innerText = 'الموديل ' + i;
            tdLabel.appendChild(label);
            row.appendChild(tdLabel);

            tdLabel.appendChild(model_input);
            row.appendChild(model_input);

            var tdRadio = document.createElement('td');

            var radioBtn1 = document.createElement('input');
            radioBtn1.type = 'radio';
            radioBtn1.name = 'radioOption_' + i;
            radioBtn1.value = 'option1';
            radioBtn1.id = 'radioOption1_' + i;
            tdRadio.appendChild(radioBtn1);
            tdRadio.appendChild(document.createTextNode(' سيريال '));

            var radioBtn2 = document.createElement('input');
            radioBtn2.type = 'radio';
            radioBtn2.name = 'radioOption_' + i;
            radioBtn2.value = 'option2';
            radioBtn2.id = 'radioOption2_' + i;
            tdRadio.appendChild(radioBtn2);
            tdRadio.appendChild(document.createTextNode(' باركود '));
            row.appendChild(tdRadio);

            var tdInputContainer = document.createElement('td');
            var inputContainer = document.createElement('div');
            inputContainer.id = 'inputContainer_' + i;
            tdInputContainer.appendChild(inputContainer);
            row.appendChild(tdInputContainer);


            tableBody.appendChild(row);

            function handleRadioChange(event) {
                var inputContainer = document.getElementById('inputContainer_' + i);
                inputContainer.innerHTML = '';

                if (event.target.value === 'option1') {
                    var input1 = document.createElement('input');
                    input1.type = 'text';
                    input1.placeholder = 'السيريال';
                    inputContainer.appendChild(input1);
                } else if (event.target.value === 'option2') {
                    var input2 = document.createElement('input');
                    input2.type = 'text';
                    input2.placeholder = 'الباركود';
                    inputContainer.appendChild(input2);
                }
            }

            radioBtn1.addEventListener('change', handleRadioChange);
            radioBtn2.addEventListener('change', handleRadioChange);
        }
    }
}


</script>

