<!DOCTYPE html>
<html dir="rtl" lang="ar" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="horizontal">

<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Favicon icon-->
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/logo.jpg') }}" />

    <!-- Core Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}" />

    <title>Electron</title>
    <link rel="stylesheet" href="{{ asset('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    <style>
        @media print {
            .page-break {
                page-break-after: always;
            }
        }
    </style>
</head>
<style>
    @media print {
        body {
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            table-layout: fixed; /* Ensures columns resize to fit the table */
            border-collapse: collapse;
        }

        th, td {
            word-wrap: break-word; /* Prevent content from overflowing */
            padding: 5px;
        }

        .container {
            overflow: visible; /* Ensure all content is visible */
        }
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const calculatePrintScale = () => {
            // Default scale value
            let scale = 1;

            // Adjust the scale based on content width
            const contentWidth = document.body.scrollWidth;
            const pageWidth = 794; // A4 page width in pixels (for 96 dpi)

            // Calculate the scale percentage
            scale = pageWidth / contentWidth;

            // Ensure the scale is reasonable (e.g., not too small or too large)
            scale = Math.min(1.2, Math.max(0.8, scale));

            // Apply the scale to the document
            document.documentElement.style.setProperty("--print-scale", scale);
        };

        // Calculate and set scale when the document is ready
        calculatePrintScale();

        // Optional: Recalculate scale on window resize
        window.addEventListener("resize", calculatePrintScale);
    });
