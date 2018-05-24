<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionInit extends Model
{
    //protected $table = '';
    //protected $primaryKey = '';
    //protected $timestamps = true;
    public function Answer()
    {
        return $this->hasMany('App\Models\AnswerInit','question_id','id');
    }
}
