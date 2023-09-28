<?php

    include'../config.php';

    $order_id = $_GET['order_id'];
    $code = $_GET['code'];

    $sql = "DELETE FROM `orders` WHERE id = $order_id";
    $res = mysqli_query($conn, $sql);

        if($res){
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
                    </style>
                </head>
                <body>
                    <main>
                        <br>
                        <h2>Your order is ready to pick up.</h2>
                        <br>
                        <span>Code for the box is: </span>
                        <br>
                        <span class="code"> '. $code .' </span>
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

            $mail->addAddress('meqiu06@gmail.com');
            
            if ( $mail->send() ) {			
                header("Location: panel.php");
            }

            $mail->smtpClose();
        }

    ?>