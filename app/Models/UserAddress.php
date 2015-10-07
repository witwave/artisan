<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model {
	protected $table = 'user_addresses';

	protected $fillable = ['user_id', 'name', 'receiver_name', 'receiver_mobile', 'receiver_telphone', 'address', 'province', 'city', 'district'];

	public function user() {
		return $this->belongsTo('App\Models\User');
	}

}
