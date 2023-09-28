<?php 

    include'config.php';

    $box_id     = $_POST['box_id'];
    $name       = $_POST['name'];
    $email      = $_POST['email'];
    $phone      = $_POST['tel'];

    $FileName   = $_FILES['photo']['name'];
    $TmpName    = $_FILES['photo']['tmp_name'];

    $service    = $_POST['service'];
    $message    = $_POST['message'];

    move_uploaded_file($TmpName,'foto/'.$FileName);

    $sql_insert = "INSERT INTO `orders`(`box_number`, `img_name`, `first_name`, `phone`, `email`, `description`, `type`) VALUES ('$box_id', '$FileName' , '$name', '$phone', '$email', '$message', '$service')";
    $res_insert = mysqli_query($conn, $sql_insert);

    $sql = "SELECT * FROM orders ORDER BY id DESC LIMIT 1";
    $res = mysqli_query($conn, $sql);
    $order = mysqli_fetch_assoc($res);

    if($res_insert){
        header("Location: send_mail.php?order_id=$order[id]");
    }else{
        header("Location: index.php?error=something_wrong&box_id=$box_id");
    }