@extends('adminlte::page')

@section('title', 'Edit Merk')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Merk</h1>

        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">Dashboard</a>
            </li>

            <li class="breadcrumb-item">
                <a href="{{ route('merk.index') }}">Merk</a>
            </li>

            <li class="breadcrumb-item active">
                Edit Merk
            </li>
        </ol>
    </div>
@stop

@section('content')
    <div class="container">
        <div class="card p-4">

            <div class="mb-3">
                <h5 class="mb-0">Edit Merk</h5>
            </div>

            <form action="{{ route('merk.update', $merk->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nama" class="form-label">
                        Nama Merk <span class="text-danger">*</span>
                    </label>

                    <input type="text" id="nama" name="nama"
                        class="form-control @error('nama') is-invalid @enderror" placeholder="Masukkan nama merk"
                        value="{{ old('nama', $merk->nama) }}" required>

                    @error('nama')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">
                        Simpan Perubahan
                    </button>

                    <a href="{{ route('merk.index') }}" class="btn btn-secondary">
                        Batal
                    </a>
                </div>

            </form>
        </div>
    </div>
@stop
