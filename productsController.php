<?php
//Encabezado para definir que metodos vamos a subir, siempre y cuando si lo subimos a un hosting
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
header('Allow: GET, POST, OPTIONS, PUT, DELETE');
header('Content-Type: application/json; charset=utf-8');
header('Content-Type: application/json; charset=UTF-8');
require 'productsModel.php';
$productsModel = new productsModel();
//Esto es para indicar que el servidor va recibir una solicitud
switch($_SERVER['REQUEST_METHOD']){

    case 'GET':
        $respuesta = $productsModel->getProductos();
        echo json_encode($respuesta);
    break;

    case 'POST':
        $_POST = json_decode(file_get_contents('php://input', true));
        //validamos que no se envien vacios
        if(!isset($_POST->nombre) || is_null($_POST->nombre) || empty(trim($_POST->nombre)) || strlen($_POST->nombre) >80){
            $respuesta = ['status' => 'error', 'message' => 'El nombre del producto no debe ir vacío y no debe tener mas de 80 caracteres'];
        }
        else  if(!isset($_POST->descripcion) || is_null($_POST->descripcion) || empty(trim($_POST->descripcion)) || strlen($_POST->descripcion) >100){
            $respuesta = ['status' => 'error', 'message' => 'La descripcion del producto no debe ir vacio  y no debe tener mas de 100 caracteres'];

        }
        else  if(!isset($_POST->precio) || is_null($_POST->precio) || empty(trim($_POST->precio)) || !is_numeric(($_POST->precio)) || strlen($_POST->precio) >10){
            $respuesta = ['status' => 'error', 'message' => 'El Precio del producto no debe ir vacio debe ser de tipo numerico y no debe tener mas de 10 caracteres'];

        }
        else{
            $respuesta = $productsModel -> SaveProductos($_POST->nombre,$_POST->descripcion,$_POST->precio);
        }
        echo json_encode($respuesta);
    break;

    case 'PUT':
        $_PUT = json_decode(file_get_contents('php://input', true));
        //validamos que no se envien vacios
        if(!isset($_PUT->id) || is_null($_PUT->id) || empty(trim($_PUT->id))){
            $respuesta = ['status' => 'error', 'message' => 'El id del producto no debe ir vacío'];
        }
        else if(!isset($_PUT->nombre) || is_null($_PUT->nombre) || empty(trim($_PUT->nombre)) || strlen($_PUT->nombre) >80){
            $respuesta = ['status' => 'error', 'message' => 'El nombre del producto no debe ir vacío y no debe tener mas de 80 caracteres'];
        }
        else  if(!isset($_PUT->descripcion) || is_null($_PUT->descripcion) || empty(trim($_PUT->descripcion)) || strlen($_PUT->descripcion) >100){
            $respuesta = ['status' => 'error', 'message' => 'La descripcion del producto no debe ir vacio y no debe tener mas de 100 caracteres'];

        }
        else  if(!isset($_PUT->precio) || is_null($_PUT->precio) || empty(trim($_PUT->precio)) || !is_numeric(($_PUT->precio)) || strlen($_PUT->precio) >10){
            $respuesta = ['status' => 'error', 'message' => 'El Precio del producto no debe ir vacio debe ser de tipo numerico y no debe tener mas de 10 caracteres'];

        }
        else{
            $respuesta = $productsModel -> UpdateProducto($_PUT->id,$_PUT->nombre,$_PUT->descripcion,$_PUT->precio);
        }
        echo json_encode($respuesta);
    break;

    case 'DELETE':
        $_DELETE = json_decode(file_get_contents('php://input', true));
        if(!isset($_DELETE->id) || is_null($_DELETE->id) || empty(trim($_DELETE->id))){
            $respuesta = ['status' => 'error', 'message' => 'El id del producto no debe ir vacío'];
        }
        else{
            $respuesta = $productsModel -> deleteProducto($_DELETE->id);
        }
        echo json_encode($respuesta);
    break;
}

?>