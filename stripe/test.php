<html>
  <head>
    <title>Checkout</title>
  </head>
  <body>
    <form action="/create-checkout-session" method="POST">
      <button type="submit">Checkout</button>
    </form>
  </body>
</html>
<?php 

/*
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST ,OPTIONS, PUT');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
if(empty($data)){
    echo 'error';
    return;
}
if(empty($data['number']) || empty($data['exp_month']) || empty($data['exp_year']) || empty($data['cvc']) || empty($data['name']) || empty($data['email']) || empty($data['order_id']) || empty($data['price'])){
    echo 'missing params';
    return;
} */
$number = '4242424242424242';
$exp_month = '12';
$exp_year = '24';
$cvc = '123';
$name = 'moeed';
$email = 'junaidaliansaree@gmail.com';
$order_id = 1;
$price = 1000;




$payment_id = $statusMsg = ''; 
$ordStatus = 'error'; 
 
 
$itemName = "Demo Product"; 
$itemNumber = "PN12345"; 
$itemPrice = $price; 
$currency = "INR"; 
//live key for pousspouss

define('STRIPE_API_KEY', 'sk_test_51KApeoIUvv2CeKymzZ7gcHSPgrpn0FOyj0cVqj88CCzb732HEj3M6jZPKpFHNksGNl6LqufUlOqGDmGTsNlGkojS00hm4Po4qm'); 
define('STRIPE_PUBLISHABLE_KEY', 'pk_test_51KApeoIUvv2CeKym2gGNNM3DS5iS3U6aB0EbSbxaWNHbVnqHSsxOYVZ9pxPsEXRiofdzVoqaojOOcfEUFknUJU4000MFDb2dTd'); 

 // Include Stripe PHP library 
require_once 'stripe-php/init.php'; 
 error_reporting(-1);
//  echo phpinfo();
//  echo "here";
$stripe = new \Stripe\StripeClient('sk_test_51JGiMjSJDwx14nOSzChGOF6Bf0UqtjEVZG1whQppIm4eEcYpQV8MGpKRFw5kS9FhVB4Zw8H7TSvWTANoQhd3Bkd600SJ61abO9');
// echo "here2";
$stripe->accounts->create(['type' => 'express']);


$stripe = new \Stripe\StripeClient('sk_test_51JGiMjSJDwx14nOSzChGOF6Bf0UqtjEVZG1whQppIm4eEcYpQV8MGpKRFw5kS9FhVB4Zw8H7TSvWTANoQhd3Bkd600SJ61abO9');
echo "here3";
// ca_KqLhJdqarJ281LdEuJ5pX4ISpX6dGmnf

$account = $stripe->accounts->create(
  [
    'country' => 'IN',
    'type' => 'express',
    'capabilities' => [
      'card_payments' => ['requested' => true],
      'transfers' => ['requested' => true],
    ],
    'business_type' => 'individual',
    'business_profile' => ['url' => 'https://mjcoders.com'],
  ]
);
echo "herex";
try{
$res = $stripe->accountLinks->create(
  [
    'account' => 'acct_1KBOUiSGUcfozdtu',
    'refresh_url' => 'https://mjcoders.com',
    'return_url' => 'https://mjcoders.com',
    'type' => 'account_onboarding',
  ]
);

\Stripe\Stripe::setApiKey('sk_test_51JGiMjSJDwx14nOSzChGOF6Bf0UqtjEVZG1whQppIm4eEcYpQV8MGpKRFw5kS9FhVB4Zw8H7TSvWTANoQhd3Bkd600SJ61abO9');
 
$session = \Stripe\Checkout\Session::create([
  'line_items' => [[
    'price' => '1000',
    'quantity' => 1,
  ]],
  'mode' => 'payment',
  'success_url' => 'https://mjcoders.com',
  'cancel_url' => 'https://mjcoders.com',
  'payment_intent_data' => [
    'application_fee_amount' => 123,
    'transfer_data' => [
      'destination' => 'acct_1KBOUiSGUcfozdtu',
    ],
  ],
]);
echo "here5";
// echo $res;

print_r($session);
echo "here4";
}catch(Exception $e){
    print_r($res);
    echo $e->getMessage();
    
}
exit;

 
 
// Set API key 
\Stripe\Stripe::setApiKey(STRIPE_API_KEY); 

