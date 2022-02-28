<?php

require_once "config.php";

// This is your test secret API key.
\Stripe\Stripe::setApiKey(SKEY);

$intent=htmlspecialchars(trim($_GET['payment_intent']));
$intent = Stripe\PaymentIntent::retrieve($intent);

if(isset($intent) && $intent['status']=='succeeded') {
   //ödeme başarılı alanı
}

?>
Ödeme Başarılı!