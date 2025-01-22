@extends('ClientDashboard.layouts.app')

@section('crumb')
    <span> الأسئلة المتكررة</span>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="text-center mb-7">
            <h3 class="fw-semibold">الأسئلة المتكررة
            </h3>
            <p class="fw-normal mb-0 fs-4">تعرف على المزيد حول لوحة تحكم المشرف الجاهزة للاستخدام
            </p>
        </div>
        <div class="accordion accordion-flush mb-5 card position-relative overflow-hidden"
            id="accordionFlushExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingOne">
                    <button class="accordion-button collapsed fs-4 fw-semibold shadow-none"
                        type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne"
                        aria-expanded="false" aria-controls="flush-collapseOne">
                        ما هي لوحة تحكم المشرف؟
                    </button>
                </h2>
                <div id="flush-collapseOne" class="accordion-collapse collapse"
                    aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body fw-normal">
                        لوحة تحكم المشرف هي الواجهة الخلفية لموقع ويب أو تطبيق
                        يساعد على إدارة
                        المحتوى والإعدادات العامة للموقع. يتم استخدامه على نطاق واسع من قبل أصحاب
                        الموقع
                        لتتبع
                        موقعهم الإلكتروني،
                        إجراء تغييرات على محتواها، وأكثر من ذلك.

                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingTwo">
                    <button class="accordion-button collapsed fs-4 fw-semibold shadow-none"
                        type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo"
                        aria-expanded="false" aria-controls="flush-collapseTwo">
                        ما الذي يجب أن يتضمنه قالب لوحة تحكم المشرف؟
                    </button>
                </h2>
                <div id="flush-collapseTwo" class="accordion-collapse collapse"
                    aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body fw-normal">
                        يجب أن يتضمن قالب لوحة تحكم المشرف تصميمًا صديقًا للمستخدم وتحسين محركات
                        البحث مع ملف
                        مجموعة متنوعة من المكونات
                        و
                        تصميمات التطبيقات للمساعدة في إنشاء تطبيق الويب الخاص بك بسهولة. هذا
                        يمكن أن تشمل
                        التخصيص
                        الخيارات والدعم الفني وحوالي 6 أشهر من التحديثات المستقبلية.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingThree">
                    <button class="accordion-button collapsed fs-4 fw-semibold shadow-none"
                        type="button" data-bs-toggle="collapse"
                        data-bs-target="#flush-collapseThree" aria-expanded="false"
                        aria-controls="flush-collapseThree">
                        لماذا يجب أن أشتري قوالب الإدارة من Wrappixel؟
                    </button>
                </h2>
                <div id="flush-collapseThree" class="accordion-collapse collapse"
                    aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body fw-normal">
                        يقدم Wrappixel قوالب عالية الجودة سهلة الاستخدام وكاملة
                        قابل للتخصيص. مع أكثر
                        101,801
                        عملاء سعداء وموثوقون من قبل أكثر من 10,000 شركة. يتم التعرف على Wrappixel
                        على أنه
                        الرائدة على الانترنت
                        مصدر
                        لشراء قوالب المشرف.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingfour">
                    <button class="accordion-button collapsed fs-4 fw-semibold shadow-none"
                        type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapsefour"
                        aria-expanded="false" aria-controls="flush-collapsefour">
                        هل يقدم Wrappixel ضمان استعادة الأموال؟
                    </button>
                </h2>
                <div id="flush-collapsefour" class="accordion-collapse collapse"
                    aria-labelledby="flush-headingfour" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body fw-normal">
                        لا يوجد ضمان لاستعادة الأموال في معظم الشركات، ولكن إذا كنت غير سعيد
                        مع منتجاتنا،
                        التفاف بكسل
                        يمنحك ضمان استرداد الأموال بنسبة 100%.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card bg-primary-subtle rounded-2">
    <div class="card-body text-center">
        <div class="d-flex align-items-center justify-content-center mb-4 pt-8">
            <a href="javascript:void(0)">
                <img src="./assets/images/profile/user-3.jpg"
                    class="rounded-circle me-n2 card-hover border border-2 border-white" width="44"
                    height="44">
            </a>
            <a href="javascript:void(0)">
                <img src="./assets/images/profile/user-2.jpg"
                    class="rounded-circle me-n2 card-hover border border-2 border-white" width="44"
                    height="44">
            </a>
            <a href="javascript:void(0)">
                <img src="./assets/images/profile/user-4.jpg"
                    class="rounded-circle me-n2 card-hover border border-2 border-white" width="44"
                    height="44">
            </a>
        </div>
        <h3 class="fw-semibold">لا تزال لديك أسئلة
        </h3>
        <p class="fw-normal mb-4 fs-4">لا يمكنك العثور على رالإجابة التي تبحث عنها؟ يرجى الدردشة على
            ودية لدينا
            فريق.</p>
        <a href="javascript:void(0)" class="btn btn-primary mb-8">الدردشة معنا
        </a>
    </div>
</div>

@endsection