try { 
$token = \Stripe\Token::create(array(
    'card' => [
    'number' => $number,
    'exp_month' => $exp_month,
    'exp_year' => $exp_year,
    'cvc' => $cvc,
    ],
)); 
}catch(Exception $e) {  
    $api_error = $e->getMessage();  
} 

//print_r($token);
$tokenJson = $token->jsonSerialize(); 
if($tokenJson->id !=''){
    $token  = $tokenJson->id; 
    $name = $name; 
    $email = $email; 
    $order_id = $order_id; 
    
}
 // Add customer to stripe 
try {  
//  new \Stripe\Stripe::setApiKey();

// $session = \Stripe\Checkout\Session::create([
//   'line_items' => [[
//     'price' => '12',
//     'quantity' => 1,
//   ]],
//   'mode' => 'payment',
//   'success_url' => 'https://example.com/success',
//   'cancel_url' => 'https://example.com/failure',
//   'payment_intent_data' => [
//     'application_fee_amount' => 123,
//     'transfer_data' => [
//       'destination' => 'acct_1KBOUiSGUcfozdtu',
//     ],
//   ],
// ]);
// exit;
    $customer = \Stripe\Customer::create(array( 
        'name' => 'test',
        'description' => 'test description',
        'email' => $email, 
        'source'  => $token,
        "address" => ["city" => 'multan', "country" => 'Pakistan', "line1" => 'multan', "line2" => "", "postal_code" => '66000', "state" => 'Pakistan']
    )); 
    // $stripe = new \Stripe\StripeClient(STRIPE_API_KEY);
    // $stripe->accountLinks->create(
    //   [
    //     'account' => 'acct_1JGiMjSJDwx14nOS',
    //     'refresh_url' => 'https://mjcoders.com',
    //     'return_url' => 'https://mjcoders.com',
    //     'type' => 'account_onboarding',
    //   ]
    // );
}catch(Exception $e) {  
    $api_error = $e->getMessage();  
} 


 if(empty($api_error) && $customer){  
         
        // Convert price to cents 
        $itemPriceCents = ($itemPrice*100); 
         
         
         $application_fee = intval($itemPrice * 0.2);
        // Charge a credit or a debit card 
        try {  
            // print_r()/
            
            
            $charge = \Stripe\Charge::create(array( 
                'customer' => $customer->id, 
                'amount'   => '20000', 
                'currency' => $currency, 
                'description' => $itemName,
                'transfer_group' => 'ORDER11',
            )); 
            $transfer = \Stripe\Transfer::create([
              'amount' => 7000,
              'currency' => $currency,
              'destination' => 'acct_1KBOUiSGUcfozdtu',
              'transfer_group' => 'ORDER11',
            ]);
        }catch(Exception $e) {  
            $api_error = $e->getMessage();  
        } 
       
      
        if(empty($api_error) && $charge){ 
         
            // Retrieve charge details 
            $chargeJson = $charge->jsonSerialize(); 
         
            // Check whether the charge is successful 
            if($chargeJson['amount_refunded'] == 0 && empty($chargeJson['failure_code']) && $chargeJson['paid'] == 1 && $chargeJson['captured'] == 1){ 
                // Transaction details  
                $transactionID = $chargeJson['balance_transaction']; 
                $paidAmount = $chargeJson['amount']; 
                $paidAmount = ($paidAmount/100); 
                $paidCurrency = $chargeJson['currency']; 
                $payment_status = $chargeJson['status']; 
                 
                // Insert tansaction data into the database 
               
                 
                // If the order is successful 
                if($payment_status == 'succeeded'){ 
                   echo json_encode([
                       'message'=>'success'
                   ]);
                   // echo  'Your Payment has been Successful!';
                   // header('Location: http://admin.mapetiteblouse.net/#/stripe?id="'.$order_id.'"');
                }else{ 
                      echo json_encode([
                       'message'=>'Your Payment has Failed!'
                     ]);
                } 
            }else{ 
                 echo json_encode([
                       'message'=>'Transaction has been failed!'
                     ]);
            } 
        }else{ 
            echo json_encode([
                       'message'=>'Charge creation failed! '.$api_error.''
                     ]);
           
        } 
    }else{  
        echo json_encode([
                       'message'=>'Invalid card details'.$api_error.''
                     ]); 
    } 
exit;

?>
