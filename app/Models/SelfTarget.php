<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SelfTarget extends Model
{

    use HasFactory;

    protected $guarded = [];
    public function vendor()
    {
        return $this->belongsTo(accounts::class, 'vendorID');
    }

    public function details()
    {
        return $this->hasMany(SelfTargetDetails::class, 'targetID');
    }
}
