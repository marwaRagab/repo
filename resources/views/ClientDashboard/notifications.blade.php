@extends('ClientDashboard.layouts.app')

@section('crumb')
    <span> اشعاراتي</span>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">

            <div class="col-sm-4 mt-2 mt-sm-0">
                <div class="d-flex align-items-center pb-3 mb-4 border-bottom">
                    <div class="position-relative">
                        <img src="./assets/images/profile/user-1.jpg" alt="user1" width="54"
                            height="54" class="rounded-circle" />
                        <span
                            class="position-absolute bottom-0 end-0 p-1 badge rounded-pill bg-success">
                            <span class="visually-hidden">New alerts</span>
                        </span>
                    </div>
                    <div class="me-3">
                        <h6 class="fw-semibold mb-2">تقى رأفت </h6>
                        <p class="mb-0 fs-2">الأدمن </p>
                    </div>
                </div>

                <form class="position-relative mb-4">
                    <input type="text" class="form-control search-chat py-2 ps-5" id="text-srh"
                        placeholder="Search Contact" />
                    <i
                        class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                </form>

                <!-- Nav tabs -->
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                    aria-orientation="vertical">
                    <a class="p-3 active bg-hover-light-black d-flex align-items-start justify-content-between"
                        id="v-pills-home-tab2" data-bs-toggle="pill" href="#v-pills-home2"
                        role="tab" aria-controls="v-pills-home2" aria-selected="true">
                        <div class="d-flex align-items-center">
                            <span class="position-relative">
                                <img src="./assets/images/profile/user-2.jpg" alt="user-2"
                                    width="48" height="48" class="rounded-circle" />
                                <span
                                    class="position-absolute bottom-0 end-0 p-1 badge rounded-pill bg-danger">
                                    <span class="visually-hidden">New alerts</span>
                                </span>
                            </span>
                            <div class="me-3 d-inline-block w-75">
                                <h6 class="mb-1 fw-semibold chat-title"
                                    data-username="James Anderson">
                                    تيسير </h6>
                                <span class="fs-3 text-truncate text-dark fw-semibold d-block">
                                    الفستان شكله حلو...</span>
                            </div>
                        </div>
                        <p class="fs-2 mb-0 text-muted">30 دقيقة</p>
                    </a>
                    <a class="p-3 bg-hover-light-black d-flex align-items-start justify-content-between"
                        id="v-pills-profile-tab2" data-bs-toggle="pill" href="#v-pills-profile2"
                        role="tab" aria-controls="v-pills-profile2" aria-selected="false"
                        tabindex="-1">
                        <div class="d-flex align-items-center">
                            <span class="position-relative">
                                <img src="./assets/images/profile/user-4.jpg" alt="user-4"
                                    width="48" height="48" class="rounded-circle" />
                                <span
                                    class="position-absolute bottom-0 end-0 p-1 badge rounded-pill bg-success">
                                    <span class="visually-hidden">New alerts</span>
                                </span>
                            </span>
                            <div class="me-3 d-inline-block w-75">
                                <h6 class="mb-1 fw-semibold chat-title"
                                    data-username="James Anderson">
                                    تقى </h6>
                                <span class="fs-3 text-truncate text-body-color d-block">انت:
                                    امس كان يوم جميل...</span>
                            </div>
                        </div>
                        <p class="fs-2 mb-0 text-muted">15 دقيقة</p>
                    </a>
                    <a class="p-3 bg-hover-light-black d-flex align-items-start justify-content-between"
                        id="v-pills-messages-tab2" data-bs-toggle="pill" href="#v-pills-messages2"
                        role="tab" aria-controls="v-pills-messages2" aria-selected="false"
                        tabindex="-1">
                        <div class="d-flex align-items-center">
                            <span class="position-relative">
                                <img src="./assets/images/profile/user-8.jpg" alt="user-8"
                                    width="48" height="48" class="rounded-circle" />
                                <span
                                    class="position-absolute bottom-0 end-0 p-1 badge rounded-pill bg-warning">
                                    <span class="visually-hidden">New alerts</span>
                                </span>
                            </span>
                            <div class="me-3 d-inline-block w-75">
                                <h6 class="mb-1 fw-semibold chat-title"
                                    data-username="James Anderson">
                                    حسن </h6>
                                <span class="fs-3 text-truncate text-body-color d-block">ارسل
                                    صورة</span>
                            </div>
                        </div>
                        <p class="fs-2 mb-0 text-muted">2 ساعة</p>
                    </a>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade active show py-3" id="v-pills-home2" role="tabpanel"
                        aria-labelledby="v-pills-home-tab2">
                        <p>
                            لوريم إيبسوم(Lorem Ipsum) هو ببساطة نص شكلي (بمعنى أن الغاية هي الشكل
                            وليس المحتوى) ويُستخدم في صناعات المطابع ودور النشر. كان لوريم إيبسوم
                            ولايزال المعيار للنص الشكلي منذ القرن الخامس عشر عندما قامت مطبعة مجهولة
                            برص مجموعة من الأحرف بشكل عشوائي أخذتها من نص، لتكوّن كتيّب بمثابة دليل
                            أو مرجع شكلي لهذه الأحرف.
                        </p>
                        <div class="d-flex align-items-center">
                                <img width="200" height="200px" src="./assets/images/frontend-pages/blog-10.jpg"
                                    class="img-fluid notification-img ms-3">
                                <video width="200" controls>
                                    <source src="https://www.w3schools.com/html/movie.mp4"
                                        type="video/mp4">
                                    متصفحك لا يدعم الفيديو.
                                </video>
                            <!-- <div class="pdf">
                            <iframe src="example.pdf" width="100%" height="200px" style="border: none;">
                                متصفحك لا يدعم ال pdf.
                            </iframe>
                        </div> -->
                        </div>

                    </div>
                    <div class="tab-pane fade py-3" id="v-pills-profile2" role="tabpanel"
                        aria-labelledby="v-pills-profile-tab2">
                        <p>
                            هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي
                            القارئ عن التركيز على الشكل الخارجي للنص أو شكل توضع الفقرات في الصفحة
                            التي يقرأها. ولذلك يتم استخدام طريقة لوريم إيبسوم لأنها تعطي توزيعاَ
                            طبيعياَ -إلى حد ما- للأحرف عوضاً عن استخدام "هنا يوجد محتوى نصي، هنا
                            يوجد محتوى نصي" فتجعلها تبدو (أي الأحرف) وكأنها نص مقروء.
                        </p>

                    </div>
                    <div class="tab-pane fade py-3" id="v-pills-messages2" role="tabpanel"
                        aria-labelledby="v-pills-messages-tab2">
                        <p>
                            هنالك العديد من الأنواع المتوفرة لنصوص لوريم إيبسوم، ولكن الغالبية تم
                            تعديلها بشكل ما عبر إدخال بعض النوادر أو الكلمات العشوائية إلى النص. إن
                            كنت تريد أن تستخدم نص لوريم إيبسوم ما، عليك أن تتحقق أولاً أن ليس هناك
                            أي كلمات أو عبارات محرجة أو غير لائقة مخبأة في هذا النص.

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
</div>

@endsection
