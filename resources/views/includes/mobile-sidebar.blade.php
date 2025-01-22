<div class="offcanvas customizer offcanvas-end" tabindex="-1" id="offcanvasExample"
    aria-labelledby="offcanvasExampleLabel">
    <div class="d-flex align-items-center justify-content-between p-3 border-bottom">
        <h4 class="offcanvas-title fw-semibold" id="offcanvasExampleLabel">
            القائمة الرئيسية
        </h4>

        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
         <img src="../assets/images/logos/logo.jpg"  height="150" width="150" alt="Logo">

    <div class="offcanvas-body h-n80" data-simplebar>
        <nav class="sidebar-nav">
            <ul id="sidebarnav" class="mb-0">
   <!-- start profile Dropdown -->
                        <!-- ------------------------------- -->

                        <!-- ------------------------------- -->

                <!-- ============================= -->
                <!-- Home -->
                <!-- ============================= -->
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-primary w-100">تسجيل الخروج</button>
                </form>
                <li class="nav-small-cap">
                    <iconify-icon icon="solar:menu-dots-bold-duotone" class="nav-small-cap-icon fs-5"></iconify-icon>
                    <span class="hide-menu">Home</span>
                </li>
                <li class="sidebar-item">
                <a class="sidebar-link primary-hover-bg" href="{{ route('dasboard') }}" aria-expanded="false">

                        <iconify-icon icon="solar:atom-line-duotone" class="fs-6 aside-icon text-primary">
                        </iconify-icon>
                        <span class="hide-menu pe-1">الرئيسية</span>
                    </a>
                </li>


                <!-- ============================= -->
                <!-- Apps -->
                <!-- ============================= -->
                <!-- <li class="nav-small-cap">
                    <iconify-icon icon="solar:menu-dots-bold-duotone" class="nav-small-cap-icon fs-5"></iconify-icon>
                    <span class="hide-menu">Apps</span>
                </li> -->
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow success-hover-bg" href="javascript:void(0)"
                        aria-expanded="false">
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
                        <li class="sidebar-item">
                        <a href="{{ route('supportRequest.index') }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu"> التطوير

                                </span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item">
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
                        <li class="sidebar-item">
                        <a href="{{ route('WorkingIncome.index') }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu">جهات العمل</span>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="sidebar-item">
                <a class="sidebar-link has-arrow warning-hover-bg" href="javascript:void(0)" aria-expanded="false">
                        <iconify-icon icon="solar:document-text-line-duotone" class="fs-6 aside-icon text-danger">
                        </iconify-icon>
                        <span class="hide-menu pe-1">المعاملات المقدمة</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                        <a href="{{ route('installmentClient.index', 'advanced') }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu"> المتقدمين

                                </span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                        <a href="{{ route('installmentClient.index', 'transaction_submited') }}"
                                class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu"> المعاملات المقدمة
                                </span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('installmentClient.index', 'transaction_accepted') }}"
                                class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu"> المعاملات المقبولة </span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                        <a href="{{ route('installmentClient.index', ['status' => 'refused']) }}"
                                class="sidebar-link">
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

                <li class="sidebar-item">
                <a class="sidebar-link has-arrow primary-hover-bg" href="javascript:void(0)"
                        aria-expanded="false">
                        <iconify-icon icon="solar:file-text-line-duotone" class="fs-6 aside-icon text-warning">
                        </iconify-icon>
                        <span class="hide-menu pe-1"> الشئون القانونية
                        </span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
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
                        <li class="sidebar-item">
                            <a href="{{ route('payments') }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu"> عمليات الدفع
                                </span>
                            </a>
                        </li>
                    </ul>
                </li>



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



                <li class="sidebar-item">
                <a class="sidebar-link has-arrow success-hover-bg" href="javascript:void(0)"
                        aria-expanded="false">
                        <iconify-icon icon="solar:book-2-line-duotone" class="fs-6 aside-icon text-success">
                        </iconify-icon>
                        <span class="hide-menu pe-1"> مخزن المعرض </span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                    <li class="sidebar-item">
                            <a href="{{ route('shoowroom.index') }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu "> استلام البضاعة
                                </span>
                            </a>
                        </li>
                    </ul>
                </li>



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




                <li class="sidebar-item">
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
                            <a href="{{ route('military_affairs.delegates') }}" class="sidebar-link">
                                <span class="sidebar-icon"></span>
                                <span class="hide-menu"> المسؤولين
                                </span>
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
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu"> الإدارة المالية
                    </span>
                </li>
                <!-- =================== -->
                <!-- Front Pages -->
                <!-- =================== -->
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow warning-hover-bg" href="javascript:void(0)" aria-expanded="false">
                        <iconify-icon icon="solar:document-text-line-duotone" class="fs-6 aside-icon text-danger">
                        </iconify-icon>
                        <span class="hide-menu pe-1">الإدارة المالية  </span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                         <li class="sidebar-item">
                        <a href="{{ route('payments') }}" class="sidebar-link">
                            <span class="sidebar-icon"></span>
                            <span class="hide-menu"> عمليات الدفع
                            </span>
                        </a>
                    </li>

                    </ul>
                </li>

                    </ul>
                </li>





            </ul>

        </nav>
    </div>
</div>
