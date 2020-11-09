<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfileUser extends Model
{
    protected $table = "profile_user";

    protected $fillable = [
        'user_id',
        'phone',
        'birthday'
    ];


    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
