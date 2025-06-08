@extends('backend.menus.superior')

@section('content-admin-css')
<link href="{{ asset('css/adminlte.min.css') }}" rel="stylesheet" />
@stop

@section('content')
<div class="container mt-4">
    <h2>Listado de Eventos</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Fecha</th>
                <th>Ubicación</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($events as $event)
            <tr>
                <td>{{ $event->name }}</td>
                <td>{{ $event->date }}</td>
                <td>{{ $event->location }}</td>
                <td>
                    <a href="{{ route('events.show', $event->id) }}" class="btn btn-info btn-sm">Ver</a>
                    <form action="{{ route('events.destroy', $event->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('¿Eliminar este evento?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@extends('backend.menus.footerjs')
