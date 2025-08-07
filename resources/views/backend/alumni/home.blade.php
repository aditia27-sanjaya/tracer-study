@extends('backend/item/layout')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
@section('content')
{{-- <style>
@keyframes blink {
  0% { opacity: 1; }
  50% { opacity: 0; }
  100% { opacity: 1; }
}

.blink {
  animation: blink 2s infinite;
}
</style> --}}
<div class="page-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-xxl-12 mb-6 order-0">
                <div class="card" style="background: linear-gradient(to right, #3a539b, #66bfff);">
                    <div class="d-flex align-items-start row">
                    <div class="col-sm-7">
                        <div class="card-body">
                            <h5 class="card-title text-white mb-4">Welcome Back {{ session('nama') }}! 🎉</h5>
                            <p class="mb-6 text-white"><b>TRACER STUDY SMAIT AL-ITTIHAD</b><br />Silahkan lengkapi profil terlebih dahulu sebelum melakukan pengisian Kuisioner.</p>
                            <a href="{{ url('alumni/profil') }}" class="btn btn-sm btn-danger text-white">Profil Alumni</a>
                        </div>
                    </div>
                    <div class="col-sm-5 text-center text-sm-right">
                        <div class="card-body pb-0 px-0 px-md-6">
                        <img src="{{ asset('assets/man.png') }}" height="175" alt="View Badge User" />
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        @if($data['ada_jadwal'])
            @if($data['sudah_mengisi'])
                <div class="alert alert-success d-flex justify-content-between align-items-center" role="alert" style="background-color: #d1e7dd;">
                    <div>
                        <strong>Terima kasih!</strong> Anda sudah mengisi kuisioner. Belum ada jadwal baru saat ini..
                    </div>
                    <a data-bs-dismiss="alert" class="text-dark" style="text-decoration: none; cursor: pointer;">
                        <span aria-bs-hidden="true">&times;</span>
                    </a>
                </div>
            @else
                <div class="alert alert-warning d-flex justify-content-between align-items-center" role="alert" style="background-color: #fff3cd;">
                    <div>
                        <strong>Perhatian!</strong> Anda belum mengisi kuisioner..
                        <a href="{{ url('alumni/kuisioner') }}" class="btn btn-sm btn-warning ms-2">Isi Kuisioner</a>
                    </div>
                    <a data-bs-dismiss="alert" class="text-dark" style="text-decoration: none; cursor: pointer;">
                        <span aria-bs-hidden="true">&times;</span>
                    </a>
                </div>
            @endif
        @else
            <div class="alert alert-warning d-flex justify-content-between align-items-center" role="alert" style="background-color: #fff3cd;">
                <div>
                    <strong>Jadwal</strong> belum dibuka..
                </div>
                <a data-bs-dismiss="alert" class="text-dark" style="text-decoration: none; cursor: pointer;">
                    <span aria-bs-hidden="true">&times;</span>
                </a>
            </div>
        @endif
        <div class="row d-flex align-items-stretch">
            <div class="col-xxl-3 mb-3 order-0">
                <div class="card h-100 p-4 text-center" style="background: linear-gradient(to bottom, #66bfff, #3a539b);">
                    <div class="mb-3 mt-5">
                        @php
                            $foto = $alumni->foto ? asset('assets/backend/images/alumni/' . $alumni->foto) : asset('assets/backend/images/alumni/user.png');
                        @endphp
                        <img src="{{ $foto }}" class="rounded-circle" style="box-shadow: 0 4px 10px rgba(0,0,0,0.3);" height="120" width="120">
                    </div>
                    <div class="d-flex justify-content-center gap-4 mt-5">
                        <div class="text-center">
                            <a href="{{ $alumni->facebook }}" target="_blank" class="text-decoration-none text-dark">
                                <div class=" text-white"><strong>Facebook</strong></div>
                                <img src="{{ asset('assets/backend/images/facebook.png') }}" height="35" width="35" class="mt-2">
                            </a>
                        </div>
                        <div class="text-center">
                            <a href="{{ $alumni->instagram }}" target="_blank" class="text-decoration-none text-dark">
                                <div class=" text-white"><strong>Instagram</strong></div>
                                <img src="{{ asset('assets/backend/images/instagram.png') }}" height="35" width="35" class="mt-2">
                            </a>
                        </div>
                        <div class="text-center">
                            <a href="{{ $alumni->linkedin }}" target="_blank" class="text-decoration-none text-dark">
                                <div class=" text-white"><strong>Linkedin</strong></div>
                                <img src="{{ asset('assets/backend/images/linkedin.png') }}" height="35" width="35" class="mt-2">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-9 mb-3 order-0">
                <div class="card h-100">
                    <div class="card-header">
                        <h4 class="mb-0">Data Profil</h4>
                    </div>
                    <div class="card-body py-1">
                        @if(
                            empty($alumni->nisn) || empty($alumni->angkatan) || empty($alumni->kelas) ||
                            empty($alumni->tgl_lahir) || empty($alumni->jenis_kl) ||
                            empty($alumni->no_hp) || empty($alumni->alamat)
                        )
                            <div class="text-center mt-5">
                                <h5 class="text-muted fw-bold">Lengkapi data profil terlebih dahulu sebelum mengisi kuisioner.</h5>
                            </div>
                        @else
                        <table class="table table-striped" width="100%">
                            <tr>
                                <th width="20%">NAMA</th>
                                <td>: {{ $alumni->nama_alumni }}</td>
                            </tr>
                            <tr>
                                <th>NISN</th>
                                <td>: {{ $alumni->nisn ?? '-'}}</td>
                            </tr>
                            <tr>
                                <th>ANGKATAN</th>
                                <td>: {{ $alumni->angkatan ?? '-'}}</td>
                            </tr>
                            <tr>
                                <th>KELAS</th>
                                <td>: {{ $alumni->kelas ?? '-'}}</td>
                            </tr>
                            <tr>
                                <th>TGL LAHIR</th>
                                <td>: {{ $alumni->tgl_lahir ?? '-'}}</td>
                            </tr>
                            <tr>
                                <th>JENIS KELAMIN</th>
                                <td>: {{ $alumni->jenis_kl ?? '-'}}</td>
                            </tr>
                            <tr>
                                <th>NO HP</th>
                                <td>: {{ $alumni->no_hp ?? '-'}}</td>
                            </tr>
                            <tr>
                                <th>ALAMAT</th>
                                <td>: {{ $alumni->alamat ?? '-'}}</td>
                            </tr>
                        </table>
                        @endif
                    </div>
                </div>
            </div>
            {{-- <div class="col-xxl-3 mb-6 order-0">
                <div class="card p-3 h-100">
                    <h5 class="card-title mb-2">
                        <img src="{{ asset('assets/cuaca.png') }}" height="100">
                    </h5>
                    <h3 class="mb-3 card-title text-primary" id="datetime">Memuat waktu...</h3>
                </div>
            </div> --}}
        </div>
    </div>
</div>
@endsection

<script>
    function updateDateTime() {
        const now = new Date();
        const options = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        };
        document.getElementById('datetime').textContent = now.toLocaleDateString('id-ID', options);
    }

    setInterval(updateDateTime, 1000); // Update setiap detik
    updateDateTime(); // Panggil pertama kali saat load
</script>
