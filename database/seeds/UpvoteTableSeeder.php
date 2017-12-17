<?php

use App\Models\Topic;
use App\Models\Upvote;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Generator;

class UpvoteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_ids = User::all()->pluck('id')->toArray();
        $topic_ids = Topic::all()->pluck('id')->toArray();

        $faker = app(Generator::class);

        $upvotes = factory(Upvote::class)
            ->times(1400)
            ->make()
            ->each(function ($upvote) use ($user_ids, $topic_ids, $faker) {
                $upvote->user_id = $faker->randomElement($user_ids);
                $upvote->topic_id = $faker->randomElement($topic_ids);
            });

        Upvote::insert($upvotes->toArray());

        DB::update('update (topics, (select topic_id, count(*) as c from topics_upvotes group by topic_id) as upvotes) SET topics.`upvote_count`=upvotes.c where upvotes.topic_id=topics.id;');

    }
}
