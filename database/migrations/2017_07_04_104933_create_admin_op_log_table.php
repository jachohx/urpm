<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAdminOpLogTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('admin_op_log', function(Blueprint $table)
		{
			$table->integer('id', true)->comment('ID');
			$table->integer('user_id')->comment('用户ID');
			$table->string('url', 128)->nullable()->comment('URL');
			$table->string('controller', 128)->nullable()->comment('controller类');
			$table->string('class_name', 64)->nullable()->comment('类名');
			$table->string('class_method', 64)->nullable()->comment('类方法');
			$table->string('method', 32)->nullable()->comment('请求的方法,如get,post,put,delete');
			$table->string('real_method', 32)->nullable()->comment('请求的真实方法,如get,post');
			$table->string('description', 1024)->nullable()->comment('描述');
			$table->text('parameter', 65535)->nullable()->comment('参数,json');
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
		Schema::drop('admin_op_log');
	}

}
