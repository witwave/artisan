<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCart extends Model {
	protected $table = 'cart';

	protected $fillable = ['user_id', 'content'];

	public function user() {
		return $this->belongsTo('App\Models\User');
	}

}
