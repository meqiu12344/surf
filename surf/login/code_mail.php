<?php

include '../config.php';

$order_id = $_GET['order_id'];

$sql = "SELECT * FROM orders WHERE id = $order_id";
$res = mysqli_query($conn, $sql);
$order = mysqli_fetch_assoc($res);

if ($res) {
    include '../mail_config.php';
    
    $mail->Subject = "Lock code for box!";
    $mail->setFrom('websitemessage24@gmail.com');
    $mail->isHTML(true);
    $mail->Body = '
        <html>
        <head>
            <style>
                .code{
                    color: red;
                    font-size: 30px;
                    font-weight: 700;
                    letter-spacing: 5px;
                }
            </style>
        </head>
        <body>
            <main>
                <h1>You can pick up your order</h1>
                <span>Your code for box nr. <b> '.$order['box_number'].' </b> is:</span>
                <br>
                <span class="code">
                    '.$order['box_code'].'
                </span>

                <br><br>
                <hr>

                <footer>
                    <br><img src=cid:photo> <br><br>
                    <div class="contact">
                        <b>ZigZag Fuerteventura</b> <br>
                        <b>Location:</b> Los lanitos 1b, La Jares Fuerteventura, 35650 <br>
                        <b>Phone:</b> +34 610 86 15 31 <br>
                        <b>Email:</b> zigzagvelas@yahoo.es <br>
                    </div>
                </footer>
            </main>
        </body>
        </html>
    ';
    $mail->addEmbeddedImage('../foto/logo.png', 'photo', 'logo.png');
    $mail->addAddress($order['email']);

    if ($mail->send()) {
        $sql_insert = "INSERT INTO `done_orders`(`box_number`, `img_name`, `first_name`, `phone`, `email`, `description`, `type`, `price`, `status`, `box_code`) VALUES ('$order[box_number]', '$order[img_name]', '$order[first_name]', $order[phone], '$order[email]', '$order[description]', '$order[type]', '$order[price]', '$order[status]', '$order[box_code]')";
        $res_insert = mysqli_query($conn, $sql_insert);

        unlink("../foto/$order[img_name]");

        $sql_delete = "DELETE FROM orders WHERE id = $order_id";
        $res_delete = mysqli_query($conn, $sql_delete);

        header("Location: ../thanks.php?check_mail");
        exit;
    }else{
        echo "Fail.";
    }
    
    $mail->smtpClose();
}
?>
