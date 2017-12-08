<?php  
	require_once('C:\xampp\htdocs/lib/Braintree.php');
    require_once('C:\xampp\htdocs/Credentials/credentials.php');
	
	$result = Braintree_Transaction::sale([
    "amount" => $_POST['amount'],
    "paymentMethodNonce" => $_POST['nonce'],
    "orderId" => ''
	]);
	if ($result->success) {
	  print_r("Success ID: " . $result->transaction->id);
	} else {
	  print_r("Error Message: " . $result->message);
	}
	
	
?>