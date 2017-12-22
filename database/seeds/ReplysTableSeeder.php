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

        $sql_set_reply_count = 'update (topics, (select topic_id, count(*) as c from replies group by topic_id) as replys) SET topics.`reply_count`=replys.c where replys.topic_id=topics.id';
        $sql_set_last_reply_user_id = 'update topics set `last_reply_user_id`=(select user_id from replies where replies.topic_id=topics.id order by `created_at` desc limit 1);';
        $sql_set_reply_number = <<<EOT
UPDATE `replies` INNER JOIN 
 (SELECT `id`, `topic_id`,
   @level:=CASE WHEN @topic <> `topic_id` THEN 1 ELSE @level+1 END AS num,
   @topic:=`topic_id` AS clset
FROM
  (SELECT @level:= 0) s,
  (SELECT @topic:= 0) c,
  (SELECT `topic_id`, `id`
   FROM replies
   ORDER BY `topic_id`, `id`
  ) t ) AS r SET replies.number=r.num WHERE replies.id=r.id;
EOT;

        DB::update($sql_set_reply_count);
        DB::update($sql_set_last_reply_user_id);
        DB::update($sql_set_reply_number);
    }

}

