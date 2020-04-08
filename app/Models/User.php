<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;


use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmailContract
{
    use Notifiable, MustVerifyEmailTrait,HasRoles,Traits\ActiveUserHelper,Traits\LastActivedAtHelper;

    protected $fillable = [
        'name', 'email', 'password','avatar',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function topics(){
        return $this->hasMany(Topic::class);
    }


    public function isAuthorOf($model)
    {
        return $this->id == $model->user_id;
    }

    public function replies(){
        return $this->hasMany(Reply::class);
    }


    public function setPasswordAttribute($value){
        //如果值的长度等于 60，即认为是已经做个加密情况
        if(strlen($value) != 60){
            //不等于60，做密码加密处理
            $value= bcrypt($value);

        }

        $this->attributes['password']=$value;
    }


    public function setAvatarAttribute($path){
        //如果不是http子串开头，那就是从后台长传的，需要补全UTL
        if(!\Str::startsWith($path,'http')){
            //拼接完整的URL
            $path =config('app.url')."/uploads/images/avatars/$path";
        }
        $this->attributes['avatar'] = $path;
    }

}


























