<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderProcessLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if (!Schema::hasTable('order_process_logs')) {
        Schema::create('order_process_logs', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('order_id')->index();
          $table->string('username');
          $table->string('message',200);
          $table->softDeletes();
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
    public function down()
    {
        //
    }
}
