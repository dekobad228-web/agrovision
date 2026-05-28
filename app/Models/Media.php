<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Media extends Model
{
    use HasFactory;

    protected $table = 'media';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $fillable = [
        'name',
        'file_name',
        'type',
        'mime_type',
        'extension',
        'path',
        'size',
        'description',
        'alt_text',
        'user_id'
    ];

    protected $casts = [
        'size' => 'integer',
    ];
    protected $appends = ['url'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function albums()
    {
        return $this->belongsToMany(Album::class)
            ->using(AlbumMedia::class)
            ->withTimestamps()
            ->withPivot('id');
    }

    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->path);
    }

    public function scopeImages($query)
    {
        return $query->where('type', 'image');
    }
    public function scopeVideos($query)
    {
        return $query->where('type', 'video');
    }
    public function scopeModels($query)
    {
        return $query->where('type', 'model');
    }

    public function scopeOfUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
