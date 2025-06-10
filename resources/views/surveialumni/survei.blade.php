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

        .alumni-info-card {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 2rem;
        }

        .alumni-info-card .info-item {
            margin-bottom: 0.5rem;
        }

        .alumni-info-card .info-label {
            font-weight: 600;
            color: #495057;
        }

        .alumni-info-card .info-value {
            color: #6c757d;
        }
    </style>

    <div class="container" data-aos="fade-up">
        <div class="section-title">
            <h2>Survei Alumni</h2>
            <p>Mohon isi formulir di bawah ini dengan lengkap dan jujur.</p>
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

            <!-- Alumni Information Card -->
            @if(session('verified_alumni'))
                <div class="alumni-info-card" data-aos="fade-up">
                    <h5 class="mb-3">Informasi Alumni</h5>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="info-item">
                                <span class="info-label">NIM:</span>
                                <span class="info-value">{{ session('verified_alumni.nim') }}</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-item">
                                <span class="info-label">Nama:</span>
                                <span class="info-value">{{ session('verified_alumni.nama') }}</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-item">
                                <span class="info-label">Program Studi:</span>
                                <span class="info-value">{{ session('verified_alumni.program_studi') ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-item">
                                <span class="info-label">Tahun Lulus:</span>
                                <span class="info-value">{{ session('verified_alumni.tahun_lulus') ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('alumni.survey.store') }}" method="post" class="survey-form" data-aos="fade-up"
                data-aos-delay="200" novalidate>
                @csrf
                
                <!-- Hidden fields for verified alumni data -->
                @if(session('verified_alumni'))
                    <input type="hidden" name="nim" value="{{ session('verified_alumni.nim') }}">
                    <input type="hidden" name="nama_alumni_display" value="{{ session('verified_alumni.nama') }}">
                    <input type="hidden" name="program_studi_hidden" value="{{ session('verified_alumni.program_studi') }}">
                    <input type="hidden" name="tahun_lulus_hidden" value="{{ session('verified_alumni.tahun_lulus') }}">
                @endif

                <div class="row gy-4">
                    <div class="col-md-6">
                        <label for="no_telepon" class="pb-2">No. HP <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('no_telepon') is-invalid @enderror" id="no_telepon" name="no_telepon" required value="{{ old('no_telepon') }}">
                        @error('no_telepon')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="pb-2">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" required value="{{ old('email') }}">
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="tanggal_pertama_kerja" class="pb-2">Tanggal Pertama Kerja <span
                                class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="tanggal_pertama_kerja" name="tanggal_pertama_kerja"
                            required value="{{ old('tanggal_pertama_kerja') }}">
                        @error('tanggal_pertama_kerja')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="tanggal_pertama_kerja_instansi_saat_ini" class="pb-2">Tanggal Mulai Kerja pada Instansi
                            Saat Ini <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="tanggal_pertama_kerja_instansi_saat_ini"
                            name="tanggal_pertama_kerja_instansi_saat_ini" required value="{{ old('tanggal_pertama_kerja_instansi_saat_ini') }}">
                        @error('tanggal_pertama_kerja_instansi_saat_ini')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <div id="date_validation_message" class="custom-validation-message"></div>
                    </div>

                    <input type="hidden" id="masa_tunggu" name="masa_tunggu" value="{{ old('masa_tunggu') }}">

                    <div class="col-md-6">
                        <label for="jenis_instansi" class="pb-2">Jenis Instansi <span class="text-danger">*</span></label>
                        <select class="form-control" id="jenis_instansi" name="jenis_instansi" required>
                            <option value="">Pilih Jenis Instansi</option>
                            <option value="Pemerintah" {{ old('jenis_instansi') == 'Pemerintah' ? 'selected' : '' }}>Pemerintah</option>
                            <option value="BUMN" {{ old('jenis_instansi') == 'BUMN' ? 'selected' : '' }}>BUMN</option>
                            <option value="Swasta" {{ old('jenis_instansi') == 'Swasta' ? 'selected' : '' }}>Swasta</option>
                            <option value="Wirausaha" {{ old('jenis_instansi') == 'Wirausaha' ? 'selected' : '' }}>Wirausaha</option>
                            <option value="Lainnya" {{ old('jenis_instansi') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('jenis_instansi')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="nama_instansi" class="pb-2">Nama Instansi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama_instansi" name="nama_instansi" required value="{{ old('nama_instansi') }}">
                        @error('nama_instansi')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="skala" class="pb-2">Skala <span class="text-danger">*</span></label>
                        <select class="form-control" id="skala" name="skala" required>
                            <option value="">Pilih Skala</option>
                            <option value="Lokal" {{ old('skala') == 'Lokal' ? 'selected' : '' }}>Lokal</option>
                            <option value="Nasional" {{ old('skala') == 'Nasional' ? 'selected' : '' }}>Nasional</option>
                            <option value="Internasional" {{ old('skala') == 'Internasional' ? 'selected' : '' }}>Internasional</option>
                            <option value="Wirausaha" {{ old('skala') == 'Wirausaha' ? 'selected' : '' }}>Wirausaha</option>
                        </select>
                        @error('skala')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="lokasi_instansi" class="pb-2">Lokasi Instansi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="lokasi_instansi" name="lokasi_instansi"
                            placeholder="Kota, Provinsi" required value="{{ old('lokasi_instansi') }}">
                        @error('lokasi_instansi')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="kategori_id" class="pb-2">Kategori Profesi <span class="text-danger">*</span></label>
                        <select class="form-control" id="kategori_id" name="kategori_id" required>
                            <option value="">Pilih Kategori Profesi</option>
                            @isset($kategoriList)
                                @foreach($kategoriList as $kategori)
                                    <option value="{{ $kategori->kategori_id }}" {{ old('kategori_id') == $kategori->kategori_id ? 'selected' : '' }}>
                                        {{ $kategori->nama_kategori }}
                                    </option>
                                @endforeach
                            @endisset
                        </select>
                        @error('kategori_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="profesi_id" class="pb-2">Profesi <span class="text-danger">*</span></label>
                        <select name="profesi_id" class="form-control" id="profesi_id" required>
                            <option value="">-- Pilih Profesi --</option>
                            @isset($profesiList)
                                @foreach($profesiList as $profesi)
                                    <option value="{{ $profesi->profesi_id }}" {{ old('profesi_id') == $profesi->profesi_id ? 'selected' : '' }}>
                                        {{ $profesi->nama_profesi }}
                                    </option>
                                @endforeach
                            @endisset
                        </select>
                        @error('profesi_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <h4 class="mt-4 mb-3">Informasi Atasan Langsung</h4>
                    </div>

                    <div class="col-md-6">
                        <label for="nama_atasan" class="pb-2">Nama Atasan Langsung <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama_atasan" name="nama_atasan" required value="{{ old('nama_atasan') }}">
                        @error('nama_atasan')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="jabatan_atasan" class="pb-2">Jabatan Atasan Langsung <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="jabatan_atasan" name="jabatan_atasan" required value="{{ old('jabatan_atasan') }}">
                        @error('jabatan_atasan')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="no_telepon_atasan" class="pb-2">No HP Atasan Langsung <span
                                class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="no_telepon_atasan" name="no_telepon_atasan" required value="{{ old('no_telepon_atasan') }}">
                        @error('no_telepon_atasan')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="email_atasan" class="pb-2">Email Atasan Langsung <span
                                class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email_atasan" name="email_atasan" required value="{{ old('email_atasan') }}">
                        @error('email_atasan')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <h4 class="mt-4 mb-3">Informasi Profesi Anda</h4>
                    </div>

                    <div class="col-md-12">
                        <label for="alamat_kantor" class="pb-2">Alamat Kantor <span class="text-danger">*</span></label>
                        <textarea 
                            class="form-control" 
                            id="alamat_kantor" 
                            name="alamat_kantor" 
                            rows="3" 
                            required>{{ old('alamat_kantor') }}</textarea>
                        @error('alamat_kantor')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    
                    <div class="col-md-6 form-group">
                        <label for="kabupaten">Kabupaten <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="kabupaten" name="kabupaten" required value="{{ old('kabupaten') }}">
                        @error('kabupaten')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="pendapatan">Pendapatan <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" min="0" step="1" name="pendapatan" id="pendapatan" class="form-control" value="{{ old('pendapatan') }}" required>
                        </div>
                        @error('pendapatan')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12 text-center">
                        <div class="error-message"></div>
                        <div class="loading" style="display:none;">Menyimpan data, mohon tunggu...</div>
                        <button type="submit">Simpan Data</button>
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
                const tanggalPertamaKerja = document.getElementById('tanggal_pertama_kerja');
                const tanggalPertamaKerjaInstansi = document.getElementById('tanggal_pertama_kerja_instansi_saat_ini');
                const surveyForm = document.querySelector('.survey-form');
                const dateValidationMessage = document.getElementById('date_validation_message');

                // Fungsi untuk menampilkan pesan validasi kustom
                function showCustomValidationMessage(element, message) {
                    if (element) {
                        element.textContent = message;
                        element.style.display = 'block';
                    }
                }

                // Fungsi untuk menyembunyikan pesan validasi kustom
                function hideCustomValidationMessage(element) {
                    if (element) {
                        element.textContent = '';
                        element.style.display = 'none';
                    }
                }

                // Pastikan tanggal kedua tidak sebelum tanggal pertama
                if (tanggalPertamaKerjaInstansi) {
                    tanggalPertamaKerjaInstansi.addEventListener('change', function () {
                        const firstDateValue = tanggalPertamaKerja.value;
                        const secondDateValue = tanggalPertamaKerjaInstansi.value;

                        if (firstDateValue && secondDateValue) {
                            const firstDate = new Date(firstDateValue);
                            const secondDate = new Date(secondDateValue);

                            if (secondDate < firstDate) {
                                showCustomValidationMessage(dateValidationMessage, 'Tanggal mulai kerja pada instansi saat ini tidak boleh sebelum tanggal pertama kerja.');
                                tanggalPertamaKerjaInstansi.value = '';
                            } else {
                                hideCustomValidationMessage(dateValidationMessage);
                            }
                        }
                    });
                }

                // Auto-calculate masa tunggu using verified alumni data
                @if(session('verified_alumni.tahun_lulus'))
                    function calculateMasaTunggu() {
                        const tahunLulus = {{ session('verified_alumni.tahun_lulus') }};
                        const tanggalKerja = tanggalPertamaKerja ? tanggalPertamaKerja.value : '';

                        if (tahunLulus && tanggalKerja) {
                            const graduationDate = new Date(tahunLulus, 5, 30);
                            const workDate = new Date(tanggalKerja);

                            let diffMonths = (workDate.getFullYear() - graduationDate.getFullYear()) * 12;
                            diffMonths -= graduationDate.getMonth();
                            diffMonths += workDate.getMonth();

                            if (workDate.getDate() < graduationDate.getDate() && workDate.getMonth() === graduationDate.getMonth()) {
                                diffMonths--;
                            }

                            const masaTungguValue = diffMonths > 0 ? diffMonths : 0;
                            
                            let masaTungguInput = document.getElementById('masa_tunggu');
                            if (!masaTungguInput) {
                                masaTungguInput = document.createElement('input');
                                masaTungguInput.type = 'hidden';
                                masaTungguInput.id = 'masa_tunggu';
                                masaTungguInput.name = 'masa_tunggu';
                                if (surveyForm) {
                                    surveyForm.appendChild(masaTungguInput);
                                }
                            }
                            masaTungguInput.value = masaTungguValue;
                        }
                    }

                    if (tanggalPertamaKerja) {
                        tanggalPertamaKerja.addEventListener('change', calculateMasaTunggu);
                        calculateMasaTunggu();
                    }
                @endif

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
