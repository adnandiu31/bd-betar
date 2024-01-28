<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class StockInstrument extends Model
{
    protected $guarded = ['id'];

    public function scopeCheckStation($query)
    {
        return $query->where('station_id',Auth::user()->station->id);
        // if(!Auth::user()->isAdmin()){
        //     return $query->where('station_id',Auth::user()->station->id);
        // }
    }

    public function station()
    {
        return $this->belongsTo(Station::class);
    }

    public function instrument()
    {
        return $this->belongsTo(Instrument::class);
    }

    public function sibInstruments()
    {
        return $this->hasMany(SibInstrument::class);
    }

    public function stockParts()
    {
        return $this->belongsToMany(StockPart::class);
    }

    public function partInstruments()
    {
        return $this->hasMany(PartInstrument::class);
    }

    static public function scopeFilter($query){
        $query->when(request()->search ?? null, function ($query, $search) {
            $query->whereHas('instrument',function($query) use ($search){
                $query->where('name', 'LIKE', "%$search%");
            });
        })->when(request()->type ?? null, function ($query, $type) {
            $query->whereHas('instrument',function($query) use ($type){
                $query->whereHas('instrumentType',function($query) use ($type){
                    $query->where('name', 'LIKE', "$type");
                });
            });
        })->when(request()->manufacturer ?? null, function ($query, $manufacturer) {
            $query->whereHas('instrument',function($query) use ($manufacturer){
                $query->whereHas('manufacture',function($query) use ($manufacturer){
                    $query->where('name', 'LIKE', "$manufacturer");
                });
            });  
        })->when(request()->station ?? null, function ($query, $station) {
            $query->whereHas('station',function($query) use ($station){
                $query->where('name', 'LIKE', "$station");
            });
        });
    }
}
