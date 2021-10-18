<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BlogPostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $blogCount=(int)$this->command->ask('How many blog would you like?', 20);
        $users = \App\Models\User::all();

        \App\Models\BlogPost::factory($blogCount)->make()->each(function ($post) use ($users) {
            // dd($post);
            $post->user_id = $users->random()->id;
            $post->save();
        });
    }
}
