

@php
    $empp_id =$item->emp_id;
    $statuses = [
        'open_file',
        'Execute_alert',
        'image',
        'case_proof',
        'stop_travel',
        'Certificate',
        'stop_salary',
        'stop_car',
        'stop_bank',
        'eqrar_dain_received',
    ];
    $status = null;
    foreach ($statuses as $check) {
        if (\Illuminate\Support\Str::contains(url()->full(), $check)) {
            $status = $check;
            break;
        }
    }
    // dd($item);
    if($status == "eqrar_dain_received") 
    {
        // $m = App\Models\Military_affairs\Military_affair::find($item->m_a_id);
        // if($m)
        // {
        //     $empp_id = $item->emp_id;
        // }
        $military_id = $item->m_a_id;
    }
    else {
        // $empp_id = $item->emp_id;
        $military_id = $item->id;   
    }
@endphp



<form method="POST" action="{{ route('update-responsible') }}" class="update-form">
    @csrf
    @if ($empp_id != 0 || $empp_id != null)

        <select class="form-select" name="user_id" id="responsibleSelect">
            @foreach ($get_responsible as $res)
                <option value="{{ $res->id }}" {{ $empp_id == $res->id ? 'selected' : '' }}
                    data-military-id="{{ $item->id }}" data-user-id="{{ $res->id }}" data-status="open_file">
                    {{ $res->name_ar }}</option>
            @endforeach
        </select>
    @else
        <p>يرجى تحديد مسئول</p>

        <select class="form-select" name="user_id" id="responsibleSelect">
            <option selected>اختر</option>
            @foreach ($get_responsible as $res)
                <option value="{{ $res->id }}">{{ $res->name_ar }}</option>
            @endforeach
        </select>
    @endif
    <input type="hidden" name="military_id" value="{{ $military_id }}">
    <input type="hidden" name="status" value="{{ $status }}">
    <button type="submit" class="d-none submit-button"></button>
</form>
@include('military_affairs.Open_file.partial.responsible')




