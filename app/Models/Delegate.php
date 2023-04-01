<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Delegate extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $uuidFieldName = 'uuid';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'company_id',
    ];

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function permissions()
    {
        return $this->hasOne('App\Models\Permission', 'delegates_id', 'id');
    }

    public function storeDelegates($input, $company_id)
    {
        $data = [];
        foreach ($input as $index => $user_id) {
            $data[$index]['user_id'] = $user_id;
            $data[$index]['company_id'] = $company_id;
        }
        Delegate::where('company_id', $company_id)->delete();
        $result = Delegate::insert($data);

        return $result;
    }


}
