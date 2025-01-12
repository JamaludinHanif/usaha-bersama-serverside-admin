<?php

namespace App\Models;

use App\Models\Seller;
use App\Models\TransactionItem;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\Facades\DataTables;

class Transaction extends Model
{
    protected $fillable = ['amount', 'user_id', 'code_invoice', 'seller_id', 'status'];

    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    /**
     *     helper methods
     * */
    public function priceFormatted()
    {
        return 'Rp. ' . number_format($this->amount);
    }

    /**
     *     Static methods
     * */
    public static function dataTable($request)
    {
        $data = self::query()->with(['user', 'seller', 'items.product']);

        if (isset($request->date)) {
            $data->whereDate('created_at', $request->date);
        }

        if (isset($request->status)) {
            $data->where('status', $request->status);
        }

        $data = $data->orderBy('updated_at', 'DESC');

        return Datatables::of($data)
            ->addColumn('buyer', function ($data) {
                return $data->user ? $data->user->username : 'Pengguna Telah Dihapus';
            })
            ->addColumn('seller', function ($data) {
                return $data->seller ? $data->seller->shop_name : 'Pengguna Telah Dihapus';
            })
            ->addColumn('statusFormatted', function ($data) {
                $btnClass = $data->status == 'pending' ? 'btn-warning' :
                ($data->status == 'success' ? 'btn-success' : 'btn-danger');

                return '<center><div class="btn ' . $btnClass . ' btn-icon-split">
                            <span class="text">' . ucfirst($data->status) . '</span>
                        </div></center>';
            })
            ->addColumn('formatted_created_at', function ($data) {
                $formattedDate = 'Tanggal: ' . $data->created_at->format('d-m-Y') . ', Pukul: ' . $data->created_at->format('H:i:s');
                return $data->created_at ? $formattedDate : '';
            })
            ->addColumn('amount', function ($data) {
                return $data->priceFormatted();
            })
            ->addColumn('action', function ($data) {
                $action = '
				<div class="dropdown">
					<button class="btn btn-primary px-2 py-1 dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Pilih Aksi
					</button>
					<div class="dropdown-menu">
                        <a class="dropdown-item" href="' . route('admin.transactions.detail', $data->id) . '" title="Detail Transaksi">
                        <i class="fa fa-eye mr-1"></i> Detail
					</div>
				</div>';
                return $action;
            })
            ->rawColumns(['buyer', 'seller', 'statusFormatted', 'formatted_created_at', 'action'])
            ->make(true);
    }
}
