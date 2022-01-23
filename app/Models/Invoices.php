<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoices extends Model
{
    use HasFactory;

    protected $fillable = [
        'billing_id',
        'number',
        'total',
    ];

    public function billing()
    {
        return $this->belongsTo(Billings::class);
    }

    public function payment()
    {
        return $this->hasOne(Payments::class);
    }

}
