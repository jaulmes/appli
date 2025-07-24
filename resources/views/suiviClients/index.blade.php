@extends('dashboard.main')

@section('content')
<div class="container-fluid py-4">
    <livewire:suivi-index/>
</div>

<style>
    .card {
        border-radius: 10px;
        border: none;
    }
    .table th {
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .table td {
        vertical-align: middle;
    }
    .badge {
        font-size: 0.75rem;
        padding: 0.35em 0.65em;
    }
    .page-header {
        padding: 1rem;
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
</style>

@endsection