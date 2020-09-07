<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 5)->create();

        factory(App\Contact::class, 5)->create(['user_id' => 1]);
        factory(App\Contact::class, 10)->create(['user_id' => 2]);
        factory(App\Contact::class, 15)->create(['user_id' => 3]);
        factory(App\Contact::class, 10)->create(['user_id' => 4]);
        factory(App\Contact::class, 5)->create(['user_id' => 5]);

        factory(App\Group::class, 15)->create(['user_id' => 5]);
        factory(App\Group::class, 10)->create(['user_id' => 4]);
        factory(App\Group::class, 5)->create(['user_id' => 3]);
        factory(App\Group::class, 10)->create(['user_id' => 2]);
        factory(App\Group::class, 15)->create(['user_id' => 1]);
    }
}
