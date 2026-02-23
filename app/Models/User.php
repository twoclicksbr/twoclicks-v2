<?php

namespace App\Models;

use App\Global\Models\Person;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use SoftDeletes;

    protected $connection = 'global';

    protected $fillable = [
        'person_id',
        'email',
        'password',
        'order',
        'status',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'status' => 'boolean',
        'password' => 'hashed',
    ];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }
}
