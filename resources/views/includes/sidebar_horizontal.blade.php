<aside class="left-sidebar with-horizontal">
    <!-- Sidebar scroll-->
    <div>
        <!-- Sidebar navigation-->
        <nav id="sidebarnavh" class="sidebar-nav scroll-sidebar px-5">
            <ul id="sidebarnav">
                <!-- ============================= -->
                <!-- Home -->
                <!-- ============================= -->
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">الرئيسية</span>
                </li>
                <!-- =================== -->
                <!-- Dashboard -->
                <!-- =================== -->
                <li class="sidebar-item mega-dropdown">
                    <a class="sidebar-link primary-hover-bg" href="{{ route('dasboard') }}" aria-expanded="false">
                        <iconify-icon icon="solar:atom-line-duotone" class="fs-6 aside-icon text-primary">
                        </iconify-icon>
                        <span class="hide-menu pe-1">الرئيسية</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow warning-hover-bg" href="javascript:void(0)" aria-expanded="false">
                        <iconify-icon icon="solar:document-text-line-duotone" class="fs-6 aside-icon text-danger">
                        </iconify-icon>
                        <span class="hide-menu pe-1"> الدعم الفني</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="{{ route('supportProblem.index') }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu"> المشكلات

                                </span>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- ============================= -->
                <!-- Apps -->
                <!-- ============================= -->
                <li class="sidebar-item mega-dropdown">
                    <a class="sidebar-link has-arrow indigo-hover-bg" href="javascript:void(0)" aria-expanded="false">
                        <iconify-icon icon="solar:archive-broken" class="fs-6 aside-icon text-success"></iconify-icon>
                        <span class="hide-menu pe-1"> الإعدادات
                        </span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">

                        <li class="sidebar-item">
                            <a href="{{ route('nationality.index') }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">الجنسيات</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('branch.index') }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu"> الفروع </span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('government.index') }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">المحافظات</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="{{ route('ministry.index') }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu"> الوزارات
                                </span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('installment__percentages.index') }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu"> نسب التقسيط
                                </span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('courts.index') }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">المحاكم</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('police_stations.index') }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu"> المغافر </span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('bank.index') }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu"> البنوك
                                </span>
                            </a>
                        </li>
                        <!--                        <li class="sidebar-item">
                            <a href="{{ route('roles.index') }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">الصلاحيات</span>
                            </a>
                        </li>-->
                        <li class="sidebar-item">
                            <a href="{{ route('WorkingIncome.index') }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">جهات العمل</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- ============================= -->
                <!-- Front Pages -->
                <!-- ============================= -->
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu"> المعاملات المقدمة
                    </span>
                </li>
                <!-- =================== -->
                <!-- Front Pages -->
                <!-- =================== -->
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow warning-hover-bg" href="javascript:void(0)" aria-expanded="false">
                        <iconify-icon icon="solar:document-text-line-duotone" class="fs-6 aside-icon text-danger">
                        </iconify-icon>
                        <span class="hide-menu pe-1">المعاملات المقدمة</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="{{ route('myinstall.index', 'advanced') }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu"> المتقدمين

                                </span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('myinstall.index', 'transaction_submited') }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu"> المعاملات المقدمة
                                </span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('myinstall.index', 'transaction_accepted') }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu"> المعاملات المقبولة </span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('myinstall.index', ['status' => 'refused']) }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu"> المعاملات المرفوضة </span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('installments.search') }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu"> البحث </span>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- ============================= -->
                <!-- PAGES -->
                <!-- ============================= -->
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu"> الشئون القانونية
                    </span>
                </li>
                <li class="sidebar-item mega-dropdown">
                    <a class="sidebar-link has-arrow primary-hover-bg" href="javascript:void(0)"
                        aria-expanded="false">
                        <iconify-icon icon="solar:file-text-line-duotone" class="fs-6 aside-icon text-warning">
                        </iconify-icon>
                        <span class="hide-menu pe-1"> الشئون القانونية
                        </span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <!-- Teachers -->
                        <li class="sidebar-item">
                            <a href="{{ route('military_affairs') }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu"> الشئون القانونية
                                </span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('papers.eqrar_dain_received') }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu"> الإقرارات المستلمة
                                </span>
                            </a>
                        </li>
                        <!-- Exams -->
                        <li class="sidebar-item">
                            <a href="{{ route('papers.eqrar_dain') }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu"> الإقرارات الغير مستلمة
                                </span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('open_file') }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">فتح ملف </span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('execute_alert') }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu"> إعلان التنفيذ </span>
                            </a>
                        </li>
                        <!-- students -->
                        <li class="sidebar-item">
                            <a href="{{ route('eqrardain') }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu"> إقرار الدين </span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('image') }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu"> الايمج </span>
                            </a>
                        </li>
                        <!-- classes -->
                        <li class="sidebar-item">
                            <a href="{{ route('case_proof') }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu"> إثبات الحالة</span>
                            </a>
                        </li>
                        <!-- attendance -->
                        <li class="sidebar-item">
                            <a href="{{ route('stop_travel') }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu"> منع السفر</span>
                            </a>
                        </li>
                        <!-- icons -->
                        <li class="sidebar-item">
                            <a href="{{ route('settle.index') }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu"> التسوية</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('stop_car') }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">حجز السيارات</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('Certificate') }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu"> إصدار شهادة عسكرية
                                </span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('stop_salary') }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu"> حجز الراتب </span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('stop_bank') }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu"> حجز بنوك
                                </span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('search.index') }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu"> البحث
                                </span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('excute_actions') }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu"> رصيد التنفيذ </span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('checking') }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu"> رفع الإجراءات</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- ============================= -->
                <!-- UI -->
                <!-- ============================= -->
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu"> عملاء الأقساط
                    </span>
                </li>
                <!-- =================== -->
                <!-- UI Elements -->
                <!-- =================== -->

                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow warning-hover-bg" href="javascript:void(0)"
                        aria-expanded="false">
                        <iconify-icon icon="solar:cpu-bolt-line-duotone" class="fs-6 aside-icon text-info">
                        </iconify-icon>
                        <span class="hide-menu pe-1"> عملاء الأقساط
                        </span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="{{ route('installment.admin') }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu"> عملاء الأقساط
                                </span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('installment.lated-installments') }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu"> العملاء المتأخرون
                                </span>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- ============================= -->
                <!-- المنتجات -->
                <!-- ============================= -->
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">المنتجات</span>
                </li>
                <!-- =================== -->
                <!-- المنتجات -->
                <!-- =================== -->
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow success-hover-bg" href="javascript:void(0)"
                        aria-expanded="false">
                        <iconify-icon icon="solar:book-2-line-duotone" class="fs-6 aside-icon text-success">
                        </iconify-icon>
                        <span class="hide-menu pe-1"> مخزن المعرض </span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <!-- form elements -->
                        <li class="sidebar-item">
                            <a href="{{ route('shoowroom.index') }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu "> استلام البضاعة
                                </span>
                            </a>
                        </li>

                    </ul>
                </li>

                <!-- ============================= -->
                <!--  الشركات الموردة
