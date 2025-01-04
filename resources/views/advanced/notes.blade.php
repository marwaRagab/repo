<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0">المعاملات </h4>
        
    </div>
    
</div>
{{-- {{dd($Installment_client)}} --}}

<div class="card">
    <div class="card-body">
        <div class="modal-header d-flex align-items-center">
            <h4 class="modal-title" id="myModalLabel">
               الملاحظات</h4>
        </div>
        <div class="modal-content">
            {{-- <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myModalLabel">
                    ملاحظات </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div> --}}
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

                                @if ($Installment_client->installment_note->count() > 0 )
                                    @foreach ($Installment_client->installment_note as $installment_note)
                                        <tr>
                                            <td>{{ $installment_note->user->name_ar }}</td>
                                            <td>{{ $installment_note->reply }}</td>
                                            <td>{{ $installment_note->time }}</td>
                                            <td>{{ $installment_note->date }}</td>
                                            <td>{{ $installment_note->note }} </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" class="text-center">لم يتم إدخال بيانات</td>
                                    </tr>
                                @endif
                                
                                

                            </tbody>
                        </table>
                        <h3>ملاحظات القضايا</h3>
                        <div class="d-flex flex-wrap ">
                            <a id="openIssueCount"
                                class="me-1 mb-1 bg-primary-subtle text-primary px-4  mx-1 mb-2">
                                المفتوحة : {{ $opening_amount }}د.ك
                            </a>
                            <a id="closeIssueCount" class="bg-success-subtle text-success px-4  mx-1 mb-2">
                                المغلقة : {{ $closing_amount }} د.ك
                            </a>
                            <a id="totalIssueCount" class="bg-warning-subtle text-warning px-4  mx-1 mb-2">
                                الإجمالي : {{ $totalissue }} د.ك
                            </a>
                        </div>
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
                                    <th> الصورة</th>
                                </tr>
                                <!-- end row -->
                            </thead>
                            <tbody>
                                <!-- start row -->
                                @if ($Installment_client->installment_issue->count() > 0 )
                                    @foreach ($Installment_client->installment_issue as $installment_issue)
                                        <tr>
                                            <td>{{ $installment_issue->user->name_ar ?? ' لا يوجد' }}</td>
                                            <td>{{ $installment_issue->number_issue ?? ' لا يوجد'  }}</td>
                                            <td>{{ $installment_issue->status === 'open' ? 'مفتوح' : 'مغلق' }}</td>
                                            <td>{{ $installment_issue->working_company ?? 'لا يوجد' }}</td>
                                            <td>{{ $installment_issue->status === 'open' ? $installment_issue->opening_amount : $installment_issue->closing_amount }}</td>
                                            <td>{{ $installment_issue->date ?? 'لا يوجد' }}</td>
                                            
                                            <td>
                                                @if($installment_issue->image)
                                                    @php
                                                        $fileExtension = pathinfo($installment_issue->image, PATHINFO_EXTENSION);
                                                    @endphp                                                       
                                                    @if($fileExtension === 'pdf')
                                                        <a href="{{ asset($installment_issue->image) }}" target="_blank">
                                                            <embed src="{{ asset($installment_issue->image) }}" type="application/pdf" width="100" height="150" style="cursor: pointer;">
                                                        </a>
                                                    @else
                                                    <a href="{{ asset($installment_issue->image) }}" target="_blank">
                                                        <img src="{{ asset($installment_issue->image) }}" alt="الصورة" style="width: 50px; height: auto; cursor: pointer;">
                                                    </a>
                                                    @endif
                                                @else
                                                    <span>لا توجد صورة</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" class="text-center">لم يتم إدخال بيانات</td>
                                    </tr>
                                @endif

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
                                    <th> متوسط السعر</th>
                                    <th>الصورة </th>
                                </tr>
                                <!-- end row -->
                            </thead>
                            <tbody>
                                @if ($Installment_client->installment_car->count() > 0 )
                                    @foreach ($Installment_client->installment_car as $installment_car)
                                        <tr>
                                            <td>{{ $installment_car->user->name_ar ?? 'لا يوجد' }}</td>
                                            <td>{{ $installment_car->type_car  ?? 'لا يوجد' }}</td>
                                            <td>{{ $installment_car->model_year ?? 'لا يوجد' }}</td>
                                            <td>{{ $installment_car->average_price ?? 'لا يوجد' }}</td>
                                            <td>
                                                @if($installment_car->image)
                                                
                                                    <img src="{{ asset($installment_car->image) }}" alt="الصورة" width="100">
                                                @else
                                                    لا توجد صورة
                                                    
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" class="text-center">لم يتم إدخال بيانات</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane p-3" id="navpill-2" role="tabpanel">
                        <form id="addNoteForm" onsubmit="submitNoteForm(event)" method="POST" >
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
                                            name="installment_clients_id" value="{{ $Installment_client->id }}">

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
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
      function submitNoteForm(event) {
        event.preventDefault(); // Prevent default form submission

        const reply = document.getElementById('reply').value;
        const note = document.getElementById('note').value;
        const installment_clients_id = document.getElementById('installment_client_id').value;

        console.log("Submitting form with data:", {
            reply,
            note,
            installment_clients_id
        });

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
                // Reload the current page
                 location.reload();

                // Refresh the notes list
            },
            error: function(error) {
                console.error('Error adding note:', error);
                alert('Failed to add note. Please try again.');
            }
        });
    }
</script>


