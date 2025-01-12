@extends('layouts.seller')
@section('content')
    <div class="container mx-auto p-4 mb-44">
        <h1 class="text-2xl font-bold mb-4">{{ $title }}</h1>
        <form id="formCashier" class="bg-white mt-14">
            <div class="overflow-x-auto">
                <table class="table-auto w-full text-left border-collapse border border-gray-300" id="product-table">
                    <thead>
                        <tr class="bg-gray-100 border-b">
                            <th class="px-4 py-2 border" style="min-width: 250px;">Produk</th>
                            <th class="px-4 py-2 border" style="min-width: 150px;">Harga</th>
                            <th class="px-4 py-2 border">Kuantitas</th>
                            <th class="px-4 py-2 border" style="min-width: 150px;">Total</th>
                            <th class="px-4 py-2 border">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Rows dynamically generated -->
                    </tbody>
                </table>
            </div>
            <div class="mt-10 text-center">
                <h3 class="text-lg font-semibold">
                    Total Keseluruhan:
                    <span id="grand-total" class="text-green-600">Rp 0</span>
                </h3>
            </div>
            <div class="flex justify-center items-center mt-14">
                <button id="add-product" type="button"
                    class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                    Tambah Produk <span class="ml-1 fas fa-plus-square"></span>
                </button>
                <button type="submit" class="ml-5 bg-green-500 text-white px-6 py-2 rounded-md hover:bg-green-600">
                    Bayar <span class="ml-1 far fa-check-circle"></span>
                </button>
            </div>
        </form>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            let productCount = 0;

            // Function to format currency
            function formatCurrency(amount) {
                return 'Rp ' + amount.toLocaleString('id-ID');
            }

            // Function to calculate grand total
            function calculateGrandTotal() {
                let grandTotal = 0;
                $('.total-price').each(function() {
                    grandTotal += parseFloat($(this).data('total'));
                });
                $('#grand-total').text(formatCurrency(grandTotal));
            }

            // function input
            function addProductRow() {
                productCount++;
                const row = `
                <tr id="row-${productCount}" class="border-b hover:bg-gray-50">
                    <td class="px-4 py-2 border">
                        <select class="form-select product-select w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="data[${productCount}][product_id]" required>
                            <option value="" disabled selected>Cari Produk</option>
                        </select>
                    </td>
                    <td class="px-4 py-2 border price text-gray-700">Rp 0</td>
                    <td class="px-4 py-2 border">
                        <select name="data[${productCount}][quantity]" class="quantity w-16 p-2 border rounded-md text-center">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                        </select>
                    </td>
                    <td class="px-4 py-2 border total-price text-gray-700" data-total="0">Rp 0</td>
                    <td class="px-4 py-2 border text-center">
                        <button type="button" class="bg-red-500 text-white px-2 py-1 rounded-md remove-row hover:bg-red-600" data-row-id="row-${productCount}">
                            Hapus
                        </button>
                    </td>
                </tr>`;
                $('#product-table tbody').append(row);

                // Initialize Select2 for the new product select
                $(`#row-${productCount} .product-select`).select2({
                    placeholder: 'Cari Produk',
                    ajax: {
                        url: '{{ route('seller.get.product') }}',
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                search: params.term
                            };
                        },
                        processResults: function(data) {
                            return {
                                results: data.map(item => ({
                                    id: item.id,
                                    text: item.name,
                                    price: item.price
                                }))
                            };
                        },
                        cache: true
                    }
                }).on('select2:select', function(e) {
                    const price = e.params.data.price;
                    const row = $(this).closest('tr');
                    row.find('.price').text(formatCurrency(price));
                    row.find('.total-price').text(formatCurrency(price)).data('total', price);
                    calculateGrandTotal();
                });
            }


            // Add product row
            $(document).ready(function() {
                addProductRow();

                $('#add-product').click(function() {
                    addProductRow();
                });
            });


            // Update total when quantity changes
            $(document).on('change', '.quantity', function() {
                const row = $(this).closest('tr');
                // Mengambil harga dan menghapus simbol 'Rp' serta pemisah ribuan (titik)
                const price = parseFloat(row.find('.price').text().replace('Rp ', '').replace(/\./g, ''));
                const quantity = parseInt($(this).val());
                const total = price * quantity;
                row.find('.total-price').text(formatCurrency(total)).data('total', total);
                calculateGrandTotal();
            });

            // Remove row
            $(document).on('click', '.remove-row', function() {
                const rowId = $(this).data('row-id');
                $(`#${rowId}`).remove();
                calculateGrandTotal();
            });

            // checkout
            $(function() {

                const $formCashier = $('#formCashier');
                const $formCashierSubmitBtn = $formCashier.find(`[type="submit"]`);
                const originalBtnText = $formCashierSubmitBtn.text(); // Simpan teks asli tombol

                $formCashier.on('submit', function(e) {
                    e.preventDefault();
                    $('.message-error').html('');

                    const formData = $(this).serialize();
                    $formCashierSubmitBtn.prop('disabled', true).text(
                        'Loading...'); // Ubah teks tombol dan disable

                    ajaxSetup();
                    $.ajax({
                            url: `{{ route('seller.checkout') }}`,
                            method: 'post',
                            data: formData,
                            dataType: 'json'
                        })
                        .done(response => {
                            alertTailwind('Berhasil!',
                                response.message, 'success'
                            );
                            $formCashierSubmitBtn.prop('disabled', false).text(
                                originalBtnText);
                            setTimeout(() => {
                                location.href = `{{ route('seller.history') }}`;
                            }, 1500)
                        })
                        .fail(error => {
                            $formCashierSubmitBtn.prop('disabled', false).text(
                                originalBtnText);
                            if (error.responseJSON) {
                                if (error.responseJSON.errors) {
                                    const validationErrors = Object.values(error.responseJSON
                                            .errors)
                                        .map(errArray => errArray.join('<br>'))
                                        .join('<br>');
                                    alertTailwind('Pesan Validasi!', validationErrors,
                                        'warning');
                                } else {
                                    const errorMessage = error.responseJSON.message || error
                                        .responseJSON
                                        .details;
                                    alertTailwind('Gagal!', errorMessage, 'error');
                                }
                            } else {
                                alertTailwind('Error!',
                                    'An unexpected error occurred. Please try again.',
                                    'error');
                            }
                        });
                });
            });
        });
    </script>
@endsection
