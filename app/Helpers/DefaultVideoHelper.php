<?php

namespace App\Helpers;

use App\Models\User;
use App\Models\Video;
use Carbon\Carbon;
class DefaultVideoHelper
{
    public static function createDefaultVideo(array $overrides = []){
        $defaultUserId = User::first()->id ?? User::factory()->create()->id;
        $defaultData = [
            'title' => '100 Best Rocket Goals of the 2024/25 Season',
            'description' => 'This is a default video',
            'url' => 'https://www.youtube.com/embed/smPuJ4GAOfg',
            'published_at' => Carbon::now()->toDateTimeString(),
            'previous' => null,
            'next' => null,
            'series_id' => 1,
            'user_id' => $defaultUserId,

        ];

        $data = array_merge($defaultData, $overrides);

        return Video::create($data);
    }
    public static function createDefaultVideo2(array $overrides = []){
        $defaultUserId = User::first()->id ?? User::factory()->create()->id;
        $defaultData = [
            'title' => 'Top 10 Dribblers 2024',
            'description' => 'This is a default video 2',
            'url' => 'https://www.youtube.com/embed/septqqbBVmo',
            'published_at' => Carbon::now()->toDateTimeString(),
            'previous' => null,
            'next' => null,
            'series_id' => 1,
            'user_id' => $defaultUserId

        ];

        $data = array_merge($defaultData, $overrides);

        return Video::create($data);
    }
    public static function createDefaultVideo3(array $overrides = []){
        $defaultUserId = User::first()->id ?? User::factory()->create()->id;
        $defaultData = [
            'title' => 'Toni Kroos Master Of Simplicity',
            'description' => 'This is a default video 3',
            'url' => 'https://www.youtube.com/embed/Fr-PZ1utSBY',
            'published_at' => Carbon::now()->toDateTimeString(),
            'previous' => null,
            'next' => null,
            'series_id' => 1,
            'user_id' => $defaultUserId
        ];

        $data = array_merge($defaultData, $overrides);

        return Video::create($data);
    }

}
