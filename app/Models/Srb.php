<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Srb extends Model
{
    protected $guarded = ['id'];

    /**
     * Scope a query to only include active users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCheckStation($query)
    {
        return $query->where('station_id',Auth::user()->station->id);
    }

    public function scopeStatus($query)
    {
        return $query->where('status',true);
    }

    public function station()
    {
        return $this->belongsTo(Station::class);
    }

    public function indent()
    {
        return $this->belongsTo(Indent::class);
    }

    public function instruments()
    {
        return $this->hasMany(SrbInstrument::class);
    }

    public function parts()
    {
        return $this->hasMany(SrbPart::class);
    }

    public function isApproved()
    {
        return $this->approved_by_si_at != null && $this->approved_by_sh_at != null && $this->approved_by_ce_at !=null      && $this->approved_by_me_at !=null &&  $this->approved_by_dg_at !=null;
    }

}
