<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;

class Seller extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'shop_name',
        'email',
        'no_hp',
        'profit', // profit adalah keuntungan yang didapat si penjual
        'password',
        'image',
        'location',
        'status',
    ];

    // relasi

    /**
     *  Helper methods
     * */

    public function statusHtml()
    {
        if ($this->status == 'Buka') {
            return '<span class="text-success"> Buka </span>';
        } else if ($this->status == 'Tutup') {
            return '<span class="text-default"> Tutup </span>';
        } else {
            return '<span class="text-danger"> Diblokir </span>';
        }
    }

    public function imagePath()
    {
        return storage_path('app/public/image/seller/' . $this->image);
    }

    public function imageLink()
    {
        if ($this->isHasImage()) {
            return url('storage/image/seller/' . $this->image);
        } else {
            return url('img/no-image.jpg');
        }
    }

    public function isHasImage()
    {
        if (empty($this->image)) {
            return false;
        }

        return File::exists($this->imagePath());
    }

    public function removeImage()
    {
        if ($this->isHasImage()) {
            File::delete($this->imagePath());
            $this->update([
                'image' => null,
            ]);
        }

        return $this;
    }

    public function setImage($request)
    {
        if (!empty($request->image)) {
            $this->removeImage();
            $file = $request->file('image');
            $filename = $this->slug ?? date('Ymd_His');
            $filename = $filename . '.' . $file->getClientOriginalExtension();

            $file->move(storage_path('app/public/image/seller/'), $filename);
            $this->update([
                'image' => $filename,
            ]);
        }

        return $this;
    }

    /**
     *  CRUD methods
     * */
    public static function createSeller($request)
    {
        $product = self::create([
            'name' => $request->name,
            'shop_name' => $request->shop_name,
            'email' => $request->email,
            'profit' => $request->profit,
            'password' => $request->password,
            'location' => $request->location,
            'status' => 'Tutup',
            'no_hp' => $request->no_hp,
        ]);
        $product->setImage($request);

        return $product;
    }

    public function updateSeller($request)
    {
        $this->update([
            'name' => $request->name,
            'shop_name' => $request->shop_name,
            'email' => $request->email,
            'profit' => $request->profit,
            'password' => $request->password,
            'location' => $request->location,
            'status' => $request->status,
            'no_hp' => $request->no_hp,
        ]);
        $this->setImage($request);

        return $this;
    }

    public function deleteSeller()
    {
        $this->removeImage();
        return $this->delete();
    }

    /**
     *  Static methods
     * */
    public static function dataTable($request)
    {
        $data = self::query();

        if (isset($request->date)) {
            $data->whereDate('created_at', $request->date);
        }

        if (isset($request->status)) {
            $data->where('status', $request->status);
        }

        $data = $data->orderBy('updated_at', 'DESC');

        return DataTables::of($data)
            ->addColumn('status', function ($data) {
                $btnClass = $data->status == 'pcs'
                ? 'btn-info'
                : ($data->status == 'Buka'
                    ? 'btn-success'
                    : ($data->status == 'Tutup'
                        ? 'btn-warning'
                        : 'btn-danger'));
                $status = '<div class="' . $btnClass . '"
            style="padding-top: 5px; padding-bottom: 5px; color: white; border-radius: 10px; font-size: 15px; text-align: center;">'
                . $data->status .
                    '</div>';
                return $status;
            })
            ->addColumn('profit', function ($data) {
                $profit = e($data->profit); // Escape untuk mencegah XSS
                $html = '<div style="text-align:center;font-size:18px;font-weight:bold">' . $profit . ' %</div>';
                return $html;
            })
            ->addColumn('no_hp', function ($data) {
                $html = '<a href="https://wa.me/' . $data->no_hp . '" style="text-align:center;">' . $data->no_hp . '</a>';
                return $html;
            })
            ->addColumn('image', function ($data) {
                $html = '<div class="d-flex justify-content-center"><img src="' . $data->imageLink() . '" width="70"></div>';
                return $html;
            })
            ->addColumn('action', function ($data) {
                $button = '
                <div class="d-flex justify-content-center">
                    <div class="dropdown">
                        <button class="btn btn-primary px-2 py-1 dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Pilih Aksi
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('admin.seller.detail', $data->id) . '" title="Detail Penjual">
                                <i class="fa fa-eye mr-1"></i> Detail
                            <a class="dropdown-item" href="' . route('admin.seller.edit', $data->id) . '" title="Edit Penjual">
                                <i class="fas fa-pencil-alt mr-1"></i> Edit
                            </a>
                            <a class="dropdown-item delete" href="javascript:void(0)" data-delete-message="Yakin ingin menghapus?" data-delete-href="' . route('admin.seller.delete', $data->id) . '">
                                <i class="fas fa-trash mr-1"></i> Hapus
                            </a>
                        </div>
                    </div>
                </div>';

                return $button;
            })
            ->rawColumns(['status', 'no_hp', 'profit', 'image', 'action'])
            ->make(true);
    }

}
