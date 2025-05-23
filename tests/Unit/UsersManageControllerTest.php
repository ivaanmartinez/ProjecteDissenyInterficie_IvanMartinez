<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UsersManageControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function loginAsVideoManager(): void
    {
        create_permissions();
        $user = User::factory()->create();
        $user->assignRole('video-manager');
        $this->actingAs($user);
    }

    protected function loginAsSuperAdmin(): void
    {
        create_permissions();
        $user = User::factory()->create();
        $user->assignRole('super_admin');
        $this->actingAs($user);
    }

    protected function loginAsRegularUser(): void
    {
        create_permissions();
        $user = User::factory()->create();
        $user->assignRole('regular');
        $this->actingAs($user);
    }

    public function test_user_with_permissions_can_see_add_users()
    {
        $this->loginAsSuperAdmin();
        $response = $this->get(route('users.manage.create'));
        $response->assertStatus(200);
    }

    public function test_user_without_users_manage_create_cannot_see_add_users()
    {
        $this->loginAsRegularUser();
        $response = $this->get(route('users.manage.create'));
        $response->assertForbidden();
    }

    public function test_user_with_permissions_can_store_users()
    {
        $this->loginAsSuperAdmin();
        $response = $this->postJson(route('users.manage.store'), [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'regular', // Assuming 'regular' is a valid role
        ]);
        $response->assertStatus(302);
        $response->assertRedirect(route('users.manage.index'));
    }

    public function test_user_without_permissions_cannot_store_users()
    {
        $this->loginAsRegularUser();
        $response = $this->post(route('users.manage.store'), [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);
        $response->assertStatus(403); // Ensure this matches the expected response
    }


    public function test_user_with_permissions_can_destroy_users()
    {
        $this->loginAsSuperAdmin();
        $user = User::factory()->create();

        // Perform the delete request
        $response = $this->delete(route('users.manage.destroy', $user->id));

        // Check if the response is a redirect to the users manage page
        $response->assertRedirect(route('users.manage.index'));
    }

    public function test_user_without_permissions_cannot_destroy_users()
    {
        $this->loginAsRegularUser();
        $user = User::factory()->create();
        $response = $this->delete(route('users.manage.destroy', $user->id));
        $response->assertForbidden();
    }

    public function test_user_with_permissions_can_see_edit_users()
    {
        $this->loginAsSuperAdmin();
        $user = User::factory()->create();
        $response = $this->get(route('users.manage.edit', $user->id));
        $response->assertStatus(200);
    }

    public function test_user_without_permissions_cannot_see_edit_users()
    {
        $this->loginAsRegularUser();
        $user = User::factory()->create();
        $response = $this->get(route('users.manage.edit', $user->id));
        $response->assertForbidden();
    }

    public function test_user_with_permissions_can_update_users()
    {
        // Log in as a user with the necessary permissions
        $this->loginAsSuperAdmin();

        // Create a user to update
        $user = User::factory()->create();
        $user->assignRole('regular'); // Asignar un rol inicial

        // Perform the update request with all required fields
        $response = $this->put(route('users.manage.update', $user->id), [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'password' => 'password', // Añadir contraseña aunque sea opcional
            'password_confirmation' => 'password', // Confirmación requerida
            'role' => 'regular', // Asegurar que el rol existe
        ]);

        // Verificar que se actualizó correctamente
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ]);

        // Verificar el rol actualizado
        $this->assertTrue($user->fresh()->hasRole('regular'));

        // Verificar la redirección (opcionalmente puedes comprobar que contiene la ruta)
        $response->assertRedirect(route('users.manage.index'));
    }

    public function test_user_without_permissions_cannot_update_users()
    {
        $this->loginAsRegularUser();
        $user = User::factory()->create();
        $response = $this->put(route('users.manage.update', $user->id), [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ]);
        $response->assertForbidden();
    }

    public function test_user_with_permissions_can_manage_users()
    {
        $this->loginAsSuperAdmin();
        $response = $this->get(route('users.manage.index'));
        $response->assertStatus(200);
    }

    public function test_regular_users_cannot_manage_users()
    {
        $this->loginAsRegularUser();
        $response = $this->get(route('users.manage.index'));
        $response->assertForbidden();
    }

    public function test_guest_users_cannot_manage_users()
    {
        $response = $this->get(route('users.manage.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_superadmins_can_manage_users()
    {
        $this->loginAsSuperAdmin();
        $response = $this->get(route('users.manage.index'));
        $response->assertStatus(200);
    }
}
