@extends('layouts.app')


@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                <i class="fas fa-shopping-cart text-blue-500"></i>
                Keranjang Peminjaman
            </h1>
            <p class="text-gray-600 mt-1">Barang yang akan dipinjam</p>
        </div>
        
        @if(count($cartItems) > 0)
        <div class="flex items-center gap-3">
            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-medium">
                {{ count($cartItems) }} item
            </span>
        </div>
        @endif
    </div>

    @if(count($cartItems) > 0)
    <!-- Table -->
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Barang</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Barang</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($cartItems as $index => $item)
                    <tr id="row-{{ $item['id'] }}" class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $item['kode_barang'] }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $item['nama_barang'] }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <div class="flex items-center gap-2">
                                <button class="btn-qty" data-action="decrement" data-id="{{ $item['id'] }}"
                                        class="w-8 h-8 border border-gray-300 bg-white rounded-lg hover:bg-gray-50 flex items-center justify-center">
                                    -
                                </button>
                                
                                <span id="qty-{{ $item['id'] }}" class="font-medium min-w-[20px] text-center">
                                    {{ $item['jumlah'] }}
                                </span>
                                
                                <button class="btn-qty" data-action="increment" data-id="{{ $item['id'] }}"
                                        class="w-8 h-8 border border-gray-300 bg-white rounded-lg hover:bg-gray-50 flex items-center justify-center">
                                    +
                                </button>
                            </div>
                            <div class="text-xs text-gray-500 mt-1">
                                Max: {{ $item['max_stok'] }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <button class="remove-item-btn bg-red-50 text-red-600 hover:bg-red-100 px-3 py-1 rounded-lg text-sm font-medium"
                                    data-id="{{ $item['id'] }}">
                                <i class="fas fa-trash mr-1"></i> Hapus
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="bg-white rounded-xl shadow p-6">
        <div class="flex flex-col sm:flex-row gap-4">
            <a href="{{ route('borrowing.pinjam') }}" 
               class="inline-flex items-center justify-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-3 rounded-lg font-medium">
                <i class="fas fa-arrow-left"></i>
                Tambah Barang Lagi
            </a>
            
            <button id="clearCartBtn"
                    class="inline-flex items-center justify-center gap-2 bg-gray-500 hover:bg-gray-600 text-white px-4 py-3 rounded-lg font-medium">
                <i class="fas fa-trash-alt"></i>
                Kosongkan Keranjang
            </button>
            
            <button id="submitPeminjamanBtn"
                    class="inline-flex items-center justify-center gap-2 bg-blue-500 hover:bg-blue-600 text-white px-4 py-3 rounded-lg font-medium ml-auto">
                <i class="fas fa-paper-plane"></i>
                Kirim Permintaan Peminjaman
            </button>
        </div>
        
        <!-- Info -->
        <div class="mt-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
            <p class="text-blue-700 text-sm">
                <i class="fas fa-info-circle mr-2"></i>
                <strong>Perhatian:</strong> Setelah mengirim permintaan, admin akan meninjau dan menyetujui peminjaman Anda. 
                Status akan berubah dari <strong>Pending</strong> menjadi <strong>Dipinjam</strong> setelah disetujui.
            </p>
        </div>
    </div>
    
    @else
    <!-- Empty Cart -->
    <div class="bg-white rounded-xl shadow p-8 text-center">
        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-shopping-cart text-3xl text-gray-400"></i>
        </div>
        <h3 class="text-xl font-semibold text-gray-700 mb-2">Keranjang Kosong</h3>
        <p class="text-gray-500 mb-6">Belum ada barang yang ditambahkan ke keranjang</p>
        
        <a href="{{ route('borrowing.pinjam') }}" 
           class="inline-flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg font-medium">
            <i class="fas fa-boxes"></i>
            Pinjam Barang
        </a>
    </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Event listener untuk tombol + dan -
    document.querySelectorAll('.btn-qty').forEach(button => {
        button.addEventListener('click', function() {
            const itemId = this.getAttribute('data-id');
            const action = this.getAttribute('data-action');
            updateQty(itemId, action);
        });
    });
    
    // Event listener untuk tombol hapus
    document.querySelectorAll('.remove-item-btn').forEach(button => {
        button.addEventListener('click', function() {
            const itemId = this.getAttribute('data-id');
            removeItem(itemId);
        });
    });
    
    // Event listener untuk tombol kosongkan keranjang
    document.getElementById('clearCartBtn')?.addEventListener('click', clearCart);
    
    // Event listener untuk tombol submit peminjaman
    document.getElementById('submitPeminjamanBtn')?.addEventListener('click', submitPeminjaman);
});

// Update jumlah barang
function updateQty(itemId, action) {
    const currentQty = parseInt(document.getElementById('qty-' + itemId).textContent);
    let newQty = currentQty;
    
    if (action === 'increment') {
        newQty = currentQty + 1;
    } else if (action === 'decrement' && currentQty > 1) {
        newQty = currentQty - 1;
    }
    
    // Kirim request ke server
    fetch('{{ route("borrowing.cart.update") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            inventory_id: itemId,
            action: action
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('qty-' + itemId).textContent = newQty;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat mengupdate jumlah');
    });
}

// Hapus item dari keranjang
function removeItem(itemId) {
    if (!confirm('Hapus barang ini dari keranjang?')) return;
    
    fetch('{{ route("borrowing.cart.remove") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            inventory_id: itemId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Hapus row dari tabel
            const row = document.getElementById('row-' + itemId);
            if (row) row.remove();
            
            // Jika tidak ada row lagi, reload halaman
            const remainingRows = document.querySelectorAll('tbody tr').length;
            if (remainingRows === 0) {
                setTimeout(() => {
                    window.location.reload();
                }, 500);
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat menghapus barang');
    });
}

// Kosongkan keranjang
function clearCart() {
    if (!confirm('Kosongkan seluruh keranjang? Semua barang akan dihapus.')) return;
    
    window.location.href = '{{ route("borrowing.cart.clear") }}';
}

// Submit peminjaman
function submitPeminjaman() {
    if (!confirm('Kirim permintaan peminjaman? Setelah dikirim, tidak dapat diubah.')) return;
    
    const submitBtn = document.getElementById('submitPeminjamanBtn');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengirim...';
    submitBtn.disabled = true;
    
    fetch('{{ route("borrowing.submit") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (response.ok) {
            return response.json();
        }
        throw new Error('Network response was not ok');
    })
    .then(data => {
        if (data.success) {
            alert(data.message);
            window.location.href = '{{ route("borrowing.riwayat") }}';
        } else {
            alert(data.message || 'Terjadi kesalahan');
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan. Silakan coba lagi.');
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
}
</script>
@endsection