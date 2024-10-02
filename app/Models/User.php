<?php

namespace App\Models;

use App\Models\LogActivity;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\CustomResetPasswordNotification;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    use SoftDeletes;

    protected $fillable = [
        'name',
        'role',
        'username',
        'email',
        'image',
        'password',
    ];

    protected $dates = ['deleted_at'];

    public function activityLogs()
    {
        return $this->hasMany(LogActivity::class);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPasswordNotification($token));
    }


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}


// User::create([
//     'name' => 'Jamaludin Hanif',
//     'role' => 'admin',
//     'username' => 'Jamal',
//     'email' => 'newhanif@gmail.com',
//     'password' => bcrypt('12345')
// ])

// User::create([
//     'name' => 'Amanda Damayanti',
//     'role' => 'user',
//     'username' => 'amay',
//     'email' => 'mnddmyt@gmail.com',
//     'password' => bcrypt('12345')
// ]);
