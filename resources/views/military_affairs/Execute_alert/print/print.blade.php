@php
    $qrareldin = DB::table('installment')->where('id', $item->installment->id)->first();
    $client_img = DB::table('client_imgs')->where('client_id', $qrareldin->client_id)->where('type','civil_img')->first();
@endphp

<div class="dropdown mb-6 me-6">
    <!-- Dropdown button -->
    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
        طباعة
    </button>
    <!-- Dropdown links -->
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        @if (Str::contains(request()->url(), 'open_file'))
            @foreach (get_fixed_prin_data() as $data)
            <li><a class="dropdown-item" href="{{ route('print_issue', ['item' => $item->id , 'data_id' => $data->id]) }}" target="_blank">بيانات ({{   explode(' ', $data->name_ar)[0] }})</a></li>
            @endforeach 
        @endif
        <li><a class="dropdown-item" href="{{ route('print_case_proof',['item' => $item->id]) }}" target="_blank">اثبات حالة</a></li>
        <li><a class="dropdown-item" href="{{ route('print_sticker' ,['item' => $item->id]) }}" target="_blank">ستيكر ملف التنفيذ</a></li>
        <li>
            <a class="dropdown-item {{ $qrareldin->qard_paper_img == null || $qrareldin->qard_paper_img == ''  ? 'disabled' : '' }}"  
               href="{{ $qrareldin ? asset($qrareldin->qard_paper_img) : '#' }}" 
               target="_blank" >
               اقرار الدين
            </a>
        </li>
        <li>
            <a class="dropdown-item {{ !$client_img || !$client_img->path || $client_img->path == null ? 'disabled' : '' }}" 
                href="{{ $client_img ? asset($client_img->path) : '#' }}" 
                target="_blank">
                 الصورة المدنية
             </a>
        </li>
    </ul>
</div>
