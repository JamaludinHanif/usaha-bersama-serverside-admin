<?php

namespace App\Models;

use App\Models\Note;
use App\MyClass\Helper;
use App\Models\Paylater;
use App\Models\LogActivity;
use App\Models\PaymentCode;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Notifications\CustomResetPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

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
        'no_hp',
        'password',
        'otp',
        'is_verify',
    ];

    protected $dates = ['deleted_at'];

    // relasi
    public function activityLogs()
    {
        return $this->hasMany(LogActivity::class);
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

    /**
     *     CRUD methods
     * */
    public static function createUser(array $request)
    {
        $request['password'] = \Hash::make($request['password']);
        $request['no_hp'] = Helper::idPhoneNumberFormat($request['no_hp']);
        $user = self::create($request);
        return $user;
    }

    public function updateUser($request)
    {
        $this->update([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'role' => $request->role,
            'no_hp' => Helper::idPhoneNumberFormat($request['no_hp']),
        ]);

        if (!empty($request->password)) {
            $this->changePassword($request->password);
        }

        return $this;
    }

    public function deleteUser()
    {
        return $this->delete();
    }

    /**
     *     Helper methods
     * */
    public function comparePassword($oldPassword)
    {
        return \Hash::check($oldPassword, $this->password);
    }

    public function changePassword($newPassword)
    {
        if (!empty($newPassword)) {
            $this->update([
                'password' => \Hash::make($newPassword),
            ]);
        }

        return $this;
    }

    public function avatarLink()
    {
        return url('img/default-avatar.jpg');
    }

    public function roleName()
    {
        return $this->role;
    }

    public function roleText()
    {
        return $this->role;
    }

    public function isSuperUser()
    {
        return $this->role == self::ROLE_SUPER_USER;
    }

    public function isAdmin()
    {
        return $this->role == self::ROLE_ADMIN;
    }

    public function isAnggota()
    {
        return $this->role == self::ROLE_ANGGOTA;
    }

    public function isBuyer()
    {
        return $this->role == self::ROLE_BUYER;
    }

    /**
     *     Static methods
     * */
    public static function dataTable($request)
    {
        $data = self::query();

        if (isset($request->role)) {
            $data->where('role', $request->role);
        }

        $data = $data->orderBy('updated_at', 'DESC');

        return Datatables::of($data)
            ->addColumn('roleFormatted', function ($data) {
                $btnClass = $data->role == 'admin' ? 'btn-info' : ($data->role == 'seller' ? 'btn-success' : 'btn-warning');
                $roleFormatted = '<center><div class="btn ' . $btnClass . ' btn-icon-split">
                <span class="text">' . $data->role . '</span>
            </div></center>';

                return $roleFormatted;
            })
            ->addColumn('action', function ($data) {

                $action = '
				<div class="dropdown">
					<button class="btn btn-primary px-2 py-1 dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Pilih Aksi
					</button>
					<div class="dropdown-menu">
						<a class="dropdown-item edit" href="javascript:void(0);" data-edit-href="' . route('admin.users.update', $data->id) . '" data-get-href="' . route('admin.users.get', $data->id) . '">
							<i class="fas fa-pencil-alt mr-1"></i> Edit
						</a>
						<a class="dropdown-item delete" href="javascript:void(0)" data-delete-message="Yakin ingin menghapus?" data-delete-href="' . route('admin.users.delete', $data->id) . '">
							<i class="fas fa-trash mr-1"></i> Hapus
						</a>
					</div>
				</div>';

                return $action;
            })
            ->rawColumns(['action', 'roleFormatted'])
            ->make(true);
    }
}

// User::create([
//     'name' => 'Jamaludin Hanif',
//     'role' => 'admin',
//     'username' => 'Jamal2',
//     'email' => 'newhanif74323@gmail.com',
//     'password' => bcrypt('12345')
// ])

// User::create([
//     'name' => 'Amanda Damayanti',
//     'role' => 'admin',
//     'username' => 'amanda',
//     'email' => 'amandadmyntii@gmail.com',
//     'password' => bcrypt('12345')
// ])

// User::create([
//     'name' => 'Muhammad Maulana Latif Al-Amin',
//     'role' => 'buyer',
//     'username' => 'maul',
//     'email' => 'sra352285@gmail.com',
//     'password' => bcrypt('12345')
// ])
