<div class="card">
    <div class="card-header text-white">
        <h5 class="card-title"> </h5>
    </div>
    <div class="card-body">
        <!-- Filters -->
        <div class="mb-4">
            <form method="GET" action="{{ route('technical_support.reports.timeline') }}">
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
                            <option value=""> الكل</option>
                            @foreach ($priorities as $priorityKey => $priorityValue)
                                <option value="{{ $priorityKey }}"
                                    {{ request('priority') == $priorityKey ? 'selected' : '' }}>
                                    {{ $priorityValue }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mt-4">
                        <button type="submit" class="btn btn-success btn-sm rounded">بحث</button>
                        <button type="button" id="resetButton" class="btn btn-danger btn-sm rounded">إلغاء</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Reset Button Logic -->
        <script>
            document.getElementById('resetButton').addEventListener('click', function() {
                window.location.href = "{{ route('technical_support.reports.timeline') }}";
            });
        </script>

        <!-- Filter Summary -->
        @if (request('start_date') || request('end_date') || request('priority'))
            <div class="filter-summary mb-4">
                <h6>ملخص الفلاتر</h6>
                <ul>
                    <li><strong>تاريخ البداية:</strong> {{ request('start_date') ?? 'غير محدد' }}</li>
                    <li><strong>تاريخ النهاية:</strong> {{ request('end_date') ?? 'غير محدد' }}</li>
                    <li><strong>الأولوية:</strong> {{ $priorities[request('priority')] ?? 'جميع الأولويات' }}</li>
                </ul>
            </div>
        @endif

        <!-- Timeline Table -->
        <div class="row">
            <div class="col-md-10">
                <table class="table table-bordered table-striped">
                    <thead class="bg-light">
                        <tr style="background-color: #f2f2f2;">
                            <th class="narrow-column">م</th>
                            <th class="text-center">رقم التذكرة</th>
                            <th class="text-center">الأولوية</th>

                            <th class="text-center">تاريخ البدايه</th>
                            <th class="text-center">تاريخ النهاية</th>
                            <th class="text-center">زمن الحل (ساعات)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($issues as $index => $issue)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td class="text-center">
                                    <a href="{{ route('supportProblem.show', $issue->ticket_id) }}" target="_blank">
                                        {{ $issue->ticket_id }}
                                    </a>
                                </td>
                                <td class="text-center">
                                    @if ($issue->priority == 'high')
                                        <span class="btn btn-danger btn-sm rounded">عالية</span>
                                    @elseif ($issue->priority == 'medium')
                                        <span class="btn btn-warning btn-sm rounded">متوسطة</span>
                                    @elseif ($issue->priority == 'low')
                                        <span class="btn btn-success btn-sm rounded">منخفضة</span>
                                    @else
                                        <span class="btn btn-secondary btn-sm rounded">غير محددة</span>
                                    @endif
                                </td>
                                <td class="text-center">{{ $issue->start_date }}</td>
                                <td class="text-center">{{ $issue->end_date }}</td>
                                <td class="text-center"> {{ $issue->days }} يوم
                                    {{ $issue->hours }} ساعة
                                    {{ $issue->minutes }} دقيقة</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .filter-summary {
        display: none;
    }

    @media print {

        form,
        button,
        .btn {
            display: none;
        }

        .filter-summary {
            display: block;
        }
    }

    .narrow-column {
        width: 5%;
    }

    .table {
        font-size: 0.9rem;
        width: 100%;

    }

    .table thead th {
        text-align: center;
    }
</style>
