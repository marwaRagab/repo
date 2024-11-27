<div class="mb-3 overflow-hidden position-relative">
    <div class="px-3">
        <h4 class="fs-6 mb-0">Datatable Advanced</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="../horizontal/index.html">Home</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">Datatable Advanced</li>
            </ol>
        </nav>
    </div>
</div>
<div class="datatables">
    <!-- start File export -->
    <div class="card">
        <div class="card-body">
            <div class="mb-2">
                <h4 class="card-title mb-0">File export</h4>
            </div>
            <p class="card-subtitle mb-3">
                Exporting data from a table can often be a key part of a
                complex application. The Buttons extension for DataTables
                provides three plug-ins that provide overlapping
                functionality for data export. You can refer full
                documentation from here
                <a href="https://datatables.net/">Datatables</a>
            </p>
            <div class="table-responsive">
                <table id="file_export" class="table w-100 table-striped table-bordered display text-nowrap">
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
                            رقم الهاتف
                        </th>
                        <th
                            class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                            تاريخ البدء
                        </th>
                        <th
                            class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                            نوع الضمانات
                        </th>

                        <th
                            class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                            المبلغ
                        </th>
                        <th
                            class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                            فتح ملف
                        </th>
                        <th
                            class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                            المحكمة
                        </th>
                        <th
                            class="whitespace-nowrap rounded-tl-lg bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                            الإجراءات
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $x=1;
                    @endphp
                    @foreach($items as $item)
                        @if(count($item->military_clients)>=1)
                            @php

                                $data_install=json_decode($item->installments,true);
                                $data_military=json_decode($item->military_clients,true);
                            @endphp


                            <tr>
                                <td>
                                    <p>{{$x++}}</p>
                                </td>
                                <td>

                                    <a href="{{url('www.google.com')}}">{{htmlspecialchars($data_install[0]['id'])}}</a>

                                </td>
                                <td>
                                    <h5> {{$item->name_ar}}</h5>
                                </td>
                                <td>
                                    <h5> 97963166 </h5>
                                </td>
                                <td>
                                    <h5>{{htmlspecialchars($data_military[0]['date'])}}</h5>
                                </td>

                                <td>
                                    @php

                                        $address=$item->client_address->last();

                                              if(htmlspecialchars($data_install[0]['eqrardain_date']) != Null){
                                                  $eqrar_type= 'وصل امانة';

                                              }
                                               if(htmlspecialchars($data_install[0]['qard_paper']) != Null){
                                                  $eqrar_type= 'اقرار الدين ';

                                              }
                                                if(htmlspecialchars($data_install[0]['qard_paper']) == Null  &&  htmlspecialchars($data_install[0]['eqrardain_date']) == Null ){
                                                  $eqrar_type= 'لا يوجد  ';

                                              }

                                    @endphp


                                    <h5> {{$eqrar_type}}</h5>
                                </td>
                                <td>
                                    <h5>{{htmlspecialchars($data_military[0]['amount'])}}</h5></td>


                                <td>
                                    <!-- Primary header modal -->
                                    <button type="button" class="btn mb-1 bg-primary-subtle text-primary px-4 fs-4 "
                                            data-bs-toggle="modal"
                                            data-bs-target="#primary-header-modal{{ $item->id }}">
                                        فتح ملف
                                    </button>
                                    <!-- Primary Header Modal -->
                                    <div id="primary-header-modal{{ $item->id }}" class="modal fade" tabindex="-1"
                                         aria-labelledby="primary-header-modalLabel{{ $item->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                            <div class="modal-content">
                                                <form class="mega-vertical"
                                                      action="{{route('to_ex_alert')}}" method="post"
                                                      enctype="multipart/form-data">
                                                    @csrf

                                                    <div
                                                        class="modal-header modal-colored-header bg-primary text-white">
                                                        <h4 class="modal-title text-white"
                                                            id="primary-header-modalLabel">
                                                            Modal Heading
                                                        </h4>
                                                        <button type="button" class="btn-close btn-close-white"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h5 class="mt-0">Primary Background</h5>
                                                        <p>
                                                            my broker id is {{ $item->id }}
                                                        </p>
                                                        <div class="px-4 py-4 sm:px-5">
                                                            <div class="mt-4 space-y-4">
                                                                <h5><span class="font-medium text-slate-700">
                                                                        الإسم :
                                                                    </span>
                                                                    {{$item->name_ar}}
                                                                </h5>
                                                                <p>
                                                                    @if($address)

                                                                        <span class="font-medium text-slate-700">
                                                                        عنوان السكن :

                                                                    </span>
                                                                        المنطقة
                                                                        :  {{$item->area ?  $item->area->name_ar : ''   }}
                                                                        - قطعة :  {{$address['block']}}- شارع
                                                                        : {{$address['street']}} -
                                                                        مبني :  {{$address['building']}}- الرقم الآلي
                                                                        : {{$item->house_id}}

                                                                    @endif


                                                                </p>

                                                                <input type="hidden" name="military_affairs_id"
                                                                       value="{{htmlspecialchars($data_military[0]['id'])}}">
                                                                <input type="hidden" name="id_time_type_old"
                                                                       value="{{$item_type_time->id}}">
                                                                <input type="hidden" name="id_time_type_new"
                                                                       value="{{$item_type_time_new->id}}">
                                                                <input type="hidden" name="type"
                                                                       value="{{$item_type_time->type}}">
                                                                <input type="hidden" name="type_id"
                                                                       value="{{$item_type_time->id}}">

                                                                <label class="block">
                                                                    <span>الجهة</span>


                                                                    <select name="place"
                                                                            class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">


                                                                        @foreach($courts as $court)

                                                                            <option
                                                                                value="{{$court->id}}" {{ $item->governorate_id==$court->id ?   'selected' : ''}} >
                                                                                {{$court->name_ar}}
                                                                            </option>

                                                                        @endforeach


                                                                    </select>
                                                                </label>

                                                                <label class="block">
                                                                    <span>الرقم الآلي لللقضية</span>

                                                                    <input
                                                                        class="form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                                                        placeholder="الرقم الآلي لللقضية"
                                                                        type="text" value="{{old('issue_id')}}"
                                                                        name="issue_id"/>
                                                                </label>
                                                                <label class="block">
                                                                    <span>تاريخ فتح الملف</span>


                                                                    <input
                                                                        class="form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                                                        placeholder="تاريخ فتح الملف" type="date"
                                                                        value="{{old('date')}}" name="date"/>
                                                                </label>


                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">

                                                        <button type="button" class="btn btn-light"
                                                                data-bs-dismiss="modal">
                                                            Close
                                                        </button>
                                                        <button type="submit"
                                                                class="btn bg-primary-subtle text-primary ">
                                                            Save changes
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    <!-- /.modal -->

                                    <br>
                                    <br>

                                    <button type="button" class="btn mb-1 bg-primary-subtle text-primary px-4 fs-4 "
                                            data-bs-toggle="modal"
                                            data-bs-target="#primary2-header-modal{{ $item->id }}">
                                        الرجوع الى العملاء المتاخرين
                                    </button>
                                    <!-- Primary Header Modal -->
                                    <div id="primary2-header-modal{{ $item->id }}" class="modal fade" tabindex="-1"
                                         aria-labelledby="primary2-header-modalLabel{{ $item->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                            <div class="modal-content">
                                                <form class="mega-vertical"
                                                      action="{{route('return_to_lated')}}" method="post"
                                                      enctype="multipart/form-data">
                                                    @csrf


                                                    <div
                                                        class="modal-header modal-colored-header bg-primary text-white">
                                                        <h4 class="modal-title text-white"
                                                            id="primary-header-modalLabel">
                                                            الرجوع الى العملاء المتاخرين

                                                        </h4>
                                                        <button type="button" class="btn-close btn-close-white"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h5 class="mt-0">Primary Background</h5>
                                                        <p>
                                                            my broker id is {{ $item->id }}
                                                        </p>
                                                        <div class="px-4 py-4 sm:px-5">
                                                            <div class="mt-4 space-y-4">


                                                                <input type="hidden" name="military_affairs_id"
                                                                       value="{{htmlspecialchars($data_military[0]['id'])}}">


                                                                <label class="block">
                                                                    <span>     السبب</span>
                                                                    <textarea name="return_reason"
                                                                              class="form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                                                    >

                                                                           </textarea>

                                                                </label>


                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">

                                                        <button type="button" class="btn btn-light"
                                                                data-bs-dismiss="modal">
                                                            Close
                                                        </button>
                                                        <button type="submit"
                                                                class="btn bg-primary-subtle text-primary ">
                                                            Save changes
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    <!-- /.modal -->
                                </td>
                                <td>
                                    <h5>{{$item->court->name_ar}} </h5>
                                </td>
                                <td>

                                    <button type="button" class="btn mb-1 bg-primary-subtle text-primary px-4 fs-4 "
                                            data-bs-toggle="modal"
                                            data-bs-target="#primary3-header-modal{{ $item->id }}">
                                        الملاحظة
                                    </button>
                                    <!-- Primary Header Modal -->
                                    <div id="primary3-header-modal{{ $item->id }}" class="modal fade" tabindex="-1"
                                         aria-labelledby="primary3-header-modalLabel{{ $item->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                            <div class="modal-content">
                                                <form class="mega-vertical"
                                                      action="{{url('add_notes')}}" method="post"
                                                      enctype="multipart/form-data">
                                                    @csrf


                                                    <div
                                                        class="modal-header modal-colored-header bg-primary text-white">
                                                        <h4 class="modal-title text-white"
                                                            id="primary-header-modalLabel">
                                                            Modal Heading
                                                        </h4>
                                                        <button type="button" class="btn-close btn-close-white"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h5 class="mt-0">Primary Background</h5>
                                                        <p>
                                                            my broker id is {{ $item->id }}
                                                        </p>
                                                        <div class="px-4 py-4 sm:px-5">
                                                            <div class="mt-4 space-y-4">


                                                                <input type="hidden" name="military_affairs_id"
                                                                       value="{{htmlspecialchars($data_military[0]['id'])}}">

                                                                <input type="hidden" name="type" value="open_file">

                                                                <label class="block">
                                                                    <span>الملاحظة</span>
                                                                    <select name="notes_type"
                                                                            class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                                                                        <option
                                                                            value="note">
                                                                            ملاحظة
                                                                        </option>
                                                                        <option
                                                                            value="answered">
                                                                            الرد
                                                                        </option>
                                                                        <option
                                                                            value="refused">
                                                                            لم يرد
                                                                        </option>


                                                                    </select>
                                                                </label>

                                                                <label class="block">
                                                                    <span>     السبب</span>
                                                                    <textarea name="notes"
                                                                              class="form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                                                    >

                                                                           </textarea>

                                                                </label>


                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light"
                                                                data-bs-dismiss="modal">
                                                            Close
                                                        </button>
                                                        <button type="submit"
                                                                class="btn bg-primary-subtle text-primary ">
                                                            Save changes
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    <!-- /.modal -->
                                    <button type="button" class="btn mb-1 bg-primary-subtle text-primary px-4 fs-4 "
                                            data-bs-toggle="modal"
                                            data-bs-target="#primary4-header-modal{{ $item->id }}">
                                        تفاصيل الملف
                                    </button>
                                    <!-- Primary Header Modal -->
                                    <div id="primary4-header-modal{{ $item->id }}" class="modal fade" tabindex="-1"
                                         aria-labelledby="primary4-header-modalLabel{{ $item->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                            <tr class="modal-content">
                                                <form class="mega-vertical"
                                                      action="{{url('add_notes')}}" method="post"
                                                      enctype="multipart/form-data">
                                                    @csrf

                                                    <div
                                                        class="modal-header modal-colored-header bg-primary text-white">
                                                        <h4 class="modal-title text-white"
                                                            id="primary-header-modalLabel">
                                                            Modal Heading
                                                        </h4>
                                                        <button type="button" class="btn-close btn-close-white"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h5 class="mt-0">Primary Background</h5>
                                                        <p>
                                                            my broker id is {{ $item->id }}
                                                        </p>
                                                        <div class="px-4 py-4 sm:px-5">
                                                            @php

                                                                $note=  get_all_notes('execute_alert',htmlspecialchars($data_military[0]['id']));
                                                            @endphp


                                                            <div class="my-4 space-y-4">
                                                                <div x-data="{activeTab:'tabHome'}"
                                                                     class="tabs flex flex-col">
                                                                    <div class="is-scrollbar-hidden overflow-x-auto">
                                                                        <div class="tabs-list flex">
                                                                            <button @click="activeTab = 'tabHome'"
                                                                                    :class="activeTab === 'tabHome' ? 'border-primary dark:border-accent text-primary dark:text-accent-light' : 'border-transparent hover:text-slate-800 focus:text-slate-800 dark:hover:text-navy-100 dark:focus:text-navy-100'"
                                                                                    class="btn shrink-0 rounded-none border-b-2 px-3 py-2 font-medium">
                                                                                الملاحظات
                                                                            </button>
                                                                            <button @click="activeTab = 'tabProfile'"
                                                                                    :class="activeTab === 'tabProfile' ? 'border-primary dark:border-accent text-primary dark:text-accent-light' : 'border-transparent hover:text-slate-800 focus:text-slate-800 dark:hover:text-navy-100 dark:focus:text-navy-100'"
                                                                                    class="btn shrink-0 rounded-none border-b-2 px-3 py-2 font-medium">
                                                                                تتبع المعاملة
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="tab-content pt-4">
                                                                        <div x-show="activeTab === 'tabHome'"
                                                                             x-transition:enter="transition-all duration-500 easy-in-out"
                                                                             x-transition:enter-start="opacity-0 [transform:translate3d(1rem,0,0)]"
                                                                             x-transition:enter-end="opacity-100 [transform:translate3d(0,0,0)]">
                                                                            <div
                                                                                class="is-scrollbar-hidden min-w-full overflow-x-auto">
                                                                                <table class="w-full text-right">
                                                                                    <thead>

                                                                                    <tr
                                                                                        class="border border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                                                        <th
                                                                                            class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                                                                                            يوزر التحويل
                                                                                        </th>
                                                                                        <th
                                                                                            class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                                                                                            القسم
                                                                                        </th>
                                                                                        <th
                                                                                            class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                                                                                            الملاحظة
                                                                                        </th>
                                                                                        <th
                                                                                            class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                                                                                            التاريخ
                                                                                        </th>
                                                                                        <th
                                                                                            class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                                                                                            عدد الايام
                                                                                        </th>
                                                                                    </tr>
                                                                                    </thead>

                                                                                 <tr>
                                                                                    <label class="block">
                                                                                        <span>الملاحظة</span>
                                                                                        <select name="notes_type"
                                                                                                class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                                                                                            <option
                                                                                                value="note">
                                                                                                ملاحظة
                                                                                            </option>
                                                                                            <option
                                                                                                value="answered">
                                                                                                الرد
                                                                                            </option>
                                                                                            <option
                                                                                                value="refused">
                                                                                                لم يرد
                                                                                            </option>


                                                                                        </select>
                                                                                    </label>


                                                                                    <td class="whitespace-nowrap px-4
                                                                                        py-3 sm:px-5">>

                                                                                        {{$note}}
                                                                                        <br>
                                                                                        {{$note  ? $note  :   date('Y-m-d') }}
                                                                                    </td>
                                                                                    <td>
                                                                                        <div
                                                                                            class="mb-3 overflow-hidden position-relative">
                                                                                            <div class="px-3">
                                                                                                <h4 class="fs-6 mb-0">
                                                                                                    Datatable
                                                                                                    Advanced</h4>
                                                                                                <nav
                                                                                                    aria-label="breadcrumb">
                                                                                                    <ol class="breadcrumb mb-0">
                                                                                                        <li class="breadcrumb-item">
                                                                                                            <a href="../horizontal/index.html">Home</a>
                                                                                                        </li>
                                                                                                        <li class="breadcrumb-item"
                                                                                                            aria-current="page">
                                                                                                            Datatable
                                                                                                            Advanced
                                                                                                        </li>
                                                                                                    </ol>
                                                                                                </nav>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="datatables">
                                                                                            <!-- start File export -->
                                                                                            <div class="card">
                                                                                                <div class="card-body">
                                                                                                    <div class="mb-2">
                                                                                                        <h4 class="card-title mb-0">
                                                                                                            File
                                                                                                            export</h4>
                                                                                                    </div>
                                                                                                    <p class="card-subtitle mb-3">
                                                                                                        Exporting data
                                                                                                        from a table can
                                                                                                        often be a key
                                                                                                        part of a
                                                                                                        complex
                                                                                                        application. The
                                                                                                        Buttons
                                                                                                        extension for
                                                                                                        DataTables
                                                                                                        provides three
                                                                                                        plug-ins that
                                                                                                        provide
                                                                                                        overlapping
                                                                                                        functionality
                                                                                                        for data export.
                                                                                                        You can refer
                                                                                                        full
                                                                                                        documentation
                                                                                                        from here
                                                                                                        <a href="https://datatables.net/">Datatables</a>
                                                                                                    </p>
                                                                                                    <div
                                                                                                        class="table-responsive">
                                                                                                        <table
                                                                                                            id="file_export"
                                                                                                            class="table w-100 table-striped table-bordered display text-nowrap">
                                                                                                            <thead>

                                                                                                            <tr>
                                                                                                                <th
                                                                                                                    class="whitespace-nowrap rounded-tr-lg bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                                                                                                    #
                                                                                                                </th>
                                                                                                                <th
                                                                                                                    class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                                                                                                    رقم
                                                                                                                    المعاملة
                                                                                                                </th>
                                                                                                                <th
                                                                                                                    class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                                                                                                    اسم
                                                                                                                    العميل
                                                                                                                </th>
                                                                                                                <th
                                                                                                                    class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                                                                                                    رقم
                                                                                                                    الهاتف
                                                                                                                </th>
                                                                                                                <th
                                                                                                                    class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                                                                                                    تاريخ
                                                                                                                    البدء
                                                                                                                </th>
                                                                                                                <th
                                                                                                                    class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                                                                                                    نوع
                                                                                                                    الضمانات
                                                                                                                </th>

                                                                                                                <th
                                                                                                                    class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                                                                                                    المبلغ
                                                                                                                </th>
                                                                                                                <th
                                                                                                                    class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                                                                                                    فتح
                                                                                                                    ملف
                                                                                                                </th>
                                                                                                                <th
                                                                                                                    class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                                                                                                    المحكمة
                                                                                                                </th>
                                                                                                                <th
                                                                                                                    class="whitespace-nowrap rounded-tl-lg bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                                                                                                    الإجراءات
                                                                                                                </th>
                                                                                                            </tr>
                                                                                                            </thead>
                                                                                                            <tbody>
                                                                                                            @php
                                                                                                                $x=1;
                                                                                                            @endphp
                                                                                                            @foreach($items as $item)
                                                                                                                @if(count($item->military_clients)>=1)
                                                                                                                    @php

                                                                                                                        $data_install=json_decode($item->installments,true);
                                                                                                                        $data_military=json_decode($item->military_clients,true);
                                                                                                                    @endphp

                                                                                                                    <tr>
                                                                                                                        <td>
                                                                                                                            <p>{{$x++}}</p>
                                                                                                                        </td>
                                                                                                                        <td>

                                                                                                                            <a href="{{url('www.google.com')}}">{{htmlspecialchars($data_install[0]['id'])}}</a>

                                                                                                                        </td>
                                                                                                                        <td>
                                                                                                                            <h5> {{$item->name_ar}}</h5>
                                                                                                                        </td>
                                                                                                                        <td>
                                                                                                                            <h5>
                                                                                                                                97963166 </h5>
                                                                                                                        </td>
                                                                                                                        <td>
                                                                                                                            <h5>{{htmlspecialchars($data_military[0]['date'])}}</h5>
                                                                                                                        </td>
                                                                                                                        <td>
                                                                                                                            @php

                                                                                                                                $address=$item->client_address->last();

                                                                                                                                      if(htmlspecialchars($data_install[0]['eqrardain_date']) != Null){
                                                                                                                                          $eqrar_type= 'وصل امانة';

                                                                                                                                      }
                                                                                                                                       if(htmlspecialchars($data_install[0]['qard_paper']) != Null){
                                                                                                                                          $eqrar_type= 'اقرار الدين ';

                                                                                                                                      }
                                                                                                                                        if(htmlspecialchars($data_install[0]['qard_paper']) == Null  &&  htmlspecialchars($data_install[0]['eqrardain_date']) == Null ){
                                                                                                                                          $eqrar_type= 'لا يوجد  ';

                                                                                                                                      }

                                                                                                                            @endphp


                                                                                                                            <h5> {{$eqrar_type}}</h5>
                                                                                                                        </td>
                                                                                                                        <td>
                                                                                                                            <h5>{{htmlspecialchars($data_military[0]['amount'])}}</h5>
                                                                                                                        </td>


                                                                                                                        <td>
                                                                                                                            <!-- Primary header modal -->
                                                                                                                            <button
                                                                                                                                type="button"
                                                                                                                                class="btn mb-1 bg-primary-subtle text-primary px-4 fs-4 "
                                                                                                                                data-bs-toggle="modal"
                                                                                                                                data-bs-target="#primary-header-modal{{ $item->id }}">
                                                                                                                                فتح
                                                                                                                                ملف
                                                                                                                            </button>
                                                                                                                            <!-- Primary Header Modal -->
                                                                                                                            <div
                                                                                                                                id="primary-header-modal{{ $item->id }}"
                                                                                                                                class="modal fade"
                                                                                                                                tabindex="-1"
                                                                                                                                aria-labelledby="primary-header-modalLabel{{ $item->id }}"
                                                                                                                                aria-hidden="true">
                                                                                                                                <div
                                                                                                                                    class="modal-dialog modal-dialog-scrollable modal-lg">
                                                                                                                                    <div
                                                                                                                                        class="modal-content">
                                                                                                                                        <form
                                                                                                                                            class="mega-vertical"
                                                                                                                                            action="{{route('to_ex_alert')}}"
                                                                                                                                            method="post"
                                                                                                                                            enctype="multipart/form-data">
                                                                                                                                            @csrf

                                                                                                                                            <div
                                                                                                                                                class="modal-header modal-colored-header bg-primary text-white">
                                                                                                                                                <h4 class="modal-title text-white"
                                                                                                                                                    id="primary-header-modalLabel">
                                                                                                                                                    Modal
                                                                                                                                                    Heading
                                                                                                                                                </h4>
                                                                                                                                                <button
                                                                                                                                                    type="button"
                                                                                                                                                    class="btn-close btn-close-white"
                                                                                                                                                    data-bs-dismiss="modal"
                                                                                                                                                    aria-label="Close"></button>
                                                                                                                                            </div>
                                                                                                                                            <div
                                                                                                                                                class="modal-body">
                                                                                                                                                <h5 class="mt-0">
                                                                                                                                                    Primary
                                                                                                                                                    Background</h5>
                                                                                                                                                <p>
                                                                                                                                                    my
                                                                                                                                                    broker
                                                                                                                                                    id
                                                                                                                                                    is {{ $item->id }}
                                                                                                                                                </p>
                                                                                                                                                <div
                                                                                                                                                    class="px-4 py-4 sm:px-5">
                                                                                                                                                    <div
                                                                                                                                                        class="mt-4 space-y-4">
                                                                                                                                                        <h5><span
                                                                                                                                                                class="font-medium text-slate-700">
                                                                        الإسم :
                                                                    </span>
                                                                                                                                                            {{$item->name_ar}}
                                                                                                                                                        </h5>
                                                                                                                                                        <p>
                                                                                                                                                            @if($address)

                                                                                                                                                                <span
                                                                                                                                                                    class="font-medium text-slate-700">
                                                                        عنوان السكن :

                                                                    </span>
                                                                                                                                                                المنطقة
                                                                                                                                                                :  {{$item->area ?  $item->area->name_ar : ''   }}
                                                                                                                                                                -
                                                                                                                                                                قطعة
                                                                                                                                                                :  {{$address['block']}}
                                                                                                                                                                -
                                                                                                                                                                شارع
                                                                                                                                                                : {{$address['street']}}
                                                                                                                                                                -
                                                                                                                                                                مبني
                                                                                                                                                                :  {{$address['building']}}
                                                                                                                                                                -
                                                                                                                                                                الرقم
                                                                                                                                                                الآلي
                                                                                                                                                                : {{$item->house_id}}

                                                                                                                                                            @endif


                                                                                                                                                        </p>

                                                                                                                                                        <input
                                                                                                                                                            type="hidden"
                                                                                                                                                            name="military_affairs_id"
                                                                                                                                                            value="{{htmlspecialchars($data_military[0]['id'])}}">
                                                                                                                                                        <input
                                                                                                                                                            type="hidden"
                                                                                                                                                            name="id_time_type_old"
                                                                                                                                                            value="{{$item_type_time->id}}">
                                                                                                                                                        <input
                                                                                                                                                            type="hidden"
                                                                                                                                                            name="id_time_type_new"
                                                                                                                                                            value="{{$item_type_time_new->id}}">
                                                                                                                                                        <input
                                                                                                                                                            type="hidden"
                                                                                                                                                            name="type"
                                                                                                                                                            value="{{$item_type_time->type}}">
                                                                                                                                                        <input
                                                                                                                                                            type="hidden"
                                                                                                                                                            name="type_id"
                                                                                                                                                            value="{{$item_type_time->id}}">

                                                                                                                                                        <label
                                                                                                                                                            class="block">
                                                                                                                                                            <span>الجهة</span>


                                                                                                                                                            <select
                                                                                                                                                                name="place"
                                                                                                                                                                class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">


                                                                                                                                                                @foreach($courts as $court)

                                                                                                                                                                    <option
                                                                                                                                                                        value="{{$court->id}}" {{ $item->governorate_id==$court->id ?   'selected' : ''}} >
                                                                                                                                                                        {{$court->name_ar}}
                                                                                                                                                                    </option>

                                                                                                                                                                @endforeach


                                                                                                                                                            </select>
                                                                                                                                                        </label>

                                                                                                                                                        <label
                                                                                                                                                            class="block">
                                                                                                                                                            <span>الرقم الآلي لللقضية</span>

                                                                                                                                                            <input
                                                                                                                                                                class="form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                                                                                                                                                placeholder="الرقم الآلي لللقضية"
                                                                                                                                                                type="text"
                                                                                                                                                                value="{{old('issue_id')}}"
                                                                                                                                                                name="issue_id"/>
                                                                                                                                                        </label>
                                                                                                                                                        <label
                                                                                                                                                            class="block">
                                                                                                                                                            <span>تاريخ فتح الملف</span>

                                                                                                                                                            <input
                                                                                                                                                                class="form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                                                                                                                                                placeholder="تاريخ فتح الملف"
                                                                                                                                                                type="date"
                                                                                                                                                                value="{{old('date')}}"
                                                                                                                                                                name="date"/>
                                                                                                                                                        </label>


                                                                                                                                                    </div>
                                                                                                                                                </div>
                                                                                                                                            </div>
                                                                                                                                            <div
                                                                                                                                                class="modal-footer">
                                                                                                                                                <button
                                                                                                                                                    type="button"
                                                                                                                                                    class="btn btn-light"
                                                                                                                                                    data-bs-dismiss="modal">
                                                                                                                                                    Close
                                                                                                                                                </button>
                                                                                                                                                <button
                                                                                                                                                    type="submit"
                                                                                                                                                    class="btn bg-primary-subtle text-primary ">
                                                                                                                                                    Save
                                                                                                                                                    changes
                                                                                                                                                </button>
                                                                                                                                            </div>
                                                                                                                                        </form>
                                                                                                                                    </div>
                                                                                                                                    <!-- /.modal-content -->
                                                                                                                                </div>
                                                                                                                                <!-- /.modal-dialog -->
                                                                                                                            </div>
                                                                                                                            <!-- /.modal -->

                                                                                                                            <br>
                                                                                                                            <br>

                                                                                                                            <button
                                                                                                                                type="button"
                                                                                                                                class="btn mb-1 bg-primary-subtle text-primary px-4 fs-4 "
                                                                                                                                data-bs-toggle="modal"
                                                                                                                                data-bs-target="#primary2-header-modal{{ $item->id }}">
                                                                                                                                الرجوع
                                                                                                                                الى
                                                                                                                                العملاء
                                                                                                                                المتاخرين
                                                                                                                            </button>
                                                                                                                            <!-- Primary Header Modal -->
                                                                                                                            <div
                                                                                                                                id="primary2-header-modal{{ $item->id }}"
                                                                                                                                class="modal fade"
                                                                                                                                tabindex="-1"
                                                                                                                                aria-labelledby="primary2-header-modalLabel{{ $item->id }}"
                                                                                                                                aria-hidden="true">
                                                                                                                                <div
                                                                                                                                    class="modal-dialog modal-dialog-scrollable modal-lg">
                                                                                                                                    <div
                                                                                                                                        class="modal-content">
                                                                                                                                        <form
                                                                                                                                            class="mega-vertical"
                                                                                                                                            action="{{route('return_to_lated')}}"
                                                                                                                                            method="post"
                                                                                                                                            enctype="multipart/form-data">
                                                                                                                                            @csrf

                                                                                                                                            <div
                                                                                                                                                class="modal-header modal-colored-header bg-primary text-white">
                                                                                                                                                <h4 class="modal-title text-white"
                                                                                                                                                    id="primary-header-modalLabel">
                                                                                                                                                    الرجوع
                                                                                                                                                    الى
                                                                                                                                                    العملاء
                                                                                                                                                    المتاخرين

                                                                                                                                                </h4>
                                                                                                                                                <button
                                                                                                                                                    type="button"
                                                                                                                                                    class="btn-close btn-close-white"
                                                                                                                                                    data-bs-dismiss="modal"
                                                                                                                                                    aria-label="Close"></button>
                                                                                                                                            </div>
                                                                                                                                            <div
                                                                                                                                                class="modal-body">
                                                                                                                                                <h5 class="mt-0">
                                                                                                                                                    Primary
                                                                                                                                                    Background</h5>
                                                                                                                                                <p>
                                                                                                                                                    my
                                                                                                                                                    broker
                                                                                                                                                    id
                                                                                                                                                    is {{ $item->id }}
                                                                                                                                                </p>
                                                                                                                                                <div
                                                                                                                                                    class="px-4 py-4 sm:px-5">
                                                                                                                                                    <div
                                                                                                                                                        class="mt-4 space-y-4">


                                                                                                                                                        <input
                                                                                                                                                            type="hidden"
                                                                                                                                                            name="military_affairs_id"
                                                                                                                                                            value="{{htmlspecialchars($data_military[0]['id'])}}">


                                                                                                                                                        <label
                                                                                                                                                            class="block">
                                                                                                                                                            <span>     السبب</span>
                                                                                                                                                            <textarea
                                                                                                                                                                name="return_reason"
                                                                                                                                                                class="form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                                                                                                                                            >

                                                                           </textarea>

                                                                                                                                                        </label>


                                                                                                                                                    </div>
                                                                                                                                                </div>
                                                                                                                                            </div>
                                                                                                                                            <div
                                                                                                                                                class="modal-footer">
                                                                                                                                                <button
                                                                                                                                                    type="button"
                                                                                                                                                    class="btn btn-light"
                                                                                                                                                    data-bs-dismiss="modal">
                                                                                                                                                    Close
                                                                                                                                                </button>
                                                                                                                                                <button
                                                                                                                                                    type="submit"
                                                                                                                                                    class="btn bg-primary-subtle text-primary ">
                                                                                                                                                    Save
                                                                                                                                                    changes
                                                                                                                                                </button>
                                                                                                                                            </div>
                                                                                                                                        </form>
                                                                                                                                    </div>
                                                                                                                                    <!-- /.modal-content -->
                                                                                                                                </div>
                                                                                                                                <!-- /.modal-dialog -->
                                                                                                                            </div>
                                                                                                                            <!-- /.modal -->
                                                                                                                        </td>
                                                                                                                        <td>
                                                                                                                            <h5>{{$item->court->name_ar}} </h5>
                                                                                                                        </td>
                                                                                                                        <td>
                                                                                                                            <button
                                                                                                                                type="button"
                                                                                                                                class="btn mb-1 bg-primary-subtle text-primary px-4 fs-4 "
                                                                                                                                data-bs-toggle="modal"
                                                                                                                                data-bs-target="#primary3-header-modal{{ $item->id }}">
                                                                                                                                فتح
                                                                                                                                ملف
                                                                                                                            </button>
                                                                                                                            <!-- Primary Header Modal -->
                                                                                                                            <div
                                                                                                                                id="primary3-header-modal{{ $item->id }}"
                                                                                                                                class="modal fade"
                                                                                                                                tabindex="-1"
                                                                                                                                aria-labelledby="primary3-header-modalLabel{{ $item->id }}"
                                                                                                                                aria-hidden="true">
                                                                                                                                <div
                                                                                                                                    class="modal-dialog modal-dialog-scrollable modal-lg">
                                                                                                                                    <div
                                                                                                                                        class="modal-content">
                                                                                                                                        <form
                                                                                                                                            class="mega-vertical"
                                                                                                                                            action="{{url('add_notes')}}"
                                                                                                                                            method="post"
                                                                                                                                            enctype="multipart/form-data">
                                                                                                                                            @csrf

                                                                                                                                            <div
                                                                                                                                                class="modal-header modal-colored-header bg-primary text-white">
                                                                                                                                                <h4 class="modal-title text-white"
                                                                                                                                                    id="primary-header-modalLabel">
                                                                                                                                                    Modal
                                                                                                                                                    Heading
                                                                                                                                                </h4>
                                                                                                                                                <button
                                                                                                                                                    type="button"
                                                                                                                                                    class="btn-close btn-close-white"
                                                                                                                                                    data-bs-dismiss="modal"
                                                                                                                                                    aria-label="Close"></button>
                                                                                                                                            </div>
                                                                                                                                            <div
                                                                                                                                                class="modal-body">
                                                                                                                                                <h5 class="mt-0">
                                                                                                                                                    Primary
                                                                                                                                                    Background</h5>
                                                                                                                                                <p>
                                                                                                                                                    my
                                                                                                                                                    broker
                                                                                                                                                    id
                                                                                                                                                    is {{ $item->id }}
                                                                                                                                                </p>
                                                                                                                                                <div
                                                                                                                                                    class="px-4 py-4 sm:px-5">
                                                                                                                                                    <div
                                                                                                                                                        class="mt-4 space-y-4">


                                                                                                                                                        <input
                                                                                                                                                            type="hidden"
                                                                                                                                                            name="military_affairs_id"
                                                                                                                                                            value="{{htmlspecialchars($data_military[0]['id'])}}">


                                                                                                                                                        <label
                                                                                                                                                            class="block">
                                                                                                                                                            <span>الملاحظة</span>
                                                                                                                                                            <select
                                                                                                                                                                name="notes_type"
                                                                                                                                                                class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                                                                                                                                                                <option
                                                                                                                                                                    value="note">
                                                                                                                                                                    ملاحظة
                                                                                                                                                                </option>
                                                                                                                                                                <option
                                                                                                                                                                    value="answered">
                                                                                                                                                                    الرد
                                                                                                                                                                </option>
                                                                                                                                                                <option
                                                                                                                                                                    value="refused">
                                                                                                                                                                    لم
                                                                                                                                                                    يرد
                                                                                                                                                                </option>


                                                                                                                                                            </select>
                                                                                                                                                        </label>

                                                                                                                                                        <label
                                                                                                                                                            class="block">
                                                                                                                                                            <span>     السبب</span>
                                                                                                                                                            <textarea
                                                                                                                                                                name="notes"
                                                                                                                                                                class="form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                                                                                                                                            >

                                                                           </textarea>

                                                                                                                                                        </label>


                                                                                                                                                    </div>
                                                                                                                                                </div>
                                                                                                                                            </div>
                                                                                                                                            <div
                                                                                                                                                class="modal-footer">
                                                                                                                                                <button
                                                                                                                                                    type="button"
                                                                                                                                                    class="btn btn-light"
                                                                                                                                                    data-bs-dismiss="modal">
                                                                                                                                                    Close
                                                                                                                                                </button>
                                                                                                                                                <button
                                                                                                                                                    type="submit"
                                                                                                                                                    class="btn bg-primary-subtle text-primary ">
                                                                                                                                                    Save
                                                                                                                                                    changes
                                                                                                                                                </button>
                                                                                                                                            </div>
                                                                                                                                        </form>
                                                                                                                                    </div>
                                                                                                                                    <!-- /.modal-content -->
                                                                                                                                </div>
                                                                                                                                <!-- /.modal-dialog -->
                                                                                                                            </div>
                                                                                                                            <!-- /.modal -->

                                                                                                                        </td>


                                                                                                                    </tr>
                                                                                                                @endif
                                                                                                            @endforeach
                                                                                                            <!-- end row -->
                                                                                                            </tbody>
                                                                                                        </table>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>



                                                                                    </td>
                                                                                    <div class="modal-footer">

                                                                                        <button type="button" class="btn btn-light"
                                                                                                data-bs-dismiss="modal">
                                                                                            Close
                                                                                        </button>
                                                                                        <button type="submit"
                                                                                                class="btn bg-primary-subtle text-primary ">
                                                                                            Save changes
                                                                                        </button>
                                                                                    </div>


                                                                               </tr>
                                                                                </table>
                                                                            </div>


                             @endif
                            @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.modal-content -->


<!-- end row -->
