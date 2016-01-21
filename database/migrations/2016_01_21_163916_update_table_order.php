<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTableOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if (Schema::hasTable('orders')) {
          if (! Schema::hasColumn('orders', 'payment_time')) {
              Schema::table('orders', function($table) {
                  $table->dateTime('payment_time');
                  $table->string('payment_message',200);
              });
          }
          if (! Schema::hasColumn('orders', 'status')) {
              Schema::table('orders', function($table) {
                  $table->integer('status');
              });
          }
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
