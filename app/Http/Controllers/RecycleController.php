<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class RecycleController extends Controller
{
    public function indexUsers()
    {
        return view('admin-recycle.users', [
            'title' => 'Recycle Users',
        ]);
    }

    public function showAll(Request $request)
    {
        // $data = User::query()->onlyTrashed()->get();
        $query = User::query()->onlyTrashed();

        if (isset($request->role)) {
            $query->where('role', $request->role);
        }

        // Ambil data dari query
        $data = $query->get();

        return Datatables::of($data)
        ->addColumn('role', function($data) {
            $btnClass = $data->role == 'admin' ? 'btn-info' : 'btn-warning';
            return '<center><div class="btn ' . $btnClass . ' btn-icon-split">
                        <span class="text">' . $data->role . '</span>
                    </div></center>';
        })
        ->addColumn('action', function($data){
            return view('admin-recycle.action')->with('data', $data);
        })
        ->addColumn('formatted_deleted_at', function ($row) {
            return $row->deleted_at ? $row->deleted_at->format('d-m-Y H:i:s') : '';
        })
        ->addColumn('imageUser', function($data) {
            // Ganti $data->image dengan $data->image untuk mendapatkan nilai gambar dari data
            $imageUrl = $data->image == null
                ? 'https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png'
                : asset('storage/' . $data->image);

            // Kembalikan HTML yang diinginkan
            return '<div class="d-flex justify-content-center">
                        <img src="' . $imageUrl . '" width="50" alt="">
                    </div>';
        })
        ->rawColumns(['role', 'imageUser', 'formatted_deleted_at', 'action'])
        ->make(true);
    }

    public function restore($id)
    {
        // dd($id);
        $user = User::onlyTrashed()->where('id', $id)->restore();

        return response()->json(['success' => 'Berhasil merestore data']);
    }

    public function destroy($id)
    {
        // dd($id);
        $user = User::onlyTrashed()->where('id', $id)->forceDelete();

        return response()->json(['success' => 'Berhasil mendestroy data']);
    }
}
