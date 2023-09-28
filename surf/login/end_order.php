<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set code</title>
    <link rel="stylesheet" href="login_css/login.css">
</head>
<body>
    <main>
        <div class="logo">
            <img src="../foto/logo.png" alt="">
        </div>
    </main>

    <hr>

    <form action="pay_mail.php" method='GET'>
        <h1>Entry code for box</h1>
        <input type="text" name="price" style='display: none;' value='<?php echo $_GET['price']; ?>'>
        <input type="text" name="order_id" style='display: none;' value='<?php echo $_GET['order_id']; ?>'>
        <input type="number" name="code" min='1000' max='9999'>
        <input type="submit" value="SUBMIT">
    </form>

</body>
</html>