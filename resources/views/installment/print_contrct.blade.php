<!DOCTYPE html>
<html dir="rtl" lang="ar" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="horizontal">

<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Favicon icon-->
    <link rel="shortcut icon" type="image/png" href="{{asset('assets/images/logos/logo.jpg')}}"/>

    <!-- Core Css -->
    <link rel="stylesheet" href="{{asset('assets/css/styles.css')}}"/>

    <title>Electron</title>
    <link rel="stylesheet" href="{{asset('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}">
</head>

<body>
<div class="container ">
    <div class="border-bottom">
        <div class="text-center py-1">
            <h5> اتفاقية بيع بالأقساط
            </h5>
        </div>
        <div class="  d-md-flex d-sm-block justify-content-between">

            <h6>شركة الكترون للأجهزة الالكترونية ذ.م.م</h6>
            <h6>ELECTRON COMPANY L.L.C</h6>
        </div>
        @php
            \Carbon\Carbon::setlocale("ar");
            $day_name= \Carbon\Carbon::today()->translatedFormat('l');
            $user_name=\Illuminate\Support\Facades\Auth::user()->name_ar;
        @endphp


        <div class="  d-md-flex d-sm-block justify-content-between">

            <h6>التاريخ: <span>
                    {{$day_name}} {{date('Y-m-d')}}</span></h6>

            <h6>رقم المعاملة : <span>{{$installment->id}}</span></h6>
        </div>
    </div>
    {{-- {{ dd($client->client_address->last()) }} --}}
    <div class="row">
        <div class="col-12  ">
            <p class="text-dark">انه فى تاريخ أعلاه تم الاتفاق بين كل من : </p>

            <p class="text-dark">أولا : شركة إلكترون للأجهزة الإلكترونية ذ.م.م <br>
                ومقرها الرئيسي : الجهراء - شارع عين جالوت - مجمع علياء - الدور الأول </p>
            <p class="text-dark d-flex justify-content-end"> ( طرف أول )</p>

            <div class=" d-flex justify-content-between">
                <div class="col-md-6 col-sm-12">
                    <p class="text-dark">ثانيا :العميل : {{$client->name_ar}}</p>
                    <p class="text-dark"> العنوان 
                        : المنطقة : 
                        {{$client->client_address->last()->area}} -
                         قطعة : 
                         {{$client->client_address->last()->block}} -
                         - شارع
                        : {{$client->client_address->last()->street}} - 
                        مبني
                        : {{$client->client_address->last()->building}} -
                        جادة :
                        {{$client->client_address->last()->jada != "0" ? $client->client_address->last()->jada : ""}} -
                        الدور :
                        {{$client->client_address->last()->floor != "0" ? $client->client_address->last()->floor : ""}} -
                        الشقة :
                        {{$client->client_address->last()->flat != "0" ? $client->client_address->last()->flat : ""}} -
                        الرقم الالى  :
                        {{$client->client_address->last()->house_id}}
                    </p>
                    
                    <p class="text-dark"> جهة العمل
                     @if($client->client_ministrey)
                        جهة العمل : {{\App\Models\Ministry::find($client->client_ministrey->first()->ministry_id)->name_ar}}
                        @endif
                    </p>

                </div>

                <div class="col-md-6 col-sm-12">
                    <p class="text-dark">
                        الجنسية : {{{$client->nationality->name_ar}}}</p>
                    <p class="text-dark"> بطاقة مدنية رقم : {{$client->civil_number}}</p>
                    <p class="text-dark"> الهاتف النقال : {{$client->client_phone->last()->phone}}</p>
                    <p class="text-dark d-flex justify-content-end"> ( طرف الثاني )</p>
                </div>
            </div>
            <div class="col-12 ">
                <p class="text-dark">حيث أقر جميع الأطراف بأهليتهم للتعاقد والتصرف واتفاقهم على الآتي :
                    <br>
                    تمهيد
                    <br>
                    لما كان الطرف الثاني قد رغب في شراء الأجهزة وطلب من الطرف الأول تقسيط الأجهزة
                    المطلوبة
                    والمذكورة في فاتورة الشراء الرسمية , وحيث ارتضى الطرف الأول تقسيط المبلغ
                    المطلوب من الطرف الثاني بالمبلغ
                    الموضح بالجدول فقد تم الاتفاق على تنظيم تلك العلاقة وفقا للمبين بالجدول التالي وبنود العقد التالية
                    له
                </p>

                <table class="table table-bordered border">

                    <tbody>
                    @php
                        $all_madion_amount=round(($installment->installment*$installment->months ),0);
                        $last_amoun_required=((($installment->amount-$installment->first_amount)*25)/100);
                    @endphp
                    <tr style="border: 1px solid black !important;">
                        <th style="border: 1px solid black !important;" scope="row">المبلغ المستحق</th>
                        <td style="border: 1px solid black !important;">{{number_format(($all_madion_amount ), 3, '.', ',')}} دك</td>
                        <td style="border: 1px solid black !important;">تاريخ تسديد القسط الأول</td>
                        <td style="border: 1px solid black !important;">{{$installment->start_date}}</td>
                    </tr>
                    <tr style="border: 1px solid black !important;">
                        <th style="border: 1px solid black !important;" scope="row">القسط</th>
                        <td style="border: 1px solid black !important;">{{$installment->installment}} دك</td>
                        <td style="border: 1px solid black !important;">تاريخ تسديد القسط الأخير</td>
                        <td style="border: 1px solid black !important;">{{\Carbon\Carbon::parse($installment->start_date)->addMonth($installment->months)->subMonth(1)->format('Y-m-d')}}</td>
                    </tr>
                    <tr style="border: 1px solid black !important;">

                        <td style="border: 1px solid black !important;"> مدة الاتفاق</td>
                        <td style="border: 1px solid black !important;">{{$installment->months}} شهر</td>
                    </tr>


                    </tbody>
                </table>
                <p class="text-dark ">البند الأول : يعد التمهيد السابق والجدول الملحق به جزء لا يتجزأ من هذه الاتفاقية
                    ومكملاً لها ويأخذ حكم أحد بنودها .</p>
                <p class="text-dark ">البند الثاني : يتعهد بسداد الرصيد المستحق على أقساط شهرية كما هو مبين بالجدول
                    السابق , ويكون السداد فى مكتب الطرف الأول أو اى عنوان أخر يحدده الطرف الأول وتكون جميع الدفعات
                    مسؤولية الطرف الثاني إلى أن تصل إلى الطرف الأول .</p>
                <p class="text-dark ">البند الثالث : لا يحق للطرف الثاني أن يمتنع أو يتأخر عن دفع الأقساط المستحقة بموجب
                    هذه الاتفاقية لأي سبب من الأسباب .</p>
                <p class="text-dark ">البند الرابع : يقر الطرف الثاني بان العناوين المبينة أعلاه ووسائل الاتصال والبريد
                    هي العناوين الوحيده المعتمده في إرسال أية مراسلات أو إعلانات قضائية ما لم يخطر الطرف الثاني الطرف
                    الأول كتابيا بتغييره وأن البيانات والمعلومات المذكورة صحيحة وبأنه وفى حالة تأخير الطرف الثاني عن دفع
                    أي قسط من الأقساط الموضحة في الجدول السابق في موعد استحقاقه وكذلك في حالة الإفلاس أو الإعسار أو
                    الوفاة فان باقي قيمة القرض وملحقاته من مصاريف وغيرها تعتبر مستحقة الأداء فورا وبدون حاجة الى تنبيه
                    أو إنذار ويكون من حق الطرف الأول الرجوع على الطرف الثاني بكامل الرصيد المتبقي من القيمة الإجمالية
                    للأقساط وفوائد التأخير القانونية المستحقة حتى تاريخ السداد وجميع الرسوم والمصاريف والنفقات القانونية
                    وأتعاب المحاماة الفعلية التى يقوم بها الطرف الأول بدفعها والتى يقر الطرف الثاني بالتزامه الصريح بها
                    منذ الآن ويكون للطرف الأول حق الامتياز العام على البضاعة موضوع الاتفاقية فى استيفاء دينة وذلك
                    بالأولوية على جميع الدائنين الآخرين .</p>
                <p class="text-dark ">البند الخامس : للطرف الأول كامل الحق وفقا لخياره بالقيام بخصم السندات الاذنية (
                    الكمبيالات ) الموقعة من الطرف الثاني لدى البنك أو تظهيرها للغير دون أن يتوقف ذلك على رضاء وموافقة
                    الطرف الثاني ودون الحاجة إلى إخطار الطرف الثاني بهذا التظهير , ولا تعتبر هذه السندات الاذنية
                    استبدالاً للدين المستحق أو سداداً أو تجديداً له بل إثباتاً للدين وتأكيداً له .</p>
                <p class="text-dark ">البند السادس : يحتفظ الطرف الأول صراحة لنفسه بحق التنازل عن هذه الاتفاقية وعن كافة
                    الحقوق المقررة بها ويحق له تحويلها كليا وجزئيا للغير أو لمن يشاء دون أن يحق للطرف الثاني الاعتراض
                    على ذلك , إلا إنه لا يحق للطرف الثاني تحويل حقوقه أو التزاماته بموجب هذه الاتفاقية إلى الغير .</p>
                <p class="text-dark ">البند السابع : يفوض الطرف الثانى ( العميل ) . بموجب هذا الطرف الاول ( الشركة )
                    تفويضا غير قابل للإلغاء أو الرجوع في تبادل كافة المعلومات عنه وعن حساباته من البنوك والجهات المشاركة
                    فى نظام تجميع البيانات والمعلومات , المقرر بموجب القانون رقم (2) لسنة 2001 فى شان إنشاء نظام لجميع
                    المعلومات والبيانات الخاصة بالقروض الاستهلاكية ونظام مركزية المخاطر كما يفوضه أيضا في الحصول من
                    الهيئة العامة للمعلومات المدنية على عنوان كل من سكنه وعمله وما قد يطرأ عليهما من تغيير ويصرح بتزويد
                    الهيئة والجهات الأخرى ذات العلاقة بهذا التفويض , وذلك دون أدنى مسؤولية في هذا الخصوص على الشركة أو
                    الهيئة أو الجهات المشار إليها أعلاه .</p>
                <p class="text-dark ">البند الثامن : يقر الطرف الثاني بان كافة التزاماته ( النقدية والغير نقدية )
                    المترصدة بذمته بما في ذلك مديونيته للطرف الأول عن الحساب المبين في الاتفاقية لا تتعدى الشروط المعلنة
                    من قبل بنك الكويت المركزي خاصة فيما يتعلق بعدم تجاوز أقساط القروض الاستهلاكية والقروض المقسطة التي
                    يحصل عليها العميل عن 40% من صافى الدخل الشهري المستمر للعميل بعد الاستقطاعات , ( أو عن 30% بالنسبة
                    للقروض المقدمه للمتقاعدين ) ويقر أيضا إن الحد الأقصى للقروض الاستهلاكية وغيرها من القروض المقسطة
                    الممنوحة له شاملة المبلغ موضوع الاتفاقية الماثلة , لا تتجاوز خمسة عشر أمثال صافى الدخل الشهري
                    بالنسبة للقرض الاستهلاكى وبحد أقصى خمسة عشر ألف دينار كويتي , ولا تتجاوز 70 ألف دينار كويتي بالنسبة
                    للقروض المقسطة ومن ضمنه الحد الأقصى للقروض الاستهلاكية .</p>
                <p class="text-dark ">البند التاسع : يقر الطرف الثاني بان كافة المستندات والأوراق والمعلومات المقدمة
                    منهم للطرف الأول هي جميعا صحيحة وسارية وتم تقديمها تحت مسئوليته الشخصية ويتعهد بإخطار الطرف الأول
                    عند تغيير أو تجديد أي منها وفى حالة اتضاح غير ذلك يعتبر ذلك إخلال بشرط جوهري من شروط العقد من قبلهم
                    ويحق للطرف الأول الرجوع عليهم قضاء .</p>
                <p class="text-dark ">البند العاشر : اتفق الطرفان على انه يحق للطرف الأول أن يتحقق من الموقف المالي
                    للطرف الثاني وأيا من البيانات المتعلقة بالاتفاقية في أي وقت يشاء طوال فترة سريان الاتفاقية وحتى
                    السداد التام وحالة رفض الطرف الثاني ذلك فانه يحق للطرف الأول المطالبة بكامل المبلغ المترصد في ذمته .
                </p>
                <p class="text-dark ">البند الحادي عشر : يقر الطرف الثاني بموافقته على سداد قيمة الأقساط الشهرية
                    المستحقة عليه خصماً من حسابه لدى البنك مباشرة وفى حال تعذر تلك الوسيلة من وسائل الدفع أو عدم رغبته
                    في ذلك يكون ملزماً بسداد الرسوم الخاصة بخدمة خيارات الدفع والمحددة سلفاً من إدارة الشركة .</p>
                <p class="text-dark ">البند الثاني عشر : يقر الطرف الثاني بالإفصاح عن الأطراف المدينة المرتبطة معه
                    اقتصادياً أو قانونياً لدى الشركة على اعتبارهم عميلاً واحداً سواء كان هذا الارتباط عن طريق الملكية أو
                    الإدارة المشتركة وتزويد الشركة بالبيانات المالية والافصاحات المتعلقة على أساس دوري طوال فترة سداد
                    الأقساط أو عند طلبها .</p>
                <p class="text-dark ">البند الثالث عشر : يقر أطراف هذه الاتفاقية بأنهم قد اطلعوا على بنودها وملحقاتها
                    ومرفقتها , ووافقوا عليها وارتضوا بأحكامها وذيلوها بتوقيعاتهم واستلم كل منهم نسخة للعمل بموجبها عند
                    اللزوم .</p>
                <p class="text-dark ">البند الرابع عشر : حررت هذه الاتفاقية في الكويت في التاريخ الموضح أعلاه من نسختين
                    بيد كل طرف نسخة , وكل نزاع قد ينشأ عن تنفيذ أحكامها يكون الفصل فيه من اختصاص محكمة الكويت الكلية
                    ومحاكم العاصمة الجزئية أيا كان محل إقامة الطرف الثاني .</p>

            </div>
            <div class="col-12  d-flex justify-content-between">
                <div class="col-md-5 col-sm-12">
                    <p class="text-dark text-underline fw-bolder">الطرف الأول</p>
                    <p class="text-dark">شركة إلكترون للأجهزة الإلكترونية </p>

                </div>

                <div class="col-md-7 col-sm-12">
                    <p class="text-dark text-underline fw-bolder">الطرف الثاني</p>
                    <p class="text-dark"> ( العميل )</p>
                    <p class="text-dark">الاسم :</p>
                    <p class="text-dark"> التوقيع :</p>
                </div>
            </div>


        </div>

    </div>

    <script src="{{asset('assets/js/vendor.min.js')}}"></script>
    <!-- Import Js Files -->
    <script src="{{asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/libs/simplebar/dist/simplebar.min.js')}}"></script>
    <script src="{{asset('assets/js/theme/app.horizontal.init.js')}}"></script>
    <script src="{{asset('assets/js/theme/theme.js')}}"></script>
    <script src="{{asset('assets/js/theme/app.min.js')}}"></script>
    <script src="{{asset('assets/js/theme/sidebarmenu.js')}}"></script>
    <script src="{{asset('assets/js/theme/feather.min.js')}}"></script>

    <!-- solar icons -->
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
    <script src="{{asset('assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/js/datatable/datatable.init.js')}}"></script>
</body>

</html>