-->
                <!-- ============================= -->
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu"> الشركات الموردة
                    </span>
                </li>
                <!-- =================== -->
                <!-- الشركات الموردة
-->
                <!-- =================== -->
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow warning-hover-bg" href="javascript:void(0)"
                        aria-expanded="false">
                        <iconify-icon icon="solar:bedside-table-2-line-duotone" class="fs-6 aside-icon text-danger">
                        </iconify-icon>
                        <span class="hide-menu pe-1"> الشركات الموردة
                        </span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="{{ route('company.index') }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu"> الشركات
                                </span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('products.index') }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu"> المنتجات
                                </span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('tawreed.index') }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu"> توريد جديد
                                </span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('orders.index') }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu "> طلبات الشراء
                                </span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('mark.index') }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu "> الماركات
                                </span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('class.index') }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu "> الأصناف
                                </span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="{{ route('Transfer.getAvailableProducts') }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu"> المنتجات المتوفرة
                                </span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('transferProduct.index') }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu"> نقل المنتجات
                                </span>
                            </a>
                        </li>

                    </ul>
                </li>
                <!-- =================== -->
                <!-- المنتجات
-->
                <!-- =================== -->
                <!-- <li class="sidebar-item">
                    <a class="sidebar-link has-arrow warning-hover-bg" href="javascript:void(0)"
                        aria-expanded="false">
                        <iconify-icon icon="solar:bedside-table-2-line-duotone"
                            class="fs-6 aside-icon text-danger"></iconify-icon>
                        <span class="hide-menu pe-1"> المنتجات
                        </span>
                    </a>

                </li> -->
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu"> الشئون القانونية
                    </span>
                </li>
                <li class="sidebar-item mega-dropdown">
                    <a class="sidebar-link has-arrow primary-hover-bg" href="javascript:void(0)"
                        aria-expanded="false">
                        <iconify-icon icon="solar:lock-keyhole-line-duotone" class="fs-6 aside-icon text-warning">
                        </iconify-icon>
                        <span class="hide-menu pe-1">
                            الموارد البشرية
                        </span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="{{ route('clients.index') }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu"> العملاء
                                </span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('users.index') }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu"> المستخدمين
                                </span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('roles.index') }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu"> مجموعات العمل
                                </span>
                            </a>
                        </li>
                        <!-- Exams -->
                        <li class="sidebar-item">
                            <a href="{{ route('member.index') }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu"> الموظفين
                                </span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('broker.index') }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu"> الوسطاء</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('transactions.done.index') }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu"> منجزين المعاملات </span>
                            </a>
                        </li>
                        <!-- students -->
                        <li class="sidebar-item">
                            <a href="{{ route('communication.index') }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu"> طرق التواصل </span>
                            </a>
                        </li>
                        <!-- <li class="sidebar-item">
              <a href="#" class="sidebar-link">
                <span class="sidebar-icon"></span>
                <span class="hide-menu"> مجموعات العمل (الوظيفة) </span>
              </a>
            </li> -->
                    </ul>
                </li>
            </ul>
    </div>
