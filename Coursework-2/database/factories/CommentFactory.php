<?php

namespace Database\Factories;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'commentBody' => $this->faker->realText(100),
            'commentable_id' => User::all()->random()->id,
            'commentable_type' => 'App\Models\UserProfile',
            'post_id' => Post::all()->random()->id,
        ];
    }
}
