<nav class="main-sidebar ps-menu">
    <div class="sidebar-header">
        <div class="text">E-LEARNING</div>
        <div class="close-sidebar action-toggle">
            <i class="ti-close"></i>
        </div>
    </div>
    <div class="sidebar-content">
        <ul>
            <li class="{{ Request::segment(1) == 'dashboard' ? 'active open' : '' }}">
                <a href="{{ route('dashboard') }}" class="link">
                    <i class="ti-home"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="menu-category">
                <span class="text-uppercase">User Interface</span>
            </li>

            @if (
                (Auth::check() && Auth::user()->can('view pegawai')) ||
                    Auth::user()->can('view tahun-ajaran') ||
                    Auth::user()->can('view kelas') ||
                    Auth::user()->can('view siswa'))
                <li class="{{ Request::segment(1) == 'master' ? 'active open' : '' }}">
                    <a href="#" class="main-menu has-dropdown">
                        <i class="ti-desktop"></i>
                        <span>Master</span>
                    </a>
                    <ul class="sub-menu ">
                        @can('view pegawai')
                            <li class="{{ Request::segment(2) == 'pegawai' ? 'active open' : '' }}">
                                <a href="{{ route('pegawai.index') }}" class="link"><span>Pegawai</span></a>
                            </li>
                        @endcan
                        @can('view tahun-ajaran')
                            <li class="{{ Request::segment(2) == 'tahun-ajaran' ? 'active open' : '' }}">
                                <a href="{{ route('tahun-ajaran.index') }}" class="link"><span>Tahun Ajaran</span></a>
                            </li>
                        @endcan
                        @can('view kelas')
                            <li class="{{ Request::segment(2) == 'kelas' ? 'active open' : '' }}">
                                <a href="{{ route('kelas.index') }}" class="link"><span>Kelas</span></a>
                            </li>
                        @endcan
                        @can('view siswa')
                            <li class="{{ Request::segment(2) == 'siswa' ? 'active open' : '' }}">
                                <a href="{{ route('siswa.index') }}" class="link"><span>Siswa</span></a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endif

            @can('view mata-pelajaran')
                <li
                    class="{{ Request::segment(1) == 'mata-pelajaran' || Request::segment(1) == 'materi-pelajaran' || Request::segment(1) == 'mata-pelajaran-siswa' ? 'active open' : '' }}">
                    <a href="{{ route('mata-pelajaran.index') }}" class="link">
                        <i class="ti-book"></i>
                        <span>Mata Pelajaran</span>
                    </a>
                </li>
            @endcan

            @can('view tugas')
                <li class="{{ Request::segment(1) == 'tugas' ? 'active open' : '' }}">
                    <a href="{{ route('tugas.index') }}" class="link">
                        <i class="ti-write"></i>
                        <span>Data Tugas</span>
                    </a>
                </li>
            @endcan

            @can('view pengumpulan-tugas')
                <li class="{{ Request::segment(1) == 'pengumpulan-tugas' ? 'active open' : '' }}">
                    <a href="{{ route('pengumpulan-tugas.index') }}" class="link">
                        <i class="ti-layers"></i>
                        <span>Tugas</span>
                    </a>
                </li>
            @endcan

            @can('view rekap-nilai')
            <li class="{{ Request::segment(1) == 'rekap-nilai' ? 'active open' : '' }}">
                <a href="{{ route('rekap-nilai.index') }}" class="link">
                    <i class="ti-ruler-alt-2"></i>
                    <span>Rekap Nilai</span>
                </a>
            </li>
            @endcan

            @can('view rekap-nilai-siswa')
            <li class="{{ Request::segment(1) == 'rekap-nilai-siswa' ? 'active open' : '' }}">
                <a href="{{ route('rekap-nilai-siswa.index') }}" class="link">
                    <i class="ti-ruler-alt-2"></i>
                    <span>Rekap Nilai</span>
                </a>
            </li>
            @endcan
        </ul>
    </div>
</nav>
