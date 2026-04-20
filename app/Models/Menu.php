<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Integer;

class Menu extends Model
{
    protected $table = 'menus';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $fillable = [
        'name',
        'slug',
        'position',
    ];

    protected $casts = [
        'position' => 'integer'
    ];

    public function items()
    {
        return $this->hasMany(MenuItem::class)->orderBy('position');
    }
}
