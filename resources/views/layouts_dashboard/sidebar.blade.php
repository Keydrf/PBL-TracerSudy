<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/dashboard') }}">
                <i class="mdi mdi-grid-large menu-icon"></i>
                <span class="menu-title">@lang('sidebar.dashboard')</span>
            </a>
        </li>
        @if (Auth::user() && Auth::user()->level_id === 1)
            {{-- Asumsi 1 adalah level_id untuk SUPADM --}}
            {{-- <li class="nav-item {{ request()->is('level') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/level') }}">
                    <i class="menu-icon mdi mdi-layers-outline"></i>
                    <span class="menu-title">@lang('sidebar.level')</span>
                </a>
            </li> --}}
            <li class="nav-item {{ request()->is('user') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/user') }}">
                    <i class="menu-icon mdi mdi-account-circle-outline"></i>
                    <span class="menu-title">@lang('sidebar.user')</span>
                </a>
            </li>
        @endif
        <li class="nav-item {{ request()->is('alumni') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/alumni') }}">
                <i class="mdi mdi-account-multiple menu-icon"></i>
                <span class="menu-title">@lang('sidebar.alumni')</span>
            </a>
        </li>
        {{-- <li class="nav-item {{ request()->is('perusahaan') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/perusahaan') }}">
                <i class="mdi mdi-office-building menu-icon"></i> <span class="menu-title">@lang('sidebar.company')</span>
            </a>
        </li> --}}
        <li class="nav-item {{ request()->is('kategori') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/kategori') }}">
                <i class="mdi mdi-format-list-bulleted menu-icon"></i>
                <span class="menu-title">@lang('sidebar.profession_category')</span>
            </a>
        </li>
        <li class="nav-item {{ request()->is('profesi') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/profesi') }}">
                <i class="mdi mdi-account-tie menu-icon"></i>
                <span class="menu-title">@lang('sidebar.profession')</span>
            </a>
        </li>
        <li class="nav-item {{ request()->is('laporan') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/laporan') }}">
                <i class="mdi mdi-file-document menu-icon"></i>
                <span class="menu-title">@lang('sidebar.report')</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#" id="logout-link">
                <i class="mdi mdi-logout menu-icon"></i>
                <span class="menu-title">@lang('sidebar.signout')</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
    </ul>
</nav>
<style>
    .swal-actions-spacing button {
        margin: 0 5px;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Konfirmasi logout
        document.getElementById('logout-link').addEventListener('click', function(e) {
            e.preventDefault();

            Swal.fire({
                title: '{!! __('confirmation.judul') !!}',
                text: '{!! __('confirmation.deskripsi') !!}',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: '{!! __('confirmation.tombol.keluar') !!}',
                cancelButtonText: '{!! __('confirmation.tombol.batal') !!}',
                customClass: {
                    popup: 'swal-popup-theme',
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-light',
                    actions: 'swal-actions-spacing',
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        });

        // Kode untuk active state sidebar
        const currentPath = window.location.pathname;
        const sidebarLinks = document.querySelectorAll('.sidebar-wrapper ul.nav li a');

        sidebarLinks.forEach(link => {
            // Skip logout link from active state
            if (link.querySelector('.mdi-logout')) return;

            const linkPath = new URL(link.href, window.location.origin).pathname;
            if (currentPath === linkPath || currentPath.startsWith(linkPath + '/')) {
                link.parentNode.classList.add('active');
            }
        });
    });
</script>