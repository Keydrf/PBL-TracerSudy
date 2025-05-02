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
                    <a href="https://www.youtube.com/watch?v=Y7f98aduVJ8" class="glightbox pulsating-play-btn"></a>
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
                        <span data-purecounter-start="0" data-purecounter-end="0"
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
                        <span data-purecounter-start="0" data-purecounter-end="0"
                            data-purecounter-duration="1" class="purecounter"></span>
                        <p>Pengguna Terdaftar</p>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <!-- Services Section -->
    <section id="services" class="services section light-background">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <span>Services</span>
            <h2>Services</h2>
            <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
        </div><!-- End Section Title -->

        <div class="container">

            <div class="row gy-4">

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="service-item position-relative">
                        <div class="icon">
                            <i class="bi bi-activity"></i>
                        </div>
                        <a href="service-details.html" class="stretched-link">
                            <h3>Nesciunt Mete</h3>
                        </a>
                        <p>Provident nihil minus qui consequatur non omnis maiores. Eos accusantium minus dolores iure
                            perferendis tempore et consequatur.</p>
                    </div>
                </div><!-- End Service Item -->

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="service-item position-relative">
                        <div class="icon">
                            <i class="bi bi-broadcast"></i>
                        </div>
                        <a href="service-details.html" class="stretched-link">
                            <h3>Eosle Commodi</h3>
                        </a>
                        <p>Ut autem aut autem non a. Sint sint sit facilis nam iusto sint. Libero corrupti neque eum hic non
                            ut nesciunt dolorem.</p>
                    </div>
                </div><!-- End Service Item -->

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="service-item position-relative">
                        <div class="icon">
                            <i class="bi bi-easel"></i>
                        </div>
                        <a href="service-details.html" class="stretched-link">
                            <h3>Ledo Markt</h3>
                        </a>
                        <p>Ut excepturi voluptatem nisi sed. Quidem fuga consequatur. Minus ea aut. Vel qui id voluptas
                            adipisci eos earum corrupti.</p>
                    </div>
                </div><!-- End Service Item -->

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="service-item position-relative">
                        <div class="icon">
                            <i class="bi bi-bounding-box-circles"></i>
                        </div>
                        <a href="service-details.html" class="stretched-link">
                            <h3>Asperiores Commodit</h3>
                        </a>
                        <p>Non et temporibus minus omnis sed dolor esse consequatur. Cupiditate sed error ea fuga sit
                            provident adipisci neque.</p>
                        <a href="service-details.html" class="stretched-link"></a>
                    </div>
                </div><!-- End Service Item -->

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                    <div class="service-item position-relative">
                        <div class="icon">
                            <i class="bi bi-calendar4-week"></i>
                        </div>
                        <a href="service-details.html" class="stretched-link">
                            <h3>Velit Doloremque</h3>
                        </a>
                        <p>Cumque et suscipit saepe. Est maiores autem enim facilis ut aut ipsam corporis aut. Sed animi at
                            autem alias eius labore.</p>
                        <a href="service-details.html" class="stretched-link"></a>
                    </div>
                </div><!-- End Service Item -->

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
                    <div class="service-item position-relative">
                        <div class="icon">
                            <i class="bi bi-chat-square-text"></i>
                        </div>
                        <a href="service-details.html" class="stretched-link">
                            <h3>Dolori Architecto</h3>
                        </a>
                        <p>Hic molestias ea quibusdam eos. Fugiat enim doloremque aut neque non et debitis iure. Corrupti
                            recusandae ducimus enim.</p>
                        <a href="service-details.html" class="stretched-link"></a>
                    </div>
                </div><!-- End Service Item -->

            </div>

        </div>

    </section><!-- /Services Section -->



    <!-- Testimonials Section -->
    <section id="testimonials" class="testimonials section light-background">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <span>Testimonials</span>
            <h2>Testimonials</h2>
            <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
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
                        <div class="testimonial-item" "="">
                    <p>
                      <i class=" bi bi-quote quote-icon-left"></i>
                            <span>Proin iaculis purus consequat sem cure digni ssim donec porttitora entum suscipit rhoncus.
                                Accusantium quam, ultricies eget id, aliquam eget nibh et. Maecen aliquam, risus at
                                semper.</span>
                            <i class="bi bi-quote quote-icon-right"></i>
                            </p>
                            <img src="{{asset('TemplateLP/assets/img/testimonials/testimonials-1.jpg')}}"
                                class="testimonial-img" alt="">
                            <h3>Saul Goodman</h3>
                            <h4>Ceo &amp; Founder</h4>
                        </div>
                    </div><!-- End testimonial item -->

                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <p>
                                <i class="bi bi-quote quote-icon-left"></i>
                                <span>Export tempor illum tamen malis malis eram quae irure esse labore quem cillum quid
                                    malis quorum velit fore eram velit sunt aliqua noster fugiat irure amet legam anim
                                    culpa.</span>
                                <i class="bi bi-quote quote-icon-right"></i>
                            </p>
                            <img src="{{asset('TemplateLP/assets/img/testimonials/testimonials-2.jpg')}}"
                                class="testimonial-img" alt="">
                            <h3>Sara Wilsson</h3>
                            <h4>Designer</h4>
                        </div>
                    </div><!-- End testimonial item -->

                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <p>
                                <i class="bi bi-quote quote-icon-left"></i>
                                <span>Enim nisi quem export duis labore cillum quae magna enim sint quorum nulla quem veniam
                                    duis minim tempor labore quem eram duis noster aute amet eram fore quis sint
                                    minim.</span>
                                <i class="bi bi-quote quote-icon-right"></i>
                            </p>
                            <img src="{{asset('TemplateLP/assets/img/testimonials/testimonials-3.jpg')}}"
                                class="testimonial-img" alt="">
                            <h3>Jena Karlis</h3>
                            <h4>Store Owner</h4>
                        </div>
                    </div><!-- End testimonial item -->

                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <p>
                                <i class="bi bi-quote quote-icon-left"></i>
                                <span>Fugiat enim eram quae cillum dolore dolor amet nulla culpa multos export minim fugiat
                                    dolor enim duis veniam ipsum anim magna sunt elit fore quem dolore labore illum
                                    veniam.</span>
                                <i class="bi bi-quote quote-icon-right"></i>
                            </p>
                            <img src="{{asset('TemplateLP/assets/img/testimonials/testimonials-4.jpg')}}"
                                class="testimonial-img" alt="">
                            <h3>Matt Brandon</h3>
                            <h4>Freelancer</h4>
                        </div>
                    </div><!-- End testimonial item -->

                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <p>
                                <i class="bi bi-quote quote-icon-left"></i>
                                <span>Quis quorum aliqua sint quem legam fore sunt eram irure aliqua veniam tempor noster
                                    veniam sunt culpa nulla illum cillum fugiat legam esse veniam culpa fore nisi cillum
                                    quid.</span>
                                <i class="bi bi-quote quote-icon-right"></i>
                            </p>
                            <img src="{{asset('TemplateLP/assets/img/testimonials/testimonials-5.jpg')}}"
                                class="testimonial-img" alt="">
                            <h3>John Larson</h3>
                            <h4>Entrepreneur</h4>
                        </div>
                    </div><!-- End testimonial item -->

                </div>
                <div class="swiper-pagination"></div>
            </div>

        </div>

    </section><!-- /Testimonials Section -->

    <!-- Call To Action Section -->
@endsection