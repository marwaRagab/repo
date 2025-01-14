<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
      <h4 class="card-title mb-0"> سلة المنتجات</h4>
    </div>

  </div>


<div class="card ">
<div class="card-body">

    <div class="flex justify-around ">
        <label class="block mx-1">
            <input type="radio" name="inputType" value="barcode" onclick="toggleInput('barcode')" />
            الباركود
        </label>
        <label class="block mx-1">
            <input type="radio" name="inputType" value="serial" onclick="toggleInput('serial')" />
            السريال نمبر
        </label>
        <button
            class="btn mx-1  bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90"
            type="button" onclick="addItem(event)">
            اضافة
        </button>
    </div>

    <div id="barcodeInput" class="hidden">
        <label class=" mx-1">
            الباركود
            <input id="barcodeValue"
                class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary"
                placeholder="الباركود" type="text" />
        </label>
    </div>

    <div id="serialInput" class="hidden">
        <label class=" mx-1">
            السريال نمبر
            <input id="serialValue"
                class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary"
                placeholder="السريال نمبر" type="text" />
        </label>
    </div>
</div>
</div>
<div class="card">

<div class="card-body">
  <div class="table-responsive pb-4">
    <table  class="table table-bordered border text-nowrap align-middle">
      <thead>
        <!-- start row -->
             <tr>

            <th>
                الصنف</th>
            <th>
                السريال/الباركود</th>
            <th>
                التكلفة</th>
            <th>
                السعر</th>
            <th>
                <i class="ti ti-trash fs-5"></i>
                حذف
            </th>
        </tr>
        <!-- end row -->
      </thead>
      <tbody id="productTableBody">
        <!-- Dynamic rows will be appended here -->
    </tbody>
    </table>
  </div>
</div>
</div>

<form action="{{ route('installmentApprove.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="installment_client_id" value={{ $data->id }}>
    <input type="hidden" name="products" id="productsData">
<div class="card">


      <!-- General error messages -->
      {{-- @if ($errors->any())
      <div class="alert alert-danger">
          <ul>
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
  @endif --}}

