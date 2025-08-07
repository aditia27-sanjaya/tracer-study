<ul class="metismenu" id="menu">
    <li>
        <a href="{{ url('user/dashboard') }}" class="active">
            <div class="parent-icon"><i class='bx bx-tachometer'></i>
            </div>
            <div class="menu-title">Dashboard</div>
        </a>
    </li>
    <li class="menu-label">Master</li>
    <li>
        <a href="{{ url('user/set-jadwal') }}">
            <div class="parent-icon"><i class='bx bx-calendar'></i>
            </div>
            <div class="menu-title">Jadwal</div>
        </a>
    </li>
    <li>
        <a href="{{ url('user/kuisioner') }}">
            <div class="parent-icon"><i class='bx bx-list-check'></i>
            </div>
            <div class="menu-title">Kuisioner</div>
        </a>
    </li>
    <li class="menu-label">Pengguna</li>
    <li>
        <a href="{{ url('user/alumni') }}">
            <div class="parent-icon"><i class='bx bx-user-circle'></i>
            </div>
            <div class="menu-title">Alumni</div>
        </a>
    </li>
    <li class="menu-label">Pengaturan</li>
    <li>
        <a href="{{ url('user/ganti-password') }}">
            <div class="parent-icon"><i class='bx bx-lock'></i>
            </div>
            <div class="menu-title">Ganti Password</div>
        </a>
    </li>
    <li>
        <a href="{{ url('/') }}">
            <div class="parent-icon"><i class='bx bx-log-out'></i>
            </div>
            <div class="menu-title">Logout</div>
        </a>
    </li>

</ul>
