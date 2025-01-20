@php
    use Illuminate\Support\Facades\Request;if(Request::has('check_type')){
        $type=Request::get('check_type');
    }else{
       $type='';
    }

@endphp
<div class="card mt-4 py-3">
    <div class="d-flex flex-wrap ">
        <a href=" {{route('all_checks')}}"
           class="btn-filter bg-warning-subtle text-warning px-4  mx-1 mb-2  {{ request()->get('check_type') == '' ? 'active' : '' }}  ">
            الجديدة </a>
        <a href="{{route('all_checks',array('check_type' =>1))}}"
           class="btn-filter  bg-success-subtle text-success px-4  mx-1 mb-2  {{ request()->get('check_type') == 1 ? 'active' : '' }}">
            تم الايداع </a>

    </div>
</div>
<div class="card">

    <div class="card-body">
        <div class="table-responsive pb-4">
            <table id="all-student" class="table table-bordered border text-nowrap align-middle">
                <thead>
                <!-- start row -->
                <tr>
                    <th>#</th>
                    <th> اسم العميل</th>
                    @if(request()->get('check_type') == '')
                    <th>مبلغ المديونية</th>
                    <th>المحصل</th>
                    <th> المتبقى</th>
                    <th> المبلغ</th>
                    <th> التاريخ</th>
=                    <th> صورة الشيك</th>
                    <th> ايداع الشيك</th>
                    @endif
                    @if(request()->get('check_type') == 1)
                        <th>  مبلغ الشيك</th>
                        <th>  تاريخ الايداع</th>
                        <th> صورة الايداع</th>
                    @endif


                </tr>
                <!-- end row -->
                </thead>
                <tbody>
                <!-- start row -->
                @foreach( $items as $item)
                    @if($item->installment)
                        @if($item->military_check->first())


                            @if(request()->get('check_type') == 1)
                            <tr>
                                <td>
                                    {{ $loop->index + 1 }}

                                </td>
                                <td>
                                    {{$item->installment->client->name_ar}}

                                    ({{$item->installment->id}})
                                    <br>
                                    {{$item->installment->client->civil_number}}
                                </td>

                                <td>{{$item->military_check->first()->amount}}</td>
                                <td>{{expolde_date($item->military_check->first()->deposit_date)[0]}}</td>

                                    <td>


                                        <a target="_blank"
                                           onclick="checkFileAndRedirect(
                            '{{ $item &&  $item->military_check->first() && $item->military_check->first()->deposit_img!== '0' ? 'https://electron-kw.net/' . $item->military_check->first()->deposit_img : '#' }}',
                            '{{ $item && $item->military_check->first() && $item->military_check->first()->deposit_img !== '0' ? 'https://electron-kw.com/' . $item->military_check->first()->deposit_img : '#' }}'
                        ); return false;">

                                                            <span class="btn btn-info"> صورة الايداع
                                                                 </span>
                                        </a>


                                    </td>

                            </tr>
                            @else
                                <tr>
                                    <td>
                                        {{ $loop->index + 1 }}

                                    </td>
                                    <td>
                                        {{$item->installment->client->name_ar}}

                                        ({{$item->installment->id}})
                                        <br>
                                        {{$item->installment->client->civil_number}}
                                    </td>

                                    <td>{{$item->madionia_amount}}</td>
                                    <td>{{$item->payment_done}} </td>
                                    <td> {{$item->reminder_amount}} </td>

                                    <td>{{ $item->military_check->first() ?         $item->military_check->first()->amount : ''}}  </td>
                                    <td>{{$item->military_check->first() ?    expolde_date($item->military_check->first()->date)[0] : ''}}  </td>

                                    @if(request()->get('check_type') == '')
                                        <td>


                                            <a target="_blank"
                                               onclick="checkFileAndRedirect(
                            '{{ $item &&  $item->military_check->first() && $item->military_check->first()->img_dir!== '0' ? 'https://electron-kw.net/' . $item->military_check->first()->img_dir : '#' }}',
                            '{{ $item && $item->military_check->first() && $item->military_check->first()->img_dir !== '0' ? 'https://electron-kw.com/' . $item->military_check->first()->img_dir : '#' }}'
                        ); return false;">

                                                            <span class="btn btn-info"> صورة الشيك
                                                                 </span>
                                            </a>


                                        </td>


                                        <td>

                                            <button class="btn btn-success me-6" data-bs-toggle="modal"
                                                    data-bs-target="#add-note-{{$item->id}}">
                                                ايداع الشيك
                                            </button>
                                            <div id="add-note-{{$item->id}}" class="modal fade" tabindex="-1"
                                                 aria-labelledby="bs-example-modal-md" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                                    <form class="mega-vertical"
                                                          action="{{url('add_check_finished')}}" method="post"
                                                          enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="modal-content">
                                                            <div class="modal-header d-flex align-items-center">
                                                                <h4 class="modal-title" id="myModalLabel">
                                                                    ايداع الشيك</h4>

                                                                <h4 class="modal-title" id="myModalLabel">
                                                                    {{$item->installment->client->name_ar}}</h4>

                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                @php
                                                                    $check_amount = $item->military_amount->where('military_affairs_check_id',0)->sum('amount');
                                                                @endphp
                                                                <input type="hidden" name="military_affairs_id"
                                                                       value="{{$item->id}}"/>
                                                                <input type="hidden" name="check_id"
                                                                       value="{{$item->military_check->first()->id}}"/>
                                                                <input type="hidden" name="installment_id"
                                                                       value="{{$item->installment->id}}"/>
                                                                <input type="hidden" name="client_name"
                                                                       value="{{$item->installment->client->name_ar}}"/>

                                                                <div class="form-row">

                                                                    <div class="form-group mb-3">
                                                                        <label class="form-label">تاريخ </label>
                                                                        <input type="date" name="date" class="form-control">
                                                                    </div>

                                                                    <div class="form-group my-3">
                                                                        <label for="formFile" class="form-label">الصورة </label>
                                                                        <input class="form-control" name="img_dir"
                                                                               accept="image/*" type="file" id="formFile">
                                                                    </div>

                                                                </div>

                                                            </div>
                                                            <div class="modal-footer d-flex ">
                                                                <button type="submit" class="btn btn-primary">حفظ</button>
                                                                <button type="button"
                                                                        class="btn bg-danger-subtle text-danger  waves-effect"
                                                                        data-bs-dismiss="modal">
                                                                    الغاء
                                                                </button>
                                                            </div>

                                                        </div>
                                                    </form>
                                                </div>
                                            </div>


                                        </td>
                                    @endif

                                </tr>
                            @endif

                        @endif
                    @endif

                @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>
@include('military_affairs.Execute_alert.print.script')


<!-- modals -->
<script>
    function showInputs() {
        document.getElementById('additionalInputs').classList.remove('hidden');
    }

    function hideInput() {
        document.getElementById('additionalInputs').classList.add('hidden');
    }


</script>
