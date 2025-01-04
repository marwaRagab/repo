<div class="card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <h4 class="card-title mb-0"> المسئولين
        </h4>
        <a class="btn me-1 mb-1 bg-primary-subtle text-primary px-4 "
            href="{{ route('military_affairs.delegates.get_statistics') }}">
            الإحصائيات </a>
    </div>
    <div class="card-body">
        <div class="table-responsive pb-4">
            <table class="table table-bordered table-striped text-center  ">
                <thead class="thead-dark">
                    <tr>
                        <th>اسم المسئول</th>
                        <th>الحالة</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $item->name_ar }}</td>
                            @if ($item->set_delegate == 1)
                                <form action="{{ route('delegate.update', $item->id) }}" method="post">
                                    @csrf
                                    <input type="hidden" name="set_delegate" value="0">
                                    <td><button class="btn btn-success">مفعل <i class="fa fa-check"></i></button></td>
                                </form>
                            @elseif ($item->set_delegate == 0)
                                <form action="{{ route('delegate.update', $item->id) }}" method="post">
                                    @csrf
                                    <input type="hidden" name="set_delegate" value="1">
                                    <td><button type="submit" class="btn btn-primary">تفعيل</button></td>
                                </form>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
