<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Admin User
        User::factory()->create([
            'name' => 'System Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 2. Seed Standard User
        User::factory()->create([
            'name' => 'Standard User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'role' => 'standard',
        ]);

        // 3. Seed Products highly popular and used in India
        $indianProducts = [
            [
                'title' => 'Maggi 2-Minute Masala Noodles (Pack of 12)',
                'description' => '<p>The most popular instant noodles in India, loved by students, kids, and adults alike. Quick, delicious, and flavored with a unique blend of standard Indian spices.</p>',
                'price' => 168.00, // INR value represented or decimal
                'date_available' => now()->subDays(10),
            ],
            [
                'title' => 'Tata Tea Premium (1kg)',
                'description' => '<p>India\'s favorite cup of chai! Tata Tea Premium offers a rich, full-bodied blend of Assam orthodox leaves and CTC tea to kickstart the day.</p>',
                'price' => 420.00,
                'date_available' => now()->subDays(5),
            ],
            [
                'title' => 'Amul Pure Ghee (1 Litre)',
                'description' => '<p>Pure cow milk ghee from the house of Amul. Known for its rich aroma, granular texture, and traditional taste. A staple in Indian cooking and festive recipes.</p>',
                'price' => 690.00,
                'date_available' => now()->subDays(2),
            ],
            [
                'title' => 'Parachute Pure Coconut Oil (500ml)',
                'description' => '<p>100% pure coconut oil made from premium, naturally sun-dried coconuts. Widely used in India for daily hair nourishment, skin care, and traditional cooking.</p>',
                'price' => 210.00,
                'date_available' => now(),
            ],
            [
                'title' => 'Parle-G Gluco Biscuits (Pack of 24)',
                'description' => '<p>The world\'s largest-selling biscuit brand! Loved across India for generations, these glucose-rich biscuits are the ultimate companion to a hot cup of tea.</p>',
                'price' => 120.00,
                'date_available' => now()->subDays(15),
            ],
            [
                'title' => 'Bru Instant Coffee (200g)',
                'description' => '<p>India\'s first instant coffee-chicory mix. Made from a fine blend of the choicest plantation and Robusta beans, offering a rich aroma and classic South Indian taste.</p>',
                'price' => 380.00,
                'date_available' => now()->subDays(8),
            ],
            [
                'title' => 'MDH Deggi Mirch Chilli Powder (500g)',
                'description' => '<p>A unique blend of hot red pepper and Kashmiri red chilies that adds mild heat, rich flavor, and a deep red color to classic Indian curries and gravies.</p>',
                'price' => 290.00,
                'date_available' => now()->subDays(4),
            ],
            [
                'title' => 'Daawat Rozana Basmati Rice (5kg)',
                'description' => '<p>Naturally aged, long-grain basmati rice. Offers a delightful aroma, fluffy texture, and a rich taste perfect for daily biryani, pulao, and steam rice.</p>',
                'price' => 450.00,
                'date_available' => now()->addDays(2), // Upcoming product
            ],
            [
                'title' => 'Santoor Sandal & Turmeric Soap (4-Pack)',
                'description' => '<p>One of India\'s leading sandal soap brands. Enriched with natural sandalwood and turmeric extracts to keep skin glowing, smooth, and looking youthful.</p>',
                'price' => 195.00,
                'date_available' => now()->subDays(6),
            ],
            [
                'title' => 'Hawkins Classic Aluminium Pressure Cooker (5 Litre)',
                'description' => '<p>An indispensable cooking appliance in Indian kitchens. Safe, reliable, and highly durable, perfect for boiling lentils (dal), rice, and cooking vegetables quickly.</p>',
                'price' => 2199.00,
                'date_available' => now()->addDays(5), // Upcoming product
            ],
            [
                'title' => 'Dettol Liquid Antiseptic (1 Litre)',
                'description' => '<p>A trusted household brand in India for first aid, personal hygiene, and surface disinfection to keep families safe and germ-free.</p>',
                'price' => 380.00,
                'date_available' => now()->subDays(12),
            ],
            [
                'title' => 'Cadbury Dairy Milk Silk Chocolate (150g)',
                'description' => '<p>India\'s most loved premium chocolate bar. Rich, smooth, and intensely creamy, perfect for celebrating special moments, sharing, and festive gifting.</p>',
                'price' => 175.00,
                'date_available' => now()->subDays(1),
            ],
        ];

        foreach ($indianProducts as $productData) {
            Product::create($productData);
        }
    }
}
