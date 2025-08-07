@extends('backend/item/layout')
@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Master</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Profil</li>
                    </ol>
                </nav>
            </div>
        </div>

        <h6 class="mb-0 text-uppercase">Profil Alumni</h6>
        <hr/>
            @if (Session::get('success'))
            <div class="alert alert-success" role="alert">
                <a data-bs-dismiss="alert"><span aria-bs-hidden="true">&times;</span><span class="sr-only"></span></a>
                <strong>Selamat!</strong> {{ Session::get('success') }}
            </div>
            @endif
            @if (Session::get('error'))
            <div class="alert alert-danger" role="alert">
                <a data-bs-dismiss="alert"><span aria-bs-hidden="true">&times;</span><span class="sr-only"></span></a>
                <strong>Maaf!</strong> {{ Session::get('error') }}
            </div>
            @endif
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="card card-form">
                <form action="{{ url('alumni/profilUpdate') }}" method="POST" enctype="multipart/form-data">
                <div class="row no-gutters">
                    <div class="col-lg-3 card-body">
                        <h4>Profil Alumni</h4>
                    <hr>
                        <div class="form-group text-center">
                            <label>Foto Alumni:</label><br>
                            @php
                                $foto = $data->foto ? asset('assets/backend/images/alumni/' . $data->foto) : asset('assets/backend/images/alumni/user.png');
                            @endphp
                            <img src="{{ $foto }}" class="mb-3" style="height: 150px; width: 150px; object-fit:contain" />
                            {{-- <img src="{{ asset('assets/backend/images/alumni/'. $data->foto) }}" class="mb-3" style="height: 150px; width: 150px; object-fit:contain" /> --}}
                            <input type="file" name="foto" class="form-control" placeholder="">
                            <input type="hidden" name="foto2" class="form-control" value="{{ $data->foto }}">
                            <br><br>
                            <div class="form-group">
                                <label>Ganti password:</label>
                                <input type="text" name="password" class="form-control" placeholder="Isi jika ingin mengganti Password baru!" autocomplete="off" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Password harus berupa kombinasi dari (Huruf Besar, Huruf Kecil dan angka) minimal memiliki panjang 8 karakter atau lebih!">
                                <input type="hidden" name="password2" class="form-control" value="{{ $data->password }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9 card-form__body card-body">
                            @csrf
                            <input type="hidden" name="id" class="form-control" value="{{ $data->id }}">
                            <div class="row">
                                <div class="col-lg-6">
                                    <h4>Data Alumni</h4>
                                    <hr>
                                    <div class="form-group mb-3">
                                        <label>EMAIL PRIBADI :</label>
                                        <input type="text" name="email" class="form-control" value="{{ $data->email }}" readonly>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>NAMA :</label>
                                        <input type="text" name="nama_alumni" class="form-control" value="{{ $data->nama_alumni }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>ANGKATAN :</label>
                                        <input type="text" name="angkatan" class="form-control" value="{{ $data->angkatan}}" placeholder="Contoh : 2021">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>KELAS :</label>
                                        <input type="text" name="kelas" class="form-control" value="{{ $data->kelas}}" placeholder="IPA/IPS">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>NISN :</label>
                                        <input type="text" name="nisn" class="form-control" value="{{ $data->nisn ?? '-'}}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <h4>Data Personal</h4>
                                    <hr>
                                    <div class="form-group mb-3">
                                        <label>ALAMAT :</label>
                                        <input type="text" name="alamat" class="form-control" value="{{ $data->alamat ?? '-'}}">
                                        {{-- <textarea name="alamat_perusahaan" class="form-control">#</textarea> --}}
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>NO HANDPHONE:</label>
                                        <input type="text" name="no_hp" class="form-control" value="{{ $data->no_hp ?? '-'}}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>JENIS KELAMIN</label>
                                        <select name="jenis_kl" class="form-select" required>
                                            <option value="">Pilih</option>
                                            <option value="Laki-laki" {{ $data->jenis_kl == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="Perempuan" {{ $data->jenis_kl == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>TGL LAHIR:</label>
                                        <input type="date" name="tgl_lahir" class="form-control" value="{{ $data->tgl_lahir }}">
                                    </div>
                                    {{-- <div class="form-group mb-3">
                                        <label>Lainnya :</label>
                                        <input type="text" name="-" class="form-control" value="#">
                                    </div> --}}
                                    <div class="form-group mb-3">
                                        <label>Facebook :</label>
                                        <input type="text" name="facebook" class="form-control" value="{{ $data->facebook }}" placeholder="Masukkan Link URL">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Instagram :</label>
                                        <input type="text" name="instagram" class="form-control" value="{{ $data->instagram }}" placeholder="Masukkan Link URL">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Linkedin :</label>
                                        <input type="text" name="linkedin" class="form-control" value="{{ $data->linkedin }}" placeholder="Masukkan Link URL">
                                    </div>

                                    <button type="submit" class="btn btn-primary mt-3">Update</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
    </div>
</div>

@endsection
