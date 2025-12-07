<?php

namespace App\Models;

use App\Models\Ad;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;
    public function ad(){
        return $this->belongsTo(ad::class,'ad_id','id');
    }
    public function seller()
    {
        return $this->belongsTo(User::class, 'ad_owner_id', 'id');
    }

    public function purchaser()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function ownerAd()
    {
        return $this->belongsTo(ad::class, 'ad_owner_id', 'user_id');
    }
}
