<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsTableSeeder extends Seeder
{
    public function run(): void
    {
        $categories = ['Electronics', 'Books', 'Clothing', 'Home & Kitchen'];

        $products = [
            ['Smartphone', 699.99, 50, 'Latest smartphone with OLED display.', 'https://images.pexels.com/photos/404280/pexels-photo-404280.jpeg', 'Electronics'],
            ['Laptop', 1299.99, 30, 'High performance laptop.', 'https://images.pexels.com/photos/18105/pexels-photo.jpg', 'Electronics'],
            ['Wireless Headphones', 199.99, 100, 'Noise-cancelling headphones.', 'https://images.pexels.com/photos/1649771/pexels-photo-1649771.jpeg', 'Electronics'],
            ['Bluetooth Speaker', 99.99, 80, 'Portable speaker with deep bass.', 'https://images.pexels.com/photos/14309806/pexels-photo-14309806.jpeg', 'Electronics'],
            ['Tablet', 399.99, 25, '10-inch tablet for reading and media.', 'https://images.pexels.com/photos/1334597/pexels-photo-1334597.jpeg', 'Electronics'],
            
            ['Men\'s T-Shirt', 19.99, 200, 'Comfortable cotton t-shirt.', 'https://images.pexels.com/photos/8532616/pexels-photo-8532616.jpeg', 'Clothing'],
            ['Women\'s Dress', 49.99, 120, 'Elegant summer dress.', 'https://images.pexels.com/photos/985635/pexels-photo-985635.jpeg', 'Clothing'],
            ['Jeans', 39.99, 100, 'Stylish slim-fit jeans.', 'https://images.pexels.com/photos/1082528/pexels-photo-1082528.jpeg', 'Clothing'],
            ['Jacket', 79.99, 60, 'Warm winter jacket.', 'https://images.pexels.com/photos/16170/pexels-photo.jpg', 'Clothing'],
            ['Sneakers', 59.99, 150, 'Comfortable running sneakers.', 'https://images.pexels.com/photos/2529148/pexels-photo-2529148.jpeg', 'Clothing'],

            ['Coffee Maker', 59.99, 40, 'Automatic drip coffee maker.', 'https://images.pexels.com/photos/25471386/pexels-photo-25471386.jpeg', 'Home & Kitchen'],
            ['Blender', 39.99, 50, 'High-speed blender for smoothies.', 'https://images.pexels.com/photos/3094227/pexels-photo-3094227.jpeg', 'Home & Kitchen'],
            ['Vacuum Cleaner', 129.99, 20, 'Powerful vacuum for home cleaning.', 'https://images.pexels.com/photos/844874/pexels-photo-844874.jpeg', 'Home & Kitchen'],
            ['Cookware Set', 99.99, 30, 'Non-stick cookware set.', 'https://images.pexels.com/photos/30981356/pexels-photo-30981356.jpeg', 'Home & Kitchen'],
            ['Desk Lamp', 29.99, 45, 'LED with adjustable brightness.', 'https://images.pexels.com/photos/1112598/pexels-photo-1112598.jpeg', 'Home & Kitchen'],
            ['Air Fryer', 89.99, 35, 'Healthy cooking with less oil.', 'https://images.pexels.com/photos/29461935/pexels-photo-29461935.jpeg', 'Home & Kitchen'],
        ];

        foreach ($products as $p) {
            Product::create([
                'name' => $p[0],
                'price' => $p[1],
                'stock' => $p[2],
                'description' => $p[3],
                'image_url' => $p[4],
                'category' => $p[5],
            ]);
        }
    }
}
