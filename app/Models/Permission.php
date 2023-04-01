<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Permission extends Authenticatable
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
        'delegates_id',
        'create_permission',
        'update_permission',
        'delete_permission'
    ];

    public function owner()
    {
        return $this->belongsTo("App\Models\User", 'owner_id', 'id');
    }

    // public function delegates()
    // {
    //     return $this->hasMany('App\Models\Delegate', 'delegates_id', 'id');
    // }

}
