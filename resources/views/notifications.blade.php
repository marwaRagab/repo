<div class="card">
    <div class="card-body">
        <div class="row">

            <div class="col-sm-4 mt-2 mt-sm-0 notification-border">
                <div class="d-flex align-items-center pb-3 mb-4 border-bottom">
                    <div class="position-relative">
                        <img src="../assets/images/profile/user-1.jpg" alt="user1" width="54" height="54"
                            class="rounded-circle" />
                        <span class="position-absolute bottom-0 end-0 p-1 badge rounded-pill bg-success">

                            <span class="visually-hidden">New alerts</span>
                        </span>
                    </div>
                    <div class="me-3">
                        <h6 class="fw-semibold mb-2">{{ $user->name_ar }}</h6>
                        <p class="mb-0 fs-2">{{ $role }} </p>
                    </div>
                </div>

                <form class="position-relative mb-4">
                    <input type="text" class="form-control search-chat py-2 ps-5" id="text-srh"
                        placeholder="بحث ..." />
                    <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                </form>

                <!-- Nav tabs -->
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    @foreach ($notifications as $notification)
                        <a class="p-3 bg-hover-light-black d-flex align-items-start justify-content-between"
                            id="v-pills-home-tab-{{ $notification->id }}" data-bs-toggle="pill"
                            href="#v-pills-home-{{ $notification->id }}" role="tab"
                            aria-controls="v-pills-home-{{ $notification->id }}" aria-selected="true">
                            <div class="d-flex align-items-center">
                                <span class="position-relative">
                                    <img src="../assets/images/profile/user-2.jpg" alt="user-2" width="48"
                                        height="48" class="rounded-circle" />
                                    <span class="position-absolute bottom-0 end-0 p-1 badge rounded-pill bg-danger">
                                        <span class="visually-hidden">New alerts</span>
                                    </span>
                                </span>
                                <div class="me-3 d-inline-block w-75">
                                    <h6 class="mb-1 fw-semibold chat-title">{{ $notification->user->name_ar }}</h6>
                                    <span
                                        class="fs-3 text-truncate text-dark fw-semibold d-block">{{ $notification->title }}</span>
                                </div>
                            </div>
                            <p class="fs-2 mb-0 text-muted">
                                @if (
                                    \Carbon\Carbon::parse($notification->created_at)->hour !== null &&
                                        \Carbon\Carbon::parse($notification->created_at)->minute !== null)
                                    {{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans(null, true, true, 2) }}
                                @endif
                            </p>
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Notification Details -->
            <div class="col-sm-8">
                <div class="tab-content notification-tab" id="v-pills-tabContent">
                    <div class="tab-pane fade show py-3" id="v-pills-home" role="tabpanel"
                        aria-labelledby="v-pills-home-tab">
                        <h5>{{ $notification->title }}</h5>
                        <p>{{ $notification->descr }}</p>


                        @if ($notification->problem_id)
                            <a href="{{ route('supportProblem.show', $notification->problem_id) }}"
                                class="btn btn-link mt-2">
                                عرض
                            </a>
                        @endif
                    </div>
                    @foreach ($notifications as $notification)
                        <div class="tab-pane fade py-3" id="v-pills-home-{{ $notification->id }}" role="tabpanel"
                            aria-labelledby="v-pills-home-tab-{{ $notification->id }}">
                            <h5>{{ $notification->title }}</h5>
                            <p>{{ $notification->descr }}</p>


                            @if ($notification->problem_id)
                                <a href="{{ route('supportProblem.show', $notification->problem_id) }}"
                                    class="btn btn-link mt-2">
                                    عرض
                                </a>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
