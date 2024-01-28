<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ledger extends Model
{
    protected $guarded = ['id'];

    public function station()
    {
        return $this->belongsTo(Station::class);
    }
}
