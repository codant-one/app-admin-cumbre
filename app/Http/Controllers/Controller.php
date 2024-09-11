<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *   version="1.0.0",
 *   title="APP CUMBRE PETRÓLEO, GAS Y ENERGÍA",
 *   description="<img src='https://backend.app-admin-cumbre/images/logo.svg' alt='Logo' width='30'>API oficial de la aplicación 'CUMBRE'<br><br><img src='https://codant.one/img/logos/codant.svg' alt='Logo' width='50'>Hecho por <a href='https://codant.one' target='_blank'>CODANT</a>",
 * ),
 * @OA\SecurityScheme(
 *   securityScheme="bearerAuth",
 *   in="header",
 *   name="bearerAuth",
 *   type="http",
 *   scheme="bearer",
 *   bearerFormat="JWT",
 * ),
 * @OA\Server(
 *   url=L5_SWAGGER_CONST_HOST,
 *   description="API"
 * )
 *
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
