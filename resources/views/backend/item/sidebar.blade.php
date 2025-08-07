<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="{{ asset('assets/logo_only.png') }}" style="width:40px" class="logo-icon" alt="logo icon">
        </div>
        <div>
            <h6 class="logo-text">AL-ITTIHAD</h6>
        </div>
        <div class="toggle-icon ms-auto"><i class='bx bx-arrow-back'></i>
        </div>
     </div>
    @if(session('hak_akses_id')==1)
        @include('backend.admin.sidebar')
    @elseif(session('hak_akses_id')==2)
        @include('backend.user.sidebar')
    @elseif(session('hak_akses_id')==3)
        @include('backend.alumni.sidebar')
    @endif
</div>
