@extends('layouts_lp.template')

@section('content')
    <style>
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

        .rating-container {
            display: flex;
            flex-direction: row-reverse;
            justify-content: flex-end;
        }

        .rating-container input {
            display: none;
        }

        .rating-container label {
            cursor: pointer;
            width: 40px;
            height: 40px;
            margin: 0 2px;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%23d4d4d4' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'%3e%3c/polygon%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: center;
            background-size: 70%;
        }

        .rating-container input:checked~label {
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='%23ffc107' stroke='%23ffc107' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'%3e%3c/polygon%3e%3c/svg%3e");
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

        .emote-anim {
            display: none;
        }
        .pastel-danger {
            background-color: #ffd6d6 !important;
            color: #a94442 !important;
        }
        .pastel-warning {
            background-color: #fff7d6 !important;
            color: #a67c00 !important;
        }
        .pastel-secondary {
            background-color: #e2e3f3 !important;
            color: #5a5a7a !important;
        }
        .pastel-info {
            background-color: #d6f6ff !important;
            color: #31708f !important;
        }
        .pastel-success {
            background-color: #d6ffe6 !important;
            color: #3c763d !important;
        }

        .custom-validation-message {
            color: #ed3c0d;
            font-size: 0.875em;
            margin-top: 5px;
            display: none;
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
            <h2>Survei Kepuasan Pengguna Lulusan</h2>
            <p>Mohon isi formulir di bawah ini dengan lengkap dan jujur untuk membantu kami meningkatkan kualitas lulusan.</p>
        </div>

        <div class="col-lg-12">
            @if (session('success'))
                <div class="alert alert-success" data-aos="fade-up">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger" data-aos="fade-up">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger" data-aos="fade-up">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Company Information Card -->
            @if(session('verified_company'))
                <div class="alumni-info-card" data-aos="fade-up">
                    <h5 class="mb-3">Perusahaan Terverifikasi</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-item">
                                <span class="info-label">Nama Perusahaan:</span>
                                <span class="info-value">{{ session('verified_company.nama_instansi_penilai') }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <span class="info-label">Kode OTP:</span>
                                <span class="info-value">{{ session('verified_company.kode_otp_perusahaan') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('survei.perusahaan.store') }}" method="post" class="survey-form" data-aos="fade-up"
                data-aos-delay="200">
                @csrf
                
                <!-- Hidden fields for verified company data -->
                @if(session('verified_company'))
                    <input type="hidden" name="nama_instansi_penilai" value="{{ session('verified_company.nama_instansi_penilai') }}">
                    <input type="hidden" name="kode_otp_perusahaan" value="{{ session('verified_company.kode_otp_perusahaan') }}">
                @endif

                <div class="row gy-4">
                    <!-- Data Penilai -->
                    <div class="col-md-12">
                        <h4 class="mb-3">Data Penilai</h4>
                    </div>

                    <div class="col-md-6">
                        <label for="nama" class="pb-2">Nama <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama"
                            value="{{ old('nama') }}" required>
                        @error('nama')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <div id="nama_warning" class="custom-validation-message"></div>
                    </div>

                    <div class="col-md-6">
                        <label for="jabatan" class="pb-2">Jabatan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('jabatan') is-invalid @enderror" id="jabatan" name="jabatan"
                            value="{{ old('jabatan') }}" required>
                        @error('jabatan')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <div id="jabatan_warning" class="custom-validation-message"></div>
                    </div>

                    <div class="col-md-6">
                        <label for="no_telepon" class="pb-2">No. Telepon <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('no_telepon') is-invalid @enderror" id="no_telepon" name="no_telepon"
                            value="{{ old('no_telepon') }}" required>
                        @error('no_telepon')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <div id="no_telepon_warning" class="custom-validation-message"></div>
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="pb-2">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                            value="{{ old('email') }}" required>
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <div id="email_warning" class="custom-validation-message"></div>
                    </div>

                    <!-- Alumni Search -->
                    <div class="col-md-12 mt-4">
                        <h4 class="mb-3">Data Alumni yang Dinilai</h4>
                        <label for="alumni_search" class="pb-2">Nama Alumni <span class="text-danger">*</span></label>
                        <div class="position-relative">
                            <input type="text" class="form-control @error('nim') is-invalid @enderror" id="alumni_search"
                                placeholder="Cari alumni berdasarkan nama" autocomplete="off"
                                value="{{ old('alumni_search', old('nama_alumni_display', '')) }}">
                            <div id="search_results" class="search-results d-none"></div>
                            <input type="hidden" id="nim" name="nim" required value="{{ old('nim') }}">
                            <input type="hidden" id="nama_alumni_display" name="nama_alumni_display" value="{{ old('nama_alumni_display') }}">
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
                        </div>
                    </div>

                    <div class="col-md-12 mt-4">
                        <div class="card shadow-sm border-0 mb-3" style="background: linear-gradient(90deg, #e9f5ff 0%, #f8fafc 100%);">
                            <div class="card-body">
                                <h4 class="mb-2" style="color:#04182d;">
                                    <i class="bi bi-star-fill text-warning"></i>
                                    Penilaian Kinerja Alumni <span style="font-size:0.8em;" class="text-muted">(Skala 1-5)</span>
                                </h4>
                                <div class="d-flex align-items-center mb-2 flex-wrap">
                                    <span class="badge pastel-danger me-2" style="font-size:1em;">1</span>
                                    <span class="me-3">Sangat Kurang</span>
                                    <span class="badge pastel-warning me-2" style="font-size:1em;">2</span>
                                    <span class="me-3">Kurang</span>
                                    <span class="badge pastel-secondary me-2" style="font-size:1em;">3</span>
                                    <span class="me-3">Cukup</span>
                                    <span class="badge pastel-info me-2" style="font-size:1em;">4</span>
                                    <span class="me-3">Baik</span>
                                    <span class="badge pastel-success me-2" style="font-size:1em;">5</span>
                                    <span>Sangat Baik</span>
                                </div>
                                <p class="text-muted mb-0" style="font-size:0.95em;">
                                    Silakan berikan penilaian terhadap kinerja alumni pada setiap aspek di bawah ini dengan memilih angka sesuai skala yang tersedia. Penilaian ini akan sangat membantu kami dalam meningkatkan kualitas lulusan di masa mendatang.
                                </p>
                            </div>
                        </div>
                    </div>

                    @php
                    $ratingFields = [
                        'kerjasama' => 'Kerjasama Tim',
                        'keahlian' => 'Keahlian di bidang TI',
                        'kemampuan_basing' => 'Kemampuan berbahasa asing',
                        'kemampuan_komunikasi' => 'Kemampuan berkomunikasi',
                        'pengembangan_diri' => 'Pengembangan diri',
                        'kepemimpinan' => 'Kepemimpinan',
                        'etoskerja' => 'Etos Kerja'
                    ];
                    @endphp

                    @foreach($ratingFields as $field => $label)
                    <div class="col-md-6">
                        <label class="pb-2">{{ $label }} <span class="text-danger">*</span></label>
                        <div class="rating-container">
                            @for($i = 5; $i >= 1; $i--)
                            <input type="radio" id="{{ $field }}-{{ $i }}" name="{{ $field }}" value="{{ $i }}"
                                {{ old($field) == $i ? 'checked' : '' }} required>
                            <label for="{{ $field }}-{{ $i }}" title="{{ $i == 5 ? 'Sangat Baik' : ($i == 4 ? 'Baik' : ($i == 3 ? 'Cukup' : ($i == 2 ? 'Kurang' : 'Sangat Kurang'))) }}"></label>
                            @endfor
                        </div>
                        @error($field)
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    @endforeach

                    <!-- Additional Information -->
                    <div class="col-md-12 mt-4">
                        <h4 class="mb-3">Informasi Tambahan</h4>
                    </div>

                    <div class="col-md-12">
                        <label for="kompetensi_yang_belum_dipenuhi" class="pb-2">Kompetensi yang dibutuhkan tapi belum dapat dipenuhi <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="kompetensi_yang_belum_dipenuhi" name="kompetensi_yang_belum_dipenuhi"
                            rows="3" required>{{ old('kompetensi_yang_belum_dipenuhi') }}</textarea>
                        @error('kompetensi_yang_belum_dipenuhi')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label for="saran" class="pb-2">Saran untuk kurikulum program studi <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="saran" name="saran" rows="3" required>{{ old('saran') }}</textarea>
                        @error('saran')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12 text-center mt-4">
                        <div class="error-message"></div>
                        <button type="submit">Kirim Penilaian</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const searchInput = document.getElementById('alumni_search');
                const searchResults = document.getElementById('search_results');
                const nimInput = document.getElementById('nim');
                const selectedAlumni = document.getElementById('selected_alumni');
                const selectedAlumniText = document.getElementById('selected_alumni_text');
                const surveyForm = document.querySelector('.survey-form');

                // Function to search alumni
                function searchAlumni() {
                    const searchTerm = searchInput.value.trim();
                    if (searchTerm.length < 3) {
                        return;
                    }

                    searchResults.innerHTML = '<div class="p-2 text-center">Mencari...</div>';
                    searchResults.classList.remove('d-none');

                    const xhr = new XMLHttpRequest();
                    xhr.open('GET', `/api/alumni/search-for-survey?term=${encodeURIComponent(searchTerm)}`, true);
                    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                    xhr.onload = function() {
                        if (xhr.status === 200) {
                            const data = JSON.parse(xhr.responseText);
                            renderSearchResults(data);
                        } else {
                            searchResults.innerHTML = '<div class="p-2 text-center text-danger">Terjadi kesalahan saat mencari data</div>';
                        }
                    };
                    xhr.onerror = function() {
                        searchResults.innerHTML = '<div class="p-2 text-center text-danger">Terjadi kesalahan koneksi</div>';
                    };
                    xhr.send();
                }

                // Function to render search results
                function renderSearchResults(data) {
                    searchResults.innerHTML = '';

                    if (data.length === 0) {
                        searchResults.innerHTML = '<div class="p-2 text-center">Tidak ada hasil ditemukan</div>';
                        return;
                    }

                    data.forEach(alumni => {
                        const item = document.createElement('div');
                        item.className = 'search-item';
                        item.textContent = `${alumni.program_studi} - ${alumni.tahun_lulus} - ${alumni.nama}`;
                        item.addEventListener('click', function() {
                            selectAlumni(alumni);
                        });
                        searchResults.appendChild(item);
                    });

                    searchResults.classList.remove('d-none');
                }

                // Function to select an alumni
                function selectAlumni(alumni) {
                    nimInput.value = alumni.nim;
                    selectedAlumniText.textContent = `${alumni.program_studi} - ${alumni.tahun_lulus} - ${alumni.nama}`;
                    selectedAlumni.classList.remove('d-none');
                    searchResults.classList.add('d-none');
                    searchInput.value = alumni.nama;

                    let namaAlumniDisplay = document.getElementById('nama_alumni_display');
                    if (!namaAlumniDisplay) {
                        namaAlumniDisplay = document.createElement('input');
                        namaAlumniDisplay.type = 'hidden';
                        namaAlumniDisplay.id = 'nama_alumni_display';
                        namaAlumniDisplay.name = 'nama_alumni_display';
                        surveyForm.appendChild(namaAlumniDisplay);
                    }
                    namaAlumniDisplay.value = alumni.nama;
                }

                // Event listeners
                let searchTimeout;
                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(function() {
                        if (searchInput.value.trim().length >= 3) {
                            searchAlumni();
                        } else {
                            searchResults.classList.add('d-none');
                        }
                    }, 300);
                });

                searchInput.addEventListener('focus', function() {
                    if (this.value.trim().length >= 3) {
                        searchAlumni();
                    }
                });

                // Hide search results when clicking outside
                document.addEventListener('click', function(e) {
                    if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                        searchResults.classList.add('d-none');
                    }
                });

                // Restore old values
                @if(old('nama_instansi_penilai', old('selected_perusahaan_display')))
                    perusahaanSelect.value = "{{ old('nama_instansi_penilai', old('selected_perusahaan_display')) }}";
                @endif

                perusahaanSelect.addEventListener('change', function() {
                    document.getElementById('selected_perusahaan_display').value = perusahaanSelect.value;
                });

                @if(old('nim') && old('nama_alumni_display'))
                    document.getElementById('alumni_search').value = "{{ old('nama_alumni_display') }}";
                    document.getElementById('selected_alumni').classList.remove('d-none');
                    document.getElementById('selected_alumni_text').textContent = "{{ old('nim') }} - {{ old('nama_alumni_display') }}";
                @endif

                // Simple JS validation
                document.querySelector('form.survey-form').addEventListener('submit', function(e) {
                    let valid = true;
                    const requiredFields = ['nama', 'jabatan', 'no_telepon', 'email'];
                    requiredFields.forEach(function(id) {
                        const el = document.getElementById(id);
                        const warning = document.getElementById(id + '_warning');
                        if (el && !el.value) {
                            if (warning) warning.style.display = 'block';
                            valid = false;
                        } else {
                            if (warning) warning.style.display = 'none';
                        }
                    });
                    if (!valid) {
                        e.preventDefault();
                    }
                });
            });
        </script>
    @endpush
@endsection
