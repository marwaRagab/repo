<div class="card mt-4 py-3">
    <div class="d-flex flex-wrap ">
        <a   href="{{route('execute_alert')}}"  class="btn-filter bg-warning-subtle text-warning px-4 fs-4 mx-1 mb-2">
            العدد الكلي ({{ count_court('' ,'execute_alert',null,null) }})
        </a>

        @foreach($courts as $court)

            <a href="{{route('execute_alert',array('governorate_id' => $court->id))}}"
               class="btn-filter {{$court->style}}   px-4 fs-4 mx-1 mb-2"   > {{$court->name_ar}} 
               ({{ count_court($court->id ,'execute_alert',null,null) }})
            </a>

        @endforeach
    </div>
</div>

<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0">إعلان التنفيذ </h4>
    </div>
    <div class="card-body">
        <div class="table-responsive pb-4">
            <table id="all-student" class="table table-bordered border text-center text-nowrap align-middle">

                <thead>

                <tr>
                    <th
                        class="whitespace-nowrap rounded-tr-lg bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                        #
                    </th>
                    <th
                        class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                        رقم المعاملة
                    </th>
                    <th
                        class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                        اسم العميل
                    </th>
                    <th
                        class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                        تاريخ البدء
                    </th>
                    <th
                        class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                        تاريخ فتح الملف
                    </th>
                    <th
                        class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                        الرقم الآلي
                    </th>

                        <th
                            class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                            تاريخ النتيجة
                        </th>
                        <th
                            class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                            تفاصيل النتيجة
                        </th>
                        <th
                            class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                            الصورة
                        </th>
                        <th
                            class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                            تاريخ ايداع الاعلان
                        </th>

                        <th
                        class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                        تحديد مسئول
                    </th>

                    <th
                        class="whitespace-nowrap rounded-tl-lg bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                        الإجراءات
                    </th>
                </tr>
                </thead>

                <tbody>


                @foreach($items as $item)
                    @if($item->installment)
                        @if( Request::has('governorate_id') &&  Request::get('governorate_id') == $item->installment->client->court->id)
                            @include('military_affairs.Execute_alert.table_details')
                        @endif
                        @if(!Request::has('governorate_id'))

                            @include('military_affairs.Execute_alert.table_details')


                        @endif

                    @endif
                @endforeach
                </tbody>

            </table>


        </div>


    </div>
</div>
<script>

    function showInputs(id) {

        document.getElementById("additionalInputs-"+id).style.display = "block";

    }


</script>

