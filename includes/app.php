<?php 

require 'funciones.php';
require 'database.php';
require __DIR__ . '/../vendor/autoload.php';
define('BASE_URL', 'vendor/almasaeed2010/adminlte/');

// Conectarnos a la base de datos
use Model\ActiveRecord;
ActiveRecord::setDB($db);