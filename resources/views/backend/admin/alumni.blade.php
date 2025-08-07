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
                        <li class="breadcrumb-item active" aria-current="page">Alumni</li>
                    </ol>
                </nav>
            </div>
        </div>

        <h6 class="mb-0 text-uppercase">Alumni</h6>
        <hr/>
        <div class="card radius-10">
            <div class="card-body">
                <div class="table-responsive">
                <table id="example" class="table table-bordered table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                    <th><center>NO</center></th>
                    <th class="bg-success text-white"><center>NAMA</center></th>
                    <th class="bg-danger text-white"><center>NISN</center></th>
                    <th class="bg-primary text-white"><center>KELAS</center></th>
                    <th class="bg-warning text-white"><center>ANGKATAN</center></th>
                    <th class="bg-info text-white"><center>ALAMAT</center></th>
                    <th class="bg-success text-white"><center>STATUS</center></th>
                    <th class="bg-primary text-white"><center>AKSI</center></th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($alumni as $d)
                    <tr>
                        <td><center>{{ $no++ }}</center></td>
                        <td><center>{{ $d->nama_alumni ?? '-'}}</center></td>
                        <td><center>{{ $d->nisn ?? '-'}}</center></td>
                        <td><center>{{ $d->kelas ?? '-'}}</center></td>
                        <td><center>{{ $d->angkatan ?? '-'}}</center></td>
                        <td><center>{{ $d->alamat ?? '-'}}</center></td>
                        <td><center>{{ $d->status ?? '-'}}</center></td>
                        <td>
                            <center>
                            <button class="btn bg-success text-white shadow-sm btn-sm" data-bs-toggle="modal" data-bs-target="#detail{{ $d->id }}"><i class="bx bx-list-ul text-white"></i></button>
                            </center>
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

@foreach ($alumni as $d)
    <div class="modal fade" id="detail{{ $d->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Alumni</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table width="100%" class="table table-striped">
                    <tr>
                        <td colspan="3" class="text-center">
                            @php
                                $foto = $d->foto ? asset('assets/backend/images/alumni/' . $d->foto) : asset('assets/backend/images/alumni/user.png');
                            @endphp
                            <img src="{{ $foto }}" class="rounded-circle" style="box-shadow: 0 4px 10px rgba(0,0,0,0.3);" height="120" width="120">
                        </td>
                    </tr>
                    <br>
                    </hr>
                    <tr>
                        <th width="20%">NAMA</th>
                        <td>: {{$d->nama_alumni}}</td>
                    </tr>
                    <tr>
                        <th>NISN</th>
                        <td>: {{$d->nisn}}</td>
                    </tr>
                    <tr>
                        <th>ANGKATAN</th>
                        <td>: {{$d->angkatan}}</td>
                    </tr>
                    <tr>
                        <th>KELAS</th>
                        <td>: {{$d->kelas}}</td>
                    </tr>
                    <tr>
                        <th>TANGGAL LAHIR</th>
                        <td>: {{$d->tgl_lahir}}</td>
                    </tr>
                    <tr>
                        <th>JENIS KELAMIN</th>
                        <td>: {{$d->jenis_kl}}</td>
                    </tr>
                    <tr>
                        <th>NO HP</th>
                        <td>: {{$d->no_hp}}</td>
                    </tr>
                    <tr>
                        <th>ALAMAT</th>
                        <td>: {{$d->alamat}}</td>
                    </tr>
                    <br>
                </table>
                <br>
                <table width="100%">
                    @php
                        $jawabanAlumni = $jawaban[$d->id] ?? collect();
                        $jawabanMap = $jawabanAlumni->keyBy('pertanyaan_id');
                    @endphp

                    @if($jawabanAlumni->isEmpty())
                        <div class="alert alert-info">Belum mengisi kuisioner.</div>
                    @else
                        <table width="100%">
                            @foreach ($pertanyaan as $key => $p)
                                <tr style="background-color: #F2F2F2;">
                                    <th width="5%"><center>{{ $key + 1 }}</center></th>
                                    <th>{{ strtoupper($p->pertanyaan) }}</th>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        @php
                                            $jawabanItem = $jawabanMap[$p->id_pertanyaan] ?? null;
                                        @endphp

                                        @if (isset($pilihan[$p->id_pertanyaan]))
                                            @foreach ($pilihan[$p->id_pertanyaan] as $k)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        disabled
                                                        name="readonly_pg[{{ $d->id }}][{{ $p->id_pertanyaan }}]"
                                                        id="readonly_pg{{ $d->id }}{{ $p->id_pertanyaan }}{{ $k->id_pg }}"
                                                        value="{{ $k->id_pg }}"
                                                        @if ($jawabanItem && $jawabanItem->pilihan_ganda_id == $k->id_pg) checked @endif>
                                                    <label class="form-check-label" for="readonly_pg{{ $d->id }}{{ $p->id_pertanyaan }}{{ $k->id_pg }}">
                                                        {{ $k->label }}. {{ $k->ket }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        @else
                                            <input type="text" class="form-control mt-2 mb-3"
                                                value="{{ $jawabanItem->jawaban ?? '-' }}"
                                                readonly>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    @endif
                </table>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection
