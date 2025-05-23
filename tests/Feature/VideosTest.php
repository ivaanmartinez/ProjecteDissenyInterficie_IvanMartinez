<?php

namespace Tests\Feature\Videos;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Video;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VideosTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        create_permissions();
    }

    public function test_users_can_view_videos()
    {
        // Crear un usuario en la base de datos
        $user = User::factory()->create(['id' => 1]);

        // Crear un video en la base de datos
        $video = Video::create([
            'title' => 'Video de prueba',
            'description' => 'Descripción del video',
            'url' => 'https://www.youtube.com/watch?v=gsLvizl5j4E&ab_channel=Mattye',
            'published_at' => Carbon::now(),
            'user_id' => $user->id,
        ]);

        // Realizar una petición GET al endpoint de video
        $response = $this->get(route('videos.show', $video->id));

        // Verificar que la respuesta es exitosa y contiene el título del video
        $response->assertStatus(200);
        $response->assertSee($video->title);
    }

    public function test_users_cannot_view_not_existing_videos()
    {
        // Intentar acceder a un video inexistente
        $response = $this->get(route('videos.show', 999));

        // Verificar que se obtiene un error 404
        $response->assertStatus(404);
    }

    public function test_user_without_permissions_can_see_default_videos_page()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('videos.index'));

        $response->assertStatus(200);
        $response->assertSee('Videos');
    }

    public function test_user_with_permissions_can_see_default_videos_page()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('manage videos');

        $response = $this->actingAs($user)->get(route('videos.index'));

        $response->assertStatus(200);
        $response->assertSee('Videos');
    }

    public function test_not_logged_users_can_see_default_videos_page()
    {
        $response = $this->get(route('videos.index'));

        $response->assertStatus(200);
        $response->assertSee('Videos');
    }
}
