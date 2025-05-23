<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Factories\VideosFactory; // Importamos VideosFactory
use App\Models\Video;

class VideosTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_formatted_published_at_date()
    {
        $video = VideosFactory::new()->create([
            'published_at' => '2025-01-20 14:00:00'
        ]);

        $formattedDate = $video->getFormattedPublishedAtDate();

        $this->assertEquals('20/01/2025 14:00', $formattedDate);
    }

    public function test_can_get_formatted_published_at_date_when_not_published()
    {
        $video = VideosFactory::new()->create([
            'published_at' => null
        ]);

        $formattedDate = $video->getFormattedPublishedAtDate();
        $this->assertEquals('No publicada', $formattedDate);
    }
}
