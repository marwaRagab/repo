<div class="card">
                        <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
                            <h4 class="card-title mb-0"> عدد الملاحظات</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive pb-4">
                                <table id="all"
                                    class="table table-bordered table-striped border text-nowrap align-middle">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>م</th>
                                            <th>الملاحظة</th>
                                            <th>التاريخ</th>
                                            <th>القسم</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($data['delegates'] as $item)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{$item->note}}</td>
                                            <td>{{$item->date}}</td>
                                            <td>-</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>