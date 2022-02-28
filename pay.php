<?php
require_once 'config.php';
if(empty($_SESSION)){
    header("location:index.php");

}


?>
<!DOCTYPE html>
<html lang="tr">
  <head>
    <meta charset="utf-8" />
    <title><?=SITEADI?></title>
    <meta name="description" content="A demo of a payment on Stripe" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
      <link rel="stylesheet" href="stripe.css" />
      <link href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' rel='stylesheet'>
      <link href='https://use.fontawesome.com/releases/v5.8.1/css/all.css' rel='stylesheet'>
      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <script  src="https://js.stripe.com/v3/"></script>
  </head>
  <body>
    <!-- Display a payment fo rm -->
    <form id="payment-form">

      <div id="payment-element">
        <!--Stripe.js injects the Payment Element-->
      </div>
        <div class="form-group">
            <label for="phone"><h6>Telefon Numaranız:</h6></label>
            <input type="text"   value="<?= $_SESSION['phone']; ?>" disabled class="form-control ">
        </div>

      <button id="submit">
        <div class="spinner hidden" id="spinner"></div>
        <span id="button-text">₺<?=$_SESSION['ucret']?> Öde </span>
      </button>
      <div id="payment-message" class="hidden"></div>
    </form>
  </body>
<script>
    // This is your test publishable API key.
    const stripe = Stripe("<?=PKEY?>");

    // The items the customer wants to buy

    let elements;

    initialize();
    checkStatus();

    document
        .querySelector("#payment-form")
        .addEventListener("submit", handleSubmit);

    // Fetches a payment intent and captures the client secret
    async function initialize() {
        const { clientSecret } = await fetch("create.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
        }).then((r) => r.json());
        elements = stripe.elements({ clientSecret });


        const paymentElement = elements.create("payment");
        paymentElement.mount("#payment-element");
    }

    async function handleSubmit(e) {
        e.preventDefault();
        setLoading(true);

        const { error } = await stripe.confirmPayment({
            elements,
            confirmParams: {
                // Make sure to change this to your payment completion page

                return_url: "success.php",
            },
        });

        // This point  will only be reached if there is an immediate error when
        // confirming the payment. Otherwise, your customer will be redirected to
        // your `return_url`. For some payment methods like iDEAL, your customer will
        // be redirected to an intermediate site first to authorize the payment, then
        // redirected to the `return_url`.
        if (error.type === "card_error" || error.type === "validation_error") {
            showMessage(error.message);
        } else {
            showMessage("Sistemsel Hata");
            alert("sistemsel hata sayfayı yenileyiniz.");
        }

        setLoading(false);
    }

    // Fetches the payment intent status after payment submission
    async function checkStatus() {
        const clientSecret = new URLSearchParams(window.location.search).get(
            "payment_intent_client_secret"
        );

        if (!clientSecret) {
            return;
        }

        const { paymentIntent } = await stripe.retrievePaymentIntent(clientSecret);

        switch (paymentIntent.status) {
            case "succeeded":
                showMessage("Ödeme Başarılı :) ");
                break;
            case "processing":
                showMessage("Ödeme alınıyor. :|");
                break;
            case "requires_payment_method":
                showMessage("Ödeme Yapılamadı Lütfen Bildiriniz. :[");
                break;
            default:
                showMessage("Hay Aksi! Birşeyler ters gitti :(");
                break;
        }
    }

    // ------- UI helpers -------

    function showMessage(messageText) {
        const messageContainer = document.querySelector("#payment-message");

        messageContainer.classList.remove("hidden");
        messageContainer.textContent = messageText;

        setTimeout(function () {
            messageContainer.classList.add("hidden");
            messageText.textContent = "";
        }, 4000);
    }

    // Show a spinner on payment submission
    function setLoading(isLoading) {
        if (isLoading) {
            // Disable the button and show a spinner
            document.querySelector("#submit").disabled = true;
            document.querySelector("#spinner").classList.remove("hidden");
            document.querySelector("#button-text").classList.add("hidden");
        } else {
            document.querySelector("#submit").disabled = false;
            document.querySelector("#spinner").classList.add("hidden");
            document.querySelector("#button-text").classList.remove("hidden");
        }
    }
</script>
</html>