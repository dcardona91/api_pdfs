<?php
session_start();
date_default_timezone_set('America/Bogota');
require_once __DIR__ . '/../vendor/autoload.php';
use \ThisApp\Core\Router;
use \Illuminate\Http\Request;
new Router(Request::capture());