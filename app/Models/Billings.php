<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billings extends Model
{
    use HasFactory;

    protected $fillable = [
        'period',
        'due_time'
    ];

    public function invoice()
    {
        return $this->hasOne(Invoices::class, 'biiling_id');
    }

    public function subscription()
    {
        return $this->hasOne(Subscriptions::class);
    }

}
