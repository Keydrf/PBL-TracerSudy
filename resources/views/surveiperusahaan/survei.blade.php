@extends('layouts_lp.template')

@section('content')
    <style>
        button[type="submit"] {
            background-color: #04182d;
            /* Contoh warna biru */
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 18px;
            transition: background-color 0.3s ease;
            /* Efek transisi hover */
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
            /* Warna lebih gelap saat hover */
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
            color: #fff ;
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
    </style>

    <div class="container" data-aos="fade-up">
        <div class="section-title">
            <h2>Survei Kepuasan Pengguna Lulusan</h2>
            <p>Mohon isi formulir di bawah ini dengan lengkap dan jujur untuk membantu kami meningkatkan kualitas lulusan.
            </p>
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

            <form action="{{ route('survei.perusahaan.store') }}" method="post" class="survey-form" data-aos="fade-up"
                data-aos-delay="200">
                @csrf
                <div class="row gy-4">
                    <!-- Data Penilai -->
                    <div class="col-md-12">
                        <h4 class="mb-3">Data Penilai</h4>
                    </div>

                    <!-- Perusahaan (Penilai) -->
                    <div class="form-group col-md-6">
                        <label for="nama_instansi_penilai">Perusahaan (Penilai) <span class="text-danger">*</span></label>
                        <select name="nama_instansi_penilai" id="nama_instansi_penilai" class="form-control @error('nama_instansi_penilai') is-invalid @enderror" required>
                            <option value="">-- Pilih Perusahaan --</option>
                            @php
                                $uniqueInstansi = [];
                            @endphp
                            @foreach ($alumniList as $alumni)
                                @if(!empty($alumni->nama_instansi) && !in_array(strtolower(trim($alumni->nama_instansi)), $uniqueInstansi))
                                    <option value="{{ $alumni->nama_instansi }}"
                                        {{ old('nama_instansi_penilai') == $alumni->nama_instansi ? 'selected' : '' }}>
                                        {{ $alumni->nama_instansi }}
                                    </option>
                                    @php $uniqueInstansi[] = strtolower(trim($alumni->nama_instansi)); @endphp
                                @endif
                            @endforeach
                        </select>
                        @error('nama_instansi_penilai')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <div id="nama_instansi_penilai_warning" class="custom-validation-message"></div>
                    </div>
                    <!-- OTP Perusahaan -->
                    <div class="form-group col-md-6">
                        <label for="kode_otp_perusahaan">OTP Perusahaan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('kode_otp_perusahaan') is-invalid @enderror"
                            id="kode_otp_perusahaan" name="kode_otp_perusahaan" maxlength="4" required
                            value="{{ old('kode_otp_perusahaan') }}">
                        @error('kode_otp_perusahaan')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <div id="kode_otp_perusahaan_warning" class="custom-validation-message"></div>
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
                        <label for="instansi" class="pb-2">Instansi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('instansi') is-invalid @enderror" id="instansi" name="instansi"
                            value="{{ old('instansi') }}" required>
                        @error('instansi')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <div id="instansi_warning" class="custom-validation-message"></div>
                    </div>
                    <div class="col-md-4">
                        <label for="jabatan" class="pb-2">Jabatan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('jabatan') is-invalid @enderror" id="jabatan" name="jabatan"
                            value="{{ old('jabatan') }}" required>
                        @error('jabatan')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <div id="jabatan_warning" class="custom-validation-message"></div>
                    </div>
                    <div class="col-md-4">
                        <label for="no_telepon" class="pb-2">No. Telepon <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('no_telepon') is-invalid @enderror" id="no_telepon" name="no_telepon"
                            value="{{ old('no_telepon') }}" required>
                        @error('no_telepon')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <div id="no_telepon_warning" class="custom-validation-message"></div>
                    </div>
                    <div class="col-md-4">
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
                                placeholder="Cari alumni berdasarkan nama" autocomplete="off">
                            <div id="search_results" class="search-results d-none"></div>
                            <input type="hidden" id="nim" name="nim" required>
                            @error('nim')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <div id="selected_alumni" class="selected-alumni-info d-none">
                                <strong id="selected_alumni_text"></strong>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 mt-4">
                        <div class="card shadow-sm border-0 mb-3" style="background: linear-gradient(90deg, #e9f5ff 0%, #f8fafc 100%);">
                            <div class="card-body">
                                <h4 class="mb-2" style="color:#04182d;">
                                    <i class="bi bi-star-fill text-warning"></i>
                                    Penilaian Kinerja <span style="font-size:0.8em;" class="text-muted">(1-5)</span>
                                </h4>
                                <div class="d-flex align-items-center mb-2 flex-wrap">
                                    <span class="badge pastel-danger me-2" style="font-size:1em;">
                                        1
                                        <span class="emote-anim" style="margin-left:6px;">😡</span>
                                    </span>
                                    <span class="me-3">Sangat Kurang</span>
                                    <span class="badge pastel-warning me-2" style="font-size:1em;">
                                        2
                                        <span class="emote-anim" style="margin-left:6px;">😕</span>
                                    </span>
                                    <span class="me-3">Kurang</span>
                                    <span class="badge pastel-secondary me-2" style="font-size:1em;">
                                        3
                                        <span class="emote-anim" style="margin-left:6px;">😐</span>
                                    </span>
                                    <span class="me-3">Cukup</span>
                                    <span class="badge pastel-info me-2" style="font-size:1em;">
                                        4
                                        <span class="emote-anim" style="margin-left:6px;">🙂</span>
                                    </span>
                                    <span class="me-3">Baik</span>
                                    <span class="badge pastel-success me-2" style="font-size:1em;">
                                        5
                                        <span class="emote-anim" style="margin-left:6px;">😃</span>
                                    </span>
                                    <span>Sangat Baik</span>
                                </div>
                                <p class="text-muted mb-0" style="font-size:0.95em;">
                                    Pilih nilai untuk setiap aspek di bawah ini dengan klik bintang atau angka sesuai penilaian Anda.
                                </p>
                            </div>
                        </div>
                    </div>
                    <style>
                        .emote-anim {
                            display: inline-block;
                            animation: emote-bounce 1.2s infinite;
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
                        .badge.pastel-danger .emote-anim { animation-delay: 0s; }
                        .badge.pastel-warning .emote-anim { animation-delay: 0.1s; }
                        .badge.pastel-secondary .emote-anim { animation-delay: 0.2s; }
                        .badge.pastel-info .emote-anim { animation-delay: 0.3s; }
                        .badge.pastel-success .emote-anim { animation-delay: 0.4s; }
                        @keyframes emote-bounce {
                            0%, 100% { transform: translateY(0); }
                            20% { transform: translateY(-6px); }
                            40% { transform: translateY(0); }
                            60% { transform: translateY(-3px); }
                            80% { transform: translateY(0); }
                        }
                    </style>

                    <!-- Kerjasama Tim -->
                    <div class="col-md-6">
                        <label class="pb-2">Kerjasama Tim <span class="text-danger">*</span></label>
                        <div class="rating-container">
                            <input type="radio" id="kerjasama-5" name="kerjasama" value="5"
                                {{ old('kerjasama') == '5' ? 'checked' : '' }} required>
                            <label for="kerjasama-5" title="Sangat Baik"></label>

                            <input type="radio" id="kerjasama-4" name="kerjasama" value="4"
                                {{ old('kerjasama') == '4' ? 'checked' : '' }} required>
                            <label for="kerjasama-4" title="Baik"></label>

                            <input type="radio" id="kerjasama-3" name="kerjasama" value="3"
                                {{ old('kerjasama') == '3' ? 'checked' : '' }} required>
                            <label for="kerjasama-3" title="Cukup"></label>

                            <input type="radio" id="kerjasama-2" name="kerjasama" value="2"
                                {{ old('kerjasama') == '2' ? 'checked' : '' }} required>
                            <label for="kerjasama-2" title="Kurang"></label>

                            <input type="radio" id="kerjasama-1" name="kerjasama" value="1"
                                {{ old('kerjasama') == '1' ? 'checked' : '' }} required>
                            <label for="kerjasama-1" title="Sangat Kurang"></label>
                        </div>
                        @error('kerjasama')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Keahlian di bidang TI -->
                    <div class="col-md-6">
                        <label class="pb-2">Keahlian di bidang TI <span class="text-danger">*</span></label>
                        <div class="rating-container">
                            <input type="radio" id="keahlian-5" name="keahlian" value="5"
                                {{ old('keahlian') == '5' ? 'checked' : '' }} required>
                            <label for="keahlian-5" title="Sangat Baik"></label>

                            <input type="radio" id="keahlian-4" name="keahlian" value="4"
                                {{ old('keahlian') == '4' ? 'checked' : '' }} required>
                            <label for="keahlian-4" title="Baik"></label>

                            <input type="radio" id="keahlian-3" name="keahlian" value="3"
                                {{ old('keahlian') == '3' ? 'checked' : '' }} required>
                            <label for="keahlian-3" title="Cukup"></label>

                            <input type="radio" id="keahlian-2" name="keahlian" value="2"
                                {{ old('keahlian') == '2' ? 'checked' : '' }} required>
                            <label for="keahlian-2" title="Kurang"></label>

                            <input type="radio" id="keahlian-1" name="keahlian" value="1"
                                {{ old('keahlian') == '1' ? 'checked' : '' }} required>
                            <label for="keahlian-1" title="Sangat Kurang"></label>
                        </div>
                        @error('keahlian')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Kemampuan berbahasa asing -->
                    <div class="col-md-6">
                        <label class="pb-2">Kemampuan berbahasa asing <span class="text-danger">*</span></label>
                        <div class="rating-container">
                            <input type="radio" id="kemampuan_basing-5" name="kemampuan_basing" value="5"
                                {{ old('kemampuan_basing') == '5' ? 'checked' : '' }} required>
                            <label for="kemampuan_basing-5" title="Sangat Baik"></label>

                            <input type="radio" id="kemampuan_basing-4" name="kemampuan_basing" value="4"
                                {{ old('kemampuan_basing') == '4' ? 'checked' : '' }} required>
                            <label for="kemampuan_basing-4" title="Baik"></label>

                            <input type="radio" id="kemampuan_basing-3" name="kemampuan_basing" value="3"
                                {{ old('kemampuan_basing') == '3' ? 'checked' : '' }} required>
                            <label for="kemampuan_basing-3" title="Cukup"></label>

                            <input type="radio" id="kemampuan_basing-2" name="kemampuan_basing" value="2"
                                {{ old('kemampuan_basing') == '2' ? 'checked' : '' }} required>
                            <label for="kemampuan_basing-2" title="Kurang"></label>

                            <input type="radio" id="kemampuan_basing-1" name="kemampuan_basing" value="1"
                                {{ old('kemampuan_basing') == '1' ? 'checked' : '' }} required>
                            <label for="kemampuan_basing-1" title="Sangat Kurang"></label>
                        </div>
                        @error('kemampuan_basing')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Kemampuan berkomunikasi -->
                    <div class="col-md-6">
                        <label class="pb-2">Kemampuan berkomunikasi <span class="text-danger">*</span></label>
                        <div class="rating-container">
                            <input type="radio" id="kemampuan_komunikasi-5" name="kemampuan_komunikasi" value="5"
                                {{ old('kemampuan_komunikasi') == '5' ? 'checked' : '' }} required>
                            <label for="kemampuan_komunikasi-5" title="Sangat Baik"></label>

                            <input type="radio" id="kemampuan_komunikasi-4" name="kemampuan_komunikasi" value="4"
                                {{ old('kemampuan_komunikasi') == '4' ? 'checked' : '' }} required>
                            <label for="kemampuan_komunikasi-4" title="Baik"></label>

                            <input type="radio" id="kemampuan_komunikasi-3" name="kemampuan_komunikasi" value="3"
                                {{ old('kemampuan_komunikasi') == '3' ? 'checked' : '' }} required>
                            <label for="kemampuan_komunikasi-3" title="Cukup"></label>

                            <input type="radio" id="kemampuan_komunikasi-2" name="kemampuan_komunikasi" value="2"
                                {{ old('kemampuan_komunikasi') == '2' ? 'checked' : '' }} required>
                            <label for="kemampuan_komunikasi-2" title="Kurang"></label>

                            <input type="radio" id="kemampuan_komunikasi-1" name="kemampuan_komunikasi" value="1"
                                {{ old('kemampuan_komunikasi') == '1' ? 'checked' : '' }} required>
                            <label for="kemampuan_komunikasi-1" title="Sangat Kurang"></label>
                        </div>
                        @error('kemampuan_komunikasi')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Pengembangan diri -->
                    <div class="col-md-6">
                        <label class="pb-2">Pengembangan diri <span class="text-danger">*</span></label>
                        <div class="rating-container">
                            <input type="radio" id="pengembangan_diri-5" name="pengembangan_diri" value="5"
                                {{ old('pengembangan_diri') == '5' ? 'checked' : '' }} required>
                            <label for="pengembangan_diri-5" title="Sangat Baik"></label>

                            <input type="radio" id="pengembangan_diri-4" name="pengembangan_diri" value="4"
                                {{ old('pengembangan_diri') == '4' ? 'checked' : '' }} required>
                            <label for="pengembangan_diri-4" title="Baik"></label>

                            <input type="radio" id="pengembangan_diri-3" name="pengembangan_diri" value="3"
                                {{ old('pengembangan_diri') == '3' ? 'checked' : '' }} required>
                            <label for="pengembangan_diri-3" title="Cukup"></label>

                            <input type="radio" id="pengembangan_diri-2" name="pengembangan_diri" value="2"
                                {{ old('pengembangan_diri') == '2' ? 'checked' : '' }} required>
                            <label for="pengembangan_diri-2" title="Kurang"></label>

                            <input type="radio" id="pengembangan_diri-1" name="pengembangan_diri" value="1"
                                {{ old('pengembangan_diri') == '1' ? 'checked' : '' }} required>
                            <label for="pengembangan_diri-1" title="Sangat Kurang"></label>
                        </div>
                        @error('pengembangan_diri')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Kepemimpinan -->
                    <div class="col-md-6">
                        <label class="pb-2">Kepemimpinan <span class="text-danger">*</span></label>
                        <div class="rating-container">
                            <input type="radio" id="kepemimpinan-5" name="kepemimpinan" value="5"
                                {{ old('kepemimpinan') == '5' ? 'checked' : '' }} required>
                            <label for="kepemimpinan-5" title="Sangat Baik"></label>

                            <input type="radio" id="kepemimpinan-4" name="kepemimpinan" value="4"
                                {{ old('kepemimpinan') == '4' ? 'checked' : '' }} required>
                            <label for="kepemimpinan-4" title="Baik"></label>

                            <input type="radio" id="kepemimpinan-3" name="kepemimpinan" value="3"
                                {{ old('kepemimpinan') == '3' ? 'checked' : '' }} required>
                            <label for="kepemimpinan-3" title="Cukup"></label>

                            <input type="radio" id="kepemimpinan-2" name="kepemimpinan" value="2"
                                {{ old('kepemimpinan') == '2' ? 'checked' : '' }} required>
                            <label for="kepemimpinan-2" title="Kurang"></label>

                            <input type="radio" id="kepemimpinan-1" name="kepemimpinan" value="1"
                                {{ old('kepemimpinan') == '1' ? 'checked' : '' }} required>
                            <label for="kepemimpinan-1" title="Sangat Kurang"></label>
                        </div>
                        @error('kepemimpinan')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Etos Kerja -->
                    <div class="col-md-6">
                        <label class="pb-2">Etos Kerja <span class="text-danger">*</span></label>
                        <div class="rating-container">
                            <input type="radio" id="etoskerja-5" name="etoskerja" value="5"
                                {{ old('etoskerja') == '5' ? 'checked' : '' }} required>
                            <label for="etoskerja-5" title="Sangat Baik"></label>

                            <input type="radio" id="etoskerja-4" name="etoskerja" value="4"
                                {{ old('etoskerja') == '4' ? 'checked' : '' }} required>
                            <label for="etoskerja-4" title="Baik"></label>

                            <input type="radio" id="etoskerja-3" name="etoskerja" value="3"
                                {{ old('etoskerja') == '3' ? 'checked' : '' }} required>
                            <label for="etoskerja-3" title="Cukup"></label>

                            <input type="radio" id="etoskerja-2" name="etoskerja" value="2"
                                {{ old('etoskerja') == '2' ? 'checked' : '' }} required>
                            <label for="etoskerja-2" title="Kurang"></label>

                            <input type="radio" id="etoskerja-1" name="etoskerja" value="1"
                                {{ old('etoskerja') == '1' ? 'checked' : '' }} required>
                            <label for="etoskerja-1" title="Sangat Kurang"></label>
                        </div>
                        @error('etoskerja')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Additional Information -->
                    <div class="col-md-12 mt-4">
                        <h4 class="mb-3">Informasi Tambahan</h4>
                    </div>

                    <!-- Kompetensi yang dibutuhkan tapi belum dapat dipenuhi -->
                    <div class="col-md-12">
                        <label for="kompetensi_yang_belum_dipenuhi" class="pb-2">Kompetensi yang dibutuhkan tapi belum
                            dapat
                            dipenuhi <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="kompetensi_yang_belum_dipenuhi" name="kompetensi_yang_belum_dipenuhi"
                            rows="3" required>{{ old('kompetensi_yang_belum_dipenuhi') }}</textarea>
                        @error('kompetensi_yang_belum_dipenuhi')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Saran untuk kurikulum program studi -->
                    <div class="col-md-12">
                        <label for="saran" class="pb-2">Saran untuk kurikulum program studi <span
                                class="text-danger">*</span></label>
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
                const surveyForm = document.querySelector('.php-email-form');

                // Function to search alumni
                function searchAlumni() {
                    const searchTerm = searchInput.value.trim();
                    if (searchTerm.length < 3) {
                        return;
                    }

                    // Show loading indicator
                    searchResults.innerHTML = '<div class="p-2 text-center">Mencari...</div>';
                    searchResults.classList.remove('d-none');

                    // Using raw AJAX request instead of fetch for better compatibility
                    const xhr = new XMLHttpRequest();
                    xhr.open('GET', `/api/alumni/search-for-survey?term=${encodeURIComponent(searchTerm)}`, true);
                    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                    xhr.onload = function() {
                        if (xhr.status === 200) {
                            const data = JSON.parse(xhr.responseText);
                            renderSearchResults(data);
                        } else {
                            searchResults.innerHTML =
                                '<div class="p-2 text-center text-danger">Terjadi kesalahan saat mencari data</div>';
                        }
                    };
                    xhr.onerror = function() {
                        searchResults.innerHTML =
                            '<div class="p-2 text-center text-danger">Terjadi kesalahan koneksi</div>';
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
                    searchInput.value = '';
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
                    }, 300); // Debounce search for better performance
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

                // Custom form handling to fix preloader issue
                if (surveyForm) {
                    surveyForm.addEventListener('submit', function(e) {
                        // Let the form submit normally, but ensure loading indicator is properly handled
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

                // If there's a success message in the page (after redirect), hide the loading indicator
                const successAlert = document.querySelector('.alert-success');
                const errorAlert = document.querySelector('.alert-danger');
                if (successAlert || errorAlert) {
                    const loadingElement = document.querySelector('.loading');
                    if (loadingElement) {
                        loadingElement.style.display = 'none';
                    }
                }

                // Simple JS validation for required fields
                document.querySelector('form.survey-form').addEventListener('submit', function(e) {
                    let valid = true;
                    const requiredFields = [
                        'nama_instansi_penilai',
                        'kode_otp_perusahaan',
                        'nama',
                        'instansi',
                        'jabatan',
                        'no_telepon',
                        'email'
                    ];
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

            // Optional: Clear search results when the form is submitted
            surveyForm.addEventListener('submit', function() {
                searchResults.classList.add('d-none');
            });
        </script>
    @endpush
@endsection
