<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plans extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'name',
        'description',
        'price',
        'tax'
    ];

    public function subscription()
    {
        return $this->belongsTo(Subscriptions::class, 'plan_id');
    }
}
