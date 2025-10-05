<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $customerUsers = User::where('role', 'customer')->get();
        $products = Product::all();

        if ($customerUsers->isEmpty() || $products->isEmpty()) {
            $this->command->info('No customers or products found. Skipping order seeding.');
            return;
        }

        for ($i = 0; $i < 12; $i++) {
            $orderDate = $faker->dateTimeBetween('-2 weeks', 'now');
            $status = $faker->randomElement(['pending', 'completed']);
            $totalAmount = 0;

            DB::transaction(function () use ($faker, $customerUsers, $products, $orderDate, $status, &$totalAmount) {
                $user = $faker->randomElement($customerUsers);

                $order = Order::create([
                    'user_id' => $user->id,
                    'total_amount' => 0,
                    'status' => $status,
                    'created_at' => $orderDate,
                    'updated_at' => $orderDate,
                ]);

                $numItems = $faker->numberBetween(1, 3);
                $selectedProducts = $products->random($numItems);

                foreach ($selectedProducts as $product) {
                    $quantity = $faker->numberBetween(1, min(3, $product->stock)); 

                    if ($quantity > 0 && $product->stock >= $quantity) {
                        OrderItem::create([
                            'order_id' => $order->id,
                            'product_id' => $product->id,
                            'quantity' => $quantity,
                            'unit_price' => $product->price,
                            'line_total' => $product->price * $quantity,
                            'created_at' => $orderDate,
                            'updated_at' => $orderDate,
                        ]);

                        $product->decrement('stock', $quantity);
                        $totalAmount += ($product->price * $quantity);
                    }
                }


                $order->update(['total_amount' => $totalAmount]);
            });
        }
    }
}
