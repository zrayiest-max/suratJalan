@extends('adminlte::page')

@section('title', 'Penerima')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Penerima</h1>

        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">Dashboard</a>
            </li>

            <li class="breadcrumb-item active">
                Penerima
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
            <h2 class="mb-3">Daftar Penerima</h2>
            {{-- Action & Search --}}
            <div class="d-flex justify-content-between align-items-center mb-3">

                <a href="{{ route('penerima.create') }}" class="btn btn-primary">
                    Tambah Penerima
                </a>

                <form action="{{ route('penerima.index') }}" method="GET">
                    <div class="input-group">

                        <input type="text" name="search" class="form-control" placeholder="Cari penerima..."
                            value="{{ request('search') }}">

                        <button type="submit" class="btn btn-primary">
                            Cari
                        </button>

                        @if (request('search'))
                            <a href="{{ route('penerima.index') }}" class="btn btn-secondary">
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
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th style="width: 150px;">#</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($penerimas as $penerima)
                            <tr>
                                <td>{{ $penerima->nama }}</td>
                                <td>{{ $penerima->alamat }}</td>

                                <td>
                                    <a href="{{ route('penerima.edit', $penerima->id) }}" class="btn btn-sm btn-primary">
                                        Edit
                                    </a>

                                    <form action="{{ route('penerima.destroy', $penerima->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus penerima ini?')">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">
                                    Tidak ada data penerima.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer">
            {{ $penerimas->links() }}
        </div>
    </div>
@stop
