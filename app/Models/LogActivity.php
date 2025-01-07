<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\Facades\DataTables;

class LogActivity extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // relasi
    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    /**
     *     Static methods
     * */
    public static function dataTable($request)
    {
        $data = self::query()->with('user');

        if (isset($request->date)) {
            $data->whereDate('created_at', $request->date);
        }

        if (isset($request->role)) {
            $data->whereHas('user', function ($query) use ($request) {
                $query->where('role', $request->role);
            });
        }

        return Datatables::of($data)
            ->addColumn('name', function ($data) {
                return $data->user ? $data->user->name : 'Pengguna Telah Dihapus';
            })
            ->addColumn('username', function ($data) {
                return $data->user ? $data->user->username : 'Pengguna Telah Dihapus';
            })
            ->addColumn('roleFormatted', function ($data) {
                if (!$data->user) {
                    return '<center><div class="btn btn-danger btn-icon-split">
                                <span class="text">Pengguna Telah Dihapus</span>
                            </div></center>';
                }

                $btnClass = $data->user->role == 'admin' ? 'btn-info' :
                            ($data->user->role == 'seller' ? 'btn-success' : 'btn-warning');

                return '<center><div class="btn ' . $btnClass . ' btn-icon-split">
                            <span class="text">' . ucfirst($data->user->role) . '</span>
                        </div></center>';
            })
            ->addColumn('formatted_created_at', function ($row) {
                $formattedDate = 'Tanggal: ' . $row->created_at->format('d-m-Y') . ', Pukul: ' . $row->created_at->format('H:i:s');
                return $row->created_at ? $formattedDate : '';
            })
            ->addColumn('activity', function($row) {
                $btnClass = $row->action == 'login' ? 'btn-info' : 'btn-warning';
                return '<div class="btn ' . $btnClass . ' btn-icon-split">
                            <span class="text">' . $row->action . '</span>
                        </div>';
            })
            ->rawColumns(['name', 'username', 'roleFormatted', 'formatted_created_at', 'activity'])
            ->make(true);
    }
}
