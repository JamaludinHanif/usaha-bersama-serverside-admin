@extends('layouts.buyer')
@section('style')
@endsection
@section('content')
    <div class="bg-gray-100 p-3 lg:p-4 py-10 lg:px-5">
        <div
            class="bg-white py-2 lg:py-4 px-3 cursor-text hover:opacity-80 border rounded-xl w-11/12 lg:w-8/12 m-auto mb-5 lg:mb-10 flex flex-row justify-between items-center">
            <input type="text" id="search-box" placeholder="Cari Nabati, Gelas...."
                class="text-sm text-gray-500 focus:outline-none focus:border-none w-11/12" />
            <li class="fas fa-search"></li>
        </div>

        <div role="list"
            class="search-results grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-3 sm:gap-x-6 lg:grid-cols-4 xl:gap-x-8"
            id="search-results">
            @foreach (App\Models\Product::all() as $product)
                <a href="{{ route('buyer.product.detail', $product->slug) }}"
                    class="relative rounded-lg border bg-white hover:opacity-75 cursor-pointer shadow-lg group overflow-hidden transform transition-transform duration-300 ease-in-out hover:scale-95">
                    <div
                        class="group overflow-hidden bg-gray-100 focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 focus-within:ring-offset-gray-100">
                        <img src="{{ $product->image }}" alt=""
                            class="pointer-events-none aspect-[10/7] object-cover group-hover:opacity-75">
                    </div>
                    <div class="px-2 py-1">
                        <div class="flex justify-between">
                            @if ($product->category === 'makanan')
                                <div class="bg-cyan-400 w-8/12 rounded-tr-xl my-1">
                                    <p class="text-white text-xs text-center">Makanan</p>
                                </div>
                                <div
                                    class="{{ $product->unit === 'pcs' ? 'bg-red-300' : ($product->unit === 'dos' ? 'bg-blue-300' : ($product->unit === 'pack' ? 'bg-green-300' : 'bg-yellow-300')) }} w-3/12 rounded-tl-xl my-1">
                                    <p class="text-white text-xs text-center">{{ $product->unit }}</p>
                                </div>
                            @elseif ($product->category === 'minuman')
                                <div class="bg-yellow-400 w-8/12 rounded-tr-xl my-1">
                                    <p class="text-white text-xs text-center">Minuman</p>
                                </div>
                                <div
                                    class="{{ $product->unit === 'pcs' ? 'bg-red-300' : ($product->unit === 'dos' ? 'bg-blue-300' : ($product->unit === 'pack' ? 'bg-green-300' : 'bg-yellow-300')) }} w-3/12 rounded-tl-xl my-1">
                                    <p class="text-white text-xs text-center">{{ $product->unit }}</p>
                                </div>
                            @elseif ($product->category === 'pembersih')
                                <div class="bg-pink-400 w-8/12 rounded-tr-xl my-1">
                                    <p class="text-white text-xs text-center">Pembersih</p>
                                </div>
                                <div
                                    class="{{ $product->unit === 'pcs' ? 'bg-red-300' : ($product->unit === 'dos' ? 'bg-blue-300' : ($product->unit === 'pack' ? 'bg-green-300' : 'bg-yellow-300')) }} w-3/12 rounded-tl-xl my-1">
                                    <p class="text-white text-xs text-center">{{ $product->unit }}</p>
                                </div>
                            @else
                                <div class="bg-gray-500 w-8/12 rounded-tr-xl my-1">
                                    <p class="text-white text-xs text-center">Lainnya</p>
                                </div>
                                <div
                                    class="{{ $product->unit === 'pcs' ? 'bg-red-300' : ($product->unit === 'dos' ? 'bg-blue-300' : ($product->unit === 'pack' ? 'bg-green-300' : 'bg-yellow-300')) }} w-3/12 rounded-tl-xl my-1">
                                    <p class="text-white text-xs text-center">{{ $product->unit }}</p>
                                </div>
                            @endif
                        </div>
                        <p class="pointer-events-none mt-1 line-clamp-2 text-xs font-medium text-gray-700">
                            {{ $product->name }}</p>
                        <p class="pointer-events-none block text-sm font-semibold mt-1.5 lg:mt-2 lg:mb-2">
                            {{ $product->priceFormatted() }}</p>
                    </div>
                </a>
            @endforeach
        </div>
        {{-- </div> --}}
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {

            $('#search-box').on('keyup', function() {
                let query = $(this).val();

                $.ajax({
                    url: '{{ route('buyer.product.search') }}',
                    type: 'GET',
                    data: {
                        query: query
                    },
                    success: function(data) {
                        $('#search-results').html('');

                        if (data.length > 0) {
                            data.forEach(product => {
                                // Tentukan warna berdasarkan kategori
                                let categoryClass = '';
                                let categoryName = '';
                                switch (product.category) {
                                    case 'makanan':
                                        categoryClass = 'bg-cyan-400';
                                        categoryName = 'Makanan';
                                        break;
                                    case 'minuman':
                                        categoryClass = 'bg-yellow-400';
                                        categoryName = 'Minuman';
                                        break;
                                    case 'pembersih':
                                        categoryClass = 'bg-pink-400';
                                        categoryName = 'Pembersih';
                                        break;
                                    default:
                                        categoryClass = 'bg-gray-500';
                                        categoryName = 'Lainnya';
                                }

                                // Tentukan warna berdasarkan unit
                                let unitClass = '';
                                switch (product.unit) {
                                    case 'pcs':
                                        unitClass = 'bg-red-300';
                                        break;
                                    case 'dos':
                                        unitClass = 'bg-blue-300';
                                        break;
                                    case 'pack':
                                        unitClass = 'bg-green-300';
                                        break;
                                    default:
                                        unitClass = 'bg-yellow-300';
                                }

                                // Tambahkan elemen ke hasil pencarian
                                $('#search-results').append(`
                                    <a href="{{ route('buyer.product.detail', $product->slug) }}" class="relative rounded-lg border bg-white hover:opacity-75 cursor-pointer shadow-lg group overflow-hidden transform transition-transform duration-300 ease-in-out hover:scale-95">
                                        <div
                                            class="group overflow-hidden bg-gray-100 focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 focus-within:ring-offset-gray-100">
                                            <img src="${product.image}"
                                                alt="" class="pointer-events-none aspect-[10/7] object-cover group-hover:opacity-75">
                                        </div>
                                        <div class="px-2 py-1">
                                            <div class="flex justify-between">
                                                                    <div class="${categoryClass} w-8/12 rounded-tr-xl my-1">
                                                                        <p class="text-white text-xs text-center">${categoryName}</p>
                                                                    </div>
                                                                    <div class="${unitClass} w-3/12 rounded-tl-xl my-1">
                                                                        <p class="text-white text-xs text-center">${product.unit}</p>
                                                                    </div>
                                                                </div>
                                            <p class="pointer-events-none mt-1 line-clamp-2 text-xs font-medium text-gray-500">${product.name}</p>
                                            <p class="pointer-events-none block text-base font-semibold mt-1.5 lg:mt-2 lg:mb-2">${formatRupiah(product.price)}</p>
                                        </div>
                                    </a>
                                `);
                            });

                        } else {
                            $('#search-results').html(
                                `<p>Produk ${query} tidak ditemukan </p>`);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });
        });
    </script>
@endsection
