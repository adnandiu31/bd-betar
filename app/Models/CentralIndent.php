<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CentralIndent extends Model
{
    protected $guarded = ['id'];


    public function manufacture()
    {
        return $this->belongsTo(Manufacture::class,'manufacture_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'final_approval_by');
    }
}
