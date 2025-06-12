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
    </style>
</head>
<body>
    <div class="container py-4">
        <h1 class="text-center mb-4">Clima en El Salvador</h1>
        <div class="row row-cols-1 row-cols-md-3 g-3">
            @foreach ($climas as $clima)
                <div class="col">
                    <div class="card shadow h-100">
                        <div class="card-body text-center d-flex flex-column justify-content-between">
                            <h5 class="card-title">{{ $clima['ciudad'] }}</h5>
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
</body>
</html>
