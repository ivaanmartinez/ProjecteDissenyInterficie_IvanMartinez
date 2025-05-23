<?php

namespace App\Helpers;

use App\Models\Serie;

class SeriesHelper
{
    /**
     * Crear la primera sèrie per omplir la base de dades.
     *
     * @return Serie
     */
    public static function createDefaultSerie1(): Serie
    {
        return Serie::create([
            'title' => 'Serie 1',
            'description' => 'Descripció de la sèrie 1.',
            'image' => 'image1.jpg',
            'user_id' => 1, // Asegúrate que este usuario exista
            'user_name' => 'User 1',
            'user_photo_url' => 'https://placeimg.com/640/480/people',
            'published_at' => now(),
        ]);
    }

    /**
     * Crear la segona sèrie per omplir la base de dades.
     *
     * @return void
     */
    public static function createDefaultSerie2()
    {
        Serie::create([
            'title' => 'Serie 2',
            'description' => 'Descripció de la sèrie 2.',
            'image' => 'image2.jpg',
            'user_name' => 'User 2',
            'user_photo_url' => 'https://placeimg.com/640/480/people',
            'published_at' => now(),
        ]);
    }

    /**
     * Crear la tercera sèrie per omplir la base de dades.
     *
     * @return void
     */
    public static function createDefaultSerie3()
    {
        Serie::create([
            'title' => 'Serie 3',
            'description' => 'Descripció de la sèrie 3.',
            'image' => 'image3.jpg',
            'user_name' => 'User 3',
            'user_photo_url' => 'https://placeimg.com/640/480/people',
            'published_at' => now(),
        ]);
    }
}
