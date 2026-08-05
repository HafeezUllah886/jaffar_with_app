<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class deepFreezerMovement extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function deep_freezer()
    {
        return $this->belongsTo(deepFreezers::class, 'deep_freezer_id');
    }

    public function customer()
    {
        return $this->belongsTo(accounts::class, 'customer_id');
    }
}
