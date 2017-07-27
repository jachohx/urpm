<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAdminLoginLogTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('admin_login_log', function(Blueprint $table)
		{
			$table->integer('id', true)->comment('ID');
			$table->integer('user_id')->comment('用户ID');
			$table->string('ips', 256)->nullable()->comment('IP');
			$table->string('address', 128)->nullable()->comment('地址');
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
		Schema::drop('admin_login_log');
	}

}
