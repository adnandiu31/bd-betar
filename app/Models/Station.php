<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    protected $guarded = ['id'];

    public function ledgers()
    {
        return $this->hasMany(Ledger::class);
    }
}