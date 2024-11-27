@extends('app')

@section('content')

    <link rel="stylesheet" href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

    <div class="container">
        <h1>Branches</h1>
        <a href="{{ route('branches.create') }}" class="btn btn-primary">Add New Branch</a>
        <table class="table" id="branches-table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name (Arabic)</th>
                <th>Name (English)</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function () {
                $('#branches-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('branches.getall') }}",
                    columns: [
                        {data: 'id', name: 'id'},
                        {data: 'name_ar', name: 'name_ar'},
                        {data: 'name_en', name: 'name_en'},
                        {
                            data: 'id',
                            render: function (data, type, row) {
                                return `
                            <a href="{{ url('branches') }}/${data}" class="btn btn-info">View</a>
                            <a href="{{ url('branches') }}/${data}/edit" class="btn btn-warning">Edit</a>
                            <form method="POST" action="{{ url('branches') }}/${data}" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        `;
                            }
                        }
                    ]
                });
            });
        </script>
    @endpush
@endsection
