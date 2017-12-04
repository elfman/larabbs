<?php

use App\Handlers\SlugTranslateHandler;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Topic;

class TopicsTableSeeder extends Seeder
{
    public function run()
    {
        $user_ids = User::all()->pluck('id')->toArray();
        $category_ids = Category::all()->pluck('id')->toArray();

        $faker = app(\Faker\Generator::class);

        $handler = app(SlugTranslateHandler::class);

        $topics = factory(Topic::class)
            ->times(50)
            ->make()
            ->each(function ($topic, $index) use ($user_ids, $category_ids, $faker, $handler) {
            $topic->user_id = $faker->randomElement($user_ids);
            $topic->category_id = $faker->randomElement($category_ids);
            $topic->slug = $handler->translate($topic->title);
        });

        Topic::insert($topics->toArray());
    }

}

