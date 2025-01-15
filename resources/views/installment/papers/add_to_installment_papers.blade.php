
            <div class="card">
                <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
                    <h4 class="card-title mb-0">إضافة صورة الإعتماد</h4>
                </div>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <h6>{{ $installment->client->name_ar }} ({{ $installment->client->civil_number }})</h6>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cinet_img" class="control-label">صورة نموذج استلام المعاملة</label>
                                    <a target="_blank" class="label-info label" href="{{ url('installment/papers/recieve_install_paper/' . $installment->id) }}">
                                        نموذج الاستلام
                                    </a>
                                    <input type="file" name="cinet_img" class="form-control" />
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="paper_received_note" class="control-label">الملاحظة</label>
                                    <textarea name="paper_received_note" class="form-control"></textarea>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="received_user_id" class="control-label">الموظف المستلم</label>
                                    <select name="received_user_id" class="form-control">
                                        @foreach ($admins as $admin)
                                            <option value="{{ $admin->id }}">{{ $admin->name }} {{ $admin->lname }}</option>
                                        @endforeach
                                    </select>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="hidden" name="HTTP_REFERER" value="{{ url()->previous() }}">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>



                        </div>
                    </form>
                </div>
            </div>
                <div class="form-group" style="text-align: center;">
                    <button type="submit" name="btn_upload" class="btn btn-success">تسليم المعاملة</button>
                </div>
