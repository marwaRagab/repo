
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-12 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                <li class="active">{{ $title }}</li>
            </ol>
            <a onclick="return confirm('هل أنت متأكد ؟');" href="{{ route('invoices_cashier.export') }}"
               class="btn btn-info pull-right m-l-20 btn-rounded btn-info hidden-xs hidden-sm waves-effect waves-light">
              تصدير كامل
            </a>
        </div>
    </div>
    @include('partials.messages')

    <div class="row">
        <div class="col-md-3 col-sm-3">
            <div class="white-box">
                <div class="r-icon-stats">
                    <i class="ti-money bg-success"></i>
                    <div class="bodystate">
                        <h4>{{ isset($central_bank) ? number_format($central_bank->cash + $central_bank->knet, 3, '.', ',') : 0 }}</h4>
                        <span class="text-muted">المتوفر</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-3">
            <div class="white-box">
                <div class="r-icon-stats">
                    <i class="ti-stats-up bg-success"></i>
                    <div class="bodystate">
                        <h4>{{ isset($central_bank) ? number_format($central_bank->cash, 3, '.', ',') : 0 }}</h4>
                        <span class="text-muted">الكاش</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-3">
            <div class="white-box">
                <div class="r-icon-stats">
                    <i class="ti-stats-up bg-success"></i>
                    <div class="bodystate">
                        <h4>{{ isset($central_bank) ? number_format($central_bank->knet, 3, '.', ',') : 0 }}</h4>
                        <span class="text-muted">الكي نت</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row" id="div_search" style="display: none;">
        <form method="post" action="{{ route('invoices_cashier.search') }}">
            @csrf
            <div class="col-sm-12">
                <div class="white-box">
                    <h3 class="box-title m-b-0">البحث</h3>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-3"></div>
                            <div class="col-md-3">
                                <div class="input-daterange input-group" id="date-range">
                                    <input type="date" class="form-control" name="start" placeholder="yyyy/mm/dd" data-date-format="yyyy/mm/dd">
                                    <span class="input-group-addon bg-info b-0 text-white">إلي</span>
                                    <input type="date" class="form-control" name="end" placeholder="yyyy/mm/dd" data-date-format="yyyy/mm/dd">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select name="type" class="form-control select2">
                                        <option value="all">الكل</option>
                                        <option value="cash">الكاش</option>
                                        <option value="knet">الكي نت</option>
                                    </select>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-4"></div>
                            <div class="col-md-4" style="text-align: center; padding-top: 20px;">
                                <button type="submit" name="btn_search" class="btn btn-info">بحث</button>
                            </div>
                            <div class="col-md-4"></div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <a href="{{ route('invoices_cashier.index') }}" class="fcbtn btn btn-default btn-outline btn-1d btn-lg {{ $slug == '' ? 'disabled' : '' }}">
        الكل
    </a>
    <a href="{{ route('invoices_cashier.index', ['cash']) }}" class="fcbtn btn btn-success btn-outline btn-1d btn-lg {{ $slug == 'cash' ? 'disabled' : '' }}">
        الكاش
    </a>
    <a href="{{ route('invoices_cashier.index', ['knet']) }}" class="fcbtn btn btn-warning btn-outline btn-1d btn-lg {{ $slug == 'knet' ? 'disabled' : '' }}">
        الكي نت
    </a>

    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <h4 class="page-title">{{ $title }}
                    <button style="float: left;" onclick="do_action();" class="btn btn-info btn-rounded">بحث متقدم</button>
                </h4>
                <p class="text-muted m-b-30">{{ $title }}</p>
                <div class="table-responsive">
                    <table id="demo-foo-pagination" class="table m-b-0 toggle-arrow-tiny" data-page-size="10" data-limit-navigation="5" data-previous-text="السابق" data-last-text="الاخير" data-first-text="الاول" data-next-text="التالى">
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
                                <td>
                                    <a href="#" data-toggle="tooltip" data-original-title="{{ get_admin_user_name($invoice->user_id) }}">
                                        {{ $index + 1 }}
                                    </a>
                                </td>
                                <td style="{{ $invoice->client_name == 'تصدير' ? 'color:red;' : '' }}">
                                    {{ $invoice->client_name }}
                                </td>
                                <td>
                                    @switch($slug)
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
                                    طريقة الدفع: {{ $invoice->payment_type == 'cash' ? 'كاش' : 'كي نت' }}<br>
                                    {{ $invoice->payment_type == 'knet' ? $invoice->knet_code : '' }}
                                </td>
                                <td>{{ date('Y/m/d', $invoice->date) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <ul class="pagination pagination-lg m-b-0"></ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function do_action() {
    document.getElementById('div_search').style.display = 'block';
}
</script>
