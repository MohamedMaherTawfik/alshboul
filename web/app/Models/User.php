<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'email',
      	'name',
        'password',
        'username',
        'added_by',
        'updated_by',
        'active',
        'date',
        'delete_reason',
        'deleted_at',
        'role'

    ];
    public function addedby()
    {
        return $this->belongsTo(User::class, 'added_by');
    }
    public function updateby()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    public function client()
    {
        return $this->hasMany(Client::class);
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',

        ];
    }
}
