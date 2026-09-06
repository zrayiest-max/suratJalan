@extends('adminlte::page')

@section('title', 'Surat Jalan')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Surat Jalan</h1>

        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">Dashboard</a>
            </li>

            <li class="breadcrumb-item active">
                Surat Jalan
            </li>
        </ol>
    </div>
@stop

@section('content')

    <div class="card">
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
        <div class="card-body p-4">
            <h2 class="mb-3">Daftar Surat Jalan</h2>
            {{-- Action & Search --}}
            <div class="d-flex justify-content-between align-items-center mb-3">

                <button type="button" class="btn btn-primary" id="btnMasukkanFolder" data-bs-toggle="modal"
                    data-bs-target="#folderModal" disabled>
                    <i class="bi bi-folder-plus"></i>
                    Masukkan ke Folder
                </button>

                <form action="{{ route('surat-jalan.index') }}" method="GET">
                    <div class="input-group">

                        <input type="text" name="search" class="form-control" placeholder="Cari surat merk..."
                            value="{{ request('search') }}">

                        <button type="submit" class="btn btn-primary">
                            Cari
                        </button>

                        @if (request('search'))
                            <a href="{{ route('surat-jalan.index') }}" class="btn btn-secondary">
                                Reset
                            </a>
                        @endif

                    </div>
                </form>

            </div>

            {{-- Table --}}
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>
                                <input type="checkbox" id="selectAll">
                            </th>
                            <th>Merk</th>
                            <th>Penerima</th>
                            <th>No. Surat</th>
                            <th>Tanggal</th>
                            <th>No. SJ</th>
                            <th>Folder</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($suratJalans as $item)
                            <tr>
                                <td>
                                    <input type="checkbox" name="selected[]" class="surat-checkbox"
                                        value="{{ $item->id }}">
                                </td>

                                <td>{{ $item->merk->nama }}</td>
                                <td>{{ $item->penerima->nama }}</td>
                                <td>{{ $item->no_surat }}</td>
                                <td>{{ $item->tanggal->format('d-m-Y') }}</td>
                                <td>{{ $item->jumlah_barang }}</td>
                                <td>
                                    @if ($item->folder)
                                        <i class="bi bi-check-circle-fill text-success"></i>
                                    @else
                                        <i class="bi bi-x-circle text-muted"></i>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('surat-jalan.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <form action="{{ route('surat-jalan.destroy', $item->id) }}" method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus surat jalan ini?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">
                                    Tidak ada data surat jalan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{-- Modal Masukkan ke Folder --}}
    <div class="modal fade" id="folderModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <form action="{{ route('surat-jalan.masukkan-folder') }}" method="POST">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title">
                            Masukkan ke Folder
                        </h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>

                    <div class="modal-body">

                        <p class="text-muted">
                            <span id="jumlahDipilih" class="text-primary fw-bold">0</span>
                            surat jalan dipilih
                        </p>

                        <div class="mb-3">
                            <label for="folder_id" class="form-label">
                                Pilih Folder
                            </label>

                            <select name="folder_id" id="folder_id" class="form-select tom-select-folder" required>

                                <option value="">
                                </option>

                                @foreach ($folders as $folder)
                                    <option value="{{ $folder->id }}">
                                        {{ $folder->nama }}
                                    </option>
                                @endforeach

                            </select>
                        </div>

                        {{-- ID Surat Jalan yang dipilih akan dimasukkan ke sini --}}
                        <div id="selectedSuratJalan"></div>

                    </div>

                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Batal
                        </button>

                        <button type="submit" class="btn btn-primary">
                            Simpan
                        </button>

                    </div>

                </form>

            </div>
        </div>
    </div>
@stop

@section('js')
    @vite(['resources/js/masuk-folder.js', 'resources/js/folder-modal.js'])
@stop
