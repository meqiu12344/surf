    <?php
        include'config.php';

        $order_id = $_GET['order_id'];

        echo $order_id;

        $sql = "SELECT * FROM orders WHERE id = $order_id";
        $res = mysqli_query($conn, $sql);
        $order = mysqli_fetch_assoc($res);

        require("PHPMailer/src/PHPMailer.php");
        require("PHPMailer/src/SMTP.php");
        require("PHPMailer/src/Exception.php");

        $mail = new PHPMailer\PHPMailer\PHPMailer();

        $mail->IsSMTP();
        $mail->CharSet = "UTF-8";
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 465 ; 
        $mail->SMTPSecure = 'ssl';
        $mail->SMTPAuth = true;

        $mail->Username = "websitemessage24@gmail.com";
        $mail->Password = "tbiztklvdhzupnmk";
        $mail->Subject = "Nowa wiadomość ze strony!";
        $mail->setFrom('websitemessage24@gmail.com', 'Antosiowe miody');
        $mail->isHTML(true);
        $mail->Body = '
            <html>
            <head>
                <style>
                    .link{
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
                    <h1>New order</h1>
                    <span>
                        User '. $order['first_name'] .' (<a href="mailto:'.$order['email'].'">'.$order['email'].'</a>) order '. $order['type'] .'
                    </span>
                    <br><br><br>
                    <a href="https://www.zigzagfuerteventura.com/surf/login/" class="link" style="color: white"> Check new order </a>
                </main>
            </body>
            </html>
        ';

        $mail->addAddress('meqiu06@gmail.com');

        if ( !$mail->send() ) {		
            echo 'Some error... / Jakiś błąd...';
            echo 'Mailer Error: ' . $mail->ErrorInfo;	
            exit;
        }

        if ( $mail->send() ) {	
            header("Location: thanks.php");
        }

        $mail->smtpClose();

    ?>