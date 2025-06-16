<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        /*
        * se excluyen temporalmente las rutas de eventos para evitar problemas con CSRF
        * en el desarrollo, se recomienda habilitar CSRF en producción.
        */
        '/admin/login', 
        '/admin/eventos/nuevo-evento',
        '/admin/eventos/editar/*',
        '/admin/eventos/eliminar/*'
    
    ];
}
