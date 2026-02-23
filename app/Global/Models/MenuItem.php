<?php

namespace App\Global\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuItem extends Model
{
    use SoftDeletes;

    protected $connection = 'global';
    protected $table = 'menu_items';

    protected $fillable = [
        'parent_id',
        'label',
        'icon',
        'description',
        'route',
        'url',
        'target',
        'layout',
        'scope',
        'order',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function parent()
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(MenuItem::class, 'parent_id')->orderBy('order');
    }

    public function scopeRoots($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
}
