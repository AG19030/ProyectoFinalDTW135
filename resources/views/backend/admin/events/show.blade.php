@extends('backend.menus.superior')

@section('content-admin-css')
<link href="{{ asset('css/adminlte.min.css') }}" rel="stylesheet" />
@stop

@section('content')
<div class="container mt-4">
    <h2>Detalles del Evento</h2>
    <div class="card">
        <div class="card-body">
            <p><strong>Nombre:</strong> {{ $event->name }}</p>
            <p><strong>Descripción:</strong> {{ $event->description }}</p>
            <p><strong>Fecha:</strong> {{ $event->date }}</p>
            <p><strong>Lugar:</strong> {{ $event->location }}</p>
            <p><strong>Tipo:</strong> {{ $event->type_id }}</p>
        </div>
    </div>
    <a href="{{ route('events.index') }}" class="btn btn-secondary mt-3">Volver al listado</a>
</div>
@endsection

@extends('backend.menus.footerjs')
