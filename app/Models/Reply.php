<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    //    
    /**
     * guarded
     *
     * @var array
     */
    protected $guarded=['id'];

    
    /**
     * forum
     *
     * @return void
     */
    public function forum(){
       return $this->belongsTo(Forum::class);
    }
    
    /**
     * user
     *
     * @return void
     */
    public function user(){
        return $this->belongsTo(User::class);
     }
}
