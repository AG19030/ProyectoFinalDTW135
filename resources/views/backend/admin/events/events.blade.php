@extends('backend.menus.superior')

@section('content-admin-css')
    <link href="{{ asset('css/adminlte.min.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/dataTables.bootstrap4.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/toastr.min.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/responsive.bootstrap4.min.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/buttons.bootstrap4.min.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/estiloToggle.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/buttons_estilo.css') }}" rel="stylesheet">
@stop

<style>
    table{
        /*Ajustar tablas*/
        table-layout:fixed;
    }
</style>

<div id="divcontenedor" style="display: none">
    <section class="content-header">
        <div class="container-fluid">
            <div class="col-sm-12">
                <h1>Control de Eventos</h1>
            </div>
            <br>
            <button type="button" style="font-weight: bold; background-color: #28a745; color: white !important;" onclick="modalAgregar()" class="button button-3d button-rounded button-pill button-small">
                <i class="fas fa-pencil-alt"></i>
                Nuevo Evento
            </button>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Eventos Registrados</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="tablaDatatable"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="modalAgregar">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Nuevo Evento</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formulario-nuevo" onsubmit="event.preventDefault(); nuevoEvento();">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="form-group">
                                        <label>Nombre</label>
                                        <input type="text" maxlength="255" autocomplete="off" class="form-control" id="nombre-nuevo" placeholder="Nombre">
                                    </div>

                                    <div class="form-group">
                                        <label>Fecha</label>
                                        <input type="date" autocomplete="off" class="form-control" id="fecha-nuevo" placeholder="Fecha">
                                    </div>

                                    <div class="form-group">
                                        <label>Lugar</label>
                                        <input type="text" maxlength="255" autocomplete="off" class="form-control" id="lugar-nuevo" placeholder="Lugar">
                                    </div>

                                    <div class="form-group">
                                        <label>Descripción</label>
                                        <input type="text" maxlength="150" autocomplete="off" class="form-control" id="descripcion-nuevo" placeholder="Descripción">
                                    </div>

                                    <div class="form-group">
                                        <label>Tipo de Evento</label>
                                        <select name="tipo-evento" id="tipo-evento-nuevo" class="form-control" style="width: 100%;">
                                            <option value="">Seleccione un tipo de evento</option>
                                            <option value="clase">Clase</option>
                                            <option value="reunion">Reunión</option>
                                            <option value="taller">Taller</option>
                                            <option value="otro">Otro</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" style="font-weight: bold; background-color: #28a745; color: white !important;" class="button button-3d button-rounded button-pill button-small" onclick="nuevoEvento()">Guardar</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modalEditar">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Editar Evento</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formulario-editar">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="form-group">
                                        <label>Nombre</label>
                                        <input type="hidden" id="id-editar">
                                        <input type="text" maxlength="255" autocomplete="off"  class="form-control" id="nombre-editar">
                                    </div>

                                    <div class="form-group">
                                        <label>Fecha</label>
                                        <input type="date" autocomplete="off" class="form-control" id="fecha-editar">
                                    </div>

                                    <div class="form-group">
                                        <label>Lugar</label>
                                        <input type="text" maxlength="255" autocomplete="off" class="form-control" id="lugar-editar" placeholder="Lugar">
                                    </div>

                                    <div class="form-group">
                                        <label>Descripción</label>
                                        <input type="text" maxlength="150" autocomplete="off" class="form-control" id="descripcion-editar" placeholder="Descripción">
                                    </div>

                                    <div class="form-group">
                                        <label>Tipo de Evento</label>
                                        <select name="tipo-evento" id="tipo-evento-nuevo" class="form-control" style="width: 100%;">
                                            <option value="">Seleccione un tipo de evento</option>
                                            <option value="clase">Clase</option>
                                            <option value="reunion">Reunión</option>
                                            <option value="taller">Taller</option>
                                            <option value="otro">Otro</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" style="font-weight: bold; background-color: #28a745; color: white !important;" class="button button-3d button-rounded button-pill button-small" onclick="actualizar()">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalBorrar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Borrar Evento</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formulario-borrar">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">

                                <div class="form-group">
                                    <input type="hidden" id="idborrar">
                                    <p>¿Está seguro de eliminar este evento?</p>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" style="font-weight: bold; background-color: #ff4351; color: white !important;" class="button button-3d button-rounded button-pill button-small" onclick="borrar()">Borrar</button>
            </div>
        </div>
    </div>
</div>

