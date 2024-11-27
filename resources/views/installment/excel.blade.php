<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
      <h4 class="card-title mb-0"> تصدير عملاء الاقساط</h4>
      <button type="button" class="btn btn-success" onclick="window.location.href='{{ route('export.clients') }}'">تصدير اكسيل</button>
    </div>
    <div class="card-body">
      <div class="table-responsive pb-4">
        <table id="all-student" class="table table-bordered border text-nowrap align-middle">
          <thead>
            <!-- start row -->
            <tr>
              <th>الاسم </th>
              <th> الرقم المدني</th>
              <th> رقم الهاتف</th>
              <th>رقم هاتف العمل</th>
              <th> رقم الهاتف الارضي</th>
              <th>هاتف اقرب شخص</th>
            </tr>
            <!-- end row -->
          </thead>
          <tbody>
            <!-- start row -->
            @foreach( $Client as $item)
            <tr>
              <td>
                {{ $loop->index + 1 }}
              </td>
              <td>
                {{$item->name_ar}}
              </td>
              <td>
                @foreach ($item->client_phone as $phone)
                    {{ $phone->phone ?? 'N/A' }}<br>
                @endforeach
            </td>
            
            <td>
                @foreach ($item->client_phone as $phone)
                    {{ $phone->phone_work ?? 'N/A' }}<br>
                @endforeach
            </td>
    
            <td>
                @foreach ($item->client_phone as $phone)
                    {{ $phone->phone_land ?? 'N/A' }}<br>
                @endforeach
            </td>
    
            <td>
                @foreach ($item->client_phone as $phone)
                    {{ $phone->nearist_phone ?? 'N/A' }}<br>
                @endforeach
            </td>
              
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>