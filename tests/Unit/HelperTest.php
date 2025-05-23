<?php

namespace Tests\Unit;

use App\Helpers\DefaultVideoHelper;
use App\Models\Series;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class HelperTest extends TestCase
{
    use RefreshDatabase;
    public function test_can_create_default_user_and_professor()
    {
        create_permissions();
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
    public function test_create_default_video()
    {

        $video = DefaultVideoHelper::createDefaultVideo();

        $this->assertDatabaseHas('videos', [
            'title' => '13th ⏩ 2nd from Marc Marquez\' onboard 🎥 | 2024 #FrenchGP',
            'description' => 'Comeback ride? 📈 Completed it mate! ✅',
            'url' => 'https://www.youtube.com/embed/Y8M3yM-ahPY',
        ]);

        $this->assertEquals('13th ⏩ 2nd from Marc Marquez\' onboard 🎥 | 2024 #FrenchGP', $video->title);
        $this->assertEquals('Comeback ride? 📈 Completed it mate! ✅', $video->description);
        $this->assertEquals('https://www.youtube.com/embed/Y8M3yM-ahPY', $video->url);
    }
}
