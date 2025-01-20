  {{--

    <style>
        .row {
            display: flex;
            flex-wrap: wrap;
            gap: 0px;
            /* Adds space between columns */
        }

        /* Column styling */
        .col {
            flex: 1;
            /* Makes each column take equal width */
            min-width: 150px;
            margin-left: 1rem;
            /* Optional: sets a minimum width for each column */
        }


        .form-container {
            width: 100%;
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .tabs {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
        }

        .tab {
            flex: 1;
            text-align: center;
            padding: 10px;
            cursor: pointer;
            border-bottom: 2px solid #ddd;
            color: #333;
        }



        input[type="text"],
        select,
        .submit-btn {
            flex: 2;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        .submit-btn {
            width: 100%;
            padding: 12px;
            background-color: #ff4500;
            color: #fff;
            border: none;
            font-size: 16px;
            cursor: pointer;
            border-radius: 4px;
            margin-top: 20px;
        }

        .submit-btn:hover {
            background-color: #e84306;
        }

        /* styles.css */
        .hidden {
            display: none;
        }

        .tab.active {
            color: #ff4500;
            border-color: #ff4500;
            font-weight: bold;
        }
    </style>


    <!-- Main Content Wrapper -->
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
        <div class="card-custom block ">
            <div class="form-container">
                <h2>حسابات الأقساط</h2>
                <div class="tabs">
                    <div class="tab active" onclick="showSection('personal-info')">معلومات الشخصية</div>
                    <div class="tab" onclick="showSection('client-files')">ملفات الساينت</div>
                </div>

                <form action="{{ route('installmentsubmission.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <section class="section" id="personal-info">
                        <h3>معلومات الشخصية</h3>
                        <div class="card-custom block">
                            <input type="hidden" name="installment_clients" value="{{ $Installment_Client->id }}" />
                            <div class="flex">
                                <label class="block w-full mx-1">
                                    الرقم المدنى
                                    <input
                                        class="form-input w-full  rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        type="text" name="civil_number" value="{{ $Installment_Client->civil_number }}" readonly />
                                </label>
                                <label class="block w-full mx-1">
                                    الاسم
                                    <input
                                        class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        type="text" name="name_ar" value="{{ $Installment_Client->name_ar }}" />
                                </label>
                                <label class="block w-full mx-1">
                                    الهاتف
                                    <input
                                        class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        type="text" name="phone" value="{{ $Installment_Client->phone }}" />
                                </label>
                                <label class="block w-full mx-1">
                                    نوع الوظيفة



                                </label>
                            </div>
                            <div class="flex">
                                <label class="block w-full mx-1">
                                    الوسيط
                                    <select
                                        class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        name="boker_id">
                                        <option value="">اختر</option>
                                        @foreach ($boker as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $item->id == ($Installment_Client->boker_id ?? '') ? 'selected' : '' }}>
                                                {{ $item->name_ar }}
                                            </option>
                                        @endforeach
                                    </select>
                                </label>

                                <label class="block w-full mx-1">
                                    الجنسية
                                    <select
                                        class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        name="nationality_id">
                                        <option value="">اختر</option>
                                        @foreach ($nationality as $item)
                                            <option value="{{ $item->id }}">
                                                {{ $item->name_ar }}
                                            </option>
                                        @endforeach
                                    </select>
                                </label>

                                <label class="block w-full mx-1">
                                    المحافظات
                                    <select
                                        class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        name="government_id">
                                        <option value="">اختر</option>
                                        @foreach ($government as $item)
                                            <option value="{{ $item->id }}"
                                                >
                                                {{ $item->name_ar }}
                                            </option>
                                        @endforeach
                                    </select>
                                </label>

                                <label class="block w-full mx-1">
                                    المنطقة
                                    <select
                                        class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        name="region_id">
                                        <option value="">اختر</option>
                                        @foreach ($region as $item)
                                            <option value="{{ $item->id }}"
                                                >
                                                {{ $item->name_ar }}
                                            </option>
                                        @endforeach
                                    </select>
                                </label>


                            </div>



                            <div class="flex">
                                <label class="block w-full mx-1">
                                    <div id="formRows">
                                        <div class="row issue-row mb-3" data-index="0">
                                            <div class="col">
                                                <p> جهه الدخل</p>

                                            </div>
                                            <div class="col">
                                                <p>الراتب</p>
                                                <input type="text"
                                                    class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                                    name="installment[0][salary]" class="form-control" required />
                                            </div>

                                            <div class="col">
                                                <p>صافى الراتب</p>
                                                <input type="text"
                                                    class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                                    name="installment[0][netSalary]" class="form-control" required />
                                            </div>
                                            <div class="col">
                                                <p>اسم البنك</p>

                                            </div>

                                            <div class="col">
                                                <p>ارفاق صورة</p>
                                                <input type="file"
                                                    class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                                    name="installment[0][image]" required>
                                            </div>
                                            <div class="col">
                                                <button type="button" class="btn remove-row-btn"
                                                    style="background-color: red;color: #fff; width: 50px;">ازالة</button>
                                            </div>
                                        </div>
                                    </div>
                                </label>

                            </div>
                            <br>
                            <div class="flex">
                                <label class="mb-3 text-left">
                                    <button type="button" class="btn btn-secondary"
                                        style="background-color: green; color:white;" id="addRowBtn">اضافة </button>
                                </label>
                            </div>
                            <br>
                            <div class="flex items-center">
                                <label class="flex items-center w-full mx-1">
                                    <input type="checkbox" name="salary_certificate_less_than_5_days" />
                                    <span class="ml-2">تاريخ شهادة الراتب اقل من 5 ايام</span>
                                </label>
                            </div>
                            <br>
                            <div class="flex">
                                <label class="block w-full mx-1">
                                    الملاحظات
                                    <textarea
                                        class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        id="" rows="10" name="note"></textarea>
                                </label>
                            </div>



                        </div>
                        <!-- Add more input fields following the same structure -->
                    </section>

                    <section class="section hidden" id="client-files">
                        <h3>معلومات الساينت</h3>
                        <div class="card-custom block">
                            <input type="hidden" name="installment_clients" value="{{ $Installment_Client->id }}" />
                            <div class="flex">
                                <label class="block w-full mx-1">
                                    اجمالى الدخل
                                    <input
                                        class="form-input w-full  rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        type="text" name="cinet_total_income" required />
                                </label>
                                <label class="block w-full mx-1">
                                    مجموع الاقساط
                                    <input
                                        class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        type="text" name="cinet_installments_total" required />
                                </label>
                                <label class="block w-full mx-1">
                                    الاقساط المتاخرة
                                    <input
                                        class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        type="text" name="total_lated_installments" required />
                                </label>
                                <label class="block w-full mx-1">

                                    مؤشر قضائي

                                    <select
                                        class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                         name="legal_indicator">

                                        <option value="0">لا</option>
                                        <option value="1">نعم</option>
                                    </select>
                                </label>
                            </div>
                            <div class="flex">
                                <label class="block w-full mx-1">
                                    ديون معدومة
                                    <select
                                        class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        name="dead_loan">
                                        <option value="0">لا</option>
                                        <option value="1">نعم</option>
                                    </select>
                                </label>

                                <label class="block w-full mx-1">
                                    القسط المسموح
                                    <input
                                        class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        type="text" name="cinet_amount_limit" required />
                                </label>

                                <label class="block w-full mx-1">
                                    لمت صافي الراتب
                                    <input
                                        class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        type="text" name="cinet_amount_limit_safi" required />
                                </label>

                            </div>

                            <div class="flex items-center">
                                <label class="flex items-center w-full mx-1">
                                    ملف الساينت :
                                    <input type="file"
                                        class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        name="cinet_pdf" required>
                                </label>
                                <label class="flex items-center w-full mx-1">
                                    صورة المدنية :
                                    <input type="file"
                                        class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        name="upload_img_2" required>
                                </label>
                            </div>



                            <div class="flex">
                                <label class="block w-full mx-1">
                                    الملفات
                                    <div id="formRows1">
                                        <div class="row issue-row1 mb-3" data-index="0">
                                            <div class="col">
                                                <p> جهه </p>

                                            </div>
                                            <div class="col">
                                                <p>تاريخ فتح حساب</p>
                                                <input type="date"
                                                    class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                                    name="installment_client_cinet[0][file_date_1]" class="form-control"
                                                    required />
                                            </div>

                                            <div class="col">
                                                <p>الرصيد المتبقي</p>
                                                <input type="text"
                                                    class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                                    name="installment_client_cinet[0][file_remindes_amount_1]"
                                                    class="form-control" required />
                                            </div>
                                            <div class="col">
                                                <p>قيمة القسط</p>
                                                <input type="text"
                                                    class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                                    name="installment_client_cinet[0][file_installment_amount_1]"
                                                    class="form-control" required />
                                            </div>
                                            <div class="col">

                                                <p>قيمة المديونية </p>
                                                <input type="text"
                                                    class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                                    name="installment_client_cinet[0][file_debit_amount_1]"
                                                    class="form-control" required />
                                            </div>

                                            <div class="col">

                                                <p>إعادة الجدولة</p>
                                                <input type="text"
                                                    class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                                    name="installment_client_cinet[0][new_loan_date_1]"
                                                    class="form-control" required />
                                            </div>

                                            <div class="col">

                                                <p> القرض الجديد </p>
                                                <input type="text"
                                                    class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                                    name="installment_client_cinet[0][new_loan_amount_1]"
                                                    class="form-control" required />
                                            </div>

                                            <div class="col">

                                                <p> فتره السداد </p>

                                                <select
                                                    class="form-input w-full rounded-lg border border-slate-300 my-2 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                                    name="installment_client_cinet[0][file_all_times_1]">

                                                    @for ($i = 0; $i < 200; $i++)
                                                        <option value="{{ $i }}">{{ $i }}</option>
                                                    @endfor


                                                </select>
                                            </div>


                                            <div class="col">
                                                <button type="button" class="btn remove-row-btn1"
                                                    style="background-color: red;color: #fff; width: 50px;">ازالة</button>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            <br>
                            <div class="flex">
                                <label class="mb-3 text-left">
                                    <button type="button" class="btn btn-secondary"
                                        style="background-color: green; color:white;" id="addRowBtn1">اضافة </button>
                                </label>
                            </div>
                            <br>


                        </div>
                    </section>

                    <button type="submit" class="submit-btn">حفظ</button>
                </form>
            </div>
        </div>
    </main>




--}}

  <style>
      .wizard,
      .wizard .nav-tabs,
      .wizard .nav-tabs .nav-item {
          position: relative;
          z-index: 1;
      }

      .wizard .nav-tabs .nav-item {
          text-align: center;

      }

      .wizard .nav-tabs:after {
          content: "";
          width: 50%;
          border-bottom: solid 2px #ccc;
          position: absolute;
          margin-left: auto;
          margin-right: auto;
          top: 38%;
          z-index: 0;
      }

      .wizard .nav-tabs .nav-item .nav-link {
          width: 70px;
          height: 70px;
          margin-bottom: 6%;
          background: white;
          border: 2px solid #ccc;
          color: #ccc;
          z-index: 10;
      }

      .wizard .nav-tabs .nav-item .nav-link:hover {
          color: #333;
          border: 2px solid #333;
      }

      .wizard .nav-tabs .nav-item .nav-link.active {
          background: #fff;
          border: 2px solid #0dcaf0;
          color: #0dcaf0;
      }

      /* .wizard .nav-tabs .nav-item .nav-link:after {
        content: " ";
        position: absolute;
        right: 50%;
        transform: translate(-50%);
        opacity: 0;
        margin: 0 auto;
        bottom: 0px;
        border: 5px solid transparent;
        border-bottom-color: #0dcaf0;
        transition: 0.1s ease-in-out;
    } */

      /* .nav-tabs .nav-item .nav-link.active:after {
        content: " ";
        position: absolute;
        right: 50%;
        transform: translate(-50%);
        opacity: 1;
        margin: 0 auto;
        bottom: 0px;
        border: 10px solid transparent;
        border-bottom-color: #0dcaf0;
    }
 */
      .wizard .nav-tabs .nav-item .nav-link svg {
          font-size: 25px;
      }
  </style>

  <div class="wizard my-5 card p-5">
      <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
          <li class="nav-item flex-fill" role="presentation" data-bs-toggle="tooltip" data-bs-placement="top" title="Step 1">
              <a class="nav-link active rounded-circle mx-auto d-flex align-items-center justify-content-center"
                  href="#step1" id="step1-tab" data-bs-toggle="tab" role="tab" aria-controls="step1"
                  aria-selected="true">
                  <i class="fas fa-folder-open"></i>
              </a>
              معلومات شخصية
          </li>
          <li class="nav-item flex-fill" role="presentation" data-bs-toggle="tooltip" data-bs-placement="top"
              title="Step 2">
              <a class="nav-link rounded-circle mx-auto d-flex align-items-center justify-content-center" href="#step2"
                  id="step4-tab" data-bs-toggle="tab" role="tab" aria-controls="step2" aria-selected="false"
                  title="Step 2">
                  <i class="fas fa-flag-checkered"></i>
              </a>
              ملفات الساينت

          </li>
      </ul>
      <form action="{{ route('installmentsubmission.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
      <div class="tab-content" id="myTabContent">

            <div class="tab-pane fade show active" role="tabpanel" id="step1" aria-labelledby="step1-tab">

                <h3 class="py-3 border-bottom">معلومات الشخصية </h3>

                <section class="section" id="personal-info">

                    <input type="hidden" name="installment_clients" value="{{ $Installment_Client->id }}" />
                    <div class="form-row row py-3">
                        <div class="form-group mb-3 col-6">
                            <label class="form-label"> الرقم المدنى </label>
                            <input class="form-input form-control " type="text" name="civil_number" id="civil_number"
                                value="" required/>
                                <small id="civil-number-error" class="text-danger" style="display: none;">الرقم
                                       الذى تم ادخاله مختلف عن الرقم المسجل</small>
                        </div>
                        <div class="form-group mb-3 col-6">
                            <label class="form-label"> الاسم </label>
                            <input class="form-input form-control" type="text" name="name_ar"
                                value="" />
                        </div>
                        <div class="form-group mb-3 col-6">
                            <label class="form-label"> الهاتف </label>
                            <input class="form-input form-control" type="text" name="phone"
                                value="" />
                        </div>
                        <div class="form-group mb-3 col-6">
                            <label class="form-label">
                                نوع الوظيفة
                            </label>
                            <select class="form-input form-select" id="ministry" name="ministry_id">
                                <option value="">اختر</option>
                                @foreach ($ministry as $item)
                                    <option value="{{ $item->id }}"
                                       >
                                        {{ $item->name_ar }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3 col-6">
                            <label class="form-label">
                                الوسيط
                            </label>
                            <input class="form-input form-control " type="text" name="boker_id"
                                value="{{$Installment_Client->installmentBroker->name}}" readonly/>
                            <!-- <select class="form-input form-select" name="boker_id">
                                @foreach ($boker as $item)
                                    <option value="{{ $item->id }}"
                                        {{ $item->id == ($Installment_Client->boker_id ?? '') ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select> -->
                        </div>
                        <div class="form-group mb-3 col-6">
                            <label class="form-label">
                                الجنسية
                            </label>
                            <select class="form-input form-select">
                                <option value="">اختر</option>
                                @foreach ($nationality as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->name_ar }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3 col-6">
                            <label class="form-label">
                                المحافظات
                            </label>
                            <select class="form-input form-select">
                                <option value="">اختر</option>
                                @foreach ($government as $item)
                                    <option value="{{ $item->id }}"
                                        >
                                        {{ $item->name_ar }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3 col-6">
                            <label class="form-label">
                                المنطقة
                            </label>
                            <select class="form-input form-select">
                                <option value="">اختر</option>
                                @foreach ($region as $item)
                                    <option value="{{ $item->id }}"
                                        >
                                        {{ $item->name_ar }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div >
                        <div class="form-row row issue-row" id="formRows" data-index="0">
                            <div class="form-group mb-3 col-3">
                                <label class="form-label"> جهه الدخل</label>
                                <select class="form-input form-select" id="ministry"
                                    name="installment[0][working_compang]" required>
                                    <option value="">اختر</option>
                                    @foreach ($ministry as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->name_ar }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-3 col-3">
                                <label class="form-label"> الراتب</label>
                                <input type="text" class="form-input form-control salary" name="installment[0][salary]"
                                    required />
                            </div>
                            <div class="form-group mb-3 col-3">
                                <label class="form-label"> صافى الراتب</label>
                                <input type="text" class="form-input form-control" name="installment[0][netSalary]" id="net_salary"
                                    required />
                            </div>

                            <div class="form-group mb-3 col-3">
                                <label class="form-label"> اسم البنك</label>
                                <select class="form-input form-select" id="ministry" name="installment[0][bank]"
                                    required>
                                    <option value="">اختر</option>
                                    @foreach ($bank as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->name_ar }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-3 col-3">
                                <label class="form-label"> ارفاق صورة</label>
                                <input type="file" class="form-input form-control" name="installment[0][image]"
                                    required>
                            </div>
                        </div>
                        <div class="form-row row">
                            <div class="mb-3 d-flex align-items-center border-top pt-3">
                                {{-- <button type="button" class="btn remove-row-btn btn-danger">ازالة</button> --}}
                                <button type="button" class="btn btn-success mx-2" id="addRowBtn">اضافة</button>
                            </div>
                            <div class="form-group mb-3 col-6">
                                <label class="form-label"> تاريخ شهادة الراتب اقل من 5 ايام</label>
                                <input type="checkbox" name="salary_certificate_less_than_5_days"  required/>
                            </div>
                            <div class="form-group mb-3 col-12">
                                <label class="form-label"> الملاحظات</label>
                                <textarea class="form-input form-control" id="" rows="10" name="note"></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- Add more input fields following the same structure -->
                    <div class="d-flex justify-content-end">
                        <a class="btn btn-info next" id="nextStepButton">تابع <i class="fas fa-angle-left"></i></a>
                    </div>
                </section>
            </div>
            <div class="tab-pane fade" role="tabpanel" id="step2" aria-labelledby="step2-tab">
                <h3>معلومات الساينت</h3>
                <section class="section" id="client-files">

                    {{-- <input type="hidden" name="installment_clients" value="{{ $Installment_Client->id }}" /> --}}
                    <div class="form-row row">
                        <div class="form-group mb-3 col-6">
                            <label class="form-label"> اجمالى الدخل
                            </label>
                            <input class="form-input form-control" type="text" id="cinet_total_income" name="cinet_total_income" required readonly style="background-color: #ddd;"/>
                        </div>
                        <div class="form-group mb-3 col-6">
                            <label class="form-label">
                                مجموع الاقساط
                            </label>
                            <input class="form-input form-control" type="text" name="installment_total" id="cinet_installments_total"
                                required />
                        </div>
                        <div class="form-group mb-3 col-6">
                            <label class="block w-full mx-1">
                                الاقساط المتاخرة
                            </label>
                            <input class="form-input form-control" type="text" name="total_lated_installments"
                                required />
                        </div>
                        <div class="form-group mb-3 col-6">
                            <label class="block w-full mx-1">
                                مؤشر قضائي
                            </label>
                            <select class=" form-select form-control" name="legal_indicator">

                                <option value="0">لا</option>
                                <option value="1">نعم</option>
                            </select>

                        </div>
                        <div class="form-group mb-3 col-6">
                            <label class="block w-full mx-1">
                                ديون معدومة
                            </label>
                            <select class="form-control form-select" name="dead_loan">
                                <option value="0">لا</option>
                                <option value="1">نعم</option>
                            </select>

                        </div>
                        <div class="form-group mb-3 col-6">
                            <label class="block w-full mx-1">
                                القسط المسموح
                            </label>
                            <input class="form-input form-control" type="text" name="cinet_amount_limit" id="cinet_amount_limit" style="background-color: #ddd;" readonly/>

                        </div>
                        <div class="form-group mb-3 col-6">
                            <label class="block w-full mx-1">
                                لمت صافي الراتب
                            </label>
                            <input class="form-input form-control" type="text" name="cinet_amount_limit_safi" id="allowed_salary_limit"
                                style="background-color: #ddd;" readonly />

                        </div>
                        <div class="form-group mb-3 col-6">
                            <label class="flex items-center w-full mx-1">
                                ملف الساينت :
                            </label>
                            <input type="file" class="form-input form-control" name="cinet_pdf" required>

                        </div>
                        <div class="form-group mb-3 col-6">
                            <label class="flex items-center w-full mx-1">
                                صورة المدنية :
                            </label>
                            <input type="file" class="form-input form-control" name="upload_img_2" required>

                        </div>
                        <div class="form-group mb-3 col-12">

                            <label class="block w-full mx-1">
                                الملفات
                            </label>
                            <div id="formRows1">
                                <div class="form-row row"  data-index="0">
                                    <div class="form-group mb-3 col-lg-3 col-md-4 col-6">
                                        <label class="flex items-center w-full mx-1">
                                            جهه:
                                        </label>
                                        <select class="form-select" id="ministryfile_dis"
                                            name="installment_client_cinet[0][file_dis_1]" required>
                                            <option value="company">شركة</option>
                                            <option value="bank">بنك</option>
                                            <option value="Installment_discount_card">بطاقة خصم أقساط</option>
                                            <option value="Full_debit_card">بطاقة سحب كامل</option>
                                        </select>

                                    </div>

                                    <div class="form-group mb-3 col-lg-3 col-md-4 col-6">
                                        <label class="flex items-center w-full mx-1">
                                            تاريخ فتح حساب
                                        </label>
                                        <input type="date" class="form-input form-control fileDate"
                                            name="installment_client_cinet[0][file_date_1]" id="fileDate" class="form-control"
                                            required />
                                    </div>

                                    <div class="form-group mb-3 col-lg-3 col-md-4 col-6">
                                        <label class="flex items-center w-full mx-1">
                                            الرصيد المتبقي
                                        </label>
                                        <input type="text" class="form-input form-control"
                                            name="installment_client_cinet[0][file_remindes_amount_1]"
                                            class="form-control" required />
                                    </div>

                                    <div class="form-group mb-3 col-lg-3 col-md-4 col-6">
                                        <label class="flex items-center w-full mx-1">
                                            قيمة القسط
                                        </label>
                                        <input type="text" class="form-input form-control file_installment_amount"
                                            name="installment_client_cinet[0][file_installment_amount_1]" id="file_installment_amount"
                                            class="form-control" required />
                                    </div>

                                    <div class="form-group mb-3 col-lg-3 col-md-4 col-6">
                                        <label class="flex items-center w-full mx-1">
                                            قيمة المديونية
                                        </label>
                                        <input type="text" class="form-input form-control file_debit_amount"
                                            name="installment_client_cinet[0][file_debit_amount_1]" class="form-control" id="file_debit_amount"
                                            required />
                                    </div>
                                    <div class="form-group mb-3 col-lg-3 col-md-4 col-6" id="rescheduleField" style="display: none;">
                                        <label class="flex items-center w-full mx-1">
                                            إعادة الجدولة
                                        </label>
                                        <input type="text" class="form-input form-control rescheduleResult"
                                            name="installment_client_cinet[0][new_loan_date_1]" id="rescheduleResult" required readonly />
                                    </div>
                                    <div class="form-group mb-3 col-lg-3 col-md-4 col-6" id="newLoanField" style="display: none;">
                                        <label class="flex items-center w-full mx-1">
                                            القرض الجديد
                                        </label>
                                        <input type="text" class="form-input form-control newLoanField"
                                            name="installment_client_cinet[0][new_loan_amount_1]" id="new_loan_amount" readonly />
                                    </div>
                                    <div class="form-group mb-3 col-lg-3 col-md-4 col-6">
                                        <label class="flex items-center w-full mx-1">
                                            فتره السداد
                                        </label>
                                        <select class="form-input form-select paymentPeriod"
                                            name="installment_client_cinet[0][file_all_times_1]" id="paymentPeriod">

                                            @for ($i = 0; $i < 200; $i++)
                                                <option value="{{ $i }}">
                                                    {{ $i }}</option>
                                            @endfor


                                        </select>
                                    </div>

                                    {{-- <div class="col">
                                            <button type="button" class="btn remove-row-btn1"
                                                style="background-color: red;color: #fff; width: 50px;">ازالة</button>
                                        </div> --}}
                                </div>
                            </div>

                        </div>
                        <div class="form-group mb-3 col-6">

                            <button type="button" class="btn btn-secondary"
                                style="background-color: green; color:white;" id="addRowBtn2">اضافة
                            </button>

                        </div>

                        <div class="d-flex justify-content-between">
                            <a class="btn btn-secondary previous"><i class="fas fa-angle-right"></i> رجوع</a>
                            <button type="submit" class="btn btn-info ">تأكيد <i class="fas fa-angle-left"></i></button>
                            {{-- <button type="submit" class="btn btn-info next" id="submit-btn" style="display: none;" >حفظ</button> --}}
                        </form>
                        </div>

                    {{-- </form> --}}
                    </section>

            </div>

      </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script>
    document.getElementById('civil_number').addEventListener('blur', function() {
        const civilNumber = this.value;
        const installmentClientId = document.querySelector('input[name="installment_clients"]').value;
        const errorElement = document.getElementById('civil-number-error');

        if (civilNumber && installmentClientId) {
            fetch('{{ route('checkCivilNumber_accept') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        civil_number: civilNumber,
                        installment_clients: installmentClientId // Send the client ID
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.exists) {
                        console.log('exist');
                        errorElement.style.display = 'none';
                    } else {
                        console.log('notexist');
                        errorElement.style.display = 'block';
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    });
</script>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
        const totalIncomeInput = document.getElementById('cinet_total_income');
        const totalInstallmentsInput = document.getElementById('cinet_installments_total');
        const allowedInstallmentInput = document.getElementById('cinet_amount_limit');
        const netSalaryInput = document.getElementById('net_salary');
        const allowedSalaryLimitInput = document.getElementById('allowed_salary_limit');


        if (totalIncomeInput && totalInstallmentsInput && allowedInstallmentInput) {
            function calculateAllowedInstallment() {
                const totalIncome = parseFloat(totalIncomeInput.value) || 0;
                const netSalary = parseFloat(netSalaryInput.value) || 0;
                const totalInstallments = parseFloat(totalInstallmentsInput.value) || 0;
                const allowedInstallment = (totalIncome * 0.4) - totalInstallments;
                const allowedSalaryLimit = (netSalary * 0.4) - totalInstallments;
                allowedInstallmentInput.value = allowedInstallment.toFixed(2);
                allowedSalaryLimitInput.value = allowedSalaryLimit.toFixed(2);
            }

            // Trigger calculation on input changes
            totalIncomeInput.addEventListener('input', calculateAllowedInstallment);
            netSalaryInput.addEventListener('input', calculateAllowedInstallment);
            totalInstallmentsInput.addEventListener('input', calculateAllowedInstallment);
        } else {
            console.error("One or more elements are missing.");
        }
    });
</script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
        const ministryElement = document.getElementById('ministryfile_dis');
        const rescheduleField = document.getElementById('rescheduleField');
        const newLoanField = document.getElementById('newLoanField');

        if (!ministryElement || !rescheduleField || !newLoanField) {
            console.error("One or more elements are missing from the DOM.");
            return;
        }

        ministryElement.addEventListener('change', function() {
            const ministryValue = ministryElement.value;
            console.log('Selected ministry value:', ministryValue);

            if (ministryValue === 'bank') {
                rescheduleField.style.display = 'block';
                newLoanField.style.display = 'block';
                console.log('Showing fields');
            } else {
                rescheduleField.style.display = 'none';
                newLoanField.style.display = 'none';
                console.log('Hiding fields');
            }
        });
    });
</script>

<script>
    document.getElementById("file_installment_amount").addEventListener("input", calculateNewLoan);
    document.getElementById("file_debit_amount").addEventListener("input", calculateNewLoan);

    function calculateNewLoan() {
        const installmentAmount = parseFloat(document.getElementById("file_installment_amount").value) || 0;
        const debitAmount = parseFloat(document.getElementById("file_debit_amount").value) || 0;

        const newLoan = (installmentAmount * 115) - debitAmount;

        document.getElementById("new_loan_amount").value = newLoan.toFixed(2);
    }
</script>

  <script>
    document.addEventListener('input', function(e) {
        if (e.target && e.target.id === 'paymentPeriod' || e.target.id === 'fileDate') {
            calculateReschedule(e.target.closest('.form-row'));
        }
        if (e.target && (e.target.id === 'file_installment_amount' || e.target.id === 'file_debit_amount')) {
            calculateNewLoanAmount(e.target.closest('.form-row'));
        }
    });

    function calculateReschedule(row) {
        const period1 = parseFloat(row.querySelector('.paymentPeriod').value) || 0;
        const fileDate1 = row.querySelector('.fileDate').value;
        const rescheduleField1 = row.querySelector('.rescheduleResult');

        if (!fileDate1 || period1 === 0) {
            rescheduleField1.value = ''; // Clear the result if the input is invalid
            return;
        }

        // Get the current date
        const currentDate = new Date();
        const fileDateObj = new Date(fileDate1);

        // Calculate the difference in months between the current date and the file date
        const monthsDifference = (currentDate.getFullYear() - fileDateObj.getFullYear()) * 12 + (currentDate.getMonth() - fileDateObj.getMonth());

        // Calculate rescheduling: (فترة السداد * 30%) - months difference
        const reschedule1 = (period1 * 0.3) - monthsDifference;

        // Display the result
        rescheduleField1.value = reschedule1.toFixed(2);
    }

    function calculateNewLoanAmount(row) {
        // Get the value of "قيمة القسط" and "المديونية" for the specific row
        const installmentAmount = parseFloat(row.querySelector('.file_installment_amount').value) || 0;
        const debitAmount = parseFloat(row.querySelector('.file_debit_amount').value) || 0;

        // Calculate the new loan amount: (قيمة القسط * 115) - المديونية
        const newLoanAmount = (installmentAmount * 115) - debitAmount;

        // Get the "القرض الجديد" field for the row
        const newLoanField = row.querySelector('.newLoanField');

        // Check if the field exists and update it
        if (newLoanField) {
            newLoanField.querySelector('input').value = newLoanAmount.toFixed(2);
        }
    }
</script>

  <script>
    $(document).ready(function() {
        // Enable Tooltips
        var tooltipTriggerList = [].slice.call(
            document.querySelectorAll('[data-bs-toggle="tooltip"]')
        );
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Validation for required inputs in Step 1
        function isStep1Valid() {
            let isValid = true;
            $('#step1 input[required], #step1 select[required]').each(function() {
                if (!this.checkValidity()) {
                    isValid = false;
                    return false;  // Exit each loop
                }
            });
            return isValid;
        }

        // Advance Tabs only if Step 1 is valid
        $("#nextStepButton").click(function(event) {
            if (isStep1Valid()) {
                // Move to the next tab if Step 1 is valid
                const nextTabLinkEl = $(".nav-tabs .active")
                    .closest("li")
                    .next("li")
                    .find("a")[0];
                const nextTab = new bootstrap.Tab(nextTabLinkEl);
                nextTab.show();
            } else {
                alert("Please fill in all required fields in Step 1.");
                event.preventDefault();  // Stop default action
            }
        });

        // Allow going back without validation
        $(".previous").click(function() {
            const prevTabLinkEl = $(".nav-tabs .active")
                .closest("li")
                .prev("li")
                .find("a")[0];
            const prevTab = new bootstrap.Tab(prevTabLinkEl);
            prevTab.show();
        });
    });
</script>

  <script>
    document.getElementById('addRowBtn').addEventListener('click', function() {
        const formRows = document.getElementById('formRows');
        const index = formRows.children.length;
        // ////////////////////////

                // /////////////////////////
        const newRow = document.createElement('div');
        newRow.classList.add('row', 'issue-row', 'mb-3');
        newRow.setAttribute('data-index', index);
        newRow.innerHTML = `
            <div class="form-group mb-3 col-3">
                <label class="form-label"> جهه الدخل</label>
                <select class="form-input form-select" name="installment[${index}][working_compang]" required>
                <option value="">اختر</option>
                    @foreach ($ministry as $item)
                        <option value="{{ $item->id }}">{{ $item->name_ar }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-3 col-3">
                <label class="form-label"> الراتب</label>
                <input type="text" class="form-input form-control salary" name="installment[${index}][salary]" required />
            </div>

            <div class="form-group mb-3 col-3">
                <label class="form-label"> اسم البنك</label>
                <select class="form-input form-select" name="installment[${index}][bank]" required>
                <option value="">اختر</option>
                    @foreach ($bank as $item)
                        <option value="{{ $item->id }}">{{ $item->name_ar }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-3 col-3">
                <label class="form-label"> ارفاق صورة</label>
                <input type="file" class="form-input form-control" name="installment[${index}][image]" required />
            </div>
        `;
        formRows.appendChild(newRow);

        const netSalaryInput = document.querySelector('input[name="installment[0][netSalary]"]');
            const installmentsTotalInput = document.querySelector('input[name="cinet_installments_total"]');
            const netSalaryLimitInput = document.querySelector('input[name="cinet_amount_limit_safi"]');
            const netCinetLimitInput = document.getElementById('cinet_amount_limit');
            const netCinetTotalInput = document.getElementById('cinet_total_income');

            function calculateNetSalaryLimit() {
    // Parse values from inputs, defaulting to 0 if empty
    const netSalary = parseFloat(netSalaryInput.value) || 0;
    const netCinet = parseFloat(netCinetTotalInput.value) || 0;
    const installmentsTotal = parseFloat(installmentsTotalInput.value) || 0;

    // Calculate the Net Salary Limit
    const netSalaryLimit = (netSalary * 0.4) - installmentsTotal;
    const netCinetLimit = (netCinet * 0.4) - installmentsTotal;

    if (netCinetLimit < 0) {
        netCinetLimit = 0;
    }
    // Display result in the Net Salary Limit input field
    netSalaryLimitInput.value = netSalaryLimit.toFixed(2);
    netCinetLimitInput.value = netCinetLimit.toFixed(2);
}

// Event listeners for input changes
netSalaryInput.addEventListener('input', calculateNetSalaryLimit);
installmentsTotalInput.addEventListener('input', calculateNetSalaryLimit);
netCinetTotalInput.addEventListener('input', calculateNetSalaryLimit);
        // Re-run remove row functionality and re-add event listener for new salary input
        addRemoveRowFunctionality();
        addSalaryInputListener(newRow.querySelector('.salary'));
        calculateTotalSalary();  // Recalculate total after adding the new row
    });

    // Function to handle salary total calculation
    function calculateTotalSalary() {
        let totalSalary = 0;
        document.querySelectorAll('.salary').forEach(input => {
            const value = parseFloat(input.value) || 0;
            totalSalary += value;
        });
        document.getElementById('cinet_total_income').value = totalSalary.toFixed(2);
    }

    // Add event listener to salary input to update total on change
    function addSalaryInputListener(input) {
        input.addEventListener('input', calculateTotalSalary);
    }

    // Function to activate remove buttons and reindex rows
    function addRemoveRowFunctionality() {
        document.querySelectorAll('.remove-row-btn').forEach(button => {
            button.onclick = function() {
                const row = this.closest('.issue-row');
                row.remove();
                updateRowIndices();
                calculateTotalSalary();  // Recalculate after removing a row
            };
        });
    }

    // Function to update indices of form inputs after adding/removing rows
    function updateRowIndices() {
        document.querySelectorAll('.issue-row').forEach((row, index) => {
            row.setAttribute('data-index', index);
            row.querySelector('[name*="working_compang"]').setAttribute('name', `installment[${index}][working_compang]`);
            row.querySelector('[name*="salary"]').setAttribute('name', `installment[${index}][salary]`);
            row.querySelector('[name*="bank"]').setAttribute('name', `installment[${index}][bank]`);
            row.querySelector('[name*="image"]').setAttribute('name', `installment[${index}][image]`);
        });
    }

    // Initial call to activate remove buttons and add listeners for existing salary inputs
    addRemoveRowFunctionality();
    document.querySelectorAll('.salary').forEach(addSalaryInputListener);


</script>

  <script>
      // script.js
      function showSection(sectionId) {
          // Remove active class from all tabs
          const tabs = document.querySelectorAll(".tab");
          tabs.forEach(tab => tab.classList.remove("active"));

          // Hide all sections
          const sections = document.querySelectorAll(".section");
          sections.forEach(section => section.classList.add("hidden"));

          // Show the selected section and activate the corresponding tab
          document.getElementById(sectionId).classList.remove("hidden");
          tabs[Array.from(sections).findIndex(section => section.id === sectionId)].classList.add("active");
      }
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const salaryInputs = document.querySelectorAll('.salary');
        const totalIncomeInput = document.getElementById('cinet_total_income');

        function calculateTotalSalary() {
            let totalSalary = 0;
            salaryInputs.forEach(input => {
                const value = parseFloat(input.value) || 0;
                totalSalary += value;
            });
            totalIncomeInput.value = totalSalary.toFixed(2); // Update the total in the next tab
        }

        salaryInputs.forEach(input => {
            input.addEventListener('input', calculateTotalSalary);
        });
    });
    </script>
    {{-- //////////////////////////////////////////////// --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
    const formRows1 = document.getElementById('formRows1');

    // Function to add a new row
    document.getElementById('addRowBtn2').addEventListener('click', function () {
        const index1 = formRows1.children.length;

        const newRow1 = document.createElement('div');
        newRow1.classList.add('row', 'issue-row1', 'mb-3');
        newRow1.setAttribute('data-index', index1);

        newRow1.innerHTML = `
            <div class="form-group mb-3 col-lg-3 col-md-4 col-6">
                <label class="flex items-center w-full mx-1">جهه:</label>
                <select class="form-select" id="ministryfile_dis_${index1}"
                        name="installment_client_cinet[${index1}][file_dis_1]" required>
                    <option value="company">شركة</option>
                    <option value="bank">بنك</option>
                    <option value="Installment_discount_card">بطاقة خصم أقساط</option>
                    <option value="Full_debit_card">بطاقة سحب كامل</option>
                </select>
            </div>
            <div class="form-group mb-3 col-lg-3 col-md-4 col-6">
                <label class="flex items-center w-full mx-1">تاريخ فتح حساب</label>
                <input type="date" class="form-input form-control"
                       name="installment_client_cinet[${index1}][file_date_1]" class="form-control" required />
            </div>
            <div class="form-group mb-3 col-lg-3 col-md-4 col-6">
                <label class="flex items-center w-full mx-1">الرصيد المتبقي</label>
                <input type="text" class="form-input form-control"
                       name="installment_client_cinet[${index1}][file_remindes_amount_1]" class="form-control" required />
            </div>
            <div class="form-group mb-3 col-lg-3 col-md-4 col-6">
                <label class="flex items-center w-full mx-1">قيمة القسط</label>
                <input type="text" class="form-input form-control"
                       name="installment_client_cinet[${index1}][file_installment_amount_1]" class="form-control" required />
            </div>
            <div class="form-group mb-3 col-lg-3 col-md-4 col-6">
                <label class="flex items-center w-full mx-1">قيمة المديونية</label>
                <input type="text" class="form-input form-control"
                       name="installment_client_cinet[${index1}][file_debit_amount_1]" class="form-control" required />
            </div>
            <div class="form-group mb-3 col-lg-3 col-md-4 col-6" id="rescheduleField_${index1}" style="display: none;">
                <label class="flex items-center w-full mx-1">إعادة الجدولة</label>
                <input type="text" class="form-input form-control"
                       name="installment_client_cinet[${index1}][new_loan_date_1]" class="form-control" required readonly />
            </div>
            <div class="form-group mb-3 col-lg-3 col-md-4 col-6" id="newLoanField_${index1}" style="display: none;">
                <label class="flex items-center w-full mx-1">القرض الجديد</label>
                <input type="text" class="form-input form-control"
                       name="installment_client_cinet[${index1}][new_loan_amount_1]" class="form-control" required />
            </div>
            <div class="form-group mb-3 col-lg-3 col-md-4 col-6">
                <label class="flex items-center w-full mx-1">فتره السداد</label>
                <select class="form-input form-select"
                        name="installment_client_cinet[${index1}][file_all_times_1]" id="paymentPeriod_${index1}">
                    @for ($i = 0; $i < 200; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>
        `;

        formRows1.appendChild(newRow1);

        // Add event listeners to the new row
        addEventListenersToNewRow(index1);
    });

    // Function to add event listeners to new row
    function addEventListenersToNewRow(index) {
        // Select the paymentPeriod and fileDate inputs for this row
        const paymentPeriod = document.querySelector(`#paymentPeriod_${index}`);
        const fileDate = document.querySelector(`input[name="installment_client_cinet[${index}][file_date_1]"]`);
        const rescheduleField = document.querySelector(`input[name="installment_client_cinet[${index}][new_loan_date_1]"]`);
        const installmentAmountField = document.querySelector(`input[name="installment_client_cinet[${index}][file_installment_amount_1]"]`);
        const debtAmountField = document.querySelector(`input[name="installment_client_cinet[${index}][file_debit_amount_1]"]`);
        const newLoanAmountField = document.querySelector(`input[name="installment_client_cinet[${index}][new_loan_amount_1]"]`);

        const ministryfileDis = document.getElementById(`ministryfile_dis_${index}`);
            const rescheduleFieldsec = document.getElementById(`rescheduleField_${index}`);
            const newLoanField = document.getElementById(`newLoanField_${index}`);

            ministryfileDis.addEventListener('change', function() {
                if (ministryfileDis.value === 'bank') {
                    rescheduleFieldsec.style.display = 'block';
                    newLoanField.style.display = 'block';
                } else {
                    rescheduleFieldsec.style.display = 'none';
                    newLoanField.style.display = 'none';
                }
            });
        // Add the input event listener to recalculate when paymentPeriod is changed
        paymentPeriod.addEventListener('input', function() {
            calculateReschedule(index);
            calculateNewLoanAmount(index);
        });

        // Add the change event listener to recalculate when fileDate is changed
        fileDate.addEventListener('change', function() {
            calculateReschedule(index);
            calculateNewLoanAmount(index);
        });
        installmentAmountField.addEventListener('input', function() {
            calculateNewLoanAmount(index);
        });

        debtAmountField.addEventListener('input', function() {
            calculateNewLoanAmount(index);
        });

        // Calculate initial reschedule value when a new row is added
        calculateReschedule(index);
        calculateNewLoanAmount(index);
    }

    // Function to calculate reschedule
    function calculateReschedule(index) {
        const period = parseFloat(document.querySelector(`#paymentPeriod_${index}`).value) || 0;
        const fileDate = document.querySelector(`input[name="installment_client_cinet[${index}][file_date_1]"]`).value;
        const rescheduleField = document.querySelector(`input[name="installment_client_cinet[${index}][new_loan_date_1]"]`);

        if (!fileDate || period === 0) {
            rescheduleField.value = ''; // Clear the result if the input is invalid
            return;
        }

        // Get the current date
        const currentDate = new Date();
        const fileDateObj = new Date(fileDate);

        // Calculate the difference in months between the current date and the file date
        const monthsDifference = (currentDate.getFullYear() - fileDateObj.getFullYear()) * 12 + (currentDate.getMonth() - fileDateObj.getMonth());

        // Calculate rescheduling: (فترة السداد * 30%) - months difference
        const reschedule = (period * 0.3) - monthsDifference;

        // Display the result
        rescheduleField.value = reschedule.toFixed(2);
    }
    function calculateNewLoanAmount(index) {
        const installmentAmount = parseFloat(document.querySelector(`input[name="installment_client_cinet[${index}][file_installment_amount_1]"]`).value) || 0;
        const debtAmount = parseFloat(document.querySelector(`input[name="installment_client_cinet[${index}][file_debit_amount_1]"]`).value) || 0;
        const newLoanAmountField = document.querySelector(`input[name="installment_client_cinet[${index}][new_loan_amount_1]"]`);

        // Calculate القرض الجديد: (قيمة القسط * 115) - المديونية
        const newLoanAmount = (installmentAmount * 115) - debtAmount;

        // Display the result
        newLoanAmountField.value = newLoanAmount.toFixed(2);
    }

    // Initialize the event listeners for existing rows
    formRows1.querySelectorAll('.issue-row1').forEach((row, index) => {
        addEventListenersToNewRow(index);
    });
});
        </script>
