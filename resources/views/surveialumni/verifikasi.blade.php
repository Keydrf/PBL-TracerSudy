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

        .verification-card {
            max-width: 600px;
            margin: 0 auto;
            padding: 2rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
    </style>

    <div class="container" data-aos="fade-up">
        <div class="section-title">
            <h2>Verifikasi Alumni</h2>
            <p>Mohon verifikasi identitas Anda terlebih dahulu sebelum mengisi survei.</p>
        </div>

        <div class="verification-card" data-aos="fade-up" data-aos-delay="200">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('alumni.survey.verify') }}" method="post" class="verification-form">
                @csrf
                <div class="row gy-4">
                    <div class="col-12">
                        <label for="alumni_search" class="pb-2">Cari Alumni <span class="text-danger">*</span></label>
                        <div class="position-relative">
                            <input type="text" class="form-control @error('nim') is-invalid @enderror" id="alumni_search"
                                placeholder="Cari berdasarkan NIM atau Nama" autocomplete="off"
                                value="{{ old('alumni_search') }}">
                            <div id="search_results" class="search-results d-none"></div>
                            <input type="hidden" id="nim_alumni_hidden" name="nim" required value="{{ old('nim') }}">
                            @error('nim')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <div id="selected_alumni" class="selected-alumni-info {{ old('nim') ? '' : 'd-none' }}">
                                <strong id="selected_alumni_text"></strong>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <label for="kode_otp" class="pb-2">Kode OTP Alumni <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('kode_otp_alumni') is-invalid @enderror" 
                               id="kode_otp" name="kode_otp_alumni" maxlength="4" required value="{{ old('kode_otp_alumni') }}">
                        @error('kode_otp_alumni')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Masukkan kode OTP 4 digit yang telah diberikan kepada Anda.</small>
                    </div>

                    <div class="col-12 text-center">
                        <button type="submit">Verifikasi & Lanjutkan Survei</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const searchInput = document.getElementById('alumni_search');
                const searchResults = document.getElementById('search_results');
                const nimInput = document.getElementById('nim_alumni_hidden');
                const selectedAlumni = document.getElementById('selected_alumni');
                const selectedAlumniText = document.getElementById('selected_alumni_text');

                function searchAlumni() {
                    const searchTerm = searchInput.value.trim();
                    if (searchTerm.length < 3) {
                        searchResults.classList.add('d-none');
                        return;
                    }

                    searchResults.innerHTML = '<div class="p-2 text-center">Mencari...</div>';
                    searchResults.classList.remove('d-none');

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

                function selectAlumni(alumni) {
                    nimInput.value = alumni.nim;
                    selectedAlumniText.textContent = `${alumni.nim} - ${alumni.nama}`;
                    selectedAlumni.classList.remove('d-none');
                    searchResults.classList.add('d-none');
                    searchInput.value = alumni.nama;
                }

                let searchTimeout;
                searchInput.addEventListener('input', function () {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(function () {
                        searchAlumni();
                    }, 300);
                });

                searchInput.addEventListener('focus', function () {
                    if (this.value.trim().length >= 3) {
                        searchAlumni();
                    }
                });

                document.addEventListener('click', function (e) {
                    if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                        searchResults.classList.add('d-none');
                    }
                });
            });
        </script>
    @endpush
@endsection
