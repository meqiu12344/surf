<?php 
//check whether stripe token is not empty
if(!empty($_POST['stripeToken'])){
    //get token, card and user info from the form
    $type = $_POST['type'];
    $token = $_POST['stripeToken'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $price = $_POST['price'];
    $card_num = $_POST['card_num'];
    $card_cvc = $_POST['cvc'];
    $card_exp_month = $_POST['exp_month'];
    $card_exp_year = $_POST['exp_year'];
    
    //include Stripe PHP library
    require_once('payment_config/stripe-php/init.php');
    
    //set api key
    $stripe = array(
      "secret_key"      => "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",
      "publishable_key" => "pk_live_51NUsJWC2HnOcAYtbsE7Rd0q3nkz8J0gRV3Ru0siqFX1kT6DeBNqjiKUP69dkx8B7ApiPZss0gR2b70LSwid3H7sK00JU1f9gKv"
    );
    
    \Stripe\Stripe::setApiKey($stripe['secret_key']);
    
    //add customer to stripe
    $customer = \Stripe\Customer::create(array(
        'email' => $email,
        'source'  => $token
    ));
    
    //item information
    $itemName = $type;
    $itemNumber = "PS123456";
    $itemPrice = $price*100;
    $currency = "eur";
    $orderID = "SKA92712382139";
    
    //charge a credit or a debit card
    $charge = \Stripe\Charge::create(array(
        'customer' => $customer->id,
        'amount'   => $itemPrice,
        'currency' => $currency,
        'description' => $itemName,
        'metadata' => array(
            'order_id' => $orderID
        )
    ));
    
    //retrieve charge details
    $chargeJson = $charge->jsonSerialize();

    //check whether the charge is successful
    if($chargeJson['amount_refunded'] == 0 && empty($chargeJson ['failure_code']) && $chargeJson['paid'] == 1 && $chargeJson['captured'] == 1){
        //order details 
        $amount = $chargeJson['amount'];
        $balance_transaction = $chargeJson['balance_transaction'];
        $currency = $chargeJson['currency'];
        $status = $chargeJson['status'];
        $date = date("Y-m-d H:i:s");
        
        include'../config.php';

        //insert tansaction data into the database
        $sql = "INSERT INTO `payments`(`name`, `email`, `service_name`, `service_price`, `created`) VALUES ('".$name."','".$email."','".$itemName."', '".$price."' ,'".$date."')";
        $insert = $conn->query($sql);
        $last_insert_id = $conn->insert_id;
        
        //if order inserted successfully
        if($last_insert_id && $status == 'succeeded'){
            $order_id = $_POST['order_id'];
            header("Location: code_mail.php?order_id=$order_id");
        }else{
            $statusMsg = "Transaction has been failed";
        }
    }else{
        $statusMsg = "Transaction has been failed";
    }
}else{
    $statusMsg = "Form submission error.......";
}

echo $statusMsg;