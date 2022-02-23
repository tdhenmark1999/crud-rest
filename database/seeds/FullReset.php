<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Laravel\Models\User;
use App\Laravel\Models\Product;
use App\Laravel\Models\Category;



class FullReset extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        Product::truncate();
        Category::truncate();

        $this->call(AdminAccountSeeder::class);

    }
}
