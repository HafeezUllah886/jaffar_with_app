<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class deepFreezerScan extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function deepFreezer()
    {
        return $this->belongsTo(deepFreezers::class, 'deep_freezer_id');
    }

    public function movements()
    {
        return $this->hasMany(deepFreezerMovement::class, 'deep_freezer_id');
    }
}
