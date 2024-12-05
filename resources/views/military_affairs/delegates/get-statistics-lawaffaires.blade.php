<div class="card">
            <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
              <h4 class="card-title mb-0"> عدد استعلام رصيد التنفيذ
            </h4>
            </div>
            <div class="card-body">
              <div class="table-responsive pb-4">
                <table id="all-student" class="table table-bordered table-striped border text-nowrap align-middle">
                    <thead class="thead-dark">
                        <tr>
                          <th>م</th>
                          <th>المبلغ</th>
                          <th>التاريخ</th>
                          <th>النوع</th>
                          <th>الصورة</th>
                        </tr>
                      </thead>
                      <tbody>
                      @foreach ($data['delegates'] as $item)
                        <tr>
                          <td>{{ $loop->index + 1 }}</td>
                          <td>{{$item->amount}}</td>
                          <td>{{ \Carbon\Carbon::createFromTimestamp($item->date)->format('Y-m-d') }}</td>
                          @if ($item->check_type == 'salary')
                          <td>حجز راتب</td>
                          @elseif($item->check_type == 'banks')
                          <td>حجز بنوك</td>
                          @elseif($item->check_type == 'cars')
                          <td>حجز سيارات</td>
                          @elseif($item->check_type == 'mahkama_installment')
                          <td>تقسيط محكمة</td>
                          @elseif($item->check_type == 'mahkama_madionia_sadad')
                          <td>سداد مديونية محكمة</td>
                          @else
                          <td> لا يوجد</td>
                          @endif
                         
                          <td>
                            @if (!empty($item->img_dir))
                                <img src="https://electron-kw.net{{ $item->img_dir }}" alt="Image Description" style="width: 50px; height: 50px;">
                            @else
                                <span>لا توجد صورة</span>
                            @endif
                        </td>
                        </tr>
                        @endforeach
                      </tbody>
                </table>

              </div>
            </div>
          </div>