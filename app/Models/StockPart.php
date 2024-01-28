<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class StockPart extends Model
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

    public function part()
    {
        return $this->belongsTo(Part::class);
    }

    public function stockInstruments()
    {
        return $this->belongsToMany(StockInstrument::class);
    }

    public function sibParts()
    {
        return $this->hasMany(SibPart::class,'');
    }

    public function partInstruments()
    {
        return $this->hasMany(PartInstrument::class);
    }

    static public function scopeFilter($query){
        $query->when(request()->search ?? null, function ($query, $search) {
            $query->whereHas('part',function($query) use ($search){
                $query->where('name', 'LIKE', "%$search%");
            });
        })->when(request()->type ?? null, function ($query, $type) {
            $query->whereHas('part',function($query) use ($type){
                $query->whereHas('partType',function($query) use ($type){
                    $query->where('name',"$type");
                });
            });
        })->when(request()->manufacturer ?? null, function ($query, $manufacturer) {
            $query->whereHas('part',function($query) use ($manufacturer){
                $query->whereHas('manufacture',function($query) use ($manufacturer){
                    $query->where('name', "$manufacturer");
                });
            });  
        })->when(request()->instrument ?? null, function ($query, $instrument) {
            $query->whereHas('part',function($query) use ($instrument){
                $query->whereHas('instrument',function($query) use ($instrument){
                    $query->where('name', "$instrument");
                });
            });  
        })->when(request()->station ?? null, function ($query, $station) {
            $query->whereHas('station',function($query) use ($station){
                $query->where('name', "$station");
            });
        });
    }
}
