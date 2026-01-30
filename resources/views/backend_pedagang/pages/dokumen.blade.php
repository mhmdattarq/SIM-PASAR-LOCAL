@extends('backend_pedagang.app')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Dokumen</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('backend_pedagang.pages.uploadpermohonan') }}"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Dokumen Anda</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table_permohonan" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Nama Pemohon</th>
                                    <th>Status</th>
                                    <th>Dokumen</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permohonans as $p)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ \Carbon\Carbon::parse($p->created_at)->format('d-m-Y') }}</td>
                                        <td>{{ $p->nama }}<br>
                                            <small>NIK : {{$p->nik}}</small>
                                        </td>
                                        <td>
                                            @if ($p->status == 'draft')
                                                <span class="badge bg-warning">Draft</span>
                                            @elseif ($p->status == 'lengkap')
                                                <span class="badge bg-success">Uploaded, Terkirim</span>
                                            @elseif ($p->status == 'disetujui')
                                                <span class="badge bg-success">Disetujui, Belum Terverifikasi</span>
                                            @elseif ($p->status == 'ditolak')
                                                <span class="badge bg-danger">Ditolak</span>
                                            @elseif ($p->status == 'selesai')
                                                <span class="badge bg-success">Selesai</span>
                                            @elseif ($p->status == 'verifikasi')
                                                <span class="badge bg-info">Menunggu Verifikasi</span>
                                            @else
                                                <span class="badge bg-secondary">Unknown</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($p->dokumen_path)
                                                <a href="{{ route('pedagang.dokumen.download', ['id' => $p->id, 'type' => 'permohonan']) }}"
                                                   class="btn btn-sm btn-primary">
                                                    Download <b>Permohonan</b>
                                                </a>
                                            @endif
                                            @if (in_array($p->status, ['disetujui', 'verifikasi', 'selesai']) && $p->dokumen_path_pernyataan)
                                                | <a href="{{ route('pedagang.dokumen.download', ['id' => $p->id, 'type' => 'pernyataan']) }}"
                                                     class="btn btn-sm btn-primary">
                                                    Download <b>Pernyataan</b>
                                                </a>
                                            @endif
                                            @if (in_array($p->status, ['disetujui', 'verifikasi', 'selesai', 'ditolak']) && $p->dokumen_path_pemberitahuan)
                                                | <a href="{{ route('pedagang.dokumen.download', ['id' => $p->id, 'type' => 'pemberitahuan']) }}"
                                                     class="btn btn-sm btn-primary">
                                                    Download <b>Pemberitahuan</b>
                                                </a>
                                            @endif
                                            @if (!$p->dokumen_path && !in_array($p->status, ['disetujui', 'verifikasi', 'selesai', 'ditolak']))
                                                -
                                            @endif
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
@endsection