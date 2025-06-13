<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Weather</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/869/869869.png" type="image/png">
    <style>
        body {
            background-color: #f0f8ff;
        }
        .card {
            min-height: 300px;
            padding: 0.75rem;
        }
        .weather-icon {
            width: 75px;
            height: 75px;
            object-fit: contain;
            margin-bottom: 0.5rem;
        }
        .card-title {
            font-size: 1.1rem;
            margin-bottom: 0.75rem;
        }
        .card-text, .card p {
            font-size: 0.9rem;
            margin: 0.25rem 0;
        }

        .fancy-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(to right, #fca311, #ff8c00);
            border: none;
            color: white;
            padding: 0.4rem 0.8rem;
            font-size: 0.85rem;
            font-weight: bold;
            border-radius: 9px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            cursor: pointer;
            width: 100%;
            text-align: center;
            gap: 0.5rem;
        }

        .fancy-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
        }

        .fancy-btn .arrow {
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            padding: 0.3rem;
            margin-left: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .titulo-clima {
            display: inline-block;
            padding: 0.5rem 1rem;
            background: linear-gradient(to right, #fca311, #ff8c00);
            color: white;
            font-size: 1.5rem;
            font-weight: bold;
            border-radius: 9px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
            margin-bottom: 2rem;
        }

        .titulo-clima {
            display: block;
            width: fit-content;
            margin: 0 auto 2rem;
        }

    </style>
</head>
<body>
    <div class="container py-4">
        <h1 class="titulo-clima">Clima en El Salvador</h1>
        <div class="row row-cols-1 row-cols-md-3 g-3">
            @foreach ($climas as $clima)
                <div class="col">
                    <div class="card shadow h-100">
                        <div class="card-body text-center d-flex flex-column justify-content-between">
                        <button 
                            type="button"
                            class="fancy-btn"
                            data-bs-toggle="modal"
                            data-bs-target="#weatherModal"
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
    <!-- Modal Bootstrap -->
<div class="modal fade" id="weatherModal" tabindex="-1" aria-labelledby="weatherModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="weatherModalLabel">Detalles del Clima</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body text-center">
        <img id="modal-icon" src="" alt="Icono clima" style="width:100px; height:100px; margin-bottom: 1rem;">
        <h3 id="modal-city"></h3>
        <p id="modal-temp" class="fs-5"></p>
        <p id="modal-condicion"></p>
        <p id="modal-humedad"></p>
        <p id="modal-viento"></p>
      </div>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const weatherModal = document.getElementById('weatherModal');
    weatherModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget; // Elemento que disparó el modal

        // Obtener datos
        const ciudad = button.getAttribute('data-ciudad');
        const temp = button.getAttribute('data-temp');
        const condicion = button.getAttribute('data-condicion');
        const humedad = button.getAttribute('data-humedad');
        const viento = button.getAttribute('data-viento');
        const icono = button.getAttribute('data-icono');

        // Actualizar contenido modal
        weatherModal.querySelector('#modal-city').textContent = ciudad;
        weatherModal.querySelector('#modal-temp').textContent = `🌡️ Temperatura: ${temp} °C`;
        weatherModal.querySelector('#modal-condicion').textContent = `🌥️ Condición: ${condicion}`;
        weatherModal.querySelector('#modal-humedad').textContent = `💧 Humedad: ${humedad}%`;
        weatherModal.querySelector('#modal-viento').textContent = `💨 Viento: ${viento} km/h`;
        weatherModal.querySelector('#modal-icon').src = icono;
    });
</script>

</body>
</html>
