<div class="container-fluid print py-5">
    <h4 class="text-center py-3">فاتورة   
        رقم ( {{ $order_id }} )
    </h4>
    <div class="side-content">
        <p>التاريخ : {{ $order->created_at->format('d-m-Y') }}</p>
        <p class="print-text">المطلوب من السيد   : {{ $order->client->name_ar}}  </p>
        <p class="print-text">هاتف  : {{ $order->client->phone ?? ''}}


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
            <tr>
                <td>1</td>
                <td>Orca اوركا</td>
                <td>تلفزيون</td>
                <td>OR-39EX20</td>
                <td>1</td>
                <td>000</td>
                <td>70</td>
                <td>000</td>
                <td>70</td>
            </tr>
            <tr>
                <td>2</td>
                <td>ميديا Midea</td>
                <td>غسالة حوض</td>
                <td>MAC-120FMPS</td>
                <td>1</td>
                <td>000</td>
                <td>85</td>
                <td>000</td>
                <td>85</td>
            </tr>
            <tr>
                <td>3</td>
                <td>فيرري Ferre</td>
                <td>طباخ</td>
                <td>FGC66BW</td>
                <td>1</td>
                <td>900</td>
                <td>62</td>
                <td>900</td>
                <td>62</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="7">إجمالي المبيعات</th>
                <th>900</th>
                <th>217</th>
            </tr>
            <tr>
                <th colspan="7">خصم</th>
                <th>000</th>
                <th>15</th>
            </tr>
            <tr>
                <th colspan="7">إجمالي المبلغ ( مائتان واثنان دينار )</th>
                <th>900</th>
                <th>202</th>
            </tr>
        </tfoot>
    </table>
    <div class="side-content">
        <p>العنوان :-</p>
        <div class="d-flex justify-content-between">
            <p class="print-text">المنطقة : النعيم</p>
            <p class="print-text">قطعة : 2</p>
            <p class="print-text"> شارع : 17
            </p>

        </div>


    </div>
    <div class="d-flex justify-content-end">

        <div>
            <h5 class="print-text">المحاسب</h5>
            <h5>..................................</h5>
        </div>
    </div>
</div>