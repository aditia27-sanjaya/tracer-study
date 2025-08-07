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
                        <li class="breadcrumb-item active" aria-current="page">Jadwal</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <div class="btn-group">
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#add"><i class="bx bx-folder-open"></i> Jadwal Baru</button>
                </div>
            </div>
        </div>

        <h6 class="mb-0 text-uppercase">JADWAL SETTING</h6>
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
                                <th width="20%">Tanggal Buka</th>
                                <th width="20%">Tanggal Tutup</th>
                                <th width="20%">Periode</th>
                                <th width="20%">Status</th>
                                <th width="15%">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 0;
                            @endphp
                            @foreach ($jadwal as $j)
                                <tr>
                                    <td><center>{{ ++$no }}</center></td>
                                    <td>{{ date('d-m-Y', strtotime($j->tgl_buka)) }}</td>
                                    <td>{{ date('d-m-Y', strtotime($j->tgl_tutup)) }}</td>
                                    <td>{{ $j->periode }}</td>
                                    <td>
                                        <center>
                                            <span class="badge {{ $j->status == 1 ? 'bg-success' : 'bg-danger' }} fs-7 py-2 px-3">
                                                {{ $j->status == 1 ? 'Aktif' : 'Tidak Aktif' }}
                                            </span>
                                        </center>
                                    </td>
                                    <td>
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#edit{{$j->id}}"><i class="bx bx-edit"></i></button>
                                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete{{$j->id}}"><i class="bx bx-trash"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@foreach ( $jadwal as $j )
<div class="modal fade" id="edit{{$j->id}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Jadwal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{url('user/editJadwal')}}" method="POST">
                @csrf
                <div class="modal-body">
                    <label class="form-label">Tanggal Buka</label>
                    <input name="id" class="form-control mb-3" type="hidden" value="{{ $j->id }}">
                    <input name="tgl_buka" class="form-control mb-3" type="date" value="{{ $j->tgl_buka }}">
                    <label class="form-label">Tanggal Tutup</label>
                    <input name="tgl_tutup" class="form-control mb-3" type="date" value="{{ $j->tgl_tutup }}">
                    <label class="form-label">Periode</label>
                    <input name="periode" class="form-control mb-3" type="number" value="{{ $j->periode }}">
                    <select name="status" class="form-select mb-3" required>
                        <option value="">Pilih Status</option>
                        <option value="1" {{ $j->status == 1 ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ $j->status == 0 ? 'selected' : '' }}>Nonaktif</option>
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
@endforeach

@foreach ( $jadwal as $j )
<div class="modal fade" id="delete{{$j->id}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hapus Jadwal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{url('user/deleteJadwal')}}" method="POST">
                @csrf
                <div class="modal-body">
                    <input name="id" class="form-control mb-3" type="hidden" value="{{$j->id}}" required>
                    <p>Anda yakin ingin menghapus Jadwal ini?</p>
                    Buka : <b>{{ $j->tgl_buka }}</b> - Tutup : <b>{{ $j->tgl_tutup }}</b>
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

<div class="modal fade" id="add" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{url('user/addJadwal')}}" method="POST">
                @csrf
                <div class="modal-body">
                    <label class="form-label">Tanggal Buka</label>
                    <input name="tgl_buka" class="form-control mb-3" type="date" required>
                    <label class="form-label">Tanggal Tutup</label>
                    <input name="tgl_tutup" class="form-control mb-3" type="date" required>
                    <label class="form-label">Periode</label>
                    <input name="periode" class="form-control mb-3" type="number" required>

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
@endsection
