<?php

namespace Database\Seeders;

use App\Models\Attrproduct;
use App\Models\Car;
use App\Models\Carmodel;
use App\Models\Categoryproduct;
use App\Models\Color;
use App\Models\Model;
use App\Models\Product;
use App\Models\Servicecategory;
use App\Models\Year;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = Product::factory()->count(40)->create();
        foreach ($products as $product) {
            Attrproduct::factory()->count(10)->create([
                'product_id' => $product->id,
            ]);
        }
    }
}
