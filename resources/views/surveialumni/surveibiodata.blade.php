@extends('layouts_lp.template')

@section('content')
    <style>
        /* Gaya CSS yang sudah ada */
        button[type="submit"] {
            background-color: #04182d;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 18px;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }

        .form-control:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .search-results {
            position: absolute;
            z-index: 1000;
            width: 100%;
            max-height: 200px;
            overflow-y: auto;
            background: white;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .search-item {
            padding: 10px;
            cursor: pointer;
            border-bottom: 1px solid #f0f0f0;
        }

        .search-item:hover {
            background-color: #f8f9fa;
        }

        .selected-alumni-info {
            background-color: #e9f5ff;
            padding: 10px;
            border-radius: 4px;
            margin-top: 10px;
        }

        .php-email-form .loading {
            display: none;
            background: rgba(255, 255, 255, 0.8);
            text-align: center;
            padding: 15px;
            border-radius: 4px;
        }

        .php-email-form .loading:before {
            content: "";
            display: inline-block;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            margin: 0 10px -6px 0;
            border: 3px solid #04182d;
            border-top-color: #e1e1e1;
            animation: animate-loading 1s linear infinite;
        }

        .php-email-form .error-message,
        .php-email-form .sent-message {
            display: none;
            color: #fff;
            text-align: center;
            padding: 15px;
            font-weight: 600;
            margin-bottom: 15px;
            border-radius: 4px;
        }

        .php-email-form .error-message {
            background: #ed3c0d;
        }

        .php-email-form .sent-message {
            background: #18d26e;
        }

        @keyframes animate-loading {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Gaya untuk pesan validasi kustom */
        .custom-validation-message {
            color: #ed3c0d; /* Warna merah untuk error */
            font-size: 0.875em;
            margin-top: 5px;
            display: none; /* Sembunyikan secara default */
        }
    </style>

    <div class="container" data-aos="fade-up">
        <div class="section-title">
            <h2>Survei Alumni</h2>
            <p>Mohon verifikasi data terlebih dahulu.</p>
        </div>

        <div class="col-lg-12">
            @if(session('success'))
                <div class="alert alert-success" data-aos="fade-up">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger" data-aos="fade-up">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Hapus blok ini agar error validasi hanya muncul di bawah field --}}
            {{-- 
            @if ($errors->any())
                <div class="alert alert-danger" data-aos="fade-up">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif 
            --}}

            <form action="{{ route('alumni.survey.store') }}" method="post" class="survey-form" data-aos="fade-up"
                data-aos-delay="200" novalidate>
                @csrf
                <div class="row gy-4">
                    <div class="col-md-6">
                        <label for="alumni_search" class="pb-2">Nama <span class="text-danger">*</span></label>
                        <div class="position-relative">
                            <input type="text" class="form-control @error('nim') is-invalid @enderror" id="alumni_search"
                                placeholder="Cari berdasarkan NIM atau Nama" autocomplete="off"
                                value="{{ old('alumni_search', old('nama_alumni_display', '')) }}">
                            <div id="search_results" class="search-results d-none"></div>
                            <input type="hidden" id="nim_alumni_hidden" name="nim" required value="{{ old('nim') }}">
                            <input type="hidden" id="nama_alumni_display" name="nama_alumni_display" value="{{ old('nama_alumni_display') }}">
                            <input type="hidden" id="program_studi_hidden" name="program_studi_hidden" value="{{ old('program_studi_hidden') }}">
                            <input type="hidden" id="tahun_lulus_hidden" name="tahun_lulus_hidden" value="{{ old('tahun_lulus_hidden') }}">
                            @error('nim')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <div id="selected_alumni" class="selected-alumni-info {{ old('nim') ? '' : 'd-none' }}">
                                <strong id="selected_alumni_text">
                                    @if(old('nim') && old('nama_alumni_display'))
                                        {{ old('nim') }} - {{ old('nama_alumni_display') }}
                                    @endif
                                </strong>
                            </div>
                            <div id="search_validation_message" class="custom-validation-message"></div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="kode_otp" class="pb-2">Kode OTP <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('kode_otp_alumni') is-invalid @enderror" id="kode_otp" name="kode_otp_alumni" maxlength="4" required value="{{ old('kode_otp_alumni') }}">
                        @error('kode_otp_alumni')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="program_studi" class="pb-2">Program Studi</label>
                        <input type="text" class="form-control" id="program_studi" name="program_studi"
                            readonly value="{{ old('program_studi', old('program_studi_hidden', '')) }}">
                    </div>
                    <div class="col-md-6">
                        <label for="tahun_lulus" class="pb-2">Tahun Lulus</label>
                        <input type="text" class="form-control" id="tahun_lulus" name="tahun_lulus"
                            readonly value="{{ old('tahun_lulus', old('tahun_lulus_hidden', '')) }}">
                    </div>



                    

                    <div class="col-md-12 text-center">
                        <div class="error-message"></div>
                        <div class="loading" style="display:none;">Menyimpan data dan mengirim kode OTP ke perusahaan, mohon tunggu...</div>
                        <button type="submit">Verifikasi</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const searchInput = document.getElementById('alumni_search');
                const searchResults = document.getElementById('search_results');
                // Mengubah ID nimInput agar sesuai dengan HTML
                const nimInput = document.getElementById('nim_alumni_hidden');
                const selectedAlumni = document.getElementById('selected_alumni');
                const selectedAlumniText = document.getElementById('selected_alumni_text');
                const tanggalPertamaKerja = document.getElementById('tanggal_pertama_kerja');
                const tanggalPertamaKerjaInstansi = document.getElementById('tanggal_pertama_kerja_instansi_saat_ini');
                const surveyForm = document.querySelector('.survey-form');
                const searchValidationMessage = document.getElementById('search_validation_message');
                const dateValidationMessage = document.getElementById('date_validation_message');


                // Fungsi untuk menampilkan pesan validasi kustom
                function showCustomValidationMessage(element, message) {
                    element.textContent = message;
                    element.style.display = 'block';
                }

                // Fungsi untuk menyembunyikan pesan validasi kustom
                function hideCustomValidationMessage(element) {
                    element.textContent = '';
                    element.style.display = 'none';
                }

                // Fungsi untuk mencari alumni
                function searchAlumni() {
                    const searchTerm = searchInput.value.trim();
                    if (searchTerm.length < 3) {
                        showCustomValidationMessage(searchValidationMessage, 'Masukkan minimal 3 karakter untuk pencarian.');
                        searchResults.classList.add('d-none');
                        return;
                    } else {
                        hideCustomValidationMessage(searchValidationMessage);
                    }

                    // Tampilkan indikator loading
                    searchResults.innerHTML = '<div class="p-2 text-center">Mencari...</div>';
                    searchResults.classList.remove('d-none');

                    // Menggunakan XMLHttpRequest untuk kompatibilitas yang lebih baik
                    const xhr = new XMLHttpRequest();
                    xhr.open('GET', `/api/alumni/search?term=${encodeURIComponent(searchTerm)}`, true);
                    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                    xhr.onload = function () {
                        if (xhr.status === 200) {
                            const data = JSON.parse(xhr.responseText);
                            renderSearchResults(data);
                        } else {
                            searchResults.innerHTML = '<div class="p-2 text-center text-danger">Terjadi kesalahan saat mencari data</div>';
                        }
                    };
                    xhr.onerror = function () {
                        searchResults.innerHTML = '<div class="p-2 text-center text-danger">Terjadi kesalahan koneksi</div>';
                    };
                    xhr.send();
                }

                // Fungsi untuk merender hasil pencarian
                function renderSearchResults(data) {
                    searchResults.innerHTML = '';

                    if (data.length === 0) {
                        searchResults.innerHTML = '<div class="p-2 text-center">Tidak ada hasil ditemukan</div>';
                        return;
                    }

                    data.forEach(alumni => {
                        const item = document.createElement('div');
                        item.className = 'search-item';
                        item.textContent = `${alumni.nim} - ${alumni.nama}`;
                        item.addEventListener('click', function () {
                            selectAlumni(alumni);
                        });
                        searchResults.appendChild(item);
                    });

                    searchResults.classList.remove('d-none');
                }

                // Saat halaman dimuat, jika ada old('nim') dan old('nama_alumni_display'), tampilkan alumni terpilih dan isi default program studi & tahun lulus
                @if(old('nim') && old('nama_alumni_display'))
                    document.getElementById('alumni_search').value = "{{ old('nama_alumni_display') }}";
                    document.getElementById('selected_alumni').classList.remove('d-none');
                    document.getElementById('selected_alumni_text').textContent = "{{ old('nim') }} - {{ old('nama_alumni_display') }}";
                    document.getElementById('program_studi').value = "{{ old('program_studi', old('program_studi_hidden', '')) }}";
                    document.getElementById('tahun_lulus').value = "{{ old('tahun_lulus', old('tahun_lulus_hidden', '')) }}";
                @endif

                // Saat memilih alumni, simpan nama alumni, program studi, dan tahun lulus ke input hidden agar tetap ada saat error/validasi
                function selectAlumni(alumni) {
                    nimInput.value = alumni.nim;
                    selectedAlumniText.textContent = `${alumni.nim} - ${alumni.nama}`;
                    selectedAlumni.classList.remove('d-none');
                    searchResults.classList.add('d-none');
                    searchInput.value = alumni.nama;
                    hideCustomValidationMessage(searchValidationMessage);

                    // Simpan nama alumni ke input hidden agar tetap ada saat validasi error
                    let namaAlumniDisplay = document.getElementById('nama_alumni_display');
                    if (!namaAlumniDisplay) {
                        namaAlumniDisplay = document.createElement('input');
                        namaAlumniDisplay.type = 'hidden';
                        namaAlumniDisplay.id = 'nama_alumni_display';
                        namaAlumniDisplay.name = 'nama_alumni_display';
                        surveyForm.appendChild(namaAlumniDisplay);
                    }
                    namaAlumniDisplay.value = alumni.nama;

                    // Simpan program studi ke input hidden
                    let programStudiHidden = document.getElementById('program_studi_hidden');
                    if (!programStudiHidden) {
                        programStudiHidden = document.createElement('input');
                        programStudiHidden.type = 'hidden';
                        programStudiHidden.id = 'program_studi_hidden';
                        programStudiHidden.name = 'program_studi_hidden';
                        surveyForm.appendChild(programStudiHidden);
                    }
                    programStudiHidden.value = alumni.program_studi || '';

                    // Simpan tahun lulus ke input hidden
                    let tahunLulusHidden = document.getElementById('tahun_lulus_hidden');
                    if (!tahunLulusHidden) {
                        tahunLulusHidden = document.createElement('input');
                        tahunLulusHidden.type = 'hidden';
                        tahunLulusHidden.id = 'tahun_lulus_hidden';
                        tahunLulusHidden.name = 'tahun_lulus_hidden';
                        surveyForm.appendChild(tahunLulusHidden);
                    }
                    tahunLulusHidden.value = alumni.tahun_lulus || '';

                    // Isi otomatis program studi dan tahun lulus jika tersedia
                    if (alumni.program_studi) {
                        document.getElementById('program_studi').value = alumni.program_studi;
                    }
                    if (alumni.tahun_lulus) {
                        document.getElementById('tahun_lulus').value = alumni.tahun_lulus;
                    }
                    calculateMasaTunggu();
                }

                // Event listener untuk input pencarian (dengan debounce)
                let searchTimeout;
                searchInput.addEventListener('input', function () {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(function () {
                        searchAlumni();
                    }, 300); // Debounce pencarian
                });

                // Event listener saat input pencarian mendapatkan fokus
                searchInput.addEventListener('focus', function () {
                    if (this.value.trim().length >= 3) {
                        searchAlumni();
                    }
                });

                // Sembunyikan hasil pencarian saat mengklik di luar area pencarian
                document.addEventListener('click', function (e) {
                    if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                        searchResults.classList.add('d-none');
                    }
                });

                // Hitung masa tunggu secara otomatis saat tanggal pertama kerja atau tahun lulus berubah
                tanggalPertamaKerja.addEventListener('change', function () {
                    calculateMasaTunggu();
                });
                document.getElementById('tahun_lulus').addEventListener('change', function() {
                    calculateMasaTunggu();
                });


                // Pastikan tanggal kedua tidak sebelum tanggal pertama
                tanggalPertamaKerjaInstansi.addEventListener('change', function () {
                    const firstDateValue = tanggalPertamaKerja.value;
                    const secondDateValue = tanggalPertamaKerjaInstansi.value;

                    if (firstDateValue && secondDateValue) {
                        const firstDate = new Date(firstDateValue);
                        const secondDate = new Date(secondDateValue);

                        if (secondDate < firstDate) {
                            // Mengganti alert() dengan pesan validasi kustom
                            showCustomValidationMessage(dateValidationMessage, 'Tanggal mulai kerja pada instansi saat ini tidak boleh sebelum tanggal pertama kerja.');
                            tanggalPertamaKerjaInstansi.value = ''; // Kosongkan tanggal yang tidak valid
                        } else {
                            hideCustomValidationMessage(dateValidationMessage);
                        }
                    }
                });

                // Fungsi untuk menghitung masa tunggu (dalam bulan)
                function calculateMasaTunggu() {
                    const tahunLulus = document.getElementById('tahun_lulus').value;
                    const tanggalKerja = tanggalPertamaKerja.value;

                    if (tahunLulus && tanggalKerja) {
                        // Asumsi tanggal kelulusan adalah 30 Juni di tahun kelulusan
                        const graduationDate = new Date(tahunLulus, 5, 30); // Bulan 0-indexed (5 = Juni)
                        const workDate = new Date(tanggalKerja);

                        let diffMonths = (workDate.getFullYear() - graduationDate.getFullYear()) * 12;
                        diffMonths -= graduationDate.getMonth(); // Kurangi bulan dari tahun kelulusan
                        diffMonths += workDate.getMonth(); // Tambahkan bulan dari tahun kerja

                        // Sesuaikan untuk perbedaan hari jika tanggal kerja sebelum hari kelulusan di bulan yang sama
                        if (workDate.getDate() < graduationDate.getDate() && workDate.getMonth() === graduationDate.getMonth()) {
                            diffMonths--;
                        }

                        // Pastikan masa_tunggu tidak negatif
                        const masaTungguValue = diffMonths > 0 ? diffMonths : 0;

                        let masaTungguInput = document.getElementById('masa_tunggu');
                        if (!masaTungguInput) {
                            masaTungguInput = document.createElement('input');
                            masaTungguInput.type = 'hidden';
                            masaTungguInput.id = 'masa_tunggu';
                            masaTungguInput.name = 'masa_tunggu';
                            surveyForm.appendChild(masaTungguInput);
                        }
                        masaTungguInput.value = masaTungguValue;
                    }
                }

                // Perhitungan awal saat halaman dimuat jika ada nilai yang sudah terisi (misalnya dari old() helper)
                calculateMasaTunggu();

                // Penanganan form kustom untuk indikator loading
                if (surveyForm) {
                    surveyForm.addEventListener('submit', function (e) {
                        const loadingElement = this.querySelector('.loading');
                        const errorMessage = this.querySelector('.error-message');
                        const sentMessage = this.querySelector('.sent-message');

                        if (loadingElement) {
                            loadingElement.style.display = 'block';
                        }
                        if (errorMessage) {
                            errorMessage.style.display = 'none';
                        }
                        if (sentMessage) {
                            sentMessage.style.display = 'none';
                        }

                        // Tambahkan pop up loading menggunakan SweetAlert2 jika tersedia
                        if (window.Swal) {
                            Swal.fire({
                                title: 'Mohon Tunggu',
                                text: 'Menyimpan data dan mengirim kode OTP ke perusahaan...',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });
                        }
                    });
                }

                // Sembunyikan indikator loading jika ada pesan sesi setelah redirect
                const successAlert = document.querySelector('.alert-success');
                const errorAlert = document.querySelector('.alert-danger');
                if (successAlert || errorAlert) {
                    const loadingElement = document.querySelector('.loading');
                    if (loadingElement) {
                        loadingElement.style.display = 'none';
                    }
                }

                // Autofokus ke input OTP jika ada error OTP
                @if($errors->has('kode_otp_alumni'))
                    document.getElementById('kode_otp').focus();
                @endif

                // Inisialisasi Select2 untuk dropdown profesi
                $('select[name="profesi_id"]').select2({
                    placeholder: 'Cari Profesi',
                    allowClear: true
                });

                // Inisialisasi Select2 untuk dropdown kategori profesi
                $('select[name="kategori_id"]').select2({
                    placeholder: 'Cari Kategori',
                    allowClear: true
                });
            });
        </script>
    @endpush
@endsection
