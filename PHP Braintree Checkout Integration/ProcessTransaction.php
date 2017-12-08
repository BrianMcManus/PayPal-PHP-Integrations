<?php  
	require_once('C:\xampp\htdocs/lib/Braintree.php');
    require_once('C:\xampp\htdocs/Credentials/credentials.php');
	
	
	
	
	/**$result = Braintree_Transaction::sale([
    "amount" => $_POST['amount'],
    "paymentMethodNonce" => $_POST['nonce'],
    "orderId" => $_POST[''],
    "options" => [
      "paypal" => [
        "description" => $_POST["item"],
		  ],
		],
	]);
	if ($result->success) {
	  print_r("Success ID: " . $result->transaction->id);
	} else {
	  print_r("Error Message: " . $result->message);
	}**/

	//Can convert to JSON easily
	$options = Array(
        'paypal' => Array(
			"description" => $_POST['item'],
		)
    );
	
    $customerInformation = Array(
        'firstName' => $_POST['firstName'],
        'lastName' => $_POST['lastName'],
        //'company' => '',
        'email' =>$_POST['email'],
        'phone' => $_POST['phone'],
        //'fax' => '',
        //'website' =>$_POST['website']
    );
	
	$billingInfo = Array(
        'firstName' => $_POST['firstName'],
        'lastName' => $_POST['lastName'],
        'company' => 'Braintree',
        'streetAddress' => $_POST['streetAddress'],
        //'extendedAddress' => 'Suite 403',
        'locality' => $_POST['locality'],
        'region' => $_POST['region'],
        'postalCode' => $_POST['postalCode'],
        //'countryCodeAlpha2' => 'GB'
    );
	
    
    $transactionDetails = Array(
        'amount' => $_POST['amount'],
        'orderId' => '',
        //'merchantAccountId' => '',
        'paymentMethodNonce' => $_POST['nonce'],
        'customer' => $customerInformation,
        'billing' => $billingInfo,
        'shipping' => $billingInfo,
        'options' => $options     
    );   
	
    $result = Braintree_Transaction::sale($transactionDetails);

	 echo "<pre>";
 	 print_r($result);
 	 echo "</pre>";

?>