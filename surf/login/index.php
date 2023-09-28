<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZigZag</title>
    <link rel="stylesheet" href="login_css/login.css">
</head>
<body>
    <main>
        <div class="logo">
            <img src="../foto/logo.png" alt="">
        </div>
    </main>

    <hr>

    <form action="login.php" method="get">

        <?php 

            session_start();

            if(@$_SESSION['login_status'] == true){
                header("Location: panel.php");
            }

            if(isset($_GET['login_error'])){
                echo"<h3 style='color: red'>Código de empleado no válido</h3>";
            }else{
                echo"<h3>Hola. Ingrese el código de empleado</h3>";
            }

        ?>
        
        <input type="number" name="code" required min="0">
        <input type="submit" value="SUBMIT">
    </form>
</body>
</html>