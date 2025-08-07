@extends('backend/item/layout')
@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Pengguna</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">User Admin</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <div class="btn-group">
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#add"><i class="bx bx-folder-open"></i> Data Baru</button>
                </div>
            </div>
        </div>

        <h6 class="mb-0 text-uppercase">{{$pengguna}}</h6>
        <hr/>
        <div class="card">
            <div class="card-body">
                @if (Session::get('success'))
                    <div class="alert alert-success" role="alert">
                        <a data-bs-dismiss="alert"><span aria-bs-hidden="true">&times;</span><span class="sr-only"></span></a>
                        <strong>Selamat!</strong> {{ Session::get('success') }}
                    </div>
                    @endif
                    @if (Session::get('warning'))
                    <div class="alert alert-warning" role="alert">
                        <a data-bs-dismiss="alert"><span aria-bs-hidden="true">&times;</span><span class="sr-only"></span></a>
                        <strong>Selamat!</strong> {{ Session::get('warning') }}
                    </div>
                    @endif
                    @if (Session::get('danger'))
                    <div class="alert alert-danger" role="alert">
                        <a data-bs-dismiss="alert"><span aria-bs-hidden="true">&times;</span><span class="sr-only"></span></a>
                        <strong>Selamat!</strong> {{ Session::get('danger') }}
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
                <div class="table-responsive">
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th width="5%">NO</th>
                                <th width="45%">Nama</th>
                                <th width="35%">Email</th>
                                <th width="15%">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $key=>$p)
                                <tr>
                                    <td><center>{{ ++$key }}</center></td>
                                    <td>{{ $p->name }}</td>
                                    <td><center>{{ $p->email }}</center></td>
                                    <td>
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#edit{{$p->id}}"><i class="bx bx-edit"></i></button>
                                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete{{$p->id}}"><i class="bx bx-trash"></i></button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">Data kosong!</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="add" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{url('pimpinan/tambahAdmin')}}" method="POST">
                @csrf
                <div class="modal-body">
                    <input name="hak_akses_id" class="form-control mb-3" type="hidden" value="{{$hak_akses_id}}" required>

                    <label class="form-label">Nama</label>
                    <input name="name" class="form-control mb-3" type="text" placeholder="Ketik..." required>

                    <label class="form-label">Email</label>
                    <input name="email" class="form-control mb-3" type="email" placeholder="Ketik..." required>

                    <label class="form-label">Password</label>
                    <input name="password" class="form-control mb-3" type="password" placeholder="Ketik..." required>

                    <label class="form-label">Ketik Ulang Password</label>
                    <input name="password2" class="form-control mb-3" type="password" placeholder="Ketik..." required>

                    <label for="exampleDataList" class="form-label">Status</label>
                    <select name="status" class="form-select mb-3" required>
                        <option value="">Pilih Status</option>
                        <option value="1">Aktif</option>
                        <option value="0">Nonaktif</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach ($data as $key => $p)
<div class="modal fade" id="edit{{$p->id}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('pimpinan/editAdmin') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input name="id" class="form-control mb-3" type="hidden" value="{{ $p->id }}" required>

                    <label class="form-label">Nama</label>
                    <input name="name" class="form-control mb-3" type="text" value="{{ $p->name }}" required>

                    <label class="form-label">Email</label>
                    <input name="email" class="form-control mb-3" type="email" value="{{ $p->email }}" readonly required>

                    <label class="form-label">Password</label>
                    <input name="password" class="form-control mb-3" type="password" placeholder="Masukkan password baru (jika ingin diubah)">

                    <label class="form-label">Ketik Ulang Password</label>
                    <input name="password_confirmation" class="form-control mb-3" type="password" placeholder="Ulangi password">

                    <label class="form-label">Status</label>
                    <select name="status" class="form-select mb-3" required>
                        <option value="">Pilih Status</option>
                        <option value="1" {{ $p->is_login == 1 ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ $p->is_login == 0 ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="delete{{$p->id}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hapus Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{url('pimpinan/deleteAdmin')}}" method="POST">
                @csrf
                <div class="modal-body">
                    <input name="id" class="form-control mb-3" type="hidden" value="{{$p->id}}" required>
                    <p>Anda yakin ingin menghapus data ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endsection
