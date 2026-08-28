@extends('backend_admin.app')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Pasar</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Detail Pasar</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <br>
            <h6 class="mb-0 text-uppercase">Table Pasar</h6>
            <hr />
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table_pasar" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Pasar</th>
                                    <th>Alamat</th>
                                    <th>Total Kios</th>
                                    <th>Total Los</th>
                                    <th>Total Pelataran</th>
                                    <th>Detail Pasar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pasar as $data)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $data->nama_pasar }}</td>
                                        <td>{{ $data->alamat }}</td>
                                        <td>{{ $data->total_kios }}</td>
                                        <td>{{ $data->total_los }}</td>
                                        <td>{{ $data->total_pelataran }}</td>
                                        <td>
                                            <button type="button" class="btn btn-warning btn-sm radius-30 px-4 view-detail"
                                                data-id="{{ $data->id }}">
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
        </div>
    </div>
    <!-- Modal Scrollable -->
    <div class="modal fade" id="detailPasarModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Detail Pasar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalBody">
                    <div class="text-center">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            console.log('Script detail pasar loaded');

            // Event delegation biar aman meski tombol ditambah nanti
            $(document).on('click', '.view-detail', function() {
                var id = $(this).data('id');

                console.log('Tombol View Details diklik, ID:', id);

                if (!id) {
                    alert('Error: ID pasar tidak ditemukan!');
                    return;
                }

                // Ambil atau buat instance modal Bootstrap
                var modalElement = document.getElementById('detailPasarModal');
                var modal = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);

                // Reset modal
                $('#modalTitle').text('Detail Pasar');
                $('#modalBody').html(`
            <div class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-3 text-muted">Memuat detail pasar...</p>
            </div>
        `);

                modal.show();

                // AJAX ambil data
                $.ajax({
                    url: '{{ route('pasar.show', ':id') }}'.replace(':id', id),
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        console.log('Data detail pasar diterima:', data);

                        // Format peta
                        var lokasiPeta = data.lokasi_peta && data.lokasi_peta.includes(
                                '<iframe') ?
                            data.lokasi_peta.replace('<iframe',
                                '<iframe style="width: 100%; height: 400px; border:0;" allowfullscreen loading="lazy"'
                                ) :
                            '<p class="text-muted text-center py-4">Tidak ada peta tersedia</p>';

                        // Update judul modal
                        $('#modalTitle').text('Detail Pasar: ' + (data.nama_pasar || 'N/A'));

                        // Render isi modal
                        $('#modalBody').html(`
                    <div class="container-fluid">
                        <div class="row justify-content-center">
                            <div class="col-lg-10 col-xl-8">
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="align-top" style="width: 25%;"><strong>Nama Pasar</strong></td>
                                        <td class="align-top">:</td>
                                        <td>${data.nama_pasar || 'N/A'}</td>
                                    </tr>
                                    <tr>
                                        <td class="align-top"><strong>Alamat</strong></td>
                                        <td>:</td>
                                        <td>${data.alamat || 'N/A'}</td>
                                    </tr>
                                    <tr>
                                        <td class="align-top"><strong>Total Kios</strong></td>
                                        <td>:</td>
                                        <td>${data.total_kios || 0}</td>
                                    </tr>
                                    <tr>
                                        <td class="align-top"><strong>Total Los</strong></td>
                                        <td>:</td>
                                        <td>${data.total_los || 0}</td>
                                    </tr>
                                    <tr>
                                        <td class="align-top"><strong>Total Pelataran</strong></td>
                                        <td>:</td>
                                        <td>${data.total_pelataran || 0}</td>
                                    </tr>

                                    <!-- Foto Depan -->
                                    <tr>
                                        <td class="align-top"><strong>Foto Tampak Depan</strong></td>
                                        <td>:</td>
                                        <td>
                                            ${data.foto_depan 
                                                ? `<img src="${data.foto_depan}" alt="Tampak Depan" class="img-fluid rounded shadow-sm mb-3" style="max-height: 400px; cursor: pointer;" onclick="window.open(this.src, '_blank')">`
                                                : '<p class="text-muted">Tidak ada foto</p>'
                                            }
                                        </td>
                                    </tr>

                                    <!-- Foto Belakang -->
                                    <tr>
                                        <td class="align-top"><strong>Foto Tampak Belakang</strong></td>
                                        <td>:</td>
                                        <td>
                                            ${data.foto_belakang 
                                                ? `<img src="${data.foto_belakang}" alt="Tampak Belakang" class="img-fluid rounded shadow-sm mb-3" style="max-height: 400px; cursor: pointer;" onclick="window.open(this.src, '_blank')">`
                                                : '<p class="text-muted">Tidak ada foto</p>'
                                            }
                                        </td>
                                    </tr>

                                    <!-- Foto Dalam -->
                                    <tr>
                                        <td class="align-top"><strong>Foto Tampak Dalam Pasar</strong></td>
                                        <td>:</td>
                                        <td>
                                            ${data.foto_dalam 
                                                ? `<img src="${data.foto_dalam}" alt="Tampak Dalam" class="img-fluid rounded shadow-sm mb-3" style="max-height: 400px; cursor: pointer;" onclick="window.open(this.src, '_blank')">`
                                                : '<p class="text-muted">Tidak ada foto</p>'
                                            }
                                        </td>
                                    </tr>

                                    <!-- Lokasi Peta -->
                                    <tr>
                                        <td class="align-top"><strong>Lokasi Peta</strong></td>
                                        <td>:</td>
                                        <td>
                                            <div class="rounded overflow-hidden shadow-sm">
                                                ${lokasiPeta}
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                `);
                    },
                    error: function(xhr) {
                        console.error('AJAX Error:', xhr.status, xhr.responseText);
                        $('#modalBody').html(`
                    <div class="alert alert-danger text-center">
                        <strong>Gagal memuat data!</strong><br>
                        ${xhr.status === 404 ? 'Data pasar tidak ditemukan.' : 'Terjadi kesalahan server. Silakan coba lagi.'}
                    </div>
                `);
                    }
                });
            });
        });
    </script>
@endpush
