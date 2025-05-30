<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'users';
    protected $primaryKey = 'Id';  
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'UserType', 
        'FirstName',
        'MiddleName',
        'LastName',
        'Username', 
        'email',
        'contact_number',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',  'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Login method
     */
    function login($data) {
        $data = (object) $data;
        // Check both username and email fields since your table has both
        $user = $this->where('Username', $data->username)
                    ->orWhere('email', $data->username)
                    ->first();
              
                    if(Hash::check($data->password,$user->password)){
                        Auth::login($user,true);
                    }
    }
    
    // Add this method to your User model
    public function getAuthIdentifierName()
    {
        return 'Username'; 
    }

    public function getAuthPassword()
    {
        return $this->password;
    }
}