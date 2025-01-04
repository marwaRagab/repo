<div class="card mt-4 py-3">
    <div class="d-flex flex-wrap ">
        <a class=" btn-filter me-1 mb-1 bg-primary-subtle text-primary px-4  mx-1 mb-2 " href="{{ route('myinstall.index', ['status' => "refused"]) }}">
            العدد الكلي ({{ $data['counts']['rejectedCount'] }})
        </a>
    </div>
</div>

<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0"> المعاملات المرفوضة</h4>
        <div class="d-flex">

            {{-- <a class="btn me-1 mb-1 bg-primary-subtle text-primary px-4  " href="./archive.html">
                الارشيف </a> --}}
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive pb-4">
            <table id="all-student" class="table table-bordered border text-nowrap align-middle">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col"> اسم العميل</th>
                        <th scope="col">الوسيط</th>
                        <th scope="col">الراتب</th>
                        <th scope="col">الوظيفة</th>
                        <th scope="col">استعلام قضائى</th>
                        <th scope="col">استعلام</th>
                        <th scope="col">البنك</th>
                        <th scope="col">مجموع الاقساط</th>
                        <th scope="col"> التاريخ</th>
                        <th scope="col">سبب الرفض</th>
                    </tr>
                    <!-- end row -->
                </thead>
                <tbody>
                    @foreach( $Installment as $item)
                    <tr>
                      <td>
                        {{ $loop->index + 1 }}
                      </td>
                      <td>
                        {{$item->name_ar}}
                      </td>
                      <td>
                        {{$item->installmentBroker->name  ?? 'لا يوجد'}}
                      </td>
                      <td>{{$item->salary}} </td>
                      <td>{{$item->ministry_working->name_ar  ?? 'لا يوجد'}}</td>
                      <td> <div class="d-block">
                        <h6>@if($item->installment_issue->isNotEmpty())
                          <h6>{{ $item->installment_issue->first()->date }}</h6>
                      @else
                          <h6>لا يوجد استعلام قضائى</h6>
                      @endif
                        <div>
                          <a class="btn me-1 mb-1 bg-primary-subtle text-primary px-4  " data-bs-toggle="modal"
                            data-bs-target="#estlaam-modal-md" data-id="{{ $item->id }}" data-name="{{ $item->name_ar }}">
                            استعلام قضائي </a>
                        </div>
                        <div>
                          <a class="btn me-1 mb-1 bg-primary-subtle text-primary px-4  " href="">
                            صوره الاستعلام </a>
                        </div>
                      </div> </td>
                      <td> <div class="btn-group dropup mb-6 me-6 d-block">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                          data-bs-toggle="dropdown" aria-expanded="false">
                          نتيجة الاستعلام </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          <li>
                              <form action="{{ route('myinstall.update', $item->id) }}" method="post" style="display:inline;">
                                  @csrf
                                  <input type="hidden" name="status" value="under_inquiry">
                                  <button class="btn btn-success rounded-0 w-100 mt-2" type="submit">
                                   قيد الاستعلام
                                  </button>
                              </form>
                          </li>
                          <li>
                              <form action="{{ route('myinstall.update', $item->id) }}" method="post" style="display:inline;">
                                  @csrf
                                  <input type="hidden" name="status" value="auditing">
                                  <button class="btn btn-success rounded-0 w-100 mt-2" type="submit">
                              التدقيق القضائي</button>
                          </form>
                          </li>
                          <li>
                              <form action="{{ route('myinstall.update', $item->id) }}" method="post" style="display:inline;">
                                  @csrf
                                  <input type="hidden" name="status" value="car_inquiry">
                                  <button class="btn btn-success rounded-0 w-100 mt-2" type="submit"> استعلام سيارات
                                    </button>
                          </form>
                          </li>
                          <li>
                              <form action="{{ route('myinstall.update', $item->id) }}" method="post" style="display:inline;">
                                  @csrf
                                  <input type="hidden" name="status" value="inquiry_done">
                                  <button class="btn btn-success rounded-0 w-100 mt-2" type="submit">
                              تم الاستعلام</button>
                          </form>
                          </li>
                          <li>

                            <form action="{{ route('myinstall.update', $item->id) }}" method="post" style="display:inline;">
                              @csrf
                              <input type="hidden" name="status" value="accepted_condition">
                              <button class="btn btn-success rounded-0 w-100 mt-2" type="submit">
                          مقبول بشرط</button>
                          </li>
                          <li>
                            <a class="btn btn-info rounded-0 w-100 mt-2" data-bs-toggle="modal"
                            data-bs-target="#accept-modal-md" data-id="{{ $item->id }}" data-name="{{ $item->name_ar }}" type="submit">
                              مقبول </a>

                          </form>
                          </li>
                          <li>
                            <a class="btn btn-warning rounded-0 w-100 mt-2" data-bs-toggle="modal"
                            data-bs-target="#reject-modal-md" data-id="{{ $item->id }}" data-name="{{ $item->name_ar }}" type="submit">
                              مرفوض</a>
                          </li>

                        </ul>
                      </div>
                      <div>
                          @if ($item->status == 'archive')
                                  <button class="btn btn-danger" disabled>
                                      تمت الارشفة
                                  </button>
                              @else
                                  <form action="{{ route('myinstall.update', $item->id) }}" method="post" style="display:inline;">
                                      @csrf
                                      <input type="hidden" name="status" value="archive">
                                    {{-- <a class="btn btn-secondary w-100 mt-2" data-bs-toggle="modal" data-bs-target="#archive"> --}}
                                      <button class="btn btn-success rounded-1 w-100 mt-2" type="submit">

                                  تحويل للارشيف</button> </form>
                              @endif
                            </td>
                      <td>
                        {{$item->bank->name_ar  ?? 'لا يوجد'}}
                      </td>
                      <td>
                        {{$item->installment_total}}
                      </td>
                      <td>
                            <div class="block">
                            <h5>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y')}}</h5>
                            <a class="btn btn-secondary w-100 mt-2"  href="{{ route('advanced.notes',  $item->id) }}">

                              الملاحظات</a>
                            </div>

                        </td>
                        <td>{{$item->reason}}</td>
                    </tr>
                     @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
    <!-- notes model  -->
