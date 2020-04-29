<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <script src="https://js.stripe.com/v3/"></script>

        <!-- Styles -->
        <style>
            .StripeElement {
            box-sizing: border-box;
            
            height: 40px;
            
            padding: 10px 12px;
            
            border: 1px solid transparent;
            border-radius: 4px;
            background-color: white;
            
            box-shadow: 0 1px 3px 0 #e6ebf1;
            -webkit-transition: box-shadow 150ms ease;
            transition: box-shadow 150ms ease;
            }

            .StripeElement--focus {
            box-shadow: 0 1px 3px 0 #cfd7df;
            }

            .StripeElement--invalid {
            border-color: #fa755a;
            }

            .StripeElement--webkit-autofill {
            background-color: #fefde5 !important;
            }
        </style>
    </head>
    <body>
        
            
        <div>
            <form action="{{ url('charge') }}" method="post" id="payment-form">
                <div class="form-row">
                    <p><input type="text" name="amount" placeholder="Enter Amount" /></p>
                    <p><input type="email" name="email" placeholder="Enter Email" /></p>
                    <label for="card-element">
                    Credit or debit card
                    </label>
                    <div id="card-element">
                    <!-- A Stripe Element will be inserted here. -->
                    </div>
                
                    <!-- Used to display form errors. -->
                    <div id="card-errors" role="alert"></div>
                </div>
                <button>Submit Payment</button>
                {{ csrf_field() }}
            </form>
            <script>
                
            </script>
        
        </div>

    <script>
        (function(){
            console.log('{{ env('STRIPE_PUBLISHABLE_KEY') }}');
            const publishable_key = '{{ env('STRIPE_PUBLISHABLE_KEY') }}';
            // Create a Stripe client.
            let stripe = Stripe(publishable_key);
            
            // Create an instance of Elements.
            let elements = stripe.elements();
                
            // Custom styling can be passed to options when creating an Element.
            // (Note that this demo uses a wider set of styles than the guide below.)
            let style = {
                base: {
                    color: '#32325d',
                    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                    fontSmoothing: 'antialiased',
                    fontSize: '16px',
                    '::placeholder': {
                        color: '#aab7c4'
                    }
                },
                invalid: {
                    color: '#fa755a',
                    iconColor: '#fa755a'
                }
            };
                
            // Create an instance of the card Element.
            let card = elements.create('card', {style: style});
                
            // Add an instance of the card Element into the `card-element` <div>.
            card.mount('#card-element');
                
            // Handle real-time validation errors from the card Element.
            card.addEventListener('change', function(event) {
                var displayError = document.getElementById('card-errors');
                if (event.error) {
                    displayError.textContent = event.error.message;
                } else {
                    displayError.textContent = '';
                }
            });
                
            // Handle form submission.
            let form = document.getElementById('payment-form');
            form.addEventListener('submit', function(event) {
                event.preventDefault();
                
                stripe.createToken(card).then(function(result) {
                    if (result.error) {
                        // Inform the user if there was an error.
                        let errorElement = document.getElementById('card-errors');
                        errorElement.textContent = result.error.message;
                    } else {
                        // Send the token to your server.
                        stripeTokenHandler(result.token);
                    }
                });
            });
                
            // Submit the form with the token ID.
            function stripeTokenHandler(token) {
                // Insert the token ID into the form so it gets submitted to the server
                let form = document.getElementById('payment-form');
                let hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'stripeToken');
                hiddenInput.setAttribute('value', token.id);
                form.appendChild(hiddenInput);
                
                // Submit the form
                form.submit();
            }
        })();
    </script>

    </body>
</html>
