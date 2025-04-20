<div class="sidebar" data-color="white" data-active-color="danger">
    <div class="logo">
        <a href="https://www.creative-tim.com" class="simple-text logo-mini">
            <div class="logo-image-small">
                <img src="{{ asset('TemplateDashboard/assets/img/logo-small.png') }}" alt="Logo Small">
            </div>
        </a>
        <a href="https://www.creative-tim.com" class="simple-text logo-normal">
            Trace.Edu
        </a>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li class="{{ request()->is('dashboard') ? 'active' : '' }}">
                <a href="{{ url('dashboard') }}">
                    <i class="nc-icon nc-bank"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li class="{{ request()->is('level') ? 'active' : '' }}">
                <a href="{{ url('level') }}">
                    <i class="nc-icon nc-key-25"></i>
                    <p>Level</p>
                </a>
            </li>
            <li class="{{ request()->is('user') ? 'active' : '' }}">
                <a href="{{ url('user') }}">
                    <i class="nc-icon nc-single-02"></i>
                    <p>User</p>
                </a>
            </li>
            <li class="{{ request()->is('alumni') ? 'active' : '' }}">
                <a href="{{ url('alumni') }}">
                    <i class="nc-icon nc-hat-3"></i>
                    <p>Lulusan</p>
                </a>
            </li>
            <li class="{{ request()->is('profesis*') ? 'active' : '' }}">
                <a href="{{ url('profesis') }}">
                    <i class="nc-icon nc-planet"></i>
                    <p>Profesi</p>
                </a>
            </li>
            <li class="{{ request()->is('laporans*') ? 'active' : '' }}">
                <a href="{{ url('laporans') }}">
                    <i class="nc-icon nc-paper"></i>
                    <p>Laporan</p>
                </a>
            </li>
            {{-- <li>
                <a href="./user.html">
                    <i class="nc-icon nc-single-02"></i>
                    <p>User Profile</p>
                </a>
            </li> --}}
            {{-- <li>
                <a href="./tables.html">
                    <i class="nc-icon nc-tile-56"></i>
                    <p>Table List</p>
                </a>
            </li>
            <li>
                <a href="./typography.html">
                    <i class="nc-icon nc-caps-small"></i>
                    <p>Typography</p>
                </a>
            </li> --}}
            {{-- <li class="active-pro">
                <a href="./upgrade.html">
                    <i class="nc-icon nc-spaceship"></i>
                    <p>Upgrade to PRO</p>
                </a>
            </li> --}}
        </ul>
    </div>
</div>
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
