<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
class Sib extends Model
{
    protected $guarded = ['id'];

    public function scopeCheckStation($query)
    {
        return $query->where('station_id',Auth::user()->station->id);
    }

    public function scopeStatus($query)
    {
        return $query->where('status',true);
    }

    public function instruments()
    {
        return $this->hasMany(SibInstrument::class);
    }

    public function parts()
    {
        return $this->hasMany(SibPart::class);
    }

    public function isApproved()
    {
        return $this->approved_by_si_at != null && $this->approved_by_sh_at != null;
    }
}
