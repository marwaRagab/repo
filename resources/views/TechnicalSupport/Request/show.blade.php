<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0"> محتوي الطلب
        </h4>
    </div>
    <div class="card-body">
        <div class="table-responsive pb-4">
            <table class="table table-bordered border text-nowrap align-middle">
                <tbody>
                    <tr>
                        <td><strong>العنوان</strong></td>
                        <td>{{ $data->title }}</td>
                    </tr>
                    <tr>
                        <td><strong>الوصف</strong></td>
                        <td>{{ $data->descr }}</td>
                    </tr>
                    <tr>
                        <td><strong>التاريخ</strong></td>
                        <td>{{ \Carbon\Carbon::parse($data->created_at)->format('Y/m/d h:i:s A') }}</td>
                    </tr>
                    <tr>
                        <td><strong>اسم المستخدم</strong></td>
                        <td>{{ $data->user->name_ar }}</td>
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
                                        <source src="{{ asset('storage/' . $data->file) }}"
                                            type="video/{{ $fileExtension }}">
                                        متصفحك لا يدعم الفيديو.
                                    </video>
                                @elseif (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']))
                                    <!-- Image -->
                                    <img src="{{ asset('storage/' . $data->file) }}" alt="Attachment" width="200">
                                @elseif ($fileExtension === 'pdf')
                                    <!-- PDF -->
                                    <a href="{{ asset('storage/' . $data->file) }}" target="_blank"
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
                            @if (auth()->user()->support == 1)
                                <form action="{{ route('supportRequest.updateStatus', ['id' => $data->id]) }}"
                                    method="POST">
                                    @csrf
                                    @method('POST')
                                    <button class="btn btn-secondary dropdown-toggle btn-sm rounded" type="button"
                                        id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        تحديث الحالة
                                    </button>
                                    <ul class="dropdown-menu rounded-0" aria-labelledby="dropdownMenuButton">
                                        <li>
                                            <button type="submit" class="btn btn-info rounded-0 btn-sm w-100 mt-2"
                                                name="status" value="1">جديد</button>
                                        </li>
                                        <li>
                                            <button type="submit" class="btn btn-warning rounded-0 btn-sm w-100 mt-2"
                                                name="status" value="2">قيد التدقيق</button>
                                        </li>
                                        <li>
                                            <button type="submit" class="btn btn-success rounded-0 btn-sm w-100 mt-2"
                                                name="status" value="3">موافق عليها</button>
                                        </li>
                                        <li>
                                            <button type="submit" class="btn btn-danger rounded-0 btn-sm w-100 mt-2"
                                                name="status" value="4">مرفوضة</button>
                                        </li>
                                        <li>
                                            <button type="submit" class="btn btn-warning rounded-0 btn-sm w-100 mt-2"
                                                name="status" value="5">قيد العمل</button>
                                        </li>
                                        <li>
                                            <button type="submit" class="btn btn-warning rounded-0 btn-sm w-100 mt-2"
                                                name="status" value="6">قيد المراجعة</button>
                                        </li>
                                        <li>
                                            <button type="submit" class="btn btn-success rounded-0 btn-sm w-100 mt-2"
                                                name="status" value="7">تم الانتهاء منها</button>
                                        </li>
                                        <li>
                                            <button type="submit" class="btn btn-dark rounded-0 btn-sm w-100 mt-2"
                                                name="status" value="8">مغلقة</button>
                                        </li>
                                    </ul>
                                </form>
                            @endif
                        </td>
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
                        <td>{{ $reply->descr }}</td>
                        <td>
                            @if ($reply->file)
                                @php
                                    $fileExtension = pathinfo($reply->file, PATHINFO_EXTENSION);
                                @endphp
                                @if (in_array($fileExtension, ['mp4', 'webm', 'ogg']))
                                    <video width="200" controls>
                                        <source src="{{ asset('storage/' . $reply->file) }}"
                                            type="video/{{ $fileExtension }}">
                                        متصفحك لا يدعم الفيديو.
                                    </video>
                                @elseif (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']))
                                    <!-- Image -->
                                    <img src="{{ asset('storage/' . $reply->file) }}" alt="Attachment" width="200">
                                @elseif ($fileExtension === 'pdf')
                                    <!-- PDF -->
                                    <a href="{{ asset('storage/' . $reply->file) }}" target="_blank"
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
            <form action="{{ route('supportRequest.addReply', ['id' => $data->id]) }}" method="POST"
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
