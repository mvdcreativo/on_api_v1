<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $name = "Activo";
        // $status = new App\Models\Status;
        // $status->name = $name;
        // $status->slug = Str::slug($name);
        // $status->for = "CURSOS";
        // $status->save();

        // $name = "Inactivo";
        // $status = new App\Models\Status;
        // $status->name = $name;
        // $status->slug = Str::slug($name);
        // $status->for = "CURSOS";
        // $status->save();

        // $name = "Destacado";
        // $status = new App\Models\Status;
        // $status->name = $name;
        // $status->slug = Str::slug($name);
        // $status->for = "CURSOS";
        // $status->save();

        // $status = new App\Models\Status([
        //     'name' => "Pago en Proceso",
        //     'slug' => "payment_in_process",
        //     'for'  => "ORDERS"
        // ]);
        // $status->save();
        // $status = new App\Models\Status([
        //     'name' => "Pendiente de Pago",
        //     'slug' => "payment_required",
        //     'for'  => "ORDERS"
        // ]);
        // $status->save();
        // $status = new App\Models\Status([
        //     'name' => "Pago",
        //     'slug' => 'paid',
        //     'for'  => "ORDERS"
        // ]);
        // $status->save();

        // $status = new App\Models\Status([
        //     'name' => "Reintegrado",
        //     'slug' => "reverted",
        //     'for'  => "ORDERS"
        // ]);
        // $status->save();
        // $status = new App\Models\Status([
        //     'name' => "Reintegrado Parcial",
        //     'slug' => "partially_reverted",
        //     'for'  => "ORDERS"
        // ]);
        // $status->save();
        // $status = new App\Models\Status([
        //     'name' => "Pago Parcial",
        //     'slug' => "partially_paid",
        //     'for'  => "ORDERS"
        // ]);
        // $status->save();
        // $status = new App\Models\Status([
        //     'name' => "Indefinido",
        //     'slug' => "undefined",
        //     'for'  => "ORDERS"
        // ]);
        // $status->save();
        
        $status = new App\Models\Status([
            'name' => "Pago en local",
            'slug' => "pago_en_local",
            'for'  => "ORDERS"
        ]);
        $status->save();

    }
}
