<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Lib\BulkDataQuery;

class EmailTemplate extends Model
{
	use BulkDataQuery;
	
    protected $guarded = ['id'];
}
