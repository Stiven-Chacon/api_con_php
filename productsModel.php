<?php

class productsModel{
    //Metodo de conexion en la base de datos
    public $conexion;
    public function  __construct()
    {
        $this->conexion = new mysqli('localhost', 'root', '', 'api');
        mysqli_set_charset($this->conexion, 'utf8');
    }

    //Consulta de Todos los productos de la base de datos
    public function getProductos($id=null){
        $where = ($id == null) ?"" : " WHERE id =$id";
        $Productos=[];
        $sql='SELECT * FROM productos '.$where;
        $registros = mysqli_query($this->conexion, $sql);
        while ($row = mysqli_fetch_assoc($registros)){
            array_push($Productos,$row);
        }
        return $Productos;
    }

    //Metodo POST para guarda los productos 
    public function SaveProductos($nombre, $descripcion, $precio){
        $valida = $this->ValidateProductos($nombre, $descripcion, $precio);
        $resultado=['error', 'Producto Ya Existe'];
        if (count($valida)==0) {
            $sql="INSERT INTO productos(nombre,descripcion,precio) VALUES('$nombre', '$descripcion','$precio')";
            mysqli_query($this->conexion, $sql);
            $resultado=['success', 'Producto Agregado Correctamente'];
        }
        return $resultado;
    }
    //Metodo PUT para Actualizar los productos 
    public function UpdateProducto($id,$nombre, $descripcion, $precio){
        $existe = $this->getProductos($id);
        $resultado=['error','No existe Producto'];
        if (count($existe)>0) {
            $valida = $this->ValidateProductos($nombre, $descripcion, $precio);
            $resultado=['error', 'Producto Ya Existe con las mismas caracterisicas'];
            if (count($valida)==0) {
                $sql="UPDATE productos SET nombre='$nombre', descripcion='$descripcion', precio='$precio' WHERE id='$id'";
                mysqli_query($this->conexion, $sql);
                $resultado=['success', 'Producto Actualizado Correctamente'];
            }
        } 
        return $resultado;
    }

    //Metodo para eliminar el producto
    public function deleteProducto($id){
        //validamos si existe el producto
        $valida = $this->getProductos($id);
        $resultado=['error', 'Producto No Existe'];
        if (count($valida)>0) {
            $sql="DELETE FROM productos WHERE id='$id'";
            mysqli_query($this->conexion, $sql);
            $resultado=['success', 'Producto Eliminado Correctamente'];
        }
        return $resultado;
    }

        //Consulta de Todos los productos de la base de datos
        public function ValidateProductos($nombre, $descripcion, $precio){
            $Productos=[];
            $sql="SELECT * FROM productos WHERE nombre='$nombre' AND descripcion='$descripcion' AND precio='$precio'";
            $registros = mysqli_query($this->conexion, $sql);
            while ($row = mysqli_fetch_assoc($registros)){
                array_push($Productos,$row);
            }
            return $Productos;
        }
    
}

?>