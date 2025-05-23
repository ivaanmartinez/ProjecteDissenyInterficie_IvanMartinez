<?php

namespace Tests\Feature\Videos;

use App\Helpers\DefaultVideoHelper;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Team;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class VideosManageControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        create_permissions();
    }

    public function test_user_with_permissions_can_manage_videos()
    {
        $videoManager = $this->loginAsVideoManager();

        $video1 = DefaultVideoHelper::createDefaultVideo();
        $video2 = DefaultVideoHelper::createDefaultVideo2();
        $video3 = DefaultVideoHelper::createDefaultVideo3();


        $response = $this->actingAs($videoManager)->get(route('videos.manage.index'));

        $response->assertStatus(200);

        $response->assertSee($video1->title);
        $response->assertSee($video2->title);
        $response->assertSee($video3->title);
    }

    public function test_regular_users_cannot_manage_videos()
    {
        $regularUser = $this->loginAsRegularUser();

        $response = $this->actingAs($regularUser)->get(route('videos.manage.index'));

        $response->assertStatus(403);
    }

    public function test_guest_users_cannot_manage_videos()
    {
        $response = $this->get(route('videos.manage.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_superadmins_can_manage_videos()
    {
        $superAdmin = $this->loginAsSuperAdmin();

        $response = $this->actingAs($superAdmin)->get(route('videos.manage.index'));

        $response->assertStatus(200);
    }

    private function loginAsVideoManager()
    {
        $user = create_video_manager_user();
        $user->save();

        $user->assignRole('video_manager');
        return $user;
    }

    private function loginAsSuperAdmin()
    {
        $user = create_superadmin_user();
        $user->save();

        $user->assignRole('super_admin');
        return $user;
    }

    private function loginAsRegularUser()
    {
        $user = create_regular_user();
        $user->save();

        $user->assignRole('regular');
        return $user;
    }public function test_can_create_default_user_and_professor()
    {
        $teamDefaultUser = Team::factory()->create();
        $teamProfessor = Team::factory()->create();

        $defaultUser = createDefaultUser();
        $defaultUser->current_team_id = $teamDefaultUser->id;
        $defaultUser->save();

        $professorUser = createDefaultTeacher();
        $professorUser->current_team_id = $teamProfessor->id;
        $professorUser->save();

        $this->assertNotNull($defaultUser);
        $this->assertNotNull($professorUser);

        $this->assertTrue(Hash::check('password123', $defaultUser->password));
        $this->assertTrue(Hash::check('password123', $professorUser->password));

        $this->assertEquals($teamDefaultUser->id, $defaultUser->current_team_id);
        $this->assertEquals($teamProfessor->id, $professorUser->current_team_id);
    }

    public function test_user_with_permissions_can_see_add_videos()
    {
        $videoManager = $this->loginAsVideoManager();

        $response = $this->actingAs($videoManager)->get(route('videos.manage.create'));

        $response->assertStatus(200);
    }

    public function test_user_without_permissions_cannot_see_add_videos()
    {
        $regularUser = $this->loginAsRegularUser();

        $response = $this->actingAs($regularUser)->get(route('videos.manage.create'));

        $response->assertStatus(403);
    }

    public function test_user_with_permissions_can_store_videos()
    {
        $videoData = [
            'title' => 'Nou Video de Prova',
            'description' => 'Descripció del vídeo de prova.',
            'url' => 'https://www.youtube.com/watch?v=example',
            'published_at' => now(),
            'previous' => null,
            'next' => null,
            'series_id' => null,
        ];

        $videoManager = $this->loginAsVideoManager();

        $response = $this->actingAs($videoManager)->post(route('videos.manage.store'), $videoData);

        $response->assertStatus(302);
        $response->assertRedirect(route('videos.manage.index'));

        $this->assertDatabaseHas('videos', [
            'title' => $videoData['title'],
            'description' => $videoData['description'],
            'url' => $videoData['url'],
        ]);
    }

    public function test_user_without_permissions_cannot_store_videos()
    {
        $videoData = [
            'title' => 'Nou Video de Prova',
            'description' => 'Descripció del vídeo de prova.',
            'url' => 'https://www.youtube.com/watch?v=example',
            'published_at' => now(),
        ];

        $regularUser = $this->loginAsRegularUser();

        $response = $this->actingAs($regularUser)->post(route('videos.manage.store'), $videoData);

        $response->assertStatus(403);

        $this->assertDatabaseMissing('videos', [
            'title' => $videoData['title'],
            'description' => $videoData['description'],
            'url' => $videoData['url'],
        ]);
    }

    public function test_user_with_permissions_can_destroy_videos()
    {
        $videoManager = $this->loginAsVideoManager();

        $video = Video::create([
            'title' => 'Video de prova',
            'description' => 'Descripció del vídeo de prova.',
            'url' => 'https://www.youtube.com/watch?v=example',
            'published_at' => now(),
            'user_id' => $videoManager->id, // Ensure user_id is set
        ]);

        $response = $this->actingAs($videoManager)->delete(route('videos.manage.destroy', $video->id));

        $response->assertRedirect(route('videos.manage.index'));

        $this->assertDatabaseMissing('videos', [
            'id' => $video->id,
        ]);
    }

    public function test_user_without_permissions_cannot_destroy_videos()
    {
        $videoManager = $this->loginAsVideoManager();

        $video = Video::create([
            'title' => 'Video de prova',
            'description' => 'Descripció del vídeo de prova.',
            'url' => 'https://www.youtube.com/watch?v=example',
            'published_at' => now(),
            'user_id' => $videoManager->id, // Ensure user_id is set
        ]);

        $regularUser = $this->loginAsRegularUser();

        $response = $this->actingAs($regularUser)->delete(route('videos.manage.destroy', $video->id));

        $response->assertStatus(403);

        $this->assertDatabaseHas('videos', [
            'id' => $video->id,
        ]);
    }

    public function test_user_with_permissions_can_see_edit_videos()
    {
        $videoManager = $this->loginAsVideoManager();

        $video = Video::create([
            'title' => 'Video de prova',
            'description' => 'Descripció del vídeo de prova.',
            'url' => 'https://www.youtube.com/watch?v=example',
            'published_at' => now(),
            'user_id' => $videoManager->id, // Ensure user_id is set
        ]);

        $response = $this->actingAs($videoManager)->get(route('videos.manage.edit', $video->id));

        $response->assertStatus(200);

        $response->assertSee($video->title);
    }

    public function test_user_without_permissions_cannot_see_edit_videos()
    {
        $regularUser = $this->loginAsRegularUser();

        $video = Video::create([
            'title' => 'Video de prova',
            'description' => 'Descripció del vídeo de prova.',
            'url' => 'https://www.youtube.com/watch?v=example',
            'published_at' => now(),
            'user_id' => $regularUser->id, // Ensure user_id is set
        ]);

        $response = $this->actingAs($regularUser)->get(route('videos.manage.edit', $video->id));

        $response->assertStatus(403);
    }

    public function test_user_with_permissions_can_update_videos()
    {
        $videoManager = $this->loginAsVideoManager();

        $video = Video::create([
            'title' => 'Video de prova',
            'description' => 'Descripció del vídeo de prova.',
            'url' => 'https://www.youtube.com/watch?v=example',
            'published_at' => now(),
            'user_id' => $videoManager->id, // Ensure user_id is set
        ]);


        $response = $this->actingAs($videoManager)->put(route('videos.manage.update', $video->id), [
            'title' => 'Títol actualitzat',
            'description' => 'Descripció actualitzada del vídeo.',
            'url' => 'https://www.youtube.com/watch?v=updatedexample',
            'published_at' => now(),
            'previous' => null,
            'next' => null,
            'series_id' => null,
        ]);

        $response->assertStatus(302);

        $updatedVideo = Video::find($video->id);
        $this->assertEquals('Títol actualitzat', $updatedVideo->title);
        $this->assertEquals('Descripció actualitzada del vídeo.', $updatedVideo->description);
        $this->assertEquals('https://www.youtube.com/watch?v=updatedexample', $updatedVideo->url);
    }

    public function test_user_without_permissions_cannot_update_videos()
    {
        $regularUser = $this->loginAsRegularUser();

        $video = Video::create([
            'title' => 'Video de prova',
            'description' => 'Descripció del vídeo de prova.',
            'url' => 'https://www.youtube.com/watch?v=example',
            'published_at' => now(),
            'user_id' => $regularUser->id, // Ensure user_id is set
        ]);

        $response = $this->actingAs($regularUser)->put(route('videos.manage.update', $video->id), [
            'title' => 'Títol actualitzat',
            'description' => 'Descripció actualitzada del vídeo.',
            'url' => 'https://www.youtube.com/watch?v=updatedexample',
            'published_at' => now(),
        ]);

        $response->assertStatus(403);

        $updatedVideo = Video::find($video->id);
        $this->assertEquals('Video de prova', $updatedVideo->title);
        $this->assertEquals('Descripció del vídeo de prova.', $updatedVideo->description);
        $this->assertEquals('https://www.youtube.com/watch?v=example', $updatedVideo->url);
    }
}
