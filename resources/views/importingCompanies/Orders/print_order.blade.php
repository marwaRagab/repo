@foreach($order->order_item as $one)
<div class="container-fluid print py-5">
    <h4 class="text-center py-3">طلب شراء
    </h4>
    <div class="side-content">
        
        <p> رقم : {{$totalCount}}  / {{ $order_id }}</p>
        <p>التاريخ : {{ $order->created_at->format('d-m-Y')}}</p>
        @php 
        $item = \App\Models\ImportingCompanies\Tawreed\OrdersFiles::with('company')->where('id',$order_id)->first()->company;      
        @endphp
        <p class="print-text">السادة / {{ $item->name_ar}}   المحترمين</p>
        <p class="print-text">يرجى التكرم بتزويدنا بالأجهزة الإلكترونية التالية :-
        </p>
    </div>
    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>م</th>
                <th>الماركة</th>
                <th>الصنف</th>
                <th>الموديل</th>
                <th>الكمية المطلوبة</th>
                <th>سعر الوحدة</th>
                <th>السعر الإجمالي</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->order_item as $one)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td> {{ $one->product_order_items->mark->name_ar }}</td>
                <td> {{ $one->product_order_items->class->name_ar }}</td>
                <td> {{ $one->product_order_items->model }} </td>
                <td> {{ $one->count }} </td>
                <td> {{ number_format($one->product_order_items->price , 3) }}</td>
                <td> {{ number_format($one->product_order_items->price * $one->count , 3) }}</td>
            </tr>
            
            @endforeach
            <tr class="font-weight-bold">
                <td colspan="3" class="text-center">الإجمالي</td>
                <td colspan="3">    </td>
                <td > </td>
            </tr>
        </tbody>
    </table>
    <div class="border-top mt-4">
        <p class="print-text"> اسم العميل : شركة توب إلكترون للأجهزة الكهربائية </p>
        <p class="print-text">العنوان : الجهراء - قطعة 2 - شارع عين جالوت - مركز علياء - الدور الأول</p>
        <p class="print-text">الهاتف : :65704010</p>
    </div>
    <div class="d-flex justify-content-between">
        <div>
            <h5 class="print-text">الختم</h5>
            <h5>..................................</h5>
        </div>
        <div>
            <h5 class="print-text">التوقيع</h5>
            <h5>..................................</h5>
        </div>
    </div>
</div>
@endforeach