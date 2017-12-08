<!DOCTYPE html>

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <script src="https://www.paypalobjects.com/api/checkout.js"></script>
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
            <br><br>

        </form>
		



<div id="paypal-button"></div>

<script>


	var item_price = parseFloat(document.getElementById('amount').value);
	var subtotal = item_price * .8;
	var tax = item_price * .2;
	var shipping = 15;
	var handling_fee = 5;
	var insurance = 2;
	var total = subtotal + tax + shipping + handling_fee + insurance;

	
    paypal.Button.render({
			    
			    	env: 'sandbox', 		// environment 'sandbox' | 'production'

			        locale: 'en_GB',  //merchant locality

			        style: {
			            size: 'responsive', //large, medium, small
			            color: 'gold', //blue
			            shape: 'pill' //rect
			        },

			        client: {
				        sandbox: 'ASrRgj0H6KLBA3EvBB3byg01t2g3AgD7IbLuK4x3fj4XVkgnU99DSABBPPiPe2GH_R2ob6jW_82nneRl',//'AVHL1n6-BfmU0ynVHi9d4bOz3MAqbruDhG0puj92vDUaZ-KtPiiaE_HgjBYEF7wOY-d_euaZMxTS53Jf', //'Your SANDBOX clientID here',

				        //production: 'Your LIVE clientID here'
			        },

        commit: true, // Show a 'Pay Now' button

        payment: function() {
			
			var env = this.props.env;
			var client = this.props.client;
			
            return paypal.rest.payment.create(env, client, {
                transactions: [
                    {
                        amount: 
						{ 
							total: total, 
							currency: 'GBP',
							details: 
							{
									subtotal: subtotal,
									tax: tax,
									shipping: shipping,
									handling_fee: handling_fee,
									insurance: insurance
							}
						},
						item_list:
						{
							items: 
							[
								{
								  name: document.getElementById('firstName').value + ' '  + document.getElementById('lastName').value,
								  description: document.getElementById('item').value,
								  quantity: 1,
								  price: item_price - tax,
								  tax: tax,
								  sku: 1,
								  currency: 'GBP' 
								}
							],
							shipping_address:
							{
							  recipient_name: document.getElementById('firstName').value + ' '  + document.getElementById('lastName').value,
							  line1: document.getElementById('streetAddress').value,
							  line2: '',
							  city: document.getElementById('locality').value,
							  country_code: 'IE',
							  postal_code: document.getElementById('postalCode').value,
							  phone: document.getElementById('phone').value,
							  state: document.getElementById('region').value
							}
						}
					}
					
                ]
            });
        },

        onAuthorize: function(data, actions) {
            return actions.payment.execute().then(function(payment) {
				var output ='';
				
				for(var k in data)
				{
					output += 'name: ' + k + ' data: ' + data[k] + '\n';
				}
				
				alert("Payment Successful\n\n" + output);
                // The payment is complete!
                // You can now show a confirmation message to the customer
            });
        }

    }, '#paypal-button');
</script>