@if ($errors->any())
    <!--  <div class="alert alert-danger">
      <ul>
          @foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
      </ul>
  </div>
  -->
@endif

@if (session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif
<!-- start File export -->
<div class="card">
    <div class="card-body">
        <div class="mb-2" style="">
            <h4 class="card-title mb-0">اقرارات دين مستلمة ({{ $count }})</h4>
        </div>

        <div class="card-body">

            <div class="table-responsive pb-4">
                <table id="all-student" class="table table-bordered border text-nowrap align-middle">
                    <thead>
                        <!-- start row -->
                        <tr>
                        <tr>
                            <th>م</th>
                            <th>رقم المعاملة </th>
                            <th>اسم العميل </th>
                            <th>تاريخ الاستلام</th>
                            <th> المسلم </th>
                            <th>المستلم</th>
                            <th>تحديد مسئول</th>
                            <th>الاجراءات</th>

                        </tr>

                        </tr>
                        <!-- end row -->
                    </thead>
                    <tbody>

                        @php $i=1; @endphp

                        @foreach ($all_paper_eqrar_dain_received as $item)
                            <!-- start row -->

                            <tr>
                                <td>{{ $i }}</td>
                                <td><a href="{{ route('installment.show-installment', $item->id) }}">{{ $item->id }}</a></td>
                                <td>{{ $item->name_ar }}</td>
                                <td>{{ $item->paper_eqrar_dain_received_date }}</td>
                                <td>{{ App\Models\User::find($item->paper_eqrar_dain_sender_id)->name_ar }}</td>
                                <td>{{ App\Models\User::find($item->paper_eqrar_dain_received_user_id)->name_ar }}</td>
                                {{-- تحديد مسئول --}}
                                <td>
                                    @include('military_affairs.Open_file.partial.column_responsible')
                                </td>
                                
                                <td>                                 
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#vertical-center-modal{{ $item->id }}" 
                                        {{ $item->emp_id == 0 || $item->emp_id == null ? 'disabled' : '' }} >
                                        فتح ملف
                                    </button>
                                    <!-- Primary Header Modal -->
                                    <div id="vertical-center-modal{{ $item->id }}" class="modal fade"
                                        tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable modal-lg">

                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <div class="text-center mt-2 mb-4" style="display:none;">
                                                        <a href="#" class="text-success">
                                                            <span>
                                                                <img src="{{ asset('assets/images/logos/favicon.png') }}"
                                                                    class="me-3 img-fluid" alt="spike-img" />
                                                            </span>
                                                        </a>
                                                    </div>

                                                    <form class="ps-3 pr-3" action="{{ route('papers.to_open_file') }}"
                                                        method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="mb-3">

                                                            <label class="mr-sm-2" for="inlineFormCustomSelect">اختر
                                                                الموظف المستلم</label>
                                                            <select class="form-select mr-sm-2"
                                                                id="inlineFormCustomSelect" name="received_user_id">
                                                                <option value='' selected>اختر...</option>
                                                                @foreach ($users as $onea)
                                                                    <option value="{{ $onea->id }}">
                                                                        {{ $onea->name_ar }} </option>
                                                                @endforeach
                                                            </select>

                                                            @error('received_user_id')
                                                                <div class="alert alert-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="formFile" class="form-label">تاريخ
                                                                الاستلام</label>
                                                            <input class="form-control" type="date"
                                                                name="convert_date" value="{{ old('convert_date') }}">
                                                            @error('convert_date')
                                                                <div class="alert alert-danger">{{ $message }}</div>
                                                            @enderror

                                                            <input class="form-control" type="text"
                                                                style="display:none;" name="installment_id"
                                                                value="{{ $item->id }}">

                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="message-text" class="">ملاحظة</label>
                                                            <textarea class="form-control" name="note_transfer" id="message-text1"></textarea>
                                                        </div>
                                                        <div class="mb-3 text-center">

                                                            <button type="button"
                                                                class="btn bg-danger-subtle text-danger "
                                                                data-bs-dismiss="modal">
                                                                اغلاق
                                                            </button>
                                                            <button class="btn bg-primary-subtle text-primary "
                                                                type="submit">
                                                                حفظ
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>

                                            </div>
                                        </div>
                                </td>
                            </tr>
                            <!-- end row -->

                            @php $i++; @endphp
                        @endforeach

                    </tbody>
                </table>

            </div>

        </div>
    </div>
