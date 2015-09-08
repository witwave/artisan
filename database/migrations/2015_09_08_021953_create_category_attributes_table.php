<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
        Schema::table('product', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->string('sku', 255)->unique();
            $table->string('short_description', 255);
            $table->text('long_description')->nullable();
            $table->decimal('market_price',5,2);//市场价
            $table->boolean('show_martket_price')->default(false);//是否显示市场价
            $table->decimal('price', 8, 2)->default(0);
            $table->integer('qty')->nullable()->unsigned();//数量
            $table->boolean('featured')->default(FALSE);//新品
            $table->boolean('active')->default(TRUE);//可销售
            $table->boolean('free_shipping')->default(true);//是否包邮
            $table->json('attributes')->nullable();//其它属性
            $table->integer('category_id')->nullable()->unsigned();
            $table->foreign('category_id')->references('id')->on('categories');
            // created_at | updated_at DATETIME
            $table->timestamps();

            // Need to use InnoDB to support foreign key
            $table->engine = 'InnoDB';

        });*/
 if (! Schema::hasTable('category_attributes')) {
        Schema::create('category_attributes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->nullable()->unsigned();
            $table->integer('display_name');//(扩展属性)显示名称(比如：品牌，内存大小，颜色之类)
            $table->string('field_name');//(扩展属性)字段名称(比如：Brand,Memoery,Color之类)
            $table->string('field_type');//字段类型(比如：字符串，整数，日期之类)
            $table->string('field_length');//属性值长度(比如:50)
            $table->string('input_type');  //输入类型(比如：文本框，文本域，下拉框，复选框之类)
            $table->text('input_value'); //如果是下拉框，复选框，显示其它值
            $table->string('default_value');
            $table->boolean('required');
            $table->boolean('is_show');//是否显示在前台
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
    public function down()
    {
         Schema::drop('category_attributes');
    }
}
