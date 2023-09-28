<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="login_css/payment.css">
</head>
<body>

    <header>
        <div class="logo">
            <img src="../foto/logo.png" alt="">
        </div>
    </header>

    <hr>
    <br>

    <?php 
    
        if(isset($_GET['order_id'])){
            include'../config.php';

            $order_id = $_GET['order_id'];

            $sql = "SELECT * FROM orders WHERE id = $order_id";
            $res = mysqli_query($conn, $sql);
            $order = mysqli_fetch_assoc($res);

    ?>

    <form action="submit_payment.php" method="POST" id="paymentFrm" onsubmit="disableButton()">
        <h1>Payment form</h1>
        <span>Enter your cart date to pay for order: <?php echo $order['type']; ?> </span> <br><br>
        Price: <span style='color: red;'> <?php echo $order['price']; ?> €</span><br><br>

        <input type="number" name="price" style='display: none;' value='<?php echo $order['price']; ?>'>
        <input type="text" name="type" style='display: none;' value='<?php echo $order['type']; ?>'>
        <input type="text" name="order_id" style='display: none;' value='<?php echo $order['id']; ?>'>

        <p>
            <label>Name</label><br>
            <input type="text" name="name" size="50" />
        </p>
        <p>
            <label>Email</label><br>
            <input type="text" name="email" size="50" />
        </p>
        <p>
            <label>Card Number</label><br>
            <input type="text" name="card_num" size="20" autocomplete="off" class="card-number" />
        </p>
        <p>
            <label>CVC</label><br>
            <input type="text" name="cvc" size="4" autocomplete="off" class="card-cvc" />
        </p>
        <p>
            <label>Expiration (MM/YYYY)</label><br>
            <input type="text" name="exp_month" size="2" class="card-expiry-month"/>
            <span> / </span>
            <input type="text" name="exp_year" size="4" class="card-expiry-year"/>
        </p>
        <button type="submit" id="payBtn">Submit Payment</button>
        <br><br>
    </form>

    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript">

        Stripe.setPublishableKey('pk_live_51NUsJWC2HnOcAYtbsE7Rd0q3nkz8J0gRV3Ru0siqFX1kT6DeBNqjiKUP69dkx8B7ApiPZss0gR2b70LSwid3H7sK00JU1f9gKv');

        function stripeResponseHandler(status, response) {
            if (response.error) {
                $('#payBtn').removeAttr("disabled");
                //display the errors on the form
                $(".payment-errors").html(response.error.message);
            } else {
                var form$ = $("#paymentFrm");
                //get token id
                var token = response['id'];
                //insert the token into the form
                form$.append("<input type='hidden' name='stripeToken' value='" 
        + token + "' />");
                //submit form to the server
                form$.get(0).submit();
            }
        }
        $(document).ready(function() {
            //on form submit
            $("#paymentFrm").submit(function(event) {
                //disable the submit button to prevent repeated clicks
                $('#payBtn').attr("disabled", "disabled");
                
                //create single-use token to charge the user
                Stripe.createToken({
                    number: $('.card-number').val(),
                    cvc: $('.card-cvc').val(),
                    exp_month: $('.card-expiry-month').val(),
                    exp_year: $('.card-expiry-year').val()
                }, stripeResponseHandler);
                
                //submit from callback
                return false;
            });
        });


        function disableButton() {
            var button = document.getElementById("payBtn");
            button.disabled = true;
            button. innerHTML = "Paying...";
        }

    </script>

    <?php 
    
        }else{
            echo"<h1 style='color: red'>ERROR :(</h1>";
        }

    ?>
</body>
</html>