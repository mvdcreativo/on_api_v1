<?php

use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currency = new App\Models\Currency;
        $currency->name = "Dolares Americanos";
        $currency->symbol = "USD";
        $currency->value = 1;
        $currency->save();

        $currency = new App\Models\Currency;
        $currency->name = "Pesos Uruguayos";
        $currency->symbol = "$";
        $currency->value = 0.0125;
        $currency->save();
    }
}
