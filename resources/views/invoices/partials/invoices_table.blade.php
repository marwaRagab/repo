<table id="demo-foo-pagination" class="table m-b-0 toggle-arrow-tiny" data-page-size="10"
    data-limit-navigation="5" data-previous-text="السابق" data-last-text="الاخير"
    data-first-text="الاول" data-next-text="التالى">
    <thead>
        <tr>
            <th>م</th>
            <th>اسم العميل</th>
            <th>الرصيد</th>
            <th>دائن</th>
            <th>مدين</th>
            <th>التفاصيل</th>
            <th>التاريخ</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($invoices as $index => $invoice)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td style="{{ $invoice->client_name == 'تصدير' ? 'color:red;' : '' }}">
                    {{ $invoice->client_name }}
                </td>
                <td>
                    @switch(request('type'))
                        @case('cash')
                            {{ $invoice->balance_cash }}
                        @break
                        @case('knet')
                            {{ $invoice->balance_knet }}
                        @break
                        @default
                            {{ $invoice->balance }}
                    @endswitch
                </td>
                <td>{{ $invoice->debtor == 1 ? $invoice->amount : '-' }}</td>
                <td>{{ $invoice->creditor == 1 ? $invoice->amount : '-' }}</td>
                <td>
                    {{ $invoice->description }}<br>
                    طريقة الدفع:
                    {{ $invoice->payment_type == 'cash' ? 'كاش' : 'كي نت' }}<br>
                    {{ $invoice->payment_type == 'knet' ? $invoice->knet_code : '' }}
                </td>
                <td>{{ date('Y/m/d', $invoice->date) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
<ul class="pagination pagination-lg m-b-0"></ul>