<div class="card-body">
    <div class="form-row row pt-3">

        <div class="form-group mb-3 col-lg-4 col-md-6">
            <label class="form-label">
                مبلغ الموافقة
                <span class="text-danger">*</span>
            </label>
                <input onchange="calculate();"
                    class="form-input form-control"
                    placeholder="مبلغ الموافقة" type="text" value="{{ $data->cost_install }}" id="price_cost"
                    name="price_cost"  value="{{ old('price_cost') }}"/>

                    @error('price_cost')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
        </div>
            <!-- Field for cost_install -->
        <div class="form-group mb-3 col-lg-4 col-md-6">
            <label class="form-label">تكلفة البضاعة
                <span class="text-danger">*</span>
            </label>
            <input onchange="calculate();" class="form-input form-control" placeholder="تكلفة البضاعة" type="text"
                id="cost_install" name="cost_install" value="{{ old('cost_install',0) }}"/>

            @error('cost_install')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Field for part -->
        <div class="form-group mb-3 col-lg-4 col-md-6">
            <label class="form-label">المقدم
                <span class="text-danger">*</span>
            </label>
            <input onchange="calculate();" class="form-input form-control" placeholder="المقدم" type="text"
                id="part" name="part" value="{{ old('part',0) }}"/>

            @error('part')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>


        <div class="form-group mb-3 col-lg-4 col-md-6">
            <label class="form-label">المقدم الاضافي
                <span class="text-danger">*</span>
            </label>
            <input onchange="calculate();"
                class="form-input form-control"
                placeholder="المقدم الاضافي"
                type="text"
                id="extra_first_amount"
                name="extra_first_amount"
                value="{{ old('extra_first_amount', 0) }}" />

            @error('extra_first_amount')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3 col-lg-4 col-md-6">
            <label class="form-label">عدد الاقساط
                <span class="text-danger">*</span>
            </label>
            <select   id="count_months"  name="count_months" class="form-select" onchange="calculate();"  >
                <option value="36" selected>36 شهر (200.0 %)</option>
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
            </select>

            @error('count_months')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3 col-lg-4 col-md-6">
            <label class="form-label">المبلغ المقسط
                <span class="text-danger">*</span>
            </label>
            <input onchange="calculate();"
                class="form-input form-control"
                placeholder="المبلغ المقسط"
                type="text"
                name="total"
                id="total"

                value="{{ old('total',0) }}" />
               @error('total')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        {{--  --}}
        <div class="form-group mb-3 col-lg-4 col-md-6">
            <label class="form-label">اجمالي المقدم
                <span class="text-danger">*</span>
            </label>
            <input onchange="calculate();"
                class="form-input form-control"
                placeholder="اجمالي المقدم"
                type="text"
                name="total_first_amount"
                id="total_first_amount"

                value="{{ old('total_first_amount',0) }}" />
            @error('total_first_amount')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3 col-lg-4 col-md-6">
            <label class="form-label">
                اجمالي المبلغ المقسط
                <span class="text-danger">*</span>
            </label>
            <input onchange="calculate();"
                class="form-input form-control"
                placeholder="  اجمالي المبلغ المقسط"
                type="text"
                 name="final_total" id="final_total"

                value="{{ old('final_total',0) }}" />
            @error('final_total')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3 col-lg-4 col-md-6">
            <label class="form-label">
                القسط الشهري
                <span class="text-danger">*</span>
            </label>
            <input onchange="calculate();"
                class="form-input form-control"
                placeholder="   القسط الشهري"
                type="text"
                 name="monthly_amount"
                  id="monthly_amount"
                value="{{ old('monthly_amount',0) }}" />
            @error('monthly_amount')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group mb-3 col-lg-4 col-md-6">
            <label class="form-label">
                قسط السينت
                <span class="text-danger">*</span>
            </label>
            <input
                class="form-input form-control"
                type="text"
                 name="cinet_installment"
                  id="cinet_installment"
                value="{{ old('cinet_installment',$data->cinet_installment) }}" />
            @error('cinet_installment')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3 col-lg-4 col-md-6">
            <label class="form-label">
                القسط الداخلي
                <span class="text-danger">*</span>
            </label>
            <input
                class="form-input form-control"
                type="text"
                 name="intrenal_installment"
                  id="intrenal_installment"
                value="{{ old('intrenal_installment',$data->intrenal_installment) }}" />
            @error('intrenal_installment')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3 col-lg-4 col-md-6">
            <label class="form-label">
                بداية أول قسط
                <span class="text-danger">*</span>
            </label>
            @if ($ministry)
                <select name="start_date" class="form-control form-select">
                     @for ($i = 0; $i < 3; $i++)
                        @php
                           
                            // Get the current month and year
                            $currentDate = new DateTime(); // Use DateTime for current date
                            $currentDate->modify("+$i month"); // Increment month by $i
                            $currentYear = $currentDate->format('Y');
                            $currentMonth = $currentDate->format('m');

                            // Combine to form the display date
                            $displayDate = "$currentYear-$currentMonth-$ministry->date";

                            // Set the new date
                            $date = $displayDate;
                        @endphp
                        <option value="{{ $date }}">{{ $date }}</option>
                    @endfor
                </select>
            @else
                <p>No ministry data available.</p>
            @endif
            @error('start_date')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3 col-lg-4 col-md-6">
            <label class="form-label">
                دفع المقدم
                <span class="text-danger">*</span>
            </label>
            <select name="first_amount_pay_type"
                class="form-control form-select"
                id="first_amount_pay_type">
                <option value="cash">كاش</option>
                <option value="knet">كى نت</option>
            </select>
            @error('first_amount_pay_type')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3 col-lg-4 col-md-6">
            <label class="form-label">
                مبلغ اقرار الدين
                <span class="text-danger">*</span>
            </label>
            <input
                class="form-input form-control"
                placeholder="   مبلغ اقرار الدين"
                type="text"
                 name="eqrardain_amount"
                  id="eqrardain_amount"
                  onchange="check_currency(this.value,'eqrardain_amount')"
                value="{{ old('eqrardain_amount') }}" readonly />
            @error('eqrardain_amount')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3 col-lg-4 col-md-6">
            <label class="form-label">
                الملاحظات
                {{-- <span class="text-danger">*</span> --}}
            </label>
            <input
                class="form-input form-control"
                placeholder="الملاحظات"
                type="text"
                name="notes"
                id="notes"
                value="{{ old('notes') }}"  />
            @error('notes')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group mb-3 col-lg-5 col-md-7">
            <div class="d-flex flex wrap ">
                
                    <a href="{{url('installmentApprove/print_eqrardain/'.$data->id.'/'.'0.00')}}"
                        class="btn btn-primary mx-1">
                        طباعة اقرار الدين
                    </a>
               
                    <a  href="{{url('installmentApprove/print_eqrardain_mothaq/0.00')}}"
                        class="btn btn-primary mx-1">
                        طباعة نموذج للموثق
                    </a>
              
            </div>
        </div>


    </div>
</div>


