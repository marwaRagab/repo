@php
    $qrareldin = DB::table('installment')->where('id', $item->installment->id)->first();
    $client_img = DB::table('client_imgs')->where('client_id', $qrareldin->client_id)->where('type','cid_img1')->first();
    $pdf_img =\App\Models\Military_affairs\Military_affair::where('id', $item->id)->first();
@endphp

<style>
    a {
        cursor: pointer;
    }
</style>
<div class="dropdown mb-6 me-6">
    <!-- Dropdown button -->
    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
            aria-expanded="false">
        طباعة
    </button>
    <!-- Dropdown links -->
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        @if (Str::contains(request()->url(), 'open_file'))
            @foreach (get_fixed_prin_data() as $data)
                <li><a class="dropdown-item"
                       href="{{ route('print_issue', ['item' => $item->id , 'data_id' => $data->id]) }}"
                       target="_blank">بيانات ({{   explode(' ', $data->name_ar)[0] }})</a></li>
            @endforeach
        @endif
        <li><a class="dropdown-item" href="{{ route('print_case_proof',['item' => $item->id]) }}" target="_blank">اثبات
                حالة</a></li>
        <li><a class="dropdown-item" href="{{ route('print_sticker' ,['item' => $item->id]) }}" target="_blank">ستيكر
                ملف التنفيذ</a></li>
        <li>
            <a class="dropdown-item {{ $qrareldin->qard_paper_img == null || $qrareldin->qard_paper_img == '' || $qrareldin->qard_paper_img == 0   ? 'disabled' : '' }}"
               {{-- href="{{ $qrareldin ? asset($qrareldin->qard_paper_img) : '#' }}" --}}
               onclick="checkFileAndRedirect(
                    '{{ $qrareldin && $qrareldin->qard_paper_img && $qrareldin->qard_paper_img !== '0' ? 'https://electron-kw.net/' . $qrareldin->qard_paper_img: '#' }}',
                    '{{ $qrareldin && $qrareldin->qard_paper_img && $qrareldin->qard_paper_img !== '0' ? 'https://electron-kw.com/' . $qrareldin->qard_paper_img : '#' }}'
                ); return false;"
               target="_blank">
                اقرار الدين
            </a>
        </li>
        <li>
            <a class="dropdown-item {{ !$client_img || !$client_img->path || $client_img->path == null || $client_img->path == 0 ? 'disabled' : '' }}  "
               href="{{ route('print_civil_id' ,['item' => $item->id]) }}" target="_blank">
                الصورة المدنية</a></li>
        </li>
        @if (Str::contains(request()->url(), 'stop_bank') || Str::contains(request()->url(), 'stop_car'))
            <li>
                <a class="dropdown-item {{ $pdf_img->execute_do_img == null || $pdf_img->execute_do_img == '' || $pdf_img->execute_do_img == 0   ? 'disabled' : '' }}"
                   {{-- href="{{ $qrareldin ? asset($qrareldin->qard_paper_img) : '#' }}" --}}
                   onclick="checkFileAndRedirect(
                    '{{ $pdf_img && $pdf_img->execute_do_img  && $pdf_img->execute_do_img !== '0' ? 'https://electron-kw.net/' . $pdf_img->execute_do_img: '#' }}',
                    '{{ $pdf_img && $pdf_img->execute_do_img && $pdf_img->execute_do_img!== '0' ? 'https://electron-kw.com/' . $pdf_img->execute_do_img: '#' }}'
                ); return false;"
                   target="_blank">
                    صورة الpdf
                </a>
            </li>

        @endif
    </ul>
</div>

@include('military_affairs.Execute_alert.print.script')
