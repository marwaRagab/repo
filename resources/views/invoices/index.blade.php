<style>
    .nav-tabs .nav-item {
        border-radius: 10px;
        margin-right: 5px;
    }

    .nav-tabs .nav-link {
        border: 1px solid #ddd;
        border-radius: 10px;
    }
</style>

<div class="card mt-4 py-3">
    <div class="col-md-12 col-sm-12">
        <a id="export_all_btn" onclick="return confirm('هل أنت متأكد ؟');" href="{{ route('invoices_cashier.export') }}"
    class="btn btn-danger btn-rounded mb-3 card-subtitle" style="float: left;" target="_blank">
    تصدير كامل
</a>
    </div>


    <div class="row">
        <div id="available_card" class="col-md-4 col-sm-4">
            <div class="card mt-4 py-3">
                <div class="r-icon-stats">
                    <i class="ti-money bg-success"></i>
                    <div class="bodystate">
                        <h4>{{ isset($central_bank) ? number_format($central_bank->cash + $central_bank->knet, 3, '.', ',') : 0 }}
                        </h4>
                        <span class="text-muted">المتوفر</span>
                    </div>
                </div>
            </div>
        </div>
        <div id="cash_card" class="col-md-4 col-sm-4">
            <div class="card mt-4 py-3">
                <div class="r-icon-stats">
                    <i class="ti-stats-up bg-success"></i>
                    <div class="bodystate">
                        <h4>{{ isset($central_bank) ? number_format($central_bank->cash, 3, '.', ',') : 0 }}</h4>
                        <span class="text-muted">الكاش</span>
                    </div>
                </div>
            </div>
        </div>
        <div id="knet_card" class="col-md-4 col-sm-4">
            <div class="card mt-4 py-3">
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
</div>


<div class="card">
    <div class="card-body">
        <h4 class="card-title">{{ $title }}</h4>
        <button id="advanced_search_btn" style="float: left;" onclick="do_action();"
            class="btn btn-success btn-rounded mb-3 card-subtitle">بحث
            متقدم</button>

        <br /> <br />
        <div class="row justify-content-center" id="div_search" style="display: none;">
            <form method="GET" action="{{ route('invoices_cashier.index') }}">
                @csrf
                <div class="row">
                    <div class="col-md-3">
                        <label for="start_date">تاريخ البداية</label>
                        <input type="date" id="start_date" name="start_date" class="form-control"
                            value="{{ request('start_date', $start_date) }}">
                    </div>
                    <div class="col-md-3">
                        <label for="end_date">تاريخ النهاية</label>
                        <input type="date" id="end_date" name="end_date" class="form-control"
                            value="{{ request('end_date', $end_date) }}">
                    </div>
                    <div class="col-md-3">
                        <label for="type">نوع الدفع</label>
                        <select name="type" class="form-control">
                            <option value="all" {{ request('type', $payment_type) == 'all' ? 'selected' : '' }}>الكل</option>
                            <option value="cash" {{ request('type', $payment_type) == 'cash' ? 'selected' : '' }}>الكاش</option>
                            <option value="knet" {{ request('type', $payment_type) == 'knet' ? 'selected' : '' }}>الكي نت</option>
                        </select>
                    </div>
                    <div class="col-md-3 text-center">
                        <button type="submit" class="btn btn-secondary" style="margin-top: 30px;">بحث</button>
                    </div>
                </div>
            </form>
        </div>
        <br /> <br />
        <!-- Nav tabs -->
        <ul class="nav nav-tabs nav-fill">
            <li class="nav-item">
                <a class="nav-link {{ request('type') == 'all' || !request('type') ? 'active' : '' }}"
                    href="{{ route('invoices_cashier.index', ['type' => 'all', 'start_date' => request('start_date'), 'end_date' => request('end_date')]) }}">الكل</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('type') == 'cash' ? 'active' : '' }}"
                    href="{{ route('invoices_cashier.index', ['type' => 'cash', 'start_date' => request('start_date'), 'end_date' => request('end_date')]) }}">الكاش</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('type') == 'knet' ? 'active' : '' }}"
                    href="{{ route('invoices_cashier.index', ['type' => 'knet', 'start_date' => request('start_date'), 'end_date' => request('end_date')]) }}">الكي نت</a>
            </li>
        </ul>
        <br /><br />
        <!-- Tab panes -->
        <!-- Tab panes -->
        <div class="tab-content border mt-5">
            <div class="tab-pane p-3 active show" id="tab1" role="tabpanel">
                <div class="row">

                    <div class="col-md-12">
                        <div class="table-responsive">
                            @include('invoices.partials.invoices_table')
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane p-3" id="tab2" role="tabpanel">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            @include('invoices.partials.invoices_table')
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane p-3" id="tab3" role="tabpanel">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            @include('invoices.partials.invoices_table')
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
</div>

<script>
    function do_action() {

        document.getElementById('div_search').style.display = 'block';


        document.getElementById('advanced_search_btn').style.display = 'none';
        document.querySelector('.card.mt-4.py-3').style.display = 'none';
        document.querySelectorAll('.card.mt-4.py-3').forEach(card => {
            card.style.display = 'none';
        });
    }
</script>
<script>
    function reset_action() {
        document.getElementById('div_search').style.display = 'none';

        document.getElementById('advanced_search_btn').style.display = 'block';
        document.querySelector('.card.mt-4.py-3').style.display = 'block';
        document.querySelectorAll('.card.mt-4.py-3').forEach(card => {
            card.style.display = 'block';
        });
    }

    window.onload = function() {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('start_date') || urlParams.has('end_date') ) {
            do_action();
        } else {
            reset_action();
        }
    };
</script>
