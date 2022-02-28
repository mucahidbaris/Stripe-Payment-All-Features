<?php
require_once 'config.php';

if(isset($_POST['submit'])){

    $ucret=htmlspecialchars(trim($_POST['ucret']));
    $phone=htmlspecialchars(trim($_POST['phone']));
    $_SESSION['phone']=str_replace('+','',$phone);
    $_SESSION['ucret']=$ucret;

    header("Location:pay.php");
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.15/css/intlTelInput.css"  />
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.15/js/intlTelInput.min.js" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.15/js/utils.min.js" ></script>
</head>
<body>
<!-- Display a payment fo rm -->

<form  method="post" action="">
    <div class="form-group ">
    <button class="btn btn-success" name="submit" value="submit" >
        <span id="button-text">İlerle ---></span>
    </button>
    </div>
        <div class="form-group ">
            <label for="phone1" data-validate = "Geçerli Telefon Numrası Giriniz." ><h6>Kayıtlı Telefon Numaranız    </h6></label>
            <input type="tel"  id="tel"  name="tel"  placeholder="532XXXXXXX" required class="form-control ">
            <label><h6>Ücret Giriniz..:</h6></label>
            <input type="number"  id="ucret"  name="ucret"  placeholder="Tutar" required class="form-control ">

        </div>

    <div  class="alert alert-primary" role="alert" >&ensp;Tutarı Lütfen eksiksiz giriniz. 20₺ için 20 yazmanız yeterlidir.

    </div>


    <div id="payment-message" class="hidden"></div>
</form>
</body>
<script>
    var input = document.querySelector("#tel");
    window.intlTelInput(input, {
        hiddenInput: "phone",
        initialCountry: 'TR',
        nationalMode: true,
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.15/js/utils.min.js" // just for formatting/placeholders etc
    });
</script>
</html>

