@php use Illuminate\Support\Facades\Request; @endphp
<div class="card mt-4 py-3">
    <div class="d-flex flex-wrap ">
        <a href="{{route('stop_travel')}}"

           class="btn border border-info font-medium text-info hover:bg-info hover:text-white focus:bg-info focus:text-white active:bg-info/90 ml-3 mt-3">
            العدد الكلي ({{count($items)}})
        </a>
        @php
            if(Request::has('governorate_id')){
                $gov=Request::get('governorate_id');
            }else{
               $gov='';
            }
             if(Request::has('stop_travel_type')){
                $travel_type=Request::get('stop_travel_type');
            }else{
             $travel_type='';
            }
        @endphp



        @foreach($courts as $court)

            <a href="{{route('stop_travel',array('governorate_id' => $court->id,'stop_travel_type'=>$travel_type))}}"
               class="btn-filter {{$court->style}}   px-4 fs-4 mx-1 mb-2"> {{$court->name_ar}}
            </a>

        @endforeach


    </div>
    <div class="d-flex flex-wrap ">

        @php
            if(Request::has('governorate_id')){
                $gov=Request::get('governorate_id');
            }else{
               $gov='';
            }
             if(Request::has('stop_travel_type')){
                $travel_type=Request::get('stop_travel_type');
            }else{
             $travel_type='';
            }
        @endphp

        @foreach($stop_travel_types as $stop_travel_type)

            <a href="{{route('stop_travel',array('stop_travel_type' => $stop_travel_type->slug,'governorate_id'=> $gov ))}}"
               class="btn-filter {{$stop_travel_type->style}}   px-4 fs-4 mx-1 mb-2">  {{$stop_travel_type->name_ar}}
            </a>

        @endforeach
    </div>

</div>


<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0"> منع السفر</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive pb-4">
            <table id="all-student" class="table table-bordered border text-nowrap align-middle">

                <thead>
                <!-- start row -->


                <tr>
                    <!--
                                        <th>#</th>
                    -->
                    <th>رقم المعاملة</th>
                    <th>اسم العميل</th>
                    <th> المحكمة</th>
                    <th> العددات</th>
                    <th> تاريخ فتح ملف</th>
                    <th>الرقم الالى</th>


                    @if(Request::get('stop_travel_type')=='command')

                        <th>تاريخ طلب منع سفر</th>
                        <th> منع سفر</th>
                    @elseif(Request::get('stop_travel_type')=='stop_travel_finished')

                        <th>تاريخ طلب منع سفر</th>
                        <th> تاريخ منع سفر</th>
                    @elseif(Request::get('stop_travel_type')=='stop_travel_cancel_request')

                        <th> تاريخ طلب رفع منع سفر</th>
                        <th> رفع منع سفر</th>
                    @elseif(Request::get('stop_travel_type')=='stop_travel_cancel')

                        <th> تاريخ طلب رفع منع سفر</th>
                        <th> تاريخ رفع منع سفر</th>
                    @else
                        <th>امر منع سفر</th>

                    @endif

                    <th> الإجراءات</th>

                </tr>
                <!-- end row -->
                </thead>
                <tbody>

                <!-- start row -->
                @if(isset($items))

                    @foreach( $items as $item)

                        @if($item->installment)
                            @php
                                if($item->installment->client->court)
                                $court_id= \App\Models\Court::where('governorate_id', $item->installment->client->court->id)->first()->id;
                                else
                                    $court_id='';


                                 if( Request::has('stop_travel_type') &&  Request::get('stop_travel_type')!= '' ){
                                     if( Request::get('stop_travel_type')=='command'){

                                           $array=count($item->status_all->where('flag',2));
                                        }else{
                                      //   echo Request::get('stop_travel_type')
                                        $array= count($item->status_all->where('type_id',Request::get('stop_travel_type'))) ;
                                        }
                                    }else{
                                     $array= count($items);
                                    }


                            @endphp

                            @if( Request::has('governorate_id')&&   Request::get('governorate_id')!= ''  &&  Request::get('governorate_id') == $court_id)

                                @if($array>0)

                                    @include('military_affairs.Stop_travel.table_details')

                                @endif
                            @endif
                            @if(!Request::has('governorate_id') ||  Request::get('governorate_id')== '' )

                                @if($array>0)

                                    @include('military_affairs.Stop_travel.table_details')

                                @endif
                            @endif

                        @endif
                    @endforeach

                @endif
                </tbody>
            </table>

        </div>

    </div>
</div>


<script>


</script>
