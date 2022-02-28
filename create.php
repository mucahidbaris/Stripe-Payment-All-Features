<?php
require_once "config.php";
header('Content-Type: application/json');
// This is your test secret API key.
\Stripe\Stripe::setApiKey(SKEY);
$sureay='now '.'+'.'1'.' months';
$productskuepoch=strtotime("$sureay");
$productsku= gmdate('Y-m-d H:i:s',$productskuepoch);
try {
    // retrieve JSON from POST body

    // Create a PaymentIntent with amount and currency
    //Type : to include card and customer attributes (:card_country:). Type :: to include custom metadata (::product_sku::).
    $paymentIntent = \Stripe\PaymentIntent::create([
        'amount' => intval($_SESSION['ucret'])*100,
        'currency' => 'try',
        'description' => 'phone:'.$_SESSION['phone'].'ucret:'.$_SESSION['ucret'],
          'metadata' => [
            'phone' => $_SESSION['phone'],
            'product' => $_SESSION['ucret'],
            'product_sku' => $productsku,
            'price' => $_SESSION['ucret'],
        ],
        'automatic_payment_methods' => [
            'enabled' => true,
        ],
    ]);

    $output = [
        'clientSecret' => $paymentIntent->client_secret,
    ];
    echo json_encode($output);
} catch (Error $e) {
    //http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>

