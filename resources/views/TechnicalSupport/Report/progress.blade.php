<div class="card">
    <div class="card-header text-white">
    </div>
    <div class="card-body">
        <!-- Filters -->
        <div class="mb-4">
            <form method="GET" action="{{ route('technical_support.reports.progress') }}">
                <div class="row">
                    <div class="col-md-4">
                        <label for="start_date">تاريخ البداية</label>
                        <input type="date" id="start_date" name="start_date" class="form-control"
                            value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-4">
                        <label for="end_date">تاريخ النهاية</label>
                        <input type="date" id="end_date" name="end_date" class="form-control"
                            value="{{ request('end_date') }}">
                    </div>
                    <div class="col-md-3" style="display: none">
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
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-success mt-10">بحث</button>
                        <button type="button" id="resetButton" class="btn btn-danger mt-10">إلغاء</button>
                    </div>
                </div>
            </form>
        </div>

        <script>
            document.getElementById('resetButton').addEventListener('click', function() {
                window.location.href = "{{ route('technical_support.reports.progress') }}";
            });
        </script>

        <!-- User Performance Table -->
        <div class="row justify-content-center">
            <div class="col-md-10">
                <table class="table table-bordered table-striped">
                    <thead class="bg-light">
                        <tr style="background-color: #f2f2f2;">
                            <th class="narrow-column">م</th>
                            <th class="text-center">اسم العضو</th>
                            <th class="text-center">المشكلات المنجزة</th>
                            <th class="text-center">متوسط زمن الحل (دقائق)</th>
                            <th class="text-center">عدد المشكلات العالقة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($userPerformance as $developerId => $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="text-center">
                                    <a href="{{ route('supportProblem.index', ['user_id' => $developerId]) }}">
                                        {{ $data['name_ar'] }}
                                    </a>
                                </td>
                                <td class="text-center">{{ $data['completed_count'] }}</td>
                                <td class="text-center">
                                    @php
                                        $days = floor($data['avg_resolution_time'] / 1440);
                                        $hours = floor(($data['avg_resolution_time'] % 1440) / 60);
                                        $minutes = $data['avg_resolution_time'] % 60;
                                    @endphp
                                    {{ $days }} أيام {{ $hours }} ساعات {{ $minutes }} دقائق
                                </td>
                                <td class="text-center">{{ $data['pending_count'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">لا توجد بيانات لعرضها</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .table {
        font-size: 0.9rem;
    }

    .table thead th {
        text-align: center;
    }
</style>
