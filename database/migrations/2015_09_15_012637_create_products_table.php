<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductsTable extends Migration {

	/**
	 *   名称
	 *品牌
	 *类型（鲜花等）
	 *色彩：
	 *价格
	 *提前定购价
	 *设定日期
	 *合作伙伴商价
	 *基本邮费
	 *每加一份的价格
	 *简要说明
	 *商品描述
	 *封面图片
	 *配送说明
	 *花语
	 *状态（已上架，没上架）
	 *商口数量
	 *积分：客户买一份所得的积分
	 *
	 * @return void
	 */
	public function up() {
		if (!Schema::hasTable('products')) {
			Schema::create('products', function (Blueprint $table) {
				$table->increments('id');
				$table->string('title', 255);
				$table->string('name', 255);
				$table->string('sku', 255)->unique();
				$table->string('brand'); //品牌
				$table->string('color'); //色彩
				$table->string('type'); //类型
				$table->string('material', 255); //用材
				$table->decimal('price', 8, 2)->default(0);
				$table->timestamp('down_time'); //过期时间，自动下架时间
				$table->decimal('partner_price', 8, 2)->default(0); //合作伙伴商价
				$table->decimal('ship_fee', 8, 2)->default(0);
				$table->decimal('ship_one_fee', 8, 2)->default(0);
				$table->string('ship_mark', 512)->nullable();
				$table->integer('credit')->default(0); //客户买一份所得的积分
				$table->integer('can_use_credit')->default(0); //是否可以使用积分
				$table->string('flower_description', 255); //花语
				$table->string('short_description', 255);
				$table->text('long_description')->nullable();
				$table->decimal('market_price', 8, 2)->default(0);
				$table->boolean('show_market_price')->default(TRUE);
				$table->boolean('featured')->default(FALSE);
				$table->boolean('active')->default(TRUE); //上架，下架
				$table->integer('qty')->nullable()->unsigned(); //数量
				$table->text('attributes')->nullable();
				$table->integer('category_id')->nullable()->unsigned();
				$table->integer('pv')->default(0)->unsigned();
				$table->foreign('category_id')->references('id')->on('categories');

				// created_at | updated_at DATETIME
				$table->timestamps();
				// Need to use InnoDB to support foreign key
				$table->engine = 'InnoDB';
			});
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('products');
	}

}
