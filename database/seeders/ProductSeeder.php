<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        DB::table('products')->truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        $products = [
            [
                'name' => 'Nordic Lounge Chair',
                'description' => 'Kursi lounge gaya Skandinavia yang modern dan minimalis. Cocok untuk bersantai dengan elegan di ruang keluarga.',
                'price' => 1250000,
                'stock' => 25,
                'image_url' => 'https://images.unsplash.com/photo-1598300042247-d088f8ab3a91?q=80&w=800&h=800&auto=format&fit=crop',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kruzo Aero Chair',
                'description' => 'Sofa bertekstur nyaman yang menambah kesan estetik ruangan. Dibuat dengan material premium untuk kenyamanan maksimal.',
                'price' => 780000,
                'stock' => 15,
                'image_url' => 'https://images.unsplash.com/photo-1503602642458-232111445657?q=80&w=800&h=800&auto=format&fit=crop',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ergonomic Desk Chair',
                'description' => 'Kursi kerja ergonomis dengan dukungan lumbar untuk kenyamanan ekstra selama Anda bekerja atau belajar di rumah.',
                'price' => 1430000,
                'stock' => 40,
                'image_url' => 'https://images.unsplash.com/photo-1505843490538-5133c6c7d0e1?q=80&w=800&h=800&auto=format&fit=crop',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Classic Leather Armchair',
                'description' => 'Kursi kulit klasik untuk nuansa mewah berkelas. Terbuat dari kulit asli berkualitas tinggi yang awet dan tahan lama.',
                'price' => 3100000,
                'stock' => 10,
                'image_url' => 'https://images.unsplash.com/photo-1567538096630-e0c55bd6374c?q=80&w=800&h=800&auto=format&fit=crop',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Minimalist Wooden Stool',
                'description' => 'Bangku mini minimalis tanpa sandaran. Bahan material kayu pinus solid yang kuat dan serbaguna.',
                'price' => 320000,
                'stock' => 80,
                'image_url' => 'https://images.unsplash.com/photo-1524758631624-e2822e304c36?q=80&w=800&h=800&auto=format&fit=crop',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Outdoor Patio Couch',
                'description' => 'Sofa santai tahan cuaca yang sempurna untuk bersantai di area outdoor, teras, atau taman rumah Anda.',
                'price' => 2650000,
                'stock' => 22,
                'image_url' => 'https://images.unsplash.com/photo-1541004995602-b3e898709909?q=80&w=800&h=800&auto=format&fit=crop',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Velvet Accent Chair',
                'description' => 'Kursi aksen berbahan velvet yang elegan, sangat lembut saat disentuh, memberikan sentuhan glamor.',
                'price' => 1500000,
                'stock' => 12,
                'image_url' => 'https://images.unsplash.com/photo-1519947486511-46149fa0a254?q=80&w=800&h=800&auto=format&fit=crop',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mid-Century Dining Chair',
                'description' => 'Kursi ruang makan berdesain Mid-Century klasik kayu pohon oak kuat.',
                'price' => 680000,
                'stock' => 60,
                'image_url' => 'https://images.unsplash.com/photo-1493663284031-b7e3aefcae8e?q=80&w=800&h=800&auto=format&fit=crop',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Modern Fabric Sofa',
                'description' => 'Sofa 3 dudukan berbalut kain woven berkualitas, dirancang untuk ruang tamu kontemporer Anda.',
                'price' => 4500000,
                'stock' => 8,
                'image_url' => 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?q=80&w=800&h=800&auto=format&fit=crop',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Industrial Bar Stool',
                'description' => 'Kursi konter/bar ala industrial dengan dudukan kayu solid dan rangka metal hitan kokoh.',
                'price' => 550000,
                'stock' => 35,
                'image_url' => 'https://images.unsplash.com/photo-1533090481720-856c6e3c1fdc?q=80&w=800&h=800&auto=format&fit=crop',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Wicker Rattan Chair',
                'description' => 'Kursi rotan anyam yang menghadirkan nuansa tropis, cocok untuk sudut baca atau area santai pinggir kolam.',
                'price' => 1100000,
                'stock' => 18,
                'image_url' => 'https://images.unsplash.com/photo-1592078615290-033ee584e267?q=80&w=800&h=800&auto=format&fit=crop',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Plush Bean Bag',
                'description' => 'Bean bag empuk nan premium. Sangat sempurna untuk rebahan, bermain game, dan menonton film.',
                'price' => 950000,
                'stock' => 50,
                'image_url' => 'https://images.unsplash.com/photo-1598300056393-4aac492f4344?q=80&w=800&h=800&auto=format&fit=crop',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($products as &$p) {
            $p['rating'] = rand(35, 50) / 10;
            $p['reviews_count'] = rand(5, 120);
            $p['sold_count'] = rand(10, 400);
        }

        DB::table('products')->insert($products);
    }
}
