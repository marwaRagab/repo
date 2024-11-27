


<div class="card">
            <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
              <h4 class="card-title mb-0"> عدد الملفات المغلقة
            </h4>
            </div>
            <div class="card-body">
              <div class="table-responsive pb-4">
                <table id="all" class="table table-bordered table-striped border text-nowrap align-middle">
                    <thead class="thead-dark">
                        <tr>
                          <th>م</th>
                          <th>رقم المعاملة</th>
                          <th>تاريخ بدء المعاملة</th>
                          <th>تاريخ الاغلاق</th>
                          <th>الحالة</th>
                        </tr>
                      </thead>
                      <tbody>
                      @foreach ($data['delegates'] as $item)
                        <tr>
                          <td>{{ $loop->index + 1 }}</td>
                          <td>{{$item->militaryAffair->installment->id}}</td>
                          <td>{{$item->militaryAffair->created_at }}</td>
                          <td>{{ \Carbon\Carbon::createFromTimestamp($item->end_date)->format('Y-m-d') }} </td>
                          @if ($item->open_file_date !== null && $item->execute_date === null && $item->image_date === null && $item->case_proof_date === null && $item->certificate_date === null)
                            <td>فتح ملف</td>
                            @elseif ($item->execute_date !== null && $item->image_date === null && $item->case_proof_date === null && $item->certificate_date === null)
                                <td>اعلان التنفيذ</td>
                            @elseif ($item->image_date !== null && $item->case_proof_date === null && $item->certificate_date === null)
                                <td>الايمج</td>
                            @elseif ($item->case_proof_date !== null)
                                <td>اثبات حالة</td>
                            @elseif ($item->travel_date !== null)
                                <td>منع السفر</td>
                            @elseif ($item->certificate_date !== null)
                                <td>اصدار شهادة عسكرية</td>
                            @elseif ($item->salary_date !== null)
                                <td>حجز راتب</td>
                            @elseif ($item->car_date !== null)
                                <td>حجز سيارات</td>
                            @elseif ($item->bank_date !== null)
                                <td>حجز بنوك</td>
                            @endif
                          
                        </tr>
                        @endforeach
                        
                      </tbody>
                </table>

              </div>
            </div>
          </div>