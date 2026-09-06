@extends('adminlte::page')

@section('title', 'Folder')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Folder</h1>

        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">Dashboard</a>
            </li>

            <li class="breadcrumb-item active">
                Folder
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
            <h2 class="mb-3">Daftar Folder</h2>



            {{-- Action & Search --}}
            <div class="d-flex justify-content-between align-items-center mb-3">

                <a href="{{ route('folder.create') }}" class="btn btn-primary">
                    Tambah Folder
                </a>

                <form action="{{ route('folder.index') }}" method="GET">
                    <div class="input-group">

                        <input type="text" name="search" class="form-control" placeholder="Cari folder..."
                            value="{{ request('search') }}">

                        <button type="submit" class="btn btn-primary">
                            Cari
                        </button>

                        @if (request('search'))
                            <a href="{{ route('folder.index') }}" class="btn btn-secondary">
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
                            <th>Folder</th>
                            <th>No. SJ</th>
                            <th>Tanggal</th>
                            <th>No. Brg</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($folders as $folder)
                            <tr>
                                <td>{{ $folder->nama }}</td>
                                <td>{{ $folder->suratJalans->count() }}</td>
                                <td>{{ $folder->created_at->format('d/M/Y') }}</td>
                                <td>{{ $folder->details_count }}</td>

                                <td>
                                    <a href="{{ route('folder.show', $folder->id) }}" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('folder.edit', $folder->id) }}" class="btn btn-sm btn-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="{{ route('folder.print', $folder) }}" class="btn btn-secondary btn-sm">
                                        <i class="bi bi-printer"></i>
                                    </a>

                                    <form action="{{ route('folder.destroy', $folder->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus folder ini?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">
                                    Tidak ada data folder.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer">
            {{ $folders->links() }}
        </div>

    </div>
@stop
