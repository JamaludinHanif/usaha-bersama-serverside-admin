{{-- @extends('layouts.app') --}}

{{-- @section('content') --}}
    <h1>Kasir</h1>
    <form action="{{ route('cashier.store') }}" method="POST">
        @csrf
        <table>
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>
                        <input type="number" name="products[{{ $product->id }}][quantity]" min="0" max="{{ $product->stock }}">
                        <input type="hidden" name="products[{{ $product->id }}][id]" value="{{ $product->id }}">
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <button type="submit">Bayar</button>
    </form>
{{-- @endsection --}}
