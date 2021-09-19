<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use DB;
use Auth;

class mMember extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable,
        CanResetPassword;

    protected $table = 'users';
    protected $primaryKey = 'users_id';
    public $incrementing = false;
    public $remember_token = false;
    //public $timestamps = false;
    protected $fillable = ['users_id','users_username', 'users_password', 'users_name','users_email','users_nohp','users_accesstoken','users_lastonline','users_created_at','users_updated_at'];

}
