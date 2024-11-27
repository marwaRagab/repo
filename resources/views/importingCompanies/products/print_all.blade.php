<div class="container-fluid print py-5">
    <h3 class="text-center mb-4 ">
        منتجات المعرض
    </h3>
    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>التسلسل</th>
                <th>الماركة</th>
                <th>الموديل</th>
                <th>الصنف</th>
                <th>العدد</th>
                <th>الباركود</th>
                <th>صافي التكلفة</th>
                <th>سعر البيع</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $one)
            <tr>
              
                <td> {{ $loop->iteration }}</td>
                <td> {{ $one->mark->name_ar ?? ''}}</td>
                <td> {{ $one->model }} </td>
                <td> {{ $one->class->name_ar}} </td>
                <td> {{ count($one->productsItems) }}</td>
                <td> {{ $one->number}}</td>
                <td> {{ $one->net_price}}</td>
                <td>{{ $one->price}}</td>
            </tr>
           @endforeach
        </tbody>
    </table>
</div>