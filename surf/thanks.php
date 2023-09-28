<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanks</title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/thanks.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="foto/logo.png" alt="">
        </div>
    </header>

    <hr>
    <br>

    
    <?php 
    
        if(isset($_GET['check_mail'])){
            echo"<h1>Thanks for pay :)</h1>";
            echo"<span> Now please check your mail to get code for box. </span> <br>";
        }else{
            echo"<h1>Thanks for order :)</h1>";
        }
    
    ?>
    <a href="https://www.zigzagfuerteventura.com/">Go to home page</a>
</body>
</html>