<?php echo view('application_top'); ?>

                <div class="container-fluid">
                    <div class="row bg-title">

                        <!-- .breadcrumb -->
                        <div class="col-lg-12 col-sm-8 col-md-8 col-xs-12">
                            <ol class="breadcrumb">
                                <li><a href="<?=base_url('webadmin/dashboard')?>">الرئيسية</a></li>
                                 <li><a href="#"><?php echo $title ?></a></li>
                                <li class="active">

                                <?php echo $title ?></li>
                            </ol>

                            <a href="javascript:history.back(-1);"
                              class="btn btn-danger pull-right m-l-20 btn-rounded btn-outline hidden-xs hidden-sm waves-effect waves-light">
                               عودة
                            </a>
                        </div>
                        <!-- /.breadcrumb -->
                    </div>
                    <!-- .row -->
                    <div class="row">
       <form data-toggle="validator" enctype="multipart/form-data" method="POST" >
        <div class="col-sm-12">
            <div class="white-box" style="min-height: 700px;">
            <h5 class=" ">

            <?php echo $title ?></h5>





                <div class="form-group" style="padding-bottom: 20px;border-bottom: 1px solid #000;">
                <label for="delegate_email" class="control-label">

                    <a href="<?php echo base_url() ?>installment/invoices_installment/export_all" target="_blank" class="label label-success font-weight-100 " >      طباعة تصدير الحسابات    </a>
                </label>

                <div class="help-block with-errors"> </div>
              </div>

              <div class="form-group" style="padding-bottom: 20px;border-bottom: 1px solid #000;">
                <label for="delegate_email" class="control-label">    صورة
               تصدير الحسابات
                </label>
                    <input type="file" id="input-file-now"  required name="payment_file_dir" data-error="من فضلك أختار الملف" class="dropify" />
                <div class="help-block with-errors"> </div>
              </div>

              <div class="form-group">

                  <button type="submit" name="get_bt" class="btn btn-primary">حفظ</button>

              </div>
          </div>
        </div>

           </form>
                    </div>
                    <!-- /.row -->

                    <!-- /.right-sidebar -->
                </div>

<?php echo view('admin/footer'); ?>