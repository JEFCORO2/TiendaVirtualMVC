<?php 

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\TiendaController;
use Controllers\HomeController;
use Controllers\LoginController;

$router = new Router();

//INICIAR SESION
$router->get('/', [HomeController::class, 'listar']);
$router->get('/login', [LoginController::class, 'login']);
$router->post('/iniciar', [LoginController::class, 'store']);

$router->get('/contacto', [HomeController::class, 'contacto']);
$router->get('/tienda', [TiendaController::class, 'listar']);
$router->get('/tienda/producto', [TiendaController::class, 'producto']);
$router->get('/tienda/deseo', [TiendaController::class, 'deseo']);

$router->get('/about', [LoginController::class, 'about']);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();

