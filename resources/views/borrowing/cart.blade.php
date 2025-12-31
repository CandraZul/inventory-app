@extends('borrowing.layouts.app')

@section('title', 'Keranjang Peminjaman')
@section('page-title', 'Keranjang Peminjaman')

@section('content')

<div class="card">
    @if(count($cartItems) > 0)
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h3 style="margin: 0;">
            <i class="fas fa-shopping-cart"></i> Barang yang akan Dipinjam
        </h3>
        <span class="badge" style="background: #3b82f6; color: white; padding: 5px 15px; border-radius: 20px;">
            {{ count($cartItems) }} item
        </span>
    </div>
    
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8fafc; border-bottom: 2px solid #e5e7eb;">
                    <th style="padding: 12px; text-align: left; color: #475569;">No</th>
                    <th style="padding: 12px; text-align: left; color: #475569;">Kode Barang</th>
                    <th style="padding: 12px; text-align: left; color: #475569;">Nama Barang</th>
                    <th style="padding: 12px; text-align: left; color: #475569;">Jumlah</th>
                    <th style="padding: 12px; text-align: left; color: #475569;">Aksi</th>
                </tr>
            </thead>
            <tbody id="cartTableBody">
                @foreach($cartItems as $index => $item)
                <tr style="border-bottom: 1px solid #e5e7eb;" id="row-{{ $item['id'] }}">
                    <td style="padding: 15px;">{{ $loop->iteration }}</td>
                    <td style="padding: 15px;">{{ $item['kode_barang'] }}</td>
                    <td style="padding: 15px; font-weight: 500;">{{ $item['nama_barang'] }}</td>
                    <td style="padding: 15px;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <button class="btn-qty" data-action="decrement" data-id="{{ $item['id'] }}"
                                    style="width: 30px; height: 30px; border: 1px solid #d1d5db; background: white; border-radius: 6px; cursor: pointer;">
                                -
                            </button>
                            
                            <span id="qty-{{ $item['id'] }}" style="font-weight: 500;">
                                {{ $item['jumlah'] }}
                            </span>
                            
                            <button class="btn-qty" data-action="increment" data-id="{{ $item['id'] }}"
                                    style="width: 30px; height: 30px; border: 1px solid #d1d5db; background: white; border-radius: 6px; cursor: pointer;">
                                +
                            </button>
                        </div>
                        <small style="display: block; margin-top: 5px; color: #64748b;">
                            Max: {{ $item['max_stok'] }}
                        </small>
                    </td>
                    <td style="padding: 15px;">
                        <button class="btn btn-danger btn-sm remove-item-btn" data-id="{{ $item['id'] }}">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb;">
        <h4>Total: <span id="totalItems">{{ count($cartItems) }}</span> barang</h4>
        
        <div style="display: flex; gap: 15px; margin-top: 20px;">
            <a href="{{ route('borrowing.pinjam') }}" class="btn" style="background: #f1f5f9; color: #475569;">
                <i class="fas fa-arrow-left"></i> Tambah Barang Lagi
            </a>
            
            <button id="clearCartBtn" class="btn btn-secondary">
                <i class="fas fa-trash-alt"></i> Kosongkan Keranjang
            </button>
            
            <button id="submitPeminjamanBtn" class="btn btn-primary" style="margin-left: auto;">
                <i class="fas fa-paper-plane"></i> Kirim Permintaan Peminjaman
            </button>
        </div>
        
        <div style="background: #f0f9ff; border-left: 4px solid #3b82f6; padding: 15px; margin-top: 20px; border-radius: 8px;">
            <p style="margin: 0; color: #0369a1;">
                <i class="fas fa-info-circle"></i> 
                <strong>Perhatian:</strong> Setelah mengirim permintaan, admin akan meninjau dan menyetujui peminjaman Anda. 
                Status akan berubah dari <strong>Pending</strong> menjadi <strong>Dipinjam</strong> setelah disetujui.
            </p>
        </div>
    </div>
    
    @else
    <div style="text-align: center; padding: 40px;">
        <i class="fas fa-shopping-cart" style="font-size: 60px; color: #cbd5e1;"></i>
        <h3 style="margin-top: 20px; color: #64748b;">Keranjang Kosong</h3>
        <p style="color: #94a3b8;">Belum ada barang yang ditambahkan ke keranjang</p>
        
        <a href="{{ route('borrowing.pinjam') }}" class="btn btn-primary" style="margin-top: 20px;">
            <i class="fas fa-boxes"></i> Pinjam Barang
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
            document.getElementById('row-' + itemId).remove();
            
            // Update total items
            const remainingRows = document.querySelectorAll('#cartTableBody tr').length;
            document.getElementById('totalItems').textContent = remainingRows;
            
            // Jika keranjang kosong, reload halaman
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
    
    // Redirect ke route clear cart
    window.location.href = '{{ route("borrowing.cart.clear") }}';
}

// Submit peminjaman
function submitPeminjaman() {
    if (!confirm('Kirim permintaan peminjaman? Setelah dikirim, tidak dapat diubah.')) return;
    
    // Show loading
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