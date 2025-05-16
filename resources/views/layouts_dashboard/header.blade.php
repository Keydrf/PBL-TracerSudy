<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row">
  <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
    <div class="me-3">
      <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="minimize">
        <span class="icon-menu"></span>
      </button>
    </div>
    <div>
      <a class="navbar-brand brand-logo" href="/dashboard">
        <img src="{{ asset('TemplateAdmin/TEDB1.PNG') }}" alt="logo" />
      </a>
      <a class="navbar-brand brand-logo-mini" href="/dashboard">
        <img src="{{ asset('TemplateAdmin/TEDB1.PNG') }}" alt="logo" />
      </a>
    </div>
  </div>
  <div class="navbar-menu-wrapper d-flex align-items-top">
    <ul class="navbar-nav">
      <li class="nav-item fw-semibold d-none d-lg-block ms-0">
        <h1 class="welcome-text">
          <span id="greeting"></span>, <span class="text-black fw-bold">{{ Auth::user()->nama }}</span>
        </h1>
        <h3 class="welcome-sub-text">Selamat Datang di Sistem Tracer Study</h3>
      </li>
    </ul>
    <ul class="navbar-nav navbar-nav-right">
      <li class="nav-item dropdown me-3 position-relative">
        <a class="btn btn-info btn-rounded dropdown-toggle d-flex align-items-center py-2 px-3" 
           href="#" 
           id="languageDropdown" 
           data-bs-toggle="dropdown"
           style="background-color: white; color: #1d3bb2; font-weight: 600; border: 1px solid #dee2e6;">
          <i class="fa fa-language me-2"></i>
          <span id="selected-language" class="text-nowrap">Bahasa</span>
        </a>
        <div class="dropdown-menu dropdown-menu-end mt-2" 
             style="min-width: 120px; border: 1px solid #dee2e6; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
          <a class="dropdown-item d-flex align-items-center py-2 px-3" 
             href="#" 
             onclick="setLanguage('id')"
             style="color: #1d3bb2; font-weight: 500;">
            Indonesia
          </a>
          <a class="dropdown-item d-flex align-items-center py-2 px-3" 
             href="#" 
             onclick="setLanguage('en')"
             style="color: #1d3bb2; font-weight: 500;">
            English
          </a>
        </div>
      </li>
    </ul>
    
    <style>
      /* Memastikan dropdown tidak menggeser posisi tombol */
      .nav-item.dropdown .dropdown-menu {
        position: absolute;
        right: 0;
        left: auto;
        margin-top: 0.5rem;
      }
      
      /* Konsistensi gaya border radius */
      .btn-rounded {
        border-radius: 20px;
      }
      
      /* Efek hover untuk dropdown item */
      .dropdown-item:hover {
        background-color: #f8f9fa;
      }
    </style>

    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
      data-bs-toggle="offcanvas">
      <span class="mdi mdi-menu"></span>
    </button>
  </div>
</nav>
<script>
  function updateGreeting() {
    const now = new Date();
    const hour = now.getHours();
    let greeting = 'Good Morning';

    if (hour < 12) {
      greeting = 'Good Morning';
    } else if (hour < 18) {
      greeting = 'Good Afternoon';
    } else {
      greeting = 'Good Evening';
    }

    document.getElementById('greeting').textContent = greeting;
  }

  updateGreeting(); // Set greeting saat halaman dimuat
  setInterval(updateGreeting, 60000); // Update setiap menit (opsional)
</script>