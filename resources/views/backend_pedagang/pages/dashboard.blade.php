@extends('backend_pedagang.app')
@section('content')
    <div class="col">
        <!-- Modal -->
        <div class="modal fade" id="welcomeModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Selamat Datang!</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <p>Halo, <strong>{{ $displayName ?? Auth::user()->nik }}</strong></p>
                        <p>Selamat Anda berhasil login ke aplikasi <b>Sim-Pasar</b>!</p>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-success" data-bs-dismiss="modal">Lanjutkan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-wrapper">
        <div class="page-content">
            <div class="row row-cols-1 row-cols-lg-4">
                <div class="col">
                    <div class="card rounded-4 bg-gradient-secondary bubble position-relative overflow-hidden">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-0">
                                <div class="">
                                    <h4 class="mb-0 text-dark">{{ $totalPermohonan ?? 0 }}</h4>
                                    <p class="mb-0 text-dark">Total Permohonan</p>
                                </div>
                                <div class="fs-1 text-white">
                                    <i class="bx bx-cart"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card rounded-4 bg-gradient-burning bubble position-relative overflow-hidden">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-0">
                                <div class="">
                                    <h4 class="mb-0 text-dark">{{ $permohonanDitolak ?? 0 }}</h4>
                                    <p class="mb-0 text-dark">Permohonan Ditolak</p>
                                </div>
                                <div class="fs-1 text-white">
                                    <i class="bx bx-group"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card rounded-4 bg-gradient-success bubble position-relative overflow-hidden">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-0">
                                <div class="">
                                    <h4 class="mb-0 text-dark">{{ $permohonanSelesai ?? 0 }}</h4>
                                    <p class="mb-0 text-dark">Permohonan Disetujui Dan Selesai</p>
                                </div>
                                <div class="fs-1 text-white">
                                    <i class="bx bx-wallet"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card rounded-4 bg-gradient-cosmic bubble position-relative overflow-hidden">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-0">
                                <div class="">
                                    <h4 class="mb-0 text-dark">{{ $permohonanPending ?? 0 }}</h4>
                                    <p class="mb-0 text-dark">Permohonan Terkirim, Pending</p>
                                </div>
                                <div class="fs-1 text-white">
                                    <i class="bx bx-line-chart-down"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end row-->
            @if (!$permohonan)
                <!-- instruksi dashboard -->
                <div class="col">
                    <div class="card rounded-4 bg-gradient-danger">
                        <div class="card-body text-center">
                            <h3 class="text-dark">Belum Ada Permohonan Menjadi Pedagang!</h3>
                            <div class="widgets-icons-2 mx-auto my-4 bg-white rounded-circle text-dark">
                                <i class='bx bx-window-close'></i>
                            </div>
                            <p class="mb-0 text-dark">Anda belum memiliki surat permohonan, Klik tombol di bawah ini untuk
                                membuat surat permohonan menjadi pedagang baru.</p>
                            <a href="{{ route('backend_pedagang.pages.permohonan') }}"
                                class="btn btn-white px-4 rounded-5 mt-4"><i class='bx bx-highlight'></i>Buat
                                Permohonan</a>
                        </div>
                    </div>
                </div>
            @else
                {{-- Kalau status lengkap --}}
                @if ($permohonan->status == 'lengkap')
                    <div class="col">
                        <div class="card rounded-4 bg-gradient-success">
                            <div class="card-body text-center">
                                <h3 class="text-dark">Permohonan Sudah Berhasil Dikirim!</h3>
                                <div class="widgets-icons-2 mx-auto my-4 bg-white rounded-circle text-dark">
                                    <i class='bx bx-check-circle'></i>
                                </div>
                                <p class="mb-0 text-dark">Surat permohonan Anda telah berhasil diunggah. Mohon menunggu
                                    hingga
                                    proses verifikasi dilakukan oleh admin.</p>
                                <a href="{{ route('backend_pedagang.pages.uploadpermohonan') }}"
                                    class="btn btn-white px-4 rounded-5 mt-4"><i class='bx bx-list-check'></i>Lihat
                                    Permohonan</a>
                            </div>
                        </div>
                    </div>
                    {{-- Kalau status disetujui --}}
                @elseif($permohonan->status == 'disetujui')
                    <div class="col">
                        <div class="card rounded-4 bg-gradient-warning">
                            <div class="card-body text-center">
                                <h3 class="text-dark">Permohonan Sudah Berhasil Disetujui, Belum Terverifikasi!</h3>
                                <div class="widgets-icons-2 mx-auto my-4 bg-white rounded-circle text-dark">
                                    <i class='bx bx-check-circle'></i>
                                </div>
                                <p class="mb-0 text-dark">Surat permohonan Anda telah berhasil disetujui. <br>Silahkan
                                    unduh surat pemberitahuan dan surat pernyataan menjadi pedagang,
                                    lalu tanda tangani Surat pernyataan untuk menyelesaikan verifikasi.</p>
                                <a href="{{ route('backend_pedagang.pages.uploadpermohonan') }}"
                                    class="btn btn-white px-4 rounded-5 mt-4"><i class='bx bx-check'></i>Verifikasi</a>
                            </div>
                        </div>
                    </div>
                    {{-- Kalau status ditolak --}}
                @elseif($permohonan->status == 'ditolak')
                    <div class="col">
                        <div class="card rounded-4 bg-gradient-danger">
                            <div class="card-body text-center">
                                <h3 class="text-dark">Permohonan Anda Ditolak !</h3>
                                <div class="widgets-icons-2 mx-auto my-4 bg-white rounded-circle text-dark">
                                    <i class='bx bx-x'></i>
                                </div>
                                <p class="mb-0 text-dark">Permohonan yang Anda ajukan belum memenuhi kriteria yang
                                    diperlukan.
                                    Silakan ajukan kembali permohonan baru dengan memastikan seluruh informasi dan dokumen
                                    telah sesuai.</p>
                                <a href="{{ route('backend_pedagang.pages.permohonan') }}"
                                    class="btn btn-white px-4 rounded-5 mt-4"><i class='bx bx-cloud-upload'></i>Buat Ulang
                                    Surat Permohonan</a>
                            </div>
                        </div>
                    </div>
                    {{-- Kalau status verifikasi --}}
                @elseif($permohonan->status == 'verifikasi')
                    <div class="col">
                        <div class="card rounded-4 bg-gradient-primary">
                            <div class="card-body text-center">
                                <h3 class="text-dark">Permohonan Anda Sedang Diverifikasi!</h3>
                                <div class="widgets-icons-2 mx-auto my-4 bg-white rounded-circle text-dark">
                                    <i class='bx bx-time'></i>
                                </div>
                                <p class="mb-0 text-dark">Permohonan Anda sedang dalam tahap verifikasi akhir oleh admin.
                                    Setelah diverifikasi, Anda akan resmi terdaftar sebagai pedagang.</p>
                                <a href="{{ route('backend_pedagang.pages.uploadpermohonan') }}"
                                    class="btn btn-white px-4 rounded-5 mt-4"><i class='bx bx-list-check'></i>Lihat
                                    Permohonan</a>
                            </div>
                        </div>
                    </div>
                    {{-- Kalau status selesai --}}
                @elseif($permohonan->status == 'selesai')
                    <div class="col">
                        <div class="card rounded-4 bg-gradient-success">
                            <div class="card-body text-center">
                                <h3 class="text-dark">Permohonan Sudah Berhasil Disetujui, Terverifikasi!</h3>
                                <div class="widgets-icons-2 mx-auto my-4 bg-white rounded-circle text-dark">
                                    <i class='bx bx-check-circle'></i>
                                </div>
                                <p class="mb-0 text-dark">Surat permohonan Anda telah berhasil disetujui. Selamat Anda
                                    sudah berhasil terverifikasi menjadi pedagang!</p>
                                <!--<a href="{{ route('backend_pedagang.pages.uploadpermohonan') }}"
                                                                                                                                class="btn btn-white px-4 rounded-5 mt-4"><i class='bx bx-check'></i>Verifikasi</a>-->
                            </div>
                        </div>
                    </div>
                @endif
            @endif
            <hr>
            <!-- Pengumuman Table -->
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="d-lg-flex align-items-center mb-4 gap-3">
                            <div class="position-relative">
                                <h5 class="card-title">Pengumuman</h5>
                            </div>
                            <div class="ms-auto">
                                <a href="{{ route('backend_pedagang.pages.pengumuman') }}"
                                    class="btn btn-primary radius-30 mt-2 mt-lg-0">Lihat Selengkapnya</a>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Judul</th>
                                        <th>Lihat Isi Pengumuman</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pengumumans->take(5) as $pengumuman)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ \Carbon\Carbon::parse($pengumuman->tanggal)->locale('id')->translatedFormat('d M Y') }}
                                            </td>
                                            <td>{{ $pengumuman->judul }}</td>
                                            <td>
                                                <button type="button" class="btn btn-warning btn-sm radius-30 px-4"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#viewPengumumanModal_{{ $pengumuman->id }}"
                                                    data-id="{{ $pengumuman->id }}">
                                                    View Details
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Modal View Detail Pengumuman -->
                @foreach ($pengumumans->take(5) as $pengumuman)
                    <div class="modal fade" id="viewPengumumanModal_{{ $pengumuman->id }}" tabindex="-1"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable">
                            <div class="modal-content" style="border: none; box-shadow: none;">
                                <div class="modal-header" style="border-bottom: none;">
                                    <h5 class="modal-title">Detail Pengumuman: {{ $pengumuman->judul }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body" style="padding: 20px;">
                                    <table class="table" style="border: none; width: 100%; border-collapse: collapse;">
                                        <tr>
                                            <td style="width: 20%; padding: 8px; border: none;"><strong>Judul:</strong>
                                            </td>
                                            <td style="padding: 8px; border: none;">{{ $pengumuman->judul }}</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 20%; padding: 8px; border: none;"><strong>Isi:</strong></td>
                                            <td style="padding: 8px; border: none;">{{ $pengumuman->isi }}</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 20%; padding: 8px; border: none;"><strong>Tanggal:</strong>
                                            </td>
                                            <td style="padding: 8px; border: none;">
                                                {{ \Carbon\Carbon::parse($pengumuman->tanggal)->format('d M Y') }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="modal-footer" style="border-top: none;">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var welcomeModal = new bootstrap.Modal(document.getElementById('welcomeModal'));
            @if ($showModal)
                console.log('Modal triggered');
                welcomeModal.show();
            @else
                console.log('No trigger for modal');
            @endif
        });
    </script>
@endsection
