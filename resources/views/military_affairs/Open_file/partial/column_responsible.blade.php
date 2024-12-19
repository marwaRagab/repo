<form method="POST" action="{{ route('update-responsible') }}" class="update-form">
    @csrf
    @if ($item->emp_id != 0 || $item->emp_id != null)
        <select class="form-select" name="user_id" id="responsibleSelect">
            @foreach ($get_responsible as $res)
                <option value="{{ $res->id }}" {{ $item->emp_id == $res->id ? 'selected' : '' }}
                    data-military-id="{{ $item->installment_id }}" data-user-id="{{ $res->id }}"
                    data-status="open_file">{{ $res->name_ar }}</option>
            @endforeach
        </select>
    @else
        <p>يرجى تحديد مسئول</p>

        <select class="form-select" name="user_id" id="responsibleSelect">
            <option selected>اختر</option>
            @foreach ($get_responsible as $res)
                <option value="{{ $res->id }}" data-military-id="{{ $item->id }}"
                    data-user-id="{{ $res->id }}" data-status="open_file">{{ $res->name_ar }}</option>
            @endforeach
        </select>
    @endif
    <input type="hidden" name="military_id" value="{{ $item->id }}">
    <input type="hidden" name="status" value="open_file">
    <button type="submit" class="d-none submit-button"></button>
</form>
    @include('military_affairs.Open_file.partial.responsible')