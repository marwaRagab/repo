<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0"> محتوي المشكلة
        </h4>
    </div>
    {{-- {{ dd($data) }} --}}
    <div class="card-body">
        <div class="table-responsive pb-4">
            <table class="table table-bordered border text-nowrap align-middle">
                <tbody>

                    <tr>
                        <td><strong>العنوان</strong></td>
                        <td>{{ $data->title }}</td>
                    </tr>
                    @if ($data->installement_id)
                        <tr>
                            <td><strong>رقم المعاملة</strong></td>
                            <td>{{ $data->installement_id }}</td>
                        </tr>
                    @endif

                    <tr>
                        <td><strong>التاريخ</strong></td>
                        <td>{{ \Carbon\Carbon::parse($data->created_at)->locale('ar')->isoFormat('YYYY/MM/DD') }}<br>{{ \Carbon\Carbon::parse($data->created_at)->locale('ar')->isoFormat('hh:mm:ss A') }}</td>
                    </tr>
                    <tr>
                        <td><strong>اسم المستخدم</strong></td>
                        <td>{{ $data->user->name_ar }}</td>
                    </tr>

                    <tr>
                        @if (Auth::user()->roles->name_ar == "superadmin")
                        <td><strong>المبرمج</strong></td>
                        <td>{{ $data->developer->name_ar ?? 'لا يوجد' }}</td>
                        @endif
                    </tr>
                    <tr>
                        <td><strong>الاولوية</strong></td>
                        <td >
                            <p class="p-2 text-white d-inline-block {{ $data->priority == 'high' ? 'bg-danger' : ($data->priority == 'medium' ? 'bg-primary' : 'bg-success') }}">
                                 {{ $data->priority == "high"
                                     ? "مرتفعة"
                                     : ($data->priority == "medium"
                                         ? "متوسطة"
                                         : "منخفضة")
                                 }}
                             </p>
                         </td>
                    </tr>
                    <tr>
                        <td><strong>القسم</strong></td>
                        <td>{{ $data->department->name_ar  ?? 'لا يوجد'}}</td>
                    </tr>
                    <tr>
                        <td><strong> القسم الفرعى</strong></td>
                        <td>{{ $data->subdepartment->name_ar ?? 'لا يوجد' }}</td>
                    </tr>

                    <tr>
                        <td><strong> وقت استلام التاسك</strong></td>
                        <td>{{ \Carbon\Carbon::parse($data->assign_date)->locale('ar')->isoFormat('YYYY/MM/DD') ?? 'لا يوجد' }}<br>{{ \Carbon\Carbon::parse($data->assign_date)->locale('ar')->isoFormat('hh:mm:ss A') ?? 'لا يوجد' }}</td>

                    </tr>
                    <tr>
                        <td><strong> وقت الانتهاء التاسك</strong></td>
                        <td>{{ \Carbon\Carbon::parse($data->end_task)->locale('ar')->isoFormat('YYYY/MM/DD') ?? 'لا يوجد' }}<br>{{ \Carbon\Carbon::parse($data->end_task)->locale('ar')->isoFormat('hh:mm:ss A') ?? 'لا يوجد' }}</td>

                    </tr>
                    <tr>
                        <td><strong> الرابط</strong></td>
                        <td>
                            @if ($data->link)
                                <a href="{{ $data->link }}" target="_blank">اضغط للمشاهدة</a>
                            @else
                                لا يوجد
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><strong>مرفق</strong></td>
                        <td>
                            @if ($data->file)
                                @php
                                    $fileExtension = pathinfo($data->file, PATHINFO_EXTENSION);
                                @endphp
                                @if (in_array($fileExtension, ['mp4', 'webm', 'ogg']))
                                    <video width="200" controls>
                                        <source src="{{ asset($data->file) }}"
                                            type="video/{{ $fileExtension }}">
                                        متصفحك لا يدعم الفيديو.
                                    </video>
                                @elseif (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']))
                                    <!-- Image -->
                                    <img src="{{ asset($data->file) }}" alt="Attachment" width="200">
                                @elseif ($fileExtension === 'pdf')
                                    <!-- PDF -->
                                    <a href="{{ asset($data->file) }}" target="_blank"
                                        class="btn btn-primary btn-sm">
                                        عرض الملف
                                    </a>
                                @else
                                    <!-- Unsupported File Type -->
                                    <span>نوع الملف غير مدعوم للعرض.</span>
                                @endif
                            @else
                                ---
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><strong>الحالة</strong></td>

                        <td> {{ $statusMapping[$data->status] }}<br>
                            {{-- @if (auth()->user()->support == 1) --}}
                                <form action="{{ route('supportProblem.updateStatus', ['id' => $data->id]) }}"
                                    method="POST">
                                    @csrf
                                    @method('POST')
                                    <button class="btn btn-secondary dropdown-toggle btn-sm rounded" type="button"
                                        id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        تحديث الحالة
                                    </button>
                                    <ul class="dropdown-menu rounded-0" aria-labelledby="dropdownMenuButton">
                                        <li>
                                            <button type="submit" class="btn btn-success rounded-0 btn-sm w-100 mt-2"
                                                name="status" value="1">جديد</button>
                                        </li>
                                        <li>
                                            <button type="submit" class="btn btn-warning rounded-0 btn-sm w-100 mt-2"
                                                name="status" value="2">قيد التدقيق</button>
                                        </li>
                                        <li>
                                            <button type="submit" class="btn btn-primary rounded-0 btn-sm w-100 mt-2"
                                                name="status" value="3">قيد العمل</button>
                                        </li>
                                        <li>
                                            <button type="submit" class="btn btn-info rounded-0 btn-sm w-100 mt-2"
                                                name="status" value="4">بانتظار الرد</button>
                                        </li>
                                        <li>
                                            <button type="submit" class="btn btn-warning rounded-0 btn-sm w-100 mt-2"
                                                name="status" value="5">قيد المراجعة</button>
                                        </li>
                                        <li>
                                            <button type="submit" class="btn btn-warning rounded-0 btn-sm w-100 mt-2"
                                                name="status" value="6"> تم الانتهاء منها</button>
                                        </li>
                                        <li>
                                            <button type="submit" class="btn btn-success rounded-0 btn-sm w-100 mt-2"
                                                name="status" value="7">منجزة</button>
                                        </li>
                                        {{-- <li>
                                            <button type="submit" class="btn btn-dark rounded-0 btn-sm w-100 mt-2"
                                                name="status" value="7">مغلقة</button>
                                        </li> --}}
                                    </ul>
                                </form>
                            {{-- @endif --}}
                        </td>
                    </tr>
                    <tr>
                        <td><strong>الوصف</strong></td>
                        <td> {!! nl2br(e($data->descr)) !!}</td>
                    </tr>
                </tbody>
            </table>

        </div>
        <div class="d-flex align-items-center justify-content-between mb-3 py-3 border-bottom">
            <h4 class="card-title mb-0"> تعليقات الطلب
            </h4>
        </div>
        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th>التاريخ</th>
                    <th>اليوزر</th>
                    <th>الرد</th>
                    <th>المرفق</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($replies as $reply)
                    <tr>
                        <td>{{ $reply->created_at }}</td>
                        <td>{{ $reply->user->name_ar }}</td>
                        <td> {!! nl2br(e($reply->descr)) !!}</td>
                        <td>
                            @if ($reply->file)
                                @php
                                    $fileExtension = pathinfo($reply->file, PATHINFO_EXTENSION);
                                @endphp
                                @if (in_array($fileExtension, ['mp4', 'webm', 'ogg']))
                                    <video width="200" controls>
                                        <source src="{{ asset( $reply->file) }}"
                                            type="video/{{ $fileExtension }}">
                                        متصفحك لا يدعم الفيديو.
                                    </video>
                                @elseif (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif','PNG','JPG']))
                                    <!-- Image -->
                                    <a href="{{ asset( $reply->file) }}" target="_blank"
                                        class="btn btn-primary btn-sm"> عرض الصورة
                                    </a>
                                    <!-- <img src="{{ asset( $reply->file) }}" alt="Attachment" width="200" > -->
                                @elseif ($fileExtension === 'pdf')
                                    <!-- PDF -->
                                    <a href="{{ asset( $reply->file) }}" target="_blank"
                                        class="btn btn-primary btn-sm">
                                        عرض الملف
                                    </a>
                                @else
                                    <!-- Unsupported File Type -->
                                    <span>نوع الملف غير مدعوم للعرض.</span>
                                @endif
                            @else
                                ---
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-muted">لا يوجد تعليقات.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Add Reply Section -->
        <div class="mt-4">
            <form action="{{ route('supportProblem.addReply', ['id' => $data->id]) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="problem_id" value="{{ $data->id }}">
                <div class="mb-3">
                    <label for="comment" class="form-label">أضف رد</label>
                    <textarea id="comment" name="descr" class="form-control" rows="3" placeholder="اكتب الرد هنا..." required></textarea>
                </div>

                <div class="mb-3">
                    <label for="fileUpload" class="form-label">إرفاق صورة أو فيديو</label>
                    <input type="file" id="fileUpload" name="file" class="form-control"
                        accept="image/*,video/*,application/pdf">
                    <small class="form-text text-muted">يجب أن يكون حجم الملف أقل من 10 ميجا.</small>
                </div>

                <button type="submit" class="btn btn-primary">إرسال</button>
            </form>
        </div>
    </div>
</div>
