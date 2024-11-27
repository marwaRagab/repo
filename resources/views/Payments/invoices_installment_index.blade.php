<div class="card mt-4 py-3">
    @if(session()->has('message'))
        <p class="alert alert-success"> {{ session()->get('message') }}</p>
    @endif
    <div class="d-flex flex-wrap ">
        <a class=" btn-filter me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4 mx-1 mb-2 ">
            @php
                $all_amounts= json_decode(all_invoices_by_date_sql2(''),true) ;


            @endphp
            المتوفر


            {{$all_amounts['total_balance']}}
        </a>
        <a class="btn-filter bg-info-subtle text-info  px-4 fs-4 mx-1 mb-2">
            الكاش ( {{$all_amounts['cash']}})
        </a>
        <a class="btn-filter bg-warning-subtle text-warning px-4 fs-4 mx-1 mb-2">
            الكى نت ( {{$all_amounts['knet']}})
        </a>
        <a class="btn-filter  bg-success-subtle text-success px-4 fs-4 mx-1 mb-2">
            الدفع الالكترونى ({{$central_bank ? $central_bank->part : 0.000 }})
        </a>

    </div>
</div>
<div class="card mt-4 py-3">
    <div class="d-flex flex-wrap ">
        <a href="{{route('invoices_installment')}}"
           class="btn-filter bg-warning-subtle text-warning px-4 fs-4 mx-1 mb-2">
            الكل </a>
        <a href="{{route('invoices_installment',array('payment_type' =>'cash'))}}"
           class="btn-filter  bg-success-subtle text-success px-4 fs-4 mx-1 mb-2">
            كاش </a>
        <a href="{{route('invoices_installment',array('payment_type' =>'knet'))}}"
           class="btn-filter  bg-success-subtle text-success px-4 fs-4 mx-1 mb-2">
            كى نت </a>

        <a href="{{route('invoices_installment',array('payment_type' =>'part'))}}"
           class="btn-filter bg-danger-subtle text-danger px-4 fs-4 mx-1 mb-2">
            الدفع الالكترونى </a>
    </div>
</div>
<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0">عملاء الاقساط</h4>
        <div class="d-flex">


            <button class="btn me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4" data-bs-toggle="modal" data-bs-target="#expoert_modal">
                تصدير
            </button>

            <div id="expoert_modal" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-lg">
                    <div class="modal-content">
                        <form class="mega-vertical"
                              action="{{url('get_invoices_papers')}}" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="modal-header d-flex align-items-center">
                                <h4 class="modal-title" id="myModalLabel">
                                   التصدير  </h4>
                            </div>
                            <div class="modal-body">
                                <a class="btn me-1 mb-1 bg-emerald-900-subtle text-primary px-4 fs-4 "
                                   href="{{url('export_all')}}">
                                    طباعة تصدير الحسابات </a>

                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="formFile" class="form-label">صورة تصدير الحسابات</label>
                                        <input class="form-control" name="img_dir" accept="image/*" type="file" id="formFile" />
                                        @error('img_dir')
                                        <div style='color:red'>{{$message}}</div>
                                        @enderror
                                    </div>

                                </div>

                            </div>
                            <div class="modal-footer d-flex ">
                                <button type="submit" class="btn btn-primary"> حفظ</button>
                                <button type="button" class="btn bg-danger-subtle text-danger  waves-effect" data-bs-dismiss="modal">
                                    الغاء
                                </button>
                            </div>
                        </form>
                    </div>
                    <!-- /.modal-content -->
                </div>

                <!-- /.modal-dialog -->
            </div>






        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive pb-4">
            <table id="all-student" class="table table-bordered border text-nowrap align-middle">
                <thead>
                <!-- start row -->
                <tr>
                    <th>#</th>

                    <th>اسم العميل</th>
                    <th>الرصيد</th>
                    <th>دائن</th>
                    <th>مدين</th>
                    <th> التفاصيل</th>
                    <th> التاريخ</th>
                </tr>
                <!-- end row -->
                </thead>
                <tbody>
                <!-- start row -->
                @php
                    $total_balance=$all_amounts['total_balance'];
                @endphp
                @foreach($items as $item)
                    <tr>
                        <td>
                            {{$loop->index+1}}
                        </td>
                        @if($item->installment)
                            <td>
                                {{$item->installment->client->name_ar}}
                            </td>
                        @else
                            <td>
                                تصدير
                            </td>
                        @endif
                        <td>
                            @if($item->type=='export')
                                <span class="text-danger"> 0.000</span>
                            @else
                                <span class="text-danger">{{$all_amounts['total_balance']}} </span>
                            @endif

                            @if($item->debtor==1)
                                @php
                                    $total_balance = $total_balance -  $item->amount;
                                if ($total_balance == 0) {
                                    $total_balance = $all_amounts['total_balance'];
                            } else {
                                $total_balance = $total_balance + $item->amount;
                                  }

                                @endphp

                            @endif
                        </td>
                        <td>
                            @if($item->debtor==1)
                                <span class="text-danger">{{$item->amount}}</span>
                            @else
                                <span class="text-danger"> -</span>
                            @endif

                        </td>
                        <td>
                            @if($item->creditor==1)
                                <span class="text-danger">{{$item->amount}}</span>
                            @else
                                <span class="text-danger"> -</span>
                            @endif

                        </td>
                        <td>
                            <p> {{$item->description}}</p>
                            <p> طريقة الدفع:</p>
                            {{$item->pay_method}}

                        </td>
                        <td>
                            {{$item->date}}
                        </td>


                    </tr>
                @endforeach


                </tbody>
            </table>
        </div>
    </div>
</div>