</aside>
<!-- mobile sidebar -->
<div class="offcanvas customizer offcanvas-end" tabindex="-1" id="offcanvasExample"
    aria-labelledby="offcanvasExampleLabel">
    <div class="d-flex align-items-center justify-content-between p-3 border-bottom">
        <h4 class="offcanvas-title fw-semibold" id="offcanvasExampleLabel">
            Settings
        </h4>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body h-n80" data-simplebar>
        <nav class="sidebar-nav">
            <ul id="sidebarnav" class="mb-0">

                <!-- ============================= -->
                <!-- Home -->
                <!-- ============================= -->
                <li class="nav-small-cap">
                    <iconify-icon icon="solar:menu-dots-bold-duotone" class="nav-small-cap-icon fs-5"></iconify-icon>
                    <span class="hide-menu">Home</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link sidebar-link primary-hover-bg" href="" id="get-url"
                        aria-expanded="false">
                        <span class="aside-icon p-2 bg-primary-subtle rounded-1">
                            <iconify-icon icon="solar:screencast-2-line-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu ps-1">Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link sidebar-link success-hover-bg" href="../horizontal/index2.html"
                        aria-expanded="false">
                        <span class="aside-icon p-2 bg-success-subtle rounded-1">
                            <iconify-icon icon="solar:chart-line-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu ps-1">Dashboard 2</span>
                    </a>
                </li>

                <!-- ============================= -->
                <!-- Apps -->
                <!-- ============================= -->
                <li class="nav-small-cap">
                    <iconify-icon icon="solar:menu-dots-bold-duotone" class="nav-small-cap-icon fs-5"></iconify-icon>
                    <span class="hide-menu">Apps</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow success-hover-bg" href="javascript:void(0)"
                        aria-expanded="false">
                        <span class="aside-icon p-2 bg-success-subtle rounded-1">
                            <iconify-icon icon="solar:smart-speaker-minimalistic-line-duotone" class="fs-6">
                            </iconify-icon>
                        </span>
                        <span class="hide-menu ps-1">Ecommerce</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="../horizontal/eco-shop.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Shop One</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="../horizontal/eco-shop2.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Shop Two</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="../horizontal/eco-shop-detail.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Details One</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="../horizontal/eco-shop-detail2.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Details Two</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="../horizontal/eco-product-list.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">List</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="../horizontal/eco-checkout.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Checkout</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="../horizontal/eco-add-product.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Add Product</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="../horizontal/eco-edit-product.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Edit Product</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow warning-hover-bg" href="javascript:void(0)"
                        aria-expanded="false">
                        <span class="aside-icon p-2 bg-warning-subtle rounded-1">
                            <iconify-icon icon="solar:pie-chart-3-line-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu ps-1">Blog</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="../horizontal/blog-posts.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Posts</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="../horizontal/blog-detail.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Details</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow danger-hover-bg" href="javascript:void(0)"
                        aria-expanded="false">
                        <span class="aside-icon p-2 bg-danger-subtle rounded-1">
                            <iconify-icon icon="solar:user-circle-line-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu ps-1">User Profile</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="../horizontal/page-user-profile.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Profile One</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="../horizontal/page-user-profile2.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Profile Two</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link indigo-hover-bg" href="../horizontal/app-email.html"
                        aria-expanded="false">
                        <span class="aside-icon p-2 bg-indigo-subtle rounded-1">
                            <iconify-icon icon="solar:mailbox-line-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu ps-1">Email</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link info-hover-bg" href="../horizontal/app-calendar.html"
                        aria-expanded="false">
                        <span class="aside-icon p-2 bg-info-subtle rounded-1">
                            <iconify-icon icon="solar:calendar-add-line-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu ps-1">Calendar</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link success-hover-bg" href="../horizontal/app-kanban.html"
                        aria-expanded="false">
                        <span class="aside-icon p-2 bg-success-subtle rounded-1">
                            <iconify-icon icon="solar:window-frame-line-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu ps-1">Kanban</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link primary-hover-bg" href="../horizontal/app-chat.html"
                        aria-expanded="false">
                        <span class="aside-icon p-2 bg-primary-subtle rounded-1">
                            <iconify-icon icon="solar:chat-round-unread-line-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu ps-1">Chat</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link secondary-hover-bg" href="../horizontal/app-notes.html"
                        aria-expanded="false">
                        <span class="aside-icon p-2 bg-secondary-subtle rounded-1">
                            <iconify-icon icon="solar:notification-unread-lines-line-duotone" class="fs-6">
                            </iconify-icon>
                        </span>
                        <span class="hide-menu ps-1">Notes</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link success-hover-bg" href="../horizontal/app-contact.html"
                        aria-expanded="false">
                        <span class="aside-icon p-2 bg-success-subtle rounded-1">
                            <iconify-icon icon="solar:phone-line-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu ps-1">Contact Table</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link warning-hover-bg" href="../horizontal/app-contact2.html"
                        aria-expanded="false">
                        <span class="aside-icon p-2 bg-warning-subtle rounded-1">
                            <iconify-icon icon="solar:list-check-line-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu ps-1">Contact List</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link danger-hover-bg" href="../horizontal/app-invoice.html"
                        aria-expanded="false">
                        <span class="aside-icon p-2 bg-danger-subtle rounded-1">
                            <iconify-icon icon="solar:file-text-line-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu ps-1">Invoice</span>
                    </a>
                </li>


                <!-- ============================= -->
                <!-- Pages -->
                <!-- ============================= -->
                <li class="nav-small-cap">
                    <iconify-icon icon="solar:menu-dots-bold-duotone" class="nav-small-cap-icon fs-5"></iconify-icon>
                    <span class="hide-menu">Pages</span>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link indigo-hover-bg" href="../horizontal/page-pricing.html"
                        aria-expanded="false">
                        <span class="aside-icon p-2 bg-indigo-subtle rounded-1">
                            <iconify-icon icon="solar:dollar-minimalistic-line-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu ps-1">Pricing</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link info-hover-bg" href="../horizontal/page-faq.html" aria-expanded="false">
                        <span class="aside-icon p-2 bg-info-subtle rounded-1">
                            <iconify-icon icon="solar:question-circle-line-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu ps-1">FAQ</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link primary-hover-bg" href="../horizontal/page-account-settings.html"
                        aria-expanded="false">
                        <span class="aside-icon p-2 bg-primary-subtle rounded-1">
                            <iconify-icon icon="solar:user-circle-line-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu ps-1">Account Setting</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link danger-hover-bg" href="../landingpage/index.html" aria-expanded="false">
                        <span class="aside-icon p-2 bg-danger-subtle rounded-1">
                            <iconify-icon icon="solar:window-frame-line-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu ps-1">Landing Page</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow secondary-hover-bg" href="javascript:void(0)"
                        aria-expanded="false">
                        <span class="aside-icon p-2 bg-secondary-subtle rounded-1">
                            <iconify-icon icon="solar:widget-4-line-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu ps-1">Widgets</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="../horizontal/widgets-cards.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Cards</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="../horizontal/widgets-banners.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Banner</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="../horizontal/widgets-charts.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Charts</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="../horizontal/widgets-feeds.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Feed Widgets</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="../horizontal/widgets-apps.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Apps Widgets</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="../horizontal/widgets-data.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Data Widgets</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- ============================= -->
                <!-- SchoolPages -->
                <!-- ============================= -->
                <li class="nav-small-cap">
                    <iconify-icon icon="solar:menu-dots-bold-duotone" class="nav-small-cap-icon fs-5"></iconify-icon>
                    <span class="hide-menu">SchoolPages</span>
                </li>

                <!-- =================== -->
                <!-- Teachers -->
                <!-- =================== -->
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow success-hover-bg" href="javascript:void(0)"
                        aria-expanded="false">
                        <span class="aside-icon p-2 bg-success-subtle rounded-1">
                            <iconify-icon icon="solar:lightbulb-bolt-line-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu ps-1">Teachers</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="../horizontal/all-teacher.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">All Teachers</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="../horizontal/teacher-details.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu"> Teachers Details</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- =================== -->
                <!-- Exam -->
                <!-- =================== -->
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow warning-hover-bg" href="javascript:void(0)"
                        aria-expanded="false">
                        <span class="aside-icon p-2 bg-warning-subtle rounded-1">
                            <iconify-icon icon="solar:file-text-line-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu ps-1">Exam</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="../horizontal/exam-schedule.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Exam Schedule</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="../horizontal/exam-result.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu"> Exam Result</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="../horizontal/exam-result-details.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu"> Exam Result Details</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- =================== -->
                <!-- Students -->
                <!-- =================== -->
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow danger-hover-bg" href="javascript:void(0)"
                        aria-expanded="false">
                        <span class="aside-icon p-2 bg-danger-subtle rounded-1">
                            <iconify-icon icon="solar:square-academic-cap-line-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu ps-1">Students</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="../horizontal/all-student.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">All Students</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="../horizontal/student-details.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu"> Students Details</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- =================== -->
                <!-- Classes -->
                <!-- =================== -->
                <li class="sidebar-item">
                    <a class="sidebar-link sidebar-link indigo-hover-bg" href="../horizontal/classes.html"
                        aria-expanded="false">
                        <span class="aside-icon p-2 bg-indigo-subtle rounded-1">
                            <iconify-icon icon="solar:planet-3-line-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu ps-1">Classes</span>
                    </a>
                </li>

                <!-- =================== -->
                <!-- Attendance -->
                <!-- =================== -->
                <li class="sidebar-item">
                    <a class="sidebar-link sidebar-link info-hover-bg" href="../horizontal/attendance.html"
                        aria-expanded="false">
                        <span class="aside-icon p-2 bg-info-subtle rounded-1">
                            <iconify-icon icon="solar:file-check-line-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu ps-1">Attendance</span>
                    </a>
                </li>

                <!-- ============================= -->
                <!-- UI -->
                <!-- ============================= -->
                <li class="nav-small-cap">
                    <iconify-icon icon="solar:menu-dots-bold-duotone" class="nav-small-cap-icon fs-5"></iconify-icon>
                    <span class="hide-menu">UI</span>
                </li>

                <!-- =================== -->
                <!-- UI Elements -->
                <!-- =================== -->
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow primary-hover-bg" href="javascript:void(0)"
                        aria-expanded="false">
                        <span class="aside-icon p-2 bg-primary-subtle rounded-1">
                            <iconify-icon icon="solar:cpu-bolt-line-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu ps-1">UI Elements</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="../horizontal/ui-accordian.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Accordian</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="../horizontal/ui-badge.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Badge</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="../horizontal/ui-buttons.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Buttons</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="../horizontal/ui-dropdowns.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Dropdowns</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="../horizontal/ui-modals.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Modals</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="../horizontal/ui-tab.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Tab</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="../horizontal/ui-tooltip-popover.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Tooltip & Popover</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="../horizontal/ui-notification.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Alerts</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="../horizontal/ui-progressbar.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Progressbar</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="../horizontal/ui-pagination.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Pagination</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="../horizontal/ui-typography.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Typography</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="../horizontal/ui-bootstrap-ui.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Bootstrap UI</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="../horizontal/ui-breadcrumb.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Breadcrumb</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="../horizontal/ui-offcanvas.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Offcanvas</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="../horizontal/ui-lists.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Lists</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="../horizontal/ui-grid.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Grid</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="../horizontal/ui-carousel.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Carousel</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="../horizontal/ui-scrollspy.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Scrollspy</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="../horizontal/ui-spinner.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Spinner</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="../horizontal/ui-link.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Link</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- =================== -->
                <!-- Cards -->
                <!-- =================== -->
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow secondary-hover-bg" href="javascript:void(0)"
                        aria-expanded="false">
                        <span class="aside-icon p-2 bg-secondary-subtle rounded-1">
                            <iconify-icon icon="solar:document-text-line-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu ps-1">Cards</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="../horizontal/ui-cards.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Basic Cards</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="../horizontal/ui-card-customs.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Custom Cards</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="../horizontal/ui-card-weather.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Weather Cards</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="../horizontal/ui-card-draggable.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Draggable Cards</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- =================== -->
                <!-- Components -->
                <!-- =================== -->
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow success-hover-bg" href="javascript:void(0)"
                        aria-expanded="false">
                        <span class="aside-icon p-2 bg-success-subtle rounded-1">
                            <iconify-icon icon="solar:command-line-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu ps-1">Components</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="../horizontal/component-sweetalert.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Sweet Alert</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="../horizontal/component-nestable.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Nestable</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="../horizontal/component-noui-slider.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Noui slider</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="../horizontal/component-rating.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Rating</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="../horizontal/component-toastr.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Toastr</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- ============================= -->
                <!-- Forms -->
                <!-- ============================= -->
                <li class="nav-small-cap">
                    <iconify-icon icon="solar:menu-dots-bold-duotone" class="nav-small-cap-icon fs-5"></iconify-icon>
                    <span class="hide-menu">Forms</span>
                </li>

                <!-- =================== -->
                <!-- Form Elements -->
                <!-- =================== -->
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow secondary-hover-bg" href="javascript:void(0)"
                        aria-expanded="false">
                        <span class="aside-icon p-2 bg-secondary-subtle rounded-1">
                            <iconify-icon icon="solar:book-2-line-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu ps-1">Form Elements</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="../horizontal/form-inputs.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Forms Input</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="../horizontal/form-input-groups.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Input Groups</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="../horizontal/form-input-grid.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Input Grid</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="../horizontal/form-checkbox-radio.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Checkbox & Radios</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="../horizontal/form-bootstrap-switch.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Bootstrap Switch</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="../horizontal/form-select2.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Select2</span>
                            </a>
                        </li>

                    </ul>
                </li>

                <!-- =================== -->
                <!-- Form Input -->
                <!-- =================== -->
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow success-hover-bg" href="javascript:void(0)"
                        aria-expanded="false">
                        <span class="aside-icon p-2 bg-success-subtle rounded-1">
                            <iconify-icon icon="solar:ruler-line-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu ps-1">Form Input</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="../horizontal/form-basic.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Basic Form</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="../horizontal/form-horizontal.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Form Horizontal</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="../horizontal/form-actions.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Form Actions</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="../horizontal/form-row-separator.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Row Separator</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="../horizontal/form-bordered.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Form Bordered</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="../horizontal/form-detail.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Form Detail</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="../horizontal/form-striped-row.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Striped Rows</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="../horizontal/form-floating-input.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Form Floating Input</span>
                            </a>
                        </li>
                    </ul>
                </li>


                <!-- =================== -->
                <!-- Form Addons -->
                <!-- =================== -->
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow primary-hover-bg" href="javascript:void(0)"
                        aria-expanded="false">
                        <span class="aside-icon p-2 bg-primary-subtle rounded-1">
                            <iconify-icon icon="solar:qr-code-line-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu ps-1">Form Addons</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="../horizontal/form-dropzone.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Dropzone</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="../horizontal/form-mask.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Form Mask</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="../horizontal/form-typeahead.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Form Typehead</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- =================== -->
                <!-- Form Validation -->
                <!-- =================== -->
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow indigo-hover-bg" href="javascript:void(0)"
                        aria-expanded="false">
                        <span class="aside-icon p-2 bg-indigo-subtle rounded-1">
                            <iconify-icon icon="solar:danger-circle-line-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu ps-1">Form Validation</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="../horizontal/form-bootstrap-validation.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Bootstrap Validation</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="../horizontal/form-custom-validation.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Custom Validation</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- =================== -->
                <!-- Form Pickers -->
                <!-- =================== -->
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow success-hover-bg" href="javascript:void(0)"
                        aria-expanded="false">
                        <span class="aside-icon p-2 bg-success-subtle rounded-1">
                            <iconify-icon icon="solar:document-add-line-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu ps-1">Form Pickers</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="../horizontal/form-picker-colorpicker.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Colorpicker</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="../horizontal/form-picker-bootstrap-rangepicker.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Bootstrap Rangepicker</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="../horizontal/form-picker-bootstrap-datepicker.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Bootstrap Datepicker</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="../horizontal/form-picker-material-datepicker.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Material Datepicker</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- =================== -->
                <!-- Form Editor -->
                <!-- =================== -->
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow indigo-hover-bg" href="javascript:void(0)"
                        aria-expanded="false">
                        <span class="aside-icon p-2 bg-indigo-subtle rounded-1">
                            <iconify-icon icon="solar:dna-bold-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu ps-1">Form Editor</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="../horizontal/form-editor-quill.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Quill Editor</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="../horizontal/form-editor-tinymce.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Tinymce Editor</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- =================== -->
                <!-- Form Wizard -->
                <!-- =================== -->
                <li class="sidebar-item">
                    <a class="sidebar-link sidebar-link warning-hover-bg" href="../horizontal/form-wizard.html"
                        aria-expanded="false">
                        <span class="aside-icon p-2 bg-warning-subtle rounded-1">
                            <iconify-icon icon="solar:password-minimalistic-line-duotone"
                                class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu ps-1">Form Wizard</span>
                    </a>
                </li>

                <!-- =================== -->
                <!-- Form Repeater -->
                <!-- =================== -->
                <li class="sidebar-item">
                    <a class="sidebar-link sidebar-link primary-hover-bg" href="../horizontal/form-repeater.html"
                        aria-expanded="false">
                        <span class="aside-icon p-2 bg-primary-subtle rounded-1">
                            <iconify-icon icon="solar:star-circle-line-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu ps-1">Form Repeater</span>
                    </a>
                </li>

                <!-- ============================= -->
                <!-- Tables -->
                <!-- ============================= -->
                <li class="nav-small-cap">
                    <iconify-icon icon="solar:menu-dots-bold-duotone"
                        class="nav-small-cap-icon fs-5"></iconify-icon>
                    <span class="hide-menu">Tables</span>
                </li>

                <!-- =================== -->
                <!-- Bootstrap Table -->
                <!-- =================== -->
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow indigo-hover-bg" href="javascript:void(0)"
                        aria-expanded="false">
                        <span class="aside-icon p-2 bg-indigo-subtle rounded-1">
                            <iconify-icon icon="solar:sidebar-minimalistic-line-duotone"
                                class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu ps-1">Bootstrap Table</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="../horizontal/table-basic.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Basic Table</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="../horizontal/table-dark-basic.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Dark Basic Table</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="../horizontal/table-sizing.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Sizing Table</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="../horizontal/table-layout-coloured.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Coloured Table</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- =================== -->
                <!-- Datatable -->
                <!-- =================== -->
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow info-hover-bg" href="javascript:void(0)"
                        aria-expanded="false">
                        <span class="aside-icon p-2 bg-info-subtle rounded-1">
                            <iconify-icon icon="solar:tablet-line-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu ps-1">Datatables</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="../horizontal/table-datatable-basic.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Basic Initialisation</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="../horizontal/table-datatable-api.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">API</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="../horizontal/table-datatable-advanced.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Advanced Initialisation</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- ============================= -->
                <!-- Charts -->
                <!-- ============================= -->
                <li class="nav-small-cap">
                    <iconify-icon icon="solar:menu-dots-bold-duotone"
                        class="nav-small-cap-icon fs-5"></iconify-icon>
                    <span class="hide-menu">Charts</span>
                </li>

                <!-- =================== -->
                <!-- Apex Chart -->
                <!-- =================== -->
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow primary-hover-bg" href="javascript:void(0)"
                        aria-expanded="false">
                        <span class="aside-icon p-2 bg-primary-subtle rounded-1">
                            <iconify-icon icon="solar:dropper-minimalistic-2-line-duotone"
                                class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu ps-1">Apex Charts</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="../horizontal/chart-apex-line.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Line Chart</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="../horizontal/chart-apex-area.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Area Chart</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="../horizontal/chart-apex-bar.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Bar Chart</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="../horizontal/chart-apex-pie.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Pie Chart</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="../horizontal/chart-apex-radial.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Radial Chart</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="../horizontal/chart-apex-radar.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Radar Chart</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- ============================= -->
                <!-- Sample Pages -->
                <!-- ============================= -->
                <li class="nav-small-cap">
                    <iconify-icon icon="solar:menu-dots-bold-duotone"
                        class="nav-small-cap-icon fs-5"></iconify-icon>
                    <span class="hide-menu">Sample Pages</span>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow danger-hover-bg" href="javascript:void(0)"
                        aria-expanded="false">
                        <span class="aside-icon p-2 bg-danger-subtle rounded-1">
                            <iconify-icon icon="solar:file-line-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu ps-1">Sample Pages</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="../horizontal/pages-animation.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Animation</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="../horizontal/pages-search-result.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Search Result</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="../horizontal/pages-gallery.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Gallery</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="../horizontal/pages-treeview.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Treeview</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="../horizontal/pages-block-ui.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Block-Ui</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="../horizontal/pages-session-timeout.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Session Timeout</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- ============================= -->
                <!-- Icons -->
                <!-- ============================= -->
                <li class="nav-small-cap">
                    <iconify-icon icon="solar:menu-dots-bold-duotone"
                        class="nav-small-cap-icon fs-5"></iconify-icon>
                    <span class="hide-menu">Icons</span>
                </li>

                <!-- =================== -->
                <!-- Tabler Icon -->
                <!-- =================== -->
                <li class="sidebar-item">
                    <a class="sidebar-link sidebar-link secondary-hover-bg" href="../horizontal/icon-tabler.html"
                        aria-expanded="false">
                        <span class="aside-icon p-2 bg-secondary-subtle rounded-1">
                            <iconify-icon icon="solar:archive-broken" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu ps-1">Tabler Icon</span>
                    </a>
                </li>

                <!-- =================== -->
                <!-- Solar Icon -->
                <!-- =================== -->
                <li class="sidebar-item">
                    <a class="sidebar-link sidebar-link primary-hover-bg" href="../horizontal/icon-solar.html"
                        aria-expanded="false">
                        <span class="aside-icon p-2 bg-primary-subtle rounded-1">
                            <iconify-icon icon="solar:sticker-smile-circle-2-linear" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu ps-1">Solar Icon</span>
                    </a>
                </li>


                <!-- ============================= -->
                <!-- Auth -->
                <!-- ============================= -->
                <li class="nav-small-cap">
                    <iconify-icon icon="solar:menu-dots-bold-duotone"
                        class="nav-small-cap-icon fs-5"></iconify-icon>
                    <span class="hide-menu">Auth</span>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link sidebar-link success-hover-bg"
                        href="../horizontal/authentication-error.html" aria-expanded="false">
                        <span class="aside-icon p-2 bg-success-subtle rounded-1">
                            <iconify-icon icon="solar:danger-circle-line-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu ps-1">Error</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow warning-hover-bg" href="javascript:void(0)"
                        aria-expanded="false">
                        <span class="aside-icon p-2 bg-warning-subtle rounded-1">
                            <iconify-icon icon="solar:login-2-line-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu ps-1">Login</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="../horizontal/authentication-login.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Side Login</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="../horizontal/authentication-login2.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Boxed Login</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow danger-hover-bg" href="javascript:void(0)"
                        aria-expanded="false">
                        <span class="aside-icon p-2 bg-danger-subtle rounded-1">
                            <iconify-icon icon="solar:user-plus-broken" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu ps-1">Register</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="../horizontal/authentication-register.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Side Register</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="../horizontal/authentication-register2.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Boxed Register</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow indigo-hover-bg" href="javascript:void(0)"
                        aria-expanded="false">
                        <span class="aside-icon p-2 bg-indigo-subtle rounded-1">
                            <iconify-icon icon="solar:refresh-bold-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu ps-1">Forgot Password</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="../horizontal/authentication-forgot-password.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Side Forgot Password</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="../horizontal/authentication-forgot-password2.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Boxed Forgot Password</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow info-hover-bg" href="javascript:void(0)"
                        aria-expanded="false">
                        <span class="aside-icon p-2 bg-info-subtle rounded-1">
                            <iconify-icon icon="solar:magnifer-zoom-in-linear" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu ps-1">Two Steps</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="../horizontal/authentication-two-steps.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Side Two Steps</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="../horizontal/authentication-two-steps2.html" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Boxed Two Steps</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link sidebar-link primary-hover-bg"
                        href="../horizontal/authentication-maintenance.html" aria-expanded="false">
                        <span class="aside-icon p-2 bg-primary-subtle rounded-1">
                            <iconify-icon icon="solar:settings-line-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu ps-1">Maintenance</span>
                    </a>
                </li>

                <!-- ============================= -->
                <!-- Documentation -->
                <!-- ============================= -->
                <li class="nav-small-cap">
                    <iconify-icon icon="solar:menu-dots-bold-duotone"
                        class="nav-small-cap-icon fs-5"></iconify-icon>
                    <span class="hide-menu">Documentation</span>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link sidebar-link success-hover-bg" href="../docs/index.html"
                        aria-expanded="false">
                        <span class="aside-icon p-2 bg-success-subtle rounded-1">
                            <iconify-icon icon="solar:file-text-line-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu ps-1">Getting Started</span>
                    </a>
                </li>

                <!-- ============================= -->
                <!-- OTHER -->
                <!-- ============================= -->
                <li class="nav-small-cap">
                    <iconify-icon icon="solar:menu-dots-bold-duotone"
                        class="nav-small-cap-icon fs-5"></iconify-icon>
                    <span class="hide-menu">Other</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow secondary-hover-bg" href="javascript:void(0)"
                        aria-expanded="false">
                        <span class="aside-icon p-2 bg-secondary-subtle rounded-1">
                            <iconify-icon icon="solar:layers-minimalistic-line-duotone"
                                class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu ps-1">Menu Level</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="javascript:void(0)" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Level 1</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">Level 1.1</span>
                            </a>
                            <ul aria-expanded="false" class="collapse two-level">
                                <li class="sidebar-item">
                                    <a href="javascript:void(0)" class="sidebar-link">
                                        <span class="sidebar-icon"></span>
                                        <span class="hide-menu">Level 2</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a class="sidebar-link has-arrow" href="javascript:void(0)"
                                        aria-expanded="false">
                                        <span class="sidebar-icon"></span>
                                        <span class="hide-menu">Level 2.1</span>
                                    </a>
                                    <ul aria-expanded="false" class="collapse three-level">
                                        <li class="sidebar-item">
                                            <a href="javascript:void(0)" class="sidebar-link">
                                                <span class="sidebar-icon"></span>
                                                <span class="hide-menu">Level 3</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-item">
                                            <a href="javascript:void(0)" class="sidebar-link">
                                                <span class="sidebar-icon"></span>
                                                <span class="hide-menu">Level 3.1</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link sidebar-link success-hover-bg opacity-50" href="javascript:void(0)"
                        aria-expanded="false">
                        <span class="aside-icon p-2 bg-success-subtle rounded-1">
                            <iconify-icon icon="solar:forbidden-circle-line-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu ps-1">Disabled</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link sidebar-link warning-hover-bg" href="javascript:void(0)"
                        aria-expanded="false">
                        <span class="aside-icon p-2 bg-warning-subtle rounded-1">
                            <iconify-icon icon="solar:star-line-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <div class="lh-base hide-menu">
                            <span class="hide-menu ps-1 d-flex">SubCaption</span>
                            <span class="hide-menu ps-1 d-flex fs-2">This is the sutitle</span>
                        </div>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link sidebar-link danger-hover-bg justify-content-between"
                        href="javascript:void(0)" aria-expanded="false">
                        <div class="d-flex align-items-center">
                            <span class="aside-icon p-2 bg-danger-subtle rounded-1">
                                <iconify-icon icon="solar:shield-check-line-duotone" class="fs-6"></iconify-icon>
                            </span>
                            <span class="hide-menu ps-1">Chip</span>
                        </div>
                        <div class="hide-menu">
                            <span
                                class="badge rounded-circle bg-danger d-flex align-items-center justify-content-center round-20 p-0 me-7">9</span>
                        </div>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link sidebar-link indigo-hover-bg justify-content-between"
                        href="javascript:void(0)" aria-expanded="false">
                        <div class="d-flex align-items-center">
                            <span class="aside-icon p-2 bg-indigo-subtle rounded-1">
                                <iconify-icon icon="solar:smile-circle-line-duotone" class="fs-6"></iconify-icon>
                            </span>
                            <span class="hide-menu ps-1">Outlined</span>
                        </div>
                        <div class="hide-menu">
                            <span
                                class="hide-menu badge rounded-pill border border-indigo text-indigo fs-2 me-7">Outline</span>
                        </div>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link sidebar-link info-hover-bg" href="javascript:void(0)"
                        aria-expanded="false">
                        <span class="aside-icon p-2 bg-info-subtle rounded-1">
                            <iconify-icon icon="solar:star-line-duotone" class="fs-6"></iconify-icon>
                        </span>
                        <span class="hide-menu ps-1">External Link</span>
                    </a>
                </li>
            </ul>

        </nav>
    </div>
</div>
