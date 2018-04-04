<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CorporateUser extends Model
{
	protected $fillable = [
		'name',
		'email',
		'status',
	];
}
