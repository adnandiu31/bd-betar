<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    //    
    /**
     * guarded
     *
     * @var array
     */
    protected $guarded=['id'];

    
    /**
     * user
     *
     * @return void
     */
    public function user(){
        return $this->belongsTo(User::class);
    }
        
    /**
     * replies
     *
     * @return void
     */
    public function replies(){
       return $this->hasMany(Reply::class);
    }
}
