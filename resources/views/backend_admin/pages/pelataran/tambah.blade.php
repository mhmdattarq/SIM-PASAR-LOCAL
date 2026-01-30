@extends('backend_admin.app')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="row">
                <!--breadcrumb-->
                <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                    <div class="breadcrumb-title pe-3">Pelataran</div>
                    <div class="ps-3">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 p-0">
                                <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Penambahan Pelataran</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <!--end breadcrumb-->
                <div class="col-xl-9 mx-auto">
                    <div class="card border-top border-4 border-info">
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger mt-4">
                                    <strong>Terjadi kesalahan!</strong>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if (session('success'))
                                <div class="alert alert-success mt-4">
                                    {{ session('success') }}
                                </div>
                            @endif
                            <div class="border p-4 rounded">
                                <div class="card-title d-flex align-items-center">
                                    <div><i class="bx bxs-home me-1 font-22 text-info"></i>
                                    </div>
                                    <h5 class="mb-0 text-info">Tambah Pelataran</h5>
                                </div>
                                <hr />
                                <form action="{{ route('pelataran.store') }}" method="POST" class="user">
                                    @csrf
                                    <div class="row mb-3">
                                        <label for="nomor_pelataran" class="col-sm-3 col-form-label">Nomor Pelataran</label>
                                        <div class="col-sm-9">
                                            <input type="text"
                                                class="form-control @error('nomor_pelataran') is-invalid @enderror"
                                                id="nomor_pelataran" name="nomor_pelataran"
                                                placeholder="Masukkan Nomor Pelataran.."
                                                value="{{ old('nomor_pelataran') }}">
                                            @error('nomor_pelataran')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="ukuran_pelataran" class="col-sm-3 col-form-label">Ukuran
                                            Pelataran</label>
                                        <div class="col-sm-9">
                                            <input type="text"
                                                class="form-control @error('ukuran_pelataran') is-invalid @enderror"
                                                id="ukuran_pelataran" name="ukuran_pelataran"
                                                placeholder="Masukkan Ukuran Pelataran.."
                                                value="{{ old('ukuran_pelataran') }}">
                                            @error('ukuran_pelataran')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="harga_sewa" class="col-sm-3 col-form-label">Harga Sewa</label>
                                        <div class="col-sm-9">
                                            <input type="number"
                                                class="form-control @error('harga_sewa') is-invalid @enderror"
                                                id="harga_sewa" name="harga_sewa" placeholder="Masukkan Harga Sewa.."
                                                value="{{ old('harga_sewa') }}">
                                            @error('harga_sewa')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="satuan_retribusi" class="col-sm-3 col-form-label">Satuan
                                            Retribusi</label>
                                        <div class="col-sm-9">
                                            <select class="form-select @error('satuan_retribusi') is-invalid @enderror"
                                                id="satuan_retribusi" name="satuan_retribusi">
                                                <option value=""
                                                    {{ old('satuan_retribusi') == '' ? 'selected' : '' }}>Masukkan Satuan
                                                    Retribusi</option>
                                                <option value="hari"
                                                    {{ old('satuan_retribusi') == 'hari' ? 'selected' : '' }}>Hari</option>
                                                <option value="bulan"
                                                    {{ old('satuan_retribusi') == 'bulan' ? 'selected' : '' }}>Bulan
                                                </option>
                                                <option value="tahun"
                                                    {{ old('satuan_retribusi') == 'tahun' ? 'selected' : '' }}>Tahun
                                                </option>
                                            </select>
                                            @error('satuan_retribusi')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="kategori_pelataran" class="col-sm-3 col-form-label">Kategori
                                            Pelataran</label>
                                        <div class="col-sm-9">
                                            <select class="form-select @error('kategori_pelataran') is-invalid @enderror"
                                                id="kategori_pelataran" name="kategori_pelataran">
                                                <option value=""
                                                    {{ old('kategori_pelataran') == '' ? 'selected' : '' }}>Masukkan
                                                    Kategori</option>
                                                <option value="tetap"
                                                    {{ old('kategori_pelataran') == 'tetap' ? 'selected' : '' }}>
                                                    Tetap/bulan</option>
                                                <option value="tidaktetap"
                                                    {{ old('kategori_pelataran') == 'tidaktetap' ? 'selected' : '' }}>Tidak
                                                    tetap/harian</option>
                                                <option value="insidentil"
                                                    {{ old('kategori_pelataran') == 'insidentil' ? 'selected' : '' }}>
                                                    Insidentil/event</option>
                                            </select>
                                            @error('kategori_pelataran')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="lokasi_pelataran" class="col-sm-3 col-form-label">Lokasi
                                            Pelataran</label>
                                        <div class="col-sm-9">
                                            <input type="text"
                                                class="form-control @error('lokasi_pelataran') is-invalid @enderror"
                                                id="lokasi_pelataran" name="lokasi_pelataran"
                                                placeholder="Masukkan Lokasi Pelataran.."
                                                value="{{ old('lokasi_pelataran') }}">
                                            @error('lokasi_pelataran')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="pasar_id" class="col-sm-3 col-form-label">Pasar</label>
                                        <div class="col-sm-9">
                                            <select class="form-select @error('pasar_id') is-invalid @enderror"
                                                id="pasar_id" name="pasar_id">
                                                <option value="" {{ old('pasar_id') == '' ? 'selected' : '' }}>--
                                                    Masukkan Pasar --</option>
                                                @foreach ($pasars as $pasar)
                                                    <option value="{{ $pasar->id }}"
                                                        {{ old('pasar_id') == $pasar->id ? 'selected' : '' }}>
                                                        {{ $pasar->nama_pasar }}</option>
                                                @endforeach
                                            </select>
                                            @error('pasar_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-3 col-form-label"></label>
                                        <div class="col-sm-9">
                                            <button type="submit" class="btn btn-info px-5">Tambah Pelataran</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
