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
                Tambah Surat Jalan
            </li>
        </ol>
    </div>
@stop

@section('content')
    <div class="container">
        <div class="card p-4">
            <div class="mb-3">
                <h5 class="mb-0">Tambah Surat Jalan</h5>
            </div>
            <form action="{{ route('surat-jalan.store') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="alamat" class="form-label">
                        Nomor Surat Jalan <span class="text-danger">*</span>
                    </label>

                    <input type="text" id="no_surat" name="no_surat"
                        class="form-control @error('no_surat') is-invalid @enderror"
                        value="{{ old('no_surat', $nomorSurat) }}" readonly>

                    @error('no_surat')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">
                        Tanggal <span class="text-danger">*</span>
                    </label>

                    <input type="date" id="tanggal" name="tanggal"
                        class="form-control @error('tanggal') is-invalid @enderror"
                        value="{{ old('tanggal', now()->format('Y-m-d')) }}" required>

                    @error('tanggal')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="merk_id" class="form-label">
                        Merk <span class="text-danger">*</span>
                    </label>

                    <select name="merk_id" id="merk_id"
                        class="form-select tom-select @error('merk_id') is-invalid @enderror" required>

                        <option value=""></option>
                        @foreach ($merks as $merk)
                            <option value="{{ $merk->id }}" @selected(old('merk_id') == $merk->id)>
                                {{ $merk->nama }}
                            </option>
                        @endforeach
                    </select>

                    @error('merk_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="penerima_id" class="form-label">Penerima<span class="text-danger">*</span></label>

                    <select name="penerima_id" id="penerima_id" class="form-select tom-select" required>
                        <option value=""></option>

                        @foreach ($penerimas as $penerima)
                            <option value="{{ $penerima->id }}">
                                {{ $penerima->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <h5 class="mb-0">Detail Surat Jalan</h5>
                </div>

                <div class="mb-3">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th scope="col" style="width: 60px">#</th>
                                    <th scope="col" style="width: 150px">Jumlah</th>
                                    <th scope="col">Nama Barang</th>
                                    <th scope="col" style="width: 70px"></th>
                                </tr>
                            </thead>

                            <tbody id="item-table-body">
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

                                    <td class="text-center">
                                        <button type="button" class="btn btn-outline-danger btn-sm btn-remove-row"
                                            disabled>
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

@stop

@section('js')
    @vite('resources/js/surat-jalan.js')
@stop
