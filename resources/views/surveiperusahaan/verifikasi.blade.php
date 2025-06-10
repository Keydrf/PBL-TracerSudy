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
            <h2>Verifikasi Perusahaan</h2>
            <p>Verifikasi data perusahaan dan OTP untuk mengisi survei kepuasan.</p>
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

            <form action="{{ route('survei.perusahaan.verify') }}" method="post" class="verification-form">
                @csrf
                <div class="row gy-4">
                    <div class="col-12">
                        <label for="nama_instansi_penilai" class="pb-2">Pilih Perusahaan <span class="text-danger">*</span></label>
                        <select name="nama_instansi_penilai" id="nama_instansi_penilai" 
                                class="form-control @error('nama_instansi_penilai') is-invalid @enderror" required>
                            <option value="">-- Pilih Perusahaan --</option>
                            @php $uniqueInstansi = []; @endphp
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
                    </div>

                    <div class="col-12">
                        <label for="kode_otp_perusahaan" class="pb-2">Kode OTP Perusahaan <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('kode_otp_perusahaan') is-invalid @enderror" 
                               id="kode_otp_perusahaan" 
                               name="kode_otp_perusahaan" 
                               maxlength="4" 
                               required 
                               value="{{ old('kode_otp_perusahaan') }}"
                               placeholder="Masukkan 4 digit kode OTP">
                        @error('kode_otp_perusahaan')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Masukkan kode OTP yang dikirim ke email perusahaan.</small>
                    </div>

                    <div class="col-12 text-center">
                        <button type="submit">Verifikasi & Lanjutkan Survei</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
