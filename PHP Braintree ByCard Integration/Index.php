<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="frame.css">
		<title>PayPal-Pay By Card</title>

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
		
	<script src="https://js.braintreegateway.com/web/3.15.0/js/client.min.js"></script>
    <script src="https://js.braintreegateway.com/web/3.15.0/js/hosted-fields.min.js"></script>
    

    </head>

    <body translate="no" >

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
		
		
		<div class="paymentFrame">  
		  <form action="ProcessTransaction.php" method="post" id="cardForm" >
			<label class="hosted-fields--label" for="card-number">Card Number</label>
			<div id="card-number" class="hosted-field"></div>

			<label class="hosted-fields--label" for="expiration-date">Expiration Date</label>
			<div id="expiration-date" class="hosted-field"></div>

			<label class="hosted-fields--label" for="cvv">CVV</label>
			<div id="cvv" class="hosted-field"></div>

			<div class="button-container">
			<input type="submit" class="button button--small button--green" value="Purchase" id="submit"/>
			</div>
		  </form>
		<div>
		
		<script>
		
      var form = document.querySelector('#cardForm');
      var submit = document.querySelector('input[type="submit"]');

      braintree.client.create({
        authorization: '<?php echo $clientToken ?>'
      }, function (clientErr, clientInstance) {
        if (clientErr) {
          console.error(clientErr);
          return;
        }

        // This example shows Hosted Fields, but you can also use this
        // client instance to create additional components here, such as
        // PayPal or Data Collector.

        braintree.hostedFields.create({
          client: clientInstance,
          styles: {
            'input': {
				'font-size': '16px',
				'font-family': 'courier, monospace',
				'font-weight': 'lighter',
				'color': '#ccc'
			  },
			  ':focus': {
				'color': 'black'
			  },
			  '.valid': {
				'color': '#8bdda8'
			  }
			},
          fields: {
            number: {
              selector: '#card-number',
              placeholder: '4111 1111 1111 1111'
            },
            cvv: {
              selector: '#cvv',
              placeholder: '123'
            },
            expirationDate: {
              selector: '#expiration-date',
              placeholder: '10/2019'
            }
          }
        }, function (hostedFieldsErr, hostedFieldsInstance) {
          if (hostedFieldsErr) {
            console.error(hostedFieldsErr);
            return;
          }

          submit.removeAttribute('disabled');

          form.addEventListener('submit', function (event) {
            event.preventDefault();

            hostedFieldsInstance.tokenize(function (tokenizeErr, payload) {
              if (tokenizeErr) {
                console.error(tokenizeErr);
                return;
              }

              // If this was a real integration, this is where you would
              // send the nonce to your server.
			  document.getElementById("nonce").value = payload.nonce;
			  document.getElementById("submitForm").submit();
              console.log('Got a nonce: ' + payload.nonce);
            });
          }, false);
        });
      });
    </script>

   
		
		</body>
		
</html>