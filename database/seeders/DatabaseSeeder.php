<?php

namespace Database\Seeders;

use App\Helpers\DefaultVideoHelper;
use App\Helpers\SeriesHelper;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use function Laravel\Prompts\password;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        create_permissions();

        $superAdmin = create_superadmin_user();
        $regularUser = create_regular_user();
        $videoManager = create_video_manager_user();

        $superAdmin->save();
        $regularUser->save();
        $videoManager->save();

        $superAdmin->refresh()->assignRole('super_admin');
        $regularUser->refresh()->assignRole('regular');
        $videoManager->refresh()->assignRole('video_manager');


        createDefaultTeacher();
        createDefaultUser();

        DefaultVideoHelper::createDefaultVideo();
        DefaultVideoHelper::createDefaultVideo2();
        DefaultVideoHelper::createDefaultVideo3();
        SeriesHelper::createDefaultSerie1();
        SeriesHelper::createDefaultSerie2();
        SeriesHelper::createDefaultSerie3();
    }
}
