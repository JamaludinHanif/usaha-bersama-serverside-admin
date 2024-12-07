<?php

namespace App\Http\Controllers;

use App\Models\PaymentCode;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class HistoryController extends Controller
{
    // transaksi
    public function indexTransaction()
    {
        return view('admin-transaction.transaction', [
            'title' => 'Riwayat Transaksi',
            'datas' => Transaction::all(),
        ]);
    }

    public function getTransaction(Request $request)
    {
        $data = Transaction::query();

        if (isset($request->date)) {
            $data->whereDate('created_at', $request->date);
        }
        if (isset($request->status)) {
            $data->where('status', $request->status);
        }
        if (isset($request->type)) {
            $data->where('type', $request->type);
        }

        return Datatables::of($data)
            ->addColumn('username', function ($row) {
                return $row->user ? $row->user->username : '';
            })
            ->addColumn('formatted_created_at', function ($row) {
                return $row->created_at ? $row->created_at->format('d-m-Y (H:i:s)') : '';
            })
            ->addColumn('action', function ($data) {
                return view('admin-transaction.action')->with('data', $data);
            })
            ->addColumn('formatted_amount', function ($row) {
                return $row->total_amount ? 'Rp ' . number_format($row->total_amount, 0, ',', '.') : '';
            })
            ->addColumn('status_formatted', function ($row) {
                $btnClass = $row->status == 'success' ? 'btn-success' : ($row->status == 'pending' ? 'btn-warning' : 'btn-danger');
                return '<center><div class="btn ' . $btnClass . ' btn-icon-split">
                        <span class="text">' . $row->status . '</span>
                    </div></center>';
            })
            ->addColumn('type_formatted', function ($row) {
                $btnClass = $row->type == 'paylater' ? 'btn-warning' : ($row->type == 'cash' || $row->type == 'tunai' ? 'btn-success' : 'btn-info');
                return '<center><div class="btn ' . $btnClass . ' btn-icon-split">
                        <span class="text">' . $row->type . '</span>
                    </div></center>';
            })
            ->rawColumns(['action', 'username', 'status_formatted', 'type_formatted', 'formatted_amount', 'formatted_created_at'])
            ->make(true);
    }

    public function getDetailTransaction($id)
    {
        $data = Transaction::where('id', $id)->with(['user', 'items'])->get();

        return view('admin-transaction.detail-transaction', [
            'title' => 'Detail Transaksi',
            'datas' => $data,
        ]);
    }

    // pembayaran
    public function indexPayment()
    {
        return view('admin-history-payment.payment', [
            'title' => 'Riwayat Pembayaran',
            'datas' => PaymentCode::all(),
        ]);
    }

    public function getPayment(Request $request)
    {
        $data = PaymentCode::query();

        if (isset($request->date)) {
            $data->whereDate('created_at', $request->date);
        }
        if (isset($request->status)) {
            $data->where('status', $request->status);
        }
        if (isset($request->type)) {
            $data->where('type', $request->type);
        }

        return Datatables::of($data)
            ->addColumn('username', function ($row) {
                return $row->user ? $row->user->username : '';
            })
            ->addColumn('cashier', function ($row) {
                return $row->user ? $row->cashier->username : '';
            })
            ->addColumn('formatted_created_at', function ($row) {
                return $row->created_at ? $row->created_at->format('d-m-Y (H:i:s)') : '';
            })
            ->addColumn('action', function ($data) {
                return view('admin-history-payment.action')->with('data', $data);
            })
            ->addColumn('formatted_amount', function ($row) {
                return $row->amount ? 'Rp. ' . number_format($row->amount, 0, ',', '.') : 'Rp. 0';
            })
            ->addColumn('status_formatted', function ($row) {
                $btnClass = $row->status == 'success' ? 'btn-success' : ($row->status == 'pending' ? 'btn-warning' : 'btn-danger');
                return '<center><div class="btn ' . $btnClass . ' btn-icon-split">
                        <span class="text">' . $row->status . '</span>
                    </div></center>';
            })
            ->addColumn('type_formatted', function ($row) {
                $btnClass = $row->type == 'paylater' ? 'btn-warning' : ($row->type == 'cash' || $row->type == 'tunai' ? 'btn-success' : 'btn-info');
                return '<center><div class="btn ' . $btnClass . ' btn-icon-split">
                        <span class="text">' . $row->type . '</span>
                    </div></center>';
            })
            ->rawColumns(['action', 'username', 'cashier', 'status_formatted', 'type_formatted', 'formatted_amount', 'formatted_created_at'])
            ->make(true);
    }

    public function getDetailPayment($id)
    {
        $data = PaymentCode::where('id', $id)->with(['user', 'items'])->get();

        return view('admin-transaction.detail-transaction', [
            'title' => 'Detail Transaksi',
            'datas' => $data,
        ]);
    }
}
