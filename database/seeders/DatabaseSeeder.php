<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if ($this->command->confirm('Do you want to refresh the database?')) {
            $this->command->call('migrate:refresh');
            $this->command->info('Database was refreshed');
        }

        $this->call([
            UsersTableSeeder::class,
            BlogPostsSeeder::class,
            CommentSeeder::class,
            TagsTableSeeder::class,
            BlogPostTagTableSeeder::class
        ]);
        // \App\Models\User::factory(10)->create();
        // DB::table('users')->insert(
        //     [
        //         'name' => 'Ashley the clown',
        //         'email' => 'development@jumpingfoxsoftware.com',
        //         'email_verified_at' => now(),
        //         'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        //         'remember_token' => Str::random(10),
        //     ]
        // );
    }
}
