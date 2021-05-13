<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

  require_once('init.php');

  $token  = $_POST['stripeToken'];
  $email  = $_POST['stripeEmail'];

  $customer = \Stripe\Customer::create([
      'email' => $email,
      'source'  => $token,
  ]);

  $charge = \Stripe\Charge::create([
      'customer' => $customer->id,
      'amount'   => 5000,
      'currency' => 'usd',
  ]);

  echo '<h1>Successfully charged $50.00!</h1>';
?>