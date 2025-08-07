<ul class="metismenu" id="menu">
    <li>
        <a href="{{ url('pimpinan/dashboard') }}" class="active">
            <div class="parent-icon"><i class='bx bx-tachometer'></i>
            </div>
            <div class="menu-title">Dashboard</div>
        </a>
    </li>
    <li class="menu-label">Master</li>
    <li>
        <a href="{{ url('pimpinan/set-jadwal') }}">
            <div class="parent-icon"><i class='bx bx-calendar'></i>
            </div>
            <div class="menu-title">Jadwal</div>
        </a>
    </li>
    <li>
        <a href="{{ url('pimpinan/kuisioner') }}">
            <div class="parent-icon"><i class='bx bx-calendar-check'></i>
            </div>
            <div class="menu-title">Kuisioner</div>
        </a>
    </li>
    <li class="menu-label">Pengguna</li>
    <li>
        <a href="{{ url('pimpinan/user') }}">
            <div class="parent-icon"><i class='bx bx-user-circle'></i>
            </div>
            <div class="menu-title">User Admin</div>
        </a>
    </li>
    <li>
        <a href="{{ url('pimpinan/alumni') }}">
            <div class="parent-icon"><i class='bx bx-user-circle'></i>
            </div>
            <div class="menu-title">Alumni</div>
        </a>
    </li>

    <li class="menu-label">Pengaturan</li>
    <li>
        <a href="{{ url('pimpinan/ganti-password') }}">
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
