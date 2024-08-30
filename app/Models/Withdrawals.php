<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Withdrawals extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'id',
        'app_user_id',
        'bank',
        'account',
        'amount',
        'status'
    ];

    public function usuario()
    {
        return $this->belongsTo(AppUser::class,'app_user_id','id');
    }

}