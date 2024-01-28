<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstrumentIndent extends Model
{
    protected $guarded = ['id'];

    public function instrument()
    {
        return $this->belongsTo(Instrument::class);
    }

    public function indent()
    {
        return $this->belongsTo(Indent::class);
    }
}
