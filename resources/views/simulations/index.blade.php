@extends('dashboard.main')

@section('content')

<section class="h-100 h-custom">
    <div class="container h-100 py-5">
        <livewire:liste-simulation/>
    </div>
</section>

@endsection

@section('javascript')
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
@endsection
