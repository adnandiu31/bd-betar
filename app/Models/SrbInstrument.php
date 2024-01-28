<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SrbInstrument extends Model
{
    protected $guarded=['id'];


    public function srb(){
        return $this->belongsTo(Srb::class);
    }

    public function instrument(){
        return $this->belongsTo(Instrument::class);
    }
}
