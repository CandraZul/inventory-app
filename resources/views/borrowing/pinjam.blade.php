@extends('borrowing.layouts.app')

@section('title', 'Pinjam Barang')
@section('page-title', 'Pinjam Barang')

@section('content')

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h3 style="margin: 0;">Daftar Barang Tersedia</h3>
        
        <!-- Cart Badge -->
        <div style="position: relative;">
            <a href="{{ route('borrowing.cart') }}" class="btn btn-primary" style="position: relative;">
                <i class="fas fa-shopping-cart"></i> Keranjang
                @if($cartCount > 0)
                <span style="position: absolute; top: -8px; right: -8px; background: #ef4444; color: white; border-radius: 50%; width: 20px; height: 20px; font-size: 12px; display: flex; align-items: center; justify-content: center;">
                    {{ $cartCount }}
                </span>
                @endif
            </a>
        </div>
    </div>
    
    <!-- Search Form -->
    <form method="GET" action="{{ route('borrowing.pinjam') }}" style="margin-bottom: 25px;">
        <div style="display: flex; gap: 10px; max-width: 500px;">
            <input type="text" 
                   name="search" 
                   placeholder="Cari nama barang..." 
                   value="{{ request('search') }}"
                   style="flex: 1; padding: 10px 15px; border: 1px solid #d1d5db; border-radius: 8px;">
            <button type="submit" class="btn" style="background: #3b82f6; color: white;">
                <i class="fas fa-search"></i> Cari
            </button>
        </div>
    </form>
    
    <!-- Tabel Barang -->
    @if($inventories->count() > 0)
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8fafc; border-bottom: 2px solid #e5e7eb;">
                    <th style="padding: 12px; text-align: left; color: #475569;">No</th>
                    <th style="padding: 12px; text-align: left; color: #475569;">Nama Barang</th>
                    <th style="padding: 12px; text-align: left; color: #475569;">Stok Tersedia</th>
                    <th style="padding: 12px; text-align: left; color: #475569;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($inventories as $item)
                <tr style="border-bottom: 1px solid #e5e7eb; transition: background 0.3s;">
                    <td style="padding: 15px;">{{ $loop->iteration }}</td>
                    <td style="padding: 15px; font-weight: 500;">{{ $item->nama_barang }}</td>
                    <td style="padding: 15px;">
                        <span style="padding: 5px 10px; background: #d1fae5; color: #065f46; border-radius: 20px; font-weight: 500;">
                            {{ $item->jumlah }}
                        </span>
                    </td>
                    <td style="padding: 15px;">
                        <button class="btn btn-primary btn-sm add-to-cart-btn"
                                data-id="{{ $item->id }}"
                                data-nama="{{ $item->nama_barang }}"
                                data-stok="{{ $item->jumlah }}"
                                {{ $item->jumlah == 0 ? 'disabled' : '' }}>
                            <i class="fas fa-cart-plus"></i> Tambah ke Keranjang
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <!-- Pagination -->
        <div style="margin-top: 20px;">
            {{ $inventories->links() }}
        </div>
    </div>
    @else
    <div style="text-align: center; padding: 40px;">
        <i class="fas fa-box-open" style="font-size: 60px; color: #cbd5e1;"></i>
        <p style="margin-top: 15px; color: #64748b;">Tidak ada barang ditemukan</p>
    </div>
    @endif
</div>

<!-- Modal Add to Cart -->
<div id="cartModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: white; width: 90%; max-width: 500px; border-radius: 12px; padding: 30px; position: relative;">
        <button onclick="closeModal()" style="position: absolute; top: 15px; right: 15px; background: none; border: none; font-size: 20px; cursor: pointer; color: #64748b;">
            &times;
        </button>
        
        <h3 style="margin-bottom: 20px;" id="modalTitle"></h3>
        
        <form id="cartForm">
            @csrf
            <input type="hidden" name="inventory_id" id="modalInventoryId">
            
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; color: #475569; font-weight: 500;">
                    <i class="fas fa-box"></i> Nama Barang
                </label>
                <input type="text" id="modalNamaBarang" readonly 
                       style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 8px; background: #f9fafb;">
            </div>
            
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; color: #475569; font-weight: 500;">
                    <i class="fas fa-layer-group"></i> Stok Tersedia
                </label>
                <input type="text" id="modalStok" readonly 
                       style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 8px; background: #f9fafb;">
            </div>
            
            <div style="margin-bottom: 25px;">
                <label style="display: block; margin-bottom: 8px; color: #475569; font-weight: 500;">
                    <i class="fas fa-hashtag"></i> Jumlah yang Dipinjam
                </label>
                <div style="display: flex; align-items: center; gap: 15px;">
                    <button type="button" onclick="decrementQty()" 
                            style="width: 40px; height: 40px; border: 1px solid #d1d5db; background: white; border-radius: 8px; font-size: 18px; cursor: pointer;">
                        -
                    </button>
                    
                    <input type="number" name="jumlah" id="modalQty" value="1" min="1" 
                           style="width: 80px; text-align: center; padding: 10px; border: 1px solid #3b82f6; border-radius: 8px;">
                    
                    <button type="button" onclick="incrementQty()" 
                            style="width: 40px; height: 40px; border: 1px solid #d1d5db; background: white; border-radius: 8px; font-size: 18px; cursor: pointer;">
                        +
                    </button>
                </div>
                <small style="display: block; margin-top: 5px; color: #64748b;">
                    Masukkan jumlah yang ingin dipinjam (max: <span id="modalMax"></span>)
                </small>
            </div>
            
            <div style="display: flex; gap: 10px; justify-content: flex-end;">
                <button type="button" onclick="closeModal()" class="btn" 
                        style="background: #f1f5f9; color: #475569;">
                    Batal
                </button>
                <button type="button" onclick="addToCart()" class="btn btn-primary">
                    <i class="fas fa-cart-plus"></i> Tambah ke Keranjang
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Variabel untuk modal
let currentMaxStok = 0;

// Event listener untuk tombol "Tambah ke Keranjang"
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
    
    document.getElementById('cartModal').style.display = 'flex';
}

function closeModal() {
    document.getElementById('cartModal').style.display = 'none';
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
    const submitBtn = document.querySelector('#cartForm button[type="button"]');
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

// Close modal when clicking outside
document.getElementById('cartModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});
</script>

@endsection