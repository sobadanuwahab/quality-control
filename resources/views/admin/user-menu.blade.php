@extends('layouts.custom')

@section('content')
    <div class="container mt-4">
        <h4>Data untuk: <strong>{{ $selectedUser->name }}</strong></h4>
        <div class="list-group mt-3">
            <a href="{{ route('admin.logMeteran', $selectedUser->id) }}" class="list-group-item list-group-item-action">Log
                Meteran</a>
            <a href="{{ route('admin.dcp', $selectedUser->id) }}" class="list-group-item list-group-item-action">DCP
                Report</a>
            <a href="{{ route('admin.onesheet', $selectedUser->id) }}"
                class="list-group-item list-group-item-action">Onesheet</a>
            <a href="{{ route('admin.projector', $selectedUser->id) }}"
                class="list-group-item list-group-item-action">Maintenance Projector</a>
            <a href="{{ route('admin.hvac', $selectedUser->id) }}"
                class="list-group-item list-group-item-action">Maintenance HVAC</a>
            <a href="{{ route('admin.asset', $selectedUser->id) }}" class="list-group-item list-group-item-action">Data
                Asset</a>
        </div>
    </div>
@endsection