</script>
<body>
    @for ($i = 0; $i < 3; $i++)
        @php
            $title1 = match($i) {
                0 => 'نسخة ملف العميل (1)',
                1 => 'نسخة ملف العميل الاحتياطى (2)',
                2 => 'نسخة احتياطية ارشيف الشركة (3)',
            };
        @endphp
        <div class="container my-5">
            <div class="col-12 d-md-flex d-sm-block justify-content-between border-bottom py-3">
                <div>
                    <h6>رقم العملية: <span>{{ $serial ?? request()->query('serial') }}</span></h6>
                    <h6>وقت الطباعة: <span>{{ date('H:i:s') }}</span></h6>
                </div>
                <div class="text-end">
                    <h6>شركة الكترون</h6>
                    <h6>تاريخ: <span>{{ date('d-m-Y') }}</span></h6>
                    <h6>اسم المستخدم: <span>{{ $user_name ?? request()->query('user_name') }}</span></h6>
                </div>
            </div>
            <div class="row">
                <div class="col-12 text-center py-3">
                    <h5>سند قبض</h5>
                </div>
                <div class="col-12 d-md-flex d-sm-block justify-content-between">
                    <h6>التاريخ: <span>{{ $invoice['date'] }}</span></h6>
                    <h6>رقم السند
                        <span>{{ $installment_month['id'] ?? (request()->query('installment_month')['id'] ?? (request()->query('installment_month')->id ?? null)) }}</span>
                    </h6>
                </div>
                <div class="col-12 d-md-flex d-sm-block justify-content-between">
                    <h6>اسم العميل: <span>{{ $client['name'] }}</span></h6>
                    <h6>المبلغ: <span>{{ $invoice['amount'] }}
                            ({{ is_array($first_sum) ? implode(', ', $first_sum) : $first_sum }} دينار @if (!empty($secound_sum) && strlen($secound_sum) > 3)
                                و {{ $secound_sum }} فلس
                            @endif)</span></h6>
                </div>
                <div class="col-12 d-md-flex d-sm-block justify-content-between">
                    <h6>معاملة رقم: <span>{{ $invoice['installment_id'] }}</span></h6>
                    <h6>طريقة الدفع: <span>
                            @switch($invoice['payment_type'])
                                @case('cash')
                                    كاش
                                @break

                                @case('knet')
                                    كي نت
                                @break

                                @case('cash/knet')
                                    كاش / كي نت
                                @break

                                @case('part')
                                    دفع رابط
                                @break

                                @default
                            @endswitch
                        </span></h6>
                </div>
                <div class="col-12 d-md-flex d-sm-block justify-content-between border-bottom">
                    <h6>عدد الشهور المتأخرة: <span>{{ $item['not_done_count_lated'] }}</span></h6>
                    <h6>قسط شهري: <span>
                            @if (isset($installment_month['installment_type']) && $installment_month['installment_type'] == 'first_amount')
                                المقدم
                            @else
                                {{ $invoice['date'] ?? 'لا يوجد تاريخ' }}
                            @endif
                        </span></h6>
                </div>
                <div class="col-12 text-center py-3">
                    <h5>اخر عمليات بكشف الحساب</h5>
                </div>
                <div class="col-12 py-2 mx-5">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>م</th>
                                <th>الرصيد</th>
                                <th>مدين</th>
                                <th>دائن</th>
                                <th>البيان طريق الدفع</th>
                                <th>التاريخ</th>
                                <th>رقم العملية السند</th>
                                <th>اليوزر</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $x = 1;
                                $n = 1;
                            @endphp
                            @if ($n <= 8)
                                <tr>
                                    @php
                                        $the_balance =
                                            $item['installment_clients'] > 0
                                                ? $item['total_madionia']
                                                : $total_madionia - ($laws_item_amount ?? 0) + ($first_amount ?? 0);
                                    @endphp
                                    <td>{{ $x++ }}</td>
                                    <td>{{ number_format($the_balance, 3, '.', ',') }}</td>
                                    <td></td>
                                    <td>{{ number_format($the_balance, 3, '.', ',') }}</td>
                                    <td></td>
                                    <td>{{ $item['date'] }}</td>
                                    <td></td>
                                    <td>{{ getUserName($user_name) }}</td>
                                </tr>
                                @php $n++; @endphp
                            @endif

                            @if (isset($item['months']) && $item['months'] == 24 && isset($laws_item_amount) && $laws_item_amount > 0)
                                @php
                                    $the_balance =
                                        $item['installment_clients'] > 0 ? $item['eqrardain_amount'] : $total_madionia;
                                @endphp
                                @if ($n <= 8)
                                    <tr>
                                        <td>{{ $x++ }}</td>
                                        <td>{{ number_format($laws_item_amount, 3, '.', ',') }}</td>
                                        <td>{{ number_format($the_balance, 3, '.', ',') }}</td>
                                        <td>{{ $item['date'] }}</td>
                                        <td>أتعاب المحامى</td>
                                        <td></td>
                                        <td></td>
                                        <td>{{ getUserName(get_admin_user_name($item['user_id'])) }}</td>
                                    </tr>
                                    @php $n++; @endphp
                                @endif
                            @endif

                            @php $total_madionia = $the_balance; @endphp
                            @foreach ($items_done as $item)
                                @if ($item['status'] == 'done' && $n <= 8)
                                    <tr>
                                        <td>{{ $x++ }}</td>
                                        <td>{{ number_format($total_madionia -= $item['amout'], 3, '.', ',') }}</td>
                                        <td>{{ $item['amout'] }}</td>
                                        <td>-</td>
                                        <td>
                                            قسط شهرى
                                            @switch($item['payment_type'])
                                                @case('cash')
                                                    <span class="label label-success font-weight-100">دفع كاش</span>
                                                @break

                                                @case('part')
                                                    دفع رابط
                                                @break
                                            @endswitch
                                            @if ($item['installment_type'] == 'discount')
                                                <span class="label label-warning font-weight-100">خصم</span>
                                            @endif
                                        </td>
                                        <td>{{ $item['payment_date'] }}</td>
                                        <td>{{ $item['knet'] ?? '' }} <br> {{ $item['id'] }}</td>
                                        <td>{{ getUserName($user_name) }}</td>
                                    </tr>
                                    @php $n++; @endphp
                                @endif
                            @endforeach

                            @php $total_checkat = 0; @endphp
                            @if (!empty($military_affairs_checks))
                                @foreach ($military_affairs_checks as $military_affairs_check)
                                    @php $total_checkat += $military_affairs_check["amount"]; @endphp
                                    @if ($n <= 8)
                                        <tr>
                                            <td>{{ $x++ }}</td>
                                            <td>{{ number_format($total_madionia -= $military_affairs_check['amount'], 3, '.', ',') }}
                                            </td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>شيك</td>
                                            <td>{{ date('Y-m-d', strtotime($military_affairs_check['date'])) }}</td>
                                            <td>{{ $military_affairs_check['amount'] }}</td>
                                            <td>{{ getUserName(get_admin_user_name($military_affairs_check['deposit_user_id'])) }}
                                            </td>
                                        </tr>
                                        @php $n++; @endphp
                                    @endif
                                @endforeach
                            @endif

                            @php $total_amounts = 0; @endphp
                            @if (!empty($military_affairs_amounts) && is_iterable($military_affairs_amounts))
                                @foreach ($military_affairs_amounts as $military_affairs_amount)
                                    @php $total_amounts += $military_affairs_amount["amount"] ?? 0; @endphp
                                    @php $total_diff = $total_amounts - $total_checkat; @endphp
                                    @if (
                                        $military_affairs_amount['check_type'] != 'update' &&
                                            $military_affairs_amount['military_affairs_check_id'] != -1 &&
                                            $total_diff > 0 &&
                                            $n <= 8)
                                        <tr class="service">
                                            <td class="tableitem">{{ $x++ }}</td>
                                            <td class="tableitem">
                                                {{ number_format($total_madionia -= $military_affairs_amount['amount'], 3, '.', ',') }}
                                            </td>
                                            <td class="tableitem">{{ $military_affairs_amount['amount'] }}</td>
                                            <td class="tableitem">-</td>
                                            <td></td>
                                            <td class="tableitem">{{ $military_affairs_amount['date'] }}</td>
                                            <td class="tableitem">
                                                <span class="label label-danger font-weight-100">
                                                    @switch($military_affairs_amount['check_type'])
                                                        @case('salary')
                                                            حجز راتب
                                                        @break

                                                        @case('banks')
                                                            حجز بنوك
                                                        @break

                                                        @case('cars')
                                                            حجز سيارة
                                                        @break

                                                        @case('mahkama_installment')
                                                            تقسيط محكمة
                                                        @break

                                                        @case('mahkama_madionia_sadad')
                                                            سداد مديونية محكمة
                                                        @break

                                                        @default
                                                            رصيد تنفيذ
                                                    @endswitch
                                                </span>
                                            </td>
                                            <td class="tableitem">
                                                {{ getUserName(get_admin_user_name($military_affairs_amount['user_id'])) }}
                                            </td>
                                        </tr>
                                        @php $n++; @endphp
                                    @endif
                                @endforeach

                                @if (!empty($installment_discount))
                                    @foreach ($installment_discount as $item_2)
                                        @if ($n <= 8)
                                            <tr>
                                                <td>{{ $x++ }}</td>
                                                <td>{{ number_format($total_madionia -= $item_2['amount'], 3, '.', ',') }}
                                                </td>
                                                <td>-</td>
                                                <td>{{ $item_2['amount'] }}</td>
                                                <td>{{ $item_2['date'] }}</td>
                                                <td>
                                                    @switch($item_2['type'])
                                                        @case('income')
                                                            <span class="label label-success font-weight-100">دفع</span>
                                                        @break

                                                        @case('expenses_pending')
                                                            <span class="label label-warning font-weight-100">خصم</span>
                                                        @break

                                                        @case('knet')
                                                            دفع رابط
                                                        @break
                                                    @endswitch
                                                </td>
                                                <td>{{ getUserName(get_admin_user_name($item_2['user_id'])) }}</td>
                                            </tr>
                                            @php $n++; @endphp
                                        @endif
                                    @endforeach
                                @endif
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="page-break"></div>
    @endfor

    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <!-- Import Js Files -->
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/dist/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/theme/app.horizontal.init.js') }}"></script>
    <script src="{{ asset('assets/js/theme/theme.js') }}"></script>
    <script src="{{ asset('assets/js/theme/app.min.js') }}"></script>
    <script src="{{ asset('assets/js/theme/sidebarmenu.js') }}"></script>
    <script src="{{ asset('assets/js/theme/feather.min.js') }}"></script>
    <!-- solar icons -->
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
    <script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable.init.js') }}"></script>
</body>

</html>
