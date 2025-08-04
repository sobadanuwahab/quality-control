@extends('layouts.custom')

@section('content')
    <main class="flex-grow p-4">
        <div class="container mx-auto">
            <h2 class="fw-bold mb-4" style="color: #367fa9"><i class="bi bi-clipboard-data me-2"></i>Data Asset
            </h2>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="GET" action="{{ route('asset.index') }}" class="row g-3 mb-4">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Cari Nama Asset"
                        value="{{ request('search') }}">
                </div>
                <div class="col-md-4">
                    <select name="grouping_asset" class="form-control">
                        <option value="">-- Semua Grouping Asset --</option>
                        @foreach ($groupingOptions as $group)
                            <option value="{{ $group }}" {{ request('grouping_asset') == $group ? 'selected' : '' }}>
                                {{ $group }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('asset.index') }}" class="btn btn-secondary">Reset</a>
                </div>
            </form>

            <div class="table-responsive card shadow-sm p-3">
                @include('asset.table', ['assets' => $assets])
            </div>
        </div>
    </main>
@endsection
