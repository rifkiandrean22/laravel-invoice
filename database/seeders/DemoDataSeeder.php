<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Supplier;
use App\Models\Product;

class DemoDataSeeder extends Seeder {
    public function run(): void {
        Supplier::factory()->create(['name'=>'PT Sinar Jaya','email'=>'sinar@example.com']);
        Product::factory()->create(['sku'=>'P-001','name'=>'Kertas A4','unit'=>'rim','price'=>45000]);
        Product::factory()->create(['sku'=>'P-002','name'=>'Pulpen','unit'=>'pcs','price'=>5000]);
    }
}
