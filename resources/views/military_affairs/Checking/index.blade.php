@php
    use Illuminate\Support\Facades\Request;if(Request::has('checking_type')){
        $type=Request::get('checking_type');
    }else{
       $type='';
    }

@endphp
<div class="card mt-4 py-3">
    <div class="d-flex flex-wrap ">
        <a  href="{{route('checking')}}"  class="btn-filter bg-warning-subtle text-warning px-2  mx-1 mb-2">
            التدقيق </a>
        <a   href="{{route('checking',array('checking_type' =>'actions_up'))}}"    class="btn-filter  bg-success-subtle text-success px-2  mx-1 mb-2">
            رفع الإجراءات </a>
        <a  href="{{route('checking',array('checking_type' =>'all_reminders'))}}"  class="btn-filter  bg-success-subtle text-success px-2  mx-1 mb-2">
            مبالغ مسترجعة</a>

        <a    href="{{route('checking',array('checking_type' =>'archive'))}}" class="btn-filter bg-danger-subtle text-danger px-2  mx-1 mb-2">
            الأرشيف </a>
    </div>
</div>
<div class="card">
    <div class="d-flex align-items-center justify-content-between px-2 py-3 border-bottom">
        <h4 class="card-title mb-0"> رفع الإجراءات</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive pb-4">
            <table id="all-student" class="table table-bordered border text-nowrap align-middle">
                <thead>
                <!-- start row -->
                <tr>
                    <th>#</th>


                    <th> اسم العميل</th>
                    <th> الرقم الالي
                    </th>
                    <th>مبلغ المديونية</th>
                    @if(Request::has('checking_type') && Request::get('checking_type') !='archive' )

                    <th> المحصل</th>
                    @endif
                    @if(!Request::has('checking_type'))
                        <th> المتبقى للعميل</th>

                        <th> رفع الإجراءات</th>

                    @endif
                    @if(Request::has('checking_type') && Request::get('checking_type') =='actions_up' )

                        <th>  تحويل اللارشيف</th>

                    @endif
                    @if(Request::has('checking_type') && Request::get('checking_type') =='all_reminders' )
                        <th> المتبقى للعميل</th>
                        <th>  تحويل اللارشيف</th>

                    @endif




                </tr>
                <!-- end row -->
                </thead>
                <tbody>
                <!-- start row -->

                @foreach($items as $item)
                    <tr data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false"
                        aria-controls="collapseExample">
                        <td>
                            {{ $loop->index + 1 }}

                        </td>
                        <td>
                            {{$item->installment->client->name_ar}}
                            <br>
                            ({{$item->installment->id}})
                            <br>
                            {{$item->installment->client->civil_number}}
                        </td>
                        <td>{{$item->issue_id}}</td>
                        <td>{{$item->madionia_amount}}</td>

                        @if(Request::has('checking_type') && Request::get('checking_type') !='archive' )

                            <td> المحصل</td>

                        @endif
                        @if(!Request::has('checking_type'))
                            <td> {{$item->reminder_amount}} </td>

                            <td>

                                <button class="btn btn-success me-6" data-bs-toggle="modal" data-bs-target="#remove_action_modal-{{$item->id}}">
                                    رفع الإجراءات
                                </button>

                                <div id="remove_action_modal-{{$item->id}}" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                        <div class="modal-content">
                                            <form class="mega-vertical"
                                                  action="{{url('update_actions_up')}}" method="post"
                                                  enctype="multipart/form-data">
                                                @csrf
                                            <div class="modal-header d-flex align-items-center">
                                                <h4 class="modal-title" id="myModalLabel">
                                                    التدقيق </h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <h6>التدقيق
                                                </h6>

                                                    <div class="form-row">
                                                        <div class="form-group">
                                                            <label for="formFile" class="form-label">صورة</label>
                                                            <input class="form-control" name="img_dir" accept="image/*" type="file" id="formFile" />
                                                            @error('img_dir')
                                                            <div style='color:red'>{{$message}}</div>
                                                            @enderror
                                                        </div>
                                                        <input  type="hidden" name="military_affairs_id"  value="{{$item->id}}" >
                                                        <div class="form-group">
                                                            <label for="date" class="form-label">صورة</label>
                                                            <input class="form-control" type="date" name="date" id="date" />
                                                            @error('date')
                                                            <div style='color:red'>{{$message}}</div>
                                                            @enderror
                                                        </div>
                                                    </div>

                                            </div>
                                            <div class="modal-footer d-flex ">
                                                <button type="submit" class="btn btn-primary">رفع الاجراء</button>
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

                            </td>


                        @endif
                        @if(Request::has('checking_type') && Request::get('checking_type') =='actions_up' )

                            <td>

                                <button class="btn btn-success me-6" data-bs-toggle="modal" data-bs-target="#archive_modal-{{$item->id}}">
                                 تحويل للارشيف
                                </button>

                                <div id="archive_modal-{{$item->id}}" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                        <div class="modal-content">
                                            <form class="mega-vertical"
                                                  action="{{url('update_actions_up')}}" method="post"
                                                  enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-header d-flex align-items-center">
                                                    <h4 class="modal-title" id="myModalLabel">
                                                        التدقيق </h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <h6>التدقيق
                                                    </h6>

                                                    <div class="form-row">
                                                        <div class="form-group">
                                                            <label for="formFile" class="form-label">صورة</label>
                                                            <input class="form-control" name="img_dir" accept="image/*" type="file" id="formFile" />
                                                            @error('img_dir')
                                                            <div style='color:red'>{{$message}}</div>
                                                            @enderror
                                                        </div>
                                                        <input  type="hidden" name="military_affairs_id"  value="{{$item->id}}" >
                                                        <input  type="hidden" name="convert_type"  value="archived" >
                                                        <div class="form-group">
                                                            <label for="date" class="form-label">صورة</label>
                                                            <input class="form-control" type="date" name="date" id="date" />
                                                            @error('date')
                                                            <div style='color:red'>{{$message}}</div>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="modal-footer d-flex ">
                                                    <button type="submit" class="btn btn-primary">رفع الاجراء</button>
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

                            </td>

                        @endif
                        @if(Request::has('checking_type') && Request::get('checking_type') =='all_reminders' )
                            <td> {{$item->reminder_amount}} </td>
                            <td>

                                <button class="btn btn-success me-6" data-bs-toggle="modal" data-bs-target="#reminder_amount-{{$item->id}}">
                                    تحويل اللارشيف تسليم
                                </button>

                                <div id="reminder_amount-{{$item->id}}" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                        <div class="modal-content">
                                            <form class="mega-vertical"
                                                  action="{{url('update_actions_reminder')}}" method="post"
                                                  enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-header d-flex align-items-center">
                                                    <h4 class="modal-title" id="myModalLabel">
                                                        التدقيق </h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body ">
                                                   <div class="d-flex justify-content-between">
                                                   <h6>التدقيق
                                                    </h6>
                                                    <a class="btn btn-success me-6"  href="" >
                                                        طباعة
                                                    </a>
                                                   </div>

                                                    <div class="form-row">
                                                        <div class="form-group">
                                                            <label for="formFile" class="form-label">صورة</label>
                                                            <input class="form-control" name="reminder_img_dir" accept="image/*" type="file" id="formFile" />
                                                            @error('reminder_img_dir')
                                                            <div style='color:red'>{{$message}}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="formFile" class="form-label">صورة</label>
                                                            <input class="form-control" name="archived_img_dir" accept="image/*" type="file" id="formFile" />
                                                            @error('archived_img_dir')
                                                            <div style='color:red'>{{$message}}</div>
                                                            @enderror
                                                        </div>
                                                        <input  type="hidden" name="military_affairs_id"  value="{{$item->id}}" >
                                                        <input  type="hidden" name="installment_id"  value="{{$item->installment->id}}" >
                                                        <input  type="hidden" name="client_id"  value="{{$item->installment->client->id}}" >
                                                        <div class="form-group">
                                                            <label for="date" class="form-label">صورة</label>
                                                            <input class="form-control" type="date" name="date" id="date" />
                                                            @error('date')
                                                            <div style='color:red'>{{$message}}</div>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="modal-footer d-flex ">
                                                    <button type="submit" class="btn btn-primary">رفع الاجراء</button>
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


                            </td>

                        @endif

                    </tr>



                @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>
