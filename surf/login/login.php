<?php

    session_start();

    include'../config.php';

    $code = $_GET['code'];

    $sql = "SELECT * FROM `employees` WHERE code = $code";
    $res = mysqli_query($conn, $sql);

    $many = mysqli_num_rows($res);

    if($many == 1){
        while($user = mysqli_fetch_assoc($res)){
            
            $_SESSION['login_status'] = true;
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['permisions'] = $user['permisions'];

            header("Location: panel.php");

        }
    }else{
        # header("Location: index.php?login_error"); 
    }