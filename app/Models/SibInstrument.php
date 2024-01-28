<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class SibInstrument extends Model
{
    protected $guarded=['id'];


    public function sib(){
        return $this->belongsTo(Sib::class);
    }

    public function instrument(){
        return $this->belongsTo(Instrument::class);
    }
}
