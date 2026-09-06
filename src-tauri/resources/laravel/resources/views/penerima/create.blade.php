@extends('adminlte::page')

@section('title', 'Penerima')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Penerima</h1>

        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">Dashboard</a>
            </li>

            <li class="breadcrumb-item">
                <a href="{{ route('penerima.index') }}">Penerima</a>
            </li>

            <li class="breadcrumb-item active">
                Tambah Penerima
            </li>
        </ol>
    </div>
@stop

@section('content')
    <div class="container">
        <div class="card p-4">
            <div class="mb-3">
                <h5 class="mb-0">Tambah Penerima</h5>
            </div>
            <form action="{{ route('penerima.store') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="nama" class="form-label">
                        Nama Penerima <span class="text-danger">*</span>
                    </label>

                    <input type="text" id="nama" name="nama"
                        class="form-control @error('nama') is-invalid @enderror" placeholder="Masukkan nama penerima"
                        value="{{ old('nama') }}" required>

                    @error('nama')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">
                        Alamat <span class="text-danger">*</span>
                    </label>

                    <input type="text" id="alamat" name="alamat"
                        class="form-control @error('alamat') is-invalid @enderror" placeholder="Masukkan alamat"
                        value="{{ old('alamat') }}" required>

                    @error('alamat')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('penerima.index') }}" class="btn btn-secondary">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@stop
