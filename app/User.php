<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Lib\BulkDataQuery;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, BulkDataQuery;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $gaurded = ['id','created_at','updated_at','remember_token'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
