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
                        <li class="breadcrumb-item active" aria-current="page">Kuisioner</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <div class="btn-group">
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambah_pertanyaan"><i class="bx bx-folder-open"></i> Pertanyaan Baru</button>
                </div>
            </div>
        </div>
        <h6 class="mb-0 text-uppercase">KUISIONER OBJEKTIF</h6>
        <hr/>
        <div class="card">
        <div class="card-body">
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
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered" style="width:100%;">
                    <thead>
                        <tr>
                            <th width="5%">NO</th>
                            <th width="25%">PERTANYAAN</th>
                            <th width="30%">OPSI JAWABAN</th>
                            <th width="20%">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse ($pertanyaan as $key => $p)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ strtoupper($p->pertanyaan) }}</td>
                            <td>
                            @if(isset($pilihan[$p->id_pertanyaan]))
                                <table width="100%">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($pilihan[$p->id_pertanyaan] as $key2 => $h)
                                        <tr>
                                            <td width="10%">
                                                <span>{{ $h['label'] }}.</span>
                                            </td>
                                            <td width="65%">
                                                <span>{{ $h['ket'] }}</span>
                                            </td>
                                            <td width="25%" style="border-right: none !important">
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#pilih{{ $h['id_pg'] }}"><i class="bx bx-edit text-warning"></i></a>
                                                <a href="{{ url('pimpinan/deletePilihan/'.$h['id_pg']) }}" onclick="return confirm('Anda yakin ingin menghapus data ini?')"><i class="bx bx-trash text-danger"></i></a>
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="pilih{{$h['id_pg']}}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Data</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{url('pimpinan/editPilihan')}}" method="POST">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <input name="id_pg" class="form-control mb-3" type="hidden" value="{{$h['id_pg']}}" required>
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <label class="form-label">Label</label>
                                                                    <input type="text" name="label" class="form-control mb-3" value="{{$h['label']}}" required>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label">Keterangan</label>
                                                                    <input type="text" name="ket" class="form-control mb-3" value="{{$h['ket']}}" required>
                                                                </div>
                                                            </div>
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
                                    </tbody>
                                </table>
                            @else
                                <span class="text-danger">Tidak Ada Opsi = Essay</span>
                            @endif
                            </td>
                            <td>
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#form{{ $p->id_pertanyaan }}"><i class="bx bx-list-ul"></i></button>
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#edit{{ $p->id_pertanyaan }}"><i class="bx bx-edit"></i></button>
                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete{{ $p->id_pertanyaan }}"><i class="bx bx-trash"></i></button>
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

<div class="modal fade" id="tambah_pertanyaan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Pertanyaan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{url('pimpinan/addKuisioner')}}" method="POST">
                @csrf
                <div class="modal-body">
                    <label class="form-label">Pertanyaan</label>
                    <input name="pertanyaan" class="form-control mb-3" type="text" placeholder="Ketik..." required
                    style="text-transform: uppercase;"
                    oninput="this.value = this.value.toUpperCase()">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Aksi Pilihan Ganda --}}
@foreach ($pertanyaan as $key=>$p)
<div class="modal fade" id="form{{$p->id_pertanyaan}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6>{{$p->pertanyaan}}</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('pimpinan/aksiPilihanGanda') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="pertanyaan_id" class="form-control mb-3" value="{{$p->id_pertanyaan}}" required>
                    <div class="row" id="dynamicAddRemove{{ $p->id_pertanyaan }}">
                        <div class="col-md-12" id="deleteForm{{ $p->id_pertanyaan }}">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">Label</label>
                                    <input type="text" name="label[]" class="form-control mb-3" placeholder="Contoh : A,B,C" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Keterangan</label>
                                    <input type="text" name="ket[]" class="form-control mb-3" placeholder="Keterangan" required>
                                </div>
                                <div class="col-md-2 pt-2">
                                    <button type="button" class="btn btn-danger mt-4 btn-sm remove-tr{{ $p->id_pertanyaan }}">Hapus</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" name="add" id="add-btn{{ $p->id_pertanyaan }}" class="btn btn-success btn-sm"><i class="bx bx-plus"></i></button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Edit Pertanyaan --}}
<div class="modal fade" id="edit{{$p->id_pertanyaan}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Pertanyaan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{url('pimpinan/editKuisioner')}}" method="POST">
                @csrf
                <div class="modal-body">
                    <input name="id_pertanyaan" class="form-control mb-3" type="hidden" value="{{$p->id_pertanyaan}}" required>
                    <label class="form-label">Pertanyaan</label>
                    <input name="pertanyaan" class="form-control mb-3" type="text" value="{{$p->pertanyaan}}" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Delete Pertanyaan --}}
<div class="modal fade" id="delete{{$p->id_pertanyaan}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hapus Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{url('pimpinan/deleteKuisioner')}}" method="POST">
                @csrf
                <div class="modal-body">
                    <input name="id_pertanyaan" class="form-control mb-3" type="hidden" value="{{$p->id_pertanyaan}}" required>
                    <p>Anda yakin ingin menghapus Pertanyaan ini?</p>
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

@push('js')
@foreach ($pertanyaan as $key=>$p)

<script type="text/javascript">
    var i = 0;
    $("#add-btn{{ $p->id_pertanyaan }}").click(function(){
    ++i;
    var html = '<div class="col-md-12" id="deleteForm{{ $p->id_pertanyaan }}">\
                    <div class="row">\
                        <div class="col-md-3">\
                            <label class="form-label">Label</label>\
                            <input type="text" name="label[]" class="form-control mb-3" placeholder="Contoh : A,B,C" required>\
                        </div>\
                        <div class="col-md-4">\
                            <label class="form-label">Keterangan</label>\
                            <input type="text" name="ket[]" class="form-control mb-3" placeholder="Keterangan" required>\
                        </div>\
                        <div class="col-md-2 pt-2">\
                            <button type="button" class="btn btn-danger mt-4 btn-sm remove-tr{{ $p->id_pertanyaan }}">Hapus</button>\
                        </div>\
                    </div>\
                </div>';
        $("#dynamicAddRemove{{ $p->id_pertanyaan }}").append(html);
    });

    $(document).on('click', '.remove-tr{{ $p->id_pertanyaan }}', function(){
        $('#deleteForm{{$p->id_pertanyaan}}').remove();
    });

</script>

@endforeach
@endpush
