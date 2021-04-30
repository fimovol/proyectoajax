<?php
$cn = new PDO('mysql:host=localhost;dbname=catalogo',"root","");

if($_POST["Action"] == "crear"){
    $nombre=$_POST["Nom"];
    $edad=$_POST["Edad"];
    $carrera=$_POST["Carrera"];
    $statement =$cn->prepare("call crearcliente(:dato1, :dato2, :dato3)");
    $statement->bindParam(':dato1', $_POST["Nom"]);
    $statement->bindParam(':dato2', $_POST["Edad"]);
    $statement->bindParam(':dato3', $_POST["Carrera"]);
    
    $result = $statement->execute();
    echo "fijate en la base de datos ave si se guardo el dato";
}


if($_POST["Action"] == "vista"){
    $statement = $cn->prepare("call verclientes()");
    $statement->execute();
    $result = $statement->fetchAll();
    $clientes ="";
    if($result)
        {
            foreach($result as $row)
            {
                $clientes.= '<div class="bloque">
                te llamas '.$row["nombre"].' tienes '.$row["edad"].' años y estas en la carrera de '.$row["catalogo"].'
                <button class="btn btn-primary deletecliente" id="'.$row["id"].'">eliminar</button>
                </div>'
                ;
            }
        }
    else
    {
        $clientes= 'No existen registros en la Tabla Productos';
    }
        echo $clientes;
}
if($_POST["Action"] == "delete"){
    $statement =$cn->prepare("call eliminarcliente(:dato1)");
    $statement->bindParam(':dato1', $_POST["Num"]);
    $statement->execute();

    if(!empty($result))
    {
        echo 'Registro eELIMINADO';
    }
}
?>