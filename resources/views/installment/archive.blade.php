<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-1 border-bottom">
      <h4 class="card-title mb-0">ارشيف المعاملات</h4>
    </div>
    <div class="card-body">
      <div class="table-responsive pb-4">
        <table id="all-student" class="table table-bordered border text-nowrap align-middle">
          <thead>
            <!-- start row -->
            <tr>
              <th>#</th>
              <th>رقم المعاملة </th>
              <th>اسم العميل</th>
              <th> الرقم المدني</th>
              <th>التاريخ</th>
              <th>اجمالي الاقساط</th>
              <th>المقدم</th>
              <th>عدد الاقساط</th>
              <th> قيمة القسط الشهري</th>
              <th> طباعة براءة ذمة</th>
              <th> طباعة ايقاف استقطاع</th>
              
              <th> عرض التفاصيل</th>
            </tr>
            <!-- end row -->
          </thead>
          <tbody>
            <!-- start row -->
            @foreach( $Installment as $item)
            <tr>
              <td>
                {{ $loop->index + 1 }}
              </td>
              <td>
                {{$item->id}}
              </td>
              <td>{{$item->client->name_ar ?? 'لا يوجد' }} </td>
              <td>{{$item->client->civil_number ?? 'لا يوجد' }}</td>
              <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y')}}</td>
                     
              <td>                                {{ $item->extra_first_amount + $item->first_amount}}
 </td>
             
              @if ($item->installment_client && $item->installment_client->part)
              <td>{{$item->installment_client->part}}</td>
              @else
              <td>{{$item->first_amount}}</td>
              @endif
              <td>
                {{$item->count_months ?? null}}
              </td>
              <td>
                {{$item->monthly_amount ?? null}}
              </td>
              <td class="text-success">طباعة براءة ذمة</td>
              <td class="text-success">طباعة ايقاف استقطاع</td>
              <td>
                <div class="d-block">
                  <div>
                    <button class="btn me-1 mb-1 bg-primary-subtle text-primary px-4  ">
                      عرض التفاصيل
                    </button>
                  </div>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>