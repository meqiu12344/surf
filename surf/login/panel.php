<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="login_css/panel.css">

    <script>
        window.onload = function() {
            // Pobierz element input daty
            var inputDate = document.getElementById("myDateInput");

            // Ustaw bieżącą datę jako minimalną datę dla pola input
            var currentDate = new Date().toISOString().split("T")[0];
            inputDate.setAttribute("min", currentDate);
        };
    </script>
</head>
<body>

    <?php 
    
        if(!$_SESSION['login_status']){
            header("Location: index.php");
        }

    ?>

    <header>
        <main>
            <div class="user_info">
                <span>
                    <?php 
                        if(isset($_GET['waiting'])){
                            echo "<a href='panel.php' class='link-header'>Orders</a>";
                        }else{
                            echo"<a href='panel.php?waiting' class='link-header'>Waiting for <br> payment</a>";
                        }
                    ?>

                </span>
            </div>
            <div class="logo">
                <img src="../foto/logo.png" alt="Surf logo">
            </div>
            <div class="logout">
                <a href="logout.php">Log out</a>
            </div>
        </main>
    </header>

    <br><br><br>

    <?php 
    
        if(isset($_GET['waiting'])){
            $sql = "SELECT * FROM `orders` WHERE status = 1 ORDER BY `orders`.`id` DESC";
            echo"<h1> Orders waiting for payment </h1>";
        }else{
            $sql = "SELECT * FROM `orders` WHERE status <> 1 ORDER BY `orders`.`id` DESC";
            echo"<h1> Orders </h1><br>";
        }

    ?>
                        
    <main class='row'>
        <?php 

            include'../config.php';

            $res = mysqli_query($conn, $sql);

            $many = mysqli_num_rows($res);

            if($many == 0){
                echo"<h3 style='color: red; text-align: center;'>There is no new orders</h3>";
            }else{
                while($order = mysqli_fetch_assoc($res)){
                    echo"<div class='column'>";
                        echo"<form action='end_order.php' method='GET'>";
                            echo"<input type='text' style='display: none;' name='order_id' value='$order[id]'>";
    
                            echo"<span> <b> Order id: </b>". $order['id'] ." <span style='float: right; ";  if(isset($_GET['waiting'])){ echo "display: none;"; }  echo"'> <input type='submit' value='End order' class='end_order'> </span></span>";
                            echo"<br><br> <span> <b>Box id: </b>" . $order['box_number']."</span>";
                            echo"<br><br> <span> <b>Photo: </b><a style='font-size: 15px; font-weight: 500;' href='../foto/$order[img_name]'> See photo </a></span>";
                            echo"<br><br> <span> <b>Type: </b>". $order['type'] ."</span>";
                            echo"<br><br> <span> <b>Client name: </b>". $order['first_name'] ."</span>";
                            echo"<br><br> <span> <b>Phone: </b>". $order['phone'] ."</span>";
                            echo"<br><br> <span> <b>Email: </b><a href='mailto:".$order['email']."' class='mail-link'>". $order['email'] ."</a></span>";
                            echo"<br><br> <span> <b>Description: </b><br>". $order['description'] ."</span>";
                            echo"<br><br><br> <span> € <input type='number' name='price' min='0' class='price'"; if(isset($_GET['waiting'])){ echo "value=$order[price]"; } echo" placeholder='Price' required> </span>";
                            
                        echo"</form>";
                        echo"<br><br>";
                        echo"<div class='display: flex; justify-content: space-between;'>";
                            if($order['deliver_date'] == null){
                                echo"<form action='' method='post'>";
                                    echo"<span><b>Set delivery date: </b></span><br>";
                                    echo"<input type='text' style='display: none;' value='$order[id]' name='order_id'>";
                                    echo"<input type='date' name='date' id='myDateInput' required>";
                                    echo"<input type='submit' class='set-date-submit' value='Set Date'>";
                                echo"</form>";
                            }else{
                                echo"<span> <b>Delivery date:</b> $order[deliver_date] </span>";
                            }
                        echo"</div>";    
                    echo"</div>";
                }
            }
        ?>
    </main>

    <?php 
    
            if(isset($_POST['date']) && isset($_POST['order_id'])){
                $update_sql = "UPDATE `orders` SET `deliver_date`='$_POST[date]' WHERE id = '$_POST[order_id]'";
                $update_res = mysqli_query($conn, $update_sql);
                header("Location: panel.php");
            }

    ?>
</body>
</html>