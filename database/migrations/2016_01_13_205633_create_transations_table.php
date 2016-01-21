<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransationsTable extends Migration
{
    /**
     * Run the migrations.
     *https://doc.open.alipay.com/doc2/detail.htm?spm=0.0.0.0.EoExcx&treeId=62&articleId=103742&docType=1
     * @return void
     */
    public function up()
    {
        Schema::create('transations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('is_success',1);
            $table->string('sign_type');
            $table->string('sign',32);
            $table->string('out_trade_no',64)->nullable();
            $table->string('subject',256)->nullable();
            $table->string('payment_type',4);
            $table->string('exterface',128)->nullable();
            $table->string('trade_no',64)->nullable();
            $table->string('trade_status',64)->nullable();
            $table->string('notify_id',256)->nullable();
            $table->dateTime('notify_time')->nullable();
            $table->string('notify_type')->nullable();
            $table->string('seller_email',100)->nullable();
            $table->string('buyer_email',100)->nullable();
            $table->string('seller_id',30)->nullable();
            $table->string('buyer_id',30)->nullable();
            $table->decimal('total_fee')->nullable();
            $table->string('extra_common_param',512)->nullable();
            $table->string('body',400)->nullable();
            $table->string('agent_user_id',512)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('transations');
    }
}
