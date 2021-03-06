<?php

use App\Models\Group;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserGroupSeeder extends Seeder {
	public function run() {
		DB::table('users')->delete();
		DB::table('groups')->delete();
		DB::table('users_groups')->delete();

		$user = new User;
		$user->email = 'admin@bdbeloved.com';
		$user->password = \Hash::make("bdbeloved");
		$user->name = '系统管理员';
		$user->activated = 1;
		$user->type = 2;

		$user->save();

		$admin_group = new Group;
		$admin_group->name = 'Admin';
		$admin_group->permissions = json_encode(array(
			'admin.view' => 1,
			'admin.create' => 1,
			'admin.delete' => 1,
			'admin.update' => 1,
		));
		$admin_group->save();

		$user_group = new Group;
		$user_group->name = 'User';
		$user_group->permissions = json_encode(array(
			'admin.view' => 0,
			'admin.create' => 0,
			'admin.delete' => 0,
			'admin.update' => 0,
		));
		$user_group->save();

		// Assign user permissions
		$user->groups()->save($admin_group);
	}
}
