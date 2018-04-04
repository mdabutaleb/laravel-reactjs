<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommunityUser extends Model
{
	protected $fillable = [
		'name',
		'email',
		'status',
	];
}
