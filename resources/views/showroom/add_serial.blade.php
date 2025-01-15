<!--<div class="card mt-4 py-3">
     <div class="d-flex flex-wrap ">
        <a class=" btn-filter me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4 mx-1 mb-2 "
            href="./recieve-product-archieve.html">
            الارشيف
        </a>
    </div> 
</div>-->
<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0"> استلام </h4>
    </div>
    <div class="card-body">
        <form action="{{ route('showroom.addSerial',$id) }}" method="POST" enctype="multipart/form-data">
            <input class="form-control" type="text" style="display:none;" name="order_id" value="{{ $id }}">
            @csrf
            <div class="table-responsive pb-4">
                <table id="file-export" class="table w-100 table-bordered display text-nowrap">
                    <thead>
                        <!-- start row -->
                        <tr>
                            <th>م</th>
                            <th> الماركة</th>
                            <th> الصنف</th>
                            <th> الموديل</th>
                            <th> السريال</th>
                            <th> الصورة</th>
                        </tr>
                        <!-- end row -->
                    </thead>
                    <tbody>
                        <!-- start row -->
                        @foreach ($new_items as $item)
                        {{ $item->id}}
                        <tr>
                            <td> {{ $loop->index + 1 }} </td>
                            <td> {{ $item->product->mark->name_ar }}</td>
                            <td>
                                {{ $item->product->class->name_ar }} <br>
                            </td>
                            <td>
                                {{$item->product->model }}<br>
                            </td>
                            <td>
                                <input type="text" class="form-control" name="serial_number_{{$item->id}}"
                                    id="serial_number_{{$item->id}}">
                                @error('serial_number_{{$item->id}}')
                                <div style='color:red'>{{$message}}</div>
                                @enderror
                            </td>
                            <td><input type="file" name="serial_number_img_{{ $item->id}}" class="form-control" /></td>

                        </tr>
                        @endforeach

                    </tbody>

                </table>

            </div>
            <button type="submit" class="btn btn-primary">حفظ </button>
        </form>
    </div>
</div>