<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_is_super_admin_function()
    {
        create_permissions();
        $superAdmin = create_superadmin_user();
        $this->assertTrue($superAdmin->isSuperAdmin());

        $regularUser = create_regular_user();
        $this->assertFalse($regularUser->isSuperAdmin());
    }
    public function user_without_permissions_can_see_default_users_page(): void
    {
        create_permissions();
        $user = create_regular_user();
        $this->actingAs($user);
        $response = $this->get(route('users.index'));
        $response->assertStatus(200);
    }

    public function user_with_permissions_can_see_default_users_page()
    {
        create_permissions();
        $user = create_superadmin_user();
        $this->actingAs($user);
        $response = $this->get(route('users.index'));
        $response->assertStatus(200);
    }

    public function not_logged_users_cannot_see_default_users_page()
    {
        $response = $this->get(route('users.index'));
        $response->assertRedirect(route('login'));
    }

    public function user_without_permissions_can_see_user_show_page()
    {
        create_permissions();
        $user = create_regular_user();
        $targetUser = create_regular_user();
        $this->actingAs($user);
        $response = $this->get(route('users.show', $targetUser->id));
        $response->assertStatus(200);
    }

    public function user_with_permissions_can_see_user_show_page()
    {
        create_permissions();
        $user = create_superadmin_user();
        $targetUser = create_regular_user();
        $this->actingAs($user);
        $response = $this->get(route('users.show', $targetUser->id));
        $response->assertStatus(200);
    }

    public function not_logged_users_cannot_see_user_show_page()
    {
        create_permissions();
        $targetUser = create_regular_user();
        $response = $this->get(route('users.show', $targetUser->id));
        $response->assertRedirect(route('login'));
    }
}
