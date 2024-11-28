<div class="card">
            <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
              <h4 class="card-title mb-0"> احصائيات المسئولين</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive pb-4">
                <table id="all" class="table table-bordered border text-nowrap align-middle">
                    <thead class="thead-dark">
                        <tr>
                          <th>#</th>
                          <th>اسم المسؤل</th>
                          <th>عدد الملفات الحالية</th>
                          <th>عدد الملفات المغلقة</th>
                          <th>عدد الملاحظات</th>
                          <th>عدد استعلام رصيد التنفيذ</th>
                          <th>المتوسط الكلى</th>
                          <th>الاحصائيات</th>
                        </tr>
                      </thead>
                      <tbody>
                      @foreach ($data['users'] as $item)
                        <tr>
                          <td>{{ $loop->index + 1 }}</td>
                          <td>{{ $item->name_ar }}</td>
                          <td><a href="{{ route('military_affairs.get_statistics_details', $item->id) }}" class="text-underline text-info" >{{App\Models\military_affairs_deligation::where('emp_id', $item->id)->where('end_date' , null)->count()}}</a></td>
                          <td><a href="{{ route('military_affairs.get_statistics_deligations', $item->id) }}" class="text-underline text-success" >{{App\Models\military_affairs_deligation::where('emp_id', $item->id)->whereNotNull('end_date')->count()}}</a></td>
                          <td><a href="{{ route('military_affairs.get_statistics_notes_details', $item->id) }}" class="text-underline text-indigo" >{{App\Models\military_affairs_notes::where('created_by', $item->id)->count()}}</a></td>
                          <td><a href="{{ route('military_affairs.get_statistics_lawaffaires', $item->id) }}" class="text-underline text-success" >{{App\Models\Military_affairs\Military_affairs_amount::where('created_by', $item->id)->count()}}</a></td>
                          <td>50</td>
                          <td><a class="btn btn-info" href="../legal-affairs/get-statistics-emp.html">الاحصائيات</a></td>
                        </tr>
                        @endforeach
                      </tbody>
                </table>

              </div>
            </div>
          </div>