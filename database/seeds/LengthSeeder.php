<?php

use Illuminate\Database\Seeder;

class LengthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $length_unit = new App\Models\LengthUnit;
        $length_unit->name = "Seg";
        $length_unit->value = 0;
        $length_unit->length_unit_id = null;
        $length_unit->save();

        $length_unit = new App\Models\LengthUnit;
        $length_unit->name = "Min";
        $length_unit->value = 60;
        $length_unit->length_unit_id = 1;
        $length_unit->save();

        $length_unit = new App\Models\LengthUnit;
        $length_unit->name = "Hr";
        $length_unit->value = 60;
        $length_unit->length_unit_id = 2;
        $length_unit->save();

        $length_unit = new App\Models\LengthUnit;
        $length_unit->name = "Día";
        $length_unit->value = 24;
        $length_unit->length_unit_id = 3;
        $length_unit->save();

        $length_unit = new App\Models\LengthUnit;
        $length_unit->name = "Semana";
        $length_unit->value = 7;
        $length_unit->length_unit_id = 4;
        $length_unit->save();

        $length_unit = new App\Models\LengthUnit;
        $length_unit->name = "Mes";
        $length_unit->value = 30;
        $length_unit->length_unit_id = 4;
        $length_unit->save();

        $length_unit = new App\Models\LengthUnit;
        $length_unit->name = "Año";
        $length_unit->value = 12;
        $length_unit->length_unit_id = 6;
        $length_unit->save();
    }
}
