<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartIndent extends Model
{
    protected $guarded = ['id'];

    public function part()
    {
        return $this->belongsTo(Part::class);
    }

    public function indent()
    {
        return $this->belongsTo(Indent::class);
    }
}
