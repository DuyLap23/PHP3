<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Nette\Utils\Random;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::query()->pluck('id')->toArray();
        $product=[];
        for ($i = 1; $i < 10; $i++) {
            $product[]=  [
                'category_id' =>fake()-> randomElement($categories),
                'name' => fake()->name(),
                'price' => fake()->numberBetween(10000, 1000000),
                'quantity' => fake()->numberBetween(1, 100),
                'image' => fake()->imageUrl(),
                'description' => fake()->text(100),
                'status' => rand(0, 1),
            ];
           
        }
        DB::table('products')->insert($product);
    }
}
