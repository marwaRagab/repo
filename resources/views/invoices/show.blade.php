@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Invoice Details</h1>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoice->items as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->price }}</td>
                        <td>{{ $item->quantity * $item->price }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <h3>Total: {{ $invoice->total }}</h3>
        </div>
    </div>
</div>
@endsection
