<?php

use Faker\Factory;
use Illuminate\Database\Seeder;

use App\User;

class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $faker = Factory::create();
    $roles = ['admin', 'moderator', 'user'];

    foreach ($roles as $role) {
      $user = User::create([
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,

        'email' => $role . '@example.org',
        'password' => Hash::make('password'),
        'role' => $role,

        'verified_at' => now(),
      ]);

      $user->save();
    }
  }
}
