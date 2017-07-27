<?php

use Illuminate\Database\Seeder;

class AdminUsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('admin_users')->delete();
        \DB::table('admin_users')->insert(array (
            0 => 
		        array (
                    'id'		        =>	1,
	                'username'	        =>	'admin',
	                'email'		        =>	'admin@localhost.com',
		            'mobile'	        =>	'12345678909',
		            'sex'	            =>	1,
		            'password'	        =>	'$2y$10$p7ynYlhuSZ9v8P1WlohSpugGO5EjNGAQhINqugIrJyRPo93xP9.82', //123456
		            'remember_token'    =>	'',
		            'created_at'	    =>	date('Y-m-d H:i:s',time()),
		            'updated_at'	    =>	date('Y-m-d H:i:s',time()),
		        ),
	        )
	    );
    }
}
