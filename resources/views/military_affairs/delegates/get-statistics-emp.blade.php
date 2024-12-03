<div class="card mt-4 p-4">
    <h5 class="pb-3">البحث</h5>
    <form method="GET" action="{{ route('military_affairs.get_statistics_emp', ['user_id' => $user]) }}">
        <div class="row align-items-end">
            <div class="form-group col-md-5">
                <label for="monthSelect">اختر الشهر</label>
                <input type="month" name="month" id="monthSelect" class="form-control">
            </div>
            <div class="form-group col-md-5">
                <label for="durationSelect">اختر المدة</label>
                <select name="month_range" id="durationSelect" class="form-control">
                    <option value="3">آخر 3 شهور</option>
                    <option value="6">آخر 6 شهور</option>
                    <option value="9">آخر 9 شهور</option>
                </select>
            </div>
            <div class="form-group col-md-2">
                <button type="submit" class="btn btn-primary w-100">بحث</button>
            </div>
        </div>
    </form>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>الاقسام</th>
                    <th>العدد</th>
                    <th>المتوسط</th>
                    <th>الملاحظات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($statistics as $index => $stat)
                    <tr>
                        <td>{{ (int)$index + 1 }}</td>
                        <td>{{ $stat['department'] }}</td>
                        <td>{{ $stat['count'] }}</td>
                        <td>
                            @if ($stat['count'] > 0)
                                {{ $stat['average'] / $stat['count'] }}
                            @else
                                0
                            @endif
                        </td>
                        <td>{{ $stat['note_count_days'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
