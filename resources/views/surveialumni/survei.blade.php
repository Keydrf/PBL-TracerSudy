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

            <form action="{{ route('alumni.survey.store') }}" method="post" class="survey-form" data-aos="fade-up" data-aos-delay="200">
                @csrf
                <div class="row gy-4">
                    <!-- Nama (Search) -->
                    <div class="col-md-12">
                        <label for="alumni_search" class="pb-2">Nama <span class="text-danger">*</span></label>
                        <div class="position-relative">
                            <input type="text" class="form-control" id="alumni_search"
                                placeholder="Cari berdasarkan NIM atau Nama" autocomplete="off">
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

                    <!-- Program Studi -->
                    <div class="col-md-6">
                        <label for="program_studi" class="pb-2">Program Studi <span class="text-danger">*</span></label>
                        <select class="form-control" id="program_studi" name="program_studi" required>
                            <option value="">Pilih Program Studi</option>
                            <option value="Teknik Informatika">Teknik Informatika</option>
                            <option value="Sistem Informasi">Sistem Informasi</option>
                            <option value="Manajemen Informatika">Manajemen Informatika</option>
                            <!-- Add more options as needed -->
                        </select>
                        @error('program_studi')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tahun Lulus -->
                    <div class="col-md-6">
                        <label for="tahun_lulus" class="pb-2">Tahun Lulus <span class="text-danger">*</span></label>
                        <select class="form-control" id="tahun_lulus" name="tahun_lulus" required>
                            <option value="">Pilih Tahun Lulus</option>
                            @php
                                $currentYear = date('Y');
                                for ($year = $currentYear; $year >= $currentYear - 10; $year--) {
                                    echo "<option value='{$year}'>{$year}</option>";
                                }
                            @endphp
                        </select>
                        @error('tahun_lulus')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- No HP -->
                    <div class="col-md-6">
                        <label for="no_telepon" class="pb-2">No. HP <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="no_telepon" name="no_telepon" required>
                        @error('no_telepon')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="col-md-6">
                        <label for="email" class="pb-2">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" name="email" required>
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tanggal Pertama Kerja -->
                    <div class="col-md-6">
                        <label for="tanggal_pertama_kerja" class="pb-2">Tanggal Pertama Kerja <span
                                class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="tanggal_pertama_kerja" name="tanggal_pertama_kerja"
                            required>
                        @error('tanggal_pertama_kerja')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tanggal Mulai Kerja pada Instansi Saat Ini -->
                    <div class="col-md-6">
                        <label for="tanggal_pertama_kerja_instansi_saat_ini" class="pb-2">Tanggal Mulai Kerja pada Instansi
                            Saat Ini <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="tanggal_pertama_kerja_instansi_saat_ini"
                            name="tanggal_pertama_kerja_instansi_saat_ini" required>
                        @error('tanggal_pertama_kerja_instansi_saat_ini')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Jenis Instansi -->
                    <div class="col-md-6">
                        <label for="jenis_instansi" class="pb-2">Jenis Instansi <span class="text-danger">*</span></label>
                        <select class="form-control" id="jenis_instansi" name="jenis_instansi" required>
                            <option value="">Pilih Jenis Instansi</option>
                            <option value="Pemerintah">Pemerintah</option>
                            <option value="BUMN">BUMN</option>
                            <option value="Swasta">Swasta</option>
                            <option value="Wirausaha">Wirausaha</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                        @error('jenis_instansi')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Nama Instansi -->
                    <div class="col-md-6">
                        <label for="nama_instansi" class="pb-2">Nama Instansi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama_instansi" name="nama_instansi" required>
                        @error('nama_instansi')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Skala -->
                    <div class="col-md-6">
                        <label for="skala" class="pb-2">Skala <span class="text-danger">*</span></label>
                        <select class="form-control" id="skala" name="skala" required>
                            <option value="">Pilih Skala</option>
                            <option value="Lokal">Lokal</option>
                            <option value="Nasional">Nasional</option>
                            <option value="Internasional">Internasional</option>
                        </select>
                        @error('skala')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Lokasi Instansi -->
                    <div class="col-md-6">
                        <label for="lokasi_instansi" class="pb-2">Lokasi Instansi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="lokasi_instansi" name="lokasi_instansi"
                            placeholder="Kota, Provinsi" required>
                        @error('lokasi_instansi')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Kategori Profesi -->
                    <div class="col-md-6">
                        <label for="kategori_profesi" class="pb-2">Kategori Profesi <span
                                class="text-danger">*</span></label>
                        <select class="form-control" id="kategori_profesi" name="kategori_profesi" required>
                            <option value="">Pilih Kategori Profesi</option>
                            <option value="IT">IT</option>
                            <option value="Pendidikan">Pendidikan</option>
                            <option value="Kesehatan">Kesehatan</option>
                            <option value="Keuangan">Keuangan</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                        @error('kategori_profesi')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Profesi -->
                    <div class="col-md-6">
                        <label for="profesi" class="pb-2">Profesi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="profesi" name="profesi" required>
                        @error('profesi')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <h4 class="mt-4 mb-3">Informasi Atasan Langsung</h4>
                    </div>

                    <!-- Nama Atasan Langsung -->
                    <div class="col-md-6">
                        <label for="nama_atasan" class="pb-2">Nama Atasan Langsung <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama_atasan" name="nama_atasan" required>
                        @error('nama_atasan')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Jabatan Atasan Langsung -->
                    <div class="col-md-6">
                        <label for="jabatan_atasan" class="pb-2">Jabatan Atasan Langsung <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="jabatan_atasan" name="jabatan_atasan" required>
                        @error('jabatan_atasan')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- No HP Atasan Langsung -->
                    <div class="col-md-6">
                        <label for="no_telepon_atasan" class="pb-2">No HP Atasan Langsung <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="no_telepon_atasan" name="no_telepon_atasan" required>
                        @error('no_telepon_atasan')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email Atasan Langsung -->
                    <div class="col-md-6">
                        <label for="email_atasan" class="pb-2">Email Atasan Langsung <span
                                class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email_atasan" name="email_atasan" required>
                        @error('email_atasan')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12 text-center">
                        <div class="error-message"></div>
                        <button type="submit">Simpan Data</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const searchInput = document.getElementById('alumni_search');
                const searchResults = document.getElementById('search_results');
                const nimInput = document.getElementById('nim');
                const selectedAlumni = document.getElementById('selected_alumni');
                const selectedAlumniText = document.getElementById('selected_alumni_text');
                const tanggalPertamaKerja = document.getElementById('tanggal_pertama_kerja');
                const tanggalPertamaKerjaInstansi = document.getElementById('tanggal_pertama_kerja_instansi_saat_ini');
                const surveyForm = document.querySelector('.php-email-form');

                // Function to search alumni
                function searchAlumni() {
                    const searchTerm = searchInput.value.trim();
                    if (searchTerm.length < 3) {
                        alert('Masukkan minimal 3 karakter untuk pencarian');
                        return;
                    }

                    // Show loading indicator
                    searchResults.innerHTML = '<div class="p-2 text-center">Mencari...</div>';
                    searchResults.classList.remove('d-none');

                    // Using raw AJAX request instead of fetch for better compatibility
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
                        item.textContent = `${alumni.nim} - ${alumni.nama}`;
                        item.addEventListener('click', function () {
                            selectAlumni(alumni);
                        });
                        searchResults.appendChild(item);
                    });

                    searchResults.classList.remove('d-none');
                }

                // Function to select an alumni
                function selectAlumni(alumni) {
                    nimInput.value = alumni.nim;
                    selectedAlumniText.textContent = `${alumni.nim} - ${alumni.nama}`;
                    selectedAlumni.classList.remove('d-none');
                    searchResults.classList.add('d-none');
                    searchInput.value = '';

                    // Auto-fill program studi dan tahun lulus
                    if (alumni.program_studi) {
                        document.getElementById('program_studi').value = alumni.program_studi;
                    }

                    if (alumni.tahun_lulus) {
                        document.getElementById('tahun_lulus').value = alumni.tahun_lulus;
                    }
                }

                // Event listeners
                searchInput.addEventListener('input', function () {
                    if (this.value.trim().length >= 3) {
                        searchAlumni();
                    } else {
                        searchResults.classList.add('d-none');
                    }
                });

                searchInput.addEventListener('focus', function () {
                    if (this.value.trim().length >= 3) {
                        searchAlumni();
                    }
                });

                // Hide search results when clicking outside
                document.addEventListener('click', function (e) {
                    if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                        searchResults.classList.add('d-none');
                    }
                });

                // Calculate masa tunggu automatically
                tanggalPertamaKerja.addEventListener('change', function () {
                    calculateMasaTunggu();
                });

                // Ensure second date is not before first date
                tanggalPertamaKerjaInstansi.addEventListener('change', function () {
                    const firstDate = new Date(tanggalPertamaKerja.value);
                    const secondDate = new Date(tanggalPertamaKerjaInstansi.value);

                    if (secondDate < firstDate) {
                        alert('Tanggal mulai kerja pada instansi saat ini tidak boleh sebelum tanggal pertama kerja');
                        tanggalPertamaKerjaInstansi.value = tanggalPertamaKerja.value;
                    }
                });

                // Function to calculate masa tunggu (waiting period)
                function calculateMasaTunggu() {
                    const tahunLulus = document.getElementById('tahun_lulus').value;
                    const tanggalKerja = tanggalPertamaKerja.value;

                    if (tahunLulus && tanggalKerja) {
                        // Assuming graduation is on June 30th of the graduation year
                        const graduationDate = new Date(tahunLulus, 5, 30); // Month is 0-indexed (5 = June)
                        const workDate = new Date(tanggalKerja);

                        // Calculate difference in months
                        const diffMonths = (workDate.getFullYear() - graduationDate.getFullYear()) * 12 +
                            (workDate.getMonth() - graduationDate.getMonth());

                        // Add hidden input for masa_tunggu
                        let masaTungguInput = document.getElementById('masa_tunggu');
                        if (!masaTungguInput) {
                            masaTungguInput = document.createElement('input');
                            masaTungguInput.type = 'hidden';
                            masaTungguInput.id = 'masa_tunggu';
                            masaTungguInput.name = 'masa_tunggu';
                            document.querySelector('form').appendChild(masaTungguInput);
                        }

                        masaTungguInput.value = diffMonths > 0 ? diffMonths : 0;
                    }
                }

                if (surveyForm) {
                    surveyForm.addEventListener('submit', function (e) {
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
            });


        </script>
    @endpush
@endsection