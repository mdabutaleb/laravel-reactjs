<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectCategory extends Model
{

	public function projects() {
		return $this->hasMany('App\Project');
	}
}
