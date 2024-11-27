<div class="card mt-4 py-3">
    @php
    use Illuminate\Support\Facades\Request;
    if(Request::has('governorate_id')){
    $gov=Request::get('governorate_id');
    }else{
    $gov='';
    }
    if(Request::has('stop_bank_type')){
    $bank_type=Request::get('stop_bank_type');
    }else{
    $bank_type='';
    }
    if(Request::has('ministry_id')){
    $ministry=Request::get('ministry_id');
    }else{
    $ministry='';
    }
    @endphp
    <div class="d-flex flex-wrap ">
        <a href="{{route('stop_bank')}}" class="btn-filter bg-warning-subtle text-warning px-4 fs-4 mx-1 mb-2">
            العدد الكلي ({{count($items)}})
        </a>

        @foreach($courts as $court)

        <a href="{{route('stop_bank',array('governorate_id' => $court->id))}}"
           class="btn-filter {{$court->style}}   px-4 fs-4 mx-1 mb-2"> {{$court->name_ar}}
        </a>

        @endforeach
    </div>
</div>
<div class="card mt-4 py-3">
