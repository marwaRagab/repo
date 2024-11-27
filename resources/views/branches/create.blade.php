@extends('app')

@section('content')
    <div class="container">
        <h1>Create New Branch</h1>
        <form action="{{ route('branches.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name_ar">Name (Arabic)</label>
                <input type="text" name="name_ar" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="name_en">Name (English)</label>
                <input type="text" name="name_en" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Save</button>
        </form>
    </div>
@endsection
