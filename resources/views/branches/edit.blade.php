@extends('app')

@section('content')
    <div class="container">
        <h1>Edit Branch</h1>
        <form action="{{ route('branches.update', $branch->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name_ar">Name (Arabic)</label>
                <input type="text" name="name_ar" class="form-control" value="{{ $branch->name_ar }}" required>
            </div>
            <div class="form-group">
                <label for="name_en">Name (English)</label>
                <input type="text" name="name_en" class="form-control" value="{{ $branch->name_en }}" required>
            </div>
            <button type="submit" class="btn btn-success">Update</button>
        </form>
    </div>
@endsection
