<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceCashier extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'invoices_cashier';

    // Define the fillable attributes
    /*protected $fillable = [
        'invoice_id',
        'cashier_id',
        'amount',
        'payment_date',
    ];
*/
    // Define the relationships
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function cashier()
    {
        return $this->belongsTo(Cashier::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
