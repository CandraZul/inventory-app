@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Pinjam Barang</h1>
            <p class="text-gray-600 mt-1">Daftar barang tersedia untuk dipinjam</p>
        </div>
        
        <!-- Cart Badge -->
        <div class="relative">
            <a href="{{ route('borrowing.cart') }}" 
               class="inline-flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white px-4 py-3 rounded-lg font-medium relative">
                <i class="fas fa-shopping-cart"></i>
                Keranjang
                @if($cartCount > 0)
                <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs w-6 h-6 rounded-full flex items-center justify-center">
                    {{ $cartCount }}
                </span>
                @endif
            </a>
        </div>
    </div>
    
    <!-- Search Form -->
    <form method="GET" action="{{ route('borrowing.pinjam') }}" class="mb-6">
        <div class="flex flex-col sm:flex-row gap-3 max-w-lg">
            <input type="text" 
                   name="search" 
                   placeholder="Cari nama barang..." 
                   value="{{ request('search') }}"
                   class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            <button type="submit" 
                    class="inline-flex items-center justify-center gap-2 bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg font-medium">
                <i class="fas fa-search"></i>
                Cari
            </button>
        </div>
    </form>
    
    <!-- Tabel Barang -->
    @if($inventories->count() > 0)
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Barang</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stok Tersedia</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($inventories as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $item->nama_barang }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                {{ $item->jumlah }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <button class="add-to-cart-btn inline-flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium disabled:opacity-50 disabled:cursor-not-allowed"
                                    data-id="{{ $item->id }}"
                                    data-nama="{{ $item->nama_barang }}"
                                    data-stok="{{ $item->jumlah }}"
                                    {{ $item->jumlah == 0 ? 'disabled' : '' }}>
                                <i class="fas fa-cart-plus"></i>
                                Tambah ke Keranjang
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($inventories->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $inventories->links() }}
        </div>
        @endif
    </div>
    
    @else
    <!-- Empty State -->
    <div class="bg-white rounded-xl shadow p-8 text-center">
        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-box-open text-3xl text-gray-400"></i>
        </div>
        <h3 class="text-xl font-semibold text-gray-700 mb-2">Tidak ada barang ditemukan</h3>
        <p class="text-gray-500">Coba gunakan kata kunci pencarian yang berbeda</p>
    </div>
    @endif
</div>

<!-- Modal Add to Cart -->
<div id="cartModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-md">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800" id="modalTitle"></h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <form id="cartForm" class="p-6">
            @csrf
            <input type="hidden" name="inventory_id" id="modalInventoryId">
            
            <div class="space-y-4">
                <!-- Nama Barang -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fas fa-box mr-2"></i>Nama Barang
                    </label>
                    <input type="text" id="modalNamaBarang" readonly 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-700">
                </div>
                
                <!-- Stok Tersedia -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fas fa-layer-group mr-2"></i>Stok Tersedia
                    </label>
                    <input type="text" id="modalStok" readonly 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-700">
                </div>
                
                <!-- Jumlah -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fas fa-hashtag mr-2"></i>Jumlah yang Dipinjam
                    </label>
                    <div class="flex items-center gap-3">
                        <button type="button" onclick="decrementQty()" 
                                class="w-10 h-10 border border-gray-300 bg-white rounded-lg hover:bg-gray-50 flex items-center justify-center">
                            -
                        </button>
                        
                        <input type="number" name="jumlah" id="modalQty" value="1" min="1" 
                               class="w-20 px-3 py-2 border border-blue-500 rounded-lg text-center">
                        
                        <button type="button" onclick="incrementQty()" 
                                class="w-10 h-10 border border-gray-300 bg-white rounded-lg hover:bg-gray-50 flex items-center justify-center">
                            +
                        </button>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">
                        Masukkan jumlah yang ingin dipinjam (max: <span id="modalMax"></span>)
                    </p>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="flex gap-3 justify-end mt-6">
                <button type="button" onclick="closeModal()" 
                        class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                    Batal
                </button>
                <button type="button" onclick="addToCart()" 
                        class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 inline-flex items-center gap-2">
                    <i class="fas fa-cart-plus"></i>
                    Tambah ke Keranjang
                </button>
            </div>
        </form>
    </div>
</div>

<script>
let currentMaxStok = 0;

document.addEventListener('DOMContentLoaded', function() {
    const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');
    
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const nama = this.getAttribute('data-nama');
            const stok = this.getAttribute('data-stok');
            
            showAddToCartModal(id, nama, stok);
        });
    });
    
    document.getElementById('cartModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });
});

function showAddToCartModal(id, nama, stok) {
    currentMaxStok = parseInt(stok);
    
    document.getElementById('modalInventoryId').value = id;
    document.getElementById('modalNamaBarang').value = nama;
    document.getElementById('modalStok').value = stok;
    document.getElementById('modalQty').value = 1;
    document.getElementById('modalQty').max = stok;
    document.getElementById('modalMax').textContent = stok;
    document.getElementById('modalTitle').textContent = 'Pinjam: ' + nama;
    
    document.getElementById('cartModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('cartModal').classList.add('hidden');
}

function incrementQty() {
    const qtyInput = document.getElementById('modalQty');
    let current = parseInt(qtyInput.value);
    if (current < currentMaxStok) {
        qtyInput.value = current + 1;
    }
}

function decrementQty() {
    const qtyInput = document.getElementById('modalQty');
    let current = parseInt(qtyInput.value);
    if (current > 1) {
        qtyInput.value = current - 1;
    }
}

function addToCart() {
    const form = document.getElementById('cartForm');
    const formData = new FormData(form);
    
    // Tampilkan loading
    const submitBtn = document.querySelector('#cartForm button[type="button"]:last-child');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menambahkan...';
    submitBtn.disabled = true;
    
    fetch('{{ route("borrowing.cart.add") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            closeModal();
            // Refresh halaman untuk update cart count
            window.location.reload();
        } else {
            alert(data.message);
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