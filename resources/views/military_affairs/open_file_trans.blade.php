
<div class="container-fluid">
    <div class="row bg-title">

        <!-- .breadcrumb -->
        <div class="col-lg-12 col-sm-8 col-md-8 col-xs-12">



                <a href="javascript:history.back(-1);" class="btn btn-danger pull-right m-l-20 btn-rounded btn-outline hidden-xs hidden-sm waves-effect waves-light">
                عودة
            </a>
        </div>
        <!-- /.breadcrumb -->
    </div>


    <!-- .row -->
    <div class="row">
        <div class="col-md-12">
            <?php
            if (session()->has('error') || session()->has('success')) {
                ?>
            <div class="alert <?php echo (session()->getFlashdata('success') ? 'alert-success' : ' alert-danger') ?>">
                <a class="close" data-dismiss="alert">×</a>
                    <?php echo (session()->getFlashdata('success') ? session()->getFlashdata('success') : ''); ?>
                    <?php echo (session()->getFlashdata('error') ? session()->getFlashdata('error') : ''); ?>
            </div>
                <?php
            }
            ?>
        </div>

        <form class="mega-vertical" action="{{url('to_ex_alert')}}" method="post"
              enctype="multipart/form-data">
            @csrf
            <div class="col-sm-12">
                <div class="white-box">

                    <input type="hidden"  name="military_affairs_id" value="{{$item_law->id}}">
                    <input type="hidden"  name="id_time_type_old" value="{{$item_type_time->id}}">
                    <input type="hidden"  name="id_time_type_new" value="{{$item_type_time_new->id}}">
                    <input type="hidden"  name="type" value="{{$item_type_time->type}}">
                    <input type="hidden"  name="type_id" value="{{$item_type_time->id}}">

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="civil_id" class="control-label"> الرقم الآلي للقضية</label>
                            <input type="text" class="form-control" value="{{old('issue_id')}}" id="issue_id" name="issue_id"  data-error="هذا الحقل مطلوب">
                            <?php if (session('errors') && isset(session('errors')['issue_id'])) { ?>
                            <div class="help-block with-errors">
                                    <?= session('errors')['issue_id']; ?>
                            </div>
                            <?php } ?>

                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="media-body">
                            <div class="mb-3 row">
                                <label class="col-sm-12 col-form-label"> المؤهل الدراسي</label>
                                <div class="col-sm-9">
                                    <select name='place' class="form-select"
                                            aria-label="Default select example">
                                        <option value=''>اختر الموهل</option>
                                        @foreach($governorates as $governorate)
                                            <option
                                                value='{{$governorate->id}}' {{$item_law->place==$governorate->id?'selected':''}}>{{$governorate->name_ar}}</option>
                                        @endforeach
                                    </select>
                                    @error('place')
                                    <div style='color:red'>{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>





                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="civil_id" class="control-label"> تاريخ فتح الملف </label>
                            <input type='date' class="form-control " required="" name="date" value="<?= old('open_file_date'); ?>" placeholder="yyyy/mm/dd" data-date-format="yyyy/mm/dd">
                            <?php if (session('errors') && isset(session('errors')['date'])) { ?>
                            <div class="help-block with-errors">
                                    <?= session('errors')['open_file_date']; ?>
                            </div>
                            <?php } ?>

                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div style=" display: none;" class="col-md-3">
                        <div class="form-group">
                            <label for="xxxx" class="control-label"> خاص بنا </label>
                            <input type="checkbox" class="form-control " style="width: 37px; margin-right: 50px;" name="our_law" value="1" />
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div style=" display: none;" class="col-md-3">
                        <div class="form-group">
                            <label for="xxxx" class="control-label"> ضبط واحضار </label>
                            <input type="checkbox" class="form-control " style="width: 37px; margin-right: 50px;" name="catch" value="1" />
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" style="margin-top: 25px;" name="btn_save" id="btn_save" class="btn btn-success">حفظ وتحويل لإعلان التنفيذ
                        </button>
                    </div>

                </div>
            </div>

        </form>
    </div>

    <!-- /.row -->

    <!-- /.right-sidebar -->
</div>





