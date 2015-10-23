<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserTable extends Migration {

	/**
	 * Run the migrations.
	 * 用户表
	 * 用户分为：一种是超级管理员，一种是合作伙伴，一种是普通用户
	 * 合作伙伴 可以查看用户购买的购买课程
	 * 普通用户只能参与网站的前台功能（如报名，评论，分享）
	 * 用户可以通过手机或者邮箱进入系统
	 * 姓名
	 * 手机
	 * 邮箱
	 * 网名
	 * 图像
	 * 性别
	 * 密码
	 * 类型（管理员1，内部人员2，合作伙伴3，普通会员4
	 * 状态（激活1，0)
	 * 总积分
	 * 使用积分
	 * 所在省
	 * 所在市
	 * 所在区
	 * 所在详细地址
	 * 所在经度
	 * 所在纬度
	 * @return void
	 */
	public function up() {
		Schema::create('users', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name'); //姓名
			$table->string('mobile', 11)->nullable()->index(); //手机
			$table->string('email')->unique(); //邮箱
			$table->string('nickname')->nullable();
			$table->string('avatar')->nullable();
			$table->string('sex')->nullable();
			$table->string('password', 60);
			$table->integer('type')->default(0); //0:普通用户，1:合作伙伴 2:内部员工 3:管理员

			$table->integer('total_credit')->default(0); //总积分
			$table->integer('used_credit')->default(0); //已使用积分

			$table->string('province')->nullable();
			$table->string('city')->nullable();
			$table->string('district')->nullable();
			$table->string('address')->nullable();
			$table->double('lng')->nullable(); //经度
			$table->double('lat')->nullable(); //纬度
			$table->string('openid')->nullable(); //微信open_id

			$table->text('permissions')->nullable();
			$table->boolean('activated')->default(0); //状态
			$table->string('activation_code')->nullable();
			$table->timestamp('activated_at')->nullable();
			$table->timestamp('last_login')->nullable();
			$table->integer('login_count')->nullable();
			$table->string('persist_code')->nullable();
			$table->string('reset_password_code')->nullable();

			// We'll need to ensure that MySQL uses the InnoDB engine to
			// support the indexes, other engines aren't affected.
			$table->engine = 'InnoDB';
			$table->index('activation_code');
			$table->index('reset_password_code');

			$table->rememberToken();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('users');
	}

}
