<?php 

    session_start();
    
    $_SESSION['login_status'] = false;
    session_destroy();

    header("Location: index.php");