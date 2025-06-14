@extends('backend.menus.superior')

@section('content-admin-css')
<link href="{{ asset('css/adminlte.min.css') }}" type="text/css" rel="stylesheet" />
<link href="{{ asset('css/dataTables.bootstrap4.css') }}" type="text/css" rel="stylesheet" />
<link href="{{ asset('css/toastr.min.css') }}" type="text/css" rel="stylesheet" />
<link href="{{ asset('css/responsive.bootstrap4.min.css') }}" type="text/css" rel="stylesheet" />
<link href="{{ asset('css/buttons.bootstrap4.min.css') }}" type="text/css" rel="stylesheet" />
<link href="{{ asset('css/estiloToggle.css') }}" type="text/css" rel="stylesheet" />
<link href="{{ asset('css/buttons_estilo.css') }}" rel="stylesheet">
<!-- Asegurar Bootstrap 4 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
@stop

<style>
    table {
        /*Ajustar tablas*/
        table-layout: fixed;
    }
    
    .fancy-btn {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        background: linear-gradient(45deg, #007bff, #0056b3);
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .fancy-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,123,255,0.3);
        color: white;
    }
    
    .weather-icon {
        width: 64px;
        height: 64px;
    }
    
    .arrow {
        margin-left: 5px;
    }
</style>

<div id="divcontenedor" style="display: none">
    <div class="container py-4">
        <h1 class="titulo-clima">Clima en El Salvador</h1>
        <div class="row">
            @foreach ($climas as $clima)
            <div class="col-md-4 col-sm-6 col-12 mb-3">
                <div class="card shadow h-100">
                    <div class="card-body text-center d-flex flex-column justify-content-between">
                        <button
                            type="button"
                            class="fancy-btn weather-btn"
                            data-toggle="modal"
                            data-target="#weatherModal"
                            data-ciudad="{{ $clima['ciudad'] }}"
                            @if($clima['data'])
                            data-temp="{{ $clima['data']['current']['temp_c'] }}"
                            data-condicion="{{ ucfirst($clima['data']['current']['condition']['text']) }}"
                            data-humedad="{{ $clima['data']['current']['humidity'] }}"
                            data-viento="{{ $clima['data']['current']['wind_kph'] }}"
                            data-icono="https:{{ $clima['data']['current']['condition']['icon'] }}"
                            @endif>
                            {{ $clima['ciudad'] }}
                            <span class="arrow">➤</span>
                        </button>

                        @if ($clima['data'])
                        <img src="https:{{ $clima['data']['current']['condition']['icon'] }}" alt="Icono clima" class="weather-icon mx-auto d-block">
                        <p class="card-text">🌡️ {{ $clima['data']['current']['temp_c'] }} °C</p>
                        <p>🌥️ {{ ucfirst($clima['data']['current']['condition']['text']) }}</p>
                        <p>💧 {{ $clima['data']['current']['humidity'] }}% humedad</p>
                        <p>💨 {{ $clima['data']['current']['wind_kph'] }} km/h viento</p>
                        @else
                        <p class="text-danger">Error: {{ $clima['error'] ?? 'No disponible' }}</p>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    
    <!-- Modal Bootstrap 4 -->
    <div class="modal fade" id="weatherModal" tabindex="-1" role="dialog" aria-labelledby="weatherModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="weatherModalLabel">Detalles del Clima</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img id="modal-icon" src="" alt="Icono clima" style="width:100px; height:100px; margin-bottom: 1rem;">
                    <h3 id="modal-city"></h3>
                    <p id="modal-temp" class="h5"></p>
                    <p id="modal-condicion"></p>
                    <p id="modal-humedad"></p>
                    <p id="modal-viento"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
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

<!-- Asegurar jQuery y Bootstrap 4 JavaScript -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        // Mostrar el contenedor
        document.getElementById("divcontenedor").style.display = "block";
        
        // Verificar si jQuery está cargado
        if (typeof jQuery === 'undefined') {
            console.error('jQuery no está cargado');
        } else {
            console.log('jQuery cargado correctamente - versión:', jQuery.fn.jquery);
        }
        
        // Verificar si Bootstrap está cargado
        if (typeof $.fn.modal === 'undefined') {
            console.error('Bootstrap JavaScript no está cargado');
        } else {
            console.log('Bootstrap modal cargado correctamente');
        }
        
        // Configurar el modal
        $('#weatherModal').on('show.bs.modal', function (event) {
            console.log('Modal show.bs.modal disparado');
            
            var button = $(event.relatedTarget); // Botón que disparó el modal
            
            if (button.length === 0) {
                console.error('No se encontró el botón que disparó el modal');
                return;
            }
            
            // Obtener datos del botón
            var ciudad = button.data('ciudad') || 'Ciudad no disponible';
            var temp = button.data('temp') || 'N/A';
            var condicion = button.data('condicion') || 'N/A';
            var humedad = button.data('humedad') || 'N/A';
            var viento = button.data('viento') || 'N/A';
            var icono = button.data('icono') || '';
            
            console.log('Datos obtenidos:', {
                ciudad: ciudad,
                temp: temp,
                condicion: condicion,
                humedad: humedad,
                viento: viento,
                icono: icono
            });
            
            // Actualizar el contenido del modal
            var modal = $(this);
            modal.find('#modal-city').text(ciudad);
            modal.find('#modal-temp').text('🌡️ Temperatura: ' + temp + ' °C');
            modal.find('#modal-condicion').text('🌥️ Condición: ' + condicion);
            modal.find('#modal-humedad').text('💧 Humedad: ' + humedad + '%');
            modal.find('#modal-viento').text('💨 Viento: ' + viento + ' km/h');
            
            if (icono) {
                modal.find('#modal-icon').attr('src', icono).show();
            } else {
                modal.find('#modal-icon').hide();
            }
        });
        
        // Eventos adicionales para debugging
        $('#weatherModal').on('shown.bs.modal', function () {
            console.log('Modal mostrado correctamente');
        });
        
        $('#weatherModal').on('hide.bs.modal', function () {
            console.log('Modal ocultándose');
        });
        
        $('#weatherModal').on('hidden.bs.modal', function () {
            console.log('Modal ocultado completamente');
        });
        
        // Manejo manual de botones de cerrar (fallback)
        $(document).on('click', '[data-dismiss="modal"]', function() {
            console.log('Botón de cerrar clickeado');
            $('#weatherModal').modal('hide');
        });
        
        // Cerrar modal al hacer click fuera
        $('#weatherModal').on('click', function(e) {
            if (e.target === this) {
                console.log('Click fuera del modal');
                $(this).modal('hide');
            }
        });
        
        // Cerrar modal con tecla ESC
        $(document).on('keydown', function(e) {
            if (e.keyCode === 27 && $('#weatherModal').hasClass('show')) {
                console.log('Tecla ESC presionada');
                $('#weatherModal').modal('hide');
            }
        });
        
        // Test manual para verificar que el modal funciona
        window.testModal = function() {
            console.log('Probando modal manualmente...');
            $('#weatherModal').modal('show');
        };
        
        console.log('Scripts del modal inicializados correctamente');
        console.log('Para probar el modal manualmente, ejecuta: testModal() en la consola');
    });
</script>

@stop