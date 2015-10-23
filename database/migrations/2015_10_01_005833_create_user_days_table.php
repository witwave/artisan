<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserDaysTable extends Migration {
	/**
	 *用户重要节日（可以添加多条）
	 *姓名 宝宝
	 *名称（如生日）
	 *日期  x年x月
	 *备注
	 *是否提醒（提前一周邮箱和短信提醒）
	 *提醒的邮箱：
	 *短信手机
	 * @return void
	 */
	public function up() {
		Schema::create('user_days', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->integer('name')->unsigned();
			$table->date('date');
			$table->string('mark', 100)->nullable();
			$table->boolean('remind_enable')->default(0);
			$table->integer('remind_beforeday')->default(7);
			$table->string('remind_email')->nullable();
			$table->string('remind_mobile')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('user_days');
	}
}
