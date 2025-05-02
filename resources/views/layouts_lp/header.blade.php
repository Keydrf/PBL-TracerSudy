<header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

      <a href="index.html" class="logo d-flex align-items-center me-auto">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="TemplateLP/assets/img/logo.png" alt=""> -->
        <h1 class="sitename">TraceEdu</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="/" class="active">Beranda</a></li>
          <li><a href="/surveialumni" >Survei Alumni</a></li>
          <li><a href="/surveiperusahaan">Survei Perusahaan</a></li>
          <li><a href="/sebaran-profesi">Sebaran Profesi</a></li>
          
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>



    </div>
    <script>
      // Ambil path URL saat ini
      const currentPath = window.location.pathname;
    
      // Ambil semua link dalam navmenu
      const navLinks = document.querySelectorAll('#navmenu a');
    
      // Loop semua link dan bandingkan dengan currentPath
      navLinks.forEach(link => {
        // Jika href cocok dengan path saat ini
        if (link.getAttribute('href') === currentPath) {
          link.classList.add('active'); // Tambahkan class active
        } else {
          link.classList.remove('active'); // Pastikan yang lain tidak active
        }
      });
    </script>
    
  </header>