@extends('adminlte::page')

@section('title', 'Tracking')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Tracking</h1>

        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">Dashboard</a>
            </li>

            <li class="breadcrumb-item active">
                Tracking
            </li>
        </ol>
    </div>
@stop

@section('content')

    <div class="card">
        <div class="card-body p-4">
            <h2 class="mb-3">Daftar Item</h2>
            {{-- Action & Search --}}
            <div class="d-flex justify-content-between align-items-center mb-3">

                <form action="{{ route('surat-jalan.tracking') }}" method="GET">
                    <div class="input-group">

                        <input type="text" name="search" class="form-control" placeholder="Cari barang..."
                            value="{{ request('search') }}">

                        <button type="submit" class="btn btn-primary">
                            Cari
                        </button>

                        @if (request('search'))
                            <a href="{{ route('surat-jalan.tracking') }}" class="btn btn-secondary">
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
                            <th>No. Surat</th>
                            <th>Folder</th>
                            <th>Merk</th>
                            <th>Penerima</th>
                            <th>Barang</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($details as $detail)
                            <tr>
                                <td>{{ $detail->suratJalan->no_surat }}</td>
                                <td>{{ $detail->folder->nama }}</td>
                                <td>{{ $detail->suratJalan->merk->nama }}</td>
                                <td>{{ $detail->suratJalan->penerima->nama }}</td>
                                <td>{{ $detail->nama_barang }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">
                                    Tidak ada data.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $details->links() }}
        </div>
    </div>
@stop
