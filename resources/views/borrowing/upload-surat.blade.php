@extends('borrowing.layouts.app')

@section('title', 'Upload Surat Peminjaman')
@section('page-title', 'Upload Surat Peminjaman')

@section('content')

<div class="card">
    <div style="text-align: center; margin-bottom: 30px;">
        <i class="fas fa-file-contract" style="font-size: 60px; color: #3b82f6;"></i>
        <h2 style="margin-top: 15px;">Upload Surat Peminjaman</h2>
        <p style="color: #64748b;">
            Untuk peminjaman jangka panjang atau membawa barang keluar kampus
        </p>
        
        <div style="margin-top: 20px;">
            <a href="{{ route('borrowing.surat.template') }}" class="btn btn-success">
                <i class="fas fa-download"></i> Unduh Template Surat (.docx)
            </a>
            <a href="{{ route('borrowing.surat.list') }}" class="btn" style="background: #f1f5f9; color: #475569; margin-left: 10px;">
                <i class="fas fa-list"></i> Lihat Surat Saya
            </a>
        </div>
    </div>
    
    @if(session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
    @endif
    
    @if(session('error'))
    <div class="alert alert-error">
        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
    </div>
    @endif
    
    <form method="POST" action="{{ route('borrowing.surat.store') }}" enctype="multipart/form-data" id="uploadForm">
        @csrf
        
        <div style="max-width: 600px; margin: 0 auto;">
            
            <div style="background: #f0f9ff; padding: 20px; border-radius: 10px; margin-bottom: 25px;">
                <h4 style="margin-top: 0; color: #0369a1;">
                    <i class="fas fa-info-circle"></i> Petunjuk Pengisian
                </h4>
                <ol style="margin: 10px 0 0 20px; color: #475569;">
                    <li>Unduh template surat di atas</li>
                    <li>Isi data di template menggunakan Microsoft Word/LibreOffice</li>
                    <li>Cetak dan tanda tangani surat</li>
                    <li>Scan surat yang sudah ditandatangani menjadi PDF (atau foto jelas)</li>
                    <li>Upload file PDF/Word di form bawah ini</li>
                </ol>
            </div>
            
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; color: #475569; font-weight: 500;">
                    <i class="fas fa-user"></i> Nama Pemohon <span style="color: #ef4444;">*</span>
                </label>
                <input type="text" name="nama_pemohon" required 
                       value="{{ Auth::user()->name }}"
                       style="width: 100%; padding: 12px 15px; border: 1px solid #d1d5db; border-radius: 8px;"
                       placeholder="Nama lengkap sesuai KTM/KTP">
            </div>
            
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; color: #475569; font-weight: 500;">
                    <i class="fas fa-phone"></i> Nomor HP/WhatsApp <span style="color: #ef4444;">*</span>
                </label>
                <input type="tel" name="no_hp" required 
                       style="width: 100%; padding: 12px 15px; border: 1px solid #d1d5db; border-radius: 8px;"
                       placeholder="Contoh: 081234567890">
                <small style="display: block; margin-top: 5px; color: #64748b;">
                    Akan digunakan untuk konfirmasi dari admin
                </small>
            </div>
            
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; color: #475569; font-weight: 500;">
                    <i class="fas fa-calendar-alt"></i> Periode Peminjaman <span style="color: #ef4444;">*</span>
                </label>
                <div style="display: flex; align-items: center; gap: 15px; flex-wrap: wrap;">
                    <div style="flex: 1;">
                        <label style="font-size: 14px; color: #64748b;">Dari Tanggal</label>
                        <input type="date" name="tanggal_mulai" required 
                               min="{{ date('Y-m-d') }}"
                               style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 8px;">
                    </div>
                    <div style="flex: 1;">
                        <label style="font-size: 14px; color: #64748b;">Sampai Tanggal</label>
                        <input type="date" name="tanggal_selesai" required 
                               min="{{ date('Y-m-d') }}"
                               style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 8px;">
                    </div>
                </div>
            </div>
            
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; color: #475569; font-weight: 500;">
                    <i class="fas fa-file-alt"></i> Keperluan Peminjaman
                </label>
                <textarea name="keperluan" rows="3"
                          style="width: 100%; padding: 12px 15px; border: 1px solid #d1d5db; border-radius: 8px;"
                          placeholder="Contoh: Untuk penelitian tugas akhir, seminar fakultas, praktikum lapangan, dll."></textarea>
            </div>
            
            <div style="margin-bottom: 25px;">
                <label style="display: block; margin-bottom: 8px; color: #475569; font-weight: 500;">
                    <i class="fas fa-file-upload"></i> Upload Surat <span style="color: #ef4444;">*</span>
                </label>
                
                <div style="border: 2px dashed #3b82f6; border-radius: 10px; padding: 30px; text-align: center; background: #f8fafc; cursor: pointer;"
                     onclick="document.getElementById('fileInput').click()"
                     id="dropZone">
                    <i class="fas fa-cloud-upload-alt" style="font-size: 40px; color: #3b82f6;"></i>
                    <p style="margin: 15px 0 10px 0; color: #475569;">
                        <strong>Klik untuk memilih file atau drag file ke sini</strong>
                    </p>
                    <p style="color: #64748b; font-size: 14px;">
                        Format: PDF, DOC, DOCX (maksimal 5MB)
                    </p>
                </div>
                
                <input type="file" name="surat" id="fileInput" accept=".pdf,.doc,.docx" required 
                       style="display: none;" onchange="showFileName(this)">
                
                <div id="fileName" style="margin-top: 10px; display: none;">
                    <p style="margin: 0; color: #059669;">
                        <i class="fas fa-check-circle"></i> 
                        File terpilih: <span id="fileNameText"></span>
                    </p>
                </div>
            </div>
            
            <div style="display: flex; gap: 10px; justify-content: center; margin-top: 30px;">
                <a href="{{ route('borrowing.dashboard') }}" class="btn" 
                   style="background: #f1f5f9; color: #475569; padding: 12px 25px;">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary" id="submitBtn" style="padding: 12px 25px;">
                    <i class="fas fa-paper-plane"></i> Kirim Surat
                </button>
            </div>
            
        </div>
    </form>
</div>

<script>
// Tampilkan nama file yang dipilih
function showFileName(input) {
    if (input.files && input.files[0]) {
        const fileName = input.files[0].name;
        const fileSize = (input.files[0].size / 1024 / 1024).toFixed(2); // MB
        
        document.getElementById('fileNameText').textContent = 
            `${fileName} (${fileSize} MB)`;
        document.getElementById('fileName').style.display = 'block';
        
        // Validasi ukuran file
        if (input.files[0].size > 5 * 1024 * 1024) { // 5MB
            alert('Ukuran file terlalu besar! Maksimal 5MB.');
            input.value = '';
            document.getElementById('fileName').style.display = 'none';
        }
    }
}

// Drag and drop functionality
const dropZone = document.getElementById('dropZone');
const fileInput = document.getElementById('fileInput');

dropZone.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropZone.style.background = '#e0f2fe';
    dropZone.style.borderColor = '#1d4ed8';
});

