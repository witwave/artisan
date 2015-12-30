<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrderProductTable extends Migration {

	/**
	 * Run the migrations.
	 * 订单详细（多个商品）
	 * 订单ＩＤ
	 * 商品ＩＤ
	 * 名称
	 * 商品信息
	 * 价格
	 * 数量
	 * 总价
	 * 运费
	 * 获得积分
	 * @return void
	 */
	public function up() {
		if (!Schema::hasTable('order_product')) {
			Schema::create('order_product', function (Blueprint $table) {
				$table->increments('id');
				$table->integer('order_id')->unsigned();
				$table->integer('product_id')->unsigned();
				$table->decimal('mail_fee', 8, 2)->default(0); //运费
				$table->decimal('price', 8, 2)->default(0);
				$table->string('name', 255);
				$table->integer('qty')->default(0);
				$table->integer('credit')->default(0);
				$table->decimal('total_price', 8, 2)->default(0);
				$table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
				$table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
			});
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('order_product');
	}

}
