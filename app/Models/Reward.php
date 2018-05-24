<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    protected $table = 'reward';
    //protected $primaryKey = '';
    //protected $timestamps = true;
    public function getRewardPicture(){
        return $this->hasOne('\App\Models\RewardPicture','reward_id','id');
    }
}