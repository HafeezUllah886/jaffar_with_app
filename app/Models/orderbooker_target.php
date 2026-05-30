<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orderbooker_target extends Model
{

    use HasFactory;

    protected $guarded = [];

    public function orderbooker()
    {
        return $this->belongsTo(User::class, 'orderbookerID');
    }
}
