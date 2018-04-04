<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model {
	public function SubMenu() {
		return $this->hasMany('App\SubMenu');
	}
}
