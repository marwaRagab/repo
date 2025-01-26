@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Invoice</h1>
    <form action="{{ route('invoices.update', $invoice->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="invoice_number">Invoice Number</label>
            <input type="text" class="form-control" id="invoice_number" name="invoice_number" value="{{ $invoice->invoice_number }}" required>
        </div>

        <div class="form-group">
            <label for="date">Date</label>
            <input type="date" class="form-control" id="date" name="date" value="{{ $invoice->date }}" required>
        </div>

        <div class="form-group">
            <label for="amount">Amount</label>
            <input type="number" class="form-control" id="amount" name="amount" value="{{ $invoice->amount }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Invoice</button>
    </form>
</div>
@endsection
