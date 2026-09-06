@extends('adminlte::page')

@section('title', 'Surat Jalan')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Surat Jalan</h1>

        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">Dashboard</a>
            </li>

            <li class="breadcrumb-item">
                <a href="{{ route('folder.index') }}">Folder</a>
            </li>

            <li class="breadcrumb-item active">
                Detail Folder
            </li>
        </ol>
    </div>
@stop

@section('content')
    <div class="container">
        <div class="card p-4">
            <div class="mb-3">
                <h5 class="mb-0">Detail Surat Jalan</h5>
            </div>
            <form action="{{ route('folder.details.store', $folder) }}" method="post">
                @csrf
                <div class="mb-3">
                    <div id="deleted-items"></div>
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th style="width: 60px">#</th>
                                    <th style="width: 150px">Jumlah</th>
                                    <th>Nama Barang</th>
                                    <th style="width: 220px">Surat Jalan</th>
                                    <th style="width: 70px"></th>
                                </tr>
                            </thead>

                            <tbody id="item-table-body">
                                @forelse ($folder->details as $detail)
                                    <tr class="item-row">
                                        <input type="hidden" name="items[{{ $loop->index }}][id]"
                                            value="{{ $detail->id }}">

                                        <th scope="row" class="row-number">
                                            {{ $loop->iteration }}
                                        </th>

                                        <td>
                                            <input type="number" name="items[{{ $loop->index }}][jumlah]"
                                                class="form-control item-jumlah" value="{{ $detail->jumlah }}"
                                                min="1" required>
                                        </td>

                                        <td>
                                            <input type="text" name="items[{{ $loop->index }}][nama_barang]"
                                                class="form-control item-nama-barang" value="{{ $detail->nama_barang }}"
                                                required>
                                        </td>

                                        <td>
                                            <select name="items[{{ $loop->index }}][surat_jalan_id]"
                                                class="form-select item-surat-jalan" required>

                                                @foreach ($suratJalans as $suratJalan)
                                                    <option value="{{ $suratJalan->id }}" @selected($detail->surat_jalan_id == $suratJalan->id)>
                                                        {{ $suratJalan->no_surat }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>

                                        <td class="text-center">
                                            <button type="button" class="btn btn-outline-danger btn-sm btn-remove-row"
                                                data-id="{{ $detail->id }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>

                                @empty
                                    <tr class="item-row">
                                        <th scope="row" class="row-number">1</th>

                                        <td>
                                            <input type="number" name="items[0][jumlah]" class="form-control item-jumlah"
                                                min="1" required>
                                        </td>

                                        <td>
                                            <input type="text" name="items[0][nama_barang]"
                                                class="form-control item-nama-barang" required>
                                        </td>

                                        <td>
                                            <select name="items[0][surat_jalan_id]" class="form-select item-surat-jalan">

                                                <option value="">-- Pilih Surat Jalan --</option>

                                                @foreach ($suratJalans as $suratJalan)
                                                    <option value="{{ $suratJalan->id }}">
                                                        {{ $suratJalan->no_surat }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>

                                        <td class="text-center">
                                            <button type="button" class="btn btn-outline-danger btn-sm btn-remove-row"
                                                disabled>
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('folder.index') }}" class="btn btn-secondary">
                        Batal
                    </a>
                </div>
            </form>

            <h6 class="mb-3">Daftar Surat Jalan</h6>
            {{-- Table --}}
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Merk</th>
                            <th>Penerima</th>
                            <th>No. Surat</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($suratJalans as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->merk->nama }}</td>
                                <td>{{ $item->penerima->nama }}</td>
                                <td>{{ $item->no_surat }}</td>
                                <td>{{ $item->tanggal->format('d-m-Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">
                                    Tidak ada data surat jalan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@stop

<script>
    window.suratJalans = @json(
        $suratJalans->map(fn($sj) => [
                'id' => $sj->id,
                'no_surat' => $sj->no_surat,
            ]));
</script>

@section('js')
    @vite('resources/js/folder-details.js')
@stop
