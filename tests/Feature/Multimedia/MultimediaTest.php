<?php

namespace Tests\Feature\Multimedia;

use App\Models\User;
use App\Models\Multimedia;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class MultimediaTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
        $this->createPermissions();
        $this->createRoles();
    }

    /**
     * Test that users with appropriate permissions can view the multimedia index page.
     */
    public function test_user_with_permissions_can_view_multimedia_index()
    {
        $user = $this->loginAsMultimediaManager();

        // Create test multimedia files
        $this->createTestMultimedia($user->id, 3);

        $response = $this->actingAs($user)->get('/api/multimedia');

        $response->assertStatus(200);

        // Check that multimedia files are returned in the response
        $multimedia = Multimedia::where('user_id', $user->id)->get();
        foreach ($multimedia as $file) {
            $response->assertJsonFragment(['file_name' => $file->file_name]);
        }
    }


    /**
     * Test that superadmins can manage all multimedia files.
     */
    public function test_superadmins_can_manage_all_multimedia()
    {
        $admin = $this->loginAsSuperAdmin();
        $regularUser = User::factory()->create();

        // Create multimedia for regular user
        $this->createTestMultimedia($regularUser->id, 2);

        $response = $this->actingAs($admin)->get('/api/multimedia');

        $response->assertStatus(200);

        // Admin should see all files
        $allFiles = Multimedia::all();
        foreach ($allFiles as $file) {
            $response->assertJsonFragment(['file_name' => $file->file_name]);
        }
    }

    /**
     * Test that users can upload multimedia files.
     */
    public function test_user_can_upload_multimedia()
    {
        $user = $this->loginAsRegularUser();

        // Create a generic file instead of an image
        $file = UploadedFile::fake()->create('document.pdf', 100);

        $response = $this->actingAs($user)->post('/api/multimedia', [
            'file' => $file,
            'file_name' => 'document.pdf',
            'file_type' => 'pdf',
            'mime_type' => 'application/pdf',
            'user_id' => $user->id
        ]);

        $response->assertStatus(200);

        // Check that file was stored in database
        $this->assertDatabaseHas('multimedia', [
            'file_name' => 'document.pdf',
            'file_type' => 'pdf',
            'mime_type' => 'application/pdf',
            'user_id' => $user->id
        ]);

        // Check that file exists in storage
        $multimedia = Multimedia::where('file_name', 'document.pdf')->first();
        Storage::disk('public')->assertExists($multimedia->file_path);
    }

    /**
     * Test that users cannot delete other users' multimedia files.
     */
    public function test_user_cannot_delete_others_multimedia()
    {
        $user1 = $this->loginAsRegularUser('user1@example.com');
        $user2 = User::factory()->create(['email' => 'user2@example.com']);

        $multimedia = $this->createTestMultimedia($user2->id, 1);

        $response = $this->actingAs($user1)->delete("/api/multimedia/{$multimedia[0]->id}");

        $response->assertStatus(403);

        // Check that file still exists in database
        $this->assertDatabaseHas('multimedia', [
            'id' => $multimedia[0]->id
        ]);
    }

    /**
     * Test that users can update their own multimedia files.
     */
    public function test_user_can_update_own_multimedia()
    {
        $user = $this->loginAsRegularUser();
        $multimedia = $this->createTestMultimedia($user->id, 1);

        $newName = 'updated-file-name.pdf';

        $response = $this->actingAs($user)->put("/api/multimedia/file/{$multimedia[0]->id}", [
            'file_name' => $newName
        ]);

        $response->assertStatus(200);

        // Check that file was updated in database
        $this->assertDatabaseHas('multimedia', [
            'id' => $multimedia[0]->id,
            'file_name' => $newName
        ]);
    }

    /**
     * Test that users cannot update other users' multimedia files.
     */
    public function test_user_cannot_update_others_multimedia()
    {
        $user1 = $this->loginAsRegularUser('user1@example.com');
        $user2 = User::factory()->create(['email' => 'user2@example.com']);

        $multimedia = $this->createTestMultimedia($user2->id, 1);

        $response = $this->actingAs($user1)->put("/api/multimedia/file/{$multimedia[0]->id}", [
            'file_name' => 'should-not-update.pdf'
        ]);

        $response->assertStatus(403);

        // Check that file name was not updated
        $this->assertDatabaseHas('multimedia', [
            'id' => $multimedia[0]->id,
            'file_name' => $multimedia[0]->file_name
        ]);
    }

    /**
     * Create test multimedia files for a user.
     */
    private function createTestMultimedia($userId, $count = 1)
    {
        $multimedia = [];

        for ($i = 0; $i < $count; $i++) {
            // Use create() instead of image() to avoid GD dependency
            $file = UploadedFile::fake()->create("document-{$i}.pdf", 100);
            $path = $file->store('multimedia', 'public');

            $multimedia[] = Multimedia::create([
                'file_name' => "document-{$i}.pdf",
                'file_type' => 'pdf',
                'mime_type' => 'application/pdf',
                'file_path' => $path,
                'user_id' => $userId
            ]);
        }

        return $multimedia;
    }

    /**
     * Create necessary permissions.
     */
    private function createPermissions()
    {
        $permissions = [
            'view multimedia',
            'upload multimedia',
            'edit multimedia',
            'delete multimedia',
            'manage multimedia'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }

    /**
     * Create roles with appropriate permissions.
     */
    private function createRoles()
    {
        // Create multimedia manager role
        $managerRole = Role::firstOrCreate(['name' => 'multimedia_manager']);
        $managerRole->givePermissionTo([
            'view multimedia',
            'upload multimedia',
            'edit multimedia',
            'delete multimedia',
            'manage multimedia'
        ]);

        // Create super admin role
        $superAdminRole = Role::firstOrCreate(['name' => 'super_admin']);
        $superAdminRole->givePermissionTo([
            'view multimedia',
            'upload multimedia',
            'edit multimedia',
            'delete multimedia',
            'manage multimedia'
        ]);
    }

    /**
     * Login as multimedia manager.
     */
    private function loginAsMultimediaManager()
    {
        $user = User::factory()->create([
            'name' => 'Multimedia Manager',
            'email' => 'multimedia_manager@example.com',
        ]);

        $role = Role::where('name', 'multimedia_manager')->first();
        $user->assignRole($role);

        return $user;
    }

    /**
     * Login as super admin.
     */
    private function loginAsSuperAdmin()
    {
        $user = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'super_admin' => true,
        ]);

        $user->assignRole('super_admin');

        return $user;
    }

    /**
     * Login as regular user.
     */
    private function loginAsRegularUser($email = 'regular@example.com')
    {
        $user = User::factory()->create([
            'name' => 'Regular User',
            'email' => $email,
        ]);

        $role = Role::firstOrCreate(['name' => 'regular_user']);
        $user->assignRole($role);

        return $user;
    }
}