<div class="card">

    <div class="card-body">

        <div class="form-row row pt-3">

            <div class="form-group mb-3 col-lg-4 col-md-6">
                <label class="form-label">
                    الاسم
                    <span class="text-danger">*</span>
                </label>
                <input
                    class="form-input form-control"
                    type="text"
                    name="name_ar"
                    id="name_ar"
                    value="{{ old('name_ar',$data->name_ar) }}"  />
                @error('name_ar')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3 col-lg-4 col-md-6">
                <label class="form-label">
                    الرقم المدني
                    <span class="text-danger">*</span>
                </label>
                <input
                    class="form-input form-control"
                    type="text"
                    name="civil_number"
                    id="civil_number"
                    value="{{ old('civil_number',$data->civil_number) }}"  />
                @error('civil_number')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3 col-lg-4 col-md-6">
                <label class="form-label">
                    الاسم الاول (العربيه)
                    <span class="text-danger">*</span>
                </label>
                <input
                    class="form-input form-control"
                    type="text"
                    name="first_name_ar"
                    id="first_name_ar"
                    value="{{ old('first_name_ar') }}" required />
                @error('first_name_ar')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3 col-lg-4 col-md-6">
                <label class="form-label">
                    الاسم الثاني (العربيه)
                    <span class="text-danger">*</span>
                </label>
                <input
                    class="form-input form-control"
                    type="text"
                    name="second_name_ar"
                    id="second_name_ar"
                    value="{{ old('second_name_ar') }}" required />
                @error('second_name_ar')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3 col-lg-4 col-md-6">
                <label class="form-label">
                    الاسم الثالث (العربيه)
                    <span class="text-danger">*</span>
                </label>
                <input
                    class="form-input form-control"
                    type="text"
                    name="third_name_ar"
                    id="third_name_ar"
                    value="{{ old('third_name_ar') }}" required />
                @error('third_name_ar')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3 col-lg-4 col-md-6">
                <label class="form-label">
                    الاسم الرابع (العربيه)
                    {{-- <span class="text-danger">*</span> --}}
                </label>
                <input
                    class="form-input form-control"
                    type="text"
                    name="fourth_name_ar"
                    id="fourth_name_ar"
                    value="{{ old('fourth_name_ar') }}"  />
                @error('fourth_name_ar')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3 col-lg-4 col-md-6">
                <label class="form-label">
                    الاسم الخامس (العربيه)
                    <!--<span class="text-danger">*</span>-->
                </label>
                <input
                    class="form-input form-control"
                    type="text"
                    name="fifth_name_ar"
                    id="fifth_name_ar"
                    value="{{ old('fifth_name_ar') }}" />
                @error('fifth_name_ar')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3 col-lg-4 col-md-6">
                <label class="form-label">
                    الاسم الاول (الانجليزية)
                    <span class="text-danger">*</span>
                </label>
                <input
                    class="form-input form-control"
                    type="text"
                    name="first_name_en"
                    id="first_name_en"
                    value="{{ old('first_name_en') }}" required />
                @error('first_name_en')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3 col-lg-4 col-md-6">
                <label class="form-label">
                    الاسم الثاني (الانجليزية)
                    <span class="text-danger">*</span>
                </label>
                <input
                    class="form-input form-control"
                    type="text"
                    name="second_name_en"
                    id="second_name_en"
                    value="{{ old('second_name_en') }}" required />
                @error('second_name_en')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3 col-lg-4 col-md-6">
                <label class="form-label">
                    الاسم الثالث (الانجليزية)
                    <span class="text-danger">*</span>
                </label>
                <input
                    class="form-input form-control"
                    type="text"
                    name="third_name_en"
                    id="third_name_en"
                    value="{{ old('third_name_en') }}" required />
                @error('third_name_en')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3 col-lg-4 col-md-6">
                <label class="form-label">
                    الاسم الرابع (الانجليزية)
                    {{-- <span class="text-danger">*</span> --}}
                </label>
                <input
                    class="form-input form-control"
                    type="text"
                    name="fourth_name_en"
                    id="fourth_name_en"
                    value="{{ old('fourth_name_en') }}"  />
                @error('fourth_name_en')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3 col-lg-4 col-md-6">
                <label class="form-label">
                    الاسم الخامس (الانجليزية)
                    <!--<span class="text-danger">*</span>-->
                </label>
                <input
                    class="form-input form-control"
                    type="text"
                    name="fifth_name_en"
                    id="fifth_name_en"
                    value="{{ old('fifth_name_en') }}" />
                @error('fifth_name_en')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3 col-lg-4 col-md-6">
                <label class="form-label">
                    النوع
                    <span class="text-danger">*</span>
                </label>
                <select id="gender" name="gender" class="form-select" required>
                    <option value ="">اختر</option>
                    <option value="male">ذكر</option>
                    <option value="female">انثي</option>
                </select>
                @error('gender')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3 col-lg-4 col-md-6">
                <label class="form-label">
                    الجنسية
                    <span class="text-danger">*</span>
                </label>
                <select id="nationality" name="nationality" class="form-select" >
                    <option value ="">اختر</option>
                    @foreach ($nationality as $item)
                    <option value="{{ $item->id }}">{{ $item->name_ar }}</option>
                @endforeach
                </select>
                @error('nationality')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3 col-lg-4 col-md-6">
                <label class="form-label">
                    الهاتف
                    <span class="text-danger">*</span>
                </label>
                <input
                class="form-input form-control"
                type="text"
                name="phone"
                id="phone"
                value="{{ old('phone') }}" required />

                @error('phone')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group mb-3 col-lg-4 col-md-6">
                <label class="form-label">
                    الفرع
                    <span class="text-danger">*</span>
                </label>
                <select id="branch_id" name="branch_id" class="form-select" >
                    <option value ="">اختر</option>
                    @foreach ($branches as $branche)
                        <option value="{{ $branche->id }}">{{ $branche->name_ar }}</option>
                    @endforeach
                </select>
                @error('branch_id')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3 col-lg-4 col-md-6">
                <label class="form-label">
                    هاتف العمل
                    <span class="text-danger">*</span>
                </label>
                <input
                class="form-input form-control"
                type="text"
                name="phone_land"
                id="phone_land"
                value="{{ old('phone_land') }}" />

                @error('phone_land')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3 col-lg-4 col-md-6">
                <label class="form-label">
                    اسم اقرب شخص (1)
                    <span class="text-danger">*</span>
                </label>
                <input
                class="form-input form-control"
                type="text"
                name="nearist_phone1"
                id="nearist_phone1"
                value="{{ old('nearist_phone1') }}" required />

                @error('nearist_phone1')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3 col-lg-4 col-md-6">
                <label class="form-label">
                    هاتف اقرب شخص (1)
                    <span class="text-danger">*</span>
                </label>
                <input
                class="form-input form-control"
                type="text"
                name="phone_work1"
                id="phone_work1"
                value="{{ old('phone_work1') }}" required />

                @error('phone_work1')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3 col-lg-4 col-md-6">
                <label class="form-label">
                    اسم اقرب شخص (2)
                    <span class="text-danger">*</span>
                </label>
                <input
                class="form-input form-control"
                type="text"
                name="nearist_phone2"
                id="nearist_phone2"
                value="{{ old('nearist_phone2') }}" required />

                @error('nearist_phone2')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3 col-lg-4 col-md-6">
                <label class="form-label">
                    هاتف اقرب شخص (2)
                    <span class="text-danger">*</span>
                </label>
                <input
                class="form-input form-control"
                type="text"
                name="phone_work2"
                id="phone_work2"
                value="{{ old('phone_work2') }}" required />

                @error('phone_work2')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>


            <div class="form-group mb-3 col-lg-4 col-md-6">
                <label class="form-label">
                    المنطقة
                    <span class="text-danger">*</span>
                </label>
                <select id="region" name="region" class="form-select" required>
                    <option value ="">اختر</option>
                    @foreach ($region as $item)
                    <option value="{{ $item->id }}">{{ $item->name_ar }}</option>
                @endforeach
                </select>
                @error('region')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>



            <div class="form-group mb-3 col-lg-4 col-md-6">
                <label class="form-label">
                    القطعة
                    <span class="text-danger">*</span>
                </label>
                <input
                class="form-input form-control"
                type="text"
                name="block"
                id="block"
                value="{{ old('block') }}" required />

                @error('block')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3 col-lg-4 col-md-6">
                <label class="form-label">
                    شارع
                    <span class="text-danger">*</span>
                </label>
                <input
                class="form-input form-control"
                type="text"
                name="street"
                id="street"
                value="{{ old('street') }}" required />

                @error('street')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3 col-lg-4 col-md-6">
                <label class="form-label">
                    جادة
                    <span class="text-danger">*</span>
                </label>
                <input
                class="form-input form-control"
                type="text"
                name="jada"
                id="jada"
                value="{{ old('jada') }}" />

                @error('jada')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3 col-lg-4 col-md-6">
                <label class="form-label">
                    مبني
                    <span class="text-danger">*</span>
                </label>
                <input
                class="form-input form-control"
                type="text"
                name="building"
                id="building"
                value="{{ old('building') }}" />

                @error('building')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3 col-lg-4 col-md-6">
                <label class="form-label">
                    الدور
                    <!--<span class="text-danger">*</span>-->
                </label>
                <input
                class="form-input form-control"
                type="text"
                name="floor"
                id="floor"
                value="{{ old('floor') }}" />

                @error('floor')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3 col-lg-4 col-md-6">
                <label class="form-label">
                    رقم الشقه
                    <!--<span class="text-danger">*</span>-->
                </label>
                <input
                class="form-input form-control"
                type="text"
                name="flat"
                id="flat"
                value="{{ old('flat') }}" />
                @error('flat')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3 col-lg-4 col-md-6">
                <label class="form-label">
                    رقم الالي
                    <span class="text-danger">*</span>
                </label>
                <input
                class="form-input form-control"
                type="text"
                name="house_id"
                id="house_id"
                value="{{ old('house_id') }}" required />
                @error('house_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3 col-lg-4 col-md-6">
                <label class="form-label">
                    جهه العمل
                    <span class="text-danger">*</span>
                </label>
                <input
                class="form-input form-control"
                type="text"
                name="ministry_id"
                id="ministry_id"
                value="{{ $ministry->name_ar ?? null}}" disabled />
                @error('ministry_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3 col-lg-4 col-md-6">
                <label class="form-label">
                    الراتب
                    <span class="text-danger">*</span>
                </label>
                <input
                class="form-input form-control"
                type="text"
                name="salary"
                id="Salary"
                value="{{ old('salary',$data->salary) }}" readonly />
                @error('salary')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3 col-lg-4 col-md-6">
                <label class="form-label">
                    اسم البنك
                    <span class="text-danger">*</span>
                </label>
                <select id="bank" name="bank" class="form-select" required>
                    <option value ="">اختر</option>
                    @foreach ($bank as $item)
                        <option value="{{ $item->id }}">{{ $item->name_ar }}</option>
                    @endforeach
                </select>
                @error('bank')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3 col-lg-4 col-md-6">
                <label class="form-label">
                    رقم الحساب البنكي
                    <span class="text-danger">*</span>
                </label>
                <input
                class="form-input form-control"
                type="text"
                name="ipan"
                id="ipan"
                value="{{ old('ipan') }}" required />
                @error('ipan')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3 col-lg-4 col-md-6">
                <label class="form-label">
                    عنوان العمل
                    <span class="text-danger">*</span>
                </label>
                <input
                class="form-input form-control"
                type="text"
                name="location"
                id="location"
                value="{{ old('location') }}" required />
                @error('location')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3 col-lg-4 col-md-6">
                <label class="form-label">
                    موقع كويك فيندر
                    <span class="text-danger">*</span>
                </label>
                <input
                class="form-input form-control"
                type="text"
                name="kwfinder"
                id="kwfinder"
                value="{{ old('kwfinder') }}" required />
                @error('kwfinder')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3 col-lg-4 col-md-6">
                <label class="form-label">
                    البريد الالكترونى
                    <!--<span class="text-danger">*</span>-->
                </label>
                <input
                class="form-input form-control"
                type="email"
                name="email"
                id="email"
                value="{{ old('email') }}" />
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3 col-lg-4 col-md-6">
                <label class="form-label">
                    هويتي
                    <span class="text-danger">*</span>
                </label>
                <input
                class="form-input form-control"
                type="file"
                name="personal_image"
                id="personal_image"
                value="{{ old('personal_image') }}" required />
                @error('personal_image')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3 col-lg-4 col-md-6">
                <label class="form-label">
                    هوية العمل
                    <span class="text-danger">*</span>
                </label>
                <input
                class="form-input form-control"
                type="file"
                name="work_image"
                id="work_image"
                value="{{ old('work_image') }}" required />
                @error('work_image')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3 col-lg-12 col-md-12">
                {{-- <label class="form-label">
                    التحقق من هويتي
                    <span class="text-danger">*</span>
                </label>


                <input
                class=" form-input form-control"
                type="checkbox" name="checkbox" required/>
                <p<i class="fa-solid fa-star-of-life text-error fs-5"></i></p>
                @error('checkbox')
                    <div class="text-danger">{{ $message }}</div>
                @enderror --}}

                <div class="flex mt-3">
                    <label class="inline-flex items-center  space-x-reverse space-x-2">
                        <input
                            class="form-checkbox"
                            type="checkbox" name="checkbox" required/>
                        <p>التحقق من هويتي <i class="fa-solid fa-star-of-life text-error fs-5"></i></p>

                    </label>
                </div>
            </div>


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

    <!--/span-->
    </div>
</div>



<div class="card">
<div class="card-body">
  <div class="table-responsive">
    <div class="accordion accordion-flush" id="accordionFlushExample">
      <div class="accordion-item">
        <h2 class="accordion-header" id="flush-headingOne">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
            <i class="ti ti-user-check fs-6 d-block mx-1" style="color: rgb(1, 122, 58);"></i> البيانات
            الشخصية <span class="text-gray mx-1">( قم بالضغط هنا لاظهار البيانات العميل)</span>
          </button>
        </h2>
        <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne"
          data-bs-parent="#accordionFlushExample">
          <div class="accordion-body">
            <div class="table-responsive pb-4">
              <table class="table">
                <tbody>
                    <tr>
                        <th>
                            الاسم
                        </th>
                        <td>{{ $data->name_ar ?? 'لايوجد' }}</td>
                    </tr>
                    <tr>
                        <th>
                            الرقم المدني
                        </th>
                        <td>{{ $data->civil_number ?? 'لايوجد' }}</td>

                    </tr>
                    <tr>
                        <th>
                            الهاتف </th>
                        <td>{{ $data->phone ?? 'لايوجد' }}</td>


                    </tr>
                    <tr>
                        <th>
                            البنك
                        </th>
                        <td>{{ $data->bank->name_ar ?? 'لايوجد' }}</td>

                    </tr>
                    <tr>
                        <th>
                            المحافظة
                        </th>
                        <td> {{ $data->governorate->name_ar ?? 'لايوجد' }}</td>


                    </tr>
                    <tr>
                        <th>
                            جهة العمل
                        </th>
                        <td> {{ $data->ministry_working->name_ar ?? 'لايوجد' }}</td>



                    </tr>
                    <tr>
                        <th>
                            مجموع الأقساط </th>
                        <td> {{ $data->installment_total ?? 'لايوجد' }}</td>




                    </tr>
                    <tr>
                        <th>
                            مجموع مديونية الساينت </th>
                        <td> {{ $total_cient ?? 'لايوجد' }}</td>




                    </tr>
                    <tr>
                        <th>
                            الوسيط </th>
                        <td> {{ $data->Boker->name_ar ?? 'لايوجد' }}</td>





                    </tr>
                    <tr>
                        <th>
                            جهة الدخل ( 1 ) </th>
                        <td>
                            <div class="block">
                                 {{ $working->ministry->name_ar ?? 'لايوجد' }}
                                 <br>
                                <a href="{{ $working->image ?? 'http://127.0.0.1:8000/' }}"
                                    class="btn mt-5 mb-1 bg-info font-medium text-white hover:bg-info-focus focus:bg-info-focus active:bg-info-focus/90"
                                    target="_blank">
                                    الصورة
                                    {{-- <img src="{{$working->image}}" alt="Thumbnail" style="width: 100px;"> --}}
                                </a>
                            </div>
                        </td>


                    </tr>
                    <tr>
                        <th>
                            الراتب (1) </th>
                        <td> {{ $working->salary ?? 'لايوجد' }}</td>



                    </tr>
                    <tr>
                        <th>
                            اجمالي الدخل </th>
                        <td>{{ $data->cinet_total_income   ?? 'لايوجد'}}</td>



                    </tr>
                    <tr>
                        <th>
                            القسط المسموح </th>
                        <td> {{ $data->cinet_amount_limit ?? 'لايوجد' }}</td>



                    </tr>
                    <tr>
                        <th>
                            القرض المسموح </th>
                        <td> {{ (intval($data->cinet_amount_limit ?? 0) * 122) ?: 'لايوجد' }}</td>



                    </tr>
                    <tr>
                        <th>
                            ملف الساينت </th>
                        <td> <a href="{{ $data->cinet_pdf ?? 'http://127.0.0.1:8000/' }}"
                                class="btn mt-5 mb-1 bg-info font-medium text-white hover:bg-info-focus focus:bg-info-focus active:bg-info-focus/90"
                                target="_blank">
                                عرض الساينت
                                {{-- <img src="{{$working->image}}" alt="Thumbnail" style="width: 100px;"> --}}
                            </a>

                        </td>

                    </tr>
                    <tr>
                        <th>
                            عدد الملفات المفتوحة </th>
                        <td> {{ $cinetCount->count() ?? 'لايوجد' }}</td>



                    </tr>
                    <tr>
                        <th>
                            اقرار دين </th>
                        <td class="block">

                            <div class="form-group mb-3 col-lg-12 col-md-12">
                                <label class="form-label">
                                    اضف ملف<i class="fa-solid fa-star-of-life text-error fs-5"></i>
                                </label>
                                    <input
                                        class="form-input form-control"
                                        placeholder="" name="qard_paper" type="file" required />

                            </div>
                            <div class="form-group mb-3 col-lg-12 col-md-12">
                                <label class="form-label">
                                    السنه<i class="fa-solid fa-star-of-life text-error fs-5"></i>
                                </label>
                                    <input
                                        class="form-input form-control"
                                        placeholder="" name="qard_year" type="text" required />

                            </div>
                            <div class="form-group mb-3 col-lg-12 col-md-12">
                                <label class="form-label">
                                    مكتب التوثيق<i
                                        class="fa-solid fa-star-of-life text-error fs-5"></i>
                                </label>
                                <input class="form-input form-control"
                                        placeholder=" " name="qard_place" type="text" required/>

                            </div>
                            <div class="form-group mb-3 col-lg-12 col-md-12">
                                <label class="form-laber">
                                    رقم المرجع<i class="fa-solid fa-star-of-life text-error fs-5"></i>
                                </label>
                                    <input
                                        class="form-input form-control"
                                        placeholder="    " type="text" name="qard_number" required />

                            </div>
                            <div class="form-group mb-3 col-lg-12 col-md-12">
                                <label class="block w-full mx-1">
                                    الشروط و الاحكام<i
                                        class="fa-solid fa-star-of-life text-error fs-5"></i>
                                </label>
                                    <textarea rows="4" name="rules" placeholder=" Enter Text"
                                        class="form-textarea form-control"></textarea>

                            </div>

                        </td>
                    </tr>
                </tbody>
              </table>
              <div class="d-flex justify-content-end">
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
  </div>
</div>
</div>
</div>

</form>
<div class="card">
<div class="card-body">
  <div class="table-responsive">
    <div class="accordion accordion-flush" id="accordionFlushExampleNotes">
      <div class="accordion-item">
        <h2 class="accordion-header" id="flush-headingTwo">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
            <i class="ti ti-message-2 fs-6 d-block mx-1" style="color: blueviolet;"></i> ملفات الساينت <span
              class="text-gray mx-1">( قم بالضغط هنا لاظهار ملف الساينت)</span>
          </button>
        </h2>
        <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo"
          data-bs-parent="#accordionFlushExampleNotes">
          <div class="accordion-body">
            <div class="table-responsive pb-4">
              <table id="all-students" class="table table-bordered border text-nowrap align-middle">
                <thead>
                  <!-- start row -->
                  <tr>
                    <th> # </th>
                    <th>الجهة </th>
                    <th> تاريخ فتح حساب </th>
                    <th> الرصيد المتبقي</th>
                    <th> قيمة القسط</th>
                    <th> قيمة المديونية </th>
                    <th> فتره السداد </th>
                    <th> مبلغ القرض </th>
                    <th> إعادة الجدولة </th>

                  </tr>
                  <!-- end row -->
                </thead>
                <tbody>
                  <!-- start row -->
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
</div>
</div>
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



                    if (data.success) {
                        console.log(data.product.number);
                        if(products.length > 0){
                            products.forEach(element => {
                                // ...use `element`...
                                if(element.number == data.product.number){
                                 alert('هذا المنتج موجود بالفعل')

                                }else {
                                    appendRow(data.product, barcodeSelected)
                                }
                            });


                          //  console.log(products);
                        }else {
                              console.log(products);
                            appendRow(data.product, barcodeSelected)

                        }


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

                <td class="whitespace-nowrap py-3 sm:px-5">
                    <p>${product.model || 'الصنف'}</p>
                </td>
                 <td  id="${product.number}" class="whitespace-nowrap py-3 sm:px-5">${product.number || 0 }</td>

                <td class="whitespace-nowrap py-3 sm:px-5 cost-cell">(${product.cost || 0} د . ك)</td>
                <td class="whitespace-nowrap py-3 sm:px-5">(${product.price || 0} د . ك)</td>
                <td class="whitespace-nowrap py-3 sm:px-5"><i class="ti ti-trash fs-5" onclick="deleteRow(this)"></i></td>




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
            calculate();
        }
    </script>

    <script>
        // Function to calculate values based on input changes
        function calculate()
        {
            var price_cost = $('#price_cost').val();
            var cost_install = $('#cost_install').val();
            var part = $('#part').val();
            var total_first_amount = $('#total_first_amount').val();
            var final_total = $('#final_total').val();
            var extra_first_amount = $('#extra_first_amount').val();
            var total = $('#total').val();
            var monthly_amount = $('#monthly_amount').val();
            var eqrardain_amount = $('#eqrardain_amount').val();
            let count_monthsselectedValue = document.getElementById('count_months').value;
            if(parseFloat(cost_install) > parseFloat(price_cost))
             {
                monthly_amount = (parseFloat(price_cost)*3) /count_monthsselectedValue;
                $('#monthly_amount').val(Math.floor(monthly_amount));
                // freation
                let frection = monthly_amount - Math.floor(monthly_amount);

                 let partt =frection* count_monthsselectedValue;

                part = (parseFloat(cost_install) - parseFloat(price_cost)) + partt;
                $('#part').val(Math.floor(part));

                total_first_amount = parseFloat(Math.floor(part)) + parseFloat(extra_first_amount);
                $('#total_first_amount').val(total_first_amount);

                total = Math.floor(monthly_amount) * count_monthsselectedValue;
                $('#total').val(total);

                final_total= (parseFloat(total)) + parseFloat(total_first_amount);
                $('#final_total').val(final_total);




                // monthly_amount = (parseFloat(price_cost)*3) /count_monthsselectedValue;
                // $('#monthly_amount').val(Math.floor(monthly_amount));
                $('#eqrardain_amount').val(total);
                console.log('dddd');
             }
             else
             {
                 monthly_amount =  (parseFloat(cost_install) *3) /count_monthsselectedValue;

                $('#monthly_amount').val(Math.floor(monthly_amount));

                let frection = monthly_amount - Math.floor(monthly_amount);

                part =frection* count_monthsselectedValue;
                $('#part').val(Number(part).toFixed(3));

                total_first_amount = Number(Number(part).toFixed(3)) + parseFloat(extra_first_amount);
                $('#total_first_amount').val(total_first_amount.toFixed(3));

                total = Math.floor(monthly_amount) * count_monthsselectedValue;
                $('#total').val(total);

                final_total= (parseFloat(total)) +  parseFloat(total_first_amount);
                $('#final_total').val(final_total);

                $('#eqrardain_amount').val(total);
                console.log("ee");
                console.log(monthly_amount);
             }
            // console.log(count_monthsselectedValue);

        }
        // function calculate() {
        //     const extraFirstAmount = ($('#extra_first_amount').val()) * 1000;
        //     const countMonths = $('#count_months').val();
        //     const percent = parseFloat($('#asd_' + countMonths).attr('disc')) || 0;
        //     const costInstall = ($('#cost_install').val() || 0) * 1000;
        //     const total = ($('#total').val() || 0) * 1000;
        //     const priceCost = ($('#price_cost').val() || 0) * 1000;
        //     let finalInstallmentAmount = priceCost;
        //     $('#part').val('0');

        //     // Calculate the difference
        //     let difference = costInstall - priceCost;
        //     if (difference < 0) finalInstallmentAmount = costInstall;

        //     const effectiveMonths = countMonths == 0 ? $('#count_months_without').val() : countMonths;
        //     const rate = ((finalInstallmentAmount * percent) / 100).toFixed(3);
        //     $('#rate').val(rate);

        //     const totalValue = rate * 1000 + finalInstallmentAmount + extraFirstAmount;
        //     const part = $('#part').val() * 1000;
        //     const monthlyInstallment = ((totalValue - part - extraFirstAmount) / effectiveMonths / 1000).toFixed(3);
        //     $('#monthly_amount').val(monthlyInstallment);

        //     const firstRest = Math.floor(monthlyInstallment);
        //     const remainder = monthlyInstallment - firstRest;
        //     const totalRemaining = (remainder * effectiveMonths) * 1000;
        //     const totalFirstAmount = parseInt(totalRemaining + part).toFixed(0);
        //     const installmentRemainder = firstRest * effectiveMonths * 1000;
        //     $('#reminder_amount').val(parseFloat(installmentRemainder / 1000).toFixed(3));

        //     // Update final values
        //     const extraPart = (difference < 0) ? 0 : (costInstall - priceCost);
        //     $('#total').val(parseFloat((totalValue + extraPart) / 1000).toFixed(3));
        //     $('#final_installment_amount').val(parseFloat(finalInstallmentAmount / 1000).toFixed(3));
        //     $('#total_first_amount').val(parseFloat((totalValue - installmentRemainder + extraPart) / 1000).toFixed(3));
        //     $('#part').val(parseFloat((totalValue - installmentRemainder + extraPart - extraFirstAmount) / 1000).toFixed(
        //     3));
        //    // Calculate final total as a number to avoid string concatenation issues
        //     const finalTotal = parseFloat($('#total').val()) - parseFloat($('#total_first_amount').val());
        //     $('#final_total').val(finalTotal.toFixed(3));

        //     const cinetLimit = $('#cinet_amount_limit').val() * 1000;
        //     const internalInstallment = (monthlyInstallment * 1000 > cinetLimit) ? monthlyInstallment - (cinetLimit /
        //         1000) : 0;
        //     $('#cinet_installment').val((cinetLimit > monthlyInstallment * 1000 ? monthlyInstallment : cinetLimit / 1000)
        //         .toFixed(3));
        //     $('#intrenal_installment').val(internalInstallment.toFixed(3));

        //     const eqrarAmount = parseFloat(finalInstallmentAmount / 1000).toFixed(3);
        //     $('#eqrardain_amount').val(eqrarAmount);

        //     return false;
        // }
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


