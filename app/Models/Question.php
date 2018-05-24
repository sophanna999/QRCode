<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'question';
    //protected $primaryKey = '';
    //protected $timestamps = true;
    public function Answer()
    {
        return $this->hasMany('App\Models\Answer','question_id','id');
    }
}