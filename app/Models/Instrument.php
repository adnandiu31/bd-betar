<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class Instrument extends Model
{
    protected $guarded = ['id'];

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

    public function instrumentType()
    {
        return $this->belongsTo(InstrumentType::class);
    }

    public function manufacture()
    {
        return $this->belongsTo(Manufacture::class);
    }

    public function parts()
    {
        return $this->hasMany(Part::class);
    }

    public function stockInstruments()
    {
        return $this->hasMany(StockInstrument::class);
    }

    public function srbInstruments()
    {
        return $this->hasMany(SrbInstrument::class);
    }

    static public function scopeFilter($query){
        $query->when(request()->search ?? null, function ($query, $search) {
            $query->where('name', 'LIKE', "%$search%");
        })->when(request()->type ?? null, function ($query, $type) {
            $query->whereHas('instrumentType',function($query) use ($type){
                $query->where('name', 'LIKE', "$type");
            });
        })->when(request()->manufacturer ?? null, function ($query, $manufacturer) {
            $query->whereHas('manufacture',function($query) use ($manufacturer){
                $query->where('name', 'LIKE', "$manufacturer");
            });
        });
    }
}
