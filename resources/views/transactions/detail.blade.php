@extends('layouts.app')
@section('title')
    {{ $title }}
@endsection
@section('breadcrumbs')
    <ul class="breadcrumbs" style="color: white">
        <li class="nav-home">
            <a href="{{ route('dashboard') }}">
                <i class="flaticon-home" style="color: white"></i>
            </a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow" style="color: white"></i>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.transactions.index') }}" style="color: white">Transaksi</a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow" style="color: white"></i>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.transactions.index') }}" style="color: white">Riwayat Transaksi</a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow" style="color: white"></i>
        </li>
        <li class="nav-item">
            <a href="#" style="color: white">{{ $title }}</a>
        </li>
    </ul>
@endsection

@section('content')
    {{-- @dd($datas) --}}
    <div class="container my-5">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4>{{ $title }}</h4>
            </div>
            <div class="card-body">
                <!-- Informasi Transaksi -->
                <div class="row mb-5">
                    <div class="col-md-6">
                        <table>
                            <tr>
                                <td>
                                    <span class="mx-2">ID Transaksi</span>
                                </td>
                                <td>: <span class="fw-bold mx-1">#{{ $datas->code_invoice }}</span></td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="mx-2">Tanggal</span>
                                </td>
                                <td>: <span class="fw-bold mx-1">{{ $datas->created_at->translatedFormat('d F Y (H:i:s)') }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="mx-2">Nama Penjual</span></td>
                                <td>: <span class="fw-bold mx-1">{{ $datas->seller->shop_name }}</span></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table>
                            <tr>
                                <td><span class="mx-2">Nama Pelanggan</span></td>
                                <td>: <span class="fw-bold mx-1">{{ $datas->user->name ?? 'Pengguna tidak ditemukan' }}</span></td>
                            </tr>
                            <tr>
                                <td><span class="mx-2">Status</span></td>
                                <td>: <span
                                        class="badge text-white fw-bold mx-1 {{ $datas->status == 'pending' ? 'bg-warning' : ($datas->status == 'success' ? 'bg-success' : 'bg-danger') }}">
                                        {{ $datas->status }}
                                    </span></td>
                            </tr>
                            <tr>
                                <td><span class="mx-2">Invoice/Nota</span></td>
                                <td>: <span class="fw-bold mx-1"><a href="#" data-id="{{ $datas->id }}" class="downloadInvoice">Download Invoice</a></span></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Tabel Item Transaksi -->
                <h5 class="mb-3 mt-5">Daftar Item</h5>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Produk</th>
                                <th>Jumlah</th>
                                <th>Harga Satuan</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datas->items as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->product->name }}</td>
                                    <td>{{ $item->quantity }} {{ $item->product->unit }}</td>
                                    <td>Rp. {{ number_format($item->product->price, 0, ',', '.') }}</td>
                                    <td>Rp. {{ number_format($item->price, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="4" class="text-end">Total Harga :</th>
                                <th>Rp. {{ number_format($datas->amount, 0, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Tombol Aksi -->
                <div class="" style="margin-top: 50px">
                    <a href="javascript:history.back()" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    {{-- <script>
        $(document).ready(function() {
            var table = $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax: "{{ url('/api/transactions/transactions-json') }}",
                columns: [{
                        data: 'kode_invoice',
                        name: 'kode_invoice'
                    },
                    {
                        data: 'username',
                        name: 'username'
                    },
                    {
                        data: 'status_formatted',
                        name: 'status_formatted'
                    },
                    {
                        data: 'formatted_amount',
                        name: 'formatted_amount'
                    },
                    {
                        data: 'type_formatted',
                        name: 'type_formatted'
                    },
                    {
                        data: 'formatted_created_at',
                        name: 'formatted_created_at',
                        orderable: true,
                        searchable: true,
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ],
                preDrawCallback: function(settings) {
                    let date = $('#formFilter').find('[name="date"]').val();
                    let class_id = $('#formFilter').find('[name="class_id"]').val();

                    settings.ajax =
                        `{{ url('/api/transactions/transactions-json') }}?date=${date}&class_id=${class_id}`;
                }
            });

            // function untuk filter
            $('#formFilter').find('[name="date"]').change(function(e) {
                e.preventDefault();
                $('#myTable').DataTable().ajax.reload();
            });

            // function download pdf
            $('#generatePdfBtn').click(function() {
                let date = $('#date').val();
                alert(date)
                window.location.href = `/pdf/generate-pdf-logs-data?date=${date}`;
            });

        });
    </script> --}}
@endsection
