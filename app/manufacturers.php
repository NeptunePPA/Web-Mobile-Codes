<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class manufacturers extends Model {
	protected $table = 'manufacturers';

	protected $fillable = [
		'item_no', 'manufacturer_name', 'manufacturer_logo', 'is_active', 'is_delete', 'short_name'];

	public function user() {
		return $this->hasMany('App\User', 'organization');
	}

	public function device() {
		return $this->hasMany('App\device', 'manufacturer_name');
	}

	public function ordermanufacturer() {
		return $this->hasMany('App\orders', 'manufacturer_name');
	}

}
