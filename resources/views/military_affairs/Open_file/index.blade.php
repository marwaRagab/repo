
<div class="card mt-4 py-3">
    <div class="d-flex flex-wrap ">


        <a   href="{{route('open_file')}}" class="btn-filter bg-warning-subtle text-warning px-4 fs-4 mx-1 mb-2">
            العدد الكلي ({{ count_court('' ,'open_file',null,null) }})
        </a>

        @foreach($courts as $court)

            <a href="{{route('open_file',array('governorate_id' => $court->id))}}"
               class="btn-filter {{$court->style}}   px-4 fs-4 mx-1 mb-2"> {{$court->name_ar}} {{ count_court($court->id ,'open_file',null,null) }}
            </a>

        @endforeach
    </div>
</div>
<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0">فتح ملف</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive pb-4">
            <table id="all-student" class="table table-bordered border text-nowrap align-middle">
                <thead>
                <!-- start row -->
                <tr>
                    <th>#</th>
                    <th>رقم المعاملة</th>
                    <th>اسم العميل</th>
                    <th> رقم الهاتف</th>
                    <th>تاريخ البدء</th>
                    <th> نوع الضمانات
                    </th>
                    <th>المبلغ</th>
                    <th> فتح ملف</th>
                    <th> تحديد مسئول</th>
                    <th> المحكمة</th>
                    <th> الإجراءات</th>

                </tr>
                <!-- end row -->
                </thead>
                <tbody>
                <!-- start row -->
                @if(isset($items))
                    @foreach( $items as $item)

                        @if($item->installment->finished==0)
                            @if( Request::has('governorate_id') &&  Request::get('governorate_id') == $item->installment->client->court?->id)
                                @include('military_affairs.Open_file.table_details')
                            @endif
                            @if(!Request::has('governorate_id'))
                                @include('military_affairs.Open_file.table_details')

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


    $(window).on('load', function () {
        let var_id = '{{$errors->first('id')}}';
        @if ($errors->has('method') && $errors->first('method')=='POST' && $errors->has('id'))
        $('#return_to_lated' + var_id).modal('show');
        @endif
    });

</script>
