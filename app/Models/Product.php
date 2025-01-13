<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class Product extends Model
{
    use HasFactory, SoftDeletes; // Tambahkan SoftDeletes trait

    protected $fillable = [
        'name',
        'price',
        'unit',
        'category',
        'stock',
        'weight',
        'length',
        'width',
        'height',
        'description',
        'image',
        'slug',
    ];

    /**
     *  Helper methods
     * */
    public function priceFormatted()
    {
        return 'Rp. ' . number_format($this->price);
    }

    public function generateSlug()
    {
        $base = Str::of($this->name)->slug('-');

        $found = false;
        $iter = 0;
        $slug = '';
        while (!$found) {
            $slug = $iter > 0 ? $base . '-' . $iter : $base;
            $page = self::where('slug', $slug)
                ->where('id', '!=', $this->id)
                ->first();

            if ($page) {
                $iter++;
            } else {
                $found = true;
            }
        }

        $this->update([
            'slug' => $slug,
        ]);

        return $this;
    }

    public function getLink()
    {
        return url($this->fullSlug());
    }

    public function fullSlug()
    {
        return route('buyer.product.detail', $this->slug);
    }

    public function modifiedAt()
    {
        return $this->updated_at ?? $this->created_at;
    }

    /**
     *  CRUD methods
     * */
    public static function createProduct($request)
    {
        $product = self::create([
            'name' => $request->name,
            'unit' => $request->unit,
            'category' => $request->category,
            'price' => $request->price,
            'stock' => $request->stock,
            'weight' => $request->weight,
            'length' => $request->length,
            'width' => $request->width,
            'height' => $request->height,
            'description' => \Helper::fixContent($request->description),
            'image' => $request->image,
        ]);
        $product->generateSlug();

        return $product;
    }

    public function updateProduct($request)
    {
        $this->update([
            'name' => $request->name,
            'unit' => $request->unit,
            'category' => $request->category,
            'price' => $request->price,
            'stock' => $request->stock,
            'weight' => $request->weight,
            'length' => $request->length,
            'width' => $request->width,
            'height' => $request->height,
            'description' => \Helper::fixContent($request->description),
            'image' => $request->image,
        ]);
        $this->generateSlug();

        return $this;
    }

    public function deleteProduct()
    {
        return $this->delete();
    }

    /**
     *  Static methods
     * */
    public static function dataTable($request)
    {
        $data = self::query();

        if (isset($request->category)) {
            $data->where('category', $request->category);
        }

        if (isset($request->unit)) {
            $data->where('unit', $request->unit);
        }

        $data = $data->orderBy('updated_at', 'DESC');

        return DataTables::of($data)
            ->addColumn('thumbnail', function ($data) {
                $html = '<div class="d-flex justify-content-center"><img src="' . $data->image . '" width="50"></div> ';
                return $html;
            })
            ->addColumn('category', function ($data) {
                $btnClass = $data->category == 'minuman'
                ? 'btn-info'
                : ($data->category == 'makanan'
                    ? 'btn-success'
                    : ($data->category == 'pembersih'
                        ? 'btn-danger'
                        : 'btn-warning'));
                $category = '<div class="' . $btnClass . '"
                style="padding-top: 5px; padding-bottom: 5px; color: white; border-radius: 10px; font-size: 15px; text-align: center;">'
                . $data->category .
                    '</div>';
                return $category;
            })
            ->addColumn('unit', function ($data) {
                $btnClass2 = $data->unit == 'pcs'
                ? 'btn-info'
                : ($data->unit == 'dos'
                    ? 'btn-success'
                    : ($data->unit == 'pack'
                        ? 'btn-danger'
                        : 'btn-warning'));
                $unit = '<div class="' . $btnClass2 . '"
                style="padding-top: 5px; padding-bottom: 5px; color: white; border-radius: 10px; font-size: 15px; text-align: center;">'
                . $data->unit .
                    '</div>';
                return $unit;
            })
            ->addColumn('formatted_amount', function ($data) {
                return $data->priceFormatted();
            })
            ->addColumn('action', function ($data) {
                $button = '
                <div class="d-flex justify-content-center">
                    <div class="dropdown">
                        <button class="btn btn-primary px-2 py-1 dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Pilih Aksi
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('admin.product.detail', $data->id) . '" title="Detail Produk">
                                <i class="fa fa-eye mr-1"></i> Detail
                            <a class="dropdown-item" href="' . route('admin.product.edit', $data->id) . '" title="Edit Produk">
                                <i class="fas fa-pencil-alt mr-1"></i> Edit
                            </a>
                            <a class="dropdown-item delete" href="javascript:void(0)" data-delete-message="Yakin ingin menghapus?" data-delete-href="' . route('admin.product.delete', $data->id) . '">
                                <i class="fas fa-trash mr-1"></i> Hapus
                            </a>
                        </div>
                    </div>
                </div>';

                return $button;
            })
            ->rawColumns(['thumbnail', 'action', 'category', 'unit'])
            ->make(true);
    }

    public static function getBySlug($slug)
    {
        return self::where('slug', $slug)->first();
    }
}

// Product::create([
//     'name' => 'nabati ukuran 720g rasa coklat',
//     'price' => 2500,
//     'unit' => 'pcs',
//     'category' => 'makanan',
//     'image' => 'https://www.static-src.com/wcsstore/Indraprastha/images/catalog/full//105/MTA-27188906/nabati_wafer_nabati_50gr_-_coklat_rischeese-keju_full01_5d98abe1.jpg',
//     'stock' => 24
// ])

// Product::create([
//     'name' => 'Teh gelas cup kecil ukuran 200ml',
//     'price' => 1000,
//     'unit' => 'pcs',
//     'category' => 'minuman',
//     'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQnYOSy866mSQji7p8HVPMIwKfdoC732z5rMg&s',
//     'stock' => 100
// ])

// Product::create([
//     'name' => 'Teh gelas cup kecil isi 24',
//     'price' => 23000,
//     'unit' => 'dos',
//     'category' => 'minuman',
//     'image' => 'https://down-id.img.susercontent.com/file/id-11134207-7r98v-ltd9jl2olv6v94',
//     'stock' => 5
// ])

// Product::create([
//     'name' => 'rinso cair saset ukuran 10gram',
//     'price' => 1000,
//     'unit' => 'pcs',
//     'category' => 'pembersih',
//     'image' => 'https://images.tokopedia.net/img/cache/700/product-1/2020/9/28/14677532/14677532_50d6da2c-00e5-487e-8e2d-1c72b2144532_800_800',
//     'stock' => 100
// ])

// Product::create([
//     'name' => 'nabati all variant ukuran 16gram',
//     'price' => 1000,
//     'unit' => 'pack',
//     'category' => 'makanan',
//     'image' => 'https://down-id.img.susercontent.com/file/9897f81c8d6415e5f207ced234927e57',
//     'stock' => 20
// ])
