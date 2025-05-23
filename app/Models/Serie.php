<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;

class Serie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'user_name',
        'user_photo_url',
        'published_at',
    ];

    /**
     * Relació 1:N → Una sèrie pot tindre molts vídeos
     */
    public function videos()
    {
        return $this->hasMany(Video::class, 'series_id');
    }

    /**
     * Funció fictícia testedBy (ex: relació amb User o similar)
     * Aquí pots canviar-ho segons la teva estructura de dades real
     */
    public function testedBy()
    {
        return $this->belongsTo(User::class, 'user_name', 'name'); // Assumim que el camp "user_name" té el nom
    }

    /**
     * 🔁 Retorna la data de creació en format "d/m/Y"
     */
    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at->format('d/m/Y');
    }

    /**
     * 🕰️ Retorna la data de creació en format "fa 3 dies", etc.
     */
    public function getFormattedForHumansCreatedAtAttribute()
    {
        return Carbon::parse($this->created_at)->diffForHumans();
    }

    /**
     * ⌚ Retorna el timestamp de created_at (ex: per usar en JS o AJAX)
     */
    public function getCreatedAtTimestampAttribute()
    {
        return $this->created_at->timestamp;
    }
}
