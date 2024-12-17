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
    <div class="d-flex flex-wrap ">
        <a href="{{route('stop_bank',array('governorate_id' => $court->id,'stop_bank_type' =>$bank_type))}}"
            class="btn-filter bg-warning-subtle text-warning px-4 fs-4 mx-1 mb-2">
            العدد الكلي ({{count($items)}})
        </a>

        @foreach($stop_bank_types as $stop_bank_type)

        <a href="{{route('stop_bank',array('governorate_id' => $gov,'stop_bank_type'=> $stop_bank_type->slug))}}"
            class="btn-filter {{$stop_bank_type->style}}   px-4 fs-4 mx-1 mb-2"> {{$stop_bank_type->name_ar}}
        </a>

        @endforeach
    </div>



    @if(Request::has('stop_bank_type'))
    <div class="d-flex flex-wrap ">
        <a href="{{route('stop_bank')}}" class="btn-filter bg-warning-subtle text-warning px-4 fs-4 mx-1 mb-2">
            العدد الكلي ({{count($items)}})
        </a>
        {{--@foreach($ministries as $ministry)

                <a href="{{route('stop_bank',array('governorate_id' => $gov,'ministry_id' =>$ministry->date,'stop_bank_type' => $bank_type))}}"
        class="btn-filter {{$ministry->style}} px-4 fs-4 mx-1 mb-2"> {{$ministry->ministries_dates}}
        </a>

        @endforeach--}}
    </div>

    @endif
    @if(Request::has('stop_bank_type'))
    <div class="d-flex flex-wrap ">
        <a href="{{route('stop_bank')}}" class="btn-filter bg-warning-subtle text-warning px-4 fs-4 mx-1 mb-2">
            العدد الكلي ({{count($items)}})
        </a>

        {{-- @foreach($banks as $bank)

                <a href="{{route('stop_bank',array('governorate_id' => $gov,'ministry_id' =>$ministry,'certificate_type' => $Certificate_type->name_en))}}"
        class="btn-filter {{$bank->style}} px-4 fs-4 mx-1 mb-2"> {{$bank->name_ar}}
        </a>

        @endforeach--}}
    </div>
    @endif
</div>


@if(count($ministries) > 0 || request()->has('day'))
<div class="card mt-4 py-3">
    <div class="d-flex flex-wrap ">
        @foreach($ministries as $one)
      
        <a href="{{route('stop_bank',array('governorate_id' => $gov,'stop_bank_type'=> $bank_type , 'day' => $one))}}"
            class="btn-filter bg-success-subtle text-success px-4 fs-4 mx-1 mb-2">
            {{now()->format('Y').'/'.now()->format('m').'/'.$one->format('d')}} ({{ $one}})
        </a>
        @endforeach
    </div>
</div>
@endif

<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0">حجز بنوك </h4>
        <a class="btn me-1 mb-1 bg-success-subtle text-success px-4 fs-4 " href="{{ route('stop_bank.archive') }}">
            الإرشيف </a>
    </div>
    <div class="card-body">
        <div class="table-responsive pb-4">
            <table id="all-student" class="table table-bordered border text-nowrap align-middle">

                <thead>

                    <tr>
                        <th
                            class="whitespace-nowrap rounded-tr-lg bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                            #
                        </th>

                        <th
                            class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                            اسم العميل
                        </th>
                        <th
                            class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                            المحكمة
                        </th>
                        <th
                            class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                            المبلغ
                        </th>
                        <th
                            class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                            تاريخ الحجز
                        </th>
                        <th
                            class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                            تاريخ اخر طلب
                        </th>
                        <th
                            class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                            الوزارة
                        </th>

                        <th
                            class="whitespace-nowrap rounded-tl-lg bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                            الحساب
                        </th>

                        <th
                            class="whitespace-nowrap rounded-tl-lg bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                            الإجراءات
                        </th>
                    </tr>
                </thead>

                <tbody>


                    @foreach($items as $item)


                    @if($item->installment->finished==0)

                    @php

                    $item_statues=
                    $item->notes->where('type','=','stop_bank')->where('times_type_id',$item_type_time_old->id)->where('date_end',NULL);
                    @endphp
                    @if( Request::has('governorate_id') && Request::get('governorate_id') ==
                    $item->installment->client->governorate_id)

                    @include('military_affairs.Stop_bank.table_details')

                    @endif

                    @if(!Request::has('governorate_id') || Request::get('governorate_id') == '' )

                    @if(count($item_statues)>=1)

                    @include('military_affairs.Stop_bank.table_details')

                    @endif

                    @endif
                    @endif

                    @endforeach
                </tbody>

            </table>


        </div>


    </div>
</div>