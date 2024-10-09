<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ReedemCode;
// use App\Exports\UsersExport;
// use App\Imports\UsersImport;
// use App\Exports\TemplateImport;
use Illuminate\Http\Request;
// use Intervention\Image\Facades\Image;
use Illuminate\Validation\Rule;
use Illuminate\Routing\Controller;
use Yajra\DataTables\Facades\DataTables;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
// use Intervention\Image\ImageManager;
// use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
// use Intervention\Image\Drivers\Gd\Driver;

class UserController extends Controller
{
    // users menggunakan ajax (tanpa reload website)
    public function create()
    {
        return view('admin-users.addUsers');
    }

    public function indexUsers()
    {
        return view('admin-users.users', [
            'title' => 'All Users',
        ]);
    }

    public function showAll(Request $request)
    {
        $data = User::query();

        if (isset($request->role)) {
            $data->where('role', $request->role);
        }

        return Datatables::of($data)
        ->addColumn('role', function($data) {
            $btnClass = $data->role == 'admin' ? 'btn-info' : 'btn-warning';
            return '<center><div class="btn ' . $btnClass . ' btn-icon-split">
                        <span class="text">' . $data->role . '</span>
                    </div></center>';
        })
        ->addColumn('action', function($data){
            return view('admin-users.action')->with('data', $data);
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
        ->rawColumns(['role', 'imageUser', 'action'])
        ->make(true);
    }

    public function store(Request $request)
    {
        // dd($request);
        // if ($request->hasFile('image')) {
        //     // File berhasil diunggah
        //     $file = $request->file('image');
        //     dd($file); // menampilkan detail file yang diunggah
        // } else {
        //     // Tidak ada file yang diunggah
        //     dd('Tidak ada file yang diunggah');
        // }

        $data = $request->all();

        // dd($data);

        $rules = [
            'name' => 'required|max:100',
            'username' => ['required', 'min:3', 'max:100', 'unique:users'],
            'role' => 'required|in:admin,user',
            'email' => ['required', 'email:dns', 'unique:users'],
            'password' => 'required|min:5|max:100'
        ];

        // Menambahkan aturan untuk gambar hanya jika nilai gambar tidak sama dengan "undefined"
        if ($request->input('image') !== 'undefined') {
            $rules['image'] = ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg'];//, 'max:2048'];
        }

        $validasi = Validator::make($data, $rules, [
            'name.required' => 'Nama wajib diisi',
            'name.max' => 'Nama maksimal 100 karakter',
            'username.required' => 'Username wajib diisi',
            'username.min' => 'Username minimal 3 karakter',
            'username.max' => 'Username maksimal 100 karakter',
            'username.unique' => 'Username sudah digunakan',
            'role.required' => 'Role wajib diisi',
            'role.in' => 'Role harus salah satu dari admin atau user',
            'image.image' => 'File harus berupa gambar/foto',
            'image.mimes' => 'File gambar harus berformat jpeg, png, jpg, gif, svg',
            'image.max' => 'Ukuran gambar maksimal 2MB',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah digunakan',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 5 karakter',
            'password.max' => 'Password maksimal 100 karakter',
        ]);

        if ($validasi->fails()) {
            return response()->json(['errors' => $validasi->errors()]);
        } else {
            $data = [
                'name' => $request->name,
                'username' => $request->username,
                'role' => $request->role,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ];

            if ($request->hasFile('image')) {
                // Ambil file gambar dari request
                $image = $request->file('image');
                $filename = time() . '_' . $image->getClientOriginalName();

                $manager = new ImageManager(Driver::class);
                $imageProcessed = $manager->read($image);

                $imageProcessed->cover(500, 500);;

                // Simpan gambar ke storage
                $path = $request->file('image')->storeAs('uploads', $filename, 'public');
                $imageProcessed->save(storage_path('app/public/' . $path));

                // Simpan path gambar ke dalam data array
                $data['image'] = $path;
            }

            User::create($data);
            return response()->json(['success' => 'Berhasil menyimpan data']);

        }

    }

    public function editUser2($id)
    {
        // dd($id);
        return view('admin-users.editUsers', [
            'title' => 'Edit User',
            'datas' => User::where('id', $id)->first()
        ]);
        // $data = Quotes::where('id', $id)->first();
        // return response()->json(['data' => $data]);
    }

    public function updateUser2(Request $request, $id)
    {

        // dd($request->all());
        $user = User::findOrFail($id);

        $rules = [
            'name' => 'required|max:100',
            'role' => 'required|in:admin,user',
            'username' => [
                'required',
                'min:3',
                'max:100',
                Rule::unique('users')->ignore($user->id) // Mengabaikan validasi unique untuk ID yang sedang diupdate
            ],
            'email' => [
                'required',
                'email:dns',
                Rule::unique('users')->ignore($user->id) // Mengabaikan validasi unique untuk ID yang sedang diupdate
            ],
        ];

        // Menambahkan aturan untuk gambar hanya jika nilai gambar tidak sama dengan "undefined"
        if ($request->input('image') !== 'undefined') {
            $rules['image'] = ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg'];//, 'max:2048'];
        }

        // Tambahkan validasi password jika diisi
        if ($request->filled('password')) {
            $rules['password'] = 'required|min:5|max:100';
        }

        // Validasi request
        $validasi = Validator::make($request->all(), $rules, [
            'name.required' => 'Nama wajib diisi',
            'name.max' => 'Nama maksimal 100 karakter',
            'username.required' => 'Username wajib diisi',
            'username.min' => 'Username minimal 3 karakter',
            'username.max' => 'Username maksimal 100 karakter',
            'username.unique' => 'Username sudah digunakan',
            'role.required' => 'Role wajib diisi',
            'role.in' => 'Role harus salah satu dari admin atau user',
            'image.image' => 'File harus berupa gambar/foto',
            'image.mimes' => 'File gambar harus berformat jpeg, png, jpg, gif, svg',
            'image.max' => 'Ukuran gambar maksimal 2MB',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah digunakan',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 5 karakter',
            'password.max' => 'Password maksimal 100 karakter',
        ]);

        if ($validasi->fails()) {
            return response()->json(['errors' => $validasi->errors()]);
        } else {
            $data = $validasi->validated();

            // Hash password jika diisi
            if (isset($data['password'])) {
                $data['password'] = bcrypt($data['password']);
            }

            if ($request->hasFile('image')) {
                // dd('app/public/' . $user->image);
                // menghapus old image
                if ($request->file('image')) {
                    File::delete(storage_path('app/public/' . $user->image));
                }

                // Ambil file gambar dari request
                $image = $request->file('image');
                $filename = time() . '_' . $image->getClientOriginalName();

                $manager = new ImageManager(Driver::class);
                $imageProcessed = $manager->read($image);

                $imageProcessed->cover(500, 500);

                // Simpan gambar ke storage
                $path = $request->file('image')->storeAs('uploads', $filename, 'public');
                $imageProcessed->save(storage_path('app/public/' . $path));

                // Simpan path gambar ke dalam data array
                $data['image'] = $path;
            }

            User::where('id', $id)->update($data);
            return response()->json(['success' => 'Berhasi mengupdate data']);
        }

    }

    public function deleteUserAjax($id)
    {
        // dd($id);
        try {
            $user = User::findOrFail($id);
            if ($user->image) {
                File::delete(storage_path('app/public/' . $user->image));
                $user->update(['image' => null]);
            }
            File::delete(storage_path('app/public/' . $user->image));
            $user->delete();
            // toast('User berhasil di ubah','success');
            return response()->json(['success' => 'Berhasil menghapus data'], 200); // Berikan respons sukses
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal menghapus data '], 500); // Berikan respons error . $e->getMessage()
        }
    }

    // recyle/restore
    public function indexRestore()
    {
        return view('admin-recycle.users', [
            'title' => 'Recycle Users',
        ]);
    }

    public function showAllDeleted(Request $request)
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


    // excellll
    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
        ]);

