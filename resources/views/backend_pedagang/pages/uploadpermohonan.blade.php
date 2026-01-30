@extends('backend_pedagang.app')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Permohonan</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('backend_pedagang.pages.uploadpermohonan') }}"><i
                                        class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Unggah Surat Permohonan</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->

            @foreach ($permohonans as $permohonan)
                @if ($permohonan->status == 'lengkap')
                    <div class="alert alert-info mb-3" style="font-size: 14px;">
                        <span style="animation: blink 1.5s infinite;">Surat Permohonan anda telah berhasil dikirim, Silahkan
                            menunggu persetujuan dari <b>Admin.</b></span>
                        <style>
                            @keyframes blink {
                                0% {
                                    opacity: 1;
                                }

                                50% {
                                    opacity: 0.3;
                                }

                                100% {
                                    opacity: 1;
                                }
                            }
                        </style>
                    </div>
                @elseif ($permohonan->status == 'disetujui')
                    <div class="alert alert-warning mb-3" style="font-size: 14px;">
                        <span style="animation: blink 1.5s infinite;">Surat permohonan Anda telah berhasil disetujui.
                            Silahkan unduh Surat pemberitahuan dan Surat
                            pernyataan menjadi pedagang,
                            <b>lalu tanda tangani Surat pernyataan</b> untuk menyelesaikan verifikasi.</span>
                        <style>
                            @keyframes blink {
                                0% {
                                    opacity: 1;
                                }

                                50% {
                                    opacity: 0.3;
                                }

                                100% {
                                    opacity: 1;
                                }
                            }
                        </style>
                    </div>
                @endif
            @endforeach

            <!-- Tombol upload -->
            @foreach ($permohonans as $permohonan)
                @if ($permohonan->status == 'disetujui')
                    <button type="button" class="btn btn-warning mb-3" data-bs-toggle="modal"
                        data-bs-target="#VerifikasiModal">
                        Unggah Surat Pernyataan
                    </button>
                @endif
            @endforeach

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
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permohonans as $p)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ \Carbon\Carbon::parse($p->updated_at)->format('d-m-Y') }}</td>
                                        <td>{{ $p->nama }}<br>
                                            <small>NIK : {{ $p->nik }}</small>
                                        </td>
                                        <td>
                                            @if ($p->status == 'lengkap')
                                                <span class="badge bg-success">Terkirim</span>
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
                                            @if ($p->status === 'lengkap')
                                                {{ $p->keterangan ?? '' }}
                                            @elseif($p->status === 'disetujui')
                                                {{ $p->keterangan ?? '' }}
                                            @elseif($p->status === 'ditolak')
                                                {{ $p->keterangan ?? '' }}
                                            @elseif($p->status === 'selesai')
                                                {{ $p->keterangan ?? '' }}
                                            @elseif($p->status === 'verifikasi')
                                                {{ $p->keterangan ?? '' }}
                                            @else
                                                {{ $p->keterangan ?? '-' }}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($p->status == 'disetujui' || $p->status == 'verifikasi')
                                                <a href="{{ route('pedagang.permohonan.download', $p->id) }}"
                                                    class="btn btn-sm btn-success">
                                                    Download Dokumen <b>Permohonan</b> Anda
                                                </a>
                                                |
                                                <a href="{{ route('pedagang.pemberitahuan.download') }}"
                                                    class="btn btn-sm btn-success">
                                                    Download Surat <b>Pemberitahuan</b>
                                                </a>
                                                |
                                                <a href="{{ route('pedagang.pernyataan.download') }}"
                                                    class="btn btn-sm btn-success">
                                                    Download Surat <b>Pernyataan</b>
                                                </a>
                                            @elseif ($p->status == 'lengkap')
                                                <a href="#" class="btn btn-sm btn-info" data-bs-toggle="modal"
                                                    data-bs-target="#viewDocumentModal" data-id="{{ $p->id }}">
                                                    Lihat Permohonan Anda
                                                </a>
                                            @elseif ($p->status == 'selesai')
                                                <a href="{{ route('pedagang.permohonan.download', $p->id) }}"
                                                    class="btn btn-sm btn-success">
                                                    Download Dokumen <b>Permohonan</b>
                                                </a>
                                                |
                                                <a href="{{ route('pedagang.pernyataan.download') }}"
                                                    class="btn btn-sm btn-success">
                                                    Download Surat <b>Pernyataan</b>
                                                </a>
                                                |
                                                <a href="{{ route('pedagang.pemberitahuan.download') }}"
                                                    class="btn btn-sm btn-success">
                                                    Download Surat <b>Pemberitahuan</b>
                                                </a>
                                            @elseif ($p->status == 'ditolak')
                                                <a href="{{ route('pedagang.permohonan.download', $p->id) }}"
                                                    class="btn btn-sm btn-danger">
                                                    Download Dokumen <b>Permohonan</b>
                                                </a>
                                                |
                                                <a href="{{ route('pedagang.pemberitahuan.download') }}"
                                                    class="btn btn-sm btn-danger">
                                                    Download Surat <b>Pemberitahuan</b>
                                                </a>
                                            @else
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

    <!-- Modal Verifikasi -->
    <div class="modal fade" id="VerifikasiModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('pedagang.uploadSigned') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Verifikasi Dokumen</h5>
                    </div>
                    <div class="alert alert-warning mb-3" style="font-size: 14px;">
                        <span style="animation: blink 1.5s infinite;">
                            Silahkan <b> tanda tangani Surat pernyataan menjadi pedagang</b> untuk menyelesaikan verifikasi.
                        </span>
                    </div>
                    <style>
                        @keyframes blink {
                            0% {
                                opacity: 1;
                            }

                            50% {
                                opacity: 0.3;
                            }

                            100% {
                                opacity: 1;
                            }
                        }
                    </style>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="permohonan_id" class="form-label">Pemohon</label>
                            <input type="text" class="form-control" value="{{ $p->nama }}" readonly>

                            {{-- hidden input supaya id tetap ikut ke controller --}}
                            <input type="hidden" name="permohonan_id" value="{{ $p->id }}">
                        </div>
                        <div class="mb-3">
                            <label for="signed_document" class="form-label">Upload Surat Pernyataan Menjadi Pedagang
                                (PDF)</label>
                            <input type="file" name="signed_document" id="signed_document" class="form-control"
                                accept="application/pdf" required>
                            @error('signed_document')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Upload</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Modal Verifikasi -->

    <!-- Modal Lihat Dokumen -->
    <div class="modal fade" id="viewDocumentModal" tabindex="-1" aria-labelledby="viewDocumentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewDocumentModalLabel">Lihat Permohonan Anda</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Adobe viewer -->
                    <div id="adobe-dc-view-document" style="height:600px;"></div>
                    <!-- Fallback iframe -->
                    <iframe id="fallback-pdf-document" src="" width="100%" height="600px"
                        style="border:none; display:none;"></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Kembali</button>
                    <a href="{{ route('pedagang.permohonan.download', $p->id) }}" class="btn btn-primary">Download</a>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal Lihat Dokumen -->

    <!-- Adobe SDK -->
    <!-- Adobe SDK -->
    <script src="https://documentcloud.adobe.com/view-sdk/main.js"></script>

    <script>
        document.addEventListener("adobe_dc_view_sdk.ready", function() {
            let adobeDCView = null;
            let lastFileUrl = null; // Simpan URL untuk fallback

            $('#viewDocumentModal').on('shown.bs.modal', function(event) {
                const button = $(event.relatedTarget);
                const permohonanId = button.data('id');

                const fallbackIframe = document.getElementById('fallback-pdf-document');
                const adobeContainer = document.getElementById('adobe-dc-view-document');

                // Reset tampilan
                adobeContainer.innerHTML = '';
                adobeContainer.style.display = 'none';
                fallbackIframe.style.display = 'none';
                fallbackIframe.src = '';

                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                fetch(`/get-document-url/${permohonanId}`, {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        }
                    })
                    .then(res => {
                        if (!res.ok) throw new Error('Gagal mengambil URL dokumen');
                        return res.json();
                    })
                    .then(data => {
                        if (data.error) throw new Error(data.error);

                        // Simpan URL untuk fallback
                        lastFileUrl = data.fileUrl + '?v=' + new Date().getTime();

                        // Deteksi localhost
                        const isLocalhost = location.hostname === "localhost" || location.hostname ===
                            "127.0.0.1";

                        if (isLocalhost) {
                            // Langsung pakai iframe fallback di localhost
                            console.log('Localhost terdeteksi → langsung pakai iframe');
                            fallbackIframe.src = lastFileUrl;
                            fallbackIframe.style.display = 'block';
                            return;
                        }

                        // Kalau bukan localhost, coba Adobe Embed dulu
                        return fetch(lastFileUrl, {
                                cache: "no-store"
                            })
                            .then(pdfRes => {
                                if (!pdfRes.ok) throw new Error('Gagal fetch PDF');
                                return pdfRes.arrayBuffer();
                            })
                            .then(arrayBuffer => {
                                adobeDCView = new AdobeDC.View({
                                    clientId: "ef7d978631e747dcb6b67accce3eb38b",
                                    divId: "adobe-dc-view-document"
                                });

                                return adobeDCView.previewFile({
                                    content: {
                                        promise: Promise.resolve(new Uint8Array(
                                            arrayBuffer))
                                    },
                                    metaData: {
                                        fileName: data.fileName || 'permohonan.pdf'
                                    }
                                }, {
                                    embedMode: "SIZED_CONTAINER",
                                    showDownloadPDF: false,
                                    showPrintPDF: false
                                });
                            })
                            .then(() => {
                                adobeContainer.style.display = 'block';
                                console.log('Adobe Embed berhasil');
                            });
                    })
                    .catch(err => {
                        console.warn('Adobe Embed gagal (normal di localhost):', err.message);

                        // Fallback ke iframe PASTI JALAN
                        if (lastFileUrl) {
                            fallbackIframe.src = lastFileUrl;
                            fallbackIframe.style.display = 'block';
                            adobeContainer.style.display = 'none';

                            // Ubah judul biar user tahu
                            $('#viewDocumentModalLabel').text('Lihat Permohonan Anda (Mode Sederhana)');
                        } else {
                            alert('Gagal memuat dokumen. Silakan refresh halaman.');
                        }
                    });
            });

            // Reset saat modal ditutup
            $('#viewDocumentModal').on('hidden.bs.modal', function() {
                document.getElementById('adobe-dc-view-document').innerHTML = '';
                adobeDCView = null;
                const fallbackIframe = document.getElementById('fallback-pdf-document');
                fallbackIframe.src = '';
                fallbackIframe.style.display = 'none';
                $('#viewDocumentModalLabel').text('Lihat Permohonan Anda');
            });
        });
    </script>
@endsection
