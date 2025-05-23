<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Multimedia extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_name', 'file_type', 'file_path', 'mime_type', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
