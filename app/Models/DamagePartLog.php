<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DamagePartLog extends Model
{
    protected $guarded = ['id'];

    public function part(){
        return $this->belongsTo(Part::class);
    }

}
