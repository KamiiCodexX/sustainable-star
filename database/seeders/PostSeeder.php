<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $posts = [
            [
                'owner_id' => 1,
                'text' => 'This is post 1',
                'posted_by' => 'user',
            ],
            [
                'owner_id' => 2,
                'text' => 'This is post 2',
                'posted_by' => 'company',
            ]
        ];

        Post::insert($posts);
    }
}
