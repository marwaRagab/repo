
@php 
$arr=['success','danger','primary','secondary','info','warning'];
//dd($governorates[2]);
@endphp
<div class="card mt-4 py-3">
  <div class="d-flex flex-wrap ">

    <a class="btn-filter bg-warning-subtle text-warning px-4 fs-4 mx-1 mb-2">
      العدد الكلي ({{ $count_total }})
    </a>

@for ($i=0;$i<count($governorates);$i++)

<a  href="{{ route('image',$governorates[$i]->id) }}" class="btn-filter  bg-{{ $arr[$i] }}-subtle text-{{ $arr[$i] }} px-4 fs-4 mx-1 mb-2">
  محكمة {{ $governorates[$i]->name_ar }} ({{ $count['counter_'.$governorates[$i]->id]}})
</a>
@endfor
    


   
  </div>
</div>
<div class="card">
  <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
      <h4 class="card-title mb-0">{{ $title }}</h4>
  </div>
<div class="card-body">
  
  <div class="table-responsive pb-4">
    <table id="all-student" class="table table-bordered border text-nowrap align-middle">
      <thead>
        <!-- start row -->
        <tr>
          <th>م</th>
                                <th >رقم المعاملة </th>
                                <th>اسم العميل </th>
                                <th>تاريخ البدء</th>
                                <th> المبلغ </th>
                                <th>تاريخ فتح الملف </th>
                                <th>الرقم الالي</th>
                                 <th>تاريخ النتيجه</th>
                                 <th>المحكمة</th>
                                 <th>نتيجه الاعلان</th>
                                 <th>إيداع الاعلان</th>
                                 <th>الاجراءات</th>


        </tr>
        <!-- end row -->
      </thead>
      <tbody>
       @php $i=1; @endphp
                  @foreach ($transactions as $one)
                      
                
                <!-- start row -->
  
                <tr>
            <td>{{$i}}</td>
                  <td><a href="#">{{$one->id}}</a></td>
                  <td>{{$one->name_ar}}<br/>{{ $one->civil_number }}<br/>{{ $one->phone_ids }}</td>
                  <td>{{$one->date}}</td>
                  <td>{{$one->eqrardain_amount}}</td>
                  <td>{{$one->open_file_date}}</td>
                  <td>{{$one->issue_id}}</td>
                  <td></td> <!-- هجيبه من الجلسات وانا بتيست-->
                  <td>{{$one->governorate_id}}</td>
                  <td>لا يوجد</td>
                  <td>  
                    <button class="btn btn-success me-6 my-2" data-bs-toggle="modal" data-bs-target="#add_a3lan">
                    ايداع الاعلان</button>

                  <div id="add_a3lan" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable modal-lg">
                      <div class="modal-content">
                        <div class="modal-header d-flex align-items-center">
                          <h4 class="modal-title" id="myModalLabel">
                            ايداع الاعلان</h4>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <form class="ps-3 pr-3" action="{{ route('image.to_a3lan_eda3') }}" method="POST" enctype="multipart/form-data">
                            @csrf 
                            <div class="form-row">
                              
                              <div class="form-group">
                                <div class="my-3">
                                  <label class="form-label">تاريخ ايداع الاعلان</label>
                                  <input class="form-control" name="jalsaat_alert_paper_date" type="date" />
                                  @error('jalsaat_alert_paper_date')
                                  <div class="alert alert-danger">{{ $message }}</div>
                                     @enderror
                                  <input class="form-control" type="text" style="display:none;" name="installment_id" value="12">

                                </div>
                              </div>
                            </div>
                          </form>
                        </div>
                        <div class="modal-footer d-flex ">
                          <button type="submit" class="btn btn-primary"> حفظ</button>
                          <button type="button" class="btn bg-danger-subtle text-danger  waves-effect" data-bs-dismiss="modal">
                            الغاء
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                 
</td>
                  <div class="btn-group dropup mb-6 me-6 d-block ">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                      data-bs-toggle="dropdown" aria-expanded="false">
                      الإجراءات
                    </button>
                    <ul class="dropdown-menu rounded-0" aria-labelledby="dropdownMenuButton">
                      <li>
                        <a class="btn btn-warning rounded-0 w-100 mt-2" data-bs-toggle="modal"
                          data-bs-target="#notes">
                          الملاحظات</a>
                      </li>
                      <li>
                        <a class="btn btn-primary rounded-0 w-100 mt-2" href="#">
                          التفاصيل</a>
                          <li>
                            <a class="btn btn-info rounded-0 w-100 mt-2" 
                             href="{{ route('image.athbat_7ala/'.$one->id) }}">طباعة كتاب اثبات
                            </a>
                          </li>
                      <li style="display:none">
                        <a class="btn btn-success rounded-0 w-100 mt-2" data-bs-toggle="modal"
                          data-bs-target="#open-file">الصورة
                        </a>
                      </li>
                    
                    
                    </ul>


                  </div>
                 
                  <div class="btn-group dropup mb-6 me-6 d-block ">
                    <button class="btn btn-danger dropdown-toggle" type="button" id="dropdownMenuButton"
                      data-bs-toggle="dropdown" aria-expanded="false">
                      طباعة
                    </button>
                    <ul class="dropdown-menu rounded-0" aria-labelledby="dropdownMenuButton">
                      <li>
                        <a class="btn btn-warning rounded-0 w-100 mt-2" href="#">
                          اثبات حالة</a>
                      </li>
                      <li>
                        <a class="btn btn-primary rounded-0 w-100 mt-2" href="#">
                          ستيكر ملف التنفيذ</a>
                        
                      <li>
                        <a class="btn btn-success rounded-0 w-100 mt-2" href="#">البطاقة المدنية
                        </a>
                      </li>
                      <li>
                        <a class="btn btn-info rounded-0 w-100 mt-2" 
                         href="#">  اقرار الدين
                        </a>
                      </li>
                     
                   
                    </ul>


                  </div>

                     
                      <!-- sample modal content -->
                      <div id="notes_{{ $one->id }}" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md"
                      aria-hidden="true">
                     <form class="mega-vertical"
                           action="{{url('add_notes')}}" method="post"
                           enctype="multipart/form-data">
                         @csrf
                         <div class="modal-dialog modal-dialog-scrollable modal-lg">
                             <div class="modal-content">
                                 <div class="modal-header d-flex align-items-center">
                                     <h4 class="modal-title" id="myModalLabel">
                                         اضافة ملاحظة </h4>
                                     <button type="button" class="btn-close" data-bs-dismiss="modal"
                                             aria-label="Close"></button>
                                 </div>
                                 <div class="modal-body">

                                  
                                     <div class="form-row">
                                         <div class="form-group">
                                             <label class="form-label"> الجهة</label>
                                             <select class="form-select" name="notes_type">
                                                 <option
                                                     value="answered">
                                                     رد
                                                 </option>
                                                 <option
                                                     value="refused">
                                                     لم يرد
                                                 </option>
                                                 <option
                                                     value="note">
                                                     ملاحظة
                                                 </option>


                                             </select>
                                         </div>
                                         <div class="form-group">
                                             <label class="form-label" for="input1 ">
                                                 الملاحظة </label>
                                             <textarea name="note" class="form-control mb-2">

                                             </textarea>
                                             <input type="text"  name="note" value="{{ $one->id }}"class="form-control mb-2" style="display:none;"/>
                                         </div>


                                     </div>

                                 </div>
                                 <div class="modal-footer d-flex ">
                                     <button type="submit" class="btn btn-primary">
                                         حفظ
                                     </button>
                                     <button type="button"
                                             class="btn bg-danger-subtle text-danger  waves-effect"
                                             data-bs-dismiss="modal">
                                         الغاء
                                     </button>
                                 </div>
                             </div>
                             <!-- /.modal-content -->
                         </div>
                     </form>
                     <!-- /.modal-dialog -->
                 </div>

                  
                </tr>
                <!-- end row -->
          
          @php $i++; @endphp
                @endforeach
      </tbody>  
    </table>

  </div>

</div>
</div>