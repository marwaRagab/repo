<div class="container-fluid print py-5">
    <h4 class="text-center py-3">فاتورة   
        رقم ( {{ $order_id }} )
    </h4>
    <div class="side-content">
        <p>التاريخ : {{ $order->created_at->format('d-m-Y') }}</p>
        <p class="print-text">المطلوب من السيد   : {{ $order->client->name_ar}}  </p>
        <p class="print-text">هاتف  : {{ $order->client->client_phone->first()?->phone}}


        </p>
    </div>
    <table class="table table-bordered text-center">
        <thead class="thead-dark">
            <tr>
                <th>م</th>
                <th>الماركة</th>
                <th>الصنف</th>
                <th>الموديل</th>
                <th>العدد</th>
                <th colspan="2">سعر الوحدة</th>
                <th colspan="2">الإجمالي</th>
            </tr>
            <tr>
                <th colspan="5"></th>
                <th>فلس</th>
                <th>دينار</th>
                <th>فلس</th>
                <th>دينار</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->order_item as $one)
            <tr>
                <td> {{ $loop->iteration }}</td>
                <td>{{ $one->product_order_items->mark->name_ar }} </td>
                <td>{{ $one->product_order_items->class->name_ar }}</td>
                <td>{{ $one->product_order_items->model }}</td>
                <td>{{ $one->counter }}</td>
                <td>{{ explode('.',number_format(($one->price) , 3))[1] ?? 000}}</td>
                <td>{{ explode('.',number_format(($one->price) , 3))[0] }}</td>
                <td>{{ explode('.',number_format(($one->price) , 3))[1] ?? 000}}</td>
                <td>{{ explode('.',number_format(($one->price) , 3))[0] }}</td>
            </tr>
           @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="7">إجمالي المبيعات</th>
                <th>{{  explode('.',number_format(($totalCount) , 3))[1] }}</th>
                <th>{{ explode('.',number_format(($totalCount) , 3))[0] }}</th>
            </tr>
            <tr>
                <th colspan="7">خصم</th>
                <th>{{  explode('.',number_format(($totalCount - $qabilaCount) , 3))[1] }}</th>
                <th>{{ explode('.',number_format(($totalCount - $qabilaCount) , 3))[0] }}</th>
            </tr>
            <tr>
                
                <th colspan="7">إجمالي المبلغ </th>
                <th>{{explode('.',number_format( $totalCount - ($totalCount - $qabilaCount ) , 3))[1]}}</th>
                <th> {{explode('.',number_format( $totalCount - ($totalCount - $qabilaCount ) , 3))[0]}} </th>
                
            </tr>
        </tfoot>
    </table>
    <div class="side-content">
        <p>العنوان :-</p>
        <div class="d-flex justify-content-between">
            <p class="print-text">المنطقة : {{ $order->client->area?->first()->name_ar }}</p>
            <p class="print-text">قطعة : {{ $order->client->client_address?->first()->block }}</p>
            <p class="print-text"> شارع : {{ $order->client->client_address?->first()->street }}</p>
            <br><br><p class="print-text"> مبنى : {{ $order->client->client_address?->first()->building }}</p>
        </div>


    </div>
    <div class="d-flex justify-content-end">

        <div>
            <h5 class="print-text">المحاسب</h5>
            <h5>..................................</h5>
        </div>
    </div>
</div>