<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;


class Part extends Model
{
    protected $guarded = ['id'];

    // public function scopeCheckStation($query)
    // {
    //     return $query->where('station_id',Auth::user()->station->id);

    //     return $query->whereHas('instrument',function($query){
    //         $query->where('station_id',Auth::user()->station_id);
    //     });

        
    // }

    public function scopeCheckStation($query)
    {
        // return $query->where('station_id',Auth::user()->station->id);
        if(!Auth::user()->isAdmin()){
            return $query->where('station_id',Auth::user()->station->id);
        }
    }

    public function station()
    {
        return $this->belongsTo(Station::class);
    }

    public function instrument()
    {
        return $this->belongsTo(Instrument::class);
    }

    public function partType()
    {
        return $this->belongsTo(PartType::class);
    }

    public function manufacture()
    {
        return $this->belongsTo(Manufacture::class);
    }

    public function stockParts()
    {
        return $this->hasMany(StockPart::class);
    }

    public function srbParts()
    {
        return $this->hasMany(SrbPart::class);
    }

    static public function scopeFilter($query){
        $query->when(request()->search ?? null, function ($query, $search) {
            $query->where('name', 'LIKE', "%$search%");
        })->when(request()->type ?? null, function ($query, $type) {
            $query->whereHas('partType',function($query) use ($type){
                $query->where('name', 'LIKE', "$type");
            });
        })->when(request()->manufacturer ?? null, function ($query, $manufacturer) {
            $query->whereHas('manufacture',function($query) use ($manufacturer){
                $query->where('name', 'LIKE', "$manufacturer");
            });
        })->when(request()->instrument ?? null, function ($query, $instrument) {
            $query->whereHas('instrument',function($query) use ($instrument){
                $query->where('name', 'LIKE', "$instrument");
            });
        });
    }
}
