<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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

<div class="d-flex flex-wrap">
    @php
        $allAmounts = json_decode(all_invoices_by_date_sql2(''), true);
    @endphp

    <div class="d-flex justify-content-start align-items-center w-100 mt-2 flex-nowrap">
        @foreach ([
            ['id' => 'available_card', 'icon' => 'fas fa-dollar-sign', 'color' => 'bg-success', 'label' => 'المتوفر', 'amount' => $allAmounts['total_balance'] ?? 0],
            ['id' => 'cash_card', 'icon' => 'fas fa-credit-card', 'color' => 'bg-secondary', 'label' => 'الكاش', 'amount' => $allAmounts['cash'] ?? 0],
            ['id' => 'knet_card', 'icon' => 'fas fa-money-check', 'color' => 'bg-danger', 'label' => 'الكي نت', 'amount' => $allAmounts['knet'] ?? 0],
            ['id' => 'onlinepayment_card', 'icon' => 'fas fa-wallet', 'color' => 'bg-warning', 'label' => 'الدفع الاليكتروني', 'amount' => $central_bank->part ?? 0]
        ] as $card)
            <div id="{{ $card['id'] }}" class="col-md-2 col-sm-4 card mt-2 py-2 mx-2">
                <div class="r-icon-stats">
                    <div class="bodystate" style="float: left;">
                        <h6>{{ number_format($card['amount'], 3, '.', ',') }}</h6>
                        <span class="text-muted">{{ $card['label'] }}</span>
                    </div>
                    <i class="{{ $card['icon'] }} {{ $card['color'] }} text-white p-2 rounded-circle"></i>
                </div>
            </div>
        @endforeach
    </div>
</div>

<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0">حسابات الاقساط</h4>
        <div class="d-flex">
            <button id="advanced_search_btn" onclick="do_action();" class="btn btn-success btn-rounded mb-3 card-subtitle">بحث متقدم</button>
&nbsp;&nbsp;
            <button class="btn btn-danger btn-rounded mb-3 card-subtitle" data-bs-toggle="modal" data-bs-target="#export_modal">تصدير</button>

        </div>
    </div>

    <!-- Export Modal -->
    <div id="export_modal" class="modal fade" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <form action="{{ url('get_invoices_papers') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header d-flex align-items-center">
                        <h4 class="modal-title">التصدير</h4>
                    </div>
                    <div class="modal-body">
                        <a class="btn me-1 mb-1 bg-emerald-900-subtle text-primary px-4 fs-4" href="{{ url('export_all') }}">طباعة تصدير الحسابات</a>
                        <div class="form-group mt-3">
                            <label for="formFile" class="form-label">صورة تصدير الحسابات</label>
                            <input class="form-control" name="img_dir" accept="image/*" type="file" id="formFile" />
                            @error('img_dir')
                                <div style="color: red;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">حفظ</button>
                        <button type="button" class="btn bg-danger-subtle text-danger" data-bs-dismiss="modal">إلغاء</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="card-body">
        <!-- Advanced Search -->

        <div class="row justify-content-center" id="div_search" style="display: none;">
            <form method="GET" action="{{ route('invoices_installment') }}">
                @csrf
                <div class="row">
                    <div class="col-md-3">
                        <label for="start_date">تاريخ البداية</label>
                        <input type="date" id="start_date" name="start_date" class="form-control" value="{{ request('start_date', $start_date) }}">
                    </div>
                    <div class="col-md-3">
                        <label for="end_date">تاريخ النهاية</label>
                        <input type="date" id="end_date" name="end_date" class="form-control" value="{{ request('end_date', $end_date) }}">
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

        <!-- Navigation Tabs -->
        <ul class="nav nav-tabs nav-fill mt-4">
            @foreach ([
                'all' => 'الكل',
                'cash' => 'الكاش',
                'knet' => 'الكي نت',
                'part' => 'الدفع الالكتروني'
            ] as $key => $label)
                <li class="nav-item">
                    <a class="nav-link {{ request('payment_type') == $key || (!request('payment_type') && $key == 'all') ? 'active' : '' }}"
                       href="{{ route('invoices_installment', ['payment_type' => $key, 'start_date' => request('start_date'), 'end_date' => request('end_date')]) }}">
                        {{ $label }}
                    </a>
                </li>
            @endforeach
        </ul>

        <!-- Invoices Table -->
        <div class="table-responsive pb-4 mt-4">
            <table id="all-student" class="table table-bordered text-nowrap align-middle">
                <thead>
                <tr>
                    <th>#</th>
                    <th>اسم العميل</th>
                    <th>الرصيد</th>
                    <th>دائن</th>
                    <th>مدين</th>
                    <th>التفاصيل</th>
                    <th>التاريخ</th>
                </tr>
                </thead>
                <tbody>
                @php
                    $totalBalance = $allAmounts['total_balance'] ?? 0;
                @endphp
                @foreach ($items as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->installment ? $item->installment->client->name_ar : 'تصدير' }}</td>
                        <td>{{ $item->type === 'export' ? '0.000' : number_format($totalBalance, 3, '.', ',') }}</td>
                        <td>{{ $item->debtor ? number_format($item->amount, 3, '.', ',') : '-' }}</td>
                        <td>{{ $item->creditor ? number_format($item->amount, 3, '.', ',') : '-' }}</td>
                        <td>
                            <p>{{ $item->description }}</p>
                            <p>طريقة الدفع: {{ $item->pay_method }}</p>
                        </td>
                        <td>{{ $item->date }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function do_action() {
        document.getElementById('div_search').style.display = 'block';
        document.getElementById('advanced_search_btn').style.display = 'none';
    }
</script>
