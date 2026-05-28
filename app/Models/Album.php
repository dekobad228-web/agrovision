<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Album extends Model
{
    use HasFactory;

    protected $table = 'albums';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $fillable = [
        'title',
        'slug',
        'is_system',
        'position',
        'user_id',
    ];

    protected $casts = [
        'is_system' => 'boolean',
        'position' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function media()
    {
        return $this->belongsToMany(Media::class)
            ->using(AlbumMedia::class)
            ->withTimestamps()
            ->withPivot('id');
    }

    public function scopeSystem($query)
    {
        return $query->where('is_system', true);
    }

    public function scopeOfUser($query, $userId = null)
    {
        if ($userId) {
            return $query->where('user_id', $userId);
        }

        return $query->whereNotNull('user_id');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('position');
    }
}
