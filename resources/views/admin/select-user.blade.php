@extends('layouts.custom')

@section('content')
    <div class="container mt-4">
        <h4>Pilih User / Outlet</h4>
        <form action="{{ route('admin.userMenu') }}" method="GET">
            <div class="form-group">
                <label for="user_id">Outlet/User:</label>
                <select name="user_id" class="form-control" required>
                    <option value="">-- Pilih --</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->username }})</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Lanjut</button>
        </form>
    </div>
@endsection
