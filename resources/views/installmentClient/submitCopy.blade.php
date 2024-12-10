<div class="card mt-4 py-3">
    <div class="d-flex flex-wrap ">
        @if (request()->route('status') === 'submit_archive')
            <a class=" btn-filter me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4 mx-1 mb-2 "
                href="{{ route('myinstall.index', ['status' => 'submit_archive']) }}">
                العدد الكلي ({{ App\Models\Installment_Client::where('status', 'submit_archive')->count() }})
            </a>
        @else
            <a class=" btn-filter me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4 mx-1 mb-2 "
                href="{{ route('myinstall.index', ['status' => 'transaction_submited']) }}">
                العدد الكلي ({{ $data['counts']['transaction_submitedCount'] }})
            </a>
        @endif
    </div>
</div>

<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0"> المعاملات المقدمة</h4>
        <div class="d-flex">
            @if (request()->route('status') === 'submit_archive')
            @else
                <a class="btn me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4 "
                    href="{{ route('myinstall.index', ['status' => 'submit_archive']) }}">
                    الارشيف </a>
            @endif
        </div>
    </div>


    <div class="card-body">
        <div class="table-responsive pb-4">
            <table id="all-student" class="table table-bordered border text-nowrap align-middle">
                <thead>
                    <!-- start row -->
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col"> اسم العميل</th>
                        <th scope="col"> رقم المدنى</th>
                        <th scope="col"> رقم العميل</th>
                        <th scope="col">الوسيط</th>
                        <th scope="col">الراتب</th>
                        <th scope="col">الوظيفة</th>
                        <th scope="col">البنك</th>
                        <th scope="col">مجموع الاقساط</th>
                        <th scope="col"> التاريخ</th>
                        <th scope="col">تقديم</th>
                    </tr>
                    <!-- end row -->
                </thead>
                <tbody>
                    @foreach ($Installment as $item)
                        <tr>
                            <td>
                                {{ $loop->index + 1 }}
                            </td>
                            <td>
                                {{ $item->name_ar }}
                            </td>
                            <td>
                                {{ $item->civil_number }}
                            </td>
                            <td>
                                {{ $item->phone }}
                            </td>
                            <td>
                                {{ $item->installmentBroker->name ?? 'لا يوجد' }}
                            </td>
                            <td>{{ $item->salary }} </td>
                            <td>{{ $item->ministry_working->name_ar ?? 'لا يوجد' }}</td>
                            <td>
                                {{ $item->bank->name_ar ?? 'لا يوجد' }}
                            </td>
                            <td>
                                {{ $item->installment_total }}
                            </td>
                            <td>
                                <div class="block">
                                    <h5>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</h5>
                                    <a class="btn btn-secondary w-100 mt-2" href="{{ route('advanced.notes',  $item->id) }}">

                                        الملاحظات</a>
                                </div>

                            </td>
                            <td>

                                <div>
                                    @if ($item->status == 'submit_archive')
                                        <button class="btn btn-danger" disabled>
                                            تمت الارشفة
                                        </button>
                                    @else
                                        <a class="btn btn-secondary w-100 mt-2"
                                            href="{{ route('installment.convert_approvedCopy', $item->id) }}">
                                            تقديم </a>
                                        </br>
                                        <form action="{{ route('myinstall.update', $item->id) }}" method="post"
                                            style="display:inline;">
                                            @csrf
                                            <input type="hidden" name="status" value="submit_archive">
                                            {{-- <a class="btn btn-secondary w-100 mt-2" data-bs-toggle="modal" data-bs-target="#archive"> --}}
                                            <button class="btn btn-success rounded-0 w-100 mt-2" type="submit">

                                                تحويل للارشيف</button>
                                        </form>
                                    @endif

                                    </li>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
   

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



