<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Models\LogActivity;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LogActivityController extends Controller
{
    public function showAll()
    {
        return view('admin-users.logActivites', [
            'title' => 'Log Activity',
            'datas' => LogActivity::all()
        ]);
    }

    public function showDataJson(Request $request)
    {
        $data = LogActivity::query();

        if (isset($request->date)) {
            $data->whereDate('created_at', $request->date);
        }

        // search datatables sistem *(jika search defaultnya error)
        if ($request->has('search') && $request->search['value'] != '') {
            $searchValue = $request->search['value'];
            $data->where(function($query) use ($searchValue) {
                $query->whereHas('user', function($query) use ($searchValue) {
                        $query->where('name', 'like', "%{$searchValue}%")
                              ->orWhere('username', 'like', "%{$searchValue}%")
                              ->orWhere('role', 'like', "%{$searchValue}%");
                    })
                    ->orWhere('created_at', 'like', "%{$searchValue}%")
                    ->orWhere('action', 'like', "%{$searchValue}%");
            });
        }

        return Datatables::of($data)
            ->addColumn('name', function ($row) {
                return $row->user ? $row->user->name : 'Pengguna Telah Dihapus';
            })
            ->addColumn('username', function ($row) {
                return $row->user ? $row->user->username : 'Pengguna Telah Dihapus';
            })
            ->addColumn('role', function ($row) {
                return $row->user ? $row->user->role : 'Pengguna Telah Dihapus';
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
            ->rawColumns(['activity'])
            ->make(true);
    }
}
