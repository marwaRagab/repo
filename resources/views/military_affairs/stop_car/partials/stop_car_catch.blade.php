<div id="convert_command-{{ $item->id }}" class="modal fade convert_command" tabindex="-1"
    aria-labelledby="bs-example-modal-md" aria-hidden="true">
   <div class="modal-dialog modal-dialog-scrollable modal-lg">
       <div class="modal-content">
           <form class="mega-vertical" action="{{ route('stop_car_convert', $item->id) }}"
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
                    <div class="form-group">
                        <label class="form-label" for="input1 ">
                            تاريخ </label>
                        <input type="date" name="date" class="form-control mb-2"
                            id="input1">
                        @error('date')
                        <div style='color:red'>{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="formFile" class="form-label">
                            صورة الكتاب </label>
                        <input class="form-control" name="img_dir" accept="image/*"
                            type="file" id="formFile" />
                        @error('img_dir')
                        <div style='color:red'>{{$message}}</div>
                        @enderror
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
