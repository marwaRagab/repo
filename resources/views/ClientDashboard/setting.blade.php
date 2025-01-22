@extends('ClientDashboard.layouts.app')

@section('crumb')
    <span> الأعدادت</span>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-lg-6 d-flex align-items-stretch">
                <div class="card w-100 border position-relative overflow-hidden">
                    <div class="card-body p-4">
                        <h4 class="card-title">تغيير الملف الشخصي
                        </h4>
                        <p class="card-subtitle mb-4">قم بتغيير الصورة الشخصية الخاصة بك من هنا
                        </p>
                        <div class="text-center">
                            <img src="./assets/images/profile/user-1.jpg" alt="spike-img"
                                class="img-fluid rounded-circle" width="120" height="120">
                            <div
                                class="d-flex align-items-center justify-content-center my-4 gap-6">
                                <button class="btn btn-primary">رفع الصورة</button>
                                <button class="btn bg-danger-subtle text-danger">إعادة ضبط الصورة
                                </button>
                            </div>
                            <p class="mb-0">مسموح بـ JPG أو GIF أو PNG. الحجم الأقصى 800 كيلو</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 d-flex align-items-stretch">
                <div class="card w-100 border position-relative overflow-hidden">
                    <div class="card-body p-4">
                        <h4 class="card-title"> تغيير كلمة المرور</h4>
                        <p class="card-subtitle mb-4">لتغيير كلمة المرور الخاصة بك، يرجى التأكيد هنا
                        </p>
                        <form>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label"> كلمة المرور
                                    الحالي</label>
                                <input type="password" class="form-control"
                                    id="exampleInputPassword1" value="12345678910">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword2" class="form-label"> كلمة المرور
                                    الجديدة</label>
                                <input type="password" class="form-control"
                                    id="exampleInputPassword2" value="12345678910">
                            </div>
                            <div>
                                <label for="exampleInputPassword3" class="form-label"> تأكيد كلمة
                                    المرور</label>
                                <input type="password" class="form-control"
                                    id="exampleInputPassword3" value="12345678910">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card w-100 border position-relative overflow-hidden mb-0">
                    <div class="card-body p-4">
                        <h4 class="card-title">تفاصيل البيانات الشخصية</h4>
                        <p class="card-subtitle mb-4">لتغيير بياناتك الشخصية، قم بالتحرير والحفظ من
                            هنا
                        </p>
                        <form>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="exampleInputtext"
                                            class="form-label">الإسم</label>
                                        <input type="text" class="form-control"
                                            id="exampleInputtext" placeholder="تقى ">
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputtext1" class="form-label">البريد
                                            الإلكتروني</label>
                                        <input type="email" class="form-control"
                                            id="exampleInputtext1" placeholder="info@modernize.com">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="exampleInputtext2" class="form-label">
                                            اللقب</label>
                                        <input type="text" class="form-control"
                                            id="exampleInputtext2" placeholder="رأفت">
                                    </div>

                                    <div class="mb-3">
                                        <label for="exampleInputtext3" class="form-label">رقم
                                            الهاتف</label>
                                        <input type="text" class="form-control"
                                            id="exampleInputtext3" placeholder="+91 12345 65478">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div>
                                        <label for="exampleInputtext4"
                                            class="form-label">العنوان</label>
                                        <input type="text" class="form-control"
                                            id="exampleInputtext4"
                                            placeholder="814 Howard Street, 120065, India">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div
                                        class="d-flex align-items-center justify-content-end mt-4 gap-6">
                                        <button class="btn btn-primary">حفظ</button>
                                        <button
                                            class="btn bg-danger-subtle text-danger">إلغاء</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
