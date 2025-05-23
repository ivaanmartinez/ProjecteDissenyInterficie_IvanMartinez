<?php

namespace App\Models;

use App\Events\VideoCreated;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Series;


class Video extends Model
{
    use HasFactory;

    protected $table = 'videos';

    protected $fillable = [
        'title',
        'description',
        'url',
        'published_at',
        'previous',
        'next',
        'series_id',
        'user_id', // Afegit per assegurar que es guarda correctament l'usuari propietari del vídeo
    ];

    /**
     * Sobreescrivim la funció find() per evitar problemes.
     */
    public static function find($id)
    {
        return static::query()->findOrFail($id);
    }
    /**
     * Relació 1:N → Un vídeo pot tindre una sèrie
     */
    public function series()
    {
        return $this->belongsTo(Serie::class, 'series_id');
    }

    /**
     * Accessor per formatar la data de publicació.
     */
    public function getFormattedPublishedAtAttribute()
    {
        return $this->published_at ? Carbon::parse($this->published_at)->format('d/m/Y') : 'No publicada';
    }

    /**
     * Accessor per mostrar la data de publicació en format "fa X temps".
     */
    public function getFormattedForHumansPublishedAtAttribute()
    {
        return $this->published_at ? Carbon::parse($this->published_at)->diffForHumans() : 'No publicada';
    }

    /**
     * Accessor per obtenir el timestamp de la data de publicació.
     */
    public function getPublishedAtTimestampAttribute()
    {
        return $this->published_at ? Carbon::parse($this->published_at)->timestamp : null;
    }

    /**
     * Relació amb l'usuari propietari del vídeo.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relació amb la sèrie a la qual pertany el vídeo.
     */

    /**
     * Vídeo anterior dins la sèrie.
     */
    public function previousVideo()
    {
        return $this->belongsTo(Video::class, 'previous');
    }

    /**
     * Vídeo següent dins la sèrie.
     */
    public function nextVideo()
    {
        return $this->belongsTo(Video::class, 'next');
    }
    public function getFormattedPublishedAtDate()
    {
        if ($this->published_at) {
            return Carbon::parse($this->published_at)->format('d/m/Y H:i');
        }

        return 'No publicada';
    }
    protected $dispatchesEvents = [
        'created' => VideoCreated::class,
    ];
}
