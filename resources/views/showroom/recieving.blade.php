
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
        <h4 class="card-title mb-0"> استلام المنتجات </h4>
    </div>
    <div class="card-body">

        <div class="table-responsive pb-4">
            <table id="file-export" class="table w-100 table-striped table-bordered display text-nowrap">
                <thead>
                    <!-- start row -->
                    <tr>
                        <th>م</th>
                        <th>رقم طلب الشراء </th>
                        <th>اسم الشركة </th>
                        <th> الأصناف</th>
                        <th> الموديلات</th>
                        <th> العدد</th>
                        <th>مكان التوريد</th>
                        <th>القيمة الإجمالية</th>
                        <th> إستلام المنتجات</th>
                    </tr>
                    <!-- end row -->
                </thead>
                <tbody>
                    <!-- start row -->
                    @foreach ($all_orders as $order)
                    @php
                    $purchase =
                    App\Models\ImportingCompanies\Tawreed\purchase_items::where('order_id',$order->id)->get();
                    @endphp
                    <tr>
                        <td> {{ $loop->index + 1 }} </td>
                        <td> {{ $order->id}}</td>
                        <td> {{$order->company->name_ar}}</td>
                        <td>
                            @foreach($purchase as $one)
                            {{ $one->product->class->name_ar}} <br>
                            @endforeach
                        </td>
                        <td>
                            @foreach($purchase as $one)
                            {{$one->product->model }}<br>
                            @endforeach
                        </td>
                        <td>
                            @foreach($purchase as $one)
                            {{$one->count}}<br>
                            @endforeach
                        </td>
                        <td> {{ 'المعرض'}}</td>
                        <td>
                            @foreach($purchase as $one)
                            @php $sum = 0 ;
                            $sum = $sum + ( $one->product->net_price * $one->count ) ;
                            @endphp
                            {{ $sum }} <br>
                            @endforeach
                        </td>

                        <td> <a class="btn btn-secondary " data-bs-toggle="modal"
                                data-bs-target="#open-file{{$order->id}}">
                                استلام المنتجات</a>
                            <div id="open-file{{$order->id}}" class="modal fade" tabindex="-1"
                                aria-labelledby="bs-example-modal-md" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header d-flex align-items-center">
                                            <h4 class="modal-title mt-2" id="myModalLabel">
                                                استلام المنتجات</h4>
                                            <hr>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">

                                            <form action="{{ route('update_purchase_order',$order->id) }}" method="POST"
                                                enctype="multipart/form-data">
                                                <input class="form-control" type="text" style="display:none;"
                                                    name="order_id" value="{{ $order->id }}">
                                                @csrf
                                                <div class="table-responsive pb-4">
                                                    <table id="file-export"
                                                        class="table table-bordered border text-nowrap align-middle">
                                                        <thead>
                                                            <tr>
                                                                <th>الماركة</th>
                                                                <th>الصنف </th>
                                                                <th> الموديل </th>
                                                                <th> العدد </th>
                                                                <th> العدد المستلم </th>
                                                                <th> استلام </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <!-- start row -->
                                                            @foreach ($purchase as $purch)
                                                            <tr>
                                                                <td> {{ $purch->product->mark->name_ar }}
                                                                </td>
                                                                <td> {{ $purch->product->class->name_ar}}</td>
                                                                <td> {{$purch->product->model }} </td>
                                                                <td>{{ $purch->count }}
                                                                    <input id="counter_{{$purch->id}}"
                                                                        name="counter_{{$purch->id}}"
                                                                        value="{{ $purch->count}}" type="hidden">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                        name="counter_received_{{$purch->id}}"
                                                                        id="counter_received_{{$purch->id}}"
                                                                        onchange="check({{ $purch->id}})">
                                                                    @error('counter_received_{{$purch->id}}')
                                                                    <div style='color:red'>{{$message}}</div>
                                                                    @enderror
                                                                </td>
                                                                <td>
                                                                    <div class="form-check py-2"> <label
                                                                            class="form-check-label"
                                                                            for="receiving_{{$purch->id}}">
                                                                        </label>
                                                                        <input class="form-check-input" type="checkbox"
                                                                            checked value="1"
                                                                            id="receiving_{{$purch->id}}"
                                                                            name="receiving_{{$purch->id}}">
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                    <div id="tableBody"></div>
                                                </div>
                                                <div class="modal-footer d-flex ">
                                                    <button type="submit" class="btn btn-primary">حفظ </button>
                                                    <button type="button"
                                                        class="btn bg-danger-subtle text-danger  waves-effect"
                                                        data-bs-dismiss="modal">
                                                        الغاء
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>
</div>
</div>
</div>
<!-- model open file  -->


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


</script>
