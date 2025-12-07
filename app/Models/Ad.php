<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Ad extends Model
{
    use HasFactory, SoftDeletes, Notifiable;

    protected $guarded =[];
    public function transaction(){
        return $this->hasOne(Transaction::class,'ad_id','user_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function owner(): MorphTo
    {
        return $this->morphTo();
    }
}
