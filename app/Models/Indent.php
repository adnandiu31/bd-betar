<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Indent extends Model
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

    public function scopeAllApproved($query)
    {
        return $query->where('station_id',Auth::user()->station->id)
            ->where('approved_by_si_at','!=',null)
            ->where('approved_by_sh_at','!=',null)
            ->where('approved_by_ce_at','!=',null)
            ->where('approved_by_me_at','!=',null)
            ->where('approved_by_dg_at','!=',null)
            ->where('status',true);
    }

    public function isApproved()
    {
         return $this->approved_by_si_at != null && $this->approved_by_sh_at != null;
    }

    public function hasRemaining(){
        if($this->product_type=='instrument'){
            return $this->instruments()->where('remaining','>',0)->get();

        }else{
            return $this->parts()->where('remaining','>',0)->get();
        }
    }

    public function station()
    {
        return $this->belongsTo(Station::class);
    }

    public function manufacture()
    {
        return $this->belongsTo(Manufacture::class);
    }

    public function instruments()
    {
        return $this->hasMany(InstrumentIndent::class);
    }

    public function parts()
    {
        return $this->hasMany(PartIndent::class);
    }

    static public function scopeFilter($query){
        $query->when(request()->search ?? null, function ($query, $search) {
            $query->where('name', 'LIKE', "%$search%");
        })->when(request()->station ?? null, function ($query, $station) {
            $query->whereHas('station',function($query) use ($station){
                $query->where('name', 'LIKE', "$station");
            });
        })->when(request()->manufacturer ?? null, function ($query, $manufacturer) {
            $query->whereHas('manufacture',function($query) use ($manufacturer){
                $query->where('name', 'LIKE', "$manufacturer");
            });
        });
    }
}
