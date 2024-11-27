<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
      <h4 class="card-title mb-0"> عدد الملفات الحالية</h4>
    </div>
    <div class="card-body">
      <div class="table-responsive pb-4">
        <table id="all" class="table table-bordered table-striped border text-nowrap align-middle">
            <thead class="thead-dark">
                <tr>
                  <th>م</th>
                  <th>رقم المعاملة</th>
                  <th>اسم العميل</th>
                  <th>رقم الهاتف</th>
                  <th>المحكمة</th>
                  <th>تاريخ البدء</th>
                  <th>مبلغ المديونية</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($data['delegates'] as $item)
                <tr>
                  <td>{{ $loop->index + 1 }}</td>
                  <td>{{$item->militaryAffair->installment->id}}</td>
                  <td> {{$item->militaryAffair->installment->client->name_ar}}</td>
                  <td>{{ $item->militaryAffair->installment->client->client_phone->first()?->phone }}</td>
                  <td>{{$item->militaryAffair->installment->client->court->name_ar}}</td>
                  <td>{{$item->militaryAffair->created_at }}</td>
                  <td>{{$item->militaryAffair->madionia_amount }}</td>
                </tr>
                @endforeach
              </tbody>
        </table>

      </div>
    </div>
  </div>