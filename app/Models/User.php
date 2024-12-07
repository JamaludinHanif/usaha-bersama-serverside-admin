<?php

namespace App\Models;

use App\Models\Note;
use App\Models\Paylater;
use App\Models\LogActivity;
use App\Models\PaymentCode;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\CustomResetPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;

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
        'no_hp',
        'debt_limit',
        'password',
    ];

    protected $dates = ['deleted_at'];

    public function activityLogs()
    {
        return $this->hasMany(LogActivity::class);
    }

    public function paylater()
    {
        return $this->hasMany(Paylater::class);
    }

    public function paymentCode()
    {
        return $this->hasMany(PaymentCode::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
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
//     'email' => 'newhanif743@gmail.com',
//     'no_hp' => '6285161310018',
//     'password' => bcrypt('12345')
// ])

// User::create([
//     'name' => 'Amanda Damayanti',
//     'role' => 'kasir',
//     'username' => 'amanda',
//     'email' => 'amandadmyntii@gmail.com',
//     'no_hp' => '6283823538374',
//     'password' => bcrypt('hanifganteng')
// ])

// User::create([
//     'name' => 'Muhammad Maulana Latif Al-Amin',
//     'role' => 'user',
//     'username' => 'maul',
//     'email' => 'sra352285@gmail.com',
//     'no_hp' => '6285161310017',
//     'password' => bcrypt('12345')
// ])
