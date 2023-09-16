<?php

namespace App\Models;

use App\Models\Customer;
use App\Models\InvoiceProduct;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class invoice extends Model
{
    use HasFactory;
    protected $fillable = ['total', 'discount', 'vat', 'payable', 'user_id', 'customer_id'];

    function customer():belongsTo{
        return $this->belongsTo(Customer::class);
    }
    

    // function invoice_product():BelongsTo{
    // function invoice_product():BelongsTo{
    //     return $this->hasMany(InvoiceProduct::class);
    // }
}