        Excel::import(new UsersImport, $request->file('file'));

        return redirect('/tes')->with('success', 'Data imported successfully!');
    }

    public function downloadTemplate()
    {
        return Excel::download(new TemplateImport, 'template-user.xlsx');
    }


    // APIIIIII
    public function indexApi()
    {
        return User::all();
    }

    // Simpan post baru
    public function register(Request $request)
    {

        $data = $request->all();

        $rules = [
            'name' => 'required|max:100',
            'username' => ['required', 'min:3', 'max:100', 'unique:users'],
            'email' => ['required', 'email:dns', 'unique:users'],
            'password' => 'required|min:5|max:100'
        ];

        $validasi = Validator::make($data, $rules, [
            'name.required' => 'Nama wajib diisi',
            'name.max' => 'Nama maksimal 100 karakter',
            'username.required' => 'Username wajib diisi',
            'username.min' => 'Username minimal 3 karakter',
            'username.max' => 'Username maksimal 100 karakter',
            'username.unique' => 'Username sudah digunakan',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah digunakan',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 5 karakter',
            'password.max' => 'Password maksimal 100 karakter',
        ]);

        if ($validasi->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validasi->errors(),
            ], 200);
        } else {
            $data = [
                'name' => $request->name,
                'username' => $request->username,
                'role' => $request->role,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ];

            User::create($data);
            return response()->json([
                'status' => true,
                'message' => 'Berhasil membuat akun, Silahkan Login',
            ], 200);
        }

    }

    // Tampilkan satu post
    public function showApi($id)
    {
        $post = User::findOrFail($id);
        return response()->json($post);
    }

    // Update post yang ada
    public function updateApi(Request $request, $id)
    {
        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required|string',
        ]);

        $post = User::findOrFail($id);
        $post->update($request->all());

        return response()->json($post);
    }

    // Hapus post
    public function destroyApi($id)
    {
        $post = User::findOrFail($id);
        $post->delete();

        return response()->json(null, 204);
    }

    public function myCart(Request $request)
    {
        $userId = $request->userId;

        // Ambil semua data keranjang berdasarkan user_id dan eager load produk
        $dataCarts = ReedemCode::with('product') // Eager load produk
            ->where('user_id', $userId)
            ->get();

        // Kelompokkan data berdasarkan kode
        $groupedData = $dataCarts->groupBy('code');

        // Formatkan data untuk menampilkan produk
        $formattedData = [];
        foreach ($groupedData as $code => $items) {
            $productData = [];
            foreach ($items as $item) {
                $productData[] = [
                    'id' => $item->product_id,
                    'name' => $item->product->name, // Ambil nama produk dari relasi
                    'quantity' => $item->quantity,
                    'total_amount' => $item->total_amount,
                ];
            }
            $formattedData[] = [
                'code' => $code,
                'products' => $productData,
            ];
        }

        return response()->json([
            'status' => true,
            'message' => 'Berhasil fetch data keranjang',
            'data' => $formattedData,
        ], 200);
    }
}
