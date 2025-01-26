@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create Invoice</h1>
        <form action="{{ route('invoices.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="client_name">Client Name</label>
                <input type="text" class="form-control" id="client_name" name="client_name" required>
            </div>
            <div class="form-group">
                <label for="invoice_date">Invoice Date</label>
                <input type="date" class="form-control" id="invoice_date" name="invoice_date" required>
            </div>
            <div class="form-group">
                <label for="amount">Amount</label>
                <input type="number" class="form-control" id="amount" name="amount" required>
            </div>
            <button type="submit" class="btn btn-primary">Create Invoice</button>
        </form>
    </div>
@endsection
