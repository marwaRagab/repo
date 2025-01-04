<div class="card">
                        <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
                            <h4 class="card-title mb-0"> استعلام بالبنوك ( {{$Military->installment->client->name_ar}} - {{$Military->installment->client->civil_number}})
                            </h4>
                            <a class="btn me-1 mb-1 bg-success-subtle text-success px-4  "
                                href="{{ route('stop_bank.archive') }}">
                                عودة</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive pb-4">
                            <form action="{{ route('stop_bank.save_banks_info') }}" method="POST">
                            @csrf
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
                                        @foreach($items as $item)
                                        <tr>
                                            <td>
                                            {{ $loop->index + 1 }}
                                            </td>
                                            <td>
                                            {{$item->name_ar}}
                                            </td>
                                            <td> 
                                            <input type="hidden" name="banks[{{ $item->id }}][military_affairs_id]" value="{{$Military->id}}">
                                            <input type="hidden" name="banks[{{ $item->id }}][bank_id]" value="{{$item->id}}">
                                            <input type="radio" name="banks[{{ $item->id }}][found]" value="1" 
                                                    onclick="showInput('{{ $item->id }}')"> يوجد

                                                <!-- Dropdown for bank status -->
                                                <div id="inputField{{ $item->id }}" class="form-group hidden mt-3">
                                                    <select class="form-select form-control" id="input1" 
                                                            name="banks[{{ $item->id }}][bank_status]">
                                                        <option value="0">اختر الحالة</option>
                                                        <option value="stopped">موقوف راتب</option>
                                                        <option value="visa">فيزا</option>
                                                        <option value="wrong_bank">لا يوجد حساب</option>
                                                        <option value="housing">يعمل بدل ايجار</option>
                                                        <option value="account_closed">حساب مغلق</option>
                                                        <option value="money_found">يوجد مبلغ بالحساب</option>
                                                    </select>
                                                </div>
                                            </td>
                                            <td> <input type="radio" name="banks[{{ $item->id }}][found]" value="0" 
                                            onclick="hideInput('{{ $item->id }}')"> لا يوجد

                                            </td>
                                            <td> <textarea class="form-control" name="banks[{{ $item->id }}][note]" rows="5"></textarea>

                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <button class="btn btn-success" type="submit">حفظ</button>
                                </form>
                            </div>
                        </div>
                    </div>


<script>
    function showInput(id) {
    document.getElementById('inputField' + id).classList.remove('hidden');
}

function hideInput(id) {
    document.getElementById('inputField' + id).classList.add('hidden');
}
</script>