<div id="open-details" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg">
    <div class="modal-content">
      <div class="modal-header d-flex align-items-center">
        <h4 class="modal-title" id="myModalLabel">
          الملاحظات </h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <ul class="nav nav-pills" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#navpill-1" role="tab">
              <span>الملاحظات</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#navpill-2" role="tab">
              <span>الرد</span>
            </a>
          </li>

        </ul>
        <!-- Tab panes -->
        <div class="tab-content border mt-2">
          <div class="tab-pane active p-3" id="navpill-1" role="tabpanel">
            {{-- <h6 class="text-danger">عفوا ، لم يتم الاستعلام القضائي</h6>
            <h6 class="text-danger">عفوا ، لم يتم الاستعلام للتنفيذ</h6> --}}
            <table id="notes1" class="table table-bordered border text-wrap align-middle">
              <thead>
                <!-- start row -->
                <tr>
                  <th>اليوزر</th>
                  <th>الاتصال</th>
                  <th>الساعة</th>
                  <th>التاريخ</th>
                  <th> الملاحظه</th>

                </tr>
                <!-- end row -->
              </thead>
              <tbody>
                <!-- start row -->

              </tbody>
            </table>

            <h3>ملاحظات القضايا</h3>
            <table id="notesissue" class="table table-bordered border text-wrap align-middle">
                <thead>
                    <!-- start row -->
                    <tr>
                        <th>اليوزر</th>
                        <th>رقم القضية</th>
                        <th>الحالة</th>
                        <th>الجهة</th>
                        <th>المبلغ</th>
                        <th> التاريخ</th>



                    </tr>
                    <!-- end row -->
                </thead>
                <tbody>
                    <!-- start row -->

                </tbody>
            </table>
            <h3>ملاحظات السيارات</h3>
            <table id="notescar" class="table table-bordered border text-wrap align-middle">
                <thead>
                    <!-- start row -->
                    <tr>
                        <th>اليوزر</th>
                        <th>النوع</th>
                        <th>السنة</th>
                        <th> متوسط  السعر</th>

                    </tr>
                    <!-- end row -->
                </thead>
                <tbody>
                    <!-- start row -->

                </tbody>
            </table>
          </div>
          <div class="tab-pane p-3" id="navpill-2" role="tabpanel">
            <form id="addNoteForm" onsubmit="submitNoteForm(event)">
              <div class="form-row">
                <div class="form-group">
                  <label class="form-label"> الاتصال</label>
                  <select class="form-select" id="reply" name="reply">
                    <option value="answered">
                      رد </option>
                    <option value="refused">
                      لم يرد </option>
                    <option value="note_under_info">
                      ملاحظة </option>
                  </select>
                </div>
                <div class="form-group">
                  <div class="my-3">
                    <label class="form-label">الملاحظات</label>
                    <textarea class="form-control" rows="5" id="note" name="note"></textarea>
                    <input type="hidden" id="installment_client_id"
                                                name="installment_clients_id" value="">

                  </div>
                </div>
                <div class="form-group">
                  <button type="submit" class="btn btn-primary">إضافة ملاحظة</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer d-flex ">
      <!-- <a class="btn btn-primary" href="../installments/show-installment.html"> تفصيل المعاملة</a> -->
      <button type="button" class="btn bg-danger-subtle text-danger  waves-effect" data-bs-dismiss="modal">
        إغلاق
      </button>
    </div>
  </div>
