@extends('ClientDashboard.layouts.app')

@section('crumb')
    <span>الصفحة الرئيسية</span>
@endsection

@section('content')

                    <!-- ------------------------------------- -->
                    <!-- Form Start -->
                    <!-- ------------------------------------- -->
                    <section class="py-lg-12 py-7 bg-light-gray">
                        <div class="container-fluid">

                            <div class="row gx-lg-7 gy-lg-0 gy-7">
                                <div class="col-lg-4">
                                    <div class="bg-primary p-7 rounded-4 position-relative bg-circle overflow-hidden">
                                        <div
                                            class="pb-10 border-bottom border-white border-opacity-10 position-relative z-1">
                                            <h3 class="text-white fs-6 fw-bolder mb-3">تواصل معنا اليوم
                                            </h3>
                                            <p class="fs-4 mb-0 text-white">
                                                هل لديك أسئلة أو بحاجة إلى المساعدة؟ نحن مجرد رسالة بعيدا. </p>
                                        </div>
                                        <div class="pt-10 position-relative z-1">
                                            <h3 class="text-white fs-6 fw-bolder mb-3">
                                                الدعم الفني
                                            </h3>
                                            <p class="fs-4 mb-0 text-white">
                                                قم بزيارتنا شخصيًا أو ابحث عن تفاصيل الاتصال الخاصة بنا للتواصل معنا
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="bg-white p-7 rounded-4">
                                        <form>
                                            <div class="d-flex flex-column gap-sm-7 gap-3">
                                                <div class="d-flex flex-column gap-2">
                                                    <label for="Fname" class="fs-3 fw-semibold">
                                                        العنوان *
                                                    </label>
                                                    <input type="text" name="Fname" id="Fname" placeholder="  العنوان "
                                                        class="form-control">
                                                </div>

                                                <div class="d-flex flex-column gap-2">
                                                    <label for="message" class="fs-3 fw-semibold">التفاصيل</label>
                                                    <textarea name="message" id="message" class="form-control"
                                                        rows="5"></textarea>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-end align-items-center">
                                                <button type="submit"
                                                    class="btn btn-primary mt-sm-7 mt-3 px-9 py-6">أرسل
                                                    التفاصيل</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- ------------------------------------- -->
                    <!-- Form End -->
                    <!-- ------------------------------------- -->

@endsection
