<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductGroup;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class GroupingTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buat Brand "APPLE TESTER" jika belum ada
        $brand = Brand::firstOrCreate(
            ['slug' => 'apple-tester'],
            [
                'name' => 'APPLE TESTER',
                'sort_order' => 0,
                'is_active' => true,
            ]
        );

        // 2. Buat Product Groups (Sub-kategori) untuk Brand tersebut
        $groupsData = [
            [
                'name' => 'iPhones',
                'slug' => 'iphones',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'MacBooks',
                'slug' => 'macbooks',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Accessories',
                'slug' => 'accessories',
                'sort_order' => 3,
                'is_active' => true,
            ],
        ];

        $groups = [];
        foreach ($groupsData as $data) {
            $groups[$data['slug']] = ProductGroup::firstOrCreate(
                [
                    'brand_id' => $brand->id,
                    'slug' => $data['slug']
                ],
                [
                    'name' => $data['name'],
                    'sort_order' => $data['sort_order'],
                    'is_active' => $data['is_active'],
                ]
            );
        }

        // 3. Buat Produk Contoh dalam masing-masing Group
        $productsData = [
            [
                'name' => 'iPhone 15 Pro Max',
                'description' => 'The ultimate iPhone with titanium body, A17 Pro chip, and advanced telephoto camera.',
                'image_path' => 'products/iphone_placeholder.png',
                'group' => 'iphones',
            ],
            [
                'name' => 'iPhone 15',
                'description' => 'A huge leap forward for iPhone with a gorgeous design, Dynamic Island, and 48MP camera.',
                'image_path' => 'products/iphone_placeholder.png',
                'group' => 'iphones',
            ],
            [
                'name' => 'MacBook Pro M3 Max',
                'description' => 'Mind-blowing performance and extreme capability for developers, creators, and professionals.',
                'image_path' => 'products/macbook_placeholder.png',
                'group' => 'macbooks',
            ],
            [
                'name' => 'AirPods Pro 2',
                'description' => 'Rich audio quality, next-level Active Noise Cancellation, and adaptive audio transparency.',
                'image_path' => 'products/airpods_placeholder.png',
                'group' => 'accessories',
            ],
            [
                'name' => 'Apple Watch Ultra 2',
                'description' => 'The rugged and capable watch built for endurance, adventure, and extreme outdoor sports.',
                'image_path' => 'products/watch_placeholder.png',
                'group' => null, // Omit group to test the "Lainnya" (ungrouped) section!
            ],
        ];

        foreach ($productsData as $index => $pData) {
            $groupId = $pData['group'] ? $groups[$pData['group']]->id : null;
            
            Product::firstOrCreate(
                [
                    'brand_id' => $brand->id,
                    'name' => $pData['name']
                ],
                [
                    'product_group_id' => $groupId,
                    'description' => $pData['description'],
                    'image_path' => $pData['image_path'],
                    'original_filename' => basename($pData['image_path']),
                    'file_size_kb' => 120,
                    'sort_order' => $index,
                    'is_active' => true,
                    'show_description' => true,
                ]
            );
        }
    }
}
