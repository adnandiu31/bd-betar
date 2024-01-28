<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PartInstrument extends Model
{
    protected $guarded = ['id'];

    // public function scopeCheckStation($query)
    // {
    //     if(!Auth::user()->isAdmin()){
    //         return $query->where('station_id',Auth::user()->station->id);
    //     }
    // }

    public function stockInstrument()
    {
        return $this->belongsTo(StockInstrument::class,'stock_instruments_id','id');
    }

    public function stockPart()
    {
        return $this->belongsTo(StockPart::class);
    }

    public function sibPart()
    {
        return $this->belongsTo(SibPart::class);
    }
}
