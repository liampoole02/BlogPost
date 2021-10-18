<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $posts = \App\Models\BlogPost::all();

        if($posts->count()===0){
            $this->command->info('THere are no blog posts, no commnets will be added');
            return;
        }

        $commentsCount=(int) $this->command->ask('How many comments would you like', 150);

        \App\Models\Comment::factory($commentsCount)->make()->each(function ($comment) use ($posts) {
            $comment->blog_post_id = $posts->random()->id;
            $comment->save();
        });
    }
}
