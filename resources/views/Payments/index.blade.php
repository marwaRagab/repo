<div class="card">


    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0"> عمليات الدفع </h4>
        <div class="d-flex justify-content-between align-items-center">
            <div class="form-group ">
                <!-- <label for="dateSelect" class="form-label">اختر التاريخ</label> -->
                <select class="form-select" id="dateSelect"  name="month" onchange="addUrlParameter2('month',this.value )">
                    <option selected disabled>اختر التاريخ</option>
                    @foreach( $dates as $date)
                        <option value="{{$date}}"  {{ request()->has('month') ?   request()->get('month')  == $date  ?  'selected' : '' : '' }}   >{{$date}}</option>

                             @endforeach


                    <!-- Add more dates as needed -->
                </select>
            </div>

        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive pb-4">
            <table class="table table-striped table-bordered border text-nowrap align-middle">
                <thead class="thead-dark">
                <tr>
                    <th>م</th>
                    <th>اسم العميل</th>
                    <th>المبلغ</th>
                    <th>طريقة الدفع</th>
                    <th>رقم العملية</th>
                    <th>حالة الطباعة</th>
                    <th>التفاصيل</th>
                    <th>التاريخ</th>
                    <th>طباعة</th>
                    <th>تحويل للأرشيف</th>
                    <th>
                        <input type="checkbox" class="form-check-input" name="action[]"
                               value="0" id="all">
                    </th>
                </tr>
                </thead>
                <tbody>
                @php
                    $serial_no='';

                @endphp

                @foreach($items as $item)

                    <tr>
                        @php
                            $serial_no=count($items) - $loop->index  ;
                            $serial_no=date('Y').date('m') .$serial_no;
                        @endphp
                        <td> {{ $loop->index + 1 }}</td>
                        @if(isset($item->installment->client))
                            <td> {{$item->installment->client->name_ar}}</td>
                        @else
                            <td>لايوجد</td>
                        @endif

                        <td>  {{$item->amount}}</td>
                        <td>

                            {{$item->pay_method}}</td>
                        <td>{{$serial_no}}</td>
                        @if($item->print_status=='done')
                            <td><span class="text-success"> تم  الطباعة</span></td>
                        @else
                            <td><span class="text-danger">لا يتم الطباعة</span></td>
                        @endif
                        @php

                            @endphp

                        <td>
                            <a href="{{url('installment.show-installment/'.$item->installment_id)}}">{{$item->description}}</a>
                        </td>

                        <td>{{$item->date}}</td>
                        <td>
                            @if($item->print_status=='done')

                                <a style="text-decoration: line-through; pointer-events: none "
                                   class="btn btn-primary btn-sm rounded-pill" href="#">طباعة</a>
                            @else

                                <a class="btn btn-primary btn-sm rounded-pill" href="{{url('print_invoice/'.$item->id.'/'
.$item->installment_id.'/'.$item->install_month_id .'/'.$serial_no )}}">طباعة</a>
                            @endif

                        </td>
                        <td>
                            @if($item->print_status=='done')
                            <a class="btn btn-danger btn-sm rounded-pill"  href="{{url('set_archief/'.$item->id)}}">تحويل
                                للأرشيف
                            </a>

                            @else
                                <button class="btn btn-secondary btn-sm rounded-pill">
                                    لم يتم   الطباعة
                                </button>
                            @endif
                        </td>
                        <td><input type="checkbox" class="form-check-input" name="action[]"
                                   value="{{$item->id}}"  id={{$serial_no}} ></td>
                    </tr>

                @endforeach
                <tr>
                    <td colspan="8"></td>
                    <td>
                        <button class="btn btn-primary btn-sm rounded-pill" value="1"   onclick="valthisform(this);" > طباعة الكل</button>
                    </td>
                    <td>
                        <button class="btn btn-secondary btn-sm rounded-pill"  value="2"  onclick="valthisform(this);">
                            تحويل الجميع
                            للأرشيف
                        </button>
                    </td>
                    <td><input type="checkbox" class="form-check-input"  name="action[]"
                               value="0" id="one"></td>
                </tr>

                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script>


    function addUrlParameter2(name, value) {
        var searchParams = new URLSearchParams(window.location.search)
        searchParams.set(name, value)
        window.location.search = searchParams.toString()
    }
    var allserials = [];


    function valthisform(id) {

        var checkboxs = document.getElementsByName("action[]");

        var okay = false;
        for (var i = 0, l = checkboxs.length; i < l; i++) {

            if (checkboxs[i].checked) {
                okay = true;
                break;
            }
        }
        if (!okay) {
            alert("يجب اختيار عميل واحد على الاقل");
            //  location.reload();
            // event.preventDefault();
        } else {

            var radios = $('input[type=checkbox]:checked');
            var value = 0; var arr=[]; var arr_arch = [];
            for (var i = 0; i < radios.length; i++) {
                if (radios[i].type === 'checkbox' && radios[i].checked) {
                    // get value, set checked flag or do whatever you need to
                    // value = Number(value) + Number(radios[i].value);

                    var elem = document.getElementById(radios[i].id);

                    var typeId_print = elem.getAttribute('data-print');
                    console.log(typeId_print);

                    if(!isNaN(Number(radios[i].value)))
                    {
                        if(typeId_print != 'done'){
                            arr.push(Number(radios[i].value));
                            allserials.push(Number(radios[i].id));
                        }else {
                            arr_arch.push(Number(radios[i].value));
                        }

                    }
                }

            }




            if( id.value == 1) {

                console.log(arr);
                $.ajax({
                    type: 'Post',
                    url: url('print_all/') + "/" + arr + '/' + allserials, // Append all client IDs to URL
                    async: false,
                    // dataType: 'json',

                    success: function(data1) {
                        data = JSON.parse( data1);
                        console.log(data);



                        window.location.href = data.redirect;

                    },
                    error: function() {}
                });
            }else if (id.value == 2) {
                if(!arr_arch){
                    $.ajax({
                        type: 'Post',
                        url: url('archieve_all/') + arr_arch,

                        async: false,
                        // dataType: 'json',

                        success: function(data1) {
                            data = JSON.parse( data1);
                            console.log(data);

                            window.location.href = data.redirect;

                        },
                        error: function() {}
                    });
                }else {
                    alert('لا يمكن الارشفة قبل الطباعة');
                }


            }
            // alert(arr);

        }
    }

    $('#all').click(function(event) {
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

</script>
