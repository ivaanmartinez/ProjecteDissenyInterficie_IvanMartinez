<?php

namespace Tests\Feature\Series;

use App\Helpers\SeriesHelper;
use App\Models\User;
use App\Models\Serie;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

class SeriesManageControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        create_permissions();
    }

    // Helper functions to log in as different types of users
    public function loginAsVideoManager(): void
    {
        $user = User::factory()->create();
        $user->assignRole('video_manager');
        $this->actingAs($user);
    }

    public function loginAsSuperAdmin(): void
    {
        $user = User::factory()->create();
        $user->assignRole('super_admin');
        $this->actingAs($user);
    }

    public function loginAsRegularUser(): void
    {
        $user = User::factory()->create();
        $user->assignRole('regular');
        $this->actingAs($user);
    }

    /** @test */
    public function user_with_permissions_can_see_add_series()
    {
        $this->loginAsSuperAdmin();
        $response = $this->get(route('series.manage.create'));
        $response->assertStatus(200);
    }

    /** @test */
    public function user_without_series_manage_create_cannot_see_add_series()
    {
        $this->loginAsRegularUser();
        $response = $this->get(route('series.manage.create'));
        $response->assertStatus(403);
    }

    /** @test */
    public function user_with_permissions_can_store_series()
    {
        $this->loginAsSuperAdmin();
        $response = $this->post(route('series.manage.store'), [
            'title' => 'Test Series',
            'description' => 'Test description',
            // other fields
        ]);
        $response->assertRedirect(route('series.manage.index'));
        $this->assertDatabaseHas('series', ['title' => 'Test Series']);
    }

    /** @test */
    public function user_without_permissions_cannot_store_series()
    {
        $this->loginAsRegularUser();
        $response = $this->post(route('series.manage.store'), [
            'title' => 'Test Series',
            'description' => 'Test description',
            // other fields
        ]);
        $response->assertStatus(403);
    }

    /** @test */
    public function user_with_permissions_can_destroy_series()
    {
        $this->loginAsSuperAdmin();
        $serie = SeriesHelper::createDefaultSerie1();
        $response = $this->delete(route('series.manage.destroy', $serie));
        $response->assertRedirect(route('series.manage.index'));
        $this->assertDatabaseMissing('series', ['id' => $serie->id]);
    }

    /** @test */
    public function user_without_permissions_cannot_destroy_series()
    {
        $this->loginAsRegularUser();
        $serie = SeriesHelper::createDefaultSerie1();
        $response = $this->delete(route('series.manage.destroy', $serie));
        $response->assertStatus(403);
    }

    /** @test */
    public function user_with_permissions_can_see_edit_series()
    {
        $this->loginAsSuperAdmin();
        $serie = SeriesHelper::createDefaultSerie1();
        $response = $this->get(route('series.manage.edit', $serie));
        $response->assertStatus(200);
    }

    public function user_without_permissions_cannot_see_edit_series()
    {
        $this->loginAsRegularUser();
        $serie = SeriesHelper::createDefaultSerie1();
        $response = $this->get(route('series.manage.edit', $serie));
        $response->assertStatus(403);
    }

    /** @test */
    public function user_with_permissions_can_update_series()
    {
        $this->loginAsSuperAdmin();
        $serie = SeriesHelper::createDefaultSerie1();
        $response = $this->put(route('series.manage.update', $serie), [
            'title' => 'Updated Title',
            'description' => 'Updated description',
            // other fields
        ]);
        $response->assertRedirect(route('series.manage.index'));
        $this->assertDatabaseHas('series', ['title' => 'Updated Title']);
    }

    /** @test */
    public function user_without_permissions_cannot_update_series()
    {
        $this->loginAsRegularUser();
        $serie = SeriesHelper::createDefaultSerie1();
        $response = $this->put(route('series.manage.update', $serie), [
            'title' => 'Updated Title',
            'description' => 'Updated description',
            // other fields
        ]);
        $response->assertStatus(403);
    }

    /** @test */
    public function user_with_permissions_can_manage_series()
    {
        $this->loginAsSuperAdmin();
        $response = $this->get(route('series.manage.index'));
        $response->assertStatus(200);
    }

    /** @test */
    public function regular_users_cannot_manage_series()
    {
        $this->loginAsRegularUser();
        $response = $this->get(route('series.manage.index'));
        $response->assertStatus(403);
    }

    /** @test */
    public function guest_users_cannot_manage_series()
    {
        $response = $this->get(route('series.manage.index'));
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function videomanagers_can_manage_series()
    {
        $this->loginAsVideoManager();
        $response = $this->get(route('series.manage.index'));
        $response->assertStatus(403);
    }

    /** @test */
    public function superadmins_can_manage_series()
    {
        $this->loginAsSuperAdmin();
        $response = $this->get(route('series.manage.index'));
        $response->assertStatus(200);
    }
}
