<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name= "Admin";
        $lastName = "";
        $user = new App\User;
        $user->name = $name;
        $user->last_name = $lastName;
        $user->slug = Str::slug($name." ".$lastName);
        $user->email = "admin@admin.com";
        $user->password = Hash::make('admin');
        $user->save();

        $name= "Emir Méndez";
        $lastName = "";
        $user = new App\User;
        $user->name = $name;
        $user->last_name = $lastName;
        $user->slug = Str::slug($name." ".$lastName);        
        $user->email = "mvdcreativo@gmail.com";
        $user->password = Hash::make('admin');
        $user->save();

        factory(App\User::class, 10)->create()->each(
            function(App\User $user ){
                factory(App\Models\Account::class)->create([
                    'user_id' => $user->id
                ]);
            }
        );
    }
}
