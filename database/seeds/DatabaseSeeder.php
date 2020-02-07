<?php

use App\Comment;
use App\Feed;
use App\Like;
use Illuminate\Database\Seeder;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//user db seed;
        User::create([
            'name' => 'thet',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin12'),
        ]);
        // $this->call(UsersTableSeeder::class);
        Feed::create([
            'user_id' => 1,
            'description' => 'Hello world',
            'image' => 'feed/default.png',
        ]);
        Comment::create([
            'user_id' => 1,
            'feed_id' => 1,
            'comment' => 'good to go',
        ]);
        Like::create([
            'user_id' => 1,
            'feed_id' => 1,

        ]);
    }
}


