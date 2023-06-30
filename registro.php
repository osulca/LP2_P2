<h1>Registro de usuarios</h1>
<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
    <input type="text" name="nombre" placeholder="Ingrese nombre"><br>
    <input type="text" name="email" placeholder="Ingrese email"><br>
    <input type="password" name="password" placeholder="Ingrese password"><br>
    <input type="password" name="password_confirm" placeholder="repita password"><br>
    <input type="submit" value="Guardar"><br>
</form>
<?php
    if(!empty($_POST)){
        $nombre = trim($_POST["nombre"]);
        $email = trim($_POST["email"]);
        $password = trim($_POST["password"]);
        $password_confirm = trim($_POST["password_confirm"]);
        $errores = 0;
        
        if($password!=$password_confirm){
            echo "<p>las contraseñas no coinciden</p>";
            $errores++;
        }

        if(strlen($password)<8){
            echo "<p>la contraseña debe tener al menos 8 caracteres</p>";
            $errores++;
        }

        $patron_email = "/^\\S+@\\S+\\.\\S+$/";
        if(preg_match($patron_email, $email)==0){
            echo "<p>el email no es correcto</p>";
            $errores++;
        }

        if($errores==0){            
            try {
                require_once "controladores/UsuarioController.php";
                $uc = new UsuarioController();
                $resultado = $uc->guardar($nombre, $email, $password);

                if($resultado!=0){
                    header("location: index.php");
                }else{
                    echo "Error: no se registró";
                }   
            }catch(Error $e){
                echo "<div style='color:red'>".$e->getMessage()."</div>";
            }catch(Exception $ex){
                echo "<div style='color:red'>ha ocurrido una excepcion</div>";
            }          
        }
    }
?>