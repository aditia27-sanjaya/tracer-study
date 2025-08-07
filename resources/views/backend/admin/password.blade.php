@extends('backend/item/layout')
@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Pengaturan</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Password</li>
                    </ol>
                </nav>
            </div>
        </div>

        <h6 class="mb-0 text-uppercase">Ganti Password</h6>
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
                <form action="{{url('pimpinan/passUpdate')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-label">Password Lama</label>
                                <input name="password" class="form-control mb-3" type="password" placeholder="Ketik..." required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Password Baru</label>
                                <input name="password_new" class="form-control mb-3" type="password" placeholder="Ketik..." required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Ketik Ulang Password Baru</label>
                                <input name="password_new2" class="form-control mb-3" type="password" placeholder="Ketik..." required>
                            </div>
                        </div>

                    </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
