<div id="convert_command-{{ $item->id }}" class="modal fade convert_command" tabindex="-1"
    aria-labelledby="bs-example-modal-md" aria-hidden="true">
   <div class="modal-dialog modal-dialog-scrollable modal-lg">
       <div class="modal-content">
           <form class="mega-vertical" action="{{ route('info_update', $item->id) }}"
                 method="post" enctype="multipart/form-data">
               @csrf
               <input type="hidden" name="military_affairs_id" value="{{ $item->id }}">
               <input type="hidden" name="type" value="{{ $item_type_time1->type }}">
               <input type="hidden" name="type_id" value="{{ request()->get('stop_car_type') }}">
               <input type="hidden" name="item_type_new" value="{{ request()->get('stop_car_type') }}">
               <input type="hidden" name="item_type_old" value="{{ request()->get('stop_car_type') }}">

               <div class="modal-header d-flex align-items-center">
                   <h4 class="modal-title" id="myModalLabel">
                       {{ $col_name }} (    {{ $item->installment->client->name_ar ?? '' }} )</h4>
                   <button type="button" class="btn-close" data-bs-dismiss="modal"
                           aria-label="Close"></button>
               </div>
               <div class="modal-body">
                   <div class="form-row">

                    <div class="form-group col-12">
                        <div class="form-check-inline">
                            <input type="radio" name="have_cars" id="have_cars" value="1" onclick="checkCheck2(1)" checked>
                            <label for="exist">يوجد</label>
                        </div>
                        <div class="form-check-inline">
                            <input type="radio" name="have_cars" id="have_cars" value="0"  onclick="checkCheck2(0)">
                            <label for="status_close">لا يوجد</label>
                        </div>
                    </div>





                       <div class="form-group">
                           <label for="formFile" class="form-label">
                               صورة أمر الحجز مختوم </label>
                           <input class="form-control" name="img_dir_1" accept="image/*" type="file"
                                  id="formFile"/>
                           @error('img_dir_1')
                           <div style='color:red'>{{ $message }}</div>
                           @enderror
                       </div>
                       <div id="mydiv567" style="display: block;" class="form-group">

                       <div class="form-group">
                        <label for="formFile" class="form-label">
                            صورة البرنت </label>
                        <input class="form-control" name="img_dir_2" accept="image/*" type="file"
                               id="formFile"/>
                        @error('img_dir_2')
                        <div style='color:red'>{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-12">
                        <label class="form-label" for="input1 ">
                               عدد السيارات </label>

                           <input type="text" name="stop_car_car_num" class="form-control mb-2" id="input1">
                           @error('stop_car_car_num')
                           <div style='color:red'>{{ $message }}</div>
                           @enderror
                       </div>

                    </div>

                   </div>
               </div>
               <div class="modal-footer d-flex ">
                   <button type="submit" class="btn btn-primary">حفظ</button>
                   <button type="button"
                           class="btn bg-danger-subtle text-danger waves-effect"
                           data-bs-dismiss="modal">
                       الغاء
                   </button>
               </div>
           </form>
       </div>
   </div>
</div>
<script>
    function checkCheck2(val) {
        var myDiv = document.getElementById("mydiv567");
        myDiv.style.display = (val == 1) ? "block" : "none";
    }
</script>
