@extends('backend/item/layout')
@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Kuisioner</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Pengisian Kuisioner</li>
                    </ol>
                </nav>
            </div>
        </div>

        <h6 class="mb-0 text-uppercase">{{ session('nama') }}</h6>
        <hr/>

        <div class="card">
            <div class="card-body">
                @if ($sudah_mengisi)
                    <div class="alert alert-success">
                        <strong>Terima kasih!</strong> Belum ada kuisioner terbaru saat ini..
                    </div>
                @else
                    <form action="{{ url('alumni/jawaban') }}" method="POST">
                        @csrf
                        <input type="hidden" name="alumni_id" value="{{ $alumni->id }}">
                        <input type="hidden" name="jadwal_id" value="{{ $jadwal->id }}">
                        <table class="table table-striped" width="100%">
                            <tr>
                                <th width="20%">NAMA</th>
                                <td>: {{ $alumni->nama_alumni }}</td>
                            </tr>
                            <tr>
                                <th>NISN</th>
                                <td>: {{ $alumni->nisn }}</td>
                            </tr>
                            <tr>
                                <th>ANGKATAN</th>
                                <td>: {{ $alumni->angkatan }}</td>
                            </tr>
                            <tr>
                                <th>KELAS</th>
                                <td>: {{ $alumni->kelas }}</td>
                            </tr>
                        </table>
                        <br>
                        <table width="100%">
                            @foreach ($pertanyaan as $key => $p)
                                <tr style="background-color: #F2F2F2;">
                                    <th width="5%"><center>{{ $key + 1 }}.</center></th>
                                    <th>{{ strtoupper($p->pertanyaan) }}</th>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        @if (isset($pilihan[$p->id_pertanyaan]))
                                            @foreach ($pilihan[$p->id_pertanyaan] as $k)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        name="pilihan_ganda_id[{{ $p->id_pertanyaan }}]"
                                                        id="pg{{ $p->id_pertanyaan }}{{ $k['id_pg'] }}"
                                                        value="{{ $k['id_pg'] }}" required>
                                                    <label class="form-check-label" for="pg{{ $p->id_pertanyaan }}{{ $k['id_pg'] }}">
                                                        {{ $k['label'] }}. {{ $k['ket'] }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        @else
                                            <input type="text" class="form-control mt-2 mb-3"
                                                name="jawaban_text[{{ $p->id_pertanyaan }}]"
                                                placeholder="Jawaban Anda..." required>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary ms-2">Kirim</button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>


@endsection
