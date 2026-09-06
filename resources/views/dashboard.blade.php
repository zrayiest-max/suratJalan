@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Dashboard</h1>

        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item active">
                Dashboard
            </li>
        </ol>
    </div>
@stop

@section('content')
    <style>
        .card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }
    </style>

    <div class="container py-5">
        <div class="row g-4">
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
            <div class="col-md-4">
                <a href="{{ route('surat-jalan.create') }}" class="text-decoration-none">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <i class="bi bi-file-earmark-plus fs-1 text-primary"></i>
                            </div>

                            <h4 class="card-title">
                                Buat Surat Jalan
                            </h4>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="{{ route('surat-jalan.index') }}" class="text-decoration-none">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <i class="bi bi-folder2-open fs-1 text-success"></i>
                            </div>

                            <h4 class="card-title">
                                Data Surat Jalan
                            </h4>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="{{ route('surat-jalan.tracking') }}" class="text-decoration-none">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <i class="bi bi-search fs-1 text-warning"></i>
                            </div>

                            <h4 class="card-title">
                                Tracking Item
                            </h4>
                        </div>
                    </div>
                </a>
            </div>

        </div>
    </div>
@stop
