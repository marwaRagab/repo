@extends('header.index')
@section('content')
    <!-- DataTables CSS -->

    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        <div class="flex items-center space-x-4 space-x-reverse py-5 lg:py-6">
            <h2 class="text-xl font-medium text-slate-800 dark:text-navy-50 lg:text-2xl">
                فتح ملف</h2>
            <div class="hidden h-full py-1 sm:flex">
                <div class="h-full w-px bg-slate-300 dark:bg-navy-600"></div>
            </div>
            <ul class="hidden flex-wrap items-center space-x-2 space-x-reverse sm:flex">
                <li class="flex items-center space-x-2 space-x-reverse">
                    <a class="text-primary transition-colors hover:text-primary-focus dark:text-accent-light dark:hover:text-accent"
                       href="#">الإعدادات</a>
                    <svg x-ignore xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </li>
                <li>فتح ملف</li>
            </ul>
        </div>
        <div class="grid grid-cols-1 gap-4 sm:gap-5 lg:gap-6">
            <!-- Users Table -->

            <div class=" filters ">
                <a href="{{route('open_file')}}"
                   class="btn border border-info font-medium text-info hover:bg-info hover:text-white focus:bg-info focus:text-white active:bg-info/90 ml-3 mt-3">
                    العدد الكلي (5857)
                </a>
                @foreach($courts as $court)

                    <a href="{{route('open_file',array('governorate_id' => $court->id))}}"
                       class="btn border border-secondary font-medium text-secondary hover:bg-secondary hover:text-white focus:bg-secondary focus:text-white active:bg-secondary/90 dark:text-secondary-light dark:hover:bg-secondary dark:hover:text-white dark:focus:bg-secondary dark:focus:text-white dark:active:bg-secondary/90 ml-3 mt-3">
                        {{$court->name_ar}}
                    </a>

                @endforeach
            </div>
            <div class=" card-custom my-5 flex items-center justify-between">
                <div class="flex">
                    <div class="flex items-center" x-data="{isInputActive:false}">
                        <label class="block">
                            <input x-effect="isInputActive === true && $nextTick(() => { $el.focus()});"
                                   :class="isInputActive ? 'w-32 lg:w-48' : 'w-0'"
                                   class="form-input bg-transparent px-1 text-left transition-all duration-100 placeholder:text-slate-500 dark:placeholder:text-navy-200"
                                   placeholder="Search here..." type="text"/>
                        </label>
                        <button @click="isInputActive = !isInputActive"
                                class="btn h-8 w-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </button>
                    </div>

                </div>
            </div>
            <div class="card">
                <div class="is-scrollbar-hidden min-w-full overflow-x-auto">
                    <table class="is-hoverable w-full text-right">
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

                                <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <p>{{$x++}}</p>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">

                                        <a href="{{url('www.google.com')}}">{{htmlspecialchars($data_install[0]['id'])}}</a>

                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <h5> {{$item->name_ar}}</h5>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <h5> 97963166 </h5>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <h5>{{htmlspecialchars($data_military[0]['date'])}}</h5>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
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
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <h5>{{htmlspecialchars($data_military[0]['amount'])}}</h5></td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <div x-data="{showModal:false}">
                                            <button @click="showModal = true"
                                                    class="btn bg-slate-150 font-medium text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">
                                                فتح ملف
                                            </button>

                                            <template x-teleport="#x-teleport-target">
                                                <div
                                                    class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
                                                    x-show="showModal" role="dialog"
                                                    @keydown.window.escape="showModal = false">
                                                    <div
                                                        class="absolute inset-0 bg-slate-900/60 transition-opacity duration-300"
                                                        @click="showModal = false" x-show="showModal"
                                                        x-transition:enter="ease-out"
                                                        x-transition:enter-start="opacity-0"
                                                        x-transition:enter-end="opacity-100"
                                                        x-transition:leave="ease-in"
                                                        x-transition:leave-start="opacity-100"
                                                        x-transition:leave-end="opacity-0"></div>
                                                    <div
                                                        class="relative w-full max-w-lg origin-top rounded-lg bg-white transition-all duration-300 dark:bg-navy-700"
                                                        x-show="showModal" x-transition:enter="easy-out"
                                                        x-transition:enter-start="opacity-0 scale-95"
                                                        x-transition:enter-end="opacity-100 scale-100"
                                                        x-transition:leave="easy-in"
                                                        x-transition:leave-start="opacity-100 scale-100"
                                                        x-transition:leave-end="opacity-0 scale-95">
                                                        <div
                                                            class="flex justify-between rounded-t-lg bg-slate-200 px-4 py-3 dark:bg-navy-800 sm:px-5">
                                                            <h3
                                                                class="text-base font-medium text-slate-700 dark:text-navy-100">
                                                                فتح ملف
                                                            </h3>
                                                            <button @click="showModal = !showModal"
                                                                    class="btn -ml-1.5 h-7 w-7 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                     class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24"
                                                                     stroke="currentColor" stroke-width="2">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                          d="M6 18L18 6M6 6l12 12"></path>
                                                                </svg>
                                                            </button>
                                                        </div>

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
                                                                <form class="mega-vertical"
                                                                      action="{{route('to_ex_alert')}}" method="post"
                                                                      enctype="multipart/form-data">
                                                                    @csrf

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

                                                                    <div class=" space-x-reverse space-x-2 text-right">
                                                                        <button @click="showModal = false"
                                                                                type="submit"
                                                                                class="btn min-w-[7rem] rounded-full border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                                                                            حفظ وتحويل لأعلان التنفيذ
                                                                        </button>

                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                        <br>
                                        <div x-data="{showModal:false}">
                                            <button @click="showModal = true"
                                                    class="btn bg-slate-150 font-medium text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">
                                                الرجوع الى العملاء المتاخرين
                                            </button>

                                            <template x-teleport="#x-teleport-target">
                                                <div
                                                    class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
                                                    x-show="showModal" role="dialog"
                                                    @keydown.window.escape="showModal = false">
                                                    <div
                                                        class="absolute inset-0 bg-slate-900/60 transition-opacity duration-300"
                                                        @click="showModal = false" x-show="showModal"
                                                        x-transition:enter="ease-out"
                                                        x-transition:enter-start="opacity-0"
                                                        x-transition:enter-end="opacity-100"
                                                        x-transition:leave="ease-in"
                                                        x-transition:leave-start="opacity-100"
                                                        x-transition:leave-end="opacity-0"></div>
                                                    <div
                                                        class="relative w-full max-w-lg origin-top rounded-lg bg-white transition-all duration-300 dark:bg-navy-700"
                                                        x-show="showModal" x-transition:enter="easy-out"
                                                        x-transition:enter-start="opacity-0 scale-95"
                                                        x-transition:enter-end="opacity-100 scale-100"
                                                        x-transition:leave="easy-in"
                                                        x-transition:leave-start="opacity-100 scale-100"
                                                        x-transition:leave-end="opacity-0 scale-95">
                                                        <div
                                                            class="flex justify-between rounded-t-lg bg-slate-200 px-4 py-3 dark:bg-navy-800 sm:px-5">
                                                            <h3
                                                                class="text-base font-medium text-slate-700 dark:text-navy-100">
                                                                رجوع للمتاخرين
                                                            </h3>
                                                            <button @click="showModal = !showModal"
                                                                    class="btn -ml-1.5 h-7 w-7 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                     class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24"
                                                                     stroke="currentColor" stroke-width="2">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                          d="M6 18L18 6M6 6l12 12"></path>
                                                                </svg>
                                                            </button>
                                                        </div>

                                                        <div class="px-4 py-4 sm:px-5">
                                                            <div class="mt-4 space-y-4">

                                                                <form class="mega-vertical"
                                                                      action="{{route('return_to_lated')}}"
                                                                      method="post"
                                                                      enctype="multipart/form-data">
                                                                    @csrf

                                                                    <input type="hidden" name="military_affairs_id"
                                                                           value="{{htmlspecialchars($data_military[0]['id'])}}">


                                                                    <label class="block">
                                                                        <span>     السبب</span>
                                                                        <textarea name="return_reason"
                                                                                  class="form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                                                        >

                                                                           </textarea>

                                                                    </label>

                                                                    <div class=" space-x-reverse space-x-2 text-right">
                                                                        <button @click="showModal = false"
                                                                                type="submit"
                                                                                class="btn min-w-[7rem] rounded-full border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                                                                            حفظ وتحويل للمتاخرين
                                                                        </button>

                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <h5>{{$item->court->name_ar}} </h5>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <div x-data="{showModal:false}">
                                            <button @click="showModal = true"
                                                    class="btn bg-slate-150 font-medium text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">
                                                تفاصيل الملف
                                            </button>

                                            <template x-teleport="#x-teleport-target">
                                                <div
                                                    class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
                                                    x-show="showModal" role="dialog"
                                                    @keydown.window.escape="showModal = false">
                                                    <div
                                                        class="absolute inset-0 bg-slate-900/60 transition-opacity duration-300"
                                                        @click="showModal = false" x-show="showModal"
                                                        x-transition:enter="ease-out"
                                                        x-transition:enter-start="opacity-0"
                                                        x-transition:enter-end="opacity-100"
                                                        x-transition:leave="ease-in"
                                                        x-transition:leave-start="opacity-100"
                                                        x-transition:leave-end="opacity-0"></div>
                                                    <div
                                                        class="relative w-full origin-top rounded-lg bg-white transition-all duration-300 dark:bg-navy-700"
                                                        x-show="showModal" x-transition:enter="easy-out"
                                                        x-transition:enter-start="opacity-0 scale-95"
                                                        x-transition:enter-end="opacity-100 scale-100"
                                                        x-transition:leave="easy-in"
                                                        x-transition:leave-start="opacity-100 scale-100"
                                                        x-transition:leave-end="opacity-0 scale-95">
                                                        <div
                                                            class="flex justify-between rounded-t-lg bg-slate-200 px-4 py-3 dark:bg-navy-800 sm:px-5">
                                                            <h3
                                                                class="text-base font-medium text-slate-700 dark:text-navy-100">
                                                                تفاصيل الملف </h3>

                                                            @php

                                                                $notes=  get_all_notes('execute_alert',htmlspecialchars($data_military[0]['id']));
                                                            @endphp


                                                            <button @click="showModal = !showModal"
                                                                    class="btn -ml-1.5 h-7 w-7 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                     class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24"
                                                                     stroke="currentColor" stroke-width="2">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                          d="M6 18L18 6M6 6l12 12"></path>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <div class="px-4 py-4 sm:px-5">


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
                                                                                    <tbody>
                                                                                    @foreach($notes  as  $note)

                                                                                        <tr
                                                                                            class="border border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                                                            <td
                                                                                                class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                                                                {{$note->created_by}}
                                                                                            </td>
                                                                                            <td
                                                                                                class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                                                                {{$note->type}}
                                                                                            </td>
                                                                                            <td
                                                                                                class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                                                                {{$note->note}}
                                                                                            </td>
                                                                                            <td
                                                                                                class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                                                                {{date($note->date)}}
                                                                                            </td>
                                                                                            <td
                                                                                                class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                                                                217
                                                                                            </td>
                                                                                        </tr>
                                                                                    @endforeach
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                        <div x-show="activeTab === 'tabProfile'"
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
                                                                                            المسئول
                                                                                        </th>
                                                                                        <th
                                                                                            class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                                                                                            القسم
                                                                                        </th>
                                                                                        <th
                                                                                            class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                                                                                            تاريخ البدء
                                                                                        </th>
                                                                                        <th
                                                                                            class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                                                                                            تاريخ الانتهاء
                                                                                        </th>
                                                                                        <th
                                                                                            class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                                                                                            عدد الايام
                                                                                        </th>
                                                                                    </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                    @foreach($notes  as  $note)

                                                                                        <tr
                                                                                            class="border border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                                                            <td
                                                                                                class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                                                                {{$note->created_by}}
                                                                                            </td>
                                                                                            <td
                                                                                                class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                                                                {{$note->type}}
                                                                                            </td>

                                                                                            <td
                                                                                                class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                                                                {{$note->date_start}}
                                                                                                <br>
                                                                                                {{$note->date_end  ? $note->date_end  :   date('Y-m-d') }}
                                                                                            </td>
                                                                                            <td
                                                                                                @php
                                                                                                     $datetime1 = date_create('2016-09-01');
                                                                                                     $datetime2 = date_create('2016-09-21');
                                                                                                     $interval = date_diff($datetime1, $datetime2);
                                                                                                      $day= $interval->format('%d'.'يوم');
                                                                                                      $year= $interval->format('%m'.'شهر');
                                                                                                      $months= $interval->format('%y'.'سنة');

                                                                                                @endphp

                                                                                                class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                                                                  {{$day}}
                                                                                            </td>
                                                                                        </tr>
                                                                                    @endforeach

                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>

                                                                <div class="space-x-reverse space-x-2 text-right">
                                                                    <button @click="showModal = false"
                                                                            class="btn min-w-[7rem] rounded-full border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                                                                        اغلاق
                                                                    </button>

                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div
                    class="flex flex-col justify-between space-y-4 px-4 py-4 sm:flex-row sm:items-center sm:space-y-0 sm:px-5">
                    <div class="flex items-center space-x-2 space-x-reverse text-xs+">
                        <span>Show</span>
                        <label class="block">
                            <select
                                class="form-select rounded-full border border-slate-300 bg-white px-2 py-1 pl-6 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                                <option>10</option>
                                <option>30</option>
                                <option>50</option>
                            </select>
                        </label>
                        <span>entries</span>
                    </div>

                    <ol class="pagination">
                        <li class="rounded-r-lg bg-slate-150 dark:bg-navy-500">
                            <a href="#"
                               class="flex h-8 w-8 items-center justify-center rounded-lg text-slate-500 transition-colors hover:bg-slate-300 focus:bg-slate-300 active:bg-slate-300/80 dark:text-navy-200 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </li>
                        <li class="bg-slate-150 dark:bg-navy-500">
                            <a href="#"
                               class="flex h-8 min-w-[2rem] items-center justify-center rounded-lg px-3 leading-tight transition-colors hover:bg-slate-300 focus:bg-slate-300 active:bg-slate-300/80 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">1</a>
                        </li>
                        <li class="bg-slate-150 dark:bg-navy-500">
                            <a href="#"
                               class="flex h-8 min-w-[2rem] items-center justify-center rounded-lg bg-primary px-3 leading-tight text-white transition-colors hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">2</a>
                        </li>
                        <li class="bg-slate-150 dark:bg-navy-500">
                            <a href="#"
                               class="flex h-8 min-w-[2rem] items-center justify-center rounded-lg px-3 leading-tight transition-colors hover:bg-slate-300 focus:bg-slate-300 active:bg-slate-300/80 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">3</a>
                        </li>
                        <li class="bg-slate-150 dark:bg-navy-500">
                            <a href="#"
                               class="flex h-8 min-w-[2rem] items-center justify-center rounded-lg px-3 leading-tight transition-colors hover:bg-slate-300 focus:bg-slate-300 active:bg-slate-300/80 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">4</a>
                        </li>
                        <li class="bg-slate-150 dark:bg-navy-500">
                            <a href="#"
                               class="flex h-8 min-w-[2rem] items-center justify-center rounded-lg px-3 leading-tight transition-colors hover:bg-slate-300 focus:bg-slate-300 active:bg-slate-300/80 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">5</a>
                        </li>
                        <li class="rounded-l-lg bg-slate-150 dark:bg-navy-500">
                            <a href="#"
                               class="flex h-8 w-8 items-center justify-center rounded-lg text-slate-500 transition-colors hover:bg-slate-300 focus:bg-slate-300 active:bg-slate-300/80 dark:text-navy-200 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M15 19l-7-7 7-7"/>
                                </svg>
                            </a>
                        </li>
                    </ol>

                    <div class="text-xs+">1 - 10 of 10 entries</div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {


            if (window.location.href.includes('governorate_id')) {

            }

            var pathname = window.location; // Returns path only (/path/example.html)

            // alert(pathname);
        });


    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>

@endsection
