<?php

use App\Laravel\Models\User;
use Illuminate\Database\Seeder;

class AdminAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $first_user = User::find(1);
        if($first_user){
            $input = ['username' => "master_admin", 'email' => "richardkennedy.domingo@yahoo.com",'password' => bcrypt('admin'),'name' => "Master Admin","type" => "super_user"];
            $first_user->fill($input);
            $first_user->save();
        }else{
            // if(env('DB_CONNECTION','sqlsrv') != "sqlsrv"){
                User::create(
                    ['id'=> 1,'username' => "master_admin", 'email' => "richardkennedy.domingo@yahoo.com",'password' => bcrypt('admin'),'name' => "Master Admin","type" => "super_user"]
                );
            // }else{
            //     DB::connection(env('MASTER_DB_CONNECTION','master_db'))->unprepared ('SET IDENTITY_INSERT [user] ON');
            //     DB::connection(env('MASTER_DB_CONNECTION','master_db'))->table('user')->insert(['id'=> 1,'username' => "admin", 'email' => "richardkennedy.domingo@yahoo.com",'password' => bcrypt('admin'),'name' => "Master Admin","type" => "super_user"]);
            //     DB::connection(env('MASTER_DB_CONNECTION','master_db'))->unprepared ('SET IDENTITY_INSERT [user] off');
            // }
                
        }
    }
}
