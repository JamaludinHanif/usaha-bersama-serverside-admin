<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Quotes;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;


class QuotesController extends Controller
{
    public function showAll()
    {
        return view('admin-quotes.allQuotes', [
            'title' => 'all quotes',
            'datas' => Quotes::all(),
        ]);
    }

    public function index()
    {
        return view('admin-quotes.kelola-quotes.quotes', [
            'title' => 'Kelola Quotes',
            'users' => User::all()
        ]);
    }

    public function showData()
    {
        // $data = [
        //     'status' => 'success',
        //     'message' => 'Data retrieved successfully',
        //     'data' => [
        //         'item1' => 'value1',
        //         'item2' => 'value2'
        //     ]
        // ];

        // $data = Quotes::all();

        // return response()->json($data);

        // $data = Quotes::all();
        // return DataTables::of($data)->make(true);

        $data = Quotes::with('user')->select('quotes.*');
        return Datatables::of($data)
            ->addColumn('username', function ($row) {
                return $row->user ? $row->user->username : '';
            })
            ->addColumn('category', function ($row) {
                return $row->category ? $row->category->name : '';
            })
            ->addColumn('formatted_created_at', function ($row) {
                return $row->created_at ? $row->created_at->format('Y-m-d H:i:s') : '';
            })
            ->addColumn('aksi', function($data){
                return view('admin-quotes.kelola-quotes.action')->with('data', $data);
            })
            ->rawColumns(['username', 'category', 'formatted_created_at'])
            ->make(true);
    }

    public function store(Request $request)
    {
        // dd($request);
        // $validatedData = $request->validate([
        //     'name' => 'required|max:100',  //versi biasa
        //     'username' => ['required', 'min:3', 'max:100', 'unique:users'], //versi menggunakan array
        //     'role' => 'required',
        //     'email' => ['required', 'email:dns', 'unique:users'],
        //     'password' => 'required|min:5|max:100',

        // ]);

        $validasi = Validator::make($request->all(), [
            'user_id' => 'required',
            'category_id' => 'required',
            'title'=> 'required|unique:quotes',
            'quote' => 'required|max:255'
        ], [
            'user_id.required' => 'User wajib di isi',
            'category_id.required' => 'Kategori wajib di isi',
            'title.required' => 'Judul wajib di isi',
            'title.unique' => 'Judul sudah dipakai, tolong gunakan judul yang lain',
            'title.max' => 'Judul terlalu panjang, max 100 karacter',
            'quote.required' => 'Quote wajib di isi',
            'quote.max' => 'Quote terlalu panjang, max 255 karakter'
        ]);

        if ($validasi->fails()) {
            return response()->json(['errors' => $validasi->errors()]);
        } else {
            $data = [
                'user_id' => $request->user_id,
                'category_id' => $request->category_id,
                'title' => $request->title,
                'quote' => $request->quote
            ];
            Quotes::create($data);
            return response()->json(['success' => 'Berhasi menyimpan data']);
        }

    }

    public function editQuotes($id)
    {
        return view('admin-quotes.kelola-quotes.editQuotes', [
            'title' => 'Edit Quote',
            'users' => User::all(),
            'categories' => Category::all(),
            'datas' => Quotes::where('id', $id)->first()
        ]);
        // $data = Quotes::where('id', $id)->first();
        // return response()->json(['data' => $data]);
    }

    public function update(Request $request, $id)
    {
        $quote = Quotes::findOrFail($id);
        $validasi = Validator::make($request->all(), [
            'user_id' => 'required',
            'category_id' => 'required',
            'title'=> [
                'required',
                Rule::unique('quotes')->ignore($quote->id), // Mengabaikan validasi unique untuk ID yang sedang diupdate
                'max:100'
            ],
            'quote' => 'required|max:255'
        ], [
            'user_id.required' => 'User wajib di isi',
            'category_id.required' => 'Kategori wajib di isi',
            'title.required' => 'Judul wajib di isi',
            'title.unique' => 'Judul sudah dipakai, tolong gunakan judul yang lain',
            'title.max' => 'Judul terlalu panjang, max 100 karacter',
            'quote.required' => 'Quote wajib di isi',
            'quote.max' => 'Quote terlalu panjang, max 255 karakter'
        ]);

        if ($validasi->fails()) {
            return response()->json(['errors' => $validasi->errors()]);
        } else {
            $data = [
                'user_id' => $request->user_id,
                'category_id' => $request->category_id,
                'title' => $request->title,
                'quote' => $request->quote
            ];
            Quotes::where('id', $id)->update($data);
            return response()->json(['success' => 'Berhasi mengupdate data']);
        }
    }

    public function deleteQuotes($id)
    {
        dd($id);
        try {
            $quote = Quotes::findOrFail($id);
            $quote->delete();
            // toast('User berhasil di ubah','success');
            return response()->json(['success' => 'Berhasil menghapus data'], 200); // Berikan respons sukses
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal menghapus data: ' . $e->getMessage()], 500); // Berikan respons error
        }
    }

    public function showFormCreate()
    {
        return view('admin-quotes.kelola-quotes.addQuotes', [
            'title' => 'New Quotes',
            'users' => User::all(),
            'categories' => Category::all()
        ]);
    }


}
