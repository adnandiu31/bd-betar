<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SrbPart extends Model
{
    protected $guarded=['id'];


    public function srb(){
        return $this->belongsTo(Srb::class);
    }

    public function part(){
        return $this->belongsTo(Part::class);
    }
}
