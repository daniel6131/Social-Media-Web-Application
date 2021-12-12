<?php

namespace Database\Seeders;
use App\Models\Post;
use Illuminate\Database\Seeder;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $p = new Post;
        $p->postContent = "TestPostContent";
        $p->user_id = 1;
        $p->save();

        $posts = Post::factory()->count(15)->create();
    }
}
