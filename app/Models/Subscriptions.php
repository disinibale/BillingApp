<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriptions extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'plan_id', 'start_date', 'end_date', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plans::class);
    }

    public function billing()
    {
        return $this->hasOne(Billings::class, 'subscription_id');
    }

    public function invoice()
    {
        return $this->hasOne(Invoices::class);
    }
}
