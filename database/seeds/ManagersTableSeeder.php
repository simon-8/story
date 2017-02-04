<?php

use Illuminate\Database\Seeder;

class ManagersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('managers')->delete();
        
        \DB::table('managers')->insert(array (
            0 => 
            array (
                'id' => 1,
                'username' => 'simon',
                'password' => '$2y$10$UNtvtqYOoBuxl4AB/fDvcuvMn4RPV80SCx2O.c/wMgRwD3qB891QC',
                'truename' => '刘先森',
                'email' => 'liu@simon8.com',
                'salt' => '',
                'lastip' => '127.0.0.1',
                'lasttime' => 1486170986,
                'remember_token' => NULL,
                'created_at' => '2017-01-12 11:02:35',
                'updated_at' => '2017-02-04 01:16:26',
            ),
        ));
        
        
    }
}