dropZone.addEventListener('dragleave', (e) => {
    e.preventDefault();
    dropZone.style.background = '#f8fafc';
    dropZone.style.borderColor = '#3b82f6';
});

dropZone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropZone.style.background = '#f8fafc';
    dropZone.style.borderColor = '#3b82f6';
    
    if (e.dataTransfer.files.length) {
        fileInput.files = e.dataTransfer.files;
        showFileName(fileInput);
    }
});

// Form submission
document.getElementById('uploadForm').addEventListener('submit', function(e) {
    const submitBtn = document.getElementById('submitBtn');
    const originalText = submitBtn.innerHTML;
    
    // Validasi tanggal
    const mulai = document.querySelector('input[name="tanggal_mulai"]').value;
    const selesai = document.querySelector('input[name="tanggal_selesai"]').value;
    
    if (new Date(selesai) < new Date(mulai)) {
        alert('Tanggal selesai harus setelah tanggal mulai!');
        e.preventDefault();
        return;
    }
    
    // Show loading
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengupload...';
    submitBtn.disabled = true;
    
    // Re-enable button after 10 seconds (if error)
    setTimeout(() => {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }, 10000);
});
</script>

<style>
#dropZone:hover {
    background: #f0f9ff !important;
    border-color: #1d4ed8 !important;
}
</style>

@endsection