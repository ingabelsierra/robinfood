<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model {
 

    protected $fillable = [
        'id', 'question','poll_id'
    ];    
  
    public function polls()
    {        
        return $this->belongsTo('App\Poll');
    }
    
    public function answers()
    {      
        return $this->hasMany('App\Answer');
    }

}
