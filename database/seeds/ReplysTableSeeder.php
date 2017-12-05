<?php

use App\Models\Topic;
use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Reply;
use Faker\Generator;

class ReplysTableSeeder extends Seeder
{
    public function run()
    {
        $user_ids = User::all()->pluck('id')->toArray();
        $topic_ids = Topic::all()->pluck('id')->toArray();

        $faker = app(Generator::class);

        $replys = factory(Reply::class)
            ->times(1000)
            ->make()
            ->each(function ($reply, $index) use ($user_ids, $topic_ids, $faker) {
                $reply->user_id = $faker->randomElement($user_ids);
                $reply->topic_id = $faker->randomElement($topic_ids);
        });

        Reply::insert($replys->toArray());


        DB::update('update (topics, (select topic_id, count(*) as c from replies group by topic_id) as replys) SET topics.`reply_count`=replys.c where replys.topic_id=topics.id;');
        DB::update('update topics set `last_reply_user_id`=(select user_id from replies where replies.topic_id=topics.id order by `created_at` desc limit 1);');
    }

}

