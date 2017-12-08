

<!DOCTYPE html>
<html >

    <head>
        <meta charset="UTF-8">
        <link rel="shortcut icon" type="image/x-icon" href="https://production-assets.codepen.io/assets/favicon/favicon-8ea04875e70c4b0bb41da869e81236e54394d63638a1ef12fa558a4a835f1164.ico" />
        <link rel="mask-icon" type="" href="https://production-assets.codepen.io/assets/favicon/logo-pin-f2d2b6d2c61838f7e76325261b7195c27224080bc099486ddd6dccb469b8e8e6.svg" color="#111" />
        <title>Paypal through braintree</title>


        <?php
        require_once('C:\xampp\htdocs/lib/Braintree.php');
        require_once('C:\xampp\htdocs/Credentials/credentials.php');

        $clientToken = Braintree_ClientToken::generate();
        
        if (!isset($_SERVER['HTTPS'])){
            header('Location: https://localhost');
            //echo "not secure";
        }else{
            //echo "secure";
        }
        ?>
        
 
		
				<!-- Load PayPal's checkout.js Library. -->
		<script src="https://www.paypalobjects.com/api/checkout.js" data-version-4 log-level="warn"></script>

		<!-- Load the client component. -->
		<script src="https://js.braintreegateway.com/web/3.15.0/js/client.min.js"></script>

		<!-- Load the PayPal Checkout component. -->
		<script src="https://js.braintreegateway.com/web/3.15.0/js/paypal-checkout.min.js"></script>

    </head>

    <body>

        <form  action="ProcessTransaction.php" id="submitForm" method="post" style="margin-left: 30px "><br>
            <label for='item'>Item:</label><br>
            <input id="item" type="text" name="item" value="Buying a new phone" /><br>
            <label for='amount'>Price:</label><br>
            <input id="amount" type="text" name="amount" value="100.00" /><br>
            <label for='fname'>Name:</label><br>
            <input id="firstName" type="text" name="firstName" value="Brian" /><br>
            <label for='lname'>Last Name:</label><br>
            <input id="lastName" type="text" name="lastName" value="Mc Manus" /><br>
            <label for='streetAddress'>Street:</label><br>
            <input id="streetAddress" type="text" name="streetAddress" value="21 fair view" /><br>
            <label for='locality'>Town:</label><br>
            <input id="locality" type="text" name="locality" value="Dundalk" /><br>
            <label for='postalCode'>Postcode:</label><br>
            <input id="postalCode" type="text" name="postalCode" value="ABC DE" /><br>
            <label for='region'>County:</label><br>
            <input id="region" type="text" name="region" value="Louth" /><br>
            <label for='country'>Country</label><br>
            <input id="country" type="text" name="country" value="Ireland" /><br>
            <label for='email'>Email</label><br>
            <input id="email" type="text" name="email" value="test@test.com" /><br>
            <label for='phone'>Phone</label><br>
            <input id="phone" type="text" name="phone" value="0857894512" /><br>
            <label for='website'>Site</label><br>
            <input id="website" type="text" name="website" value="www.example.com" /><br>
            <input type='hidden' id="nonce" name='nonce' value=''/>
            <br><br>

        </form>
		
		<div id="paypal-button"></div>
		
		<script>
					// Create a client.
		braintree.client.create({
		  authorization: '<?php echo $clientToken?>'
		}, function (clientErr, clientInstance) {

		  // Stop if there was a problem creating the client.
		  // This could happen if there is a network error or if the authorization
		  // is invalid.
		  if (clientErr) {
			console.error('Error creating client:', clientErr);
			return;
		  }

		  // Create a PayPal Checkout component.
		  braintree.paypalCheckout.create({
			client: clientInstance
		  }, function (paypalCheckoutErr, paypalCheckoutInstance) {

			// Stop if there was a problem creating PayPal Checkout.
			// This could happen if there was a network error or if it's incorrectly
			// configured.
			if (paypalCheckoutErr) {
			  console.error('Error creating PayPal Checkout:', paypalCheckoutErr);
			  return;
			}

			// Set up PayPal with the checkout.js library
			paypal.Button.render({
			  env: 'sandbox', // or 'sandbox'
			  
			  
			  commit: true,
			  style:
			  {
				  size: "medium",
				  color: "gold", //or blue
				  shape: "rect" // or pill
			  },
				  
			  
			  payment: function () {
        return paypalCheckoutInstance.createPayment({
          flow: 'checkout', // Required
          amount: document.getElementById("amount").value, // Required
          currency: 'GBP', // Required
          locale: 'en_GB',
          enableShippingAddress: true, // is shippable or not
          shippingAddressEditable: false,// Allows user to change address
          shippingAddressOverride: {
            recipientName: document.getElementById("firstName").value + " " + document.getElementById("lastName").value,
            line1: document.getElementById("streetAddress").value,
            city: document.getElementById("locality").value,
            countryCode: 'IE',
            postalCode: document.getElementById("postalCode").value,
            state: document.getElementById("region").value,
            phone: document.getElementById("phone").value
          }
        });
			  },

			  onAuthorize: function (data, actions) {
				return paypalCheckoutInstance.tokenizePayment(data)
				  .then(function (payload) {
					// Submit `payload.nonce` to your server.
				 
					document.getElementById("nonce").value = payload.nonce;
					document.getElementById("submitForm").submit();

				 });
			  },

			  onCancel: function (data) {
				console.log('checkout.js payment cancelled', JSON.stringify(data, 0, 2));
			  },

			  onError: function (err) {
				console.error('checkout.js error', err);
			  }
			}, '#paypal-button').then(function () {
			  // The PayPal button will be rendered in an html element with the id
			  // `paypal-button`. This function will be called when the PayPal button
			  // is set up and ready to be used.
			});

		  });

		});
		</script>
		

    </body>
</html>
