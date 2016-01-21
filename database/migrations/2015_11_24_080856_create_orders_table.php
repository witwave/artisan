<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *订单
	 *订单号
	 *订单用户类型（普通会员，合作伙伴，游客）
	 *用户的ID
	 *附加信息（语音，文字，图片）
	 *获得积分（购买商品得到的积分）
	 *使用积分（购买商品所花费的积分）
	 *商品总价
	 *商品成交价
	 *运费
	 *订单总价
	 *最终付款价
	 *订单联系电话
	 *是否上门自取
	 *是否付款
	 *是否发货
	 *发货人ID
	 *发货时间
	 *快递公司
	 *快递单号
	 * @return void
	 */
	public function up() {
		if (!Schema::hasTable('orders')) {
			Schema::create('orders', function (Blueprint $table) {
				$table->increments('id');
				$table->timestamps();
				$table->string('out_order_id',128)->index(); //外部订单ID (BDyyyyMMddHHmmss+round(0000~1000))
				$table->decimal('product_total_price', 8, 2)->default(0); //商品总价
				$table->integer('can_get_credit')->default(0); //购买商品得到的积分
				$table->integer('used_credit')->default(0); //购买商品所花费的积分
				$table->decimal('mail_fee', 8, 2)->default(0); //运费
				$table->integer('user_type')->default(0); //订单用户类型
				$table->integer('user_id')->nullable()->unsigned(); //用户id,游客为空
				$table->string('mobile', 11)->nullable(); //游客必须填写电话
				$table->decimal('paid', 8, 2)->default(0); //最终付款价
				$table->string('transaction_id')->default('Unknown')->nullable();
				$table->string('payment_status')->default('Completed')->nullable(); //是否付款

				$table->timestamp('require_send_day'); //要求发货日期
				$table->integer('require_send_type'); //配送时段类型（无限制，上午，下午，晚上，定时）
				$table->timestamp('require_send_time')->nullable(); //要求发货时间


				$table->boolean('has_special')->default(FALSE); //
				$table->string('special_content', 255)->nullable();
				$table->text('card')->nullable();//卡片内
				$table->dateTime('card_expired')->nullable();//卡片失效时间

				$table->boolean('self_get')->default(FALSE); //上门取货 或送货上门
				$table->integer('partner_id')->nullable(); //合作伙伴id 选择的点位


				$table->boolean('sent')->default(FALSE); //是否发货
				$table->integer('sent_by')->default(FALSE); //发货人ID
				$table->timestamp('sent_time')->nullable(); //发货时间
				$table->string('sent_company', 200)->nullable(); //快递公司
				$table->string('sent_no', 60)->nullable(); //快递单号


				$table->string('receiver_name',60);
				$table->string('receiver_province',20);
				$table->string('receiver_city',20);
				$table->string('receiver_address',500);
				$table->string('receiver_mobile',13);
				$table->string('receiver_telephone',13)->nullable();

				$table->string('booker_name',16);
				$table->string('booker_phone',16);
				$table->string('booker_email',16)->nullable();

				$table->integer('pay_type')->default(0);

				$table->text('options')->nullable();
				$table->softDeletes();

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
		Schema::dropIfExists('orders');
	}

}
