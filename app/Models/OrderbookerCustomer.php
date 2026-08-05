<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderbookerCustomer extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function orderbooker()
    {
        return $this->belongsTo(User::class, 'orderbooker_id');
    }

    public function customer()
    {
        return $this->belongsTo(accounts::class, 'customer_id');
    }
}
