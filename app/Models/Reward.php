<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Reward extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'id',
        'app_user_id',
        'place_rewards',
        'reward',
        'date_reward',
        'status'
    ];

    public function usuario()
    {
        return $this->belongsTo(AppUser::class,'app_user_id','id');
    }

    public function GetMyRewards($id)
    {
        $req = Reward::where('app_user_id',$id)->orderBy('date_reward','desc')->get();
        $data = [];

        foreach ($req as $key) {
         
            $data[] = [
                'id' => $key->id,
                'place_reward' => $key->place_reward,
                'reward' => $key->reward,
                'date_reward' => $key->date_reward,
                'status' => $key->status,
            ];
        }

        return $data;
    }

}