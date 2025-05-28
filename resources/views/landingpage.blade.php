@extends('layouts_lp.template')

@section('content')
    <!-- Hero Section -->
    <section id="hero" class="hero section">

        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center" data-aos="fade-up">
                    <h1>Berbagi Jejak Karir Alumni</h1>
                    <p>Ikuti perkembangan karir alumni dan berikan kontribusi pada almamater Anda.</p>
                    <div class="d-flex">
                        <a href="/surveialumni" class="btn-get-started">Mulai Sekarang</a>
                    </div>
                </div>
                <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-out" data-aos-delay="100">
                    <img src="{{asset('TemplateLP/assets/img/hero-img.png')}}" class="img-fluid animated"
                        alt="Ilustrasi Tracer Study">
                </div>
            </div>
        </div>

    </section>


    <!-- Featured Services Section -->
    <section id="featured-services" class="featured-services section">

        <div class="container">

            <div class="row gy-4">

                <div class="col-lg-4 d-flex" data-aos="fade-up" data-aos-delay="100">
                    <div class="service-item position-relative">
                        <div class="icon"><i class="bi bi-graph-up-arrow icon"></i></div>
                        <h4><a href="" class="stretched-link">Pemantauan Karier Alumni</a></h4>
                        <p>Melacak perkembangan karier alumni untuk mengetahui seberapa relevan pendidikan dengan dunia
                            kerja.</p>
                    </div>
                </div><!-- End Service Item -->

                <div class="col-lg-4 d-flex" data-aos="fade-up" data-aos-delay="200">
                    <div class="service-item position-relative">
                        <div class="icon"><i class="bi bi-bar-chart-line icon"></i></div>
                        <h4><a href="" class="stretched-link">Evaluasi Kurikulum</a></h4>
                        <p>Data alumni digunakan untuk menilai efektivitas kurikulum dan meningkatkan kualitas pembelajaran.
                        </p>
                    </div>
                </div><!-- End Service Item -->

                <div class="col-lg-4 d-flex" data-aos="fade-up" data-aos-delay="300">
                    <div class="service-item position-relative">
                        <div class="icon"><i class="bi bi-people icon"></i></div>
                        <h4><a href="" class="stretched-link">Hubungan Institusi dan Alumni</a></h4>
                        <p>Membangun jaringan komunikasi berkelanjutan antara kampus dan alumni untuk kemajuan bersama.</p>
                    </div>
                </div><!-- End Service Item -->

            </div>

        </div>


    </section><!-- /Featured Services Section -->

    <!-- About Section -->
    <section id="about" class="about section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <span>Tentang Tracer Study<br></span>
            <h2>Tentang Kami</h2>
            <p>Platform ini digunakan untuk melacak jejak alumni setelah lulus serta mengevaluasi keterkaitan dunia kerja
                dengan kurikulum pendidikan.</p>
        </div><!-- End Section Title -->

        <div class="container">

            <div class="row gy-4">
                <div class="col-lg-6 position-relative align-self-start" data-aos="fade-up" data-aos-delay="100">
                    <img src="{{asset('TemplateLP/assets/img/about.png')}}" class="img-fluid" alt="">
                    {{-- <a href="https://www.youtube.com/watch?v=Y7f98aduVJ8" class="glightbox pulsating-play-btn"></a> --}}
                </div>
                <div class="col-lg-6 content" data-aos="fade-up" data-aos-delay="200">
                    <h3>Menjalin Koneksi Alumni dan Meningkatkan Mutu Pendidikan</h3>
                    <p class="fst-italic">
                        Tracer Study membantu institusi pendidikan memahami perjalanan karier alumni dan menilai relevansi
                        pendidikan yang diberikan.
                    </p>
                    <ul>
                        <li><i class="bi bi-check2-all"></i> <span>Mengumpulkan data alumni secara sistematis dan
                                terstruktur.</span></li>
                        <li><i class="bi bi-check2-all"></i> <span>Menilai efektivitas kurikulum dan kesiapan kerja
                                lulusan.</span></li>
                        <li><i class="bi bi-check2-all"></i> <span>Membangun hubungan jangka panjang antara alumni dan
                                institusi melalui umpan balik yang konstruktif.</span></li>
                    </ul>
                    <p>
                        Data dari Tracer Study sangat berguna untuk pengembangan program studi, akreditasi, serta sebagai
                        dasar perencanaan strategis pendidikan yang lebih baik di masa depan.
                    </p>
                </div>
            </div>

        </div>

    </section><!-- /About Section -->


    <!-- Stats Section -->
    <section id="stats" class="stats section">
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row gy-4">

                <div class="col-lg-3 col-md-6">
                    <div class="stats-item text-center w-100 h-100">
                        <span data-purecounter-start="0" data-purecounter-end="{{ $totalAlumni }}"
                            data-purecounter-duration="1" class="purecounter"></span>
                        <p>Total Alumni</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="stats-item text-center w-100 h-100">
                        <span data-purecounter-start="0" data-purecounter-end="{{ $totalSurveiAlumni }}"
                            data-purecounter-duration="1" class="purecounter"></span>
                        <p>Tracer Study Terisi</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="stats-item text-center w-100 h-100">
                        <span data-purecounter-start="0" data-purecounter-end="{{ $totalProfesi }}"
                            data-purecounter-duration="1" class="purecounter"></span>
                        <p>Profesi</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="stats-item text-center w-100 h-100">
                        <span data-purecounter-start="0" data-purecounter-end="{{ $totalPerusahaan }}"
                            data-purecounter-duration="1" class="purecounter"></span>
                        <p>Perusahaan Terdaftar</p>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <section id="perusahaan" class="services section light-background">
        <div class="container section-title" data-aos="fade-up">
            <span>Mitra Perusahaan</span>
            <h2>Perusahaan yang Bekerja Sama</h2>
        </div>

        <div class="container">
            <div class="row gy-4">
                @foreach($perusahaanList->take(6) as $perusahaan)
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="service-item position-relative">
                            <div class="icon">
                                <i class="bi bi-building"></i>
                            </div>
                            <h3>{{ $perusahaan->nama_instansi }}</h3>
                            <p>
                                Alamat: {{ $perusahaan->alamat_kantor ?? '-' }}<br>
                                Kontak: {{ $perusahaan->email_atasan ?? '-' }} / {{ $perusahaan->no_telepon_atasan ?? '-' }}<br>
                                Alumni:
                                @if($perusahaan->alumni)
                                    {{ $perusahaan->alumni->nama }}
                                    ({{ $perusahaan->alumni->program_studi }})
                                @else
                                    -
                                @endif
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </section>





    <!-- Lecturer Assessment Section -->
    <section id="lecturer-assessment" class="testimonials section light-background">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <span>Penilaian Dosen</span>
            <h2>Penilaian Kinerja Mahasiswa</h2>
            <p>Berikut adalah penilaian dari beberapa dosen terhadap kinerja alumni setelah lulus dari institusi ini.</p>
        </div><!-- End Section Title -->

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="swiper init-swiper" data-speed="600" data-delay="5000"
                data-breakpoints="{ &quot;320&quot;: { &quot;slidesPerView&quot;: 1, &quot;spaceBetween&quot;: 40 }, &quot;1200&quot;: { &quot;slidesPerView&quot;: 3, &quot;spaceBetween&quot;: 40 } }">
                <script type="application/json" class="swiper-config">
                                {
                                  "loop": true,
                                  "speed": 600,
                                  "autoplay": {
                                    "delay": 5000
                                  },
                                  "slidesPerView": "auto",
                                  "pagination": {
                                    "el": ".swiper-pagination",
                                    "type": "bullets",
                                    "clickable": true
                                  },
                                  "breakpoints": {
                                    "320": {
                                      "slidesPerView": 1,
                                      "spaceBetween": 40
                                    },
                                    "1200": {
                                      "slidesPerView": 3,
                                      "spaceBetween": 20
                                    }
                                  }
                                }
                            </script>

                <div class="swiper-wrapper">

                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <p>
                                <i class="bi bi-quote quote-icon-left"></i>
                                <span>Mahasiswa memiliki etos kerja yang baik, mampu bekerja dalam tim, dan sangat cepat
                                    beradaptasi di lingkungan kerja profesional.</span>
                                <i class="bi bi-quote quote-icon-right"></i>
                            </p>
                            <img src="{{asset('TemplateLP/male0.png')}}" class="testimonial-img" alt="">
                            <h3>Dr. Budi Santoso</h3>
                            <h4>Dosen Teknik Informatika</h4>
                        </div>
                    </div><!-- End testimonial item -->

                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <p>
                                <i class="bi bi-quote quote-icon-left"></i>
                                <span>Alumni ini menunjukkan kemampuan komunikasi yang baik dan tanggung jawab tinggi dalam
                                    menjalankan tugas di perusahaan tempatnya bekerja.</span>
                                <i class="bi bi-quote quote-icon-right"></i>
                            </p>
                            <img src="{{asset('TemplateLP/female.png')}}" class="testimonial-img" alt="">
                            <h3>Prof. Siti Aminah</h3>
                            <h4>Dosen Sistem Informasi</h4>
                        </div>
                    </div><!-- End testimonial item -->

                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <p>
                                <i class="bi bi-quote quote-icon-left"></i>
                                <span>Mahasiswa ini unggul dalam hal inovasi dan pemecahan masalah. Banyak kontribusi
                                    positif yang diberikan di tempat kerja.</span>
                                <i class="bi bi-quote quote-icon-right"></i>
                            </p>
                            <img src="{{asset('TemplateLP/male1.png')}}" class="testimonial-img" alt="">
                            <h3>Ir. Andi Wijaya, M.T.</h3>
                            <h4>Dosen Teknik Elektro</h4>
                        </div>
                    </div><!-- End testimonial item -->

                    <!-- Tambahkan penilaian lain jika perlu -->

                </div>
                <div class="swiper-pagination"></div>
            </div>

        </div>

    </section><!-- /Lecturer Assessment Section -->


    <!-- Call To Action Section -->
@endsection