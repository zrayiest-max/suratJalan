@extends('adminlte::page')

@section('title', 'Merk')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Merk</h1>

        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">Dashboard</a>
            </li>

            <li class="breadcrumb-item active">
                Merk
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
            <h2 class="mb-3">Daftar Merk</h2>



            {{-- Action & Search --}}
            <div class="d-flex justify-content-between align-items-center mb-3">

                <a href="{{ route('merk.create') }}" class="btn btn-primary">
                    Tambah Merk
                </a>

                <form action="{{ route('merk.index') }}" method="GET">
                    <div class="input-group">

                        <input type="text" name="search" class="form-control" placeholder="Cari merk..."
                            value="{{ request('search') }}">

                        <button type="submit" class="btn btn-primary">
                            Cari
                        </button>

                        @if (request('search'))
                            <a href="{{ route('merk.index') }}" class="btn btn-secondary">
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
                            <th>Merk</th>
                            <th style="width: 150px;">#</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($merks as $merk)
                            <tr>
                                <td>{{ $merk->nama }}</td>

                                <td>
                                    <a href="{{ route('merk.edit', $merk->id) }}" class="btn btn-sm btn-primary">
                                        Edit
                                    </a>

                                    <form action="{{ route('merk.destroy', $merk->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus merk ini?')">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center text-muted">
                                    Tidak ada data merk.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer">
            {{ $merks->links() }}
        </div>

    </div>
@stop
