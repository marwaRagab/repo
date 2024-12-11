<div class="card">
                        <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
                            <h4 class="card-title mb-0"> استعلام عمل ( {{$Military->installment->client->name_ar}} - {{$Military->installment->client->civil_number}})
                            </h4>
                            <a class="btn me-1 mb-1 bg-success-subtle text-success px-4 fs-4 "
                                href="{{ route('stop_bank.archive') }}">
                               عودة</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive pb-4">
                            <form action="{{ route('stop_bank.save_jobs_info') }}" method="POST">
                            @csrf
                                <table id="all-student" class="table table-bordered border text-nowrap align-middle">
                                    <thead>
                                        <!-- start row -->
                                        <tr>
                                            <th>#</th>
                                            <th>الوزارة</th>
                                            <th>نعم</th>
                                            <th> لا</th>
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
                                            {{$item['name']}}
                                            </td>
                                            <td>
                                            <input type="hidden" name="banks[{{ $item['id'] }}][military_affairs_id]" value="{{$Military->id}}"> 
                                            <input type="hidden" name="banks[{{ $item['id'] }}][ministry_id]" value="{{$item['id']}}">

                                                <input type="radio" name="banks[{{ $item['id'] }}][found]" value="1" > نعم
                                            </td>
                                            <td> <input type="radio" name="banks[{{ $item['id'] }}][found]" value="0" > لا
                                            </td>
                                            <td> <textarea class="form-control" name="banks[{{ $item['id'] }}][note]" rows="5"></textarea>

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