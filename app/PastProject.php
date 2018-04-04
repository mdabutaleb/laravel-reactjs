<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PastProject extends Model {

	public function pastProjectMedia() {
		return $this->hasMany( 'App\PastProjectMedia' );
	}
}
