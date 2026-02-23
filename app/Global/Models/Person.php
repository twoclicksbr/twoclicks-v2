<?php

namespace App\Global\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class Person extends Model
{
    use SoftDeletes;

    protected $connection = 'global';
    protected $table = 'people';

    protected $fillable = [
        'first_name',
        'surname',
        'order',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'person_id');
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->surname}";
    }
}
