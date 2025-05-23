<?php

namespace Tests\Unit;

use App\Helpers\DefaultVideoHelper;
use App\Helpers\SeriesHelper;
use Tests\TestCase;
use App\Models\Serie;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SerieTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function serie_have_videos()
    {
        $serie = SeriesHelper::createDefaultSerie1();

        $video1 = DefaultVideoHelper::createDefaultVideo();
        $video2 = DefaultVideoHelper::createDefaultVideo2();

        $video1->series_id = $serie->id;
        $video1->save();

        $video2->series_id = $serie->id;
        $video2->save();

        $this->assertCount(2, $serie->videos);
        $this->assertTrue($serie->videos->contains($video1));
        $this->assertTrue($serie->videos->contains($video2));

    }
}
