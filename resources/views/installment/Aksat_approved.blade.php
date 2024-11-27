@extends('header.index')
@section('title', 'تقديم')

@section('content')

    <!-- Main Content Wrapper -->
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
        <div class="card-custom block ">

            <form action="{{ route('installment.store_approved') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-custom block">
                    <input type="hidden" name="installment_clients" value="{{ $Installment_Client->id }}" />
                    <div class="flex">
                        <label class="block w-full mx-1">
                            مبلغ الموافقة (التكلفة) (1000.000 د.ك )
                            <input
                                class="form-input w-full  rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                placeholder="مبلغ الموافقة" type="text" onchange="calculate();" id="cost_install"
                                name="cost_install"
                                value="{{ number_format($Installment_Client->cost_install, '3', '.', '') }}" />
                        </label>

                        <input onchange="calculate();" type="hidden" name="price_cost" id="price_cost"
                            value="{{ $Installment_Client->accept_cost }}" class="form-control">
                        <input onchange="calculate();" type="hidden" name="rate" class="form-control" id="rate"
                            value="{{ $Installment_Client->accept_cost }}">

                        <div style=" display: none;" class="col-md-3">
                            <h5 class="m-t-30 m-b-10"> المبلغ المتبقي</h5>
                            <input onchange="calculate();" type="text" name="reminder_amount" class="form-control"
                                id="reminder_amount" value="">

                        </div>
                        <div class="col-md-3" style=" display: none;">
                            <h5 class="m-t-30 m-b-10"> </h5>
                            <input onchange="calculate();" type="text"
                                value="{{ $Installment_Client->cinet_installments_total }}" name="cinet_amount_limit"
                                id="cinet_amount_limit" class="form-control">

                        </div>
                        <label class="block w-full mx-1">
                            المقدم
                            <input
                                class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                placeholder="المقدم" type="text" value="0.000" onchange="calculate();" id="part"
                                name="part" />
                        </label>
                        <label class="block w-full mx-1">
                            المبلغ المقسط
                            <input
                                class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                placeholder="المبلغ المقسط" onchange="calculate();" id="final_installment_amount"
                                type="text" name="final_installment_amount" />
                        </label>
                        <label class="block w-full mx-1">
                            عدد الاقساط
                            <input
                                class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                placeholder="عدد الاقساط" onchange="calculate();" id="count_months" type="text"
                                list="aksat" name="count_months" />
                            <datalist id="aksat">
                                <option value="36">36 شهر (200.0 %)</option>
                                <option value="35">35 شهر (200.0 %)</option>
                                <option value="34">34 شهر (200.0 %)</option>
                                <option value="33">33 شهر (200.0 %)</option>
                                <option value="32">32 شهر (200.0 %)</option>
                                <option value="31">31 شهر (200.0 %)</option>
                                <option value="30">30 شهر (200.0 %)</option>
                                <option value="29">29 شهر (200.0 %)</option>
                                <option value="28">28 شهر (200.0 %)</option>
                                <option value="27">27 شهر (200.0 %)</option>
                                <option value="26">26 شهر (200.0 %)</option>
                                <option value="25">25 شهر (200.0 %)</option>
                                <option value="24">24 شهر (200.0 %)</option>
                            </datalist>
                        </label>
                    </div>
                    <div class="flex">
                        <label class="block w-full mx-1">
                            شهور بدون نسبة
                            <input
                                class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                placeholder="شهور بدون نسبة" onchange="calculate();" id="count_months_without"
                                type="text" list="without_aksat" name="count_months_without" />
                            <datalist id="without_aksat">
                                <option value="36">36 شهر</option>
                                <option value="35">35 شهر</option>
                                <option value="34">34 شهر</option>
                                <option value="33">33 شهر</option>
                                <option value="32">32 شهر</option>
                                <option value="31">31 شهر</option>
                                <option value="30">30 شهر</option>
                                <option value="29">29 شهر</option>
                                <option value="28">28 شهر</option>
                                <option value="27">27 شهر</option>
                                <option value="26">26 شهر</option>
                                <option value="25">25 شهر</option>
                                <option value="24">24 شهر</option>
                            </datalist>
                        </label>
                        <label class="block w-full mx-1">
                            اجمالى المبلغ المقسط
                            <input
                                class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                placeholder="اجمالى المبلغ المقسط" onchange="calculate();" id="total" type="text"
                                name="total" />
                        </label>
                        <label class="block w-full mx-1">
                            القسط الشهرى
                            <input
                                class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                placeholder="القسط الشهرى" onchange="calculate();" id="monthly_amount" type="text"
                                name="monthly_amount" />
                        </label>
                        <label class="block w-full mx-1">
                            قسط الساينت
                            <input
                                class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                placeholder="قسط الساينت" onchange="calculate();" id="cinet_installment" type="text"
                                name="cinet_installment" />
                        </label>
                    </div>
                    <div class="flex">
                        <label class="block w-full mx-1">
                            القسط الداخلى
                            <input
                                class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                placeholder="القسط الداخلى" onchange="calculate();" id="intrenal_installment"
                                type="text" name="intrenal_installment" />
                        </label>
                        <label class="block w-full mx-1">
                            بداية اول قسط
                            <input
                                class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                placeholder="بداية اول قسط" type="text" list="start_kast" name="start_date" />
                            <datalist id="start_kast">
                                <option value="2024-10-28">2024-10-28</option>
                                <option value="2024-11-28">2024-11-28</option>
                                <option value="2024-12-28">2024-12-28</option>
                                <option value="2024-01-28">2024-01-28</option>
                                <option value="2024-02-28">2024-02-28</option>
                                <option value="2024-03-28">2024-03-28</option>
                                <option value="2024-04-28">2024-04-28</option>
                                <option value="2024-05-28">2024-05-28</option>
                                <option value="2024-06-28">2024-06-28</option>
                                <option value="2024-07-28">2024-07-28</option>
                                <option value="2024-08-28">2024-08-28</option>
                                <option value="2024-09-28">2024-09-28</option>
                            </datalist>
                        </label>

                    </div>

                </div>

                <div class="card-custom mt-5">

                    <div x-data="{ expandedItem: null }" class="mt-5 flex flex-col">
                        <div x-data="accordionItem('item-1')">
                            <div @click="expanded = !expanded"
                                class="flex cursor-pointer items-center py-4 text-base font-medium text-slate-700 dark:text-navy-100">
                                <p>البيانات االشخصية <span style="color: rgb(176, 176, 176);">( قم بالضغط هنا لاظهار
                                        البيانات الشخصية)</span></p>
                                <h4>نظام الأقساط</h4>
                                <div :class="expanded && '-rotate-180'"
                                    class="text-sm font-normal leading-none text-slate-400 transition-transform duration-300 dark:text-navy-300">
                                    <i class="fas fa-chevron-down mx-1"></i>
                                </div>
                            </div>
                            <div x-collapse x-show="expanded">
                                <div>
                                    <div class="is-scrollbar-hidden min-w-full overflow-x-auto">
                                        <table class="w-full text-right">
                                            <tbody>
                                                <tr
                                                    class="border border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                    <th
                                                        class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                                                        الاسم
                                                    </th>
                                                    <td>{{ $Installment_Client->name_ar }}
                                                </tr>
                                                <tr
                                                    class="border border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                    <th
                                                        class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                                                        الرقم المدني
                                                    </th>
                                                    <td>{{ $Installment_Client->civil_number }}

                                                </tr>
                                                <tr
                                                    class="border border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                    <th
                                                        class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                                                        الهاتف </th>
                                                    <td>{{ $Installment_Client->phone }}

                                                </tr>
                                                <tr
                                                    class="border border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                    <th
                                                        class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                                                        البنك
                                                    </th>
                                                    <td> {{ $Installment_Client->bank->name_ar }}

                                                </tr>
                                                <tr
                                                    class="border border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                    <th
                                                        class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                                                        المحافظة
                                                    </th>
                                                    <td> {{ $Installment_Client->governorate->name_ar }}

                                                </tr>
                                                <tr
                                                    class="border border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                    <th
                                                        class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                                                        جهة العمل
                                                    </th>
                                                    <td> {{ $Installment_Client->ministry_working->name_ar }}

                                                </tr>
                                                <tr
                                                    class="border border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                    <th
                                                        class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                                                        مجموع الأقساط </th>
                                                    <td> {{ $Installment_Client->installment_total }}

                                                </tr>
                                                <tr
                                                    class="border border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                    <th
                                                        class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                                                        مجموع مديونية الساينت </th>
                                                    <td> {{ $Installment ? $Installment->total_madionia : 'لا يوجد' }}

                                                </tr>
                                                <tr
                                                    class="border border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                    <th
                                                        class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                                                        الوسيط </th>
                                                    <td> {{ $Installment_Client->Boker->name_ar }}

                                                </tr>
                                                <tr
                                                    class="border border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                    <th
                                                        class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                                                        جهة الدخل ( 1 ) </th>
                                                    <td>
                                                        <div class="block">
                                                            <h1> {{ $Installment_Client->ministry_working->name_ar }}</h1>

                                                        </div>

                                                </tr>
                                                <tr
                                                    class="border border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                    <th
                                                        class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                                                        الراتب (1) </th>
                                                    <td> {{ $Installment_Client->salary }}

                                                </tr>
                                                <tr
                                                    class="border border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                    <th
                                                        class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                                                        اجمالي الدخل </th>
                                                    <td> 2068.000

                                                </tr>
                                                <tr
                                                    class="border border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                    <th
                                                        class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                                                        القسط المسموح </th>
                                                    <td> 2068.000

                                                </tr>
                                                <tr
                                                    class="border border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                    <th
                                                        class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                                                        القرض المسموح </th>
                                                    <td> 2068.000

                                                </tr>

                                                <tr
                                                    class="border border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                    <th
                                                        class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                                                        عدد الملفات المفتوحة </th>
                                                    <td> 55

                                                </tr>
                                                <tr
                                                    class="border border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                    <th
                                                        class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                                                        اقرار دين </th>
                                                    <td> <input
                                                            class="form-checkbox is-basic h-5 w-5 rounded border-slate-400/70 checked:bg-primary checked:border-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:bg-accent dark:checked:border-accent dark:hover:border-accent dark:focus:border-accent"
                                                            type="checkbox" name="eqrar_dain" /> </td>
                                                </tr>
                                                <tr
                                                    class="border border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                    <th
                                                        class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                                                        دخول الساينت </th>
                                                    <td> <input
                                                            class="form-checkbox is-basic h-5 w-5 rounded border-slate-400/70 checked:bg-primary checked:border-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:bg-accent dark:checked:border-accent dark:hover:border-accent dark:focus:border-accent"
                                                            type="checkbox" name="cinet_enter" /> </td>
                                                </tr>
                                                <tr
                                                    class="border border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                    <th
                                                        class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                                                        وصل امانة </th>
                                                    <td> <input
                                                            class="form-checkbox is-basic h-5 w-5 rounded border-slate-400/70 checked:bg-primary checked:border-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:bg-accent dark:checked:border-accent dark:hover:border-accent dark:focus:border-accent"
                                                            type="checkbox" name="amana_paper" /> </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <button type="submit"
                    class="btn mt-5 bg-info font-medium text-white hover:bg-info-focus focus:bg-info-focus active:bg-info-focus/90">
                    موافقة
                </button>
            </form>
            <div class="card-custom mt-5">
                <div x-data="{ expandedItem: null }" class="mt-5 flex flex-col">
                    <div x-data="accordionItem('item-1')">
                        <div @click="expanded = !expanded"
                            class="flex cursor-pointer items-center py-4 text-base font-medium text-slate-700 dark:text-navy-100">
                            <p> ملفات الساينت <span style="color: rgb(176, 176, 176);">( قم بالضغط هنا لاظهار
                                    ملفات الساينت)</span></p>
                            <!-- <h4> ملفات ال</h4> -->
                            <div :class="expanded && '-rotate-180'"
                                class="text-sm font-normal leading-none text-slate-400 transition-transform duration-300 dark:text-navy-300">
                                <i class="fas fa-chevron-down mx-1"></i>
                            </div>
                        </div>
                        <div x-collapse x-show="expanded">
                            <div class="is-scrollbar-hidden min-w-full overflow-x-auto">
                                <table class="w-full text-right">
                                    <thead>
                                        <tr class="border border-transparent border-b-slate-200 dark:border-b-navy-500">
                                            <th
                                                class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                                                #
                                            </th>
                                            <th
                                                class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                                                الجهة
                                            </th>
                                            <th
                                                class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                                                تاريخ فتح حساب
                                            </th>
                                            <th
                                                class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                                                الرصيد المتبقي
                                            </th>
                                            <th
                                                class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                                                قيمة القسط
                                            </th>
                                            <th
                                                class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                                                قيمة المديونية
                                            </th>
                                            <th
                                                class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                                                فتره السداد
                                            </th>
                                            <th
                                                class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                                                مبلغ القرض
                                            </th>
                                            <th
                                                class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                                                إعادة الجدولة
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($Installment_Client_cinet as $item)
                                            <tr
                                                class="border border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">{{ $loop->iteration }}
                                                </td>
                                                <td class="whitespace-nowrap px-4 py-3 sm:px-5"> {{ $item->file_dis_1 }}
                                                </td>
                                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                    {{ $item->file_date_1 }}
                                                </td>
                                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                    {{ $item->file_remindes_amount_1 }}</td>
                                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                    {{ $item->file_installment_amount_1 }} </td>
                                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                    {{ $item->file_debit_amount_1 }} </td>
                                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                    {{ $item->file_all_times_1 }}</td>
                                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                    {{ $item->new_loan_amount_1 }} </td>
                                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                    {{ $item->new_loan_date_1 }} شهر
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- cars --}}
            <div class="card-custom mt-5">
                <div x-data="{ expanded1: false }" class="mt-5 flex flex-col">
                    <div>
                        <div @click="expanded1 = !expanded1"
                            class="flex cursor-pointer items-center py-4 text-base font-medium text-slate-700 dark:text-navy-100">
                            <p> سيارات <span style="color: rgb(176, 176, 176);">( قم بالضغط هنا لاظهار
                                    السيارات)</span></p>
                            <div :class="expanded1 && '-rotate-180'"
                                class="text-sm font-normal leading-none text-slate-400 transition-transform duration-300 dark:text-navy-300">
                                <i class="fas fa-chevron-down mx-1"></i>
                            </div>
                        </div>
                        <div x-collapse x-show="expanded1">
                            <div class="is-scrollbar-hidden min-w-full overflow-x-auto">
                                <table class="w-full text-right">
                                    <thead>
                                        <tr class="border border-transparent border-b-slate-200 dark:border-b-navy-500">
                                            <th
                                                class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                                                #
                                            </th>
                                            <th
                                                class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                                                النوع
                                            </th>
                                            <th
                                                class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                                                السنة
                                            </th>
                                            <th
                                                class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                                                متوسط السعر
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($Installment_Client_car as $item)
                                            <tr
                                                class="border border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">{{ $loop->iteration }}
                                                </td>
                                                <td class="whitespace-nowrap px-4 py-3 sm:px-5"> {{ $item->type_car }}
                                                </td>
                                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                    {{ $item->model_year }}
                                                </td>
                                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                    {{ $item->average_price }}</td>

                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- issues --}}
            <div class="card-custom mt-5">
                <div x-data="{ expanded2: false }" class="mt-5 flex flex-col">
                    <div>
                        <div @click="expanded2 = !expanded2"
                            class="flex cursor-pointer items-center py-4 text-base font-medium text-slate-700 dark:text-navy-100">
                            <p> القضايا <span style="color: rgb(176, 176, 176);">( قم بالضغط هنا لاظهار
                                    القضايا)</span></p>
                            <div :class="expanded2 && '-rotate-180'"
                                class="text-sm font-normal leading-none text-slate-400 transition-transform duration-300 dark:text-navy-300">
                                <i class="fas fa-chevron-down mx-1"></i>
                            </div>
                        </div>
                        <div x-collapse x-show="expanded2">
                            <div class="is-scrollbar-hidden min-w-full overflow-x-auto">
                                <table class="w-full text-right">
                                    <thead>
                                        <tr class="border border-transparent border-b-slate-200 dark:border-b-navy-500">
                                            <th
                                                class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                                                #
                                            </th>
                                            <th
                                                class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                                                رقم القضية
                                            </th>
                                            <th
                                                class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                                                الحالة
                                            </th>
                                            <th
                                                class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                                                الجهة
                                            </th>
                                            <th
                                                class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                                                المبلغ
                                            </th>
                                            <th
                                                class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                                                التاريخ
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($Installment_Client_issue as $item)
                                            <tr
                                                class="border border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">{{ $loop->iteration }}
                                                </td>
                                                <td class="whitespace-nowrap px-4 py-3 sm:px-5"> {{ $item->number_issue }}
                                                </td>
                                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                    @if ($item->status == 'open')
                                                        مفتوح
                                                    @else
                                                        مغلق
                                                    @endif
                                                </td>
                                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                    {{ $item->working_company }}</td>
                                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                    {{ $item->opening_amount }}</td>
                                                <td class="whitespace-nowrap px-4 py-3 sm:px-5"> {{ $item->date }}</td>

                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- notes --}}
            <div class="card-custom mt-5">
                <div x-data="{ expanded3: false }" class="mt-5 flex flex-col">
                    <div>
                        <div @click="expanded3 = !expanded3"
                            class="flex cursor-pointer items-center py-4 text-base font-medium text-slate-700 dark:text-navy-100">
                            <p> الملاحظات <span style="color: rgb(176, 176, 176);">( قم بالضغط هنا لاظهار
                                    الملاحظات)</span></p>
                            <div :class="expanded3 && '-rotate-180'"
                                class="text-sm font-normal leading-none text-slate-400 transition-transform duration-300 dark:text-navy-300">
                                <i class="fas fa-chevron-down mx-1"></i>
                            </div>
                        </div>
                        <div x-collapse x-show="expanded3">
                            <div class="is-scrollbar-hidden min-w-full overflow-x-auto">
                                <table class="w-full text-right">
                                    <thead>
                                        <tr class="border border-transparent border-b-slate-200 dark:border-b-navy-500">
                                            <th
                                                class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                                                #
                                            </th>
                                            <th
                                                class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                                                اليوزر
                                            </th>
                                            <th
                                                class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                                                الاتصال
                                            </th>
                                            <th
                                                class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                                                الساعة
                                            </th>
                                            <th
                                                class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                                                التاريخ
                                            </th>
                                            <th
                                                class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                                                الملاحظة
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($Installment_Client_note as $item)
                                            <tr
                                                class="border border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">{{ $loop->iteration }}
                                                </td>
                                                <td class="whitespace-nowrap px-4 py-3 sm:px-5"> {{ $item->created_by }}
                                                </td>
                                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">reply
                                                    {{ $item->reply }}
                                                </td>
                                                <td class="whitespace-nowrap px-4 py-3 sm:px-5"> {{ $item->time }}</td>
                                                <td class="whitespace-nowrap px-4 py-3 sm:px-5"> {{ $item->date }}</td>
                                                <td class="whitespace-nowrap px-4 py-3 sm:px-5"> {{ $item->note }}</td>

                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        </div>

        </div>

        </div>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // Function to update the installation cost
        function update_install_cost() {
            var total_prods_cost = parseFloat($('#total_prods_cost').val()) || 0;
            $('#cost_install').val(total_prods_cost.toFixed(3));
        }

        // Function to calculate installment values
        function calculate() {
            // Get the cost_install input value and parse it as a float
            let costInstall = parseFloat($('#cost_install').val());

            // Check if the parsed value is valid
            if (!isNaN(costInstall)) {
                // Update price_cost with the formatted cost_install value
                $('#price_cost').val(costInstall.toFixed(3));

                let priceCost = costInstall * 1000;
                let count_months = parseFloat($('#count_months').val()) || 0; // Default to 0 if NaN
                let total = parseFloat($('#total').val()) * 1000 || 0; // Default to 0 if NaN
                let final_installment_amount = priceCost;
                let part = parseFloat($('#part').val()) * 1000 || 0; // Default to 0 if NaN

                // If count_months is 0, use count_months_without
                if (count_months === 0) {
                    count_months = parseFloat($('#count_months_without').val()) || 0; // Default to 0 if NaN
                }

                let percent = count_months;
                let rate = (final_installment_amount * percent) / 100;
                let total_val = rate + final_installment_amount;

                // Update total value in the input
                $('#total').val(parseFloat(total_val / 1000).toFixed(3));

                // Calculate the monthly amount
                let monthly = parseFloat((total_val - part) / count_months).toFixed(3);
                $('#monthly_amount').val(monthly);

                // Calculate the installment reminder amount
                let install_reminder_val = count_months * parseFloat(monthly);
                $('#reminder_amount').val(parseFloat(install_reminder_val).toFixed(3));

                // Calculate extra part if applicable
                let extra_part = (costInstall * 1000) - (priceCost);
                extra_part = extra_part < 0 ? 0 : extra_part; // Set extra_part to 0 if it's negative

                // Update final installment and part values
                $('#final_installment_amount').val(parseFloat(final_installment_amount / 1000).toFixed(3));
                $('#part').val(parseFloat((total_val - install_reminder_val + extra_part) / 1000).toFixed(3));

                // Calculate cinet and internal installment based on limits
                let cinet_amount_limit = parseFloat($('#cinet_amount_limit').val()) * 1000 || 0; // Default to 0 if NaN
                let monthly_amount = parseFloat(monthly) * 1000 || 0; // Default to 0 if NaN

                if (monthly_amount > cinet_amount_limit) {
                    $('#cinet_installment').val(parseFloat(cinet_amount_limit / 1000).toFixed(3));
                    $('#intrenal_installment').val(parseFloat((monthly_amount - cinet_amount_limit) / 1000).toFixed(3));
                } else {
                    $('#cinet_installment').val(parseFloat(monthly).toFixed(3));
                    $('#intrenal_installment').val(parseFloat(0).toFixed(3));
                }
            } else {
                console.error("Invalid cost_install input"); // Log error if the input is invalid
            }
            return false; // Prevent default form submission
        }

        function check_currency(value, field) {
            // Check for currency formatting or validation (e.g., limit to 3 decimal places)
            if (!/^\d+(\.\d{0,3})?$/.test(value)) {
                alert("Please enter a valid amount up to 3 decimal places");
                document.getElementById(field).value = '';
            }
        }
    </script>

    <!-- <script>
        // Function to calculate values based on input changes
        function calculate() {
            const costInstall = parseFloat(document.getElementById("cost_install").value) || 0;
            const part = parseFloat(document.getElementById("part").value) || 0;
            const countMonths = parseFloat(document.getElementById("count_months").value) || 0;
            const countMonthsWithout = parseFloat(document.getElementById("count_months_without").value) || 0;


            // Total installment amount calculation
            const total = costInstall - part;
            document.getElementById("total").value = total.toFixed(3); // Format to 3 decimal places

            // Monthly amount calculation
            const monthlyAmount = total / (countMonths || 1); // Avoid division by zero
            document.getElementById("monthly_amount").value = monthlyAmount.toFixed(3);

            // Other calculations can follow here based on your business logic
        }


@endsection
