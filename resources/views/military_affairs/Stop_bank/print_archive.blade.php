<!DOCTYPE html>
<html dir="rtl" lang="ar" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="horizontal">

<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Favicon icon-->
    <link rel="shortcut icon" type="image/png" href="{{asset('assets/images/logos/logo.jpg')}}" />

    <!-- Core Css -->
    <link rel="stylesheet" href="{{asset('assets/css/styles.css')}}" />

    <title>Electron</title>
    <link rel="stylesheet" href="{{asset('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}">
</head>

<body>
  <div class="container my-5">
    <div class="row">
            <div class="col-12 text-center py-3">
                <h5 > 
                    كشوف البنوك الخاطئة

                  </h5>
              </div>
                <div class="col-12 py-3 mx-5 ">
                <table class="table table-bordered">
                    
                    <tbody>
                      
                      <tr>
                        <th scope="row">  #	 </th>
                        <th scope="row"> اسم العميل	 	 </th>
                        <th scope="row">  البنك	 </th>
                        <th scope="row">  رقم الحساب		 </th>
                        <th scope="row">رقم الهاتف
                        </th>
                      </tr>
                      @foreach($items as $item)
                      @if($item->installment->finished==0)

                        @php
                            $item_statues=   $item->notes->where('type','=','stop_bank')->where('times_type_id',$item_type_time_old->id)->where('date_end',NULL);
                        @endphp

                      <tr>
                      <td>{{ $loop->index + 1 }}	</td>
                      <td> {{$item->installment->client->name_ar}}  <br>
                      {{$item->installment->client->civil_number}}	</td>

                      @php
                              $bank = DB::table('client_banks')->where('client_id', $item->installment->client->id)->first();
                              if($bank)
                              $bank_name = DB::table('banks')->where('id', $bank->bank_name)->first();

                              @endphp

                      <td>{{ $bank_name->name_ar ?? 'لا يوجد' }}</td>
                      <td>{{ $bank->bank_account_number ?? $item->installment->client->ipan }}</td>

                      @php
                              $phone = DB::table('client_phones')->where('client_id', $item->installment->client->id)->first();

                              @endphp
                      <td>{{$phone->phone}}</td>
                      </tr>
                      
                      @endif
                      @endforeach

                    </tbody>
                  </table>
                </div>
                      
            <div class="col-12 mx-5 py-1 d-flex justify-content-between">
                <h6> :User name  </h6><br>  {{ Auth::user()->name_ar ?? 'Guest' }}</h6>
                <h6> : Date  </h6><br> {{ now()->format('Y-m-d') }}</h6>
            </div>

            </div>

        </div>
        </div>
   
        <script src="{{asset('assets/js/vendor.min.js')}}"></script>
<!-- Import Js Files -->
<script src="{{asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/libs/simplebar/dist/simplebar.min.js')}}"></script>
<script src="{{asset('assets/js/theme/app.horizontal.init.js')}}"></script>
<script src="{{asset('assets/js/theme/theme.js')}}"></script>
<script src="{{asset('assets/js/theme/app.min.js')}}"></script>
<script src="{{asset('assets/js/theme/sidebarmenu.js')}}"></script>
<script src="{{asset('assets/js/theme/sidebarmenu.js')}}"></script>
<script src="{{asset('assets/js/theme/feather.min.js')}}"></script>

<!-- solar icons -->
<script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
<script src="{{asset('assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/js/datatable/datatable.init.js')}}"></script>
</body>

</html>