</div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Include Moment.js -->

    <script>
      $(document).ready(function() {
               $('#open-details').on('show.bs.modal', function(event) {
                   var button = $(event.relatedTarget); // Button that triggered the modal
                   var itemId = button.data('id'); // Extract info from data-* attributes
                   var modal = $(this);
                   // Set the installment_clients_id in the hidden input
                   modal.find('#installment_client_id').val(itemId);

                   // Clear previous content to prevent duplication
                   var notesTableBody = modal.find('#notes1 tbody');
                   var notesIssueTableBody = modal.find('#notesissue tbody');
                   var notesCarTableBody = modal.find('#notescar tbody');
                   notesTableBody.empty();
                   notesIssueTableBody.empty();
                   notesCarTableBody.empty();

                   // AJAX call to fetch notes for the specific item
                   $.ajax({
                       url: '/myinstall/notes/' + itemId,
                       method: 'GET',
                       success: function(response) {
                           // Populate the table with new notes if available
                           if (response.notes && response.notes.length > 0) {
                               response.notes.forEach(function(note) {
                                   notesTableBody.append(`
                               <tr>
                                   <td>${note.user.name_ar}</td>
                                   <td>${note.reply}</td>
                                   <td>${note.time}</td>
                                   <td>${note.date}</td>
                                   <td><p>${note.note}</p></td>
                               </tr>
                           `);
                               });
                           } else {
                               // Display message if no notes found
                               notesTableBody.append(
                                   '<tr><td colspan="5" class="text-center">لا توجد ملاحظات</td></tr>'
                               );
                           }
                       },
                       error: function(xhr, status, error) {
                           console.error("Error fetching notes:", error);
                           notesTableBody.append(
                               '<tr><td colspan="5" class="text-center">خطأ في تحميل البيانات</td></tr>'
                           );
                       }
                   });
                   // issue
                   $.ajax({
               url: '/myinstall/notesissue/' + itemId,
               method: 'GET',
               success: function(response) {
                   // Populate the table with new issue notes if available
                   if (response.notesissue && response.notesissue.length > 0) {
                       response.notesissue.forEach(function(issue) {
                           notesIssueTableBody.append(`
                               <tr>
                                   <td>${issue.created_by_name}</td>
                                   <td>${issue.number_issue}</td>
                                 ${issue.status === 'open' ? `<td>مفتوح</td>` : `<td>مغلق</td>`}
                                   <td>${issue.working_company}</td>
                                   <td>${issue.opening_amount}</td>
                                   <td><p>${issue.date	}</p></td>
                               </tr>
                           `);
                       });
                   } else {
                       notesIssueTableBody.append(
                           '<tr><td colspan="5" class="text-center">لا توجد قضايا</td></tr>'
                       );
                   }
               },
               error: function(xhr, status, error) {
                   console.error("Error fetching issue notes:", error);
                   notesIssueTableBody.append(
                       '<tr><td colspan="5" class="text-center">خطأ في تحميل بيانات القضايا</td></tr>'
                   );
               }
           });

           // car
           $.ajax({
               url: '/myinstall/notescar/' + itemId,
               method: 'GET',
               success: function(response) {
                   // Populate the table with new issue notes if available
                   if (response.notescar && response.notescar.length > 0) {
                       response.notescar.forEach(function(car) {
                           notesCarTableBody.append(`
                               <tr>
                                   <td>${car.user.name_ar}</td>
                                   <td>${car.type_car}</td>
                                   <td>${car.model_year}</td>
                                   <td><p>${car.average_price}</p></td>
                               </tr>
                           `);
                       });
                   } else {
                       notesCarTableBody.append(
                                '<tr><td colspan="5" class="text-center">لا يوجد استعلام سيارات</td></tr>'
                            );
                   }
               },
               error: function(xhr, status, error) {
                   console.error("Error fetching car notes:", error);
                   notesCarTableBody.append(
                       '<tr><td colspan="5" class="text-center">خطأ في تحميل بيانات السيارات</td></tr>'
                   );
               }
           });
               });
           });

           function submitNoteForm(event) {
            event.preventDefault(); // Prevent default form submission

            const reply = document.getElementById('reply').value;
            const note = document.getElementById('note').value;
            const installment_clients_id = document.getElementById('installment_client_id').value;

            console.log("Submitting form with data:", { reply, note, installment_clients_id });

            $.ajax({
                url: '/InstallmentClientNote/store', // Your backend route for storing the note
                method: 'POST',
                data: {
                    reply: reply,
                    note: note,
                    installment_clients_id: installment_clients_id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log('Note added successfully:', response);
                    document.getElementById('addNoteForm').reset(); // Reset the form
                    // Refresh the notes list
                },
                error: function(error) {
                    console.error('Error adding note:', error);
                    alert('Failed to add note. Please try again.');
                }
            });
        }

   </script>
