@foreach($order as $comp => $ord)

<div class="container-fluid print py-5">
    <h4 class="text-center py-3">طلب شراء
    </h4>
    <div class="side-content">

        <p> رقم : {{$one->product_order_items->company->id}} / {{ $order_id }}</p>
        <p>التاريخ : {{ $Order->created_at->format('d-m-Y') }}</p>

        <p class="print-text">السادة / {{ $comp }} المحترمين</p>
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
            @foreach($ord as $one)
            @php
            $one->order_price = $one->final_price;
            @endphp
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td> {{ $one->product_order_items->mark->name_ar }}</td>
                <td> {{ $one->product_order_items->class->name_ar }}</td>
                <td> {{ $one->product_order_items->model }} </td>
                <td> {{ $one->counter }} </td>
                <td> {{ number_format($one->order_price , 3) }}</td>
                <td> {{ number_format($one->final_price * $one->counter , 3) }}</td>
            </tr>

            @endforeach
            <tr class="font-weight-bold">
                <td colspan="3" class="text-center">الإجمالي</td>
                <td colspan="3"> </td>
                <td> {{ number_format($ord->sum('final_price') , 3) }} </td>
            </tr>
        </tbody>
    </table>

    <div class="border-top mt-4">
        <p class="print-text"> اسم العميل : {{ $Order->client->name_ar}} </p>
        <p class="print-text">الهاتف : {{ $Order->client->client_phone->first()?->phone}}</p>
    </div>
    <div class="d-flex justify-content-between">
        <p class="print-text">المنطقة : {{ $Order->client->area?->first()->name_ar }}</p>
        <p class="print-text">قطعة : {{ $Order->client->client_address?->first()->block }}</p>
        <p class="print-text"> شارع : {{ $Order->client->client_address?->first()->street }}</p>
        <p class="print-text"> مبنى : {{ $Order->client->client_address?->first()->building }}</p>
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