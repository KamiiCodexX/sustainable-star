<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Post extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $uuidFieldName = 'uuid';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'owner_id',
        'text',
        'posted_by',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo("App\Models\User", 'owner_id', 'id');
    }

    public function company()
    {
        return $this->belongsTo('App\Models\Company', 'owner_id', 'id');
    }

}
