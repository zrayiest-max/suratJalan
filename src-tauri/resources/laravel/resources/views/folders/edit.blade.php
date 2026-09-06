@extends('adminlte::page')

@section('title', 'Edit Folder')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Folder</h1>

        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">Dashboard</a>
            </li>

            <li class="breadcrumb-item">
                <a href="{{ route('folder.index') }}">Folder</a>
            </li>

            <li class="breadcrumb-item active">
                Edit Folder
            </li>
        </ol>
    </div>
@stop

@section('content')
    <div class="container">
        <div class="card p-4">

            <div class="mb-3">
                <h5 class="mb-0">Edit Folder</h5>
            </div>

            <form action="{{ route('folder.update', $folder->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nama" class="form-label">
                        Nama Folder <span class="text-danger">*</span>
                    </label>

                    <input type="text" id="nama" name="nama"
                        class="form-control @error('nama') is-invalid @enderror" placeholder="Masukkan nama folder"
                        value="{{ old('nama', $folder->nama) }}" required>

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

                    <a href="{{ route('folder.index') }}" class="btn btn-secondary">
                        Batal
                    </a>
                </div>

            </form>
        </div>
    </div>
@stop
