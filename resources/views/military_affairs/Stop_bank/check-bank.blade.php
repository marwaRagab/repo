<div class="card">
                        <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
                            <h4 class="card-title mb-0"> استعلام بالبنوك ( سلوي حمد سليمان الدوسري - 277011100033)
                            </h4>
                            <a class="btn me-1 mb-1 bg-success-subtle text-success px-4 fs-4 "
                                href="{{ route('stop_bank.archive') }}">
                                عودة</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive pb-4">
                                <table id="all-student" class="table table-bordered border text-nowrap align-middle">
                                    <thead>
                                        <!-- start row -->
                                        <tr>
                                            <th>#</th>
                                            <th>البنك</th>
                                            <th>يوجد</th>
                                            <th> لا يوجد</th>
                                            <th> ملاحظة </th>


                                        </tr>
                                        <!-- end row -->
                                    </thead>
                                    <tbody>
                                        <!-- start row -->
                                        <tr>
                                            <td>
                                                1
                                            </td>
                                            <td>
                                                تقى
                                            </td>
                                            <td> <input type="radio" name="option" value="option1"
                                                    onclick="showInput()"> يوجد
                                                <div id="inputField" class="form-group hidden mt-3">
                                                    <select class="form-select form-control " id="input1" name="input1">
                                                        <option>يعمل راتب</option>
                                                        <option>موقوف راتب </option>
                                                        <option>فيزا</option>
                                                        <option>لا يوجد حساب</option>
                                                        <option>يعمل بدل ايجار</option>
                                                        <option>حساب مغلق</option>
                                                        <option>يوجد مبلغ بالحساب</option>
                                                    </select>
                                                </div>
                                            </td>
                                            <td> <input type="radio" name="option" value="option2"
                                                    onclick="hideInput()"> لا يوجد

                                            </td>
                                            <td> <textarea class="form-control" rows="5"></textarea>

                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <button class="btn btn-success" type="submit">حفظ</button>
                            </div>
                        </div>
                    </div>