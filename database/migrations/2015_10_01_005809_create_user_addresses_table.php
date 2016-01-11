<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserAddressesTable extends Migration {
	/**
	 * 用户快递信息（一个用户对应多条）
	 *  名称
	 *  收件人姓名
	 *  手机
	 *  座机
	 *  邮编
	 *  地址
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('user_addresses', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id');
			$table->boolean('default')->default(0);
			$table->string('name', 60);
			$table->string('receiver_name', 60);
			$table->string('receiver_mobile', 11);
			$table->string('receiver_telephone', 16);
			$table->string('postcode', 6);
			$table->string('address', 400);
			$table->string('province')->nullable();
			$table->string('city')->nullable();
			$table->string('district')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('user_addresses');
	}
}
