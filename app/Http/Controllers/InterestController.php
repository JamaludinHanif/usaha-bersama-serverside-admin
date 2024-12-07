<?php

namespace App\Http\Controllers;

use App\Models\LogActivity;
use App\Models\InterestBill;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class InterestController extends Controller
{
    public function create()
    {
        return view('admin-transaction.kelola-bunga.addInterest');
    }

    public function index()
    {
        return view('admin-transaction.kelola-bunga.interest', [
            'title' => 'Kelola Bunga',
        ]);
    }

    public function showAll(Request $request)
    {
        $data = InterestBill::all();

        return Datatables::of($data)
            ->addColumn('action', function ($data) {
                return view('admin-transaction.kelola-bunga.action')->with('data', $data);
            })
            ->addColumn('bunga', function ($data) {
                return $data->interest . "%";
            })
            ->addColumn('formatted_amount_day', function ($data) {
                return $data->amount_day . " " . $data->unit_date;
            })
            ->addColumn('unit_date_formatted', function ($data) {
                $btnClass = $data->unit_date == 'minggu'
                ? 'btn-info'
                : 'btn-warning';

                return '<div class="' . $btnClass . '"
                        style="padding-top: 5px; padding-bottom: 5px; color: white; border-radius: 10px; font-size: 15px; text-align: center;">'
                . $data->unit_date .
                    '</div>';
            })
            ->addIndexColumn()
            ->rawColumns(['action', "unit_date_formatted", "formatted_amount_day", "bunga"])
            ->make(true);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        // dd($data);

        $rules = [
            'name' => 'required|max:100|unique:interest_bills',
            'interest' => ['required'],
            'amount_day' => 'required',
            'unit_date' => ['required'],
        ];

        // Menambahkan aturan untuk gambar hanya jika nilai gambar tidak sama dengan "undefined"
        if ($request->input('image') !== 'undefined') {
            $rules['image'] = ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg']; //, 'max:2048'];
        }

        $validasi = Validator::make($data, $rules, [
            'name.required' => 'Nama wajib diisi',
            'name.max' => 'Nama maksimal 100 karakter',
            'name.unique' => 'Nama sudah digunakan',
            'interest.required' => 'Jumlah bunga wajib diisi',
            'amount_day.required' => 'Jumlah Tanggal wajib diisi',
            'unit_date.required' => 'Satuan Tanggal wajib diisi',
        ]);

        if ($validasi->fails()) {
            return response()->json(['errors' => $validasi->errors()]);
        } else {
            // log activity
            // dd(session()->all());
            // $userId = session('userData')->id;
            LogActivity::create([
                'user_id' => $request->admin_id,
                'action' => 'membuat bunga ' . $request->name,
            ]);
            $data = [
                'name' => $request->name,
                'interest' => $request->interest,
                'amount_day' => $request->amount_day,
                'unit_date' => $request->unit_date,
            ];

            InterestBill::create($data);
            return response()->json(['success' => 'Berhasil menyimpan data']);

        }

    }

    public function delete($id)
    {
        try {
            $data = InterestBill::findOrFail($id);
            $data->delete();
            // log activity
            $userId = session('userData')->id;
            LogActivity::create([
                'user_id' => $userId,
                'action' => 'menghapus bunga' . $data->name,
            ]);
            return response()->json(['success' => 'Berhasil menghapus data'], 200); // Berikan respons sukses
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal menghapus data '], 500); // Berikan respons error . $e->getMessage()
        }
    }

    // api section
    public function showAllApi(Request $request)
    {
        $data = InterestBill::all();
        $data = $data->map(function ($item) {
            $item->label = $item->amount_day . " " . $item->unit_date . " " . "(Bunga" . " " . $item->interest . "%)";
            return $item;
        });

        return response()->json([
            'status' => true,
            'message' => 'Load data bunga berhasil',
            'data' => $data,
        ], 200);
    }
}
