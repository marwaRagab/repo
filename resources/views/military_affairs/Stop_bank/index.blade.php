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
        if(Request::has('date')){
        $date=Request::get('date');
        }else{
        $date='';
        }
         if(Request::has('bank')){
        $bank=Request::get('bank');
        }else{
        $bank='';
        }
    @endphp
    <div class="d-flex flex-wrap ">
        <a href="{{route('stop_bank')}}"
           class="btn-filter bg-success-subtle text-warning px-2  mx-1 mb-2  {{ request()->has('governorate_id') == 0 ? 'active' : '' }}  ">
            العدد الكلي ({{ count_court('' ,'stop_bank',null,null) }})
        </a>

        @foreach($courts as $court)

            <a href="{{route('stop_bank',array('governorate_id' => $court->id))}}"
               class="btn-filter {{$court->style}}   px-2  mx-1 mb-2  {{ request()->get('governorate_id') == $court->id ? 'active' : '' }} "> {{$court->name_ar}}({{ count_court($court->id ,'stop_bank',null,null) }})
            </a>

        @endforeach
    </div>
</div>

<div class="card mt-4 py-3">
    <div class="d-flex flex-wrap ">

        @foreach($stop_bank_types as $stop_bank_type)

            <a href="{{route('stop_bank',array('governorate_id' => $gov,'stop_bank_type'=> $stop_bank_type->slug))}}"
               class="btn-filter {{$stop_bank_type->style}}   px-2  mx-1 mb-2  {{ request()->get('stop_bank_type') == $stop_bank_type->id ? 'active' : '' }} "> {{$stop_bank_type->name_ar}}
            </a>

        @endforeach
    </div>


</div>
@if(request()->has('stop_bank_type'))
    <div class="card mt-4 py-3">
        <div class="d-flex flex-wrap ">


        @foreach($dates as $one)
                <a href="{{route('stop_bank',array('governorate_id' => $gov,'stop_bank_type'=> $bank_type , 'date' => $one,'bank'=>$bank))}}"
                   class="btn-filter bg-success-subtle text-success px-2  mx-1 mb-2   {{ request()->get('date') == $one ? 'active' : '' }}  ">
                    {{now()->format('Y').'/'.now()->format('m').'/'.$one}}
                </a>
            @endforeach
        </div>
    </div>

    @if(count($banks) > 0 || request()->has('bank'))
        <div class="card mt-4 py-3">
            <div class="d-flex flex-wrap ">
                @foreach($banks as $bank)
                    <a href="{{route('stop_bank',array('governorate_id' => $gov,'stop_bank_type'=> $bank_type , 'bank' => $bank['slug'],'date'=> $date))}}"
                       class="btn-filter bg-success-subtle text-success px-2  mx-1 mb-2 {{ request()->get('bank') == $bank['slug'] ? 'active' : '' }}   ">
                        {{$bank['name']}}
                    </a>
                @endforeach
            </div>
        </div>
    @endif
@endif

<div class="card">
    <div class="d-flex align-items-center justify-content-between px-2 py-3 border-bottom">
        <h4 class="card-title mb-0">حجز بنوك </h4>
        <a class="btn me-1 mb-1 bg-success-subtle text-success px-2  " href="{{ route('stop_bank.archive') }}">
            الإرشيف </a>
    </div>
    <div class="card-body">
        <div class="table-responsive pb-4">
            <table id="all-student" class="table table-bordered border text-nowrap align-middle">

                <thead>

                <tr>
                    <th
                        class="whitespace-nowrap rounded-tr-lg bg-slate-200 px-2 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                        #
                    </th>

                    <th
                        class="whitespace-nowrap bg-slate-200 px-2 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                        اسم العميل
                    </th>
                    <th
                        class="whitespace-nowrap bg-slate-200 px-2 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                        المحكمة
                    </th>
                    <th
                        class="whitespace-nowrap bg-slate-200 px-2 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                        المبلغ
                    </th>
                    <th
                        class="whitespace-nowrap bg-slate-200 px-2 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                        تاريخ الحجز
                    </th>
                    <th
                        class="whitespace-nowrap bg-slate-200 px-2 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                        تاريخ اخر طلب
                    </th>
                    <th
                        class="whitespace-nowrap bg-slate-200 px-2 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                        الوزارة
                    </th>
                    <th
                        class="whitespace-nowrap bg-slate-200 px-2 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                        تحديد مسئول
                    </th>

                    <th
                        class="whitespace-nowrap rounded-tl-lg bg-slate-200 px-2 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                        الحساب
                    </th>

                    <th
                        class="whitespace-nowrap rounded-tl-lg bg-slate-200 px-2 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                        الإجراءات
                    </th>
                </tr>
                </thead>

                <tbody>


                @foreach($items as $item)
                    @if($item->installment)


                                    @include('military_affairs.Stop_bank.table_details')


                    @endif


                @endforeach


                </tbody>


            </table>


        </div>


    </div>
</div>
