<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDay extends Model {

	protected $table = 'user_day';

	protected $fillable = ['user_id', 'date', 'name'];

	public function user() {
		return $this->belongsTo('App\Models\User');
	}
}
