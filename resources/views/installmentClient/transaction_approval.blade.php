@extends('header.index')
@section('title', 'اعتماد المعاملة')
@section('content')


    <main class="main-content w-full px-[var(--margin-x)] pb-8" style="width: 88% !important;">

        <div class="card-custom block ">

            <div class="btn w-full bg-info font-medium text-right text-white focus:bg-info-focus active:bg-info-focus/90">
                سلة المنتجات
            </div>
            <div class="flex justify-around mt-3">
                <label class="block mx-1 mt-3">
                    <input type="radio" name="inputType" value="barcode" onclick="toggleInput('barcode')" />
                    الباركود
                </label>
                <label class="block mt-3 mx-1">
                    <input type="radio" name="inputType" value="serial" onclick="toggleInput('serial')" />
                    السريال نمبر
                </label>
                <button
                    class="btn mx-1 mt-2 bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90"
                    type="button" onclick="addItem(event)">
                    اضافة
                </button>
            </div>

            <div id="barcodeInput" class="hidden">
                <label class="block w-full mx-1">
                    الباركود
                    <input id="barcodeValue"
                        class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary"
                        placeholder="الباركود" type="text" />
                </label>
            </div>

            <div id="serialInput" class="hidden">
                <label class="block w-full mx-1">
                    السريال نمبر
                    <input id="serialValue"
                        class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary"
                        placeholder="السريال نمبر" type="text" />
                </label>
            </div>

            <hr class="mt-2">

            <div class="card mt-3">
                <div class="is-scrollbar-hidden min-w-full overflow-x-auto">
                    <table class="is-hoverable w-full text-right">
                        <thead>
                            <tr>
                                <th
                                class="whitespace-nowrap rounded-tr-lg bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800">
                                الرقم</th>
                                <th
                                    class="whitespace-nowrap rounded-tr-lg bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800">
                                    الصنف</th>
                                <th class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800">
                                    الرقم</th>
                                <th class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800">
                                    التكلفة</th>
                                <th class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800">
                                    السعر</th>
                                <th class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800">
                                    <i class="fa-solid fa-trash mx-2"></i>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="productTableBody">
                            <!-- Dynamic rows will be appended here -->
                        </tbody>
                    </table>
                </div>
            </div>


            <form action="{{ route('installmentApprove.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="installment_client_id" value={{ $data->id }}>
                <input type="hidden" name="products" id="productsData">
                <div class="card-custom block">
                    <div class="flex">
                        <label class="block w-full mx-1">
                            مبلغ الموافقة
                            <input onchange="calculate();"
                                class="form-input w-full  rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                placeholder="مبلغ الموافقة" type="text" value="{{ $data->cost_install }}" id="price_cost"
                                name="price_cost" readonly />
                        </label>
                        <label class="block w-full mx-1">
                            تكلفة البضاعة
                            <input onchange="calculate();"
                                class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                placeholder="تكلفة البضاعة" type="text" name="cost_install" id="cost_install" />
                        </label>
                        <label class="block w-full mx-1">
                            المقدم
                            <input onchange="calculate();"
                                class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                placeholder="المقدم" type="text" name="part" id="part" />
                        </label>
                        <label class="block w-full mx-1">
                            المقدم الاضافي
                            <input onchange="calculate();"
                                class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                placeholder="المقدم الاضافي" id="extra_first_amount" name="extra_first_amount" value="0"
                                type="text" />
                        </label>
                    </div>
                    <div class="flex">
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
                        <label class="block w-full mx-1">
                            المبلغ المقسط
                            <input onchange="calculate();"
                                class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                placeholder="المبلغ المقسط" type="text" name="total" id="total" readonly />
                        </label>
                        <label class="block w-full mx-1">
                            اجمالي المقدم
                            <input onchange="calculate();"
                                class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                placeholder="اجمالي المقدم" type="text" name="total_first_amount"
                                id="total_first_amount" />
                        </label>

                        <label class="block w-full mx-1">
                            اجمالي المبلغ المقسط
                            <input onchange="calculate();"
                                class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                placeholder="   اجمالي المبلغ المقسط" type="text" name="final_total" id="final_total"
                                readonly />
                        </label>


                    </div>
                    <div class="flex">
                        <label class="block w-full mx-1">
                            القسط الشهري
                            <input onchange="calculate();"
                                class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                placeholder=" القسط الشهري " type="text" name="monthly_amount" id="monthly_amount"
                                readonly />
                        </label>
                        <label class="block w-full mx-1">
                            قسط السينت
                            <input onchange="calculate();"
                                class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                placeholder="قسط السينت" type="text" name="cinet_installment" id="cinet_installment"
                                value="{{ $data->cinet_installment }}" />
                        </label>
                        <label class="block w-full mx-1">
                            القسط الداخلي
                            <input onchange="calculate();"
                                class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                placeholder="القسط الداخلي" name="intrenal_installment" id="intrenal_installment"
                                type="text" readonly />
                        </label>
                        <label class="block w-full mx-1">
                            بداية أول قسط

                            <select name="start_date"
                                class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                id="">
                                @for ($i = 0; $i < 3; $i++)
                                    @php
                                        $date = new DateTime($ministry->date); // Initialize with the original date
                                        $date->modify("+$i month"); // Increment month by $i

                                        // Check if the year changes, if so, reset to December of the current year
                                        if ($date->format('Y') != date('Y')) {
                                            $date = new DateTime(date('Y') . '-12-' . $date->format('d'));
                                        }
                                    @endphp
                                    <option value="{{ $date->format('Y-m-d') }}">{{ $date->format('d-m-Y') }}</option>
                                @endfor


                            </select>
                        </label>
                    </div>
                    <div class="flex">
                        <label class="block w-full mx-1">

                            دفع المقدم
                            <select name="first_amount_pay_type"
                                class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                id="first_amount_pay_type">
                                <option value="cash">كاش</option>
                                <option value="knet">كى نت</option>
                            </select>
                        </label>
                        <label class="block w-full mx-1">
                            مبلغ اقرار الدين
                            <input
                                class="form-input w-full rounded-lg border border-slate-300 my-2 bg-gray px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                placeholder=" مبلغ اقرار الدين" onchange="check_currency(this.value,'eqrardain_amount')"
                                name="eqrardain_amount" id="eqrardain_amount" value="" type="text" readonly />
                        </label>


                    </div>
                    <div class="flex">
                        <label class="block w-full mx-1">
                            الملاحظات
                            <input
                                class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                placeholder="  الملاحظات " type="text" name="notes" />
                        </label>

                    </div>
                    <div class="flex mt-3">
                        <button
                            class="btn mx-1 bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                            طباعة اقرار الدين
                        </button>
                        <button
                            class="btn mx-1 bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                            طباعة نموذج للموثق
                        </button>
                    </div>

                </div>
                <div class="card-custom mt-5">
                    <div class=" block mt-5">
                        <div class="flex">
                            <label class="block w-full mx-1">
                                الاسم
                                <input
                                    class="form-input w-full  rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder="الاسم " type="text" name="name_ar" readonly value="{{ $data->name_ar }}" />
                            </label>
                            <label class="block w-full mx-1">
                                الرقم المدني
                                <input
                                    class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder=" الرقم المدني" type="text" name="civil_number" readonly value="{{ $data->civil_number }}"/>
                            </label>

                        </div>
                        <div class="flex">
                            <label class="block w-full mx-1">
                                الاسم الاول (العربيه) <i class="fa-solid fa-star-of-life text-error fs-5"></i> <input
                                    class="form-input w-full  rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder=" الاسم الاول" type="text" name="first_name_ar" required/>
                            </label>
                            <label class="block w-full mx-1">
                                الاسم الثاني (العربيه) <i class="fa-solid fa-star-of-life text-error fs-5"></i><input
                                    class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder=" الاسم الثاني" type="text" name="second_name_ar" required />
                            </label>
                            <label class="block w-full mx-1">
                                الاسم الثالث (العربيه)<i class="fa-solid fa-star-of-life text-error fs-5"></i>
                                <input
                                    class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder="الاسم الثالث" type="text" name="third_name_ar" required />
                            </label>
                            <label class="block w-full mx-1">
                                الاسم الرابع (العربيه) <input
                                    class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder="الاسم الرابع " type="text" name="fourth_name_ar"   />
                            </label>

                        </div>
                        <div class="flex">
                            <label class="block w-full mx-1">
                                الاسم الخامس (العربيه) <input
                                    class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder="  الاسم الخامس" type="text" name="fifth_name_ar"/>
                            </label>
                            <label class="block w-full mx-1">
                                الاسم الاول (الانجليزية) <i class="fa-solid fa-star-of-life text-error fs-5"></i><input
                                    class="form-input w-full  rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder=" الاسم الاول" type="text" name="first_name_en" required  />
                            </label>
                            <label class="block w-full mx-1">
                                الاسم الثاني (الانجليزية) <i class="fa-solid fa-star-of-life text-error fs-5"></i><input
                                    class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder=" الاسم الثاني" type="text" name="second_name_en" required />
                            </label>
                            <label class="block w-full mx-1">
                                الاسم الثالث (الانجليزية) <i class="fa-solid fa-star-of-life text-error fs-5"></i>
                                <input
                                    class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder="الاسم الثالث" type="text" name="third_name_en" required />
                            </label>

                        </div>
                        <div class="flex">
                            <label class="block w-full mx-1">
                                الاسم الرابع (الانجليزية)
                                <input
                                    class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder="الاسم الرابع" type="text"  name="fourth_name_en"/>
                            </label>
                            <label class="block w-full mx-1">
                                الاسم الخامس (الانجليزية)
                                <input
                                    class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder="الاسم الخامس" type="text" name="fifth_name_en"/>
                            </label>
                            <label class="block w-full mx-1">
                                النوع
                                <input
                                    class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder=" النوع" type="text" list="gender" name="gender" required/>
                                <datalist id="gender">
                                    <option value="male">ذكر</option>
                                    <option value="female">انثي</option>
                                </datalist>
                            </label>
                            <label class="block w-full mx-1">
                                الجنسية
                                <select name="nationality"  class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent" id="">
                                    @foreach ($nationality as $item)
                                        <option value="{{ $item->id }}">{{ $item->name_ar }}</option>
                                    @endforeach
                                </select>
                            </label>
                        </div>

                        <div class="flex">
                            <label class="block w-full mx-1">
                                الهاتف <input
                                    class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder=" الهاتف" type="text" name="phone" required/>
                            </label>
                            <label class="block w-full mx-1">
                                هاتف العمل <input
                                    class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder=" هاتف العمل" type="text" name="phone_land" required/>
                            </label>
                            <label class="block w-full mx-1">
                                اسم اقرب شخص (1) <input
                                    class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder=" اسم اقرب شخص" type="text" name="nearist_phone1" required/>
                            </label>
                            <label class="block w-full mx-1">
                                هاتف اقرب شخص (1) <input
                                    class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder=" اسم اقرب شخص" type="text" name="phone_work1" required/>
                            </label>
                        </div>
                        <div class="flex">
                            <label class="block w-full mx-1">
                                اسم اقرب شخص (2) <input
                                    class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder=" اسم اقرب شخص" type="text" name="nearist_phone2"required/>
                            </label>
                            <label class="block w-full mx-1">
                                هاتف اقرب شخص (2) <input
                                    class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder=" هاتف اقرب شخص" type="text" name="phone_work2" required/>
                            </label>
                            <label class="block w-full mx-1">
                                المنطقة <input
                                    class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder="المنطقة" type="text" list="region" name="region" required/>
                                <datalist id="region">
                                    @foreach ($region as $item)
                                    <option value="{{ $item->id }}">{{ $item->name_ar }}</option>
                                    @endforeach


                                </datalist>
                            </label>
                            <label class="block w-full mx-1">
                                القطعة <input
                                    class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder=" القطعة  " type="text" name="block" required/>
                            </label>
                        </div>
                        <div class="flex">
                            <label class="block w-full mx-1">
                                شارع <input
                                    class="form-input w-full  rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder="  شارع" type="text" name="street" required/>
                            </label>
                            <label class="block w-full mx-1">
                                جادة <input
                                    class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder="  جادة" type="text" name="jada" required />
                            </label>
                            <label class="block w-full mx-1">
                                مبني
                                <input
                                    class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder="مبني " type="text" name="building" required/>
                            </label>
                            <label class="block w-full mx-1">
                                الدور <input
                                    class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder=" الدور " type="text" name="floor" required/>
                            </label>

                        </div>
                        <div class="flex">
                            <label class="block w-full mx-1">
                                رقم الشقه <input
                                    class="form-input w-full  rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder="  رقم الشقه" type="text" name="flat" required/>
                            </label>
                            <label class="block w-full mx-1">
                                رقم الالي <i class="fa-solid fa-star-of-life text-error fs-5"></i><input
                                    class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder=" رقم الالي" name="house_id" type="text" required/>
                            </label>
                            <label class="block w-full mx-1">
                                جهه العمل
                                <input
                                    class="form-input w-full rounded-lg border border-slate-300 my-2 bg-gray px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    value="{{ $data->ministry_working->name_ar }}" list="work" name="ministry_id" disabled/>


                            </label>
                            <label class="block w-full mx-1">
                                الراتب <input
                                    class="form-input w-full rounded-lg border border-slate-300 my-2 bg-gray px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder=" الراتب " type="text" name="Salary" required />
                            </label>

                        </div>
                        <div class="flex">
                            <label class="block w-full mx-1">
                                اسم البنك
                                <input
                                    class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder="   بنك" list="bank" name="bank"  required/>
                                <datalist id="bank">
                                    @foreach ($bank as $item)
                                    <option value="{{ $item->id }}"> {{ $item->name_ar }}</option>
                                    @endforeach

                                </datalist>
                            </label>
                            <label class="block w-full mx-1">
                                رقم الحساب البنكي <input
                                    class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder=" رقم الحساب البنكي" type="text" name="ipan" required/>
                            </label>

                            <label class="block w-full mx-1">
                                عنوان العمل <input
                                    class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder="   عنوان العمل" type="text" name="location" required/>
                            </label>
                            <label class="block w-full mx-1">
                                موقع كويك فيندر <i class="fa-solid fa-star-of-life text-error fs-5"></i><input
                                    class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder=" موقع كوين فيندر
                                " type="text" name="kwfinder" required/>
                            </label>

                        </div>
                        <div class="flex">
                            <label class="block w-full mx-1">
                                البريد الالكترونى <i class="fa-solid fa-star-of-life text-error fs-5"></i>
                                <input
                                    class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder="  البريد الالكترونى " type="text" name="email" required />
                            </label>

                        </div>

                        <div class="flex">
                            <label class="block w-full mx-1">
                                هويتي <i class="fa-solid fa-star-of-life text-error fs-5"></i>
                                <input
                                    class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder="" type="file" name="personal_image" />
                            </label>
                            <label class="block w-full mx-1">
                                هوية العمل <i class="fa-solid fa-star-of-life text-error fs-5"></i>
                                <input
                                    class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder="" type="file" name="work_image" />
                            </label>

                        </div>
                        {{-- <div class="flex">
                            <label class="block w-full mx-1">
                                صورة شهادة الراتب
                                <div
                                    class="w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent">
                                    <img src="../images/100x100.png" alt="" height="70px" width="70px">
                                </div>
                            </label>
                        </div> --}}

                        <div class="flex mt-3">
                            <label class="inline-flex items-center  space-x-reverse space-x-2">
                                <input
                                    class="form-checkbox is-basic h-5 w-5 rounded border-slate-400/70 checked:bg-primary checked:border-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:bg-accent dark:checked:border-accent dark:hover:border-accent dark:focus:border-accent"
                                    type="checkbox" name="checkbox"/>
                                <p>التحقق من هويتي <i class="fa-solid fa-star-of-life text-error fs-5"></i></p>

                            </label>
                        </div>
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
                                                <tr class="border border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                    <th
                                                        class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                                                        الاسم
                                                    </th>
                                                    <td>{{ $data->name_ar ?? 'لايوجد' }}
                                                </tr>
                                                <tr class="border border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                    <th
                                                        class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                                                        الرقم المدني
                                                    </th>
                                                    <td>{{ $data->civil_number ?? 'لايوجد' }}

                                                </tr>
                                                <tr class="border border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                    <th
                                                        class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                                                        الهاتف </th>
                                                    <td>{{ $data->phone ?? 'لايوجد' }}


                                                </tr>
                                                <tr class="border border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                    <th
                                                        class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                                                        البنك
                                                    </th>
                                                    <td>{{ $data->bank->name_ar ?? 'لايوجد' }}

                                                </tr>
                                                <tr class="border border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                    <th
                                                        class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                                                        المحافظة
                                                    </th>
                                                    <td> {{ $data->governorate->name_ar ?? 'لايوجد' }}


                                                </tr>
                                                <tr class="border border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                    <th
                                                        class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                                                        جهة العمل
                                                    </th>
                                                    <td> {{ $data->ministry_working->name_ar ?? 'لايوجد' }}



                                                </tr>
                                                <tr class="border border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                    <th
                                                        class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                                                        مجموع الأقساط </th>
                                                    <td> {{ $data->installment_total ?? 'لايوجد' }}




                                                </tr>
                                                <tr class="border border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                    <th
                                                        class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                                                        مجموع مديونية الساينت </th>
                                                    <td> {{ $total_cient ?? 'لايوجد' }}




                                                </tr>
                                                <tr class="border border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                    <th
                                                        class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                                                        الوسيط </th>
                                                    <td> {{ $data->Boker->name_ar ?? 'لايوجد' }}





                                                </tr>
                                                <tr class="border border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                    <th
                                                        class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                                                        جهة الدخل ( 1 ) </th>
                                                    <td>
                                                        <div class="block">
                                                            <h1> {{ $working->ministry->name_ar ?? 'لايوجد' }}</h1>
                                                            <a href="{{ $working->image ?? 'http://127.0.0.1:8000/' }}"
                                                                class="btn mt-5 mb-1 bg-info font-medium text-white hover:bg-info-focus focus:bg-info-focus active:bg-info-focus/90"
                                                                target="_blank">
                                                                الصورة
                                                                {{-- <img src="{{$working->image}}" alt="Thumbnail" style="width: 100px;"> --}}
                                                            </a>
                                                        </div>


                                                </tr>
                                                <tr class="border border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                    <th
                                                        class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                                                        الراتب (1) </th>
                                                    <td> {{ $working->salary ?? 'لايوجد' }}



                                                </tr>
                                                <tr class="border border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                    <th
                                                        class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                                                        اجمالي الدخل </th>
                                                    <td>{{ $data->installment_total   ?? 'لايوجد'}}



                                                </tr>
                                                <tr class="border border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                    <th
                                                        class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                                                        القسط المسموح </th>
                                                    <td> {{ $data->cinet_amount_limit ?? 'لايوجد' }}



                                                </tr>
                                                <tr class="border border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                    <th
                                                        class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                                                        القرض المسموح </th>
                                                    <td> {{ (intval($data->cinet_amount_limit ?? 0) * 122) ?: 'لايوجد' }}



                                                </tr>
                                                <tr class="border border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                    <th
                                                        class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                                                        ملف الساينت </th>
                                                    <td> <a href="{{ $data->cinet_pdf ?? 'http://127.0.0.1:8000/' }}"
                                                            class="btn mt-5 mb-1 bg-info font-medium text-white hover:bg-info-focus focus:bg-info-focus active:bg-info-focus/90"
                                                            target="_blank">
                                                            عرض الساينت
                                                            {{-- <img src="{{$working->image}}" alt="Thumbnail" style="width: 100px;"> --}}
                                                        </a>



                                                </tr>
                                                <tr class="border border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                    <th
                                                        class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                                                        عدد الملفات المفتوحة </th>
                                                    <td> {{ $cinetCount->count() ?? 'لايوجد' }}



                                                </tr>
                                                <tr class="border border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                    <th
                                                        class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                                                        اقرار دين </th>
                                                    <td class="block">

                                                        <div class="mx-1">
                                                            <label class="block w-full mx-1">
                                                                اضف ملف<i class="fa-solid fa-star-of-life text-error fs-5"></i>
                                                                <input
                                                                    class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                                                    placeholder="" name="qard_paper" type="file" required />
                                                            </label>
                                                        </div>
                                                        <div class="mx-1">
                                                            <label class="block w-full mx-1">
                                                                السنه<i class="fa-solid fa-star-of-life text-error fs-5"></i>
                                                                <input
                                                                    class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                                                    placeholder="" name="qard_year" type="text" required />
                                                            </label>
                                                        </div>
                                                        <div class="mx-1">
                                                            <label class="block w-full mx-1">
                                                                مكتب التوثيق<i
                                                                    class="fa-solid fa-star-of-life text-error fs-5"></i>
                                                                <input
                                                                    class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                                                    placeholder="    " name="qard_place" type="text" required/>
                                                            </label>
                                                        </div>
                                                        <div class="mx-1">
                                                            <label class="block w-full mx-1">
                                                                رقم المرجع<i class="fa-solid fa-star-of-life text-error fs-5"></i>
                                                                <input
                                                                    class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                                                    placeholder="    " type="text" name="qard_number" required />
                                                            </label>
                                                        </div>
                                                        <div class="mx-1">
                                                            <label class="block w-full mx-1">
                                                                الشروط و الاحكام<i
                                                                    class="fa-solid fa-star-of-life text-error fs-5"></i>
                                                                <textarea rows="4" name="rules" placeholder=" Enter Text"
                                                                    class="form-textarea w-full rounded-lg border border-slate-300 bg-transparent p-2.5 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent" required></textarea>
                                                            </label>
                                                        </div>


                                                </tr>
                                            </tbody>
                                        </table>
                                        <button type="submit"
                                            class="btn mt-5 bg-info font-medium text-white hover:bg-info-focus focus:bg-info-focus active:bg-info-focus/90">
                                            الاعتماد و رفع العقود
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </form>
        <div class="card-custom mt-5">
            <div x-data="{ expandedItem: null }" class="mt-5 flex flex-col">
                <div x-data="accordionItem('item-1')">
                    <div @click="expanded = !expanded"
                        class="flex cursor-pointer items-center py-4 text-base font-medium text-slate-700 dark:text-navy-100">
                        <p> ملفات الساينت <span style="color: rgb(176, 176, 176);">( قم بالضغط هنا لاظهار
                                البيانات الشخصية)</span></p>
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
                                    @foreach ($cinetCount as $item)
                                        <tr class="border border-transparent border-b-slate-200 dark:border-b-navy-500">
                                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">{{ $item->id ?? 'لايوجد' }}
                                            </td>
                                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                {{ $item->file_dis_1 ?? 'لايوجد' }}</td>
                                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                {{ $item->file_date_1 ?? 'لايوجد' }}
                                            </td>
                                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                {{ $item->file_remindes_amount_1 ?? 'لايوجد' }}</td>
                                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                {{ $item->file_installment_amount_1 ?? 'لايوجد' }} </td>
                                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                {{ $item->file_debit_amount_1 ?? 'لايوجد' }}</td>
                                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                {{ $item->file_all_times_1 ?? 'لايوجد' }}شهر </td>
                                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                {{ $item->new_loan_amount_1 ?? 'لايوجد' }} </td>
                                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                {{ $item->new_loan_date_1 ?? 'لايوجد' }} شهر
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
        </div>
    </main>
    <!-- Include jQuery from a CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>

        function toggleInput(type) {
            document.getElementById('barcodeInput').classList.add('hidden');
            document.getElementById('serialInput').classList.add('hidden');

            if (type === 'barcode') {
                document.getElementById('barcodeInput').classList.remove('hidden');
            } else if (type === 'serial') {
                document.getElementById('serialInput').classList.remove('hidden');
            }
        }
        const products = [];
        function addItem(event) {
            event.preventDefault();
            const barcodeValue = document.getElementById("barcodeValue").value;
            const serialValue = document.getElementById("serialValue").value;
            const barcodeSelected = !document.getElementById("barcodeInput").classList.contains("hidden");

            // Define the data to send
            const data = barcodeSelected ? {
                barcode: barcodeValue
            } : {
                serial: serialValue
            };

            // const params = { ...data, ...type };

            // AJAX request to Laravel controller
            fetch('/transfer/get_product_by_nymber?' + new URLSearchParams(data), {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                })
                .then(response => response.json())
                .then(data => {

                    console.log(data);

                    if (data.success) {
                        appendRow(data.product, barcodeSelected);
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => console.error('Error:', error));

            // Clear the input fields after adding
            document.getElementById("barcodeValue").value = "";
            document.getElementById("serialValue").value = "";
        }

        function appendRow(product, barcodeSelected) {
            const productTableBody = document.getElementById("productTableBody");

            const newRow = document.createElement("tr");
            newRow.className = "border-y border-transparent border-b-slate-200 dark:border-b-navy-500";

            newRow.innerHTML = `
            <td class="whitespace-nowrap py-3 sm:px-5">${product.id || 0 }</td>
                <td class="whitespace-nowrap py-3 sm:px-5">
                    <p>${product.model || 'الصنف'}</p>
                </td>
                 <td class="whitespace-nowrap py-3 sm:px-5">${product.number || 0 }</td>

                <td class="whitespace-nowrap py-3 sm:px-5 cost-cell">(${product.cost || 0} د . ك)</td>
                <td class="whitespace-nowrap py-3 sm:px-5">(${product.price || 0} د . ك)</td>
                <td class="whitespace-nowrap py-3 sm:px-5"><i class="fa-solid fa-trash mx-2" onclick="deleteRow(this)"></i></td>




            `;

            productTableBody.appendChild(newRow);
            products.push(product);
            document.getElementById('productsData').value = JSON.stringify(products);
            updateTotalCost();
        }

        function deleteRow(element) {
            const row = element.closest("tr");
            const index = Array.from(row.parentElement.children).indexOf(row);

            products.splice(index, 1); // remove from products array
            document.getElementById('productsData').value = JSON.stringify(products); // update hidden field

            row.remove();
            updateTotalCost();
        }

        function updateTotalCost() {
            const costCells = document.querySelectorAll('.cost-cell');
            let totalCost = 0;

            // Loop through each cost cell to sum up the values
            costCells.forEach(cell => {
                const costText = cell.innerText.replace(/[^0-9.]/g, ''); // Remove non-numeric characters
                const cost = parseFloat(costText) || 0;
                totalCost += cost;
            });

            // Update the total cost input field
            document.getElementById("cost_install").value = totalCost.toFixed(2);
        }
    </script>

    <script>
        // Function to calculate values based on input changes
        function calculate() {
            const extraFirstAmount = ($('#extra_first_amount').val()) * 1000;
            const countMonths = $('#count_months').val();
            const percent = parseFloat($('#asd_' + countMonths).attr('disc')) || 0;
            const costInstall = ($('#cost_install').val() || 0) * 1000;
            const total = ($('#total').val() || 0) * 1000;
            const priceCost = ($('#price_cost').val() || 0) * 1000;
            let finalInstallmentAmount = priceCost;
            $('#part').val('0');

            // Calculate the difference
            let difference = costInstall - priceCost;
            if (difference < 0) finalInstallmentAmount = costInstall;

            const effectiveMonths = countMonths == 0 ? $('#count_months_without').val() : countMonths;
            const rate = ((finalInstallmentAmount * percent) / 100).toFixed(3);
            $('#rate').val(rate);

            const totalValue = rate * 1000 + finalInstallmentAmount + extraFirstAmount;
            const part = $('#part').val() * 1000;
            const monthlyInstallment = ((totalValue - part - extraFirstAmount) / effectiveMonths / 1000).toFixed(3);
            $('#monthly_amount').val(monthlyInstallment);

            const firstRest = Math.floor(monthlyInstallment);
            const remainder = monthlyInstallment - firstRest;
            const totalRemaining = (remainder * effectiveMonths) * 1000;
            const totalFirstAmount = parseInt(totalRemaining + part).toFixed(0);
            const installmentRemainder = firstRest * effectiveMonths * 1000;
            $('#reminder_amount').val(parseFloat(installmentRemainder / 1000).toFixed(3));

            // Update final values
            const extraPart = (difference < 0) ? 0 : (costInstall - priceCost);
            $('#total').val(parseFloat((totalValue + extraPart) / 1000).toFixed(3));
            $('#final_installment_amount').val(parseFloat(finalInstallmentAmount / 1000).toFixed(3));
            $('#total_first_amount').val(parseFloat((totalValue - installmentRemainder + extraPart) / 1000).toFixed(3));
            $('#part').val(parseFloat((totalValue - installmentRemainder + extraPart - extraFirstAmount) / 1000).toFixed(
            3));
           // Calculate final total as a number to avoid string concatenation issues
            const finalTotal = parseFloat($('#total').val()) - parseFloat($('#total_first_amount').val());
            $('#final_total').val(finalTotal.toFixed(3));

            const cinetLimit = $('#cinet_amount_limit').val() * 1000;
            const internalInstallment = (monthlyInstallment * 1000 > cinetLimit) ? monthlyInstallment - (cinetLimit /
                1000) : 0;
            $('#cinet_installment').val((cinetLimit > monthlyInstallment * 1000 ? monthlyInstallment : cinetLimit / 1000)
                .toFixed(3));
            $('#intrenal_installment').val(internalInstallment.toFixed(3));

            const eqrarAmount = parseFloat(finalInstallmentAmount / 1000).toFixed(3);
            $('#eqrardain_amount').val(eqrarAmount);

            return false;
        }
        // function calculate() {
        //     //price_cost//cost_install/final_installment_amount
        //     var extra_first_amount = ($('#extra_first_amount').val()) * 1000;
        //     var count_months = $('#count_months').val();
        //     var percent = parseFloat($('#asd_' + count_months).attr('disc'));
        //     var cost_install = $('#cost_install').val();
        //     var total = $('#total').val();
        //     var final_installment_amount = ($('#final_installment_amount').val()) * 1000;
        //     var price_cost = ($('#price_cost').val()) * 1000;
        //     cost_install = cost_install * 1000;
        //     //alert(cost_install); alert(price_cost);
        //     var final_installment_amount = price_cost;
        //     $('#part').val('0');
        //     var the_diffrence = cost_install - price_cost;
        //     if (the_diffrence < 0) {
        //         var final_installment_amount = cost_install;
        //     }

        //     if (count_months == 0) {
        //         count_months = $('#count_months_without').val();
        //         percent = 0;
        //         //  alert(count_months);
        //         // alert(percent);
        //     }


        //     total = total * 1000;

        //     var rate = ((final_installment_amount * percent) / 100);


        //     var rate_2 = parseFloat(rate / 1000).toFixed(3);

        //     $('#rate').val(rate_2);

        //     // alert(extra_first_amount);
        //     var total_val = rate + final_installment_amount + extra_first_amount;
        //     // var total_val=rate+final_installment_amount ;
        //     //  alert(total_val);
        //     //$('#total').val(parseFloat(total_val/1000).toFixed(3));
        //     var part = $('#part').val();
        //     part = part * 1000;
        //     var total_part = parseInt(total_val) - parseInt(part) - extra_first_amount;
        //     // alert(total_part);
        //     var monthly = parseFloat(((total_part / count_months)) / 1000).toFixed(3);
        //     // alert(monthly);
        //     var first_rest = parseInt(monthly);
        //     //  alert(first_rest);

        //     var secound_rest = monthly.substring(monthly.indexOf("."));
        //     //  alert(secound_rest);
        //     var rest_before_total = (secound_rest * count_months);
        //     rest_before_total = rest_before_total * 1000;
        //     // alert(rest_before_total);
        //     var part_val = rest_before_total + part;

        //     part_val = parseFloat(part_val).toFixed(0);
        //     part_val = parseInt(part_val);

        //     var install_reminder_val = count_months * first_rest;

        //     $('#reminder_amount').val(parseFloat(install_reminder_val).toFixed(3));

        //     install_reminder_val = install_reminder_val * 1000;


        //     var extra_part = ($('#cost_install').val() * 1000) - ($('#price_cost').val() * 1000);
        //     if (the_diffrence < 0) {

        //         extra_part = 0;
        //     }
        //     //alert(extra_part);
        //     //alert(total_val); alert(install_reminder_val); alert(install_reminder_val);
        //     var install_reminder_2 = total_val - install_reminder_val;

        //     $('#total').val(parseFloat((total_val + extra_part) / 1000).toFixed(3));
        //     //final_total
        //     // alert(install_reminder_val);alert(install_reminder_2);
        //     // price_cost/sale_price
        //     //var extra_part =parseFloat((($('#cost_install').val()*1000)-($('#price_cost').val()*1000))/1000).toFixed(3);

        //     // alert(final_installment_amount );
        //     if (the_diffrence < 0) {
        //         // var final_installment_amount = final_installment_amount-rest_before_total  ;
        //     }
        //     $('#final_installment_amount').val(parseFloat(final_installment_amount / 1000).toFixed(3));
        //     // alert(install_reminder_2); alert(extra_part); //alert(install_reminder_2);
        //     //  $('#part').val(parseFloat((install_reminder_2)/1000).toFixed(3));
        //     $('#total_first_amount').val(parseFloat((install_reminder_2 + extra_part) / 1000).toFixed(3));
        //     $('#part').val(parseFloat((install_reminder_2 + extra_part - extra_first_amount) / 1000).toFixed(3));
        //     //cinet_installment/intrenal_installment/cinet_amount_limit//monthly_amount
        //     $('#monthly_amount').val(parseFloat(first_rest).toFixed(3));
        //     var final_total = ((total_val + extra_part) - (install_reminder_2 + extra_part));
        //     $('#final_total').val(parseFloat(final_total / 1000).toFixed(3));

        //     var cinet_amount_limit = $('#cinet_amount_limit').val() * 1000;
        //     <?php if ($data->cinet_amount_limit < 1) {?>
        //     var cinet_amount_limit = 0;
        //     <?php }?>
        //     var monthly_amount = first_rest * 1000;
        //     // alert(monthly_amount);
        //     if (monthly_amount > cinet_amount_limit) {
        //         $('#cinet_installment').val(parseFloat(cinet_amount_limit / 1000).toFixed(3));
        //         $('#intrenal_installment').val(parseFloat((monthly_amount - cinet_amount_limit) / 1000).toFixed(3));
        //     } else {
        //         $('#cinet_installment').val(parseFloat(monthly_amount / 1000).toFixed(3));
        //         $('#intrenal_installment').val(parseFloat(0).toFixed(3));

        //     }
        //     // alert(extra_first_amount);   alert(total_val);
        //     //             var eqrardain_amount= total_val- extra_first_amount;
        //     //             var eqrardain_amount_25= (eqrardain_amount *25)/100  ;
        //     var eqrardain_amount = final_total;
        //     //var eqrardain_amount_25 = (final_total * 25) / 100;

        //     var eqrardain_amount_35 = eqrardain_amount;
        //     var eqrardain_amount_35 = Math.ceil((eqrardain_amount_35) / 1000);
        //     var eqrardain_amount_35 = parseFloat((eqrardain_amount_35)).toFixed(3);
        //     //alert( Math.ceil((eqrardain_amount_35)/1000));
        //     //  alert(eqrardain_amount); alert(eqrardain_amount_25);
        //     $('#eqrardain_amount').val(eqrardain_amount_35);
        //     //eqrardain_amount
        //     $('#eqrardain_link').attr("href",
        //         '${baseUrl}myinstall/aksat/print_eqrardain/<?php echo $data->id; ?>/' + eqrardain_amount_35);
        //     $('#eqrardain_motheq_link').attr("href", '${baseUrl}myinstall/aksat/print_eqrardain_mothaq/' +
        //         eqrardain_amount_35);


        //     return false;
        // }
    </script>

@endsection
