<?php

include '../config.php';

$order_id = $_GET['order_id'];
$code = $_GET['code'];
$price = $_GET['price'];

$sql = "SELECT * FROM orders WHERE id=$order_id";
$res = mysqli_query($conn, $sql);
$order = mysqli_fetch_assoc($res);

$sql_price = "UPDATE `orders` SET `price`=$price, `status`=1, `box_code`=$code WHERE id=$order_id";
$res_price = mysqli_query($conn, $sql_price);

if ($res_price) {
    require("../PHPMailer/src/PHPMailer.php");
    require("../PHPMailer/src/SMTP.php");
    require("../PHPMailer/src/Exception.php");

    $mail = new PHPMailer\PHPMailer\PHPMailer();

    $mail->IsSMTP();
    $mail->CharSet = "UTF-8";
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 465 ; 
    $mail->SMTPSecure = 'ssl';
    $mail->SMTPAuth = true;

    $mail->Username = "websitemessage24@gmail.com";
    $mail->Password = "tbiztklvdhzupnmk";
    $mail->Subject = "Payment for repair | ZigZag";
    $mail->setFrom('websitemessage24@gmail.com', 'ZigZag');
    $mail->isHTML(true);

    $mail->Body = '
        <html>
        <head>
            <style>
                main{
                    width: 50%;
                    margin: 0 auto;
                }
                h2{
                    margin: 0;
                }
                img{
                    width: 100px;
                    height: auto;
                    margin-right: 10px;
                }
                .code{
                    letter-spacing: 15px;
                    font-size: 20px;
                    color: red;
                }

                .payment-link{
                    padding: 10px;
                    border: 2px solid red;
                    background-color: red;
                    text-decoration: none;

                    font-size: 15px;
                    font-weight: 700;
                }
            </style>
        </head>
        <body>
            <main>
                <h1>Your order is ready</h1>
                <span>
                    The box`s lock code will be sent to you after you have paid.
                </span>
                <br><br><br>
                <a href="http://mmaniak.murphy.webd.pl/surf/login/payment.php?order_id='.$order_id.'" class="payment-link" style="color: white;">Payment link</a>
                <br><br>

                <br>
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
        header("Location: panel.php");
        exit;
    }else{
        echo "Fail.";
    }
    
    $mail->smtpClose();
}
?>
