<?php
    $cn = new PDO('mysql:host=localhost;dbname=catalogo',"root","");
    if(isset($_POST["action"])) 
    {

        if($_POST["action"] == "Vista") 
        {

        $tabla_productos = '';
        $tabla_productos = '
        <table class="table table-bordered">
            <tr>
            <th width="40%">Producto</th>
            <th width="40%">Descripcion</th>
            <th width="40%">Precio</th>
            <th width="40%">Imagen</th>
            <th width="10%">Update</th>
            <th width="10%">Delete</th>
            </tr>
        ';


        $statement = $cn->prepare("call sp_Vista()");
        $statement->execute();
        $result = $statement->fetchAll();

        
        if($result)
        {
            foreach($result as $row)
            {
                $tabla_productos .= '
                <tr>
                <td>'.$row["Nombre"].'</td>
                <td>'.$row["Descripcion"].'</td>
                <td>'.$row["Precio"].'</td>
                <td>'.$row["Imagen"].'</td>
                <td><button type="button" id="'.$row["Nro"].'" class="btn btn-warning btn-xs update">Actualizar</button></td>
                <td><button type="button" id="'.$row["Nro"].'" class="btn btn-danger btn-xs delete">Eliminar</button></td>
                </tr>
                ';
            }
        }
        else
        {
        $tabla_productos .= '
            <tr>
            <td align="center">No existen registros en la Tabla Productos</td>
            </tr>
        ';
        }

        
        $tabla_productos .= '</table>';
        echo $tabla_productos;
        }
    }
    if($_POST["action"] == "Crear")
    {
        $statement =$cn->prepare("call sp_Crear(:dato1, :dato2, :dato3, :dato4)");
        $statement->bindParam(':dato1', $_POST["Nom"]);
        $statement->bindParam(':dato2', $_POST["Des"]);
        $statement->bindParam(':dato3', $_POST["Precio"]);
        $statement->bindParam(':dato4', $_POST["Imagen"]);
        $result = $statement->execute();
    
    if($result)
    {
        echo 'Registro Guardado';
    }
    }
    if($_POST["action"] == "Buscar")
    {
        $registroproducto = array();
        $statement =$cn->prepare("call sp_buscar(:dato1)");
        $statement->bindParam(':dato1', $_POST["Num"]);
        $statement->execute();
        $result = $statement->fetchAll();
        foreach($result as $row){
            $registroproducto["Nom"] = $row["Nombre"];
            $registroproducto["Des"] = $row["Descripcion"];
            $registroproducto["Precio"] = $row["Precio"];
            $registroproducto["Imagen"] = $row["Imagen"];
        }
        echo json_encode($registroproducto);
    }
    if($_POST["action"] == "Update")
    {
        $statement =$cn->prepare("call sp_Actualizar(:dato1, :dato2, :dato3, :dato4, :dato5)");
        $statement->bindParam(':dato1', $_POST["Num"]);
        $statement->bindParam(':dato2', $_POST["Nom"]);
        $statement->bindParam(':dato3', $_POST["Des"]);
        $statement->bindParam(':dato4', $_POST["Precio"]);
        $statement->bindParam(':dato5', $_POST["Imagen"]);
        $result = $statement->execute();
    
        if($result)
        {
            echo 'Registro Actualizado';
        }
    }
    if($_POST["action"] == "Delete")
    {
        $statement =$cn->prepare("call sp_Eliminar(:dato1)");
        $statement->bindParam(':dato1', $_POST["Num"]);
        $statement->execute();
    
        if(!empty($result))
        {
            echo 'Registro eELIMINADO';
        }
    }
?>