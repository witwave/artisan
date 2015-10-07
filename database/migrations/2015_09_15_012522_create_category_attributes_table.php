<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoryAttributesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {

		if (!Schema::hasTable('categories_attributes')) {
			Schema::create('categories_attributes', function (Blueprint $table) {
				$table->increments('id');
				$table->integer('category_id')->nullable()->unsigned();
				$table->integer('display_name'); //(扩展属性)显示名称(比如：品牌，内存大小，颜色之类)
				$table->string('field_name'); //(扩展属性)字段名称(比如：Brand,Memoery,Color之类)
				$table->string('field_type'); //字段类型(比如：字符串，整数，日期之类)
				$table->string('field_length'); //属性值长度(比如:50)
				$table->string('input_type'); //输入类型(比如：文本框，文本域，下拉框，复选框之类)
				$table->text('input_value'); //如果是下拉框，复选框，显示其它值
				$table->string('default_value');
				$table->boolean('required');
				$table->boolean('is_show'); //是否显示在前台
				$table->tinyInteger('sort')->default(0);
				$table->softDeletes();
				$table->timestamps();
				$table->foreign('category_id')->references('id')->on('categories');
			});
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('categories_attributes');
	}
}
