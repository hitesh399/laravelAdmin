<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Lib\BulkDataQuery;

class Permission extends Model
{
    //
	use BulkDataQuery;

	public $timestamps = false;
	protected $guarded = ['id'];

    public function roles()
    {
    	return $this->belongsToMany('App\Models\Role','role_permission');
    }
}
