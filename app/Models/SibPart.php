<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SibPart extends Model
{
    protected $guarded=['id'];


    public function sib(){
        return $this->belongsTo(Sib::class);
    }

    public function part(){
        return $this->belongsTo(Part::class);
    }

    public function partInstruments()
    {
        return $this->hasMany(PartInstrument::class);
    }
}
