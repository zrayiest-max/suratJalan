@extends('adminlte::page')

@section('title', 'Database Management')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Database Management</h1>

        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">
                Database
            </li>
        </ol>
    </div>
@stop

@section('content')
    <div class="container">

        <div class="card">
            <div class="card-body">

                <h5>Backup Database</h5>

                <p class="text-muted">
                    Simpan salinan database untuk menjaga data Surat Jalan tetap aman.
                </p>

                <a href="{{ route('database.backup') }}" class="btn btn-success" onclick="handleBackup(this)">
                    <i class="bi bi-database-down"></i>
                    <span>Backup Database</span>
                </a>

            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body">

                <h5>Restore Database</h5>

                <p class="text-muted">
                    Pulihkan data dari file backup database sebelumnya.
                    Data saat ini akan digantikan.
                </p>

                <form action="{{ route('database.restore') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <input type="file" name="database" class="form-control" accept=".sqlite" required>
                    </div>

                    <button type="submit" class="btn btn-warning"
                        onclick="return confirm('Database saat ini akan diganti dengan file backup. Lanjutkan?')">
                        <i class="bi bi-database-up"></i>
                        Restore Database
                    </button>
                </form>

            </div>
        </div>

        <div class="card mt-3 border-danger">
            <div class="card-body">

                <h5 class="text-danger">Reset Database</h5>

                <p class="text-muted">
                    Mengembalikan database ke kondisi awal.
                    Semua data Surat Jalan, Folder, dan data lainnya akan dihapus.
                </p>

                <form action="{{ route('database.reset') }}" method="POST">
                    @csrf

                    <button type="submit" class="btn btn-danger"
                        onclick="return confirm('SEMUA DATA akan dihapus dan database dikembalikan ke kondisi awal. Yakin?')">
                        <i class="bi bi-arrow-counterclockwise"></i>
                        Reset Database
                    </button>
                </form>

            </div>
        </div>

    </div>
@stop

@section('js')
    <script>
        function handleBackup(button) {
            button.style.pointerEvents = 'none';
            button.classList.add('disabled');

            const text = button.querySelector('span');
            text.textContent = 'Mengunduh...';

            setTimeout(() => {
                button.style.pointerEvents = 'auto';
                button.classList.remove('disabled');
                text.textContent = 'Backup Database';
            }, 3000);
        }
    </script>
@stop
