<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
      <li class="nav-item">
        <a class="nav-link" href="/dashboard">
          <i class="mdi mdi-grid-large menu-icon"></i>
          <span class="menu-title">Dashboard</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/level">
          <i class="menu-icon mdi mdi-layers-outline"></i>
          <span class="menu-title">Level</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/user">
          <i class="menu-icon mdi mdi-account-circle-outline"></i>
          <span class="menu-title">User</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/alumni">
          <i class="mdi mdi-account-multiple menu-icon"></i>
          <span class="menu-title">Alumni</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/kategori-profesi">
          <i class="mdi mdi-format-list-bulleted menu-icon"></i>
          <span class="menu-title">Kategori Profesi</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/profesi">
          <i class="mdi mdi-account-tie menu-icon"></i>
          <span class="menu-title">Profesi</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/laporan">
          <i class="mdi mdi-file-document menu-icon"></i>
          <span class="menu-title">Laporan</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/logout">
          <i class="mdi mdi-logout menu-icon"></i>
          <span class="menu-title">Logout</span>
        </a>
      </li>
      
    </ul>
  </nav>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
    const currentPath = window.location.pathname;
    const sidebarLinks = document.querySelectorAll('.sidebar-wrapper ul.nav li a');

    sidebarLinks.forEach(link => {
        const linkPath = new URL(link.href, window.location.origin).pathname;
        if (currentPath === linkPath || currentPath.startsWith(linkPath + '/')) {
            link.parentNode.classList.add('active');
        }
    });
});
</script>