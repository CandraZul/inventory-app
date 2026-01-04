@extends('layouts.app')

@section('title', 'Upload Surat Peminjaman')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="text-center mb-6">
            <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-file-contract text-3xl text-blue-500"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Upload Surat Peminjaman</h1>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Untuk peminjaman jangka panjang atau membawa barang keluar kampus
            </p>

            <div class="flex flex-wrap gap-3 justify-center mt-4">
                <a href="{{ route('borrowing.surat.template') . '?v=' . time() }}"
                   class="inline-flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white px-4 py-3 rounded-lg font-medium">
                    <i class="fas fa-download"></i>
                    Unduh Template Surat (.docx)
                </a>
                <a href="{{ route('borrowing.surat.list') }}"
                   class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-3 rounded-lg font-medium">
                    <i class="fas fa-list"></i>
                    Lihat Surat Saya
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                    <p class="text-green-800 font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                    <p class="text-red-800 font-medium">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <!-- Form -->
        <div class="bg-white rounded-xl shadow p-6">
            <form method="POST" action="{{ route('borrowing.surat.store') }}" enctype="multipart/form-data" id="uploadForm">
                @csrf

                <!-- Info Box -->
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded mb-6">
                    <h4 class="font-medium text-blue-800 mb-2 flex items-center gap-2">
                        <i class="fas fa-info-circle"></i>Petunjuk Pengisian
                    </h4>
                    <ol class="text-blue-700 text-sm space-y-1 ml-4">
                        <li>1. Unduh template surat di atas</li>
                        <li>2. Isi data di template menggunakan Microsoft Word/LibreOffice</li>
                        <li>3. Cetak dan tanda tangani surat</li>
                        <li>4. Scan surat yang sudah ditandatangani menjadi PDF (atau foto jelas)</li>
                        <li>5. Upload file PDF/Word di form bawah ini</li>
                    </ol>
                </div>

                <div class="max-w-2xl mx-auto space-y-4">
                    <!-- Nama Pemohon -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="fas fa-user mr-2"></i>Nama Pemohon <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama_pemohon" required
                               value="{{ Auth::user()->name }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Nama lengkap sesuai KTM/KTP">
                    </div>

                    <!-- Nomor HP -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="fas fa-phone mr-2"></i>Nomor HP/WhatsApp <span class="text-red-500">*</span>
                        </label>
                        <input type="tel" name="no_hp" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Contoh: 081234567890">
                        <p class="text-xs text-gray-500 mt-1">
                            Akan digunakan untuk konfirmasi dari admin
                        </p>
                    </div>

                    <!-- Periode Peminjaman -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="fas fa-calendar-alt mr-2"></i>Periode Peminjaman <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">Dari Tanggal</label>
                                <input type="date" name="tanggal_mulai" required
                                       min="{{ date('Y-m-d') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">Sampai Tanggal</label>
                                <input type="date" name="tanggal_selesai" required
                                       min="{{ date('Y-m-d') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                    </div>

                    <!-- Keperluan -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="fas fa-file-alt mr-2"></i>Keperluan Peminjaman
                        </label>
                        <textarea name="keperluan" rows="3"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                  placeholder="Contoh: Untuk penelitian tugas akhir, seminar fakultas, praktikum lapangan, dll."></textarea>
                    </div>

                    <!-- Upload File -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="fas fa-file-upload mr-2"></i>Upload Surat <span class="text-red-500">*</span>
                        </label>

                        <div class="border-2 border-dashed border-blue-400 rounded-xl p-8 text-center bg-blue-50 hover:bg-blue-100 cursor-pointer transition"
                             onclick="document.getElementById('fileInput').click()"
                             id="dropZone">
                            <i class="fas fa-cloud-upload-alt text-4xl text-blue-500 mb-3"></i>
                            <p class="text-gray-700 font-medium mb-1">
                                Klik untuk memilih file atau drag file ke sini
                            </p>
                            <p class="text-gray-500 text-sm">
                                Format: PDF, DOC, DOCX (maksimal 5MB)
                            </p>
                        </div>

                        <input type="file" name="surat" id="fileInput" accept=".pdf,.doc,.docx" required
                               class="hidden" onchange="showFileName(this)">

                        <div id="fileName" class="mt-3 hidden">
                            <p class="text-green-600 text-sm flex items-center gap-2">
                                <i class="fas fa-check-circle"></i>
                                File terpilih: <span id="fileNameText" class="font-medium"></span>
                            </p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-3 justify-center pt-6">
                        <a href="{{ route('borrowing.dashboard') }}"
                           class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-medium">
                            <i class="fas fa-arrow-left"></i>
                            Kembali
                        </a>
                        <button type="submit" id="submitBtn"
                                class="inline-flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg font-medium">
                            <i class="fas fa-paper-plane"></i>
                            Kirim Surat
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showFileName(input) {
            if (input.files && input.files[0]) {
                const fileName = input.files[0].name;
                const fileSize = (input.files[0].size / 1024 / 1024).toFixed(2); // MB

                document.getElementById('fileNameText').textContent =
                    `${fileName} (${fileSize} MB)`;
                document.getElementById('fileName').classList.remove('hidden');

                // Validasi ukuran file
                if (input.files[0].size > 5 * 1024 * 1024) { // 5MB
                    alert('Ukuran file terlalu besar! Maksimal 5MB.');
                    input.value = '';
                    document.getElementById('fileName').classList.add('hidden');
                }
            }
        }

        const dropZone = document.getElementById('dropZone');
        const fileInput = document.getElementById('fileInput');

        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('bg-blue-100');
            dropZone.classList.add('border-blue-500');
        });

        dropZone.addEventListener('dragleave', (e) => {
            e.preventDefault();
            dropZone.classList.remove('bg-blue-100');
            dropZone.classList.remove('border-blue-500');
        });

        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('bg-blue-100');
            dropZone.classList.remove('border-blue-500');

            if (e.dataTransfer.files.length) {
                fileInput.files = e.dataTransfer.files;
                showFileName(fileInput);
            }
        });

        // Pengumpulan form
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

            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengupload...';
            submitBtn.disabled = true;

            setTimeout(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }, 10000);
        });

        document.addEventListener('DOMContentLoaded', function() {
            const templateLink = document.querySelector('a[href*="template"]');
            if (templateLink) {
                templateLink.addEventListener('click', function(e) {
                    const originalHref = this.getAttribute('href');
                    if (!originalHref.includes('?')) {
                        this.setAttribute('href', originalHref + '?v=' + Date.now());
                    }
                });
            }
        });
    </script>
@endsection