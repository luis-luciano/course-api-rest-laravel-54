<?php

use App\Category;
use App\Product;
use App\Transaction;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        User::truncate();
        Category::truncate();
        Product::truncate();
        Transaction::truncate();
        DB::table('category_product')->truncate();

        // Desactiva el disparo de los eventos evitando sobrecarga en la generacion de datos
        User::flushEventListeners();
        Category::flushEventListeners();
        Product::flushEventListeners();
        Transaction::flushEventListeners();

        factory(User::class, 200)->create();
        factory(Category::class, 30)->create();
        factory(Product::class, 1000)->create();
        factory(Transaction::class, 1000)->create()->each(function ($transaction) {
            $categories = Category::all()->random(mt_rand(1, 5))->pluck('id');

            $transaction->product->categories()->attach($categories);
        });
        //$this->call(UsersTableSeeder::class);
    }
}
