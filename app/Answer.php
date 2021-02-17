<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model {
 

    protected $fillable = [
        'id', 'answer', 'question_id', 
    ];     
    
    public function questions()
    {        
         return $this->belongsTo('App\Question');
    }
  

}