@extends('backend.menus.footerjs')
@section('archivos-js')

    <script src="{{ asset('js/jquery.dataTables.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.js') }}" type="text/javascript"></script>

    <script src="{{ asset('js/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/axios.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('js/alertaPersonalizada.js') }}"></script>
    <script src="{{ asset('js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/jszip.min.js') }}"></script>
    <script src="{{ asset('js/buttons.html5.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            var ruta = "{{ URL::to('admin/events/table') }}";
            $('#tablaDatatable').load("{{ URL::to('admin/eventos/tabla') }}");
            document.getElementById("divcontenedor").style.display = "block";
        });
    </script>

    <script>
        // Declarar 'url' si no está definida globalmente
        const url = "{{ url('/') }}";

        function recargar(){ // Función para recargar la tabla de eventos
            var ruta = "{{ url('/admin/eventos/tabla') }}";
            $('#tablaDatatable').load(ruta);
        }

        function modalAgregar(){
            document.getElementById("formulario-nuevo").reset();
            $('#modalAgregar').modal('show');
        }

        // nuevo evento
        function nuevoEvento(){

            var nombre = document.getElementById('nombre-nuevo').value;
            var fecha = document.getElementById('fecha-nuevo').value;
            var lugar = document.getElementById('lugar-nuevo').value;
            var descripcion = document.getElementById('descripcion-nuevo').value;
            var tipoEvento = parseInt(document.getElementById('tipo-evento-nuevo').value);


            openLoading();
            var formData = new FormData();
            formData.append('event_name', nombre);
            formData.append('date', fecha);
            formData.append('direction', lugar);
            formData.append('description', descripcion);
            formData.append('type_event', tipoEvento);

            axios.post(url+'/admin/eventos/nuevo-evento', formData, {
            })
                .then((response) => {
                    closeLoading()

                    if (response.data.status === 200) {
                        toastr.success(response.data.message);
                        $('#modalAgregar').modal('hide');
                        recargar();
                    } else if (response.data.status === 500) {
                        toastr.error(response.data.message);
                    }else if (response.data.status === 422) { // Validación de Laravel
                        $.each(response.data.errors, function(key, value){
                            toastr.error(value);
                        });
                    }
                    else {
                        toastr.error('Error al guardar');
                    }
                })
                .catch((error) => {
                    closeLoading();
                    if(error.response && error.response.data && error.response.data.errors){
                        $.each(error.response.data.errors, function(key, value){
                            toastr.error(value);
                        });
                    } else {
                        toastr.error('Error al guardar');
                    }
                });
        }

        // información de evento
        function verInformacion(id){
            openLoading();
            document.getElementById("formulario-editar").reset();

            axios.post(url+'/admin/eventos/info-evento/'+id)
                .then((response) => {
                    closeLoading();
                    if(response.data.success === 200){
                        $('#modalEditar').modal('show');
                        $('#id-editar').val(response.data.id);
                        $('#nombre-editar').val(response.data.event_name);
                        $('#fecha-editar').val(response.data.date);
                        $('#lugar-editar').val(response.data.direction);
                        $('#descripcion-editar').val(response.data.description);
                        $('#tipo-evento-editar').val(response.data.type_event);
                    } else if (response.data.status === 404) {
                        toastr.error(response.data.message);
                    }
                    else{
                        toastr.error('Información no encontrada');
                    }

                })
                .catch((error) => {
                    closeLoading()
                    toastr.error('Información no encontrada');
                });
        }

        // actualizar el evento
        function actualizar(){
            var id = document.getElementById('id-editar').value;
            var nombre = document.getElementById('nombre-editar').value;
            var fecha = document.getElementById('fecha-editar').value;
            var lugar = document.getElementById('lugar-editar').value;
            var descripcion = document.getElementById('descripcion-editar').value;
            var tipoEvento = document.getElementById('tipo-evento-editar').value;

            openLoading()
            var formData = new FormData();
            formData.append('id', id);
            formData.append('event_name', nombre);
            formData.append('date', fecha);
            formData.append('direction', lugar);
            formData.append('description', descripcion);
            formData.append('type_event', tipoEvento);


            axios.post(url+'/admin/eventos/editar-evento/'+id, formData, {
            })
                .then((response) => {
                    closeLoading()

                    if (response.data.status === 200) {
                        toastr.success(response.data.message);
                        $('#modalEditar').modal('hide');
                        recargar();
                    } else if (response.data.status === 500) {
                        toastr.error(response.data.message);
                    } else if (response.data.status === 422) { // Validación de Laravel
                        $.each(response.data.errors, function(key, value){
                            toastr.error(value);
                        });
                    }
                    else {
                        toastr.error('Error al actualizar');
                    }
                })
                .catch((error) => {
                    closeLoading();
                    if(error.response && error.response.data && error.response.data.errors){
                        $.each(error.response.data.errors, function(key, value){
                            toastr.error(value);
                        });
                    } else {
                        toastr.error('Error al actualizar');
                    }
                });
        }

        // se recibe el ID del evento a eliminar
        function modalBorrar(id){
            $('#idborrar').val(id);
            $('#modalBorrar').modal('show');
        }

        function borrar(){
            openLoading()
            // se envia el ID del evento
            var idevento = document.getElementById('idborrar').value;

            axios.post(url+'/admin/eventos/borrar-evento/'+idevento)
                .then((response) => {
                    closeLoading()
                    $('#modalBorrar').modal('hide');

                    if(response.data.status === 200){
                        toastr.success(response.data.message);
                        recargar();
                    }else{
                        toastr.error('Error al eliminar');
                    }
                })
                .catch((error) => {
                    closeLoading();
                    toastr.error('Error al eliminar');
                });
        }
    </script>


@stop
