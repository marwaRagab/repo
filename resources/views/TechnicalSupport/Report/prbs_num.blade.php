<style>
    .filter-summary {
        display: none;
    }

    @media print {
        form {
            display: none;
        }

        button,
        .btn {
            display: none;
        }

        .filter-summary {
            display: block;
        }
    }

    <style>.narrow-column {
        width: 30%;
    }

    .table {
        font-size: 0.8rem;
        width: 100%;
        /* Decreased width */
        margin: 0 auto;
        /* Center the table */
    }

    .table thead th {
        text-align: center;
    }

    .table tfoot {
        font-weight: bold;
        background-color: #f9f9f9;
    }
</style>
</style>
<div class="card">
    <div class="card-header text-white">
        <h5 class="card-title">تقرير المشكلات</h5>
    </div>
    <div class="card-body">
        <!-- Filters -->
        <div class="mb-4">
            <form method="GET" action="{{ route('technical_support.reports.prbs_num') }}">
                <div class="row">
                    <div class="col-md-3">
                        <label for="start_date">تاريخ البداية</label>
                        <input type="date" id="start_date" name="start_date" class="form-control"
                            value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="end_date">تاريخ النهاية</label>
                        <input type="date" id="end_date" name="end_date" class="form-control"
                            value="{{ request('end_date') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="priority">الأولوية</label>
                        <select id="priority" name="priority" class="form-control">
                            <option value="">اختر الأولوية</option>
                            @foreach ($priorities as $priorityKey => $priorityValue)
                                <option value="{{ $priorityKey }}"
                                    {{ request('priority') == $priorityKey ? 'selected' : '' }}>
                                    {{ $priorityValue }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-success mt-10">بحث</button>
                        <button type="button" id="resetButton" class="btn btn-danger mt-10">إلغاء</button>
                    </div>
                </div>


            </form>
        </div>

        <script>
            document.getElementById('resetButton').addEventListener('click', function() {
                window.location.href = "{{ route('technical_support.reports.prbs_num') }}";
            });
        </script>
        <br />
        <!-- Filter Summary -->
        <div class="filter-summary">
            <h6< /h6>
                <ul>
                    <li><strong>تاريخ البداية:</strong> {{ request('start_date') ?? 'غير محدد' }}</li>
                    <li><strong>تاريخ النهاية:</strong> {{ request('end_date') ?? 'غير محدد' }}</li>
                    <li><strong>الأولوية:</strong> {{ $priorities[request('priority')] ?? 'جميع الأولويات' }}</li>
                </ul>
        </div>

        <!-- Print Button -->


        <div class="row justify-content-center">
            <!-- Open Issues -->
            <div class="col-md-10">
                <table class="table table-bordered table-striped">
                    <thead class="bg-light">
                        <tr>
                            <th style="background-color: #f2f2f2;"colspan="2" class="text-center">
                                <h6>المشكلات المفتوحة</h6>
                            </th>
                        </tr>
                        <tr>
                            <th class="narrow-column ">الحالة</th>
                            <th class="text-center">العدد</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($statuses as $statusId => $statusName)
                            @if (in_array($statusId, [1, 2, 3, 4, 5]))
                                <tr>
                                    <td>{{ $statusName }}</td>
                                    <td class="text-center">{{ $problemsByStatus[$statusId] ?? 0 }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>


                    <thead class="bg-light">
                        <tr>
                            <th style="background-color: #f2f2f2;"colspan="2" class="text-center">
                                <h6>المشكلات المغلقة</h6>
                            </th>
                        </tr>
                        <tr>
                            <th class="narrow-column ">الحالة</th>
                            <th class="text-center">العدد</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($statuses as $statusId => $statusName)
                            @if (in_array($statusId, [6, 7]))
                                <tr>
                                    <td>{{ $statusName }}</td>
                                    <td class="text-center">{{ $problemsByStatus[$statusId] ?? 0 }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td><strong>الإجمالي</strong></td>
                            <td class="text-center"><strong>{{ $totalOpen }}</